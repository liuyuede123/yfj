<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->edit();
	}

	function edit()
	{
		$this->out_data['site_url'] = parent::get_site_url();
		$this->out_data['cate_list'] = parent::get_category();
		$this->out_data['info'] = $this->db->select('name,nick,intro,avatar')->from('admin')->where('id', $this->session->userdata('id'))->get()->row_array();
		$this->out_data['con_page'] = 'edit_my';
		$this->load->view('default', $this->out_data);
	}

	function save_user()
	{
		$result = array('status' => false, 'msg' => '');
		$name = $this->input->post('name');
		$nick = $this->input->post('nick');
		$avatar = $this->input->post('avatar');
		$intro = $this->input->post('intro');
		$password = $this->input->post('password');
		$id = $this->session->userdata('id');
		$is_exist = $this->db->select('id')->from('admin')->where("id <> {$id} and name='{$name}'")->get()->num_rows();
		if($is_exist > 0)
		{
			$result['msg'] = '该用户名已存在，请重新输入';
		}
		else
		{
			$update = array('name' => $name, 'nick' => $nick, 'intro' => $intro );
			if( !empty($password) )
			{
				$update['password'] = md5($password);
			}

			/*上传头像*/
			$new_avatar_exist = $this->new_avatar_exist($avatar);
			if($new_avatar_exist)
			{
				rename('../upload/temp/'.$avatar, '../avatar/admin/'.$avatar);
				$query = $this->db->select('avatar')->from('admin')->where( array('id' => $id) )->get();
				if($query->num_rows() > 0)
				{
					$old_avatar = $query->row()->avatar;
					$this->del_avatar($old_avatar);
				}
				$update['avatar'] = $avatar;
			}

			$this->db->update('admin', $update, "id = {$id}");
			$result['status'] = true;
			$result['msg'] = '保存成功';
			$this->session->set_userdata('nick', $nick);
		}
		echo json_encode($result);
	}

	private function new_avatar_exist($img)
	{
		$img_path = '../upload/temp/'.$img;
		if($img != '' and file_exists($img_path)) return true;
		else return false;
	}

	private function del_avatar($img)
	{
		$img_path = '../avatar/admin/'.$img;
		if($img != '' and file_exists($img_path))
		{
			unlink($img_path);
		}
	}
}