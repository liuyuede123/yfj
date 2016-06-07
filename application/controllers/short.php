<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class short extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$uri = explode('/', $this->uri->uri_string());
		$uri = $this->_get_uri_info($uri);
		$this->$uri['method']($uri['param']);
	}

	private function _get_uri_info($uri)
	{
		$result = array();
		/*判断是分类还是单页面*/
		$category = $this->db->query("select id from {$this->db->dbprefix('category')} where url='{$uri[0]}'");
		if($category->num_rows() > 0)
		{
			if(isset($uri[1]) AND is_numeric($uri[1]))
			{
				/*如果第二段为整数，则是文章页*/
				$article_id = (int)$uri[1];
				if($article_id > 0)
				{
					$result['method'] = '_article';
					$result['param'] = $article_id;
				}
				else
				{
					show_404();
				}
			}
			else
			{
				/*否则先确定为列表页*/
				$result['param']['id'] = $category->row()->id;
				$result['method'] = '_category_list';

				$result['param']['page'] = 1;
				// $result['param']['flag'] = 'd';
				for($i = 1; $i < 5; $i += 2)
				{
					if(isset($uri[$i]))
					{
						$result['param'][$uri[$i]] = isset($uri[$i+1]) ? $uri[$i+1] : '';
					}
				}
			}
		}
		else
		{
			/*判断是否存在该url的单页面*/
			$page = $this->db->query("select id from {$this->db->dbprefix('single_page')} where url='{$uri[0]}'");
			if($page->num_rows() > 0)
			{
				$result['method'] = '_page';
				$result['param'] = $page->row()->id;
			}
			else
			{
				show_404();
			}
		}
		return $result;
	}

	/*分类列表*/
	private function _category_list($param)
	{
		$category = $this->db->query("select id,url,ename,title,intro,site_title,site_keywords,site_keywords,site_description,tpl from {$this->db->dbprefix('category')} where id={$param['id']}")->row_array();
		$cate = array_merge($param, $category);

		$cate['bread'][] = array('name' => $cate['title'], 'link' => get_category_url($cate['id']));
		$this->load->view($cate['tpl'], $cate);
	}

	/*文章页*/
	private function _article($article_id)
	{
		$article = $this->db->query("select c.title as catetitle,c.ename as cateename,a.cate_id as cateid,c.url,c.arc_tpl,a.id,a.title,a.site_title,a.site_keywords,a.site_description,a.tags from {$this->db->dbprefix('article')} as a inner join {$this->db->dbprefix('category')} as c on a.cate_id=c.id where a.id={$article_id}");
		if($article->num_rows() > 0)
		{
			$this->db->simple_query("update {$this->db->dbprefix('article')} set click = click + 1 where id = {$article_id}");
			$param = $article->row_array();
			$param['bread'][] = array('name' => $param['title'], 'link' => base_url().$param['url']);
			$param['bread'][] = array('name' => $param['title'], 'link' => base_url().$param['url'].'/'.$param['id']);
			$this->load->view($param['arc_tpl'], $param);
		}
		else
		{
			show_404();
		}
	}

	/*单页面*/
	private function _page($page_id)
	{
		$page = $this->db->query("select id,url,title,ename,content,site_keywords,description,site_description,tpl from {$this->db->dbprefix('single_page')} where id={$page_id} limit 1")->row_array();
		$page['bread'][] = array('name' => $page['title'], 'link' => get_page_url($page['id']));
		$this->load->view($page['tpl'], $page);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */