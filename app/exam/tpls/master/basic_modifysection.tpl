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
				<li><a href="index.php?{x2;$_app}-master-basic-subject">科目管理</a> <span class="divider">/</span></li>
				<li><a href="index.php?{x2;$_app}-master-basic-section&subjectid={x2;$subjectid}&page={x2;$page}">科目管理</a> <span class="divider">/</span></li>
				<li class="active">添加章节</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">添加章节</a>
				</li>
				<li class="pull-right">
					<a href="index.php?exam-master-basic-section&subjectid={x2;$subjectid}&page={x2;$page}">章节管理</a>
				</li>
			</ul>
        	<form action="index.php?exam-master-basic-modifysection" method="post" class="form-horizontal">
				<fieldset>
    			<legend>{x2;$subjects[$section['sectionsubjectid']]['subject']}</legend>
    			<div class="control-group">
					<label for="section" class="control-label">章节名称：</label>
					<div class="controls">
						<input name="args[section]" id="section" type="text" size="30" value="{x2;$section['section']}" class="required" alt="请输入章节名称"/>
					</div>
				</div>
				<div class="control-group">
				  	<div class="controls">
					  	<button class="btn btn-primary" type="submit">提交</button>
						<input type="hidden" name="sectionid" value="{x2;$section['sectionid']}"/>
						<input type="hidden" name="page" value="{x2;$page}"/>
						<input type="hidden" name="modifysection" value="1"/>
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