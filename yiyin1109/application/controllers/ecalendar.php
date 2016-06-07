<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ecalendar extends MY_Controller {

	private $out_data;
	function __construct()
	{
		parent::__construct();
		parent::check_permission('base');
		$this->out_data['site_url'] = parent::get_site_url();
		$this->out_data['cate_list'] = parent::get_category();
	}

	public function index()
	{
		$this->ecalendar_list();
	}

	function ecalendar_list($page = 1)
	{
		$this->load->model('md_ecalendar');

		$page = (int)$page;
		$limit = 20;
		$ecalendar_count = $this->md_ecalendar->get_ecalendar_count();
		$this->out_data['pagin'] = parent::get_pagin(base_url().'ecalendar/ecalendar_list/', $ecalendar_count, $limit, 3);

		$this->out_data['con_page'] = 'ecalendar_list';
		
		$this->out_data['ecalendar_list'] = $this->md_ecalendar->get_ecalendar_list($page, $limit);
		$this->load->view('default', $this->out_data);
	}

	// function del_ecalendar()
	// {
	// 	if(!parent::is_post()) show_404();
	// 	$id = (int)$this->input->post('id');
	// 	$this->load->model('md_ecalendar');
	// 	$this->md_ecalendar->del_ecalendar($id);
	// }

	// function edit_ecalendar($ecalendar_id = 0)
	// {
	// 	$ecalendar_id = (int)$ecalendar_id;

	// 	$this->load->model('md_ecalendar');
	// 	$ecalendar_info = $this->md_ecalendar->get_ecalendar($ecalendar_id);

	// 	$this->out_data['ecalendar_info'] = $ecalendar_info;
	// 	$this->out_data['con_page'] = 'edit_ecalendar';
	// 	$this->load->view('default', $this->out_data);
	// }

	// function save_ecalendar()
	// {
	// 	if(!parent::is_post()) show_404();
	// 	$info = array(
	// 	'title' => $this->input->post('title'),
	// 	'info' => $this->input->post('info'),
	// 	'datetime' => $this->input->post('datetime'));
	// 	$id = (int)$this->input->post('id');
	// 	$this->load->model('md_ecalendar');
	// 	echo $this->md_ecalendar->save_ecalendar($id, $info);
	// }

	function collection()
	{
		$date = date("Y-m-d");
		$url = 'http://www.wm927.com/extend/server/calendar?day='.$date.'&area=USD%2CGBP%2CNZD%2CITL%2CAUD%2CCAD%2CCHF%2CFRF%2CPTE%2CDEM%2CKRW%2CJPY%2CESP%2CCNY%2CEUR&level=hight%2Cmiddle%2Clow&_='.time();
		$list = json_decode(file_get_contents($url));
		$this->db->empty_table('calendar');
		if(count($list->calandarList) > 0) $this->_analyse_insert_calendar($list->calandarList);
		if(count($list->unPublishDataList) > 0) $this->_analyse_insert_calendar($list->unPublishDataList);
		if(isset($list->publishDataList)) $this->_analyse_insert_calendar($list->publishDataList);
	}

	function _analyse_insert_calendar($data)
	{
		$list_data = array();
		$date = date("Y-m-d");
		foreach($data as $v)
		{
			$list_data[] = "({$v->id},'{$date}','{$v->newtime}','{$v->areaname}','{$v->indexname}',{$v->importantlever},'{$v->nextvalue}','{$v->prevalue}','{$v->economicdata}')";
		}
		$list_data = join(',', $list_data);
		$sql = "insert into {$this->db->dbprefix('calendar')}(cid,date,time,areaname,indexname,importantlever,nextvalue,prevalue,economicdata) values {$list_data} ON DUPLICATE KEY UPDATE nextvalue=values(nextvalue),prevalue=values(prevalue),economicdata=values(economicdata) ";
		$this->db->query($sql);
	}
}