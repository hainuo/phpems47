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
				<li><a href="index.php?{x2;$_app}-master-rowsquestions&page={x2;$page}{x2;$u}">题冒题管理</a> <span class="divider">/</span></li>
				<li class="active">修改题冒题</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">修改题冒题</a>
				</li>
				<li class="dropdown pull-right">
					<a href="index.php?{x2;$_app}-master-rowsquestions&page={x2;$page}{x2;$u}">题冒题管理</a>
				</li>
			</ul>
			<form action="?exam-master-rowsquestions-modifyquestion" method="post" class="form-horizontal">
				<div class="control-group">
					<label class="control-label">知识点：</label>
					<div class="controls">
						<textarea cols="72" rows="4" class="input-xxlarge" name="args[qrknowsid]" id="questionknowsid" readonly>{x2;tree:$question['qrknowsid'],know,kid}{x2;v:know['knowsid']}:{x2;v:know['knows']}{x2;enter}{x2;endif}</textarea>
		  			</div>
		  		</div>
				<div class="control-group">
			  		<div class="controls">
				  		<select class="combox" target="isectionselect" refUrl="index.php?exam-master-questions-ajax-getsectionsbysubjectid&subjectid={value}">
			        		<option value="0">选择科目</option>
					  		{x2;tree:$subjects,subject,sid}
					  		<option value="{x2;v:subject['subjectid']}">{x2;v:subject['subject']}</option>
					  		{x2;endtree}
				  		</select>
				  		<select class="combox" id="isectionselect" target="iknowsselect" refUrl="index.php?exam-master-questions-ajax-getknowsbysectionid&sectionid={value}">
				  			<option value="0">选择章节</option>
				  		</select>
				  		<select class="combox" id="iknowsselect">
				  			<option value="0">选择知识点</option>
				  		</select>
					</div>
				</div>
				<div class="control-group">
			  		<div class="controls">
			  			<input type="button" class="btn" value="选定" onclick="javascript:setKnowsList('questionknowsid','iknowsselect','+');"/>
			  			<input type="button" class="btn" value="清除" onclick="javascript:setKnowsList('questionknowsid','iknowsselect','-');"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="qrtype">题型：</label>
					<div class="controls">
					  	<select id="qrtype" needle="needle" msg="您必须为要添加的试题选择一种题型" name="args[qrtype]">
					  		{x2;tree:$questypes,questype,qid}
					  		<option rel="{x2;if:v:questype['questsort']}0{x2;else}{x2;v:questype['questchoice']}{x2;endif}" value="{x2;v:questype['questid']}"{x2;if:v:questype['questid'] == $question['qrtype']} selected{x2;endif}>{x2;v:questype['questype']}</option>
					  		{x2;endtree}
					  	</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="qrquestion">题干：</label>
				  	<div class="controls">
				  		<textarea id="qrquestion" class="ckeditor" name="args[qrquestion]" id="question">{x2;$question['qrquestion']}</textarea>
				  		<span class="help-block">需要填空处请以()表示。</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="qrlevel">难度：</label>
				  	<div class="controls">
					  	<select id="qrlevel" name="args[qrlevel]" needle="needle" msg="您必须为要添加的试题设置一个难度">
					  		<option value="1"{x2;if:$question['qrlevel']==1} selected{x2;endif}>易</option>
					  		<option value="2"{x2;if:$question['qrlevel']==2} selected{x2;endif}>中</option>
					  		<option value="3"{x2;if:$question['qrlevel']==3} selected{x2;endif}>难</option>
					  	</select>
					</div>
				</div>
				<div class="control-group">
				  	<div class="controls">
					  	<button class="btn btn-primary" type="submit">提交</button>
					  	<input type="hidden" name="page" value="{x2;$page}"/>
					  	<input type="hidden" name="questionid" value="{x2;$question['qrid']}"/>
					  	<input type="hidden" name="modifyquestion" value="1"/>
					  	{x2;tree:$search,arg,aid}
						<input type="hidden" name="search[{x2;v:key}]" value="{x2;v:arg}"/>
						{x2;endtree}
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
