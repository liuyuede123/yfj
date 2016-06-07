<?php

class md_base extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function get_category($catedb = 'category')
	{
		return $this->db->query("select id,title,url from {$this->db->dbprefix($catedb)}")->result_array();
	}

}