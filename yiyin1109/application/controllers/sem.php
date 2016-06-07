<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sem extends MY_Controller {

	private $out_data;
	function __construct()
	{
		parent::__construct();
		parent::check_permission('sem');
		$this->out_data['site_url'] = parent::get_site_url();
		$this->out_data['cate_list'] = parent::get_category();
	}

	public function index()
	{
		$this->record_list();
	}

	function record_list($start = '', $end = '', $is_submit = 2, $page = 1)
	{
		$this->out_data['record_list'] = array();
		$this->out_data['pagin'] = '';
		
		$start = urldecode($start);
		$end = urldecode($end);

		if($start == '' OR $end == '')
		{
			date_default_timezone_set('Asia/Shanghai');
			$start = date('Y-m-d 00:00:00');
			$end = date('Y-m-d H:i:s');
		}

		$page = (int)$page;
		$limit = 50;

		$tb = $this->db->dbprefix('sem_record');
		$count = $this->db->query("select 1 from {$tb} where time BETWEEN '{$start}' and '{$end}' and is_submit={$is_submit} ")->num_rows();
		$sql = "select * from {$this->db->dbprefix('sem_record')} where is_submit={$is_submit} and time BETWEEN '{$start}' and '{$end}' order by time desc limit ".($page - 1)*$limit.",{$limit}";
		$this->out_data['record_list'] = $this->db->query($sql)->result_array();

		$this->out_data['pagin'] = parent::get_pagin(base_url()."sem/record_list/{$start}/{$end}/{$is_submit}/", $count, $limit, 6);
		$this->out_data['con_page'] = 'sem_record_list';
		$this->out_data['start'] = $start;
		$this->out_data['end'] = $end;
		$this->out_data['is_submit'] = $is_submit;
		$this->load->view('default', $this->out_data);
	}

	function statistics($start = '', $end = '', $is_submit = 2)
	{
		$this->out_data['record_list'] = array();
		$this->out_data['record_num'] = 0;
		$start = urldecode($start);
		$end = urldecode($end);

		if($start == '' OR $end == '')
		{
			date_default_timezone_set('Asia/Shanghai');
			$start = date('Y-m-d 00:00:00');
			$end = date('Y-m-d H:i:s');
		}

		$tb = $this->db->dbprefix('sem_record');
		$sql = "select page,count(id) as total from {$tb} where time BETWEEN '{$start}' and '{$end}' and is_submit={$is_submit} group by page";
		$record_list = $this->db->query($sql)->result_array();
		foreach($record_list as $k => $v)
		{
			$sql = "select channel, count(channel) as num from {$tb} where page = '".$v['page']."' and time BETWEEN '{$start}' and '{$end}' and is_submit={$is_submit} group by channel";
			$record_list[$k]['detail'] = $this->db->query($sql)->result_array();
		}
		$this->out_data['record_list'] = $record_list;
		$this->out_data['record_num'] = $this->db->query("select 1 from {$tb} where time BETWEEN '{$start}' and '{$end}' and is_submit={$is_submit}")->num_rows();

		$this->out_data['con_page'] = 'sem_statistics';
		$this->out_data['start'] = $start;
		$this->out_data['end'] = $end;
		$this->out_data['is_submit'] = $is_submit;
		$this->load->view('default', $this->out_data);
	}

	function area($start = '', $end = '', $is_submit = 2)
	{
		$this->out_data['record_list'] = array();
		$this->out_data['record_num'] = 0;
		$start = urldecode($start);
		$end = urldecode($end);

		if($start == '' OR $end == '')
		{
			date_default_timezone_set('Asia/Shanghai');
			$start = date('Y-m-d 00:00:00');
			$end = date('Y-m-d H:i:s');
		}

		$tb = $this->db->dbprefix('sem_record');
		$sql = "select page,count(id) as total from {$tb} where time BETWEEN '{$start}' and '{$end}' and is_submit={$is_submit} group by page";
		$record_list = $this->db->query($sql)->result_array();
		foreach($record_list as $k => $v)
		{
			$sql = "select province, count(province) as num from {$tb} where page = '".$v['page']."' and time BETWEEN '{$start}' and '{$end}' and is_submit={$is_submit} group by province";
			$record_list[$k]['detail'] = $this->db->query($sql)->result_array();
		}
		$this->out_data['record_list'] = $record_list;
		$this->out_data['record_num'] = $this->db->query("select 1 from {$tb} where time BETWEEN '{$start}' and '{$end}' and is_submit={$is_submit}")->num_rows();

		$this->out_data['con_page'] = 'sem_area';
		$this->out_data['start'] = $start;
		$this->out_data['end'] = $end;
		$this->out_data['is_submit'] = $is_submit;
		$this->load->view('default', $this->out_data);
	}

	function keyword($start = '', $end = '', $is_submit = 2)
	{
		$this->out_data['record_list'] = array();
		$this->out_data['record_num'] = 0;
		$start = urldecode($start);
		$end = urldecode($end);

		if($start == '' OR $end == '')
		{
			date_default_timezone_set('Asia/Shanghai');
			$start = date('Y-m-d 00:00:00');
			$end = date('Y-m-d H:i:s');
		}

		$tb = $this->db->dbprefix('sem_record');
		$sql = "select keyword,count(id) as total from {$tb} where time BETWEEN '{$start}' and '{$end}' and is_submit={$is_submit} group by keyword";
		$record_list = $this->db->query($sql)->result_array();
		foreach($record_list as $k => $v)
		{
			$sql = "select page, count(page) as num from {$tb} where keyword = '".addslashes($v['keyword'])."' and time BETWEEN '{$start}' and '{$end}' and is_submit={$is_submit} group by page";
			$record_list[$k]['detail'] = $this->db->query($sql)->result_array();
		}
		$this->out_data['record_list'] = $record_list;
		$this->out_data['record_num'] = $this->db->query("select 1 from {$tb} where time BETWEEN '{$start}' and '{$end}' and is_submit={$is_submit}")->num_rows();

		$this->out_data['con_page'] = 'sem_keyword';
		$this->out_data['start'] = $start;
		$this->out_data['end'] = $end;
		$this->out_data['is_submit'] = $is_submit;
		$this->load->view('default', $this->out_data);
	}

}