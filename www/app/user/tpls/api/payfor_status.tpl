{x2;include:header}
<body>
<div class="row-fluid top">
	<div class="container">
		<div class="span1"><h1><img src="app/user/styles/img/theme/logo.png" /></h1></div>
		<div class="span6"><h2>模拟考试系统</h2></div>
		<div class="span5">
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="container logcontent">
		<div class="logbox">
			<form class="form-horizontal logform" method="post" action="index.php?user-app-login">
				<fieldset>
					<legend>订单号：{x2;$order['ordersn']}</legend>
					<div class="logcontrol">
						<p class="text-center">
							{x2;if:$status}
							<a class="btn btn-success" href="index.php?user-center-payfor-orderdetail&ordersn={x2;$order['ordersn']}">付款成功，查看订单详情</a>
							{x2;else}
							<a class="btn btn-danger" href="index.php?item-app-order-lists">付款失败</a>
							<a class="btn" href="index.php?user-center-payfor">查看充值记录</a>
							{x2;endif}
						</p>
					</div>
				</fieldset>
			</form>
		</div>
		<div class="logbotm"></div>
	</div>
</div>
{x2;include:foot}
</body>
</html>