<?php

class md_ecalendar extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function get_ecalendar_count()
	{
		return $this->db->query("select count(id) as num from {$this->db->dbprefix('calendar')}")->row()->num;
	}
	
	function get_ecalendar_list($page, $limit)
	{
		$start = ($page - 1)*$limit;
		return $this->db->query("select * from {$this->db->dbprefix('calendar')} order by date desc,time desc limit {$start},{$limit}")->result_array();
	}

	// function del_ecalendar($id)
	// {
	// 	$this->db->simple_query("delete from {$this->db->dbprefix('ecalendar')} where id={$id}");
	// }

	// function get_ecalendar($ecalendar_id)
	// {
	// 	return $this->db->query("select * from {$this->db->dbprefix('calendar')} where id={$ecalendar_id} limit 1")->row_array();
	// }

	// function save_ecalendar($id, $info)
	// {
	// 	if($id === 0)
	// 	{
	// 		$this->db->insert('ecalendar', $info);
	// 		$id = $this->db->insert_id();
	// 	}
	// 	else
	// 	{
	// 		$this->db->where('id', $id);
	// 		$this->db->update('ecalendar', $info);
	// 	}
	// 	return $id;
	// }

}