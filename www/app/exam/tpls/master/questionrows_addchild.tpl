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
				<li><a href="index.php?{x2;$_app}-master-rowsquestions-rowsdetail&questionid={x2;$question['qrid']}&page={x2;$page}{x2;$u}">子试题列表</a> <span class="divider">/</span></li>
				<li class="active">添加子试题</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">添加子试题</a>
				</li>
				<li class="pull-right">
					<a href="index.php?{x2;$_app}-master-rowsquestions-rowsdetail&questionid={x2;$question['qrid']}&page={x2;$page}{x2;$u}">子试题列表</a>
				</li>
			</ul>
			<form action="index.php?exam-master-rowsquestions-addchildquestion" method="post" class="form-horizontal">
				<div class="control-group">
					<label class="control-label">题型：</label>
				  	<div class="controls">
					  	<select name="args[questiontype]" class="combox" onchange="javascript:setAnswerHtml($(this).find('option:selected').attr('rel'),'rcianswerbox');">
					  		{x2;tree:$questypes,questype,qid}
					  		<option rel="{x2;if:v:questype['questsort']}0{x2;else}{x2;v:questype['questchoice']}{x2;endif}" value="{x2;v:questype['questid']}"{x2;if:v:questype['questid'] == $question['questiontype']} selected{x2;endif}>{x2;v:questype['questype']}</option>
					  		{x2;endtree}
					  	</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">题干：</label>
				  	<div class="controls">
				  		<textarea needle="needle" msg="您必须要填写题干" cols="72" rows="3" class="ckeditor" name="args[question]" id="rciquestion">{x2;$question['question']}</textarea>
				  		<span class="help-block">需要填空处请以()表示。</span>
					</div>
				</div>
				<div class="control-group" id="selecttext">
					<label class="control-label">备选项：</label>
				  	<div class="controls">
				  		<textarea cols="72" rows="7" class="ckeditor" name="args[questionselect]" id="rcquestionselect">{x2;$question['questionselect']}</textarea>
				  		<div class="intro">无选择项的请不要填写，如填空题。</div>
					</div>
				</div>
				<div class="control-group" id="selectnumber">
					<label class="control-label" for="questionselectnumber">备选项数量：</label>
				  	<div class="controls">
				  		<select class="combox" id="questionselectnumber" name="args[questionselectnumber]">
					  		<option value="0">0</option>
					  		<option value="2">2</option>
					  		<option value="4" selected>4</option>
					  		<option value="5">5</option>
					  		<option value="6">6</option>
					  	</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">参考答案：</label>
					<div class="controls">
						<div id="rcianswerbox_1" class="rcianswerbox">
						  	<label class="radio inline"><input type="radio" name="targs[questionanswer1]" value="A" checked>A</label>
						  	<label class="radio inline"><input type="radio" name="targs[questionanswer1]" value="B">B</label>
						  	<label class="radio inline"><input type="radio" name="targs[questionanswer1]" value="C">C</label>
						  	<label class="radio inline"><input type="radio" name="targs[questionanswer1]" value="D">D</label>
						  	<label class="radio inline"><input type="radio" name="targs[questionanswer1]" value="E">E</label>
						</div>
						<div id="rcianswerbox_2" style="display:none;" class="rcianswerbox">
						  	<label class="checkbox inline"><input type="checkbox" name="targs[questionanswer2][]" value="A">A</label>
						  	<label class="checkbox inline"><input type="checkbox" name="targs[questionanswer2][]" value="B">B</label>
						  	<label class="checkbox inline"><input type="checkbox" name="targs[questionanswer2][]" value="C">C</label>
						  	<label class="checkbox inline"><input type="checkbox" name="targs[questionanswer2][]" value="D">D</label>
						  	<label class="checkbox inline"><input type="checkbox" name="targs[questionanswer2][]" value="E">E</label>
						</div>
						<div id="rcianswerbox_3" style="display:none;" class="rcianswerbox">
						  	<label class="checkbox inline"><input type="checkbox" name="targs[questionanswer3][]" value="A">A</label>
						  	<label class="checkbox inline"><input type="checkbox" name="targs[questionanswer3][]" value="B">B</label>
						  	<label class="checkbox inline"><input type="checkbox" name="targs[questionanswer3][]" value="C">C</label>
						  	<label class="checkbox inline"><input type="checkbox" name="targs[questionanswer3][]" value="D">D</label>
						  	<label class="checkbox inline"><input type="checkbox" name="targs[questionanswer3][]" value="E">E</label>
						</div>
						<div id="rcianswerbox_4" class="rcianswerbox" style="display:none;">
						  	<label class="radio inline"><input type="radio" name="targs[questionanswer4]" value="A" checked>对</label>
						  	<label class="radio inline"><input type="radio" name="targs[questionanswer4]" value="B">错</label>
						</div>
						<div id="rcianswerbox_5" class="rcianswerbox" style="display:none;">
						  	<input type="text" name="targs[questionanswer5]" value="{x2;$question['questionanswer']}" />
						</div>
						<div id="rcianswerbox_0" style="display:none;" class="rcianswerbox">
						  	<textarea cols="72" rows="7" class="ckeditor" id="rciquestionanswer0" name="targs[questionanswer0]">{x2;$question['questionanswer']}</textarea>
						</div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">习题解析：</label>
				  	<div class="controls">
				  		<textarea cols="72" rows="7" class="ckeditor" name="args[questiondescribe]" id="rciquestiondescribe">{x2;$question['questiondescribe']}</textarea>
					</div>
				</div>
				<div class="control-group">
				  	<div class="controls">
					  	<button class="btn btn-primary" type="submit">提交</button>
					  	<input type="hidden" name="page" value="{x2;$page}"/>
					  	<input type="hidden" name="args[questionparent]" value="{x2;$question['qrid']}"/>
					  	<input type="hidden" name="insertquestion" value="1"/>
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