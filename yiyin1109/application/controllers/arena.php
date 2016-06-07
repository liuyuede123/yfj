<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class arena extends MY_Controller {

	private $out_data;
	function __construct()
	{
		parent::__construct();
		parent::check_permission('base');
		$this->out_data['site_url'] = parent::get_site_url();
		$this->out_data['cate_list'] = parent::get_category();
	}

	public function index()
	{
		$this->out_data['con_page'] = 'arena';
		$this->out_data['arena_list'] = $this->db->select('id,name,account,rate')->from('arena')->order_by('id')->get()->result_array();
		$this->load->view('default', $this->out_data);
	}

	function edit_record($id = 0)
	{
		$id = (int)$id;

		$this->out_data['info'] = $this->db->from('arena')->where(array('id' => $id))->limit(1)->get()->row_array();
		$this->out_data['con_page'] = 'arena_edit';
		$this->load->view('default', $this->out_data);
	}

	function save_record()
	{
		$info = array(
		'name' => $this->input->post('name'),
		'account' => $this->input->post('account'),
		'rate' => $this->input->post('rate'));
		$id = (int)$this->input->post('id');
		if($id === 0)
		{
			$this->db->insert('arena', $info);
			$id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('id', $id);
			$this->db->update('arena', $info);
		}
	}
}