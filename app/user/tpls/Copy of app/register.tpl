{x2;include:header}
<body>
{x2;include:nav}
<div class="row-fluid">
	<div class="container-fluid logcontent">
		<div class="logbox">
			<form class="form-horizontal logform" method="post" action="index.php?user-app-register">
				<fieldset>
					<legend>注册用户</legend>
					<div class="logcontrol">
						<div class="control-group">
							<label class="control-label" for="inputEmail">用户名：</label>
							<div class="controls">
								<input class="input-xlarge" type="text" type="text" name="args[username]" datatype="userName" needle="needle" msg="请你输入用户名"/><span>请输入可用的用户名</span>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputEmail">邮箱：</label>
							<div class="controls">
								<input class="input-xlarge" type="text" name="args[useremail]" datatype="email" needle="needle" msg="请你输入邮箱"/><span>请输入可用的电子邮箱地址</span>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputPassword">密码：</label>
							<div class="controls">
								<input class="input-xlarge" type="password" id="inputPassword" name="args[userpassword]" datatype="password" needle="needle" msg="请你输入密码"/><span>密码长度6位以上，数字、字母或其他字符</span>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputPassword">重复密码：</label>
							<div class="controls">
								<input class="input-xlarge" type="password" id="inputPassword2" equ="inputPassword" needle="needle" datatype="password" msg="重复密码必须和之前的密码一致"/><span>两次输入的密码必须一致</span>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<button class="btn btn-info logbtn" type="submit">立即注册</button>
								<input type="hidden" value="1" name="userregister"/>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<p>点击“立即注册”，即表示您同意并愿意遵守本站用户协议和隐私政策，如果您已有帐号，请在此<a href="index.php?user-app-login">登录</a></p>
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