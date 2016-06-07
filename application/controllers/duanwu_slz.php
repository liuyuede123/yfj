<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class duanwu_slz extends CI_Controller{
	private $team_data;
	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->team_data['team2'] = $this->db->select('id,name,did,reward,is_lucky,team')->from('active_duanwu')->where(array('team' => 2))->order_by('reward desc')->limit(5)->get()->result_array();
		$this->team_data['team3'] = $this->db->select('id,name,did,reward,is_lucky,team')->from('active_duanwu')->where(array('team' => 3))->order_by('reward desc')->limit(5)->get()->result_array();
		$this->team_data['team4'] = $this->db->select('id,name,did,reward,is_lucky,team')->from('active_duanwu')->where(array('team' => 4))->order_by('reward desc')->limit(5)->get()->result_array();
		$this->load->view('duanwu_slz',$this->team_data);
	}
}