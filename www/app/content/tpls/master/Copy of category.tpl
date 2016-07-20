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
					<a class="dropdown-toggle" href="#" data-toggle="dropdown">添加分类<strong class="caret"></strong></a>
					<ul class="dropdown-menu">
						<li><a href="index.php?{x2;$_app}-master-category-add&parent={x2;$parent}">添加分类</a></li>
						<li><a href="index.php?{x2;$_app}-master-category&parent={x2;$categories[$parent]['catparent']}">上级分类</a></li>
                    </ul>
				</li>
			</ul>
			<legend>{x2;if:$parent}{x2;$categories[$parent]['catname']}{x2;else}一级分类{x2;endif}</legend>
			{x2;tree:$categorys['data'],category,cid}
			<div class="media well">
				{x2;if:v:category['catimg']}
				<a class="pull-left plugin" href="index.php?{x2;$_app}-master-category&parent={x2;v:category['catid']}"><img class="media-object" src="{x2;v:category['catimg']}"></a>
				{x2;else}
				<a class="pull-left plugin" href="index.php?{x2;$_app}-master-category&parent={x2;v:category['catid']}"><img class="media-object" src="app/core/styles/images/noupload.gif"></a>
				{x2;endif}
				<div class="media-body">
                	<h4 class="media-heading"><a href="index.php?{x2;$_app}-master-category&parent={x2;v:category['catid']}">{x2;v:category['catname']}</a></h4>
                	<div>【ID:{x2;v:category['catid']}】{x2;substring:strip_tags(html_entity_decode(v:category['catdes'])),135}</div>
                	<div class="pull-right">
	                	<div class="btn-group">
							<a class="btn" href="index.php?{x2;$_app}-master-contents&catid={x2;v:category['catid']}&page={x2;$page}{x2;$u}"><em class="icon-th-list"></em></a>
							<a class="btn" href="index.php?{x2;$_app}-master-category-edit&page={x2;$page}&catid={x2;v:category['catid']}{x2;$u}"><em class="icon-edit"></em></a>
							<a class="btn ajax" href="index.php?{x2;$_app}-master-category-del&catid={x2;v:category['catid']}&page={x2;$page}{x2;$u}"><em class="icon-remove"></em></a>
						</div>
					</div>
                </div>
            </div>
            {x2;endtree}
			<div class="pagination pagination-right">
				<ul>{x2;$categorys['pages']}</ul>
			</div>

{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}