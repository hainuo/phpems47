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
		$this->pesql = $this->G->make('pdosql');
		$this->db = $this->G->make('pepdo');
		$this->pg = $this->G->make('pg');
		$this->module = $this->G->make('module');
		$this->session = $this->G->make('session');
		$this->user = $this->G->make('user','user');
		$groups = $this->user->getUserGroups();
		$this->tpl->assign('groups',$groups);
		$this->tpl->assign('userhash',$this->ev->get('userhash'));
		$this->_user = $_user = $this->session->getSessionUser();
		if($_user['sessionuserid'] && $this->ev->url(2)!= 'logout')
		{
			if($this->ev->get('userhash'))
			exit(json_encode(array(
				'statusCode' => 200,
				"message" => "您已经登录",
			    "callbackType" => 'forward',
			    "forwardUrl" => "index.php?".$this->G->defaultApp
			)));
			else
			{
				header("location:index.php?".$this->G->defaultApp);
				exit;
			}
		}
	}

	public function index()
	{
		$this->login();
	}

	public function login()
	{
		if($this->ev->get('userlogin'))
		{
			$tmp = $this->session->getSessionValue();
			if(TIME - $tmp['sessionlasttime'] < 1)
			{
				$message = array(
					'statusCode' => 300,
					"message" => "操作失败"
				);
				exit(json_encode($message));
			}
			$args = $this->ev->get('args');
			$user = $this->user->getUserByUserName($args['username']);
			if($user['userid'])
			{
				if($user['userpassword'] == md5($args['userpassword']))
				{
					$this->session->setSessionUser(array('sessionuserid'=>$user['userid'],'sessionpassword'=>$user['userpassword'],'sessionip'=>$this->ev->getClientIp(),'sessiongroupid'=>$user['usergroupid'],'sessionlogintime'=>TIME,'sessionusername'=>$user['username']));
					$message = array(
						'statusCode' => 201,
						"message" => "操作成功",
					    "callbackType" => 'forward',
					    "forwardUrl" => "reload"
					);
					if($this->ev->get('userhash'))
					exit(json_encode($message));
					else
					exit(header("location:{$message['forwardUrl']}"));
				}
				else
				{
					$message = array(
						'statusCode' => 300,
						'errorinput' => 'args[username]',
						"message" => "操作失败"
					);
					exit(json_encode($message));
				}
			}
			else
			{
				$message = array(
					'statusCode' => 300,
					'errorinput' => 'args[username]',
					"message" => "操作失败"
				);
				exit(json_encode($message));
			}
		}
		else
		{
			$this->tpl->display('login');
		}
	}

	public function register()
	{
		if($this->ev->get('userregister'))
		{
			$fob = array('admin','管理员','站长');
			$args = $this->ev->get('args');
			$defaultgroup = $this->user->getDefaultGroup();
			if(!$defaultgroup['groupid'] || !trim($args['username']))
			{
				$message = array(
					'statusCode' => 300,
					"message" => "用户不能注册"
				);
				exit(json_encode($message));
			}
			$username = $args['username'];
			foreach($fob as $f)
			{
				if(strpos($username,$f) !== false)
				{
					$message = array(
						'statusCode' => 300,
						'errorinput' => 'args[username]',
						"message" => "用户已经存在"
					);
					exit(json_encode($message));
				}
			}
			$user = $this->user->getUserByUserName($username);
			if($user)
			{
				$message = array(
					'statusCode' => 300,
					'errorinput' => 'args[username]',
					"message" => "用户已经存在"
				);
				exit(json_encode($message));
			}
			$email = $args['useremail'];
			$user = $this->user->getUserByEmail($email);
			if($user)
			{
				$message = array(
					'statusCode' => 300,
					'errorinput' => 'args[username]',
					"message" => "邮箱已经被注册"
				);
				exit(json_encode($message));
			}
			$id = $this->user->insertUser(array('username' => $username,'usergroupid' => $defaultgroup['groupid'],'userpassword' => md5($args['userpassword']),'useremail' => $email));
			$this->session->setSessionUser(array('sessionuserid'=>$id,'sessionpassword'=>md5($args['userpassword']),'sessionip'=>$this->ev->getClientIp(),'sessiongroupid'=>$defaultgroup['groupid'],'sessionlogintime'=>TIME,'sessionusername'=>$username));
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
			    "target" => "",
			    "rel" => "",
			    "callbackType" => 'forward',
			    "forwardUrl" => "index.php?".$this->G->defaultApp
			);
			exit(json_encode($message));
		}
		else
		{
			$this->tpl->display('register');
		}
	}

	public function logout()
	{
		$this->session->clearSessionUser();
		$message = array(
			'statusCode' => 201,
			"message" => "操作成功",
			"callbackType" => 'forward',
			"forwardUrl" => "index.php?".$this->G->defaultApp
		);
		$this->G->R($message);
		exit;
	}
}

?>