<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class download extends CI_Controller {

	private $out_data = array();
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		show_404();
	}

	function publication()
	{
		$id = $this->input->post('id');
		$this->_download_publication($id);
		exit;
		/* --------------------------- 下面的功能暂时不做---------------------------------------*/

		// $result = array('status' => false, 'msg' => '');
		// $phone = $this->input->post('phone');
		// $code = $this->input->post('code');

		// /*手机号可不能为空*/
		// if($phone == '')
		// {
		// 	$result['msg'] = '手机号码不能为空';
		// 	echo json_encode($result);
		// 	exit;
		// }

		// /*如果有传验证码，则来验证是否正确，然后再决定是否下载*/
		// if($code)
		// {
		// 	$user = $this->db->query("select id from {$this->db->dbprefix('phone_collect')} where phone = '{$phone}' and code = '{$code}' and flag=0 limit 1");
		// 	if($user->num_rows() > 0)
		// 	{
		// 		$this->db->where('id', $user->row()->id);
		// 		$this->db->update('phone_collect', array('flag' => 1));
		// 		$this->_download_publication($id);
		// 		$result['status'] = true;
		// 	}
		// 	else
		// 	{
		// 		$result['msg'] = '验证码错误，请确认后再输入';
		// 	}
		// 	echo json_encode($result);
		// 	exit;
		// }

		// /*没有验证码过来，首先查看该手机号在系统中是否已存在，如果有，则直接让其下载*/
		// $phone_exist = $this->db->query("select id from {$this->db->dbprefix('phone_collect')} where phone='{$phone}' and flag=1 limit 1")->num_rows();
		// if($phone_exist)
		// {
		// 	$this->_download_publication($id);
		// 	$result['status'] = true;
		// 	echo json_encode($result);
		// 	exit;
		// }

		// /*又没验证码，手机号又不存在于系统中，那就让其收验证码去*/
		
	}

	/*该私有函数直接下载刊物*/
	private function _download_publication($id)
	{
		$info = $this->db->query("select title,attach from {$this->db->dbprefix('article')} where id={$id} limit 1");
		if($info->num_rows() > 0)
		{
			$info = $info->row();
			$this->_download_file(base_url().'upload/soft/'.$info->attach, '银策略'.$info->title);
		}
	}

	function soft($id)
	{
		$info = $this->db->query("select soft from {$this->db->dbprefix('soft')} where id={$id} limit 1");
		if($info->num_rows() > 0)
		{
			$info = $info->row();
			// $this->_download_file(base_url().'upload/soft/'.$info->soft);
			$this->_download_file('http://soft.gdyy99.com/upload/soft/'.$info->soft);
		}
	}

	private function _download_file($file, $name = '')
	{
		$filename = ($name == '') ? basename($file) : $name.'.'.pathinfo($file, PATHINFO_EXTENSION);
	 
		header("Content-type: application/octet-stream");
	 
		//处理中文文件名
		$ua = $_SERVER["HTTP_USER_AGENT"];
		if (preg_match("/MSIE/", $ua))
		{
			$encoded_filename = rawurlencode($filename);
			header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
		}
		else if (preg_match("/Firefox/", $ua))
		{
			header("Content-Disposition: attachment; filename*=\"utf8''" . $filename . '"');
		}
		else
		{
			header('Content-Disposition: attachment; filename="' . $filename . '"');
		}
	 
		header("Content-Length: ". filesize($file));
		header("Location: {$file}");  /*使用该行直接将当前页转向文件实际地址，不需要readfile了，不会出现文件过大无法下载问题，但会导致暴露实际下载链接*/
		// readfile($file);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */