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
					<a href="#">修改分类</a>
				</li>
			</ul>
	        <form action="index.php?exam-master-basic-modifytype" method="post" class="form-horizontal">
				<fieldset>
					<div class="control-group">
						<label for="type" class="control-label">分类名称：</label>
						<div class="controls">
							<input name="args[type]" id="type" type="text" size="30" value="{x2;$type['type']}" needle="needle" msg="您必须输入一个分类名称" />
						</div>
					</div>
					<div class="control-group">
						<label for="type" class="control-label">分类题型：</label>
						<div class="controls">
							<textarea class="ckeditor" name="args[comment]" id="comment" autocomplete="off" style="visibility: hidden; display: none;">{x2;$type['comment']}</textarea>
						</div>
					</div>
					<div class="control-group">
						<label for="type" class="control-label">分类名称：</label>
						<div class="controls">
							<input name="args[sort]" id="sort" type="text" size="3" value="{x2;$type['sort']}" needle="needle" msg="您必须输入一个分类名称" />
						</div>
					</div>
					<div class="control-group">
					  	<div class="controls">
						  	<button class="btn btn-primary" type="submit">提交</button>
							<input type="hidden" name="modifytype" value="1"/>
							<input type="hidden" name="typeid" value="{x2;$type['typeid']}"/>
							<input type="hidden" name="page" value="{x2;$page}"/>
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