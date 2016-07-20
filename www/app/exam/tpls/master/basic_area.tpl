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
				<li class="active">地区设置</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">地区设置</a>
				</li>
				<li class="dropdown pull-right">
					<a href="index.php?exam-master-basic-addarea&page={x2;$page}{x2;$u}">添加地区</a>
				</li>
			</ul>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>地区ID</th>
	                    <th>区号</th>
						<th>地区名称</th>
						<th>默认</th>
						<th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                    {x2;tree:$areas['data'],area,aid}
					<tr>
						<td>{x2;v:area['areaid']}</td>
						<td>{x2;v:area['areacode']}</td>
						<td>{x2;v:area['area']}</td>
						<td>{x2;if:v:area['arealevel']}<em class="icon-ok"></em>{x2;else}<em class="icon-remove"></em>{x2;endif}</td>
						<td>
							<div class="btn-group">
	                    		<a class="btn" href="index.php?exam-master-basic&search[basicareaid]={x2;v:area['areaid']}&page={x2;$page}{x2;$u}" title="考场"><em class="icon-th-list"></em></a>
	                    		<a class="btn" href="index.php?exam-master-basic-modifyarea&areaid={x2;v:area['areaid']}&page={x2;$page}{x2;$u}" title="修改"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?exam-master-basic-delarea&areaid={x2;v:area['areaid']}&page={x2;$page}{x2;$u}" title="删除"><em class="icon-remove"></em></a>
	                    	</div>
						</td>
					</tr>
					{x2;endtree}
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
				<ul>{x2;$areas['pages']}</ul>
			</div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}