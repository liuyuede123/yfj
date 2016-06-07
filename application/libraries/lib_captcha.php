<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class lib_captcha {

	public function __construct()
	{

	}

	function send_captcha($phone)
	{
		$result = array('status' => false, 'msg' => '', 'code' => -1);
		$verify_result = $this->_verify_phone($phone);
		if( ! $verify_result['status'])
		{
			$result = $verify_result;
		}
		else
		{
			$CI =& get_instance();
			date_default_timezone_set('Asia/Chongqing');
			$md5_phone = md5($phone);
			$tb = $CI->db->dbprefix('phone_record');
			$today = date("Y-m-d");
			$is_exist = $CI->db->query("select success from {$tb} where date='{$today}' and phone = '{$md5_phone}' limit 3");
			if( $is_exist->num_rows() == 3 )
			{
				$result['msg'] = '如未收到验证码，请联系左侧在线客服报名！';
			}
			else
			{
				/*判断今天是否有成功注册过*/
				$is_exist = $is_exist->result_array();
				foreach($is_exist as $v)
				{
					if($v['success'] == 1)
					{
						$result['code'] = 1;
						$result['msg'] = '您已注册成功，请勿重复提交！';
						return $result;
					}
				}

				$target = "http://www.jianzhou.sh.cn/JianzhouSMSWSServer/http/sendBatchMessage";
				$CI->load->helper('string');
				$captcha = random_string('numeric', 4);
				$post_data = "account=sdk_yiyin&password=62509730&destmobile={$phone}&msgText=您的验证码是：{$captcha}。请不要把验证码泄露给其他人。【壹银财富】";
				$result['is_send'] = true; /*仅表示程序运行到发送验证码步骤，至于是否发送成功，不知道。*/
				$gets =  $this->_post($post_data, $target);
				if($gets > 0)
				{
					$CI->db->insert($tb, array('phone' => $md5_phone, 'date' => $today));
					$result['status'] = true;
					$CI->session->set_userdata('phone', $phone);
					$CI->session->set_userdata('captcha', $captcha);
				}
				else
				{
					$result['msg'] = '短信发送失败，请稍候重试';
				}
			}

		}
		return $result;
	}

	function verify_captcha($phone, $captcha)
	{
		$result = array('status' => false, 'msg' => '');
		$CI =& get_instance();
		if( ! ( $phone == $CI->session->userdata('phone') AND $captcha == $CI->session->userdata('captcha') ) )
		{
			$result['msg'] = '手机号和验证码不对应';
		}
		else
		{
			$result['status'] =  true;
		}
		return $result;
	}

	private function _verify_phone($phone)
	{
		$result = array('status' => false, 'msg' => '');
		if($phone === '')
		{
			$result['msg'] = '手机号码不能为空';
		}
		else
		{
			$result['status'] = true;
		}
		return $result;
	}

	private function _post($curlPost,$url)
	{
		$header [] = "content-type: application/x-www-form-urlencoded;charset=UTF-8";
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_HEADER, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST" );
	    curl_setopt($curl, CURLOPT_NOBODY, true);
	    curl_setopt($curl, CURLOPT_POST, true);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $header );
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
	    $return_str = curl_exec($curl);
	    curl_close($curl);
	    return $return_str;
	}

	private function _xml_to_array($xml)
	{
		$reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
		if(preg_match_all($reg, $xml, $matches)){
			$count = count($matches[0]);
			for($i = 0; $i < $count; $i++){
			$subxml= $matches[2][$i];
			$key = $matches[1][$i];
				if(preg_match( $reg, $subxml )){
					$arr[$key] = $this->_xml_to_array( $subxml );
				}else{
					$arr[$key] = $subxml;
				}
			}
		}
		return $arr;
	}
}