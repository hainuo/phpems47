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
				<li class="active">文件类型</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">文件类型</a>
				</li>
				<li class="pull-right">
					<a href="index.php?{x2;$_app}-master-attachtype-add">添加文件类型</a>
				</li>
			</ul>
	        <form action="index.php?{x2;$_app}-master-attachtype-batdel" method="post">
		        <table class="table table-hover">
		            <thead>
		                <tr>
		                    <th><input type="checkbox" class="checkall"/></th>
		                    <th>类型ID</th>
					        <th>类型名称</th>
					        <th>允许上传扩展名</th>
					        <th>操作</th>
		                </tr>
		            </thead>
		            <tbody>
		                {x2;tree:$types,type,tid}
				        <tr>
							<td>
								<input type="checkbox" name="delids[{x2;v:type['atid']}]" value="1"/>
							</td>
							<td>
								{x2;v:type['atid']}
							</td>
							<td>
								{x2;v:type['attachtype']}
							</td>
							<td>
								{x2;v:type['attachexts']}
							</td>
							<td>
								<div class="btn-group">
									<a class="btn" href="index.php?{x2;$_app}-master-attachtype-modify&page={x2;$page}&atid={x2;v:type['atid']}{x2;$u}" title="修改"><em class="icon-edit"></em></a>
									<a class="btn confirm" href="index.php?{x2;$_app}-master-attachtype-del&atid={x2;v:type['atid']}&page={x2;$page}{x2;$u}" title="删除"><em class="icon-remove"></em></a>
								</div>
							</td>
				        </tr>
				        {x2;endtree}
		        	</tbody>
		        </table>
		        <div class="control-group">
		            <div class="controls">
		            	<button class="btn btn-primary" type="submit">删除</button>
		            </div>
				</div>
			</form>
	        <div class="pagination pagination-right">
				<ul>{x2;$basics['pages']}</ul>
	        </div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}