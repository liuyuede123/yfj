<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class wenjuan extends MY_Controller {

	private $out_data;
	function __construct()
	{
		parent::__construct();
		$this->out_data['site_url'] = parent::get_site_url();
		$this->out_data['cate_list'] = parent::get_category();
	}

	public function index()
	{
		$this->get_wenjuan();
	}

	function get_wenjuan()
	{
		$this->out_data['con_page'] = 'get_wenjuan';
		$this->load->view('default', $this->out_data);
	}

	function get_excel()
	{
		if($this->input->post('get_excel') == 1)
		{
			require_once 'PHPExcel.php';  
			include "PHPExcel/Writer/IWriter.php";   
			include "PHPExcel/Writer/Excel5.php";   
			include 'PHPExcel/IOFactory.php';   
			//上面的四句代码是引入所需要的库， 

			$objPHPExcel = new PHPExcel();
		
			$a1 = '姓名';  //这是两个标头  就是列名，最上面的那个  
			$a2 = '实盘账号';  
			$a3 = '直播室来源';  
			$a4 = '直播室关键词';  
			$a5 = '关注直播室时间';  
			$a6 = '选择本公司原因';  
			$a7 = '其他直播室';  
			$a8 = '投资原因';  
			$a9 = '提交问卷时间';  
			$a10 = '公司内部';  
			
			//$a1=iconv("utf-8","gb2312",$a1);  //如果是乱码的话，则需要转换下  
			//$a2=iconv("utf-8","gb2312",$a2);  
			$objPHPExcel->getActiveSheet()->setCellValue('a1', $a1);//设置列的值  
			$objPHPExcel->getActiveSheet()->setCellValue('b1', $a2);  
			$objPHPExcel->getActiveSheet()->setCellValue('c1', $a3);  
			$objPHPExcel->getActiveSheet()->setCellValue('d1', $a4);  
			$objPHPExcel->getActiveSheet()->setCellValue('e1', $a5);  
			$objPHPExcel->getActiveSheet()->setCellValue('f1', $a6);  
			$objPHPExcel->getActiveSheet()->setCellValue('g1', $a7);  
			$objPHPExcel->getActiveSheet()->setCellValue('h1', $a8);  
			$objPHPExcel->getActiveSheet()->setCellValue('i1', $a9);  
			$objPHPExcel->getActiveSheet()->setCellValue('j1', $a10);   
			
			/* 设置实盘账号格式为纯数字，解决科学计数法问题，参考PHPExcel/Style/NumberFormat.php */
			$objPHPExcel->getActiveSheet()->getStyle('b')->getNumberFormat()->setFormatCode('000000000000000');
			
			$result = $this->db->query("select * from {$this->db->dbprefix('wenjuan')}")->result_array();//连接数据库的就不用多解释了  
			$i = 2; //自增变量，用来控制行，因为标头占的第一行，所以这里从第二行开始  
			foreach($result as $v)
			{
				$zb_name = $v['zb_name'];  
				$zb_id = $v['zb_id'];  
				$zb_source = $v['zb_source'];  
				$zb_keyword = $v['zb_keyword'];  
				$zb_time = $v['zb_time'];  
				$zb_reason = $v['zb_reason'];  
				$zb_another = $v['zb_another'];  
				$touzi_reason = $v['touzi_reason'];  
				$create_date = $v['create_date'];  
				$flag = $v['flag'];  
				//$i++;   
				//$id=iconv("utf8","gb2312",$id);  
				//$cname = iconv("utf8","gb2312",$cname);  
				$objPHPExcel->getActiveSheet()->setCellValue('a'.$i, $zb_name);  
				$objPHPExcel->getActiveSheet()->setCellValue('b'.$i, $zb_id);  
				$objPHPExcel->getActiveSheet()->setCellValue('c'.$i, $zb_source);  
				$objPHPExcel->getActiveSheet()->setCellValue('d'.$i, $zb_keyword);  
				$objPHPExcel->getActiveSheet()->setCellValue('e'.$i, $zb_time);  
				$objPHPExcel->getActiveSheet()->setCellValue('f'.$i, $zb_reason);  
				$objPHPExcel->getActiveSheet()->setCellValue('g'.$i, $zb_another);  
				$objPHPExcel->getActiveSheet()->setCellValue('h'.$i, $touzi_reason);  
				$objPHPExcel->getActiveSheet()->setCellValue('i'.$i, $create_date);  
				$objPHPExcel->getActiveSheet()->setCellValue('j'.$i, $flag);//这些跟上面的一样，开始一行一行的赋值。  
				$i++;     
			}  
			
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);//设置宽度  
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);  
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);  
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);  
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);  
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);  
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);  
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);  
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);  
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);  
			
			//设置字体，颜色等
			$styleArray1 = array(
			  'font' => array(
				'bold' => true,
				'size'=>12,
				'color'=>array(
				  'argb' => '0gfd000d',
				),
			  ),
			  'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			  ),
			);
			// 将A1单元格设置为加粗，居中
			$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray1);
			$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray1);
			$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray1);
			$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray1);
			$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray1);
			$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleArray1);
			$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleArray1);
			$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($styleArray1);
			$objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($styleArray1);
			$objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($styleArray1);
			  
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  //创建表格类型，目前支持老版的excel5,和excel2007,也支持生成html,pdf,csv格式  
			
			$wen_path = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']).'file/wenjuan.xls';
			
			/* echo $wen_path;
			exit; */
			$objWriter->save($wen_path);//保存生成  
			
			if(file_exists($wen_path))
			{
				
				//ajax返回参数
				echo base_url().'wenjuan/get_excel_download/?file=wenjuan.xls';
				//echo "成功生成excel，点击获取";
			}
		}
	}
	
	 public function get_excel_download(){
		$file = $this->input->get('file');
		$file = $file = base_url().'file/'.$file;
		header('Content-Description: File Download');
		header('Content-type: application.octet-stream');
		header('Content-Disposition: attachment; filename='.basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		//header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);
	} 



}