<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class monichoujiang extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		header("Access-Control-Allow-Origin: http://www.yiyin099.com");
	}

	public function index()
	{
		show_404();
	}

	function send_captcha()
	{
		$phone = $this->input->post('phone');
		// if( $this->db->select('phone')->from('moni_record')->where(array('phone' => $phone))->limit(1)->get()->num_rows() > 0 )
		// {
		// 	echo json_encode(array('status' => false, 'msg' => '每位客户只有一次抽奖机会哦~~~~'));
		// }
		// else
		// {
			$this->load->library('lib_captcha');
			$result = $this->lib_captcha->send_captcha($phone);
			echo json_encode($result);
		// }
	}

	function add_phone()
	{
		date_default_timezone_set('Asia/Chongqing');
		$phone = $this->input->post('phone');
		$captcha = $this->input->post('captcha');
		
		$result = array('status' => false, 'msg' => '');

		$session_phone = $this->session->userdata('phone');
		$session_captcha = $this->session->userdata('captcha');
		if( ! ( $phone == $session_phone AND $captcha == $session_captcha AND $session_phone !== false AND $session_captcha !== false ) )
		{
			$result['msg'] = '手机号和验证码不对应';
			echo json_encode($result);
			exit;
		}
		$this->session->unset_userdata('phone');
		$this->session->unset_userdata('captcha');

		$name = $this->input->post('name');
		$remark = $this->input->post('remark');
		$landing_page = $this->input->post('landing_page');
		$landing_page = $landing_page ? $landing_page : '';
		$engine = $this->input->post('referrer_host');
		$engine = $engine ? str_replace(array('http://www.', 'www.'), '', $engine) : '';
		$last_page = rtrim($this->input->post('last_page'),'/');
		$last_page = $last_page ? $last_page : '';
		$title = $this->input->post('title');
		$title = $title ? $title : '';
		$time = date("Y-m-d H:i:s");
		$ip = $this->_get_ip();
		$province = $this->_get_province($ip);

		$this->db->insert('phone_collect', array('name' => $name, 'phone' => $phone, 'remark' => $remark, 'time' => $time, 'landing_page' => $landing_page, 'engine' => $engine, 'last_page' => $last_page, 'ip' => $ip, 'title' => $title, 'province' => $province) );
		$result['id'] = $this->db->insert_id();
		$this->db->insert('moni_record', array('phone' => $phone));
		$result['status'] = true;

		$channel = $this->input->post('channel');
		$source_url = $this->input->post('source_url');
		$keyword = $this->input->post('keyword');
		$temp = $this->db->select('name')->from('engine')->where('domain', $channel)->limit(1)->get();
		if($temp->num_rows() > 0) $channel = $temp->row()->name;
		$this->db->insert('sem_record', array('time' => $time, 'page' => $last_page, 'channel' => $channel, 'source_url' => $source_url, 'keyword' => $keyword, 'ip' => $ip, 'province' => $province));

		/*更新手机号验证码记录*/
		$date = date("Y-m-d");
		$md5_phone = md5($phone);
		$this->db->update('phone_record', array('success' => 1), array('date' => $date, 'phone' => $md5_phone) );
		
		$this->load->library('lib_hujiao');
		$this->lib_hujiao->insert(array('name' => $name, 'time' => $time, 'title' => $title, 'phone' => $phone, 'province' => $province));
		echo json_encode($result);
	}

	private function _get_province($ip)
	{
		$result = json_decode( file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip={$ip}"), true );
		if($result['code'] == 0)
		{
			return $result['data']['region'];
		}
		else
		{
			return '';
		}
	}

	private function _get_ip()
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '')
		{
			$ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			$ip = $ip[0];
		}
		return $ip;
	}

	// function set_source()
	// {
	// 	if($_SERVER['REQUEST_METHOD' ] !== 'POST') show_404();
	// 	$rtb = substr($this->input->post('rtb'), 0, 20);
	// 	if(!empty($rtb)) $this->session->set_userdata('rtb', $rtb);

	// 	$referrer = substr($this->input->post('referrer'), 0, 30);
	// 	if(!empty($referrer)) $this->session->set_userdata('referrer', $referrer);
	// }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */