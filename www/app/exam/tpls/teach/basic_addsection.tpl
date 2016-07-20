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
				<li><a href="index.php?{x2;$_app}-teach">{x2;$apps[$_app]['appname']}</a> <span class="divider">/</span></li>
				<li><a href="index.php?{x2;$_app}-teach-basic-subject">科目管理</a> <span class="divider">/</span></li>
				<li><a href="index.php?{x2;$_app}-teach-basic-section&subjectid={x2;$subjectid}&page={x2;$page}">科目管理</a> <span class="divider">/</span></li>
				<li class="active">添加章节</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">添加章节</a>
				</li>
				<li class="pull-right">
					<a href="index.php?exam-teach-basic-section&subjectid={x2;$subjectid}&page={x2;$page}">章节管理</a>
				</li>
			</ul>
			<form action="index.php?exam-teach-basic-addsection" method="post" class="form-horizontal">
    			<fieldset>
    			<legend>{x2;$subjects[$subjectid]['subject']}</legend>
				<div class="control-group">
					<label for="section" class="control-label">章节名称：</label>
					<div class="controls">
						<input id="section" name="args[section]" type="text" size="30" value="" needle="needle" msg="请输入章节名称" />
					</div>
				</div>
				<div class="control-group">
				  	<div class="controls">
						<button class="btn btn-primary" type="submit">提交</button>
						<input type="hidden" name="insertsection" value="1"/>
						<input type="hidden" name="page" value="{x2;$page}"/>
						<input type="hidden" name="args[sectionsubjectid]" value="{x2;$subjectid}"/>
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