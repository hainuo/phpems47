<?php

class app
{
	public $G;

	public function __construct(&$G)
	{
		$this->G = $G;
		$this->session = $this->G->make('session');
		$this->tpl = $this->G->make('tpl');
		$this->ev = $this->G->make('ev');
		$this->user = $this->G->make('user','user');
	}

	public function alipayreturn()
	{
		$orderobj = $this->G->make('orders','bank');
		$alipay = $this->G->make('alipay');
		$orderid = $this->ev->get('out_trade_no');
		$order = $orderobj->getOrderById($orderid);
		$verify_result = $alipay->alireturn();
		$this->tpl->assign('order',$order);
		if($verify_result)
		{
			if($order['orderstatus'] == 2)
			{
				$this->tpl->assign('status',1);
				$this->tpl->display('payfor_status');
				exit;
			}
			else
			{
				if($this->ev->get('trade_status') == 'TRADE_FINISHED' ||$this->ev->get('trade_status') == 'TRADE_SUCCESS')
				{
					$orderobj->modifyOrderById($orderid,array('orderstatus' => 2));
					$user = $this->user->getUserById($order['orderuserid']);
					$args['usercoin'] = $user['usercoin']+$order['orderprice']*10;
					$this->user->modifyUserInfo($args,$order['orderuserid']);
					$this->tpl->assign('status',1);
					$this->tpl->display('payfor_status');
				}
				else
				{
					$this->tpl->assign('status',0);
					$this->tpl->display('payfor_status');
				}
			}
		}
		else
		{
			$this->tpl->assign('status',0);
			$this->tpl->display('payfor_status');
		}
	}

	public function alipaynotify()
	{
		$orderobj = $this->G->make('orders','bank');
		$alipay = $this->G->make('alipay');
		$orderid = $this->ev->get('out_trade_no');
		$order = $orderobj->getOrderById($orderid);
		$verify_result = $alipay->alinotify();
		$this->tpl->assign('order',$order);
		if($verify_result)
		{
			if($this->ev->get('trade_status') == 'TRADE_FINISHED' ||$this->ev->get('trade_status') == 'TRADE_SUCCESS')
			{
				if($order['orderstatus'] != 2)
				{
					$user = $this->user->getUserById($order['orderuserid']);
					$args['usercoin'] = $user['usercoin']+$order['orderprice']*10;
					$this->user->modifyUserInfo($args,$order['orderuserid']);
					$orderobj->modifyOrderById($orderid,array('orderstatus' => 2));
				}
				exit('sucess');
			}
			elseif($_POST['trade_status'] == 'WAIT_BUYER_PAY')
			{
				exit('fail');
			}
			else
			{
				exit('fail');
			}
		}
		else
		{
			exit('fail');
		}
	}
}

?>