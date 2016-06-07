<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video extends MY_Controller {

	private $out_data;
	function __construct()
	{
		parent::__construct();
		parent::check_permission('base');
		$this->out_data['site_url'] = parent::get_site_url();
		$this->out_data['cate_list'] = parent::get_category();
	}

	public function index($page = 1)
	{
		$this->video_list(0, 1);
	}

	function video_list($cate_id = 0, $page = 1)
	{
		$this->load->model('md_video');
		$this->out_data['con_page'] = 'video_list';

		$limit = 10;
		$this->out_data['video_list'] = $this->md_video->get_video_list($cate_id, $page, $limit);
		$video_count = $this->md_video->get_video_count($cate_id);
		$base_url = base_url().'video/video_list/'.$cate_id.'/';
		$uri_segment = 4;
		$this->out_data['pagin'] = parent::get_pagin($base_url, $video_count, $limit, $uri_segment);

		$this->load->view('default', $this->out_data);
	}

	function del_video()
	{
		if(!parent::is_post()) show_404();
		$id = (int)$this->input->post('id');
		$this->load->model('md_video');
		$this->md_video->del_video($id);
	}

	function edit_video($video_id = 0)
	{
		$video_id = (int)$video_id;

		$this->load->model('md_video');
		$this->out_data['video_info'] = $this->md_video->get_video($video_id);
		$this->out_data['con_page'] = 'edit_video';
		$this->load->view('default', $this->out_data);
	}

	function save_video()
	{
		if(!parent::is_post()) show_404();
		$info = array(
		'title' => $this->input->post('title'),
		'img' => $this->input->post('img'),
		'cate_id' => (int)$this->input->post('cate_id'),
		'speaker' => $this->input->post('speaker'),
		'url' => $this->input->post('url'),
		'click' => $this->input->post('click'),
		'date' => date("Y-m-d"),
		'intro' => $this->input->post('intro'));
		$id = (int)$this->input->post('id');
		$this->load->model('md_video');
		echo $this->md_video->save_video($id, $info);
	}
}