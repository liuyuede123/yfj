<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CCH
 */

/*返回分类URL*/
if(!function_exists('get_category_url'))
{
	function get_category_url($id)
	{
		$CI =& get_instance();
		$category = $CI->db->query("select url from {$CI->db->dbprefix('category')} where id={$id} limit 1");
		$base_url = base_url();
		if($category->num_rows() > 0)
		{
			return $base_url.$category->row()->url;
		}
		else
		{
			return $base_url;
		}
	}
}

/* 返回单页面URL*/
if(!function_exists('get_page_url'))
{
	function get_page_url($id)
	{
		$CI =& get_instance();
		$page = $CI->db->query("select url from {$CI->db->dbprefix('single_page')} where id={$id} limit 1");
		$base_url = base_url();
		if($page->num_rows() > 0)
		{
			return $base_url.$page->row()->url;
		}
		else
		{
			return $base_url;
		}
	}
}

/*返回分类的文章列表*/
if(!function_exists('get_article_list'))
{
	function get_article_list($cate_id, $limit = 1, $page = 0, $flag = '', $start = 0)
	{
		$CI =& get_instance();
		$cate_id = join(',', explode(',', $cate_id) );
		$sql = "select id,cate_id,title,create_date,img,intro,attach,flag,click from {$CI->db->dbprefix('article')} where cate_id IN({$cate_id})";
		if($flag != '')
		{
			$sql .= " and find_in_set('{$flag}', flag) ";
		}
		$sql .= " order by create_date desc, id desc";
		if($page === 0)
		{
			$sql .= " limit {$start},{$limit}";
		}
		else
		{
			$start = ($page - 1)*$limit;
			if($start < 0) $start = 0;
			$sql .= " limit {$start},{$limit}";
		}
		//cache
		$CI->db->cache_on();
		$list = $CI->db->query($sql)->result_array();
		foreach($list as $k => $v)
		{
			$list[$k]['url'] = get_category_url($v['cate_id']).'/'.$v['id'];
		}
		return $list;
	}
}

/*返回最新的文章*/
if(!function_exists('get_latest_article'))
{
	function get_latest_article($cate_id, $num = 1, $flag = '')
	{
		return get_article_list($cate_id, $num, 0, $flag);
	}
}

/*返回最热的文章*/
if(!function_exists('get_hot_article'))
{
	function get_hot_article($num = 1, $cate_id = 0, $except_cate = 0)
	{
		$CI = &get_instance();
		$CI->db->select('id,title,intro,create_date,img,cate_id');
		if($cate_id != 0) $CI->db->where('cate_id', $cate_id);
		if($except_cate != 0)  $CI->db->where('cate_id != ', $except_cate);
		//cache
		$CI->db->cache_on();
		$list = $CI->db->order_by('click desc, create_date desc')->get('article', $num, 0)->result_array();
		$cate_urls = array();
		foreach($list as $k => $v)
		{
			if(!isset($cate_urls[$v['cate_id']]))
			{
				$cate_urls[$v['cate_id']] = get_category_url($v['cate_id']);
			}
			$list[$k]['url'] = $cate_urls[$v['cate_id']].'/'.$v['id'];
			$temp = get_category($cate_id);
			$list[$k]['title'] = $temp['title'];
		}
		return $list;
	}
}

if(! function_exists('get_relation_article'))
{
	/**
	 * 返回特定类型的相关文章
	 * @param  int $article_id 当前文章id
	 * @param  string $type    相关文章的特定类型，可选值：pre|next
	 * @return array           结果文章的链接和标题
	 */
	function get_relation_article($article_id, $type = 'pre')
	{
		$cur_article = get_article($article_id);
		$CI =& get_instance();
		$sql = "select id,title from {$CI->db->dbprefix('article')} where cate_id={$cur_article->cate_id} ";
		if($type == 'pre')
		{
			$sql .= " and create_date <= '{$cur_article->create_date}' and id < {$article_id} order by create_date desc, id desc limit 1";
		}
		elseif($type == 'next')
		{
			$sql .= " and create_date >= '{$cur_article->create_date}' and id > {$article_id} order by create_date, id limit 1";
		}
		$list = $CI->db->query($sql)->result_array();
		if(count($list) > 0)
		{
			$list[0]['url'] = get_category_url($cur_article->cate_id).'/'.$list[0]['id'];
			return $list[0];
		}
		else
		{
			return array('title' => '无', 'url' => 'javascript:');
		}
	}
}

/*返回文章列表的分页信息*/
if(!function_exists('get_pagin'))
{
	function get_pagin($cate_id, $limit, $flag = '', $uri_segment = 3)
	{
		$CI =& get_instance();
		$CI->load->library('pagination');

		$config['base_url'] = ($flag == '') ? get_category_url($cate_id).'/page/' : get_category_url($cate_id).'/flag/'.$flag.'/page/';
		$config['total_rows'] = get_article_num($cate_id, $flag);
		$config['per_page'] = $limit;
		// $config['uri_segment'] = $uri_segment;
		$config['uri_segment'] = $uri_segment;
		$config['use_page_numbers'] = TRUE;

		$config['full_tag_open'] = '<ul class="news_page_change_ul">';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a><strong>';
		$config['cur_tag_close'] = '</strong></a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['first_link'] = '首页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';
		$config['last_link'] = '尾页';

		$CI->pagination->initialize($config); 

		return $CI->pagination->create_links();
	}
}

/*返回分类文章总数*/
if( ! function_exists('get_article_num'))
{
	function get_article_num($cate_id, $flag = '')
	{
		$CI =& get_instance();
		$sql = "select count(id) as num from {$CI->db->dbprefix('article')} where cate_id={$cate_id} ";
		if($flag != '') $sql .= " and find_in_set('{$flag}', flag)";
		//cache
		$CI->db->cache_on();
		return $CI->db->query($sql)->row()->num;
	}
}

/*返回分类信息*/
if(!function_exists('get_category'))
{
	function get_category($cate_id)
	{
		$cate_id = $cate_id==''? 0 : $cate_id;
		$CI =& get_instance();
		//cache
		$CI->db->cache_on();
		$cate = $CI->db->query("select ename,id,title,intro,url from {$CI->db->dbprefix('category')} where id in ({$cate_id}) order by find_in_set(id,'{$cate_id}')");
		if($cate->num_rows()==1){
			return $cate->row_array();
		}else if($cate->num_rows()>1){
			return $cate->result_array();
		}else{
			return '';
		}
	}
}

/*返回单页信息*/
if(!function_exists('get_page'))
{
	function get_page($page_id)
	{
		$page_id = $page_id==''?0:$page_id;
		$CI =& get_instance();
		//cache
		$CI->db->cache_on();
		$page = $CI->db->query("select id,title,content,description,url from {$CI->db->dbprefix('single_page')} where id in ({$page_id}) order by find_in_set(id,'{$page_id}')");
		if($page->num_rows()==1){
			return $page->row_array();
		}else if($page->num_rows()>1){
			return $page->result_array();
		}else{
			return '';
		}
		
	}
}


/*返回文章信息*/
if( ! function_exists('get_article'))
{
	function get_article($id)
	{
		$CI =& get_instance();
		//cache
		$CI->db->cache_on();
		return $CI->db->query("select cate_id,title,content,intro,create_date,img,attach from {$CI->db->dbprefix('article')} where id={$id}")->row_array();
	}
}

/*返回首页banner列表*/
if(!function_exists('get_banner_list'))
{
	function get_banner_list($limit = 5)
	{
		$CI =& get_instance();
		return $CI->db->query("select title,img,url from {$CI->db->dbprefix('banner')} order by sort,id limit {$limit}")->result_array();
	}
}

/*返回分类相册*/
if( ! function_exists('get_album_list'))
{
	function get_album_list($id)
	{
		$CI =& get_instance();
		//cache
		$CI->db->cache_on();
		return $CI->db->query("select text,img from {$CI->db->dbprefix('cate_album')} where cate_id={$id}")->result_array();
	}
}

/*返回活动相册*/
if( ! function_exists('get_art_album_list'))
{
	function get_art_album_list($id)
	{
		$CI =& get_instance();
		//cache
		$CI->db->cache_on();
		return $CI->db->query("select text,img from {$CI->db->dbprefix('art_img')} where art_id={$id}")->result_array();
	}
}

/*返回系统配置*/
if(!function_exists('get_website_config'))
{
	function get_website_config()
	{
		$CI =& get_instance();
		$config = $CI->db->query("select attr,value from {$CI->db->dbprefix('config')}")->result_array();
		$result = array();

		foreach($config as $v)
		{
			$result[$v['attr']] = $v['value'];
		}
		return $result;
	}
}

/*返回软件列表*/
if(!function_exists('get_soft_list'))
{
	function get_soft_list()
	{
		$CI =& get_instance();
		return $CI->db->query("select title,soft,content,img from {$CI->db->dbprefix('soft')}")->result_array();
	}
}

/*获取中文之间*/
if(!function_exists('get_chinese_date'))
{
	function get_chinese_date($date = '')
	{
		date_default_timezone_set('Asia/Shanghai');
		$arcdate = ($date=='')?date('Y-m-d'):$date;
		$arcdate = strtotime($arcdate);
		$nowdate = strtotime(date('Y-m-d'));
		//距离现在有多少天
		$resdate = ($nowdate-$arcdate)/(3600*24);
		if($resdate==0){
			$resdate='当';
		}else{
			$resdate=$resdate.'天';
		}
		return $resdate;
	}
}

/*获取视频*/
if(!function_exists('get_video_list'))
{
	function get_video_list($num = 1)
	{
		$CI =& get_instance();
		return $CI->db->query("select id,title,img from {$CI->db->dbprefix('video')} limit {$num}")->result_array();
	}
}

/*获取视频*/
if(!function_exists('get_video_id'))
{
	function get_video_id($id = 1)
	{
		$CI =& get_instance();
		return $CI->db->query("select id,title,img from {$CI->db->dbprefix('video')} where id={$id} limit 1")->result_array();
	}
}

if(!function_exists('get_calendar_list'))
{
	function get_calendar_list($limit = 5)
	{
		$CI =& get_instance();
		// return $CI->db->query("select date,time,areaname,indexname,importantlever,nextvalue,prevalue,economicdata from {$CI->db->dbprefix('calendar')} where date=DATE_FORMAT(NOW(), '%Y-%m-%d') order by time desc limit {$limit}")->result_array();
		return $CI->db->query("select date,time,areaname,indexname,importantlever,nextvalue,prevalue,economicdata from {$CI->db->dbprefix('calendar')} order by time desc limit {$limit}")->result_array();
	}
}


function sysSubStr($string,$length,$append = false) 
{ 
    if(strlen($string) <= $length ) 
    { 
        return $string; 
    } 
    else 
    { 
        $i = 0; 
        while ($i < $length) 
        { 
            $stringTMP = substr($string,$i,1); 
            if ( ord($stringTMP) >=224 ) 
            { 
                $stringTMP = substr($string,$i,3); 
                $i = $i + 3; 
            } 
            elseif( ord($stringTMP) >=192 ) 
            { 
                $stringTMP = substr($string,$i,2); 
                $i = $i + 2; 
            } 
            else 
            { 
                $i = $i + 1; 
            } 
            $stringLast[] = $stringTMP; 
        } 
        $stringLast = implode("",$stringLast); 
        if($append) 
        { 
            $stringLast .= "..."; 
        } 
        return $stringLast; 
    } 
}


if( ! function_exists('encrypt') )
{
	function encrypt($str)
	{
		$CI =& get_instance();
		$CI->load->library('encrypt');
		$CI->encrypt->set_cipher(MCRYPT_RIJNDAEL_128);
		return $CI->encrypt->encode($str);
	}
}

if( ! function_exists('decrypt') )
{
	function decrypt($str)
	{
		$CI =& get_instance();
		$CI->load->library('encrypt');
		$CI->encrypt->set_cipher(MCRYPT_RIJNDAEL_128);
		return $CI->encrypt->decode($str);
	}
}