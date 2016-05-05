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
				<li><a href="index.php?{x2;$_app}-teach">{x2;$apps[$_app]['appname']}</a> <span class="divider">/</span></li>
				<li class="active">科目管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">科目管理</a>
				</li>
				<li class="dropdown pull-right">
					<a href="index.php?exam-teach-basic-addsubject">添加科目</a>
				</li>
			</ul>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>科目ID</th>
						<th>科目名称</th>
						<th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                    {x2;tree:$subjects,subject,sid}
					<tr>
						<td>{x2;v:subject['subjectid']}</td>
						<td>{x2;v:subject['subject']}</td>
						<td>
							<div class="btn-group">
								<a class="btn" href="index.php?exam-teach-basic-section&subjectid={x2;v:subject['subjectid']}&page={x2;$page}&basicid={x2;v:basic['basicid']}{x2;$u}" title="修改模型信息"><em class="icon-th-list"></em></a>
								<a class="btn" href="index.php?exam-teach-basic-modifysubject&subjectid={x2;v:subject['subjectid']}&page={x2;$page}{x2;$u}" title="修改模型信息"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?exam-teach-basic-delsubject&subjectid={x2;v:subject['subjectid']}&page={x2;$page}{x2;$u}" title="删除模型"><em class="icon-remove"></em></a>
							</div>
						</td>
					</tr>
					{x2;endtree}
	        	</tbody>
	        </table>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}