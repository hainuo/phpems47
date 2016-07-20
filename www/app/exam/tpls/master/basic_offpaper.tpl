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
				<li><a href="index.php?{x2;$_app}-master-basic&page={x2;$page}{x2;$u}">考场管理</a> <span class="divider">/</span></li>
				<li class="active">考试调度</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">考试调度</a>
				</li>
			</ul>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>SessionId</th>
						<th>用户名</th>
						<th>真实姓名</th>
						<th>试卷名</th>
						<th>开考时间</th>
						<th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                    {x2;tree:$sessionusers['data'],user,uid}
					<tr>
						<td>{x2;v:user['examsessionid']}</td>
						<td>{x2;v:user['username']}</td>
						<td>{x2;v:user['usertruename']}</td>
						<td>{x2;v:user['examsessionsetting']['exam']}</td>
						<td>{x2;date:v:user['examsessionstarttime'],'m-d H:i'}</td>
						<td>
							<div class="btn-group">
								<!--
								<a class="btn" href="index.php?exam-master-basic-modifysubject&subjectid={x2;v:subject['subjectid']}&page={x2;$page}{x2;$u}" title="修改模型信息"><em class="icon-edit"></em></a>
								-->
								<a class="btn confirm" msg="确定要强行收卷？" href="index.php?exam-master-basic-savepaper&examsessionid={x2;v:user['examsessionid']}" title="强行收卷"><em class="icon-remove"></em></a>
							</div>
						</td>
					</tr>
					{x2;endtree}
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
	            <ul>{x2;$sessionusers['pages']}</ul>
	        </div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}