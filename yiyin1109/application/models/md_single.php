<?php

class md_single extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function get_page_list()
	{
		return $this->db->query("select id,title,url from {$this->db->dbprefix('single_page')}")->result_array();
	}

	function del_page($id)
	{
		$this->db->simple_query("delete from {$this->db->dbprefix('single_page')} where id={$id}");
	}

	function get_page($page_id)
	{
		return $this->db->query("select * from {$this->db->dbprefix('single_page')} where id={$page_id} limit 1")->row_array();
	}

	function save_page($id, $info)
	{
		$result = array('status' => false, 'msg' => '', 'id' => $id);
		$cate_url_exist = $this->db->query("select id from {$this->db->dbprefix('category')} where url='".$info['url']."'")->num_rows();
		$single_url_exist = $this->db->query("select id from {$this->db->dbprefix('single_page')} where url='".$info['url']."' and id <> ".$id)->num_rows();
		if($cate_url_exist > 0 OR $single_url_exist > 0)
		{
			$result['msg'] = '你所输入的URL已存在，请重新输入';
		}
		elseif($id === 0)
		{
			$this->db->insert('single_page', $info);
			$result['status'] = true;
			$result['id'] = $this->db->insert_id();
		}
		else
		{
			$this->db->where('id', $id);
			$result['status'] = true;
			$this->db->update('single_page', $info);
		}
		return $result;
	}

}