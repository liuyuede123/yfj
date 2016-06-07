<?php

class md_category extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function get_category($cate_id)
	{
		$query = $this->db->query("select id,title,ename,site_title,site_keywords,site_description,url,intro,tpl,arc_tpl from {$this->db->dbprefix('category')} where id={$cate_id} limit 1");
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
			return array('id' => 0);
		}
	}

	function get_album_list($cate_id)
	{
		return $this->db->query("select id,img,text from {$this->db->dbprefix('cate_album')} where cate_id={$cate_id}")->result_array();
	}
	
	function get_art_album_list($art_id)
	{
		return $this->db->query("select id,art_id,img,text from {$this->db->dbprefix('art_img')} where art_id={$art_id}")->result_array();
	}

	function save_cate($id, $info)
	{
		$result = array('status' => false, 'msg' => '');
		$cate_url_exist = $this->db->query("select id from {$this->db->dbprefix('category')} where url='".$info['url']."' and id <> ".$id)->num_rows();
		$single_url_exist = $this->db->query("select id from {$this->db->dbprefix('single_page')} where url='".$info['url']."'")->num_rows();
		if($cate_url_exist > 0 OR $single_url_exist > 0)
		{
			$result['msg'] = '你所输入的URL已存在，请重新输入';
		}
		elseif($id === 0)
		{
			$this->db->insert('category', $info);
			$result['status'] = true;
			$result['id'] = $this->db->insert_id();
		}
		else
		{
			$this->db->where('id', $id);
			$this->db->update('category', $info);
			$result['status'] = true;
			$result['id'] = $id;
		}
		return $result;
	}

	function del_cate($id)
	{
		$result = array('status' => false, 'msg' => '');
		$arc_num = $this->db->query("select count(id) as num from {$this->db->dbprefix('article')} where cate_id={$id}")->row()->num;
		$album_num = $this->db->query("select count(id) as num from {$this->db->dbprefix('cate_album')} where cate_id={$id}")->row()->num;
		if($arc_num > 0)
		{
			$result['msg'] = '该分类下还有文章，请清空文章后再试';
		}
		elseif($album_num > 0)
		{
			$result['msg'] = '该分类下还有相册，请清空相册后再试';
		}
		else
		{
			$this->db->simple_query("delete from {$this->db->dbprefix('category')} where id={$id}");
			$result['status'] = true;
		}
		return $result;
	}

	function get_article_list($cate_id, $page = 1, $limit = 10)
	{
		$start = ($page - 1)*$limit;
		return $this->db->query("select id,title,click from {$this->db->dbprefix('article')} where cate_id={$cate_id} order by create_date desc,id desc limit {$start},{$limit}")->result_array();
	}

	function get_article_count($cate_id)
	{
		return $this->db->query("select count(id) as num from {$this->db->dbprefix('article')} where cate_id={$cate_id}")->row()->num;
	}

	function del_article($id)
	{
		$file = $this->db->query("select img,attach from {$this->db->dbprefix('article')} where id={$id} limit 1")->row();
		$this->del_img($file->img);
		$this->del_soft_file($file->attach);

		$this->db->simple_query("delete from {$this->db->dbprefix('article')} where id={$id}");
	}

	function get_article($article_id)
	{
		return $this->db->query("select * from {$this->db->dbprefix('article')} where id={$article_id} limit 1")->row_array();
	}

	function save_article($id, $info)
	{
		$now = date('Y-m-d');
		$info['update_date'] = $now;

		/*移动缩略图*/
		$new_img_exist = $this->new_img_exist($info['img']);
		if($new_img_exist)
		{
			rename('../upload/temp/'.$info['img'], '../upload/web_img/'.$info['img']);
		}
		/*移动附件*/
		$new_soft_exist = $this->new_soft_exist($info['attach']);
		if($new_soft_exist)
		{
			rename('../upload/temp/'.$info['attach'], '../upload/soft/'.$info['attach']);
		}

		if($id === 0)
		{
			$info['create_date'] = $now;
			$this->db->insert('article', $info);
			$id = $this->db->insert_id();
		}
		else
		{

			$file = $this->db->query("select img,attach from {$this->db->dbprefix('article')} where id={$id} limit 1")->row();
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
				$old_soft = $file->attach;
				$this->del_soft_file($old_soft);
			}
			else
			{
				unset($info['attach']);
			}

			$this->db->where('id', $id);
			$this->db->update('article', $info);
		}
		return $id;
	}

	private function get_article_img($article_id)
	{
		return $this->db->query("select img from {$this->db->dbprefix('article')} where id={$article_id}")->row()->img;
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

	function del_album($id)
	{
		$tb_album = $this->db->dbprefix('cate_album');
		$img = $this->db->query("select img from {$tb_album} where id={$id} limit 1")->row()->img;
		unlink('../upload/img/'.$img);
		$this->db->simple_query("delete from {$tb_album} where id={$id}");
	}
	
	function del_art_album($id)
	{
		$tb_album = $this->db->dbprefix('art_img');
		$img = $this->db->query("select img from {$tb_album} where id={$id} limit 1")->row()->img;
		unlink('../upload/img/'.$img);
		$this->db->simple_query("delete from {$tb_album} where id={$id}");
	}

	function save_text($id, $text)
	{
		$this->db->where('id', $id);
		$this->db->update('cate_album', array('text' => $text));
	}
	
	function save_art_text($id, $text)
	{
		$this->db->where('id', $id);
		$this->db->update('art_img', array('text' => $text));
	}
}