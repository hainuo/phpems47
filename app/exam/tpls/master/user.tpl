{x2;if:!$userhash}
{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			{x2;include:menu}
		</div>
		<div class="span10" id="datacontent">
{x2;endif}
			<ul class="breadcrumb">
				<li><a href="index.php?{x2;$_app}-master">{x2;$apps[$_app]['appname']}</a> <span class="divider">/</span></li>
				<li class="active">开通课程</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">开通课程</a>
				</li>
			</ul>
	        <form action="index.php?exam-master-users" method="post">
				<table class="table">
					<thead>
						<tr>
							<th colspan="5">搜索</th>
						</tr>
					</thead>
					<tr>
						<td>
							用户ID：
						</td>
						<td class="input">
							<input name="search[userid]" class="inline" size="25" type="text" class="number" value="{x2;$search['userid']}"/>
						</td>
						<td>
							用户名：
						</td>
						<td class="input">
							<input class="inline" name="search[username]" size="25" type="text" value="{x2;$search['username']}"/>
						</td>
						<td>
							<button class="btn btn-primary" type="submit">搜索</button>
							<input type="hidden" value="1" name="search[argsmodel]" />
						</td>
					</tr>
				</table>
			</form>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>ID</th>
				        <th>用户名</th>
				        <th>电子邮件</th>
				        <th>注册IP</th>
				        <th>积分点数</th>
				        <th>角色</th>
				        <th>注册时间</th>
				        <th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
	            	{x2;tree:$users['data'],user,uid}
	            	<tr>
	                    <td>{x2;v:user['userid']}</td>
	                    <td>{x2;v:user['username']}</td>
						<td>{x2;v:user['useremail']}</td><td>{x2;v:user['userregip']}</td>
						<td>{x2;v:user['usercoin']}</td><td>{x2;$groups[v:user['usergroupid']]['groupname']}</td>
						<td>{x2;date:v:user['userregtime'],'Y-m-d H:i:s'}</td>
						<td>
						  	<div class="btn-group">
	                    		<a class="btn" href="index.php?exam-master-users-basics&userid={x2;v:user['userid']}{x2;$u}" title="开通课程"><em class="icon-th-list"></em></a>
							</div>
						</td>
	                </tr>
	                {x2;endtree}
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
	            <ul>{x2;$users['pages']}</ul>
	        </div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}