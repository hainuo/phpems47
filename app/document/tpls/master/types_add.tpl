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
				<li><a href="index.php?{x2;$_app}-master-attachtype">文件类型</a> <span class="divider">/</span></li>
				<li class="active">添加文件类型</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">添加文件类型</a>
				</li>
				<li class="dropdown pull-right">
					<a href="index.php?{x2;$_app}-master-attachtype">文件类型</a>
				</li>
			</ul>
			<form action="index.php?{x2;$_app}-master-attachtype-add" method="post" class="form-horizontal">
				<fieldset>
				<div class="control-group">
					<label for="basic" class="control-label">文件类型</label>
					<div class="controls">
						<input id="basic" name="args[attachtype]" type="text" value="{x2;$attachtype['attachtype']}" needle="needle" msg="您必须文件类型" />
					</div>
				</div>
				<div class="control-group">
					<label for="basicapi" class="control-label">扩展名</label>
					<div class="controls">
						<input id="basicapi" name="args[attachexts]" type="text" value="{x2;$attachtype['attachexts']}" needle="needle" msg="您必须填写文件类型扩展名"/>
						<span class="help-block">多个扩展名之间用英文逗号隔开</span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-primary" type="submit">提交</button>
						<input type="hidden" name="page" value="{x2;$page}"/>
						<input type="hidden" name="inserttype" value="1"/>
						{x2;tree:$search,arg,aid}
						<input type="hidden" name="search[{x2;v:key}]" value="{x2;v:arg}"/>
						{x2;endtree}
					</div>
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