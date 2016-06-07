<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class avatar extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		show_404();
	}

	function user()
	{
		$headimg = $this->input->get('url');
		if( empty($headimg) )
		{
			show_404();
		}
		$headimg = decrypt( urldecode($headimg) );
		$path = FCPATH.'avatar/'.$headimg;
		if( ! file_exists($path) OR is_dir($path) )
		{
			$path = FCPATH.'avatar/user_default.jpg';
		}
		$this->_show_avatar($path);
	}

	function teacher()
	{
		$headimg = $this->input->get('url');
		if( empty($headimg) )
		{
			show_404();
		}
		// $headimg = decrypt( urldecode($headimg) );
		$path = FCPATH.'avatar/admin/'.$headimg;
		if( ! file_exists($path) OR is_dir($path) )
		{
			$path = FCPATH.'avatar/admin/admin_default.jpg';
		}
		$this->_show_avatar($path);
	}

	private function _show_avatar($path)
	{
		$imginfo = getimagesize($path);
		header("Content-type: {$imginfo['mime']}");
		$handle = fopen($path, 'rb');
		echo fread( $handle, filesize($path));
		fclose($handle);
	}
}