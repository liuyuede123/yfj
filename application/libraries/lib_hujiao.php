<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class lib_hujiao {

	public function __construct()
	{

	}

	/*array('name' => $name, 'phone' => $phone, 'title' => $title, 'time' => $time, 'province' => $province, 'STRINGFIELD4' => $STRINGFIELD4)*/
	function insert($arr)
	{
		$CI =& get_instance();
		$str = $CI->load->view('tpl_hujiao', $arr, true);
		$str = str_replace('<\?', '<?', $str);
		$str = $this->_encrypt($str);
		$ProjectID = 10000009;
		// $OutCallID = 10000225;
		if(isset($arr['out_call_id']) and $arr['out_call_id'] != '')
		{
			$OutCallID = $arr['out_call_id'];
		}
		else
		{
			if(isset($arr['flag']) AND $arr['flag'] == 'soft_1022')
			{
				$OutCallID = $this->_getSoftOutCallID();
			}
			else
			{
				$OutCallID = $this->_getOutCallID();
			}
		}
		$result = file_get_contents("http://140.207.79.210/web/YWInterface.asmx/GetInformationlist?ProjectID={$ProjectID}&OutCallID={$OutCallID}&xml={$str}");
		if($this->_is_success($result))
		{
			$CI->db->query("update {$CI->db->dbprefix('out_call')} set cur = cur + 1 where out_call_id='{$OutCallID}'");
			return true;
		}
		else
		{
			return false;
		}
	}

	private function _is_success($xml_string)
	{
		$result = simplexml_load_string($xml_string);
		$result = @json_decode(@json_encode($result),1);
		$result = simplexml_load_string($result[0]);
		$result = @json_decode(@json_encode($result),1);
		if((int)$result['info']['Succeed'] == 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	private function _getOutCallID()
	{
		$CI =& get_instance();
		$tb_out_call = $CI->db->dbprefix('out_call');
		$sql = "select limit_num,cur,out_call_id from {$tb_out_call} where DATE_FORMAT(NOW(), '%Y-%m-%d') = date AND flag=''";
		$data = $CI->db->query($sql)->result_array();
		if(count($data) == 0)
		{
			$CI->db->query("update {$tb_out_call} set cur = 0, date=DATE_FORMAT(NOW(), '%Y-%m-%d') where flag=''");
			$data = $CI->db->query($sql)->result_array();
		}

		$data_selected = array();
		foreach($data as $k => $v)
		{
			if($v['cur'] < $v['limit_num'])
			{
				$data_selected[] = $v;
			}
		}
		if(count($data_selected) == 0) $data_selected = $data;

		$select = mt_rand(0, (count($data_selected) - 1) );
		return $data_selected[$select]['out_call_id'];
	}

	private function _getSoftOutCallID()
	{
		$CI =& get_instance();
		$tb_out_call = $CI->db->dbprefix('out_call');
		$sql = "select out_call_id from {$tb_out_call} where DATE_FORMAT(NOW(), '%Y-%m-%d') = date AND flag='soft_1022' order by cur limit 1";
		$data = $CI->db->query($sql);
		if($data->num_rows() == 0)
		{
			$CI->db->query("update {$tb_out_call} set cur = 0, date=DATE_FORMAT(NOW(), '%Y-%m-%d') where flag='soft_1022'");
			$data = $CI->db->query($sql);
		}
		return $data->row()->out_call_id;
	}

	private function _encrypt($str)
	{	$str = mb_convert_encoding($str, 'GBK', 'UTF-8');
		preg_match_all("/./", $str, $arr);
		$result = '';
		foreach($arr[0] as $v)
		{
			$v = ord($v);
			$i = $v < 0 ? $v+256 : $v;
			$s = (int)($i/26);
			$y = $i%26;
			$result .= (string)($s.($y < 10 ? '0'.$y : $y));
		}
		return $result;
	}
}