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
				<li><a href="index.php?{x2;$_app}-teach-basic">科目管理</a> <span class="divider">/</span></li>
				<li><a href="index.php?{x2;$_app}-teach-basic-section&subjectid={x2;$section['sectionsubjectid']}&page={x2;$page}{x2;$u}">章节管理</a> <span class="divider">/</span></li>
				<li><a href="index.php?exam-teach-basic-point&sectionid={x2;$knows['knowssectionid']}&page={x2;$page}{x2;$u}">知识点管理</a> <span class="divider">/</span></li>
				<li class="active">修改知识点</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">修改知识点</a>
				</li>
				<li class="dropdown pull-right">
					<a href="index.php?exam-teach-basic-point&sectionid={x2;$knows['knowssectionid']}&page={x2;$page}{x2;$u}">知识点管理</a>
				</li>
			</ul>
        	<form action="index.php?exam-teach-basic-modifypoint" method="post" class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="knows">知识点名称：</label>
					<div class="controls">
						<input id="knows" name="args[knows]" type="text" size="30" value="{x2;$knows['knows']}" needle="needle" alt="请输入知识点名称"/>
					</div>
				</div>
				<div class="control-group">
				  	<div class="controls">
					  	<button class="btn btn-primary" type="submit">提交</button>
						<input type="hidden" name="knowsid" value="{x2;$knows['knowsid']}"/>
						<input type="hidden" name="page" value="{x2;$page}"/>
						<input type="hidden" name="modifypoint" value="1"/>
					</div>
				</div>
			</form>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}