<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class submit_phone_ex extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		header("Access-Control-Allow-Origin: http://wap.gdyy99.com");
		header("Access-Control-Allow-Origin: http://www.yiyin099.com");
		header("Access-Control-Allow-Origin: http://www.099cj.com");
		header("Access-Control-Allow-Origin: http://www.yycf99.com");
		if($_SERVER['REQUEST_METHOD' ] !== 'POST') show_404();
		date_default_timezone_set('Asia/Chongqing');
	}

	public function index()
	{
		show_404();
	}

	function send_captcha()
	{
		$phone = $this->input->post('phone');
		$this->load->library('lib_captcha');
		$result = $this->lib_captcha->send_captcha($phone);

		if( isset($result['is_send']) )
		{
			/*程序运行到发送验证码步骤,所以现在就算用户还未提交，我也先把各项信息记录下来,默认为未提交成功*/
			/*可是细想想，如果用户刚刚点击发送验证码，却又未成功提交，现在又点击发送验证码，我直接记录下来，岂不是重复记录了？所以还是以同天同ip同手机的标准判断下吧！*/
			$ip = $this->_get_ip();
			$md5_phone = md5($phone);
			$is_exist = $this->db->query("select id from {$this->db->dbprefix('sem_record')} where ip='{$ip}' and phone='{$md5_phone}' and date_format(NOW(), '%y%m%d') = date_format(time, '%y%m%d') limit 1")->num_rows();
			if($is_exist == 0)
			{
				$phone = $this->input->post('phone');
				$last_page = rtrim($this->input->post('last_page'),'/');
				$last_page = $last_page ? $last_page : '';
				$channel = $this->input->post('channel');
				$source_url = $this->input->post('source_url');
				$keyword = $this->input->post('keyword');
				$province = $this->_get_province($ip);
				$time = date("Y-m-d H:i:s");

				$temp = $this->db->select('name')->from('engine')->where('domain', $channel)->limit(1)->get();
				if($temp->num_rows() > 0) $channel = $temp->row()->name;

				//$this->db->insert('sem_record', array('time' => $time, 'page' => $last_page, 'channel' => $channel, 'source_url' => $source_url, 'keyword' => $keyword, 'ip' => $ip, 'province' => $province, 'phone' => $md5_phone, 'is_submit' => 0));
			}
		}

		echo json_encode($result);
	}

	function add_phone()
	{
		$phone = $this->input->post('phone');
		$captcha = $this->input->post('captcha');
		
		$result = array('status' => false, 'msg' => '', 'is_insert' => false);

		$session_phone = $this->session->userdata('phone');
		$session_captcha = $this->session->userdata('captcha');
		if( ! ( $phone == $session_phone AND $captcha == $session_captcha AND $session_phone !== false AND $session_captcha !== false ) )
		{
			// $result['msg'] = '手机号和验证码不对应';
			$result['msg'] = $phone.$session_phone.'----'.$session_captcha;
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

		// $this->db->insert('phone_collect', array('name' => $name, 'phone' => $phone, 'remark' => $remark, 'time' => $time, 'landing_page' => $landing_page, 'engine' => $engine, 'last_page' => $last_page, 'ip' => $ip, 'title' => $title, 'province' => $province) );
		$result['id'] = $this->db->insert_id();
		$result['status'] = true;

		$channel = $this->input->post('channel');
		$STRINGFIELD4 = '百度推广';
		if(stripos($channel, 'haosou.com') !== false ) $STRINGFIELD4 = '360推广';

		if(stripos($last_page, 'wap_') !== false ) $STRINGFIELD4 .= '移动端';
		else $STRINGFIELD4 .= 'PC端';

		/*更新手机号验证码记录*/
		$date = date("Y-m-d");
		$md5_phone = md5($phone);
		$this->db->update('phone_record', array('success' => 1), array('date' => $date, 'phone' => $md5_phone) );

		$this->load->library('lib_hujiao');
		$flag = '';
		$source = '';
		if(stripos($last_page, 'soft_1022') !== false)
		{
			$flag = 'soft_1022';
			$source = 'rjxz';
		}
		
		if(stripos($last_page, 'oilwar') !== false)
		{
			$flag = 'soft_1022';
			$source = 'sykh';
		}
		$is_insert = $this->lib_hujiao->insert(array('name' => $name, 'time' => $time, 'title' => $title, 'phone' => $phone, 'province' => $province, 'STRINGFIELD4' => $STRINGFIELD4, 'flag' => $flag, 'source' => $source));

		/*判断与前面发送验证码是同一人提交的标准是：在同一天用相同的IP和手机号提交,将其设置为提交成功*/
		// $this->db->insert('sem_record', array('time' => $time, 'page' => $last_page, 'channel' => $channel, 'source_url' => $source_url, 'keyword' => $keyword, 'ip' => $ip, 'province' => $province));
		$is_submit = 1;
		if($is_insert) $is_submit = 2;
		$this->db->query("update {$this->db->dbprefix('sem_record')} set is_submit = {$is_submit} where ip = '{$ip}' and phone = '{$md5_phone}' and date_format(NOW(), '%y%m%d') = date_format(time, '%y%m%d') limit 1");
		$result['is_insert'] = $is_insert;
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
		$info = array(
			'name' => $this->input->post('name'),
			'time' => $this->input->post('time'),
			'title' => $this->input->post('title'),
			'phone' => $this->input->post('phone'),
			'province' => $this->input->post('province'),
			'STRINGFIELD4' => $this->input->post('STRINGFIELD4'),
			);
		$this->load->library('lib_hujiao');
		$this->lib_hujiao->insert($info);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */