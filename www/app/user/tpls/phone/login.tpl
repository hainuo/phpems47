{x2;include:header}
<body>
<div class="row-fluid top">
	<div class="container-fluid">
		<div class="span12"><h3><img src="app/user/styles/img/theme/logo.png" style="margin-top:-21px;"/></h3></div>
	</div>
</div>
<div class="row-fluid">
	<div class="container-fluid logcontent">
		<div class="logbox">
			<form class="logform" method="post" action="index.php?user-phone-login">
				<fieldset>
					<div class="logcontrol">
						<div class="control-group">
							<label class="control-label" for="inputEmail">用户名：</label>
							<div class="controls">
								<input class="span11" type="text" name="args[username]" datatype="userName" needle="needle" msg="请你输入用户名" value="peadmin"/>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputPassword">密码：</label>
							<div class="controls">
								<input class="span11" type="password" name="args[userpassword]" datatype="password" needle="needle" msg="请你输入密码" value="peadmin"/>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<input type="hidden" value="1" name="userlogin"/>
								<button class="btn btn-info logbtn" type="submit">登录</button>
								<button onclick="javascript:window.location='index.php?user-phone-register';" type="button" class="btn logbtn pull-right">注册</button>
							</div>
						</div>
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