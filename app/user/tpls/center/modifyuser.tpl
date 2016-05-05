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
					<div id="tabs-694325" class="tabbable">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#panel-344373" data-toggle="tab">用户资料</a>
							</li>
							<li>
								<a href="#panel-788885" data-toggle="tab">修改密码</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="panel-344373" class="tab-pane active">
								<form action="index.php?user-center-privatement" method="post" class="form-horizontal">
									<fieldset>
										<legend>{x2;$user['username']}</legend>
										{x2;tree:$forms,form,fid}
										<div class="control-group">
											<label for="{x2;v:form['id']}" class="control-label">{x2;v:form['title']}：</label>
											<div class="controls">
											{x2;v:form['html']}
											</div>
										</div>
										{x2;endtree}
										<div class="control-group">
											<div class="controls">
												<button class="btn btn-primary" type="submit">提交</button>
												<input type="hidden" name="modifyuserinfo" value="1"/>
												<input type="hidden" name="page" value="{x2;$page}"/>
												{x2;tree:$search,arg,aid}
												<input type="hidden" name="search[{x2;v:key}]" value="{x2;v:arg}"/>
												{x2;endtree}
											</div>
										</div>
									</fieldset>
								</form>
							</div>
							<div id="panel-788885" class="tab-pane">
								<form action="index.php?user-center-privatement" method="post" class="form-horizontal">
									<fieldset>
										<legend>{x2;$user['username']}</legend>
										<div class="control-group">
											<label for="oldpassowrd" class="control-label">旧密码：</label>
											<div class="controls">
												<input id="oldpassowrd" type="password" name="oldpassword" needle="true" datatype="password" msg="密码字数必须在6位以上"/>
											</div>
										</div>
										<div class="control-group">
											<label for="passowrd1" class="control-label">新密码：</label>
											<div class="controls">
												<input id="passowrd1" type="password" name="args[password]" needle="true" datatype="password" msg="密码字数必须在6位以上"/>
											</div>
										</div>
										<div class="control-group">
											<label for="password2" class="control-label">重复密码：</label>
											<div class="controls">
												<input id="password2" type="password" name="args[password2]" needle="true" equ="passowrd1" msg="前后两次密码必须一致且不能为空"/>
											</div>
										</div>
										<div class="control-group">
											<div class="controls">
												<button class="btn btn-primary" type="submit">提交</button>
												<input type="hidden" name="modifyuserpassword" value="1"/>
												<input type="hidden" name="page" value="{x2;$page}"/>
												{x2;tree:$search,arg,aid}
												<input type="hidden" name="search[{x2;v:key}]" value="{x2;v:arg}"/>
												{x2;endtree}
											</div>
										</div>
									</fieldset>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>