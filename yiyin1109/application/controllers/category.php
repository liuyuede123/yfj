<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class category extends MY_Controller {

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
		$this->manage_cate();
	}

	function manage_cate()
	{
		$this->out_data['con_page'] = 'category_list';
		$this->load->view('default', $this->out_data);
	}
	
	function manage_parentcate()
	{
		$this->out_data['parentcate_list'] = parent::get_category('parentcate');
		$this->out_data['con_page'] = 'parentcate_list';
		$this->load->view('default', $this->out_data);
	}

	function edit_cate($cate_id = 0)
	{
		$cate_id = (int)$cate_id;
		$this->out_data['cate_info'] = array('id' => 0);
		if($cate_id !== 0)
		{
			$this->load->model('md_category');
			$this->out_data['cate_info'] = $this->md_category->get_category($cate_id);
		}
		$this->out_data['con_page'] = 'edit_cate';
		$this->load->view('default', $this->out_data);
	}

	function edit_album($cate_id = 0)
	{
		$cate_id = (int)$cate_id;
		if($cate_id === 0)
		{
			show_404();
			exit();
		}
		else
		{
			$this->load->model('md_category');
			$this->out_data['album_list'] = $this->md_category->get_album_list($cate_id);
			$this->out_data['cate_info'] = $this->md_category->get_category($cate_id);
			$this->out_data['con_page'] = 'edit_album';
			$this->load->view('default', $this->out_data);
		}
	}
	
	function edit_art_album($art_id = 0)
	{
		$art_id = (int)$art_id;
		if($art_id === 0)
		{
			show_404();
			exit();
		}
		else
		{
			$this->load->model('md_category');
			$this->out_data['art_list'] = $this->md_category->get_art_album_list($art_id);
			$this->out_data['art_info'] = $this->md_category->get_article($art_id);
			$this->out_data['con_page'] = 'edit_art_album';
			$this->load->view('default', $this->out_data);
		}
	}

	function article_list($cate_id = 0, $page = 1)
	{
		$cate_id = (int)$cate_id;
		if($cate_id === 0)
		{
			show_404();
			exit;
		}

		$this->load->model('md_category');
		$this->out_data['cate_info'] = $this->md_category->get_category($cate_id);
		if($this->out_data['cate_info']['id'] === 0)
		{
			show_404();
			exit;
		}

		$page = (int)$page;
		$limit = 10;
		$this->out_data['article_list'] = $this->md_category->get_article_list($cate_id, $page, $limit);
		$article_count = $this->md_category->get_article_count($cate_id);
		$this->out_data['pagin'] = parent::get_pagin(base_url().'category/article_list/'.$cate_id.'/', $article_count, $limit, 4);
		$this->out_data['con_page'] = 'article_list';
		$this->out_data['cate_id'] = $cate_id;
		$this->load->view('default', $this->out_data);
	}

	function edit_article($cate_id = 0, $article_id = 0)
	{
		$cate_id = (int)$cate_id;
		if($cate_id === 0)
		{
			show_404();
			exit;
		}

		$article_id = (int)$article_id;

		$this->load->model('md_arc_flag');
		$this->out_data['flag_list'] = $this->md_arc_flag->get_flag_list();

		$this->load->model('md_category');
		$article_info = $this->md_category->get_article($article_id);
		if(empty($article_info))
		{
			$article_info['cate_id'] = $cate_id;
		}
		$this->out_data['article_info'] = $article_info;
		$this->out_data['con_page'] = 'edit_article';
		$this->load->view('default', $this->out_data);
	}
}