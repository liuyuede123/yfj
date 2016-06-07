<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	/**
	 * this is the base controller
	 * all the controller must extends base controller explect login
	 */
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Chongqing');
		self::check_login();
	}

	private function check_login()
	{
		$admin_login = $this->session->userdata('admin_login');
		if(!$admin_login)
		{
			header("Location:".base_url()."login");
		}
	}

	/*检查管理员权限*/
	protected function check_permission($permission = '')
	{
		if($this->session->userdata('role') == 'admin') return true;

		if($permission == '') header("Location:".base_url()."login");

		$admin_allow = explode(',', $this->session->userdata('permission') );
		if( in_array($permission, $admin_allow) ) return true;
		else header("Location:".base_url()."login");
	}

	protected function get_site_url()
	{
		$admin_url = base_url();
		$pos = strripos($admin_url, '/',-2);
		return substr($admin_url, 0, $pos).'/';
	}

	protected function get_category($catedb='category')
	{
		return $this->md_base->get_category($catedb);
	}

	protected function is_post()
	{
		return $_SERVER['REQUEST_METHOD' ] === 'POST' ? true : false;
	}

	protected function get_pagin($base_url, $total_rows, $limit = 10, $uri_segment = 3)
	{
		$this->load->library('pagination');
		$config['base_url'] = $base_url;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$config['use_page_numbers'] = TRUE;

		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a><strong>';
		$config['cur_tag_close'] = '</strong></a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config); 

		return $this->pagination->create_links();
	}
	
	//积分分页
	protected function get_integral_pagin($base_url, $total_rows, $limit = 10, $uri_segment = 3,$page_query_string = false)
	{
		$this->load->library('pagination');
		$config['base_url'] = $base_url;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$config['use_page_numbers'] = TRUE;
		$config['page_query_string'] = $page_query_string;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a><strong>';
		$config['cur_tag_close'] = '</strong></a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config); 

		return $this->pagination->create_links();
	}
}