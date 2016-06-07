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
	 * 从数据库中提取time时间后的各种数据
	 * @param  integer $time 提取数据的时间点
	 * @return [array]
	 */
	function get_all_msg($time = 0)
	{
		$this->_create_live_view();
		$this->_create_live_private_view();
		$tb_member_in_room = $this->ci->db->dbprefix('member_in_room');
		$live_msg_view = $this->ci->db->dbprefix('live_today');
		$view_live_private = $this->ci->db->dbprefix('live_private_today');
		$tb_member = $this->ci->db->dbprefix('member');
		$result = array('live_data' => array(), 'live_del_data' => array(), 'member_data' => array(), 'private_data' => array() );
		$time = date("Y-m-d H:i:s", $time);

		/*取得聊天室公共发信区更新的数据*/
		if( $this->ci->db->query("select 1 from {$live_msg_view} where time > '{$time}' limit 1")->num_rows() > 0 )
		{
			$message_list = $this->ci->db->query("select * from {$live_msg_view} where time > '{$time}' order by is_top desc,time")->result_array();
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

			if( ! empty($result['live_data']) )
			{
				$query = $this->ci->db->select('id,name')->from('live_category')->get()->result_array();
	 			$category = array();
	 			foreach($query as $v)
	 			{
	 				$category[$v['id']] = $v;
	 			}
	 			foreach($result['live_data'] as &$v)
	 			{
	 				$v['lid'] = explode(',', $v['lid']);
	 				$v['live'] = array();
					foreach($v['lid'] as $lv)
					{
						$v['live'][] = array('name' => $category[$lv]['name'], 'lid' => $lv);
					}
	 			}
			}
		}

		/*取得会员进入聊天室页面的数据*/
		if( $this->ci->db->query("select 1 from {$tb_member_in_room} where update_time > '{$time}' limit 1")->num_rows() > 0 )
		{
			$sql = "select i.mid,i.in_room,m.nick from {$tb_member_in_room} as i inner join {$tb_member} as m on m.id=i.mid where ";
			if($time == '1970-01-01 01:00:00')
			{
				$sql .= " i.in_room = 1";
			}
			else
			{
				$sql .= " i.update_time > '{$time}'";
			}
			$result['member_data'] = $this->ci->db->query($sql)->result_array();
		}

		/*取得私聊数据*/
		if( $this->ci->db->query("select 1 from {$view_live_private} where time > '{$time}' limit 1")->num_rows() > 0 )
		{
			$sql = "select p.mid,p.is_admin,p.content,p.time,m.nick from {$view_live_private} as p left join {$tb_member} as m on p.mid=m.id where p.time > '{$time}'";
			$result['private_data'] = $this->ci->db->query($sql)->result_array();
		}

		return $result;
	}

	/**
	 * 发送信息
	 * @param  [array] $param 包含消息的所有数据
	 * @return [void]
	 */
	function send_msg($param)
	{
		$param['time'] = date("Y-m-d H:i:s");
		$this->ci->db->insert('live', $param);
	}

	/**
	 * 发送私聊信息
	 */
	function send_private_msg($param)
	{
		$param['time'] = date("Y-m-d H:i:s");
		$param['is_admin'] = 1;
		$this->ci->db->insert('live_private', $param);
	}

	/**
	 * 删除消息，实际就是改变del标识及更新该数据时间
	 * @param  [int] $id 该消息在数据库中的记录id
	 * @return [void]
	 */
	function del_msg($id)
	{
		$time = date("Y-m-d H:i:s");
		$this->ci->db->update('live', array('time' => $time, 'del' => 1), array('id' => $id));
	}

}