<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Decodestr extends CI_Controller{
	function __construct(){
		parent::__construct();
		header("Content-Type:text/html; charset=gbk");
		header("Access-Control-Allow-Origin: http://www.yycf99.com");
		header("Access-Control-Allow-Origin: http://www.gdyy99.com");
		header("Access-Control-Allow-Origin: http://www.789cfw.com");
	}
	
	public function index(){
		$this->get_decodestr();
	}
	
	public function get_decodestr(){
		$str = $this->input->post('strr');
		//echo $str;
		echo trim(urldecode($str));
	}
	
}



