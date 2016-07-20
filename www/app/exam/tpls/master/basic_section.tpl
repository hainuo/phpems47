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
				<li><a href="index.php?{x2;$_app}-master-basic-subject">科目管理</a> <span class="divider">/</span></li>
				<li class="active">章节管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">章节管理</a>
				</li>
				<li class="pull-right">
					<a href="index.php?exam-master-basic-addsection&subjectid={x2;$subjectid}">添加章节</a>
				</li>
			</ul>
			<legend>{x2;$subjects[$subjectid]['subject']}</legend>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>章节ID</th>
						<th>章节名称</th>
						<th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                    {x2;tree:$sections['data'],section,sid}
					<tr>
						<td>{x2;v:section['sectionid']}</td>
						<td>{x2;v:section['section']}</td>
						<td>
							<div class="btn-group">
								<a class="btn ajax" href="index.php?exam-master-basic-output&sectionid={x2;v:section['sectionid']}&page={x2;$page}{x2;$u}" title="导出题库"><em class="icon-download-alt"></em></a>
								<a class="btn" href="index.php?exam-master-basic-point&sectionid={x2;v:section['sectionid']}&page=1&basicid={x2;v:basic['basicid']}{x2;$u}" title="章节列表"><em class="icon-th-list"></em></a>
								<a class="btn" href="index.php?exam-master-basic-modifysection&sectionid={x2;v:section['sectionid']}&page={x2;$page}{x2;$u}" title="修改章节信息"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?exam-master-basic-delsection&sectionid={x2;v:section['sectionid']}&page={x2;$page}{x2;$u}" title="删除章节"><em class="icon-remove"></em></a>
							</div>
						</td>
					</tr>
					{x2;endtree}
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
	            <ul>{x2;$sections['pages']}</ul>
	        </div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}