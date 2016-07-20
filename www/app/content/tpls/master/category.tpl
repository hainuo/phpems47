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
					<a href="javascript:;" onclick="javascript:openall();">分类管理</a>
				</li>
				<li class="dropdown pull-right">
					<a class="dropdown-toggle" href="#" data-toggle="dropdown">添加分类<strong class="caret"></strong></a>
					<ul class="dropdown-menu">
						<li><a href="index.php?{x2;$_app}-master-category-add&parent={x2;$parent}">添加分类</a></li>
						<li><a href="index.php?{x2;$_app}-master-category&parent={x2;$categories[$parent]['catparent']}">上级分类</a></li>
                    </ul>
				</li>
			</ul>
			<legend>{x2;if:$parent}{x2;$categories[$parent]['catname']}{x2;else}一级分类{x2;endif}</legend>
			<form action="index.php?content-master-category-lite" method="post">
				<fieldset>
					<table class="table table-hover">
						<thead>
							<tr>
								<th width="80">排序</th>
								<th width="80">ID</th>
								<th width="80">缩略图</th>
								<th>分类名称</th>
								<th width="120">操作</th>
							</tr>
						</thead>
						<tbody>
							{x2;tree:$categorys['data'],category,cid}
							<tr>
								<td><input type="text" name="ids[{x2;v:category['catid']}]" value="{x2;v:category['catlite']}" style="width:24px;padding:2px 5px;"/></td>
								<td>{x2;v:category['catid']}</td>
								<td><img src="{x2;if:v:category['catimg']}{x2;v:category['catimg']}{x2;else}app/core/styles/images/noupload.gif{x2;endif}" alt="" style="width:24px;"/></td>
								<td><a onclick="javascript:openmenu(this);" href="javascript:void(0);" class="icon-plus-sign catool" rel="{x2;v:category['catid']}" data="0" app="{x2;$_app}"></a><span>{x2;v:category['catname']}</span></td>
								<td>
									<div class="btn-group">
										<a class="btn" href="index.php?{x2;$_app}-master-category-add&parent={x2;v:category['catid']}{x2;$u}"><em class="icon-plus"></em></a>
										<a class="btn" href="index.php?{x2;$_app}-master-category-edit&page={x2;$page}&catid={x2;v:category['catid']}{x2;$u}"><em class="icon-edit"></em></a>
										<a class="btn ajax" href="index.php?{x2;$_app}-master-category-del&catid={x2;v:category['catid']}&page={x2;$page}{x2;$u}"><em class="icon-remove"></em></a>
									</div>
								</td>
							</tr>
							{x2;endtree}
						</tbody>
					</table>
					<div class="control-group">
			            <div class="controls">
				            {x2;tree:$search,arg,sid}
				            <input type="hidden" name="search[{x2;v:key}]" value="{x2;v:arg}"/>
				            {x2;endtree}
				            <label class="radio inline">
				            	<button class="btn btn-primary" type="submit">更改排序</button>
				            </label>
				            <input type="hidden" name="modifycategorysequence" value="1"/>
				            <input type="hidden" name="page" value="{x2;$page}"/>
				        </div>
			        </div>
					<div class="pagination pagination-right">
						<ul>{x2;$categorys['pages']}</ul>
					</div>
				</fieldset>
			</form>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}