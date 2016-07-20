<?php

class app
{
	public $G;

	public function __construct(&$G)
	{
		$this->G = $G;
		$this->G = $G;
		$this->ev = $this->G->make('ev');
		$this->session = $this->G->make('session');
		$this->tpl = $this->G->make('tpl');
		$this->sql = $this->G->make('sql');
		$this->pdosql = $this->G->make('pdosql');
		$this->db = $this->G->make('pdodb');
		$this->category = $this->G->make('category');
		$this->html = $this->G->make('html');
		$this->module = $this->G->make('module');
		$this->apps = $this->G->make('apps','core');
		$this->user = $this->G->make('user','user');
		$this->_user = $_user = $this->session->getSessionUser();
		$group = $this->user->getGroupById($_user['sessiongroupid']);
		if($group['groupid'] != 1)
		{
			if($this->ev->get('userhash'))
			exit(json_encode(array(
				'statusCode' => 300,
				"message" => "请您重新登录",
			    "callbackType" => 'forward',
			    "forwardUrl" => "index.php?core-master-login"
			)));
			else
			{
				header("location:index.php?core-master-login");
				exit;
			}
		}
		$localapps = $this->apps->getLocalAppList();
		$apps = $this->apps->getAppList();
		$this->tpl->assign('localapps',$localapps);
		$this->tpl->assign('apps',$apps);
		$modules = $this->module->getModulesByApp('content');
		$groups = $this->user->getUserGroups();
		$this->tpl->assign('_user',$this->user->getUserById($_user['sessionuserid']));
		$this->tpl->assign('modules',$modules);
		$this->tpl->assign('groups',$groups);
		$this->tpl->assign('userhash',$this->ev->get('userhash'));
		$this->content = $this->G->make('content','content');
		$this->block = $this->G->make('block','content');
		//$this->position = $this->G->make('position','content');
	}

	public function index()
	{
		$subaction = $this->ev->url(3);
		switch($subaction)
		{
			default:
			$this->tpl->display('index');
		}
	}

	public function ad()
	{
		$subaction = $this->ev->url(3);
		switch($subaction)
		{
			case 'modify':
			if($this->ev->get('modifyad'))
			{
				$args = $this->ev->get('args');
				$args['adstyle'] = $args['adstyle'];
				$adid = $this->ev->get('adid');
				$this->ad->modifyAd($adid,$args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "target" => "",
				    "rel" => "",
				    "callbackType" => "forward",
				    "forwardUrl" => "?content-master-ad&page={$page}"
				);
				exit(json_encode($message));
			}
			else
			{
				$adid = $this->ev->get('adid');
				$ad = $this->ad->getAdById($adid);
				$this->tpl->assign('ad',$ad);
				$this->tpl->display('ad_modify');
			}
			break;

			default:
			$page = 1;
			$ads = $this->ad->getAdList(1,$page);
			$this->tpl->assign('ads',$ads);
			$this->tpl->display('ad');
			break;
		}
	}

	public function blocks()
	{
		$subaction = $this->ev->url(3);
		$page = $this->ev->get('page');
		switch($subaction)
		{
			case 'modify':
			if($this->ev->get('modifyblock'))
			{
				$blockid = $this->ev->get('blockid');
				$args = $this->ev->get('args');
				$args['blockcontent'] = $args['blockcontent'];
				unset($args['blocktype']);
				$this->block->modifyBlock($blockid,$args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "target" => "",
				    "rel" => "",
				    "callbackType" => "forward",
				    "forwardUrl" => "index.php?content-master-blocks&page={$page}"
				);
				exit(json_encode($message));
			}
			else
			{
				$blockid = $this->ev->get('blockid');
				$block = $this->block->getBlockById($blockid);
				$block['blockcontent'] = $this->ev->stripSlashes($block['blockcontent']);
				$apps = $this->apps->getAppList();
				$blockapps = array();
				foreach($apps as $id => $app)
				{
					$tmp = $this->G->make('api',$app['appid']);
					if($tmp && method_exists($tmp,'parseBlock'))
					$blockapps[$id] = $app;
				}
				$this->tpl->assign('block',$block);
				$this->tpl->assign('blockapps',$blockapps);
				$this->tpl->assign('page',$page);
				$this->tpl->display('blocks_modify');
			}
			break;

			case 'add':
			if($this->ev->get('addblock'))
			{
				$args = $this->ev->get('args');
				$args['blockcontent'] = $args['blockcontent'];
				$this->block->addBlock($args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "target" => "",
				    "rel" => "",
				    "callbackType" => "forward",
				    "forwardUrl" => "index.php?content-master-blocks"
				);
				exit(json_encode($message));
			}
			else
			{
				$apps = $this->apps->getAppList();
				$blockapps = array();
				foreach($apps as $id => $app)
				{
					$tmp = $this->G->make('api',$app['appid']);
					if($tmp && method_exists($tmp,'parseBlock'))
					$blockapps[$id] = $app;
				}
				$this->tpl->assign('block',$block);
				$this->tpl->assign('blockapps',$blockapps);
				$this->tpl->display('blocks_add');
			}
			break;

			case 'del':
			$blockid = $this->ev->get('blockid');
			$this->block->delBlock($blockid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
			    "target" => "",
			    "rel" => "",
			    "callbackType" => "forward",
			    "forwardUrl" => "index.php?content-master-blocks&page={$page}"
			);
			exit(json_encode($message));
			break;

			case 'change':
			$blockid = $this->ev->get('blockid');
			$blocktype = $this->ev->get('blocktype');
			$this->block->modifyBlock($blockid,array('blocktype' => $blocktype));
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
			    "target" => "",
			    "rel" => "",
			    "callbackType" => "forward",
			    "forwardUrl" => "index.php?content-master-blocks&page={$page}"
			);
			exit(json_encode($message));
			break;

			default:
			$page = $this->ev->get('page');
			$blocks = $this->block->getBlockList(1,$page,10);
			$this->tpl->assign('blocks',$blocks);
			$this->tpl->assign('page',$page);
			$this->tpl->display('blocks');
		}
	}

	public function positions()
	{
		$subaction = $this->ev->url(3);
		$search = $this->ev->get('search');
		$u = '';
		if($search)
		{
			$this->tpl->assign('search',$search);
			foreach($search as $key => $arg)
			{
				$u .= "&search[{$key}]={$arg}";
			}
		}
		switch($subaction)
		{
			case 'modifycontent':
			if($this->ev->get('modifyblock'))
			{
				$posid = $this->ev->get('posid');
				$page = $this->ev->get('page');
				$args = $this->ev->get('args');
				$args['blockcontent'] = $args['blockcontent'];
				unset($args['blocktype']);
				$this->block->modifyBlock($posid,$args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "target" => "",
				    "rel" => "",
				    "callbackType" => "forward",
				    "forwardUrl" => "index.php?content-master-positions&page={$page}"
				);
				exit(json_encode($message));
			}
			else
			{
				$posid = $this->ev->get('posid');
				$page = $this->ev->get('page');
				$block = $this->block->getBlockById($posid);
				$block['blockcontent'] = $this->ev->stripSlashes($block['blockcontent']);
				$apps = $this->apps->getAppList();
				foreach($apps as $id => $app)
				{
					$tmp = $this->G->make('api',$app['appid']);
					if($tmp && method_exists($tmp,'parseBlock'))
					continue;
					else
					unset($apps[$id]);
				}
				$this->tpl->assign('block',$block);
				$this->tpl->assign('apps',$apps);
				$this->tpl->assign('page',$page);
				$this->tpl->display('positions_modify');
			}
			break;

			case 'add':
			if($this->ev->get('addpos'))
			{
				$args = $this->ev->get('args');
				$args['blockcontent'] = $args['blockcontent'];
				$this->block->addBlock($args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "target" => "",
				    "rel" => "",
				    "callbackType" => "forward",
				    "forwardUrl" => "index.php?content-master-positions"
				);
				exit(json_encode($message));
			}
			else
			{
				$apps = $this->apps->getAppList();
				foreach($apps as $id => $app)
				{
					$tmp = $this->G->make('api',$app['appid']);
					if($tmp && method_exists($tmp,'parseBlock'))
					continue;
					else
					unset($apps[$id]);
				}
				$this->tpl->assign('apps',$apps);
				$this->tpl->display('positions_add');
			}
			break;

			case 'delcontent':
			$pcid = $this->ev->get('pcid');
			$page = $this->ev->get('page');
			$this->position->delPosContent($pcid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
			    "target" => "",
			    "rel" => "",
			    "callbackType" => "forward",
			    "forwardUrl" => "index.php?content-master-positions&page={$page}{$u}"
			);
			exit(json_encode($message));
			break;

			case 'pos':
			if($this->ev->get('addpos'))
			{
				$args = $this->ev->get('args');
				$this->position->addPos($args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "target" => "",
				    "rel" => "",
				    "callbackType" => "forward",
				    "forwardUrl" => "?content-master-positions-pos"
				);
				exit(json_encode($message));
			}
			else
			{
				$poses = $this->position->getPosList();
				$this->tpl->assign('poses',$poses);
				$this->tpl->display('pos');
			}
			break;

			case 'lite':
			if($this->ev->get('modifycontentsequence'))
			{
				$page = $this->ev->get('page');
				if($this->ev->get('action') == 'delete')
				{
					$ids = $this->ev->get('delids');
					foreach($ids as $key => $id)
					{
						$this->position->delPosContent($key);
					}
				}
				else
				{
					$ids = $this->ev->get('ids');
					foreach($ids as $key => $id)
					{
						$this->position->modifyPosContent($key,array('pcsequence' => $id));
					}
				}
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?content-master-positions&page={$page}{$u}"
				);
				exit(json_encode($message));
			}
			else
			{
				$message = array(
					'statusCode' => 300,
					"message" => "无效访问"
				);
				exit(json_encode($message));
			}
			break;

			default:
			$page = $this->ev->get('page');
			if($search['posid'])$args = array(array("AND","pcposid = :pcposid",'pcposid',$search['posid']));
			else $args = 1;
			$poses = $this->position->getPosList();
			$positions = $this->position->getPosContentList($args,$page,10);
			$this->tpl->assign('poses',$poses);
			$this->tpl->assign('positions',$positions);
			$this->tpl->assign('page',$page);
			$this->tpl->display('positions');
		}
	}

	public function category()
	{
		$subaction = $this->ev->url(3);
		switch($subaction)
		{
			case 'add':
			if($this->ev->get('addcategory'))
			{
				$args = $this->ev->get('args');
				$page = $this->ev->get('page');
				$this->category->addCategory($args);
				if($args['catparent'])
				{
					$parent = $this->category->getCategoryById($args['catparent']);
					$parent = intval($parent['catparent']);
				}
				else $parent = 0;
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "target" => "",
				    "rel" => "",
				    "callbackType" => "forward",
				    "forwardUrl" => "index.php?content-master-category&parent={$parent}&page={$page}"
				);
				exit(json_encode($message));
			}
			else
			{
				$parent = $this->ev->get('parent');
				$tpls = array();
				foreach(glob("app/content/tpls/app/category_*.tpl") as $p)
				{
					$tpls[] = substr(basename($p),0,-4);
				}
				$this->tpl->assign('parent',$parent);
				$this->tpl->assign('tpls',$tpls);
				$this->tpl->display('category_add');
			}
			break;

			case 'lite':
			$ids = $this->ev->get('ids');
			foreach($ids as $key => $p)
			{
				$args = array('catlite' => $p);
				$this->category->modifyCategory($key,$args);
			}
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
			    "callbackType" => "forward",
			    "forwardUrl" => "reload"
			);
			$this->G->R($message);
			break;

			case 'ajax':
			switch($this->ev->url(4))
			{
				case 'getchildcategory':
				$catid = $this->ev->get('catid');
				$out = '';
				if($catid)
				{
					$child = $this->category->getCategoriesByArgs(array(array("AND","catparent = :catparent",':catparent',$catid)));
					foreach($child as $c)
					{
						$out .= '<option value="'.$c['catid'].'">'.$c['catname'].'</option>';
					}
				}
				if($out)
				{
					$message = array(
						'statusCode' => 200,
					    "html" => $out
					);
					exit(json_encode($message));
				}
				else
				{
					$message = array(
						'statusCode' => 300
					);
					exit(json_encode($message));
				}
				break;

				case 'getchilddata':
				$catid = $this->ev->get('catid');
				$child = $this->category->getCategoriesByArgs(array(array("AND","catparent = :catparent",':catparent',$catid)));
				exit(json_encode($child));
				$this->tpl->assign('child',$child);
				$this->tpl->assign('catid',$catid);
				$this->tpl->display('category_ajax_data');
				break;

				default:
				break;
			}
			break;

			case 'edit':
			$parent = $this->ev->get('parent');
			$catid = $this->ev->get('catid');
			$page = $this->ev->get('page');
			if($this->ev->get('submit'))
			{
				$args = $this->ev->get('args');
				$cat = $this->category->getCategoryById($catid);
				$this->category->modifyCategory($catid,$args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "callbackType" => "forward",
				    "forwardUrl" => "index.php?content-master-category&parent={$cat['catparent']}&page={$page}"
				);
				exit(json_encode($message));
			}
			else
			{
				$category = $this->category->getCategoryById($catid);
				$tpls = array();
				foreach(glob("app/content/tpls/app/category_*.tpl") as $p)
				{
					$tpls[] = substr(basename($p),0,-4);
				}
				$this->tpl->assign('tpls',$tpls);
				$this->tpl->assign('parent',$parent);
				$this->tpl->assign('category',$category);
				$this->tpl->assign('catid',$catid);
				$this->tpl->assign('page',$page);
				$this->tpl->display('category_edit');
			}
			break;

			case 'del':
			$catid = $this->ev->get('catid');
			$page = $this->ev->get('page');
			$cat = $this->category->getCategoryById($catid);
			$catstring = $this->category->getChildCategoryString($catid,0);
			$contents = $this->content->getContentList(array(array("AND","contentcatid = :contentcatid",'contentcatid',$catid)));
			if($catstring || $contents['number'])
			{
				$message = array(
					'statusCode' => 300,
					"message" => "操作失败，请先删除该分类下所有子分类和内容"
				);
				exit(json_encode($message));
			}
			$this->category->delCategory($catid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
			    "target" => "",
			    "rel" => "",
			    "callbackType" => "forward",
			    "forwardUrl" => "index.php?content-master-category&parent={$cat['catparent']}&page={$page}"
			);
			exit(json_encode($message));
			break;

			default:
			$page = intval($this->ev->get('page'));
			$page = $page?$page:1;
			$parent = intval($this->ev->get('parent'));
			$categorys = $this->category->getCategoryList(array(array("AND","catparent = :catparent",'catparent',$parent)),$page,5);
			$categories = $this->category->getAllCategory();
			$this->tpl->assign('parent',$parent);
			$this->tpl->assign('categorys',$categorys);
			$this->tpl->assign('categories',$categories);
			$this->tpl->assign('page',$page);
			$this->tpl->display('category');
		}
	}

	public function contents()
	{
		$action = $this->ev->url(3);
		$search = $this->ev->get('search');
		$page = intval($this->ev->get('page'));
		$u = '';
		if($search)
		{
			$this->tpl->assign('search',$search);
			foreach($search as $key => $arg)
			{
				$u .= "&search[{$key}]={$arg}";
			}
		}
		$this->tpl->assign('u',$u);
		$this->tpl->assign('page',$page);
		switch($action)
		{
			case 'add':
			if($this->ev->get('submit'))
			{
				$args = $this->ev->get('args');
				$args['contentuserid'] = $this->_user['sessionuserid'];
				$args['contentusername'] = $this->_user['sessionusername'];
				$args['contentinputtime'] = TIME;
				$group = $this->user->getGroupById($this->_user['sessiongroupid']);
				$args = $this->module->tidyNeedFieldsPars($args,$args['contentmoduleid'],array('group' => $group));
				$id = $this->content->addContent($args);
				/**
				$position = $this->ev->get('position');
				if($position)
				{
					foreach($position as $p)
					{
						$args = array('pctitle' => $basicargs['contenttitle'],'pctime' => TIME,'pccontentid' => $id,'pcthumb' => $basicargs['contentthumb'],'pcposid' => $p);
						$this->position->addPosContent($args);
					}
				}
				**/
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "target" => "",
				    "rel" => "",
				    "callbackType" => "forward",
				    "forwardUrl" => "index.php?content-master-contents&catid={$args['contentcatid']}"
				);
				exit(json_encode($message));
			}
			else
			{
				$catid = intval($this->ev->get('catid'));
				$parentcat = $this->category->getCategoriesByArgs(array(array("AND","catparent = 0")));
				$modules = $this->module->getModulesByApp($this->G->app);
				$tpls = array();
				foreach(glob("app/content/tpls/app/content_*.tpl") as $p)
				{
					$tpls[] = substr(basename($p),0,-4);
				}
				//$poses = $this->position->getPosList();
				//$this->tpl->assign('poses',$poses);
				$this->tpl->assign('tpls',$tpls);
				$this->tpl->assign('modules',$modules);
				$this->tpl->assign('parentcat',$parentcat);
				$this->tpl->assign('catid',$catid);
				$this->tpl->display('content_add');
			}
			break;

			case 'edit':
			$page = intval($this->ev->get('page'));
			//$gotopos = intval($this->ev->get('gotopos'));
			if($this->ev->get('submit'))
			{
				//$gotopos = intval($this->ev->get('gotopos'));
				$contentid = intval($this->ev->get('contentid'));
				$content = $this->content->getContentById($contentid);
				$args = $this->ev->get('args');
				$args['contentmodifytime'] = TIME;
				unset($args['contentcatid']);
				$group = $this->user->getGroupById($this->_user['sessiongroupid']);
				$args = $this->module->tidyNeedFieldsPars($args,$content['contentmoduleid'],array('group' => $group));
				$this->content->modifyContent($contentid,$args);
				/**
				$args = array('pctitle' => $content['contenttitle'],'pctime' => $content['contentinputtime'],'pcthumb' => $content['contentthumb']);
				$this->position->modifyPosContentByContentId($contentid,$args);

				if($gotopos)
				{
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功",
					    "target" => "",
					    "rel" => "",
					    "callbackType" => "forward",
					    "forwardUrl" => "index.php?content-master-contents&catid={$content['contentcatid']}&page={$page}{$u}"
					);
				}
				else
				**/
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "target" => "",
				    "rel" => "",
				    "callbackType" => "forward",
				    "forwardUrl" => "index.php?content-master-contents&catid={$content['contentcatid']}&page={$page}{$u}"
				);
				exit(json_encode($message));
			}
			else
			{
				$catid = intval($this->ev->get('catid'));
				$cat = $this->category->getCategoryById($catid);
				$contentid = intval($this->ev->get('contentid'));
				$content = $this->content->getContentById($contentid);
				$userid = $this->_user['sessionuserid'];
				$user = $this->user->getUserById($userid);
				$group = $this->user->getGroupById($user['usergroupid']);
				$fields = $this->module->getMoudleFields($content['contentmoduleid'],$this->user->getModuleUserInfo());
				$forms = $this->html->buildHtml($fields,$content);
				$tpls = array();
				foreach(glob("app/content/tpls/app/content_*.tpl") as $p)
				{
					$tpls[] = substr(basename($p),0,-4);
				}
				$this->tpl->assign('tpls',$tpls);
				$this->tpl->assign('fields',$fields);
				$this->tpl->assign('catid',$catid);
				$this->tpl->assign('cat',$cat);
				$this->tpl->assign('contentid',$contentid);
				$this->tpl->assign('content',$content);
				$this->tpl->assign('page',$page);
				$this->tpl->assign('forms',$forms);
				//$this->tpl->assign('gotopos',$gotopos);
				$this->tpl->display('content_edit');
			}
			break;

			case 'del':
			$page = intval($this->ev->get('page'));
			$contentid = intval($this->ev->get('contentid'));
			$content = $this->content->getContentById($contentid);
			$this->content->delContent($contentid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
			    "target" => "",
			    "rel" => "",
			    "callbackType" => "forward",
			    "forwardUrl" => "index.php?content-master-contents&catid={$content['contentcatid']}&page={$page}"
			);
			exit(json_encode($message));
			break;

			case 'lite':
			$catid = $this->ev->get('catid');
			$page = $this->ev->get('page');
			$this->tpl->assign('catid',$catid);
			$this->tpl->assign('page',$page);
			if($this->ev->get('modifycontentsequence'))
			{
				if($this->ev->get('action') == 'delete')
				{
					$ids = $this->ev->get('delids');
					foreach($ids as $key => $id)
					{
						$this->content->delContent($key);
					}
				}
				elseif($this->ev->get('action') == 'movecategory')
				{
					$contentids = array();
					$ids = $this->ev->get('delids');
					foreach($ids as $key => $id)
					{
						if($key)$contentids[] = $key;
					}
					$contentids = implode(',',$contentids);
					$parentcat = $this->category->getCategoriesByArgs(array(array("AND","catparent = 0")));
					$this->tpl->assign('parentcat',$parentcat);
					$this->tpl->assign('contentids',$contentids);
					$this->tpl->display('content_move');
					exit;
				}
				elseif($this->ev->get('action') == 'copycategory')
				{
					$contentids = array();
					$ids = $this->ev->get('delids');
					foreach($ids as $key => $id)
					{
						if($key)$contentids[] = $key;
					}
					$contentids = implode(',',$contentids);
					$parentcat = $this->category->getCategoriesByArgs(array(array("AND","catparent = 0")));
					$this->tpl->assign('parentcat',$parentcat);
					$this->tpl->assign('contentids',$contentids);
					$this->tpl->display('content_copy');
					exit;
				}
				elseif($this->ev->get('action') == 'moveposition')
				{
					$contentids = array();
					$ids = $this->ev->get('delids');
					foreach($ids as $key => $id)
					{
						if($key)$contentids[] = $key;
					}
					$contentids = implode(',',$contentids);
					$poses = $this->position->getPosList();
					$this->tpl->assign('poses',$poses);
					$this->tpl->assign('contentids',$contentids);
					$this->tpl->display('content_position');
					exit;
				}
				else
				{
					$ids = $this->ev->get('ids');
					foreach($ids as $key => $id)
					{
						$this->content->modifyBasciContent($key,array('contentsequence' => $id));
					}
				}
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?content-master-contents&catid={$catid}&page={$page}{$u}"
				);
				exit(json_encode($message));
			}
			elseif($this->ev->get('movecposition'))
			{
				$contentids = explode(',',$this->ev->get('contentids'));
				$position = $this->ev->get('position');
				if($position)
				{
					foreach($contentids as $key => $id)
					{
						if($id)
						{
							$basic = $this->content->getBasicContentById($id);
							$args = array('pctitle' => $basic['contenttitle'],'pctime' => $basic['contentinputtime'],'pccontentid' => $id,'pcthumb' => $basic['contentthumb'],'pcposid' => $position);
							$this->position->addPosContent($args);
						}
					}
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功",
						"callbackType" => "forward",
					    "forwardUrl" => "index.php?content-master-contents&catid={$catid}&page={$page}{$u}"
					);
				}
				else
				$message = array(
					'statusCode' => 300,
					"message" => "操作失败"
				);
				exit(json_encode($message));
			}
			elseif($this->ev->get('movecategory'))
			{
				$contentids = explode(',',$this->ev->get('contentids'));
				$targetcatid = $this->ev->get('targetcatid');
				if($targetcatid)
				{
					foreach($contentids as $key => $id)
					{
						if($id)$this->content->modifyBasciContent($id,array('contentcatid' => $targetcatid));
					}
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功",
						"callbackType" => "forward",
					    "forwardUrl" => "?content-master-contents&catid={$catid}&page={$page}{$u}"
					);
				}
				else
				$message = array(
					'statusCode' => 300,
					"message" => "操作失败"
				);
				exit(json_encode($message));
			}
			elseif($this->ev->get('copycategory'))
			{
				$contentids = explode(',',$this->ev->get('contentids'));
				$targetcatid = $this->ev->get('targetcatid');
				if($targetcatid)
				{
					foreach($contentids as $key => $id)
					{
						if($id)
						{
							$content = $this->content->getBasicContentById($id);
							$args = array('contentcatid' => $targetcatid,'contenttitle' => $content['contenttitle'],'contentmoduleid' => $content['contentmoduleid'],'contentthumb' => $content['contentthumb'],'contentlink' => 'index.php?content-app-content&contentid='.$content['contentid']);
							$args['contentuserid'] = $this->_user['sessionuserid'];
							$args['contentusername'] = $this->_user['sessionusername'];
							$args['contentinputtime'] = TIME;
							$this->content->addContent($args);
						}
					}
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功",
						"callbackType" => "forward",
					    "forwardUrl" => "index.php?content-master-contents&catid={$catid}&page={$page}{$u}"
					);
				}
				else
				$message = array(
					'statusCode' => 300,
					"message" => "操作失败"
				);
				exit(json_encode($message));
			}
			else
			{
				$message = array(
					'statusCode' => 300,
					"message" => "无效访问"
				);
				exit(json_encode($message));
			}
			break;

			default:
			$catid = intval($this->ev->get('catid'));
			if(!$catid)$catid = $search['contentcatid'];
			$page = $page?$page:1;
			$categories = $this->category->getAllCategory();
			$parentcat = $this->category->getCategoriesByArgs(array(array("AND","catparent = 0"),array("AND","catapp = 'content'")));
			if($catid)
			{
				$childstring = $this->category->getChildCategoryString($catid);
				$args = array(array("AND","find_in_set(contentcatid,:contentcatid)",'contentcatid',$childstring));
			}
			else $args = array();
			if($search['contentid'])
			{
				$args[] = array("AND","contentid = :contentid",'contentid',$search['contentid']);
			}
			else
			{
				if($search['contentcatid'])$args[] = array("AND","contentcatid = :contentcatid",'contentcatid',$search['contentcatid']);
				if($search['contentmoduleid'])$args[] = array("AND","contentmoduleid = :contentmoduleid",'contentmoduleid',$search['contentmoduleid']);
				if($search['stime'])$args[] = array("AND","contentinputtime >= :contentinputtime",'contentinputtime',strtotime($search['stime']));
				if($search['etime'])$args[] = array("AND","contentinputtime <= :contentinputtime",'contentinputtime',strtotime($search['etime']));
				if($search['keyword'])$args[] = array("AND","contenttitle LIKE :contenttitle",'contenttitle',"%{$search['keyword']}%");
				if($search['username'])
				{
					$user = $this->user->getUserByUserName($search['username']);
					$args[] = array("AND","contentuserid = :contentuserid",'contentuserid',$user['userid']);
				}
			}
			$contents = $this->content->getContentList($args,$page,10);
			$modules = $this->module->getModulesByApp($this->G->app);
			$this->tpl->assign('modules',$modules);
			$this->tpl->assign('catid',$catid);
			$this->tpl->assign('contents',$contents);
			$this->tpl->assign('parentcat',$parentcat);
			$this->tpl->assign('categories',$categories);
			$this->tpl->assign('page',$page);
			$this->tpl->display('content');
		}
	}

	public function module()
	{
		$subaction = $this->ev->url(3);
		switch($subaction)
		{
			case 'fields':
			$moduleid = $this->ev->get('moduleid');
			$page = $this->ev->post('page');
			if($this->ev->get('modifyfieldsequence'))
			{
				$ids = $this->ev->post('ids');
				if($ids)
				{
					foreach($ids as $key => $value)
					{
						$args = array('fieldsequence'=>$value);
						$this->module->modifyFieldHtmlType($args,$key);
					}
				}
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "?content-master-module-fields&moduleid={$moduleid}"
				);
				exit(json_encode($message));
			}
			else
			{
				$module = $this->module->getModuleById($moduleid);
				$fields = $this->module->getMoudleFields($moduleid,true);
				$this->tpl->assign('moduleid',$moduleid);
				$this->tpl->assign('module',$module);
				$this->tpl->assign('fields',$fields);
				$this->tpl->display('fields');
			}
			break;

			case 'addfield':
			$moduleid = $this->ev->get('moduleid');
			$fieldpublic = $this->ev->get('fieldpublic');
			$page = $this->ev->post('page');
			if($this->ev->get('insertfield'))
			{
				$args = $this->ev->post('args');
				$moduleid = $args['fieldmoduleid'];
				$module = $this->module->getModuleById($moduleid);
				if(!$args['fieldpublic'])
				$args['field'] = $module['modulecode'].'_'.$args['field'];
				$args['fieldforbidactors'] = ','.implode(',',$args['fieldforbidactors']).',';
				$id = $this->module->insertModuleField($args);
				if($id)
				{
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功",
						"callbackType" => "forward",
					    "forwardUrl" => "?content-master-module-fields&moduleid={$moduleid}&page={$page}"
					);
				}
				else
				{
					$message = array(
						'statusCode' => 300,
						"message" => "操作失败"
					);
				}
				exit(json_encode($message));
			}
			else
			{
				$module = $this->module->getModuleById($moduleid);
				$this->tpl->assign('moduleid',$moduleid);
				$this->tpl->assign('fieldpublic',$fieldpublic);
				$this->tpl->assign('module',$module);
				$this->tpl->display('addfield');
			}
			break;

			case 'preview':
			$moduleid = $this->ev->get('moduleid');
			$module = $this->module->getModuleById($moduleid);
			$fields = $this->module->getMoudleFields($moduleid);
			$forms = $this->html->buildHtml($fields);
			$this->tpl->assign('moduleid',$moduleid);
			$this->tpl->assign('module',$module);
			$this->tpl->assign('fields',$fields);
			$this->tpl->assign('forms',$forms);
			$this->tpl->display('preview');
			break;

			case 'modifyfield':
			if($this->ev->get('modifyfieldhtml'))
			{
				$args = $this->ev->post('args');
				$args['fieldforbidactors'] = ','.implode(',',$args['fieldforbidactors']).',';
				$fieldid = $this->ev->post('fieldid');
				$field = $this->module->getFieldById($fieldid);
				$this->module->modifyFieldHtmlType($args,$fieldid);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "navTabId" => "",
				    "rel" => "",
				    "callbackType" => "forward",
				    "forwardUrl" => "?content-master-module-fields&moduleid={$field['fieldmoduleid']}"
				);
				exit(json_encode($message));
			}
			elseif($this->ev->get('modifyfielddata'))
			{
				$args = $this->ev->post('args');
				$fieldid = $this->ev->post('fieldid');
				$field = $this->module->getFieldById($fieldid);
				$this->module->modifyFieldDataType($args,$fieldid);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "navTabId" => "",
				    "rel" => "",
				    "callbackType" => "forward",
				    "forwardUrl" => "?content-master-module-fields&moduleid={$field['fieldmoduleid']}"
				);
				exit(json_encode($message));
			}
			else
			{
				$fieldid = $this->ev->get('fieldid');
				$field = $this->module->getFieldById($fieldid);
				$this->tpl->assign('fieldid',$fieldid);
				$this->tpl->assign('field',$field);
				$this->tpl->display('modifyfield');
			}
			break;

			case 'delfield':
			$fieldid = $this->ev->get('fieldid');
			$moduleid = $this->ev->get('moduleid');
			$r = $this->module->delField($fieldid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
			    "callbackType" => "forward",
			    "forwardUrl" => "?content-master-module-fields&moduleid={$moduleid}"
			);
			exit(json_encode($message));
			break;

			case 'modify':
			$page = $this->ev->get('page');
			if($this->ev->get('modifymodule'))
			{
				$args = $this->ev->get('args');
				$moduleid = $this->ev->get('moduleid');
				$this->module->modifyModule($args,$moduleid);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "callbackType" => "forward",
				    "forwardUrl" => "?content-master-module"
				);
				exit(json_encode($message));
			}
			else
			{
				$moduleid = $this->ev->get('moduleid');
				$module = $this->module->getModuleById($moduleid);
				$this->tpl->assign('module',$module);
				$this->tpl->display('modifymodule');
			}
			break;

			case 'forbiddenfield':
			$fieldid = $this->ev->get('fieldid');
			$moduleid = $this->ev->get('moduleid');
			$field = $this->module->getFieldById($fieldid);
			if(!$moduleid)$moduleid = $field['fieldmoduleid'];
			$args = array();
			if($field['fieldlock'])
			$args['fieldlock'] = 0;
			else
			$args['fieldlock'] = 1;
			$this->module->modifyFieldHtmlType($args,$fieldid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
			    "callbackType" => "forward",
			    "forwardUrl" => "index.php?content-master-module-fields&moduleid={$moduleid}"
			);
			exit(json_encode($message));
			break;

			case 'moduleforms':
			$moduleid = $this->ev->get('moduleid');
			$userinfo = $this->user->getModuleUserInfo();
			$fields = $this->module->getMoudleFields($moduleid,$userinfo);
			$forms = $this->html->buildHtml($fields);
			$this->tpl->assign('fields',$fields);
			$this->tpl->assign('forms',$forms);
			$this->tpl->display('preview_ajax');
			break;

			case 'add':
			$page = intval($this->ev->get('page'));
			if($this->ev->post('insertmodule'))
			{
				$args = $this->ev->post('args');
				$errmsg = false;
				if($this->module->searchModules(array(array("AND","modulecode = :modulecode",'modulecode',$args['modulecode']))))
				{
					$message = array(
						'statusCode' => 300,
						"message" => "操作失败，存在同名（代码）模型"
					);
					exit(json_encode($message));
				}
				$id = $this->module->insertModule($args);
				if(!$id)$errmsg = '模型添加出错';
				if(!$errmsg)
				{
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功",
						"callbackType" => "forward",
					    "forwardUrl" => "index.php?content-master-module&page={$page}"
					);
					exit(json_encode($message));
				}
				else
				{
					$message = array(
						'statusCode' => 300,
						"message" => "操作失败，{$errmsg}"
					);
				}
				exit(json_encode($message));
			}
			else
			$this->tpl->display('addmodule');
			break;

			case 'del':
			$moduleid = $this->ev->get('moduleid');
			$fileds = $this->module->getPrivateMoudleFields($moduleid);
			$groups = $this->user->getGroupsByModuleid($moduleid);
			if($fileds || $groups)
			$message = array(
				'statusCode' => 300,
				"message" => "操作失败，请先删除该模型下所有模型字段和角色"
			);
			else
			{
				$this->module->delModule($moduleid);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
					"forwardUrl" => "index.php?content-master-module&page={$page}"
				);
			}
			exit(json_encode($message));
			break;

			default:
			$this->tpl->display('module');
		}
	}

	public function work()
	{
		$action = $this->ev->url(3);
		$search = $this->ev->get('search');
		$u = '';
		if($search)
		{
			$this->tpl->assign('search',$search);
			foreach($search as $key => $arg)
			{
				$u .= "&search[{$key}]={$arg}";
			}
		}
		$page = $this->ev->get('page');
		switch($action)
		{
			case 'add':
			if($this->ev->get('addwork'))
			{
				$args = $this->ev->get('args');
				$args['workday'] = strtotime($args['workday']);
				$args['workinfo'] = $args['workinfo'];
				$this->work->addWork($args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "?content-master-work&page={$page}"
				);
				exit(json_encode($message));
			}
			else
			{
				$starttime = $this->work->getNewTime();
				$this->tpl->assign('starttime',$starttime);
				$this->tpl->display('work_add');
			}
			break;

			case 'modify':
			$workid  = $this->ev->get('workid');
			if($this->ev->get('modifywork'))
			{
				$args = $this->ev->get('args');
				$args['workinfo'] = $args['workinfo'];
				$this->work->modifyWork($workid,$args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "?content-master-work&page={$page}"
				);
				exit(json_encode($message));
			}
			else
			{
				$work = $this->work->getWorkById($workid);
				$this->tpl->assign('work',$work);
				$this->tpl->display('work_edit');
			}
			break;

			case 'del':
			$workid  = $this->ev->get('workid');
			$this->work->delWork($workid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "?content-master-work&page={$page}"
			);
			exit(json_encode($message));
			break;

			default:
			$page = $this->ev->get('page');
			$works = $this->work->getWorkList(1,$page);
			$this->tpl->assign('works',$works);
			$this->tpl->display('work');
		}
	}
}

?>