<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class wellcome extends MY_Controller {

	private $out_data;
	function __construct()
	{
		parent::__construct();
		$this->out_data['site_url'] = parent::get_site_url();
		$this->out_data['cate_list'] = parent::get_category();
	}

	public function index()
	{
		$this->out_data['con_page'] = 'wellcome';
		$this->load->view('default', $this->out_data);
	}
}