<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class phone extends MY_Controller {

	private $out_data;
	function __construct()
	{
		parent::__construct();
		parent::check_permission('phone');
		$this->out_data['site_url'] = parent::get_site_url();
		$this->out_data['cate_list'] = parent::get_category();
	}

	public function index()
	{
		$this->phone_list();
	}

	function phone_list($page = 1)
	{
		$this->out_data['con_page'] = 'phone_list';
		$limit = 15;
		$this->out_data['pagin'] = parent::get_pagin(base_url().'phone/phone_list/', $this->_get_phone_count(), $limit, 3);

		$this->out_data['phone_list'] = $this->_get_phone_list($page, $limit);
		$this->load->view('default', $this->out_data);
	}

	private function _get_phone_count()
	{
		return $this->db->query("select count(id) as num from {$this->db->dbprefix('phone_collect')}")->row()->num;
	}

	private function _get_phone_list($page, $limit)
	{
		$start = ($page - 1)*$limit;
		return $this->db->query("select * from {$this->db->dbprefix('phone_collect')} order by time desc limit {$start}, {$limit}")->result_array();
	}

	function del_phone()
	{
		if(!parent::is_post()) show_404();
		$id = (int)$this->input->post('id');
		$sql = "delete from {$this->db->dbprefix('phone_collect')} ";
		if($id != 0) $sql .= " where id={$id} limit 1 ";
		$this->db->simple_query($sql);
	}

	function download()
	{
		date_default_timezone_set('Asia/Chongqing');
		require_once dirname(__FILE__) . '/PHPExcel.php';
		$obj = new PHPExcel();
		$list = $this->db->select('name,phone,time,title,province')->from('phone_collect')->order_by('time desc')->get()->result_array();
		$obj->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$obj->getActiveSheet()
			->setCellValue('A1', '姓名')
			->setCellValue('B1', '电话')
			->setCellValue('C1', '添加时间')
			->setCellValue('D1', '页面标题')
			->setCellValue('E1', 'IP城市');
		foreach($list as $k => $v)
		{
			$obj->getActiveSheet()
				->setCellValue('A'.($k + 2), $v['name'])
				->setCellValue('B'.($k + 2), $v['phone'])
				->setCellValue('C'.($k + 2), $v['time'])
				->setCellValue('D'.($k + 2), $v['title'])
				->setCellValue('E'.($k + 2), $v['province']);
		}
		header("Content-Disposition:attachment;filename=手机号.xls");
        header("Content-Type:application/octet-stream");
        header("Content-Transfer-Encoding:binary");
        header("Pragma:no-cache");
        $objWriter = PHPExcel_IOFactory::createWriter($obj, 'Excel5');
        $objWriter->save('php://output');
	}
}