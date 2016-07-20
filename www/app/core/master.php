<?php

class app
{
	public $G;
	public $_user;

	public function __construct(&$G)
	{
		$this->G = $G;
		$this->ev = $this->G->make('ev');
		$this->session = $this->G->make('session');
		$this->tpl = $this->G->make('tpl');
		$this->sql = $this->G->make('sql');
		$this->pdosql = $this->G->make('pdosql');
		$this->db = $this->G->make('pepdo');
		$this->apps = $this->G->make('apps', 'core');
		$this->user = $this->G->make('user', 'user');
		$this->_user = $_user = $this->session->getSessionUser();
		$group = $this->user->getGroupById($_user['sessiongroupid']);
		if ($group['groupid'] != 1 && $this->ev->url(2) != 'login') {
			if ($this->ev->get('userhash'))
				exit(json_encode([
					'statusCode'   => 300,
					"message"      => "请您重新登录",
					"callbackType" => 'forward',
					"forwardUrl"   => "index.php?core-master-login",
				]));
			else {
				header("location:index.php?core-master-login");
				exit;
			}
		}
		$this->tpl->assign('_user', $this->user->getUserById($_user['sessionuserid']));
		$this->tpl->assign('action', $this->ev->url(2) ? $this->ev->url(2) : 'user');
		$localapps = $this->apps->getLocalAppList();
		$apps = $this->apps->getAppList();
		$this->tpl->assign('localapps', $localapps);
		$this->tpl->assign('_app', 'core');
		$this->tpl->assign('apps', $apps);
	}

	public function login()
	{
		if ($this->ev->get('userlogin')) {
			$args = $this->ev->get('args');
			$randcode = strtoupper($this->ev->get('randcode'));
			$_user = $this->session->getSessionValue();
			if ($randcode && ($randcode == $_user['sessionrandcode'])) {
				$this->session->setRandCode(0);
				$user = $this->user->getUserByUserName($args['username']);
				if ($user['userid']) {
					if ($user['userpassword'] == md5($args['userpassword'])) {
						$group = $this->user->getGroupById($user['groupid']);
						if ($group['groupmoduleid'] != 1) {
							exit(json_encode([
								'statusCode'   => 300,
								"message"      => "您无权进入后台",
								"callbackType" => 'forward',
								"forwardUrl"   => "index.php?core-master-login",
							]));
						} else {
							$this->session->setSessionUser(['sessionuserid' => $user['userid'], 'sessionpassword' => $user['userpassword'], 'sessionip' => $this->ev->getClientIp(), 'sessiongroupid' => $user['usergroupid'], 'sessionlogintime' => TIME, 'sessionusername' => $user['username']]);
							$message = [
								'statusCode'   => 200,
								"message"      => "操作成功，正在转入目标页面",
								"callbackType" => 'forward',
								"forwardUrl"   => "index.php?core-master",
							];
							exit(json_encode($message));
						}
					} else {
						$message = [
							"statusCode" => 300,
							"message"    => "操作失败，您的用户名或者密码错误！",
						];
						exit(json_encode($message));
					}
				}
			}
			$message = [
				"statusCode" => 300,
				"message"    => "操作失败，验证码错误！" . $_user['sessionrandcode'],
			];
			exit(json_encode($message));
		} else {
			$this->tpl->display('login');
		}
	}

	public function logout()
	{
		$this->session->clearSessionUser();
		header("location:index.php?core-master-login");
	}

	public function index()
	{
		$this->tpl->display('index');
	}

	public function apps()
	{
		$subaction = $this->ev->url(3);
		switch ($subaction) {
			case 'config':
				$appid = $this->ev->get('appid');
				if ($this->ev->get('appconfig')) {
					$args = $this->ev->get('args');
					$args['appsetting'] = $args['appsetting'];
					$app = $this->apps->getApp($appid);
					if ($app) {
						$this->apps->modifyApp($appid, $args);
					} else {
						$this->apps->addApp($appid, $args);
					}
					$message = [
						'statusCode'   => 200,
						"message"      => "操作成功，正在转入目标页面",
						"callbackType" => 'forward',
						"forwardUrl"   => "index.php?core-master-apps",
					];
					exit(json_encode($message));
				} else {
					$app = $this->apps->getApp($appid);
					$this->tpl->assign('appid', $appid);
					$this->tpl->assign('app', $app);
					$this->tpl->display('config');
				}
				break;

			default:
				$this->tpl->display('apps');
		}
	}
}

?>