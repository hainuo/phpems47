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
				<li><a href="index.php?{x2;$_app}-master-basic-section&subjectid={x2;$section['sectionsubjectid']}&page={x2;$page}">章节管理</a> <span class="divider">/</span></li>
				<li class="active">知识点管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">知识点管理</a>
				</li>
				<li class="pull-right">
					<a href="index.php?exam-master-basic-addpoint&sectionid={x2;$section['sectionid']}&page={x2;$page}{x2;$u}">添加知识点</a>
				</li>
			</ul>
	        <form action="index.php?exam-master-basic-addpoint" method="post" class="form-horizontal">
				<fieldset>
				<legend>{x2;$section['section']}</legend>
				<div class="control-group">
					<label for="knows" class="control-label">知识点名称：</label>
					<div class="controls">
						<input id="knows" name="args[knows]" type="text" size="30" value="" needle="needle" msg="请输入知识点名称" />
						<span class="help-block">可用通过英文逗号隔开多个知识点名称来批量录入</span>
					</div>
				</div>
				<div class="control-group">
				  	<div class="controls">
						<button class="btn btn-primary" type="submit">提交</button>
						<input type="hidden" name="insertknows" value="1"/>
						<input type="hidden" name="page" value="{x2;$page}"/>
						<input type="hidden" name="args[knowssectionid]" value="{x2;$section['sectionid']}"/>
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
		</div>