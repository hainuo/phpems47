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
				<li><a href="index.php?user-master-module">模型管理</a> <span class="divider">/</span></li>
				<li class="active">添加模型</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">添加模型</a>
				</li>
				<li class="pull-right">
					<a href="index.php?user-master-module">模型列表</a>
				</li>
			</ul>
			<form action="index.php?user-master-module-add" method="post" class="form-horizontal">
				<fieldset>
					<div class="control-group">
					</div>
					<div class="control-group">
						<label for="modulename" class="control-label">模型名</label>
						<div class="controls">
							<input id="modulename" name="args[modulename]" type="text" value="" needle="needle" min="2" max="40" alt="请输入模型名称" msg="模型名称为不超过40字的中英文字符且不能为空"/>
							<span class="help-block">请输入模型名称</span>
						</div>
					</div>
					<div class="control-group">
						<label for="modulecode" class="control-label">模型代码</label>
						<div class="controls">
							<input id="modulecode" name="args[modulecode]" type="text" value="" needle="needle" datatype="english" max="12" alt="请输入模型代码" msg="模型代码为不超过12字的英文字符"/>
							<span class="help-block">请输入12字以内的英文模型代码</span>
						</div>
					</div>
					<div class="control-group">
						<label for="moduledescribe" class="control-label">模型描述</label>
						<div class="controls">
							<textarea class="input-xxlarge" rows="7" id="moduledescribe" name="args[moduledescribe]"></textarea>
							<span class="help-block">对这个模型进行描述</span>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<button class="btn btn-primary" type="submit">提交</button>
							<input type="hidden" name="insertmodule" value="1"/>
							<input type="hidden" name="page" value="{x2;$page}"/>
							{x2;tree:$search,arg,aid}
							<input type="hidden" name="search[{x2;v:key}]" value="{x2;v:arg}"/>
							{x2;endtree}
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
</body>
</html>