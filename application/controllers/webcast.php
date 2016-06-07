<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class webcast extends CI_Controller {

	private $out_data = array();
	function __construct()
	{
		parent::__construct();

	}

	public function index()
	{
		$this->room();
	}

	function room()
	{
		$this->out_data['live'] = $this->db->select('time,title,speaker,cast_url')->from('webcast')->where(array('is_finish' => 0))->order_by('sort,id desc')->limit(4)->get()->result_array();
		$this->out_data['finish'] = $this->db->select('time,title,speaker,demand_url')->from('webcast')->where(array('is_finish' => 1))->order_by('sort,id desc')->limit(8)->get()->result_array();
		$this->load->view('webcast', $this->out_data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */