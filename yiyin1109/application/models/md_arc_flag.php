<?php

class md_arc_flag extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function get_flag_list()
	{
		return $this->db->query("select id,name,flag from {$this->db->dbprefix('arc_flag')}")->result_array();
	}

}