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
						<div class="span8">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>订单号</th>
										<th>充值金额</th>
										<th>下单时间</th>
										<th>订单状态</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody>
									{x2;tree:$orders['data'],order,oid}
									<tr>
										<td>{x2;v:order['ordersn']}</td>
										<td>{x2;v:order['orderprice']}</td>
										<td>{x2;date:v:order['ordercreatetime'],'Y-m-d'}</td>
										<td>{x2;$orderstatus[v:order['orderstatus']]}</td>
										<td>
											<div class="btn-group">
												<a class="btn" href="index.php?user-center-payfor-orderdetail&ordersn={x2;v:order['ordersn']}" title="详细"><em class="icon-th-list"></em></a>
												{x2;if:v:order['orderstatus'] == 1}
												<a class="btn" href="index.php?user-center-payfor-orderdetail&ordersn={x2;v:order['ordersn']}" title="支付"><em class="icon-shopping-cart"></em></a>
												<a class="btn ajax" href="index.php?user-center-payfor-remove&ordersn={x2;v:order['ordersn']}" title="撤单"><em class="icon-remove"></em></a>
												{x2;endif}
											</div>
										</td>
									</tr>
									{x2;endtree}
								</tbody>
							</table>
							<div class="pagination pagination-right">
								<ul>{x2;$orders['pages']}</ul>
							</div>
						</div>
						<div class="span4">
							<form action="index.php?user-center-payfor" method="post">
								<fieldset>
									 <legend>充值</legend>
									 <label>充值金额</label>
									 <input type="text" name="money" type="text" onchange="javascript:$('#moneycoin').html(parseInt($(this).val())*10);" needle="needle" datatype="number" min="1" msg="您最少充值1元，充值数必须为整数"/> 元
									 <span class="help-block">1元 = 10积分，可兑换 <b id="moneycoin">0</b> 积分</span>
									 <button class="btn" type="submit">充值</button>
									 <input type="hidden" name="payforit" value="1" />
								</fieldset>
							</form>
							<fieldset>
								 <legend>代金券充值</legend>
								 <a href="#myModal" class="btn" role="button" data-toggle="modal">代金券充值</a>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<form aria-hidden="true" id="myModal" method="post" class="modal hide fade" role="dialog" aria-labelledby="#myModalLabel" action="index.php?exam-app-basics-coupon">
	<div class="modal-header">
		<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
		<h3 id="myModalLabel">
			代金券充值
		</h3>
	</div>
	<div class="modal-body" id="modal-body">
		<div class="control-group">
			<label class="control-label" for="content">代金券号码：</label>
	  		<div class="controls">
	  			<input type="text" name="couponsn" value="" needle="needle" msg="请输入16位代金券号码"/>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		 <input name="coupon" type="hidden" value="1">
		 <button class="btn" type="submit">充值</button>
	</div>
</form>
</body>
</html>