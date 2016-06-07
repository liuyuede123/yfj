<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class single extends MY_Controller {

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
		$this->page_list();
	}

	function page_list()
	{
		$this->out_data['con_page'] = 'page_list';
		$this->load->model('md_single');
		$this->out_data['page_list'] = $this->md_single->get_page_list();
		$this->load->view('default', $this->out_data);
	}

	function edit_page($page_id = 0)
	{
		$page_id = (int)$page_id;

		$this->load->model('md_single');
		$page_info = $this->md_single->get_page($page_id);

		$this->out_data['page_info'] = $page_info;
		$this->out_data['con_page'] = 'edit_page';
		$this->load->view('default', $this->out_data);
	}
}