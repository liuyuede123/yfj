<?php

class md_banner extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function get_banner_list()
	{
		return $this->db->query("select * from {$this->db->dbprefix('banner')} order by sort,id")->result_array();
	}

	function del_banner($id)
	{
		$img = $this->db->query("select img from {$this->db->dbprefix('banner')} where id={$id} limit 1")->row()->img;
		$this->del_img($img);
		$this->db->simple_query("delete from {$this->db->dbprefix('banner')} where id={$id}");
	}

	private function del_img($img)
	{
		$img_path = '../upload/web_img/'.$img;
		if($img != '' and file_exists($img_path))
		{
			unlink($img_path);
		}
	}

	function get_banner($banner_id)
	{
		return $this->db->query("select * from {$this->db->dbprefix('banner')} where id={$banner_id} limit 1")->row_array();
	}

	function save_banner($id, $info)
	{
		/*移动缩略图*/
		$new_img_exist = $this->new_img_exist($info['img']);
		if($new_img_exist)
		{
			rename('../upload/temp/'.$info['img'], '../upload/web_img/'.$info['img']);
		}

		if($id === 0)
		{
			$this->db->insert('banner', $info);
			$id = $this->db->insert_id();
		}
		else
		{
			if($new_img_exist)
			{
				$old_img = $this->db->query("select img from {$this->db->dbprefix('banner')} where id={$id} limit 1")->row()->img;
				@unlink('../upload/web_img/'.$old_img);
			}
			else
			{
				unset($info['img']);
			}
			$this->db->where('id', $id);
			$this->db->update('banner', $info);
		}
		return $id;
	}

	private function new_img_exist($img)
	{
		$img_path = '../upload/temp/'.$img;
		if($img != '' and file_exists($img_path)) return true;
		else return false;
	}

}