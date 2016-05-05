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
		$this->db = $this->G->make('pepdo');
		$this->pg = $this->G->make('pg');
		$this->html = $this->G->make('html');
		$this->module = $this->G->make('module');
		$this->session = $this->G->make('session');
		$this->user = $this->G->make('user','user');
		$this->order = $this->G->make('orders','bank');
		$this->_user = $_user = $this->session->getSessionUser();
		if(!$_user['sessionuserid'])
		{
			if($this->ev->get('userhash'))
			exit(json_encode(array(
				'statusCode' => 301,
				"message" => "请您重新登录",
			    "callbackType" => 'forward',
			    "forwardUrl" => "index.php?user-app-login"
			)));
			else
			{
				header("location:index.php?user-app-login");
				exit;
			}
		}
		$groups = $this->user->getUserGroups();
		$this->tpl->assign('groups',$groups);
		$this->tpl->assign('_user',$this->user->getUserById($_user['sessionuserid']));
		$this->tpl->assign('userhash',$this->ev->get('userhash'));
	}

	public function index()
	{
		$this->tpl->display('index');
	}

	public function payfor()
	{
		$subaction = $this->ev->url(3);
		$orderstatus = array(1=>'待付款',2=>'已完成',99=>'已撤单');
		$this->tpl->assign('orderstatus',$orderstatus);
		switch($subaction)
		{
			case 'remove':
			$oid = $this->ev->get('ordersn');
			$order = $this->order->getOrderById($oid,$this->_user['sessionuserid']);
			if($order['orderstatus'] == 1)
			{
				$this->order->delOrder($oid);
				$message = array(
					'statusCode' => 200,
					"message" => "订单删除成功",
				    "callbackType" => 'forward',
				    "forwardUrl" => "reload"
				);
			}
			else
			$message = array(
				'statusCode' => 300,
				"message" => "订单操作失败"
			);
			exit(json_encode($message));
			break;

			case 'orderdetail':
			$oid = $this->ev->get('ordersn');
			if(!$oid)exit(header("location:index.php?user-center"));
			$order = $this->order->getOrderById($oid,$this->_user['sessionuserid']);
			$alipay = $this->G->make('alipay');
			$payforurl = $alipay->outPayForUrl($order,WP.'index.php?route=user-api-alipaynotify',WP.'index.php?route=user-api-alipayreturn');
			$this->tpl->assign('payforurl',$payforurl);
			$this->tpl->assign('order',$order);
			$this->tpl->display('payfor_detail');
			break;

			default:
			if($this->ev->get('payforit'))
			{
				$money = intval($this->ev->get('money'));
				if($money < 1)
				{
					$message = array(
						'statusCode' => 300,
						"message" => "最少需要充值1元"
					);
					exit(json_encode($message));
				}
				$args = array();
				$args['orderprice'] = $money;
				$args['ordertitle'] = "考试系统充值 {$args['orderprice']} 元";
				$args['ordersn'] = date('YmdHi').rand(100,999);
				$args['orderstatus'] = 1;
				$args['orderuserid'] = $this->_user['sessionuserid'];
				$args['ordercreatetime'] = TIME;
				$args['orderuserinfo'] = array('username' => $this->_user['sessionusername']);
				$this->order->addOrder($args);
				$message = array(
					'statusCode' => 200,
					"message" => "订单创建成功",
				    "callbackType" => 'forward',
				    "forwardUrl" => "index.php?user-center-payfor-orderdetail&ordersn=".$args['ordersn']
				);
				exit(json_encode($message));
			}
			else
			{
				$page = $this->ev->get('page');
				$args = array(array("AND","orderuserid = :orderuserid",'orderuserid',$this->_user['sessionuserid']));
				$myorders = $this->order->getOrderList($args,$page);
				$this->tpl->assign('orders',$myorders);
				$this->tpl->display('payfor');
			}
		}
	}

	public function privatement()
	{
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
		if($this->ev->get('modifyuserinfo'))
		{
			$args = $this->ev->get('args');
			$userid = $this->_user['sessionuserid'];
			$group = $this->user->getGroupById($this->_user['sessiongroupid']);
			$args = $this->module->tidyNeedFieldsPars($args,$group['groupmoduleid'],array('iscurrentuser'=> 1,'group' => $group));
			$id = $this->user->modifyUserInfo($args,$userid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
			    "callbackType" => 'forward',
			    "forwardUrl" => "index.php?user-center-privatement"
			);
			exit(json_encode($message));
		}
		elseif($this->ev->get('modifyuserpassword'))
		{
			$args = $this->ev->get('args');
			$oldpassword = $this->ev->get('oldpassword');
			$userid = $this->_user['sessionuserid'];
			$user = $this->user->getUserById($userid);
			if(md5($oldpassword) != $user['userpassword'])
			{
				$message = array(
					'statusCode' => 300,
					"message" => "操作失败，原密码验证失败"
				);
				exit(json_encode($message));
			}
			if($args['password'] == $args['password2'] && $userid)
			{
				$id = $this->user->modifyUserPassword($args,$userid);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "callbackType" => 'forward',
				    "forwardUrl" => "index.php?user-center-privatement&page={$page}{$u}"
				);
				exit(json_encode($message));
			}
			else
			{
				$message = array(
					'statusCode' => 300,
					"message" => "操作失败"
				);
				exit(json_encode($message));
			}
		}
		else
		{
			$userid = $this->_user['sessionuserid'];
			$user = $this->user->getUserById($userid);
			$group = $this->user->getGroupById($user['usergroupid']);
			$fields = $this->module->getMoudleFields($group['groupmoduleid'],array('iscurrentuser'=> $userid == $this->_user['sessionuserid'],'group' => $group));
			$forms = $this->html->buildHtml($fields,$user);
			$actors = $this->user->getGroupsByModuleid($group['groupmoduleid']);
			$this->tpl->assign('moduleid',$group['groupmoduleid']);
			$this->tpl->assign('fields',$fields);
			$this->tpl->assign('forms',$forms);
			$this->tpl->assign('actors',$actors);
			$this->tpl->assign('user',$user);
			$this->tpl->assign('page',$page);
			$this->tpl->display('modifyuser');
		}
	}
}

?>