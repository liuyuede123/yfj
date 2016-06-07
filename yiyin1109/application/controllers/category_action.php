<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class category_action extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		parent::check_permission('base');
		if(!parent::is_post()) show_404();
	}

	function save_cate()
	{
		$this->db->cache_delete_all();
		$category = $this->input->post('title');
		$ename = $this->input->post('ename');
		$url = $this->input->post('url');
		$id = (int)$this->input->post('id');
		$info = array('title' => $category,
			'ename' => $ename,
			'intro' => $this->input->post('intro'),
			'site_title' => $this->input->post('site_title'),
			'site_keywords' => $this->input->post('site_keywords'),
			'site_description' => $this->input->post('site_description'),
			'tpl' => $this->input->post('tpl'),
			'arc_tpl' => $this->input->post('arc_tpl'),
			'url' => $url);
		$this->load->model('md_category');
		echo json_encode($this->md_category->save_cate($id, $info));
	}

	function del_cate()
	{
		$this->db->cache_delete_all();
		$id = (int)$this->input->post('id');
		$this->load->model('md_category');
		echo json_encode($this->md_category->del_cate($id));
	}

	function del_article()
	{
		$this->db->cache_delete_all();
		$id = (int)$this->input->post('id');
		$this->load->model('md_category');
		$this->md_category->del_article($id);
	}

	function save_article()
	{
		$this->db->cache_delete_all();
		$info = array('cate_id' => (int)$this->input->post('cate_id'),
		'title' => $this->input->post('title'),
		'content' => $this->input->post('content'),
		'site_title' => $this->input->post('site_title'),
		'site_keywords' => $this->input->post('site_keywords'),
		'site_description' => $this->input->post('site_description'),
		'tags' => $this->input->post('tags'),
		'intro' => $this->input->post('intro'),
		'img' => $this->input->post('img'),
		'attach' => $this->input->post('soft'),
		'flag' => '');
		if($this->input->post('flag'))
		{
			$info['flag'] = join(',', $this->input->post('flag'));
		}
		$id = (int)$this->input->post('id');
		$this->load->model('md_category');
		echo $this->md_category->save_article($id, $info);
	}

	function del_album()
	{
		$this->db->cache_delete_all();
		$id = (int)$this->input->post('id');
		$this->load->model('md_category');
		$this->md_category->del_album($id);
	}
	
	function del_art_album()
	{
		$this->db->cache_delete_all();
		$id = (int)$this->input->post('id');
		$this->load->model('md_category');
		$this->md_category->del_art_album($id);
	}

	function save_text()
	{
		$this->db->cache_delete_all();
		$id = (int)$this->input->post('id');
		$text = $this->input->post('text');
		$this->load->model('md_category');
		$this->md_category->save_text($id, $text);
	}
	
	function save_art_text()
	{
		$this->db->cache_delete_all();
		$id = (int)$this->input->post('id');
		$text = $this->input->post('text');
		$this->load->model('md_category');
		$this->md_category->save_art_text($id, $text);
	}
}