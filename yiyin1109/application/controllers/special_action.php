<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class special_action extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		parent::check_permission('base');
		if(!parent::is_post()) show_404();
	}

	function del_special()
	{
		$id = (int)$this->input->post('id');
		$this->load->model('md_special');
		$this->md_special->del_special($id);
	}

	function save_special()
	{
		$info = array(
		'title' => $this->input->post('title'),
		'is_show' => $this->input->post('is_show'),
		'img' => $this->input->post('img'),
		'intro' => $this->input->post('intro'),
		'url' => $this->input->post('url'));
		$id = (int)$this->input->post('id');
		$this->load->model('md_special');
		echo json_encode($this->md_special->save_special($id, $info));
	}
}