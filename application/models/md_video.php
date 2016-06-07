<?php

class md_video extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function get_category_list()
	{
		return $this->db->query("select id,name from {$this->db->dbprefix('video_category')}")->result_array();
	}

	function get_hot_video($num)
	{
		return $this->db->query("select id,title,img from {$this->db->dbprefix('video')} order by click desc,id desc limit {$num}")->result_array();
	}

	function get_video_list($cate_id, $page, $limit)
	{
		$sql = "select id,cate_id,title,speaker,date,intro,img from {$this->db->dbprefix('video')} ";
		if($cate_id !== 0)
		{
			$start = ($page - 1)*$limit;
			$sql .= " where cate_id={$cate_id} order by date desc,id desc limit {$start},{$limit} ";
		}
		else
		{
			$sql .= " order by date desc,id desc limit 5";
		}
		return $this->db->query($sql)->result_array();
	}

	function get_video_num($cate_id)
	{
		return $this->db->query("select count(id) as num from {$this->db->dbprefix('video')} where cate_id={$cate_id}")->row()->num;
	}

	function get_video($id)
	{
		return $this->db->query("select cate_id,title,url,speaker,date,intro,img from {$this->db->dbprefix('video')} where id={$id}")->row_array();
	}

	function get_latest_video($num)
	{
		return $this->db->query("select id,cate_id,title,speaker,date,intro,img from {$this->db->dbprefix('video')}  order by date desc,id desc limit {$num}")->result_array();
	}

	function get_related_video($cate_id, $num)
	{
		return $this->db->query("select id,title,date,img from {$this->db->dbprefix('video')} where cate_id={$cate_id}  order by date desc,id desc limit {$num}")->result_array();
	}
}