<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class webcast extends MY_Controller {

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
		$this->cast_list();
	}

	function cast_list($page = 1)
	{
		$this->out_data['con_page'] = 'webcast_list';

		$limit = 15;
		$start = ($page - 1)*$limit;
		$count = $this->db->select('id')->from('webcast')->get()->num_rows();
		$this->out_data['pagin'] = parent::get_pagin(base_url().'webcast/cast_list/', $count, $limit, 3);

		$this->out_data['cast_list'] = $this->db->select('id,time,title,speaker,cast_url,demand_url,is_finish')->from('webcast')->order_by('is_finish,sort')->limit($limit, $start)->get()->result_array();
		$this->load->view('default', $this->out_data);
	}

	function edit_cast($id = 0)
	{
		$id = (int)$id;

		$this->out_data['info'] = $this->db->from('webcast')->where(array('id' => $id))->limit(1)->get()->row_array();
		$this->out_data['con_page'] = 'webcast_edit';
		$this->load->view('default', $this->out_data);
	}

	function save_cast()
	{
		$info = array(
		'time' => $this->input->post('time'),
		'title' => $this->input->post('title'),
		'speaker' => $this->input->post('speaker'),
		'cast_url' => $this->input->post('cast_url'),
		'demand_url' => $this->input->post('demand_url'),
		'is_finish' => $this->input->post('is_finish'),
		'sort' => $this->input->post('sort'));
		$id = (int)$this->input->post('id');
		if($id === 0)
		{
			$this->db->insert('webcast', $info);
			$id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('id', $id);
			$this->db->update('webcast', $info);
		}
	}

	function del_cast()
	{
		$id = $this->input->post('id');
		$this->db->delete('webcast', array('id' => $id));
	}
}