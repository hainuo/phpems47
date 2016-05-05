<?php

class app
{
	public $G;

	public function __construct(&$G)
	{
		$this->G = $G;
		$this->ev = $this->G->make('ev');
		$this->tpl = $this->G->make('tpl');
		$this->sql = $this->G->make('sql');
		$this->pdosql = $this->G->make('pdosql');

		$this->db = $this->G->make('pdodb');
		$this->pg = $this->G->make('pg');
		$this->html = $this->G->make('html');
		$this->files = $this->G->make('files');
		$this->session = $this->G->make('session');
		$this->category = $this->G->make('category');
		$this->content = $this->G->make('content','content');
		$this->user = $this->G->make('user','user');
		$this->_user = $_user = $this->session->getSessionUser();
		$this->tpl->assign('_user',$this->user->getUserById($this->_user['sessionuserid']));
		$rcats = $this->category->getCategoriesByArgs("catparent = '0'");
		$this->tpl->assign('rcats',$rcats);
	}

	public function index()
	{
		$catids = array();
		$catids['index'] = $this->category->getCategoriesByArgs(array(array("AND","catindex > 0")));
		$contents = array();
		if($catids['index'])
		{
			foreach($catids['index'] as $p)
			{
				$catstring = $this->category->getChildCategoryString($p['catid']);
				$contents[$p['catid']] = $this->content->getContentList(array(array("AND","find_in_set(contentcatid,:catstring)",'catstring',$catstring)),1,$p['catindex']?$p['catindex']:10);
			}
		}
		$favor = $this->G->make('favor','exam');
		$basic = $this->G->make('basic','exam');
		$students = array();
		$students['td'] = $favor->getBestStudentsToday();
		$students['tm'] = $favor->getBestStudentsThisMonth();
		$basics = array();
		$basics['hot'] = $basic->getBestBasics();
		$basics['new'] = $basic->getBasicList(1,6);
		$this->tpl->assign('basics',$basics);
 		$this->tpl->assign('students',$students);
		$this->tpl->assign('contents',$contents);
		$this->tpl->display('index');
	}

	public function category()
	{
		$page = $this->ev->get('page');
		$catid = $this->ev->get('catid');
		$cat = $this->category->getCategoryById($catid);
		if($cat['catuseurl'] && $cat['caturl'])
		header("location:".html_entity_decode($cat['caturl']));
		if($cat['catparent'])$catparent = $this->category->getCategoryById($cat['catparent']);
		$catbread = $this->category->getCategoryPos($catid);
		$catstring = $this->category->getChildCategoryString($catid);
		$catchildren = $this->category->getCategoriesByArgs(array(array('AND',"catparent = :catparent",'catparent',$catid),array('AND',"catinmenu = '0'")));
		$contents = $this->content->getContentList(array(array("AND","find_in_set(contentcatid,:contentcatid)",'contentcatid',$catstring)),$page);
		$catbrother = $this->category->getCategoriesByArgs(array(array('AND',"catparent = :catparent",'catparent',$cat['catparent']),array('AND',"catinmenu = '0'")));
		if($cat['cattpl'])$template = $cat['cattpl'];
		else $template = 'category_default';
		$this->tpl->assign('cat',$cat);
		$this->tpl->assign('page',$page);
		$this->tpl->assign('catbrother',$catbrother);
		$this->tpl->assign('catchildren',$catchildren);
		$this->tpl->assign('catparent',$catparent);
		$this->tpl->assign('catbread',$catbread);
		$this->tpl->assign('contents',$contents);
		$this->tpl->display($template);
	}

	public function content()
	{
		$page = $this->ev->get('page');
		$contentid = $this->ev->get('contentid');
		$content = $this->content->getContentById($contentid);
		if($content['contentlink'])header("location:".html_entity_decode($content['contentlink'])."");
		else
		{
			$catbread = $this->category->getCategoryPos($content['contentcatid']);
			$cat = $this->category->getCategoryById($content['contentcatid']);
			$catbrother = $this->category->getCategoriesByArgs(array(array('AND',"catparent = :catparent",'catparent',$cat['catparent']),array('AND',"catinmenu = '0'")));
			if($content['contenttemplate'])$template = $content['contenttemplate'];
			else $template = 'content_default';
			$nearContent = $this->content->getNearContentById($contentid,$content['contentcatid']);
			if(!$template)$template = 'content_default';
			$this->tpl->assign('cat',$cat);
			$this->tpl->assign('nearContent',$nearContent);
			$this->tpl->assign('page',$page);
			$this->tpl->assign('catbread',$catbread);
			$this->tpl->assign('content',$content);
			$this->tpl->assign('catbrother',$catbrother);
			$this->tpl->display($template);
		}
	}
}

?>