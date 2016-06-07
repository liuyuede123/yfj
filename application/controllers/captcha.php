<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class captcha extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		header("Access-Control-Allow-Origin: http://wap.gdyy99.com");
		header("Access-Control-Allow-Origin: http://www.yiyin099.com");
		header("Access-Control-Allow-Origin: http://www.099cj.com");
		if($_SERVER['REQUEST_METHOD' ] !== 'POST') show_404();
	}

	public function index()
	{
		$this->send_captcha();
	}

	function send_captcha()
	{
		$phone = $this->input->post('phone');
		$this->load->library('lib_captcha');
		$result = $this->lib_captcha->send_captcha($phone);
		echo json_encode($result);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */