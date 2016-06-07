<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class index extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$version = $this->input->get('version');
		$out_data = array();
		$view_page = 'index';
		if($version !== false)
		{
			$out_data['version'] = 'version-141015';
			$view_page = 'index-'.$version;
		}
		$this->load->view($view_page, $out_data);	
	}

	function get_ecalendar()
	{
		$date = $this->input->post('date');
		$list = $this->db->query("select datetime,title,info from {$this->db->dbprefix('ecalendar')} order by datetime")->result_array();
		// $list = $this->db->query("select datetime,title,info from {$this->db->dbprefix('ecalendar')} where str_to_date(datetime, '%Y-%m-%d') = '".$date."' order by datetime")->result_array();
		echo json_encode($list);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */