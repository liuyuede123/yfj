<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class banner extends MY_Controller {

	private $out_data;
	function __construct()
	{
		parent::__construct();
		$this->out_data['site_url'] = parent::get_site_url();
		$this->out_data['cate_list'] = parent::get_category();
	}

	public function index()
	{
		$this->banner_list();
	}

	function banner_list()
	{
		$this->out_data['con_page'] = 'banner_list';
		$this->load->model('md_banner');
		$this->out_data['banner_list'] = $this->md_banner->get_banner_list();
		$this->load->view('default', $this->out_data);
	}

	function del_banner()
	{
		if(!parent::is_post()) show_404();
		$id = (int)$this->input->post('id');
		$this->load->model('md_banner');
		$this->md_banner->del_banner($id);
	}

	function edit_banner($banner_id = 0)
	{
		$banner_id = (int)$banner_id;

		$this->load->model('md_banner');
		$banner_info = $this->md_banner->get_banner($banner_id);

		$this->out_data['banner_info'] = $banner_info;
		$this->out_data['con_page'] = 'edit_banner';
		$this->load->view('default', $this->out_data);
	}

	function save_banner()
	{
		if(!parent::is_post()) show_404();
		$info = array(
		'title' => $this->input->post('title'),
		'url' => $this->input->post('url'),
		'sort' => (int)$this->input->post('sort'),
		'img' => $this->input->post('img'));
		$id = (int)$this->input->post('id');
		$this->load->model('md_banner');
		echo $this->md_banner->save_banner($id, $info);
	}
}