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
				<li class="active">标签管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">标签管理</a>
				</li>
				<li class="pull-right">
					<a href="index.php?content-master-blocks-add&page={x2;$page}">添加标签</a>
				</li>
			</ul>
			<table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>ID</th>
				        <th>名称</th>
				        <th>位置</th>
				        <th>类型</th>
				        <th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
	            	{x2;tree:$blocks['data'],block,kid}
	            	<tr>
	                    <td>{x2;v:block['blockid']}</td>
				        <td>{x2;v:block['block']}</td>
				        <td>{x2;v:block['blockposition']}</td>
				        <td>
				        	<div class="dropdown">
					        	<a class="dropdown-toggle" href="#" data-toggle="dropdown">{x2;if:v:block['blocktype'] == 1}固定内容{x2;elseif:v:block['blocktype'] == 2}分类列表{x2;elseif:v:block['blocktype'] == 3}SQL{x2;elseif:v:block['blocktype'] == 4}模板模式{x2;endif}<strong class="caret"></strong></a>
					        	<ul class="dropdown-menu">
						        	<li><a href="javascript:;">切换模式</a></li>
									<li class="divider"></li>
									<li><a class="ajax" href="index.php?{x2;$_app}-master-blocks-change&blockid={x2;v:block['blockid']}&blocktype=1&page={x2;$page}">固定内容</a></li>
									<li><a class="ajax" href="index.php?{x2;$_app}-master-blocks-change&blockid={x2;v:block['blockid']}&blocktype=2&page={x2;$page}">分类列表</a></li>
									<li><a class="ajax" href="index.php?{x2;$_app}-master-blocks-change&blockid={x2;v:block['blockid']}&blocktype=3&page={x2;$page}">SQL模式</a></li>
									<li><a class="ajax" href="index.php?{x2;$_app}-master-blocks-change&blockid={x2;v:block['blockid']}&blocktype=4&page={x2;$page}">模板模式</a></li>
			                    </ul>
		                    </div>
				        </td>
				        <td>
				        	<div class="btn-group">
								<a class="btn" href="index.php?{x2;$_app}-master-blocks-modify&blockid={x2;v:block['blockid']}&page={x2;$page}" title="修改模型信息"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?{x2;$_app}-master-blocks-del&blockid={x2;v:block['blockid']}&page={x2;$page}" title="删除模型"><em class="icon-remove"></em></a>
							</div>
						</td>
	                </tr>
	                {x2;endtree}
	        	</tbody>
	        </table>
			<div class="pagination pagination-right">
				<ul>{x2;$blocks['pages']}</ul>
			</div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}