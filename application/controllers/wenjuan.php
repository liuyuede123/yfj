<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class wenjuan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if($_SERVER['REQUEST_METHOD' ] !== 'POST') show_404();
		date_default_timezone_set('Asia/Chongqing');
	}

	public function index()
	{
		show_404();
	}

	public function send_wenjuan()
	{
		$zb_name = str_replace(' ', '', $this->input->post('zb_name'));
		$zb_id = str_replace(' ', '', $this->input->post('zb_id'));
		$zb_source = str_replace(' ', '', $this->input->post('zb_source'));  //有other
		$zb_keyword = str_replace(' ', '', $this->input->post('zb_keyword')); //有other
		$zb_time = str_replace(' ', '', $this->input->post('zb_time'));
		$zb_reason = $this->input->post('zb_reason');   //有other，多选
		$zb_another = str_replace(' ', '', $this->input->post('zb_another'));
		$touzi_reason = $this->input->post('touzi_reason'); //有other，多选
		$create_date = date('Y-m-d H:i:s', time());
		
		if($zb_source == 'other')
		{
			$zb_source = str_replace(' ', '', $this->input->post('other_source'));
		}
		if($zb_keyword == 'other')
		{
			$zb_keyword = str_replace(' ', '', $this->input->post('other_keyword'));
		}
		
		/* 判断提交数据是否为空 */
		if(empty($zb_name) OR empty($zb_id) OR empty($zb_source) OR empty($zb_keyword) OR empty($zb_keyword) OR empty($zb_time) OR empty($zb_reason) OR empty($zb_another) OR empty($touzi_reason))
		{
			$result = '信息没填写完整哦，赶紧补充吧！';
		}
		else
		{
			/* 引入表单验证 */
			$this->load->library('form_validation');
			$is_num = $this->form_validation->numeric($zb_id);
			$zb_name_len = $this->form_validation->max_length($zb_name, 20);
			if(strlen($zb_id) != 15 OR !$is_num)
			{
				echo "实盘账号格式不正确";
				exit;
			}
			if(!$zb_name_len)
			{
				echo "姓名格式不正确";
				exit;
			}
			foreach($zb_reason as $k => $v)
			{
				if($zb_reason[$k] == 'other')
				{
					$zb_reason[$k] = str_replace(' ', '', $this->input->post('other_reason'));
					if(empty($zb_reason[$k]))
					{
						echo "其他里面是空的哦，赶紧去填吧！";
						exit;
					}
				}
			}
			foreach($touzi_reason as $k => $v)
			{
				if($touzi_reason[$k] == 'other')
				{
					$touzi_reason[$k] = str_replace(' ', '', $this->input->post('other_touzi_reason'));
					if(empty($touzi_reason[$k]))
					{
						echo "其他里面是空的哦，赶紧去填吧！";
						exit;
					}
				}
			}
			$zb_reason = implode('&', $zb_reason);
			$touzi_reason = implode('&', $touzi_reason);
			/* echo $zb_reason;
			exit; */
			/* 判断是不是公司内部人员 */
			$ip = $this->_get_ip();
			if($ip == '140.207.79.210' OR $ip == '58.247.75.154' OR $ip == '58.247.75.150')
			{
				$flag = '公司内部';
			}
			else
			{
				$flag = '';
			}
			/* 一个实盘账号只能提交一次 */
			$shipan = $this->db->where(array('zb_id' => $zb_id))->get('wenjuan')->num_rows();
			/* echo $shipan;
			exit; */
			if($shipan > 0)
			{
				$result = '此实盘账号已经提交，请不要重复提交';
			}
			else
			{
				$this->db->insert('wenjuan', array('zb_name' => $zb_name, 'zb_id' => $zb_id, 'zb_source' => $zb_source, 'zb_keyword' => $zb_keyword, 'zb_time' => $zb_time, 'zb_reason' => $zb_reason, 'zb_another' => $zb_another, 'touzi_reason' => $touzi_reason, 'create_date' => $create_date, 'flag' => $flag));
				$result = '问卷提交成功';
			}
		}
		echo $result;
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

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */