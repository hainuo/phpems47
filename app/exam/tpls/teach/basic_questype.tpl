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
				<li class="active">题型管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">题型管理</a>
				</li>
				<li class="pull-right">
					<a href="index.php?exam-teach-basic-addquestype&page={x2;$page}{x2;$u}">添加题型</a>
				</li>
			</ul>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>题型ID</th>
						<th>题型</th>
						<th>题型分类</th>
						<th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                    {x2;tree:$questypes,questype,qid}
					<tr>
						<td>{x2;v:questype['questid']}</td>
						<td>{x2;v:questype['questype']}</td>
						<td>{x2;if:v:questype['questsort']}主观题{x2;else}客观题{x2;endif}</td>
						<td>
			          		<div class="btn-group">
								<a class="btn" href="index.php?exam-teach-basic-modifyquestype&questid={x2;v:questype['questid']}&page={x2;$page}{x2;$u}" title="修改"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?exam-teach-basic-delquestype&questid={x2;v:questype['questid']}&page={x2;$page}{x2;$u}" title="删除"><em class="icon-remove"></em></a>
							</div>
			          	</td>
					</tr>
					{x2;endtree}
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
        		<ul>{x2;$questypes['pages']}</ul>
	        </div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}