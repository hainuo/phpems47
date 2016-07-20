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
				<li class="active">分类管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">分类管理</a>
				</li>
				<li class="dropdown pull-right">
					<a href="index.php?exam-master-basic-addtype">添加分类</a>
				</li>
			</ul>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>分类ID</th>
						<th>分类名称</th>
						<th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                    {x2;tree:$types,type,sid}
					<tr>
						<td>{x2;v:type['typeid']}</td>
						<td>{x2;v:type['type']}</td>
						<td>
							<div class="btn-group">
								<a class="btn" href="index.php?exam-master-basic-modifytype&typeid={x2;v:type['typeid']}&page={x2;$page}{x2;$u}" title="修改分类信息"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?exam-master-basic-deltype&typeid={x2;v:type['typeid']}&page={x2;$page}{x2;$u}" title="删除分类"><em class="icon-remove"></em></a>
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