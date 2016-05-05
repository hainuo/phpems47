{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			{x2;include:menu}
		</div>
		<div class="span10" id="datacontent">
			<ul class="breadcrumb">
				<li><a href="index.php?{x2;$_app}-master">{x2;$apps[$_app]['appname']}</a> <span class="divider">/</span></li>
				<li><a href="index.php?{x2;$_app}-master-module">模型管理</a> <span class="divider">/</span></li>
				<li class="active">模型预览</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">模型预览</a>
				</li>
				<li class="dropdown pull-right">
					 <a class="dropdown-toggle" href="#" data-toggle="dropdown">模型列表<strong class="caret"></strong></a>
					<ul class="dropdown-menu">
						<li>
							<a href="index.php?user-master-module">模型列表</a>
						</li>
						<li class="divider">
						</li>
						<li>
							<a href="index.php?user-master-module-fields&moduleid={x2;$module['moduleid']}">字段管理</a>
						</li>
					</ul>
				</li>
			</ul>
			<form class="form-horizontal">
				<fieldset>
					<legend>{x2;$module['modulename']}</legend>
					{x2;tree:$forms,form,fid}
					<div class="control-group">
						<label for="{x2;v:form['id']}">{x2;v:form['title']}：</label>
						{x2;v:form['html']}
					</div>
					{x2;endtree}
				</fieldset>
			</form>
		</div>
	</div>
</div>
</body>
</html>