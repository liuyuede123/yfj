<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class soft extends MY_Controller {

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
		$this->soft_list();
	}

	function soft_list()
	{
		$this->load->model('md_soft');
		$this->out_data['con_page'] = 'soft_list';
		$this->out_data['soft_list'] = $this->md_soft->get_soft_list();
		$this->load->view('default', $this->out_data);
	}

	function del_soft()
	{
		if(!parent::is_post()) show_404();
		$id = (int)$this->input->post('id');
		$this->load->model('md_soft');
		$this->md_soft->del_soft($id);
	}

	function edit_soft($soft_id = 0)
	{
		$soft_id = (int)$soft_id;

		$this->load->model('md_soft');
		$soft_info = $this->md_soft->get_soft($soft_id);

		$this->out_data['soft_info'] = $soft_info;
		$this->out_data['con_page'] = 'edit_soft';
		$this->load->view('default', $this->out_data);
	}

	function save_soft()
	{
		if(!parent::is_post()) show_404();
		$info = array(
		'title' => $this->input->post('title'),
		'img' => $this->input->post('img'),
		'soft' => $this->input->post('soft'),
		'content' => $this->input->post('content'));
		$id = (int)$this->input->post('id');
		$this->load->model('md_soft');
		echo $this->md_soft->save_soft($id, $info);
	}
}