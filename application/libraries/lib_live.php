<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class lib_live {

	private $ci;
	public function __construct()
	{
		date_default_timezone_set('Asia/Chongqing');
		$this->ci = & get_instance();
	}

	/**
	 * 生成live当天信息的视图
	 * @return  void
	 */
	private function _create_live_view()
	{
		$live_msg_view = $this->ci->db->dbprefix('live_today');
		if( ! $this->ci->db->table_exists($live_msg_view) )
		{
			$this->ci->db->simple_query("create view {$live_msg_view} as select * from {$this->ci->db->dbprefix('live')} where date_format(time, '%Y%m%d') = date_format(now(), '%Y%m%d')");
		}
	}

	/**
	 * 生成私聊当天信息的视图
	 */
	private function _create_live_private_view()
	{
		$table = $this->ci->db->dbprefix('live_private_today');
		if( ! $this->ci->db->table_exists($table) )
		{
			$this->ci->db->simple_query("create view {$table} as select * from {$this->ci->db->dbprefix('live_private')} where date_format(time, '%Y%m%d') = date_format(now(), '%Y%m%d')");
		}
	}

	/**
	 * 设置会员是否在直播室的状态
	 */
	function set_member_room_status($mid, $status = 0)
	{
		$time = date("Y-m-d H:i:s");
		$tb_member_in_room = $this->ci->db->dbprefix('member_in_room');
		$mid = (int)$mid;
		$result = $this->ci->db->query("select in_room from {$tb_member_in_room} where mid={$mid} limit 1");
		if( $result->num_rows() > 0 )
		{
			if($result->row()->in_room != $status)
			{
				$this->ci->db->query("update {$tb_member_in_room} set in_room={$status}, update_time='{$time}' where mid={$mid} limit 1");
			}
		}
		else if($status == 1)
		{
			$this->ci->db->insert($tb_member_in_room, array('in_room' => $status, 'update_time' => $time, 'mid' => $mid));
		}
	}

	/**
	 * 从数据库中提取time时间后的各种数据
	 * @param  integer $time 提取数据的时间点
	 * @param  integer $lid 直播室id
	 * @return [array]
	 */
	function get_all_msg($lid, $time = 0)
	{
		$this->_create_live_view();
		$this->_create_live_private_view();

		$live_msg_view = $this->ci->db->dbprefix('live_today');
		$view_live_private = $this->ci->db->dbprefix('live_private_today');
		$tb_member = $this->ci->db->dbprefix('member');

		$result = array('live_data' => array(), 'live_del_data' => array(), 'private_data' => array() );
		$time = date("Y-m-d H:i:s", $time);
		
		/*取得聊天室公共发信区更新的数据*/
		if( $this->ci->db->query("select 1 from {$live_msg_view} where time > '{$time}' limit 1")->num_rows() > 0 )
		{
			$message_list = $this->ci->db->query("select * from {$live_msg_view} where time > '{$time}' AND find_in_set({$lid}, lid) order by is_top,time")->result_array();
			if(count($message_list) > 0)
			{
				foreach($message_list as $v)
				{
					/*有两种，一种是新添加的信息，一种是新删除的信息，分开显示*/
					if($v['del'] == 0)
					{
						$result['live_data'][] = $v;
					}
					else
					{
						$result['live_del_data'][] = $v['id'];
					}
				}
			}
		}

		/*取得私聊数据*/
		$mid = $this->ci->session->userdata('id');
		if( $this->ci->db->query("select 1 from {$view_live_private} where time > '{$time}' and mid={$mid} limit 1")->num_rows() > 0 )
		{
			$sql = "select is_admin,content,time from {$view_live_private} where time > '{$time}' and mid={$mid}";
			$result['private_data'] = $this->ci->db->query($sql)->result_array();
		}

		return $result;
	}

	/**
	 * 发送私聊信息
	 */
	function send_private_msg($content)
	{
		$param = array();
		$param['time'] = date("Y-m-d H:i:s");
		$param['is_admin'] = 0;
		$param['mid'] = $this->ci->session->userdata('id');
		$param['content'] = $content;
		$this->ci->db->insert('live_private', $param);
	}

}