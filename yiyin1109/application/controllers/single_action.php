<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class single_action extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		parent::check_permission('base');
		if(!parent::is_post()) show_404();
	}

	function del_page()
	{
		$id = (int)$this->input->post('id');
		$this->load->model('md_single');
		$this->md_single->del_page($id);
	}

	function save_page()
	{
		$this->db->cache_delete_all();
		$info = array(
		'title' => $this->input->post('title'),
		'ename' => $this->input->post('ename'),
		'content' => $this->input->post('content'),
		'description' => $this->input->post('description'),
		'site_keywords' => $this->input->post('site_keywords'),
		'site_description' => $this->input->post('site_description'),
		'tpl' => $this->input->post('tpl'),
		'url' => $this->input->post('url'));
		$id = (int)$this->input->post('id');
		$this->load->model('md_single');
		echo json_encode($this->md_single->save_page($id, $info));
	}
}