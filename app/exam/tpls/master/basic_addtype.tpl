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
				<li><a href="index.php?{x2;$_app}-master-basic-type">分类管理</a> <span class="divider">/</span></li>
				<li class="active">添加分类</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">添加分类</a>
				</li>
				<li class="dropdown pull-right">
					<a href="index.php?exam-master-basic-type">分类管理</a>
				</li>
			</ul>
	        <form action="index.php?exam-master-basic-addtype" method="post" class="form-horizontal">
				<fieldset>
					<div class="control-group">
						<label for="type" class="control-label">分类名称：</label>
						<div class="controls">
							<input name="args[type]" id="type" type="text" size="30" value="" needle="needle" msg="您必须输入一个分类名称" />
						</div>
					</div>
					<div class="control-group">
						<label for="type" class="control-label">分类说明：</label>
						<div class="controls">
							<textarea class="ckeditor" name="args[comment]" id="comment" autocomplete="off" style="visibility: hidden; display: none;"></textarea>
						</div>
					</div>
                    <div class="control-group">
                        <label for="type" class="control-label">分类名称：</label>
                        <div class="controls">
                            <input name="args[sort]" id="sort" type="text" size="3" value="0" needle="needle" msg="您必须输入一个分类名称" />
                        </div>
                    </div>
					<div class="control-group">
					  	<div class="controls">
						  	<button class="btn btn-primary" type="submit">提交</button>
							<input type="hidden" name="inserttype" value="1"/>
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