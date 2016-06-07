<?php

class md_video extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function get_video_list($cate_id, $page, $limit)
	{
		$start = ($page - 1)*$limit;
		$sql = "select id,title,date,click from {$this->db->dbprefix('video')} ";
		if($cate_id != 0)
		{
			$sql .= " where cate_id = {$cate_id} ";
		}
		$sql .= " order by date desc,id desc limit {$start},{$limit}";
		return $this->db->query($sql)->result_array();
	}

	function get_video_count($cate_id)
	{
		$sql = "select count(id) as num from {$this->db->dbprefix('video')} ";
		if($cate_id != 0)
		{
			$sql .= " where cate_id = {$cate_id} ";
		}
		return $this->db->query($sql)->row()->num;
	}

	function get_video($video_id)
	{
		return $this->db->query("select * from {$this->db->dbprefix('video')} where id={$video_id} limit 1")->row_array();
	}

	function del_video($id)
	{
		$file = $this->db->query("select img from {$this->db->dbprefix('video')} where id={$id} limit 1")->row();
		$this->del_img($file->img);
		$this->db->simple_query("delete from {$this->db->dbprefix('video')} where id={$id}");
	}

	private function del_img($img)
	{
		$img_path = '../upload/img/'.$img;
		if($img != '' and file_exists($img_path))
		{
			unlink($img_path);
		}
	}

	function save_video($id, $info)
	{
		/*移动缩略图*/
		$new_img_exist = $this->new_img_exist($info['img']);
		if($new_img_exist)
		{
			rename('../upload/temp/'.$info['img'], '../upload/img/'.$info['img']);
		}

		if($id === 0)
		{
			$this->db->insert('video', $info);
			$id = $this->db->insert_id();
		}
		else
		{
			$file = $this->db->query("select img from {$this->db->dbprefix('video')} where id={$id} limit 1")->row();
			if($new_img_exist)
			{
				$old_img = $file->img;
				$this->del_img($old_img);
			}
			else
			{
				unset($info['img']);
			}

			unset($info['date']);
			$this->db->where('id', $id);
			$this->db->update('video', $info);
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