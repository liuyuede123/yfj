<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class upload extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		show_404();
	}

	function upload_img()
	{
		$site_url = parent::get_site_url();
		$result = array('status' => false, 'img' => '', 'msg' => '');
		$allowed = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/bmp', 'image/png');
		if (in_array($_FILES['file']['type'], $allowed))
		{
			if ($_FILES["file"]["error"] === 0)
			{
				$ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
				$img = time().rand(100,999).'.'.$ext;
				move_uploaded_file($_FILES["file"]["tmp_name"], '../upload/temp/'.$img);
				$result['status'] = true;
				$result['img'] = $img;
			}
			else
			{
				$result['msg'] = $_FILES["file"]["error"];
			}
		}
		else
		{
			$result['msg'] = '不支持的图片格式';
		}
		echo json_encode($result);
	}

	function upload_album()
	{
		$site_url = parent::get_site_url();
		$result = array('status' => false, 'msg' => '');
		$allowed = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/bmp', 'image/png');
		if (in_array($_FILES['file']['type'], $allowed))
		{
			if ($_FILES["file"]["error"] === 0)
			{
				$ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
				$img = time().rand(100,999).'.'.$ext;
				move_uploaded_file($_FILES["file"]["tmp_name"], '../upload/img/'.$img);
				$result['status'] = true;
				$result['img'] = $img;

				$this->db->insert('cate_album', array('cate_id' => (int)$_POST['cate_id'], 'img' => $img));
			}
			else
			{
				$result['msg'] = $_FILES["file"]["error"];
			}
		}
		else
		{
			$result['msg'] = '不支持的图片格式';
		}
		echo json_encode($result);
	}
	
	function upload_art_album()
	{
		$site_url = parent::get_site_url();
		$result = array('status' => false, 'msg' => '');
		$allowed = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/bmp', 'image/png');
		if (in_array($_FILES['file']['type'], $allowed))
		{
			if ($_FILES["file"]["error"] === 0)
			{
				$ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
				$img = time().rand(100,999).'.'.$ext;
				move_uploaded_file($_FILES["file"]["tmp_name"], '../upload/img/'.$img);
				$result['status'] = true;
				$result['img'] = $img;

				$this->db->insert('art_img', array('art_id' => (int)$_POST['art_id'], 'img' => $img));
			}
			else
			{
				$result['msg'] = $_FILES["file"]["error"];
			}
		}
		else
		{
			$result['msg'] = '不支持的图片格式';
		}
		echo json_encode($result);
	}

	function upload_file()
	{
		$site_url = parent::get_site_url();
		$result = array('status' => false, 'file' => '', 'msg' => '');

		if ($_FILES["file"]["error"] === 0)
		{
			$ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
			$file = time().rand(100,999).'.'.$ext;
			move_uploaded_file($_FILES["file"]["tmp_name"], '../upload/temp/'.$file);
			$result['status'] = true;
			$result['file'] = $file;
		}
		else
		{
			$result['msg'] = $_FILES["file"]["error"];
		}

		echo json_encode($result);
	}

}