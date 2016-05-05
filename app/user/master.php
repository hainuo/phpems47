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
		$this->db = $this->G->make('pepdo');
		$this->pg = $this->G->make('pg');
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
		$modules = $this->module->getModulesByApp('user');
		$groups = $this->user->getUserGroups();
		$this->tpl->assign('_user',$this->user->getUserById($_user['sessionuserid']));
		$this->tpl->assign('modules',$modules);
		$this->tpl->assign('groups',$groups);
		$this->tpl->assign('userhash',$this->ev->get('userhash'));
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

	public function user()
	{
		$subaction = $this->ev->url(3);
		$search = $this->ev->get('search');
		$u = '';
		if($search)
		{
			foreach($search as $key => $arg)
			{
				$u .= "&search[{$key}]={$arg}";
			}
		}
		switch($subaction)
		{
			case 'del':
			$page = $this->ev->get('page');
			$userid = $this->ev->get('userid');
			$this->user->delUserById($userid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
			    "navTabId" => "",
			    "rel" => "",
			    "callbackType" => "forward",
			    "forwardUrl" => "index.php?user-master-user&page={$page}{$u}"
			);
			exit(json_encode($message));
			break;

			case 'batdel':
			if($this->ev->get('action') == 'delete')
			{
				$page = $this->ev->get('page');
				$delids = $this->ev->get('delids');
				foreach($delids as $userid => $p)
				$this->user->delUserById($userid);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "navTabId" => "",
				    "rel" => "",
				    "callbackType" => "forward",
				    "forwardUrl" => "index.php?user-master-user&page={$page}{$u}"
				);
				exit(json_encode($message));
			}
			break;

			case 'modify':
			$page = $this->ev->get('page');
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
			if($this->ev->get('modifyusergroup'))
			{
				$groupid = $this->ev->get('groupid');
				$userid = $this->ev->get('userid');
				$this->user->modifyUserGroup($groupid,$userid);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "callbackType" => "forward",
				    "forwardUrl" => "index.php?user-master-user&page={$page}{$u}"
				);
				exit(json_encode($message));
			}
			elseif($this->ev->get('modifyuserinfo'))
			{
				$args = $this->ev->get('args');
				$userid = $this->ev->get('userid');
				$user = $this->user->getUserById($userid);
				$group = $this->user->getGroupById($user['usergroupid']);
				$args = $this->module->tidyNeedFieldsPars($args,$group['groupmoduleid'],array('iscurrentuser'=> $userid == $this->_user['sessionuserid'],'group' => $group));
				$id = $this->user->modifyUserInfo($args,$userid);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "callbackType" => "forward",
				    "forwardUrl" => "index.php?user-master-user&page={$page}{$u}"
				);
				exit(json_encode($message));
			}
			elseif($this->ev->get('modifyuserpassword'))
			{
				$args = $this->ev->get('args');
				$userid = $this->ev->get('userid');
				if($args['password'] == $args['password2'] && $userid)
				{
					$id = $this->user->modifyUserPassword($args,$userid);
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功",
					    "callbackType" => "forward",
					    "forwardUrl" => "index.php?user-master-user&page={$page}{$u}"
					);
					exit(json_encode($message));
				}
				else
				{
					$message = array(
						'statusCode' => 300,
						"message" => "操作失败",
					    "navTabId" => "",
					    "rel" => ""
					);
					exit(json_encode($message));
				}
			}
			else
			{
				$userid = $this->ev->get('userid');
				$user = $this->user->getUserById($userid);
				$group = $this->user->getGroupById($user['usergroupid']);
				$fields = $this->module->getMoudleFields($group['groupmoduleid'],array('iscurrentuser'=> $userid == $this->_user['sessionuserid'],'group' => $this->user->getGroupById($this->_user['sessiongroupid'])));
				$forms = $this->html->buildHtml($fields,$user);
				$this->tpl->assign('moduleid',$group['groupmoduleid']);
				$this->tpl->assign('fields',$fields);
				$this->tpl->assign('forms',$forms);
				$this->tpl->assign('user',$user);
				$this->tpl->assign('page',$page);
				$this->tpl->display('modifyuser');
			}
			break;

			case 'batadd':
			if($this->ev->post('insertUser'))
			{
				$uploadfile = $this->ev->get('uploadfile');
				if(!file_exists($uploadfile))
				{
					$message = array(
						'statusCode' => 300,
						"message" => "上传文件不存在"
					);
					exit(json_encode($message));
				}
				else
				{
					setlocale(LC_ALL,'zh_CN');
					$handle = fopen($uploadfile,"r");
					$defaultgroup = $this->user->getDefaultGroup();
					$strings = $this->G->make('strings');
					while ($data = fgetcsv($handle,200))
					{

					    if($data[0] && $data[1])
					    {
						    $args = array();
						    $args['username'] = iconv("GBK","UTF-8",$data[0]);
						    if($strings->isUserName($args['username']))
						    {
							    $u = $this->user->getUserByUserName($args['username']);
							    if(!$u)
							    {
								    $args['useremail'] = $data[1];
								    if($strings->isEmail($args['useremail']))
								    {
									    $u = $this->user->getUserByEmail($args['useremail']);
									    if(!$u)
									    {
									    	if(!$data[2])$data[2] = '111111';
									    	$args['userpassword'] = md5($data[2]);
									    	$args['usergroupid'] = $defaultgroup['groupid'];
									    	$this->user->insertUser($args);
									    }
								    }
							    }
						    }
					    }
					}
					fclose($handle);
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功",
					    "callbackType" => "forward",
					    "forwardUrl" => "index.php?user-master-user"
					);
					exit(json_encode($message));
				}
			}
			else
			{
				$this->tpl->display('batadduser');
			}
			break;

			case 'add':
			if($this->ev->post('insertUser'))
			{
				$args = $this->ev->post('args');
				if($args['userpassword'] == $args['userpassword2'])
				{
					$userbyname = $this->user->getUserByUserName($args['username']);
					$userbyemail = $this->user->getUserByEmail($args['useremail']);
					if($userbyname)
					$errmsg = "这个用户名已经被注册了";
					if($userbyemail)
					$errmsg = "这个邮箱已经被注册了";
					if($errmsg)
					{
						$message = array(
							'statusCode' => 300,
							"message" => "{$errmsg}",
						    "navTabId" => "",
						    "rel" => ""
						);
						exit(json_encode($message));
					}
					$args['userpassword'] = md5($args['userpassword']);
					$search = $this->ev->get('search');
					$u = '';
					if($search)
					{
						foreach($search as $key => $arg)
						{
							$u .= "&search[{$key}]={$arg}";
						}
					}
					unset($args['userpassword2']);
					$id = $this->user->insertUser($args);
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功",
					    "callbackType" => "forward",
					    "forwardUrl" => "index.php?user-master-user&page={$page}{$u}"
					);
					exit(json_encode($message));
				}
			}
			else
			{
				$this->tpl->display('adduser');
			}
			break;

			default:
			$page = $this->ev->get('page')?$this->ev->get('page'):1;
			$search = $this->ev->get('search');
			$u = '';
			if($search)
			{
				foreach($search as $key => $arg)
				{
					$u .= "&search[{$key}]={$arg}";
				}
			}
			$args = array();
			if($search['userid'])$args[] = array('AND',"userid = :userid",'userid',$search['userid']);
			if($search['username'])$args[] = array('AND',"username LIKE :username",'username','%'.$search['username'].'%');
			if($search['useremail'])$args[] = array('AND',"useremail  LIKE :useremail",'useremail','%'.$search['useremail'].'%');
			if($search['groupid'])$args[] = array('AND',"usergroupid = :usergroupid",'usergroupid',$search['groupid']);
			if($search['stime'] || $search['etime'])
			{
				if(!is_array($args))$args = array();
				if($search['stime']){
					$stime = strtotime($search['stime']);
					$args[] = array('AND',"userregtime >= :userregtime",'userregtime',$stime);
				}
				if($search['etime']){
					$etime = strtotime($search['etime']);
					$args[] = array('AND',"userregtime <= :userregtime",'userregtime',$etime);
				}
			}
			$users = $this->user->getUserList($page,10,$args);
			$this->tpl->assign('users',$users);
			$this->tpl->assign('search',$search);
			$this->tpl->assign('u',$u);
			$this->tpl->assign('page',$page);
			$this->tpl->display('user');
			break;
		}
	}

	public function ajax()
	{
		$subaction = $this->ev->url(3);
		switch($subaction)
		{
			case 'getActorsByModule':
			$moduleid = $this->ev->get('moduleid');
			$actors = $this->user->getGroupsByModuleid($moduleid);
			foreach($actors as $actor)
			{
				echo '<option value="'.$actor['groupid'].'">'.$actor['groupname'].'</option>';
			}
			break;

			default:
			break;
		}
	}

	public function actor()
	{
		$subaction = $this->ev->url(3);
		switch($subaction)
		{
			case 'selectactor':
			$groupid = $this->ev->get('groupid');
			$group = $this->user->getGroupById($groupid);
			if($group)
			{
				$this->user->selectDefaultActor($groupid);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "reload"
				);
			}
			else
			$message = array(
				'statusCode' => 300,
				"message" => "操作失败，存在同名角色！"
			);
			exit(json_encode($message));
			break;

			case 'modifyactor':
			$page = $this->ev->get('page');
			if($this->ev->get('modifyactor'))
			{
				$groupid = $this->ev->get('groupid');
				$args = $this->ev->get('args');
				$r = $this->user->modifyActor($groupid,$args);
				if($r)
				{
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功",
						"callbackType" => "forward",
					    "forwardUrl" => "index.php?user-master-actor"
					);
				}
				else
				{
					$message = array(
						'statusCode' => 300,
						"message" => "操作失败，存在同名角色！",
					    "callbackType" => ''
					);
				}
				exit(json_encode($message));
			}
			else
			{
				$groupid = $this->ev->get('groupid');
				$group = $this->user->getGroupById($groupid);
				$this->tpl->assign('group',$group);
				$this->tpl->display('modifyactor');
			}
			break;

			case 'delactor':
			$page = intval($this->ev->get('page'));
			$groupid = $this->ev->get('groupid');
			$r = $this->user->delActorById($groupid);
			if($r)
			{
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
					"forwardUrl" => "index.php?user-master-actor&page={$page}"
				);
			}
			else
			{
				$message = array(
					'statusCode' => 300,
					"message" => "操作失败，该角色下存在用户，请删除所有用户后再删除本角色"
				);
			}
			exit(json_encode($message));
			break;

			case 'add':
			if($this->ev->post('insertactor'))
			{
				$args = $this->ev->post('args');
				$id = $this->user->insertActor($args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
					"forwardUrl" => "index.php?user-master-actor&moduleid={$args['groupmoduleid']}"
				);
				exit(json_encode($message));
			}
			else
			{
				$this->tpl->display('addactor');
			}
			break;

			default:
			$search = $this->ev->post('search');
			$args = 1;
			$page = $this->ev->get('page');
			$page = $page>1?$page:1;
			if($search['groupmoduleid'])
			{
				$args = array(array('AND',"groupmoduleid = :groupmoduleid",'groupmoduleid',$search['groupmoduleid']));
			}
			$actors = $this->user->getUserGroupList($args,10,$page);
			$this->tpl->assign('page',$page);
			$this->tpl->assign('actors',$actors);
			$this->tpl->display('actor');
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
				    "forwardUrl" => "index.php?user-master-module-fields&moduleid={$moduleid}"
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
					    "forwardUrl" => "index.php?user-master-module-fields&moduleid={$moduleid}&page={$page}"
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
				    "forwardUrl" => "index.php?user-master-module-fields&moduleid={$field['fieldmoduleid']}"
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
				    "forwardUrl" => "index.php?user-master-module-fields&moduleid={$field['fieldmoduleid']}"
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
			    "forwardUrl" => "index.php?user-master-module-fields&moduleid={$moduleid}"
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
				    "forwardUrl" => "index.php?user-master-module"
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
			    "forwardUrl" => "index.php?user-master-module-fields&moduleid={$moduleid}"
			);
			exit(json_encode($message));
			break;

			case 'add':
			$page = intval($this->ev->get('page'));
			if($this->ev->post('insertmodule'))
			{
				$args = $this->ev->post('args');
				$errmsg = false;
				if($this->module->searchModules(array(array('AND',"modulecode = :modulecode",'modulecode',$args['modulecode']))))
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
					    "forwardUrl" => "index.php?user-master-module&page={$page}"
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
					"forwardUrl" => "index.php?user-master-module&page={$page}"
				);
			}
			exit(json_encode($message));
			break;

			default:
			$this->tpl->display('module');
		}
	}
}

?>