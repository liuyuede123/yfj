<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	/**
	 * this is the base controller
	 * all the controller must extends base controller explect login
	 */
	protected $out_data;
	function __construct()
	{
		parent::__construct();
		self::check_login();
	}

	protected function check_login()
	{
		if(!$this->session->userdata('is_login') OR $this->session->userdata('role') != 'member' )
		{
			header("Location:".base_url()."login");
			exit;
		}
	}


	protected function is_post()
	{
		return $_SERVER['REQUEST_METHOD' ] === 'POST' ? true : false;
	}
}