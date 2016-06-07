<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class website extends MY_Controller {

	private $out_data;
	function __construct()
	{
		parent::__construct();
		$this->out_data['site_url'] = parent::get_site_url();
		$this->out_data['cate_list'] = parent::get_category();
	}

	public function index()
	{
		$this->config_list();
	}

	function config_list()
	{
		$this->out_data['con_page'] = 'config_list';
		$this->out_data['config_list'] = $this->db->query("select id,name,attr,value from {$this->db->dbprefix('config')} order by id")->result_array();
		$this->load->view('default', $this->out_data);
	}

	function add_config()
	{
		$this->out_data['con_page'] = 'add_config';
		$this->load->view('default', $this->out_data);
	}

	function add_config_action()
	{
		$info = array('name' => $this->input->post('name'),
		'attr' => 'config_'.$this->input->post('attr'),
		'value' => $this->input->post('value'));
		$result = array('status' => false, 'msg' => '');
		$is_exist = $this->db->query("select id from {$this->db->dbprefix('config')} where attr='".$info['attr']."'")->num_rows();
		if($is_exist > 0)
		{
			$result['msg'] = '属性名已存在，请重新输入';
		}
		else
		{
			$this->db->insert('config', $info);
			$result['status'] = true;
		}
		echo json_encode($result);
	}

	function save_config()
	{
		$value = $this->input->post('value');
		$id = $this->input->post('id');
		if(count($id) == 0) exit;

		$update_array = array();
		foreach($id as $k => $v)
		{
			$update_array[] = "({$v},'".$value[$k]."')";
		}
		$update = join(',', $update_array);
		$this->db->query("INSERT INTO {$this->db->dbprefix('config')} (id,value) VALUES {$update} ON DUPLICATE KEY UPDATE value=values(value)");
	}

	function del_config()
	{
		$id = (int)$this->input->post(id);
		$this->db->simple_query("delete from {$this->db->dbprefix('config')} where id={$id}");
	}
}