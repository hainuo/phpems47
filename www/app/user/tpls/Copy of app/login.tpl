{x2;include:header}
<body>
{x2;include:nav}
<div class="row-fluid">
	<div class="container-fluid logcontent">
		<div class="logbox exambox">
			<form class="form-horizontal logform" method="post" action="index.php?user-app-login">
				<fieldset>
					<legend>用户登录</legend>
					<div class="logcontrol">
						<div class="control-group">
							<label class="control-label" for="inputEmail">用户名：</label>
							<div class="controls">
								<input class="input-xlarge" type="text" name="args[username]" datatype="userName" needle="needle" msg="请你输入用户名" value="guest"/><span>请输入您的用户名</span>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputPassword">密码：</label>
							<div class="controls">
								<input class="input-xlarge" type="password" name="args[userpassword]" datatype="password" needle="needle" msg="请你输入密码" value="123456"/><span>密码长度6位以上，数字、字母或其他字符</span>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<input type="hidden" value="1" name="userlogin"/>
								<button class="btn btn-info logbtn" type="submit">登录</button>
								<button onclick="javascript:window.location='index.php?user-app-register';" type="button" class="btn logbtn">注册</button>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<p>请输入正确的用户名和密码登录　如果您还没有帐号，请在此<a href="index.php?user-app-register">注册</a></p>
							</div>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
		<div class="logbotm"></div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	window.localStorage.removeItem('questions');
});
</script>
{x2;include:foot}
</body>
</html>