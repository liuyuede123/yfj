<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class phone_ex extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		header("Access-Control-Allow-Origin: http://wap.gdyy99.com");
		header("Access-Control-Allow-Origin: http://zhibo.gdyy99.com");
		header("Access-Control-Allow-Origin: http://www.yiyin099.com");		
		header("Access-Control-Allow-Origin: http://www.099cj.com");
		header("Access-Control-Allow-Origin: http://www.yycf99.com");
	}

	public function index()
	{
		show_404();
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
		// $province = '';

		// $this->db->insert('phone_collect', array('name' => $name, 'phone' => $phone, 'remark' => $remark, 'time' => $time, 'landing_page' => $landing_page, 'engine' => $engine, 'last_page' => $last_page, 'ip' => $ip, 'title' => $title, 'province' => $province) );
		$result['id'] = $this->db->insert_id();
		$result['status'] = true;

		$channel = $this->input->post('channel');
		$source_url = $this->input->post('source_url');
		$keyword = $this->input->post('keyword');
		$STRINGFIELD4 = '百度推广';
		if(stripos($channel, 'haosou.com') !== false ) $STRINGFIELD4 = '360推广';


		$temp = $this->db->select('name')->from('engine')->where('domain', $channel)->limit(1)->get();
		if($temp->num_rows() > 0) $channel = $temp->row()->name;
		$this->db->insert('sem_record', array('time' => $time, 'page' => $last_page, 'channel' => $channel, 'source_url' => $source_url, 'keyword' => $keyword, 'ip' => $ip, 'province' => $province));

		/*更新手机号验证码记录*/
		$date = date("Y-m-d");
		$md5_phone = md5($phone);
		$this->db->update('phone_record', array('success' => 1), array('date' => $date, 'phone' => $md5_phone) );

		$this->load->library('lib_hujiao');
		$this->lib_hujiao->insert(array('name' => $name, 'time' => $time, 'title' => $title, 'phone' => $phone, 'province' => $province, 'STRINGFIELD4' => $STRINGFIELD4));
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

	function insert_to_hujiao()
	{
		if($_SERVER['REQUEST_METHOD' ] !== 'POST') show_404();
		date_default_timezone_set('Asia/Chongqing');
		$info = array(
			'name' => $this->input->post('name'),
			'time' => $this->input->post('time'),
			'title' => $this->input->post('title'),
			'phone' => $this->input->post('phone'),
			'province' => $this->input->post('province'),
			'STRINGFIELD4' => $this->input->post('STRINGFIELD4'),
			'flag' => $this->input->post('flag')
			);
		$source = $this->input->post('source');
		$out_call_id = $this->input->post('out_call_id');
		if($source !== false) $info['source'] = $source;
		if($out_call_id !== false) $info['out_call_id'] = $out_call_id;
		$this->load->library('lib_hujiao');
		echo $this->lib_hujiao->insert($info);
	}
	
	/* 处理其他站传来的数据，并插入数据库表 */
	function insert_to_table()
	{
		if($_SERVER['REQUEST_METHOD' ] !== 'POST') show_404();
		date_default_timezone_set('Asia/Chongqing');
		$info = $this->input->post();
		$tb = $info['table'];
		$info = unset($info['table']);
		$is_insert = $this->db->insert($tb, $info)->affected_rows();
		echo $is_insert ? true : false;
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