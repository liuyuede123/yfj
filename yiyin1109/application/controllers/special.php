<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class special extends MY_Controller {

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
		$this->special_list();
	}

	function special_list()
	{
		$this->out_data['con_page'] = 'special_list';
		$this->load->model('md_special');
		$this->out_data['special_list'] = $this->md_special->get_special_list();
		$this->load->view('default', $this->out_data);
	}

	function edit_special($special_id = 0)
	{
		$special_id = (int)$special_id;

		$this->load->model('md_special');
		$special_info = $this->md_special->get_special($special_id);

		$this->out_data['special_info'] = $special_info;
		$this->out_data['con_page'] = 'edit_special';
		$this->load->view('default', $this->out_data);
	}
}