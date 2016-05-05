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
				<li><a href="index.php?{x2;$_app}-teach-basic-subject">科目管理</a> <span class="divider">/</span></li>
				<li><a href="index.php?{x2;$_app}-teach-basic-section&subjectid={x2;$section['sectionsubjectid']}">章节管理</a> <span class="divider">/</span></li>
				<li class="active">知识点管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">知识点管理</a>
				</li>
				<li class="pull-right">
					<a href="index.php?exam-teach-basic-addpoint&sectionid={x2;$section['sectionid']}{x2;$u}">添加知识点</a>
				</li>
			</ul>
			<legend>{x2;$section['section']}</legend>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>知识点ID</th>
						<th>知识点名称</th>
						<th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                    {x2;tree:$knows['data'],know,kid}
					<tr>
						<td>{x2;v:know['knowsid']}</td>
						<td>{x2;v:know['knows']}</td>
						<td>
							<div class="btn-group">
								<a class="btn" href="index.php?{x2;$_app}-teach-basic-modifypoint&knowsid={x2;v:know['knowsid']}&page={x2;$page}{x2;$u}" title="修改知识点"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?{x2;$_app}-teach-basic-delpoint&sectionid={x2;v:know['knowssectionid']}&knowsid={x2;v:know['knowsid']}&page={x2;$page}{x2;$u}" title="删除知识点"><em class="icon-remove"></em></a>
							</div>
						</td>
					</tr>
					{x2;endtree}
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
	            <ul>{x2;$knows['pages']}</ul>
	        </div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}