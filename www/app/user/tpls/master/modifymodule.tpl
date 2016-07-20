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
				<li><a href="index.php?{x2;$_app}-master-module">用户模型</a> <span class="divider">/</span></li>
				<li class="active">修改模型</li>
			</ul>
	    	<form action="?user-master-module-modify" method="post" class="form-horizontal">
				<fieldset>
					<legend>{x2;$module['modulename']}</legend>
					<div class="control-group">
						<label for="modulename" class="control-label">模型名称：</label>
						<div class="controls">
							<input type="text" size="40" name="args[modulename]" needle="needle" datatype="username" id="modulename" value="{x2;$module['modulename']}"/>
						</div>
					</div>
			        <div class="control-group">
				        <label class="control-label" for="moduledescribe">模型描述：</label>
		          		<div class="controls">
		          			<textarea rows="7" class="input-xxlarge" name="args[moduledescribe]" id="moduledescribe">{x2;$module['moduledescribe']}</textarea>
			        	</div>
			        </div>
			        <div class="control-group">
						<div class="controls">
							<button class="btn btn-primary" type="submit">提交</button>
				        	<input type="hidden" name="moduleid" value="{x2;$module['moduleid']}"/>
				        	<input type="hidden" name="modifymodule" value="1"/>
							<input type="hidden" name="page" value="{x2;$page}"/>
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