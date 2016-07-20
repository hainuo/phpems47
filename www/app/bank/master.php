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
		$this->files = $this->G->make('files');
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
			header("location:index.php?core-master-login");
		}
		$this->tpl->assign('_user',$this->user->getUserById($_user['sessionuserid']));
		$this->tpl->assign('action',$this->ev->url(2)?$this->ev->url(2):'user');
		$localapps = $this->apps->getLocalAppList();
		$apps = $this->apps->getAppList();
		$this->tpl->assign('localapps',$localapps);
		$this->tpl->assign('apps',$apps);
		$this->orders = $this->G->make('orders','bank');
		$orderstatus = array(1=>'待付款',2=>'已完成',99=>'已撤单');
		$this->tpl->assign('orderstatus',$orderstatus);
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

	public function coupon()
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
		$this->coupon = $this->G->make('coupon','bank');
		switch($action)
		{
			case 'outcoupon':
			if($this->ev->get('outcoupon'))
			{
				$stime = strtotime($this->ev->get('stime'));
				$etime = strtotime($this->ev->get('etime'));
				if($stime < $etime)
				{
					$fname = 'data/coupon/'.$stime.'-'.$etime.'-coupon.csv';
					$r = $this->coupon->getAllOKCoupon($stime,$etime);
					if($this->files->outCsv($fname,$r))
					$message = array(
						'statusCode' => 200,
						"message" => "优惠券导出成功，转入下载页面，如果浏览器没有相应，请<a href=\"{$fname}\">点此下载</a>",
					    "callbackType" => 'forward',
					    "forwardUrl" => "{$fname}"
					);
					else
					$message = array(
						'statusCode' => 300,
						"message" => "优惠券导出失败"
					);
				}
				else
				$message = array(
					'statusCode' => 300,
					"message" => "请选择正确的起止时间"
				);
				exit(json_encode($message));
			}
			else
			{
				$this->tpl->display('outcoupon');
			}
			break;

			case 'batadd':
			if($this->ev->get('addcoupon'))
			{
				$number = $this->ev->get('createnumber');
				$value = $this->ev->get('couponvalue');
				if($number > 0)
				{
					if($number > 99 )$number = 99;
					if($value < 10)$value = 10;
					if($value > 9999)$value = 9999;
					for($i = 0;$i<$number;$i++)
					{
						$this->coupon->randCoupon($value);
					}
					$message = array(
						'statusCode' => 200,
						"message" => "优惠券生成成功",
					    "callbackType" => 'forward',
					    "forwardUrl" => "index.php?bank-master-coupon"
					);
				}
				else
				$message = array(
					'statusCode' => 300,
					"message" => "代金券生成失败"
				);
				exit(json_encode($message));
			}
			else
			{
				$this->tpl->display('addcoupon');
			}
			break;

			default:
			if($search)
			{
				$args = array();
			}
			else
			$args = 1;
			$coupons = $this->coupon->getCouponList($args,$page);
			$this->tpl->assign('coupons',$coupons);
			$this->tpl->display('coupon');
		}
	}

	public function orders()
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
			case 'remove':
			$oid = $this->ev->get('ordersn');
			$order = $this->orders->getOrderById($oid);
			if($order['orderstatus'] == 1 || $order['orderstatus'] == 99)
			{
				$this->orders->delOrder($oid);
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

			case 'batremove':
			$delids = $this->ev->get('delids');
			foreach($delids as $oid => $p)
			{
				echo
				$order = $this->orders->getOrderById($oid);
				if($order['orderstatus'] == 1 || $order['orderstatus'] == 99)
				{
					$this->orders->delOrder($oid);
				}
			}
			$message = array(
				'statusCode' => 200,
				"message" => "订单删除成功",
			    "callbackType" => 'forward',
			    "forwardUrl" => "reload"
			);
			exit(json_encode($message));
			break;

			case 'change':
			$ordersn = $this->ev->get('ordersn');
			$orderstatus = $this->ev->get('orderstatus');
			$args = array('orderstatus' => $orderstatus);
			$this->orders->modifyOrderById($ordersn,$args);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
			    "target" => "",
			    "rel" => "",
			    "callbackType" => "forward",
			    "forwardUrl" => "index.php?bank-master-orders&page={$page}{$u}"
			);
			exit(json_encode($message));
			break;

			default:
			if($search)
			{
				$args = array();
			}
			else
			$args = 1;
			$orders = $this->orders->getOrderList($args,$page);
			$this->tpl->assign('orders',$orders);
			$this->tpl->display('orders');
		}
	}
}

?>