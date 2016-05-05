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
			<form class="logform" method="post" action="index.php?user-phone-register">
				<fieldset>
					<div class="logcontrol">
						<div class="control-group">
							<label class="control-label" for="inputEmail">用户名：</label>
							<div class="controls">
								<input class="span11" type="text" type="text" name="args[username]" datatype="userName" needle="needle" msg="请你输入用户名"/>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputEmail">邮箱：</label>
							<div class="controls">
								<input class="span11" type="text" name="args[useremail]" datatype="email" needle="needle" msg="请你输入邮箱"/>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputPassword">密码：</label>
							<div class="controls">
								<input class="span11" type="password" id="inputPassword" name="args[userpassword]" datatype="password" needle="needle" msg="请你输入密码"/>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputPassword">重复密码：</label>
							<div class="controls">
								<input class="span11" type="password" id="inputPassword2" equ="inputPassword" needle="needle" datatype="password" msg="重复密码必须和之前的密码一致"/>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<button class="btn btn-info logbtn" type="submit">注册</button>
								<input type="hidden" value="1" name="userregister"/>
								<button onclick="javascript:window.location='index.php?user-phone-login';" type="button" class="btn logbtn pull-right">登录</button>
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