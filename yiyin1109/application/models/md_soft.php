<?php

class md_soft extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function get_soft_list()
	{
		return $this->db->query("select id,title from {$this->db->dbprefix('soft')} order by id")->result_array();
	}

	function del_soft($id)
	{
		$file = $this->db->query("select img,soft from {$this->db->dbprefix('soft')} where id={$id} limit 1")->row();
		$this->del_img($file->img);
		$this->del_soft_file($file->soft);
		$this->db->simple_query("delete from {$this->db->dbprefix('soft')} where id={$id}");
	}

	private function del_img($img)
	{
		$img_path = '../upload/web_img/'.$img;
		if($img != '' and file_exists($img_path))
		{
			unlink($img_path);
		}
	}

	private function del_soft_file($soft)
	{
		$soft_path = '../upload/soft/'.$soft;
		if($soft != '' and file_exists($soft_path))
		{
			unlink($soft_path);
		}
	}

	function get_soft($soft_id)
	{
		return $this->db->query("select * from {$this->db->dbprefix('soft')} where id={$soft_id} limit 1")->row_array();
	}

	function save_soft($id, $info)
	{
		/*移动缩略图*/
		$new_img_exist = $this->new_img_exist($info['img']);
		if($new_img_exist)
		{
			rename('../upload/temp/'.$info['img'], '../upload/web_img/'.$info['img']);
		}

		/*移动软件*/
		$new_soft_exist = $this->new_soft_exist($info['soft']);
		if($new_soft_exist)
		{
			rename('../upload/temp/'.$info['soft'], '../upload/soft/'.$info['soft']);
		}

		if($id === 0)
		{
			$this->db->insert('soft', $info);
			$id = $this->db->insert_id();
		}
		else
		{
			$file = $this->db->query("select img,soft from {$this->db->dbprefix('soft')} where id={$id} limit 1")->row();
			if($new_img_exist)
			{
				$old_img = $file->img;
				$this->del_img($old_img);
			}
			else
			{
				unset($info['img']);
			}

			if($new_soft_exist)
			{
				$old_soft = $file->soft;
				$this->del_soft_file($old_soft);
			}
			else
			{
				unset($info['soft']);
			}

			$this->db->where('id', $id);
			$this->db->update('soft', $info);
		}
		return $id;
	}

	private function new_img_exist($img)
	{
		$img_path = '../upload/temp/'.$img;
		if($img != '' and file_exists($img_path)) return true;
		else return false;
	}

	private function new_soft_exist($soft)
	{
		$soft_path = '../upload/temp/'.$soft;
		if($soft != '' and file_exists($soft_path)) return true;
		else return false;
	}

}