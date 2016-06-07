<?php

class md_member extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function get_member_list($page = 1, $limit = 10)
	{
		$start = ($page - 1)*$limit;
		return $this->db->query("select m.id,m.name,m.phone,g.integral from {$this->db->dbprefix('member')} as m inner join {$this->db->dbprefix('member_grade')} as g on m.id=g.mid limit {$start},{$limit}")->result_array();
	}

	function get_member_count()
	{
		return $this->db->query("select count(id) as num from {$this->db->dbprefix('member')}")->row()->num;
	}

	function del_member($id)
	{
		$this->db->simple_query("delete from {$this->db->dbprefix('member')} where id={$id}");
	}

}