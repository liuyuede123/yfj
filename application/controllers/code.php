<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class code extends CI_Controller {

	protected $out_data;
	function __construct()
	{
		parent::__construct();
		/* header("Access-Control-Allow-Origin: http://www.htcjzb.com");
		header("Access-Control-Allow-Origin: http://www.xwuzb.com");
		header("Access-Control-Allow-Origin: http://www.caifuzb.com");
		header("Access-Control-Allow-Origin: http://www.zjcfzb.com");
		header("Access-Control-Allow-Origin: http://www.yiyinzb.com");
		header("Access-Control-Allow-Origin: http://www.yincezb.com");
		header("Access-Control-Allow-Origin: http://www.yycfzb.com");
		header("Access-Control-Allow-Origin: http://www.zjcjzb.com"); */
		header("Access-Control-Allow-Origin: *");
		$this->load->database();
		date_default_timezone_set('Asia/Chongqing');
	}

	public function index()
	{
		/* $zhibo_code = $this->input->get("zb");
		isset($zhibo_code)?$zhibo_code:"";
		$count = $this->db->query("select count(*) as num from {$this->db->dbprefix('tel')} where zhibo_code='".mysql_real_escape_string($zhibo_code)."' and flag = 1")->row()->num;
		if(!$count){
			$out_data['zhibo_tel'] = "";
		}else{
			$out_data['zhibo_tel'] = $this->db->query("select tel from {$this->db->dbprefix('tel')} where zhibo_code='{$zhibo_code}' and flag = 1")->row()->tel;
		}
		$out_data['code_list'] = $this->db->query("select code from {$this->db->dbprefix('diagnosis_stock')} order by sort asc")->result_array(); */
		// print_r($code_list);
		// $res =  count($code_list);
		// echo $res;
		// $out_data[] = $res;
		// $this->load->view('index', $res);
		$this->load->view('code/index');
	}
	//获取人数股票
	public function get_stock_peo(){
		$result = array("checked_peo" => "","checked_stock" => "");
		$flag = $this->input->post("flag");
		$click = $this->input->post("click");
		$click = isset($click)?$click:"";
		if($flag == 1){
			$checked_peo = 0;
			$checked_stock = 0;//诊断人数checked_peo 和 已诊断股票checked_stock
			$start_num = 100;
			$hourflag = 0;//小时的偏移量
			$allminutes = 0;//总的分钟数
			$curhour = (int)date("G");//获取当前小时数(0-23)
			$curminutes = (int)date("i");//获取当前分钟数(0-59)
			//$curhour = 6;
			if($curhour >= 10 OR $curhour < 2){
			//if($curhour < 9 AND $curhour >= 2)
				//如果在这个时间段就获取 诊断人数checked_peo 和 已诊断股票checked_stock
				//获取从9点开始的分钟数
				//获取小时的偏移量
				if($curhour == 0 || $curhour == 1){
					$curhour += 24;
				}
				$hourflag = $curhour - 9;//小时的偏移量,在0-16之间
				$allminutes = $hourflag*60 + $curminutes;//总的分钟数
				$checked_peo = $allminutes*20 + rand(0,10)*5;
				$checked_stock = $allminutes*40 + rand(0,10)*5;
				//设置上下限
				$checked_peo>21000 ? 21000 : $checked_peo;
				$checked_peo<100 ? 563 : $checked_peo;
				$checked_stock>41000 ? 41000 : $checked_stock;
				$checked_stock<200 ? 1230 : $checked_stock;
				if($this->session->userdata("checked_peo") AND $this->session->userdata("checked_stock")){
					if($checked_peo > $this->session->userdata("checked_peo")){
						$this->session->set_userdata("checked_peo", $checked_peo);
					}
					if($checked_stock > $this->session->userdata("checked_stock")){
						$this->session->set_userdata("checked_stock", $checked_stock);
					}
				}else{
					$this->session->set_userdata("checked_peo", $checked_peo);
					$this->session->set_userdata("checked_stock", $checked_stock);
				}
				if($click == "click"){
					$this->session->set_userdata("checked_peo",$this->session->userdata("checked_peo")+1);
					$this->session->set_userdata("checked_stock",$this->session->userdata("checked_stock")+1);
				}
				$result['checked_peo'] = $this->session->userdata("checked_peo");
				$result['checked_stock'] = $this->session->userdata("checked_stock");
			}else if($curhour < 10 AND $curhour >= 2){
				//$this->session->set_userdata("checked_peo", 563);
				//$this->session->set_userdata("checked_stock", 1230);
				if($this->session->userdata("checked_peo") AND $this->session->userdata("checked_stock")){
					$this->session->unset_userdata('checked_peo');
					$this->session->unset_userdata('checked_stock');
				}
				
				$result['checked_peo'] = 563;
				$result['checked_stock'] = 1230;
			}
			
				
			echo json_encode($result);
		}
	}
	
	//获取功能点击量
	public function get_click(){
		$flag = $this->input->get_post("flag");
		$active = $this->input->get_post("active");
		$active = isset($active)?$active:'';
		$siteid = $this->input->get_post("siteid");
		$siteid = isset($siteid)?$siteid:'';
		if($flag){
			$ip = $this->get_real_ip();
			$db_num = $this->db->query("select count(*) as num from `zhibo_click` where ip = '{$ip}' AND active = '{$active}' AND siteid = '{$siteid}'")->row()->num;
			if($db_num == 0){
				$this->db->insert('click', array('ip' => $ip,'active'=>$active,'siteid'=>$siteid));
			}
		}
	}
	
	protected function get_real_ip(){  
		$ip=false;  
		if(!empty($_SERVER["HTTP_CLIENT_IP"])){  
			$ip = $_SERVER["HTTP_CLIENT_IP"];  
		}  
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
			$ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);  
			if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }  
			for ($i = 0; $i < count($ips); $i++) {  
				if (!preg_match ("/^(10|172\.16|192\.168)\./i", $ips[$i])) {  
					$ip = $ips[$i];  
					break;  
				}  
			}  
		}  
		return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);  
	}   

}