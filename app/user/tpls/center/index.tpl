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
					<div>
						<div class="span3">
							<div class="thumbnail"><img alt="300x200" src="{x2;if:$_user['photo']}{x2;$_user['photo']}{x2;else}app/exam/styles/image/paper.png{x2;endif}" /></div>
						</div>
						<div class="span3">
							<div class="caption">
								<h3>{x2;$_user['username']}</h3>
								<p>注册日期：{x2;date:$_user['userregtime'],'Y-m-d'}</p>
								<p>注册IP：{x2;$_user['userregip']}</p>
								<p>您现有积分：{x2;$_user['usercoin']}</p>
								<p>&nbsp;</p>
								<p><a class="btn" href="index.php?user-center-payfor">充值</a></p>
							</div>
							<div>&nbsp;</div>
						</div>
						<div class="span3">
							<div class="caption">
								<h3>&nbsp;</h3>
								<p>用户组：{x2;$groups[$_user['usergroupid']]['groupname']}</p>
								<p>真实姓名：{x2;$_user['usertruename']}</p>
								<p>邮箱：{x2;$_user['useremail']}</p>
								<p>&nbsp;</p>
							</div>
							<div>&nbsp;</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>