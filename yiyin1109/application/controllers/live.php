<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class live extends MY_Controller {

	private $out_data;
	function __construct()
	{
		parent::__construct();
		parent::check_permission('live');
	}

	public function index()
	{
		$this->out_data['site_url'] = parent::get_site_url();
		$this->out_data['cate_list'] = parent::get_category();
		$this->out_data['live_category'] = $this->db->select('id,name')->from('live_category')->order_by('sort')->get()->result_array();
		$this->out_data['con_page'] = 'live';
		$this->load->view('default', $this->out_data);
	}

	function room_list()
	{
		$this->out_data['site_url'] = parent::get_site_url();
		$this->out_data['cate_list'] = parent::get_category();
		// $this->out_data['room_list'] = $this->db->select('id,name')->from('live_category')->order_by('sort')->get()->result_array();
		$this->out_data['room_list'] = $this->db->query("select l.id,l.name,a.nick from {$this->db->dbprefix('live_category')} as l left join {$this->db->dbprefix('admin')} as a on a.id=l.aid order by sort")->result_array();
		$this->out_data['con_page'] = 'live_room_list';
		$this->load->view('default', $this->out_data);
	}

	function del_room()
	{
		$id = (int)$this->input->post('id');
		$this->db->delete('live_category', array('id' => $id));
	}

	function edit_room($id = 0)
	{
		$id = (int)$id;
		$query = $this->db->from('live_category')->where( array('id' => $id) )->get();
		if($query->num_rows() > 0)
		{
			$this->out_data['info'] = $query->row_array();
		}
		else
		{
			foreach($query->list_fields() as $v)
			{
				$this->out_data['info']["{$v}"] = '';
			}
			$this->out_data['info']['id'] = 0;
		}
		$this->out_data['admin_list'] = $this->db->query("select id,nick from {$this->db->dbprefix('admin')} where find_in_set('live', permission) OR role='admin'")->result_array();
		$this->out_data['con_page'] = 'live_room_edit';
		$this->load->view('default', $this->out_data);
	}

	function save_room()
	{
		$info = array( 'name' => $this->input->post('name'),
		'subject' => $this->input->post('subject'),
		'point' => $this->input->post('point'),
		'tech' => $this->input->post('tech'),
		'sort' => $this->input->post('sort'),
		'intro' => $this->input->post('intro'),
		'aid' => $this->input->post('aid')
		 );
		$id = $this->input->post('id');
		if($id == 0)
		{
			$this->db->insert('live_category', $info);
		}
		else
		{
			$this->db->update('live_category', $info, array('id' => $id) );
		}
	}

	function get_all_msg()
	{
		set_time_limit(30);
		header("Connection: Keep-Alive");
		header("Proxy-Connection: Keep-Alive");
		date_default_timezone_set('Asia/Chongqing');

		$this->load->library('lib_live');
		$time = $this->input->post('time');
		if( ! $time) $time = 0;
		while(1)
		{
			$result = $this->lib_live->get_all_msg($time);
			if( ( ! empty($result['live_data']) ) OR ( ! empty($result['live_del_data']) ) OR ( ! empty($result['member_data'])) OR ( ! empty($result['private_data'])) )
			{
				$result['time'] = time();
	 			echo json_encode($result);
	 			ob_flush();
				flush();
				break;
			}
			sleep(3);
			clearstatcache();
		}
	}

	function send_msg()
	{
		$content = $this->input->post('content');
		$lid = join(',', $this->input->post('lid') );
		$this->load->library('lib_live');
		$this->lib_live->send_msg( array('content' => $content, 'lid' => $lid, 'name' => $this->session->userdata('nick') ) );
	}

	function set_top()
	{
		$id = $this->input->post('id');
		$this->db->update('live', array('is_top' => 1), array('id' => $id));
	}

	function cancel_top()
	{
		$id = $this->input->post('id');
		$this->db->update('live', array('is_top' => 0), array('id' => $id));
	}

	function del_msg()
	{
		$id = $this->input->post('id');
		$this->load->library('lib_live');
		$this->lib_live->del_msg($id);
	}

	function get_member_in_room()
	{
		set_time_limit(30);
		header("Connection: Keep-Alive");
		header("Proxy-Connection: Keep-Alive");

		$this->load->library('lib_live');
		$time = $this->input->post('time');
		if( ! $time) $time = 0;
		while(1)
		{
			$result = $this->lib_live->get_member_in_room($time);
			if( ( ! empty($result['data']) ) OR ( ! empty($result['del_data']) ) )
			{
				if( ! empty($result['data']) )
				{
					$query = $this->db->select('id,name')->from('live_category')->get()->result_array();
		 			$category = array();
		 			foreach($query as $v)
		 			{
		 				$category[$v['id']] = $v;
		 			}
		 			foreach($result['data'] as &$v)
		 			{
		 				$v['lid'] = explode(',', $v['lid']);
		 				$v['live'] = array();
						foreach($v['lid'] as $lv)
						{
							$v['live'][] = array('name' => $category[$lv]['name'], 'lid' => $lv);
						}
		 			}
				}
	 			echo json_encode($result);
	 			ob_flush();
				flush();
				break;
			}
			sleep(1);
			clearstatcache();
		}
	}

	function send_private_msg()
	{
		$content = $this->input->post('content');
		$mid = $this->input->post('mid');
		$this->load->library('lib_live');
		$this->lib_live->send_private_msg(array('content' => $content, 'mid' => $mid));
	}

	function upload_img()
	{
		header("Content-Type: text/html; charset=utf-8");
		date_default_timezone_set("Asia/chongqing");
		error_reporting(E_ERROR | E_WARNING);

		$title = htmlspecialchars($_POST['pictitle'], ENT_QUOTES);
		$path = htmlspecialchars($_POST['dir'], ENT_QUOTES);
		//上传配置
		$config = array(
			"savePath" => '../'.$path.'/',
			"maxSize" => 1000, //单位KB
			"allowFiles" => array(".gif", ".png", ".jpg", ".jpeg", ".bmp"),
			"fileNameFormat" => $_POST['fileNameFormat']
		);
		include("ueditor.class.php");
		$up = new Uploader("upfile", $config);
		$info = $up->getFileInfo();
		echo "{'url':'" . str_replace('../', '', $info["url"]) . "','title':'" . $title . "','original':'" . $info["originalName"] . "','state':'" . $info["state"] . "'}";
	}
}