<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class video extends CI_Controller {

	private $out_data = array();
	function __construct()
	{
		parent::__construct();
		$this->load->model('md_video');

	}

	public function index()
	{
		$this->category(2);
	}

	function category($cate_id = 0, $page = 1)
	{
		$tpl = $this->db->select('tpl')->from('video_category')->where(array('id' => $cate_id))->limit(1)->get()->row_array();
		if(empty($tpl))
		{
			show_404();
			exit;
		}
		$tpl = $tpl['tpl'];

		$this->out_data['cate_list'] = $this->md_video->get_category_list();
		$this->out_data['hot_list'] = $this->md_video->get_hot_video(5);

		$limit = 5;
		$this->out_data['list'] = $this->md_video->get_video_list($cate_id, $page, $limit);

		if($cate_id === 0)
		{
			$this->out_data['pagin'] = '';
		}
		else
		{
			$this->load->library('pagination');
			$config['base_url'] = base_url().'video/category/'.$cate_id.'/';
			$config['total_rows'] = $this->md_video->get_video_num($cate_id);
			$config['per_page'] = $limit;
			$config['uri_segment'] = 4;
			$config['use_page_numbers'] = TRUE;

			$config['full_tag_open'] = '<ul class="pages">';
			$config['full_tag_close'] = '</ul>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a><strong>';
			$config['cur_tag_close'] = '</strong></a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['first_link'] = '首页';
			$config['next_link'] = '下一页';
			$config['prev_link'] = '上一页';
			$config['last_link'] = '尾页';

			$this->pagination->initialize($config); 

			$this->out_data['pagin'] = $this->pagination->create_links();
		}

		$this->load->view($tpl, $this->out_data);
	}

	function play($id)
	{
		$id = (int)$id;
		$video = $this->md_video->get_video($id);
		if(empty($video))
		{
			show_404();
			exit;
		}
		$this->out_data['video'] = $video;
		$this->out_data['hot_video_list'] = $this->md_video->get_hot_video(10);
		// $this->out_data['new_video_list'] = $this->md_video->get_latest_video(1);
		$this->out_data['related_video_list'] = $this->md_video->get_related_video($video['cate_id'], 10);

		$this->load->view('video_play', $this->out_data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */