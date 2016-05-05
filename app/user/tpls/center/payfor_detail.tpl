{x2;include:header}
<body>
{x2;include:nav}
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="span2 exambox">
			<div class="examform">
				<div>
					{x2;include:menu}
				</div>
			</div>
		</div>
		<div class="span10 exambox" id="datacontent">
			<div class="examform">
				<div>
					<ul class="breadcrumb">
						<li><a href="index.php?{x2;$_app}-app">用户中心</a> <span class="divider">/</span></li>
						<li class="active">隐私设置</li>
					</ul>
					<div class="row-fluid">
						<div class="span12">
							<h5>订单号：{x2;$order['ordersn']}</h5>
							<table class="table table-bordered">
								<thead>
									<td>充值金额</td>
									<td>可兑换积分</td>
									<td>下单时间</td>
								</thead>
								<tr>
									<td>{x2;$order['orderprice']}</td>
									<td>{x2;eval:echo $order['orderprice']*10}</td>
									<td>{x2;date:$order['ordercreatetime'],'Y-m-d'}</td>
								</tr>
								<tr>
									<td colspan="3"><p class="text-right">应付款：￥{x2;$order['orderprice']}</p></td>
								</tr>
							</table>
							<p class="text-right">{x2;if:$order['orderstatus'] == 1}<a class="btn btn-danger" href="{x2;$payforurl}" target="_blank">去支付（测试使用，进入后请勿付款）</a>{x2;else} <a class="btn">{x2;$orderstatus[$order['orderstatus']]}</a>{x2;endif}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>