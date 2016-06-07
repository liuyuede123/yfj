<?php

class md_special extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function get_special_list()
	{
		return $this->db->query("select id,title,url,is_show from {$this->db->dbprefix('special')} order by id desc")->result_array();
	}

	function del_special($id)
	{
		$tb = $this->db->dbprefix('special');
		$img = $this->db->query("select img from {$tb} where id={$id} limit 1")->row()->img;
		$this->del_img($img);
		$this->db->simple_query("delete from {$tb} where id={$id}");
	}

	function get_special($special_id)
	{
		return $this->db->query("select id,title,url,is_show,img,intro from {$this->db->dbprefix('special')} where id={$special_id} limit 1")->row_array();
	}

	function save_special($id, $info)
	{
		$result = array('status' => false, 'msg' => '', 'id' => $id);

		$new_img_exist = $this->new_img_exist($info['img']);
		if($new_img_exist)
		{
			rename('../upload/temp/'.$info['img'], '../upload/web_img/'.$info['img']);
		}

		if($id === 0)
		{
			$this->db->insert('special', $info);
			$result['status'] = true;
			$result['id'] = $this->db->insert_id();
		}
		else
		{
			if($new_img_exist)
			{
				$img = $this->db->query("select img from {$this->db->dbprefix('special')} where id={$id} limit 1")->row()->img;
				$this->del_img($img);
			}
			else
			{
				unset($info['img']);
			}

			$this->db->where('id', $id);
			$result['status'] = true;
			$this->db->update('special', $info);
		}
		return $result;
	}

	private function del_img($img)
	{
		$img_path = '../upload/web_img/'.$img;
		if($img != '' and file_exists($img_path))
		{
			unlink($img_path);
		}
	}

	private function new_img_exist($img)
	{
		$img_path = '../upload/temp/'.$img;
		if($img != '' and file_exists($img_path)) return true;
		else return false;
	}

}