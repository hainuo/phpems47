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
				<li><a href="index.php?{x2;$_app}-master-exams&page={x2;$page}{x2;$u}">试卷管理</a> <span class="divider">/</span></li>
				<li class="active">随机组卷修改</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">随机组卷修改</a>
				</li>
				<li class="pull-right">
					<a href="index.php?{x2;$_app}-master-exams&page={x2;$page}{x2;$u}">试卷管理</a>
				</li>
			</ul>
		    <form action="index.php?exam-master-exams-modify" method="post" class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="content">试卷名称：</label>
			  		<div class="controls">
			  			<input type="text" name="args[exam]" value="{x2;$exam['exam']}" needle="needle" msg="您必须为该试卷输入一个名称"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">评卷方式</label>
					<div class="controls">
						<label class="radio inline">
							<input name="args[examdecide]" type="radio" value="1"{x2;if:$exam['examdecide']} checked{x2;endif}/>教师评卷
						</label>
						<label class="radio inline">
							<input name="args[examdecide]" type="radio" value="0"{x2;if:!$exam['examdecide']} checked{x2;endif}/>学生自评
						</label>
						<span class="help-block">教师评卷时有主观题则需要教师在后台评分后才能显示分数，无主观题自动显示分数。</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">考试科目：</label>
				  	<div class="controls">
					  	<label class="radio">{x2;$subjects[$exam['examsubject']]['subject']}</label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="content">考试时间：</label>
			  		<div class="controls">
			  			<input type="text" name="args[examsetting][examtime]" value="{x2;$exam['examsetting']['examtime']}" size="4" needle="needle" class="inline"/> 分钟
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="content">来源：</label>
			  		<div class="controls">
			  			<input type="text" name="args[examsetting][comfrom]" value="{x2;$exam['examsetting']['comfrom']}" size="4"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="content">试卷总分：</label>
			  		<div class="controls">
			  			<input type="text" name="args[examsetting][score]" value="{x2;$exam['examsetting']['score']}" size="4" needle="needle" msg="你要为本考卷设置总分" datatype="number"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="content">及格线：</label>
			  		<div class="controls">
			  			<input type="text" name="args[examsetting][passscore]" value="{x2;$exam['examsetting']['passscore']}" size="4" needle="needle" msg="你要为本考卷设置一个及格分数线" datatype="number"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">题型排序</label>
					<div class="controls">
						<div class="sortable btn-group">
							{x2;if:$exam['examsetting']['questypelite']}
							{x2;tree:$exam['examsetting']['questypelite'],qlid,eqid}
							<a class="btn questpanel panel_{x2;v:key}">{x2;$questypes[v:key]['questype']}<input type="hidden" name="args[examsetting][questypelite][{x2;v:key}]" value="1" class="questypepanelinput" id="panel_{x2;v:key}"/></a>
							{x2;endtree}
							{x2;else}
							{x2;tree:$questypes,questype,qid}
							<a class="btn questpanel panel_{x2;v:questype['questid']}">{x2;v:questype['questype']}<input type="hidden" name="args[examsetting][questypelite][{x2;v:questype['questid']}]" value="1" class="questypepanelinput" id="panel_{x2;v:questype['questid']}"/></a>
							{x2;endtree}
							{x2;endif}
						</div>
						<span class="help-block">拖拽进行题型排序</span>
					</div>
				</div>
			    <div class="control-group">
			        <label class="control-label">题量配比模式：</label>
		          	<div class="controls">
						<label class="radio inline">
			          		<input type="radio" autocomplete="off" class="input-text" name="args[examsetting][scalemodel]" value="1" onchange="javascript:$('#modeplane').html($('#sptype').html());"{x2;if:$exam['examsetting']['scalemodel']} checked{x2;endif}/> 开启
			          	</label>
			          	<label class="checkbox inline">
			          		<input type="radio" autocomplete="off" class="input-text" name="args[examsetting][scalemodel]" value="0" onchange="javascript:$('#modeplane').html($('#normaltype').html());"{x2;if:!$exam['examsetting']['scalemodel']} checked{x2;endif}/> 关闭
			          	</label>
			       </div>
			    </div>
			    <div id="modeplane">
			    	{x2;if:$exam['examsetting']['scalemodel']}
			    	<div class="control-group">
				        <label class="control-label">题量配比：</label>
			          	<div class="controls">
				          	<label class="radio inline">题量配比模式关闭时，此设置不生效。题量配比操作繁琐，请尽量熟悉后再行操作。题量配比会受考场中考试范围制约，请谨慎配置。</label>
				       </div>
				    </div>
				    {x2;tree:$questypes,questype,qid}
					<div class="control-group questpanel panel_{x2;v:questype['questid']}">
						<label class="control-label" for="content">{x2;v:questype['questype']}：</label>
						<div class="controls">
							<span class="info">共&nbsp;</span>
							<input id="iselectallnumber_{x2;v:key}" type="text" class="input-mini" needle="needle" name="args[examsetting][questype][{x2;v:key}][number]" value="{x2;eval: echo intval($exam['examsetting']['questype'][v:key]['number'])}" size="2" msg="您必须填写总题数"/>
							<span class="info">&nbsp;题，每题&nbsp;</span><input class="input-mini" needle="needle" type="text" name="args[examsetting][questype][{x2;v:key}][score]" value="{x2;eval: echo floatval($exam['examsetting']['questype'][v:key]['score'])}" size="2" msg="您必须填写每题的分值"/>
							<span class="info">&nbsp;分，描述&nbsp;</span><input class="input-mini" type="text" name="args[examsetting][questype][{x2;v:key}][describe]" value="{x2;$exam['examsetting']['questype'][v:key]['describe']}" size="12"/>
						</div>
					</div>
					<div class="control-group questpanel panel_{x2;v:questype['questid']}">
						<label class="control-label" for="content">配比率：</label>
						<div class="controls">
							<textarea class="input-xxlarge" rows="7" cols="4" name="args[examsetting][examscale][{x2;v:questype['questid']}]">{x2;$exam['examsetting']['examscale'][v:questype['questid']]}</textarea>
						</div>
					</div>
					{x2;endtree}
					{x2;else}
			    	{x2;tree:$questypes,questype,qid}
					<div class="control-group questpanel panel_{x2;v:questype['questid']}">
						<label class="control-label" for="content">{x2;v:questype['questype']}：</label>
						<div class="controls">
							<span class="info">共&nbsp;</span>
							<input id="iselectallnumber_{x2;v:key}" type="text" class="input-mini" needle="needle" name="args[examsetting][questype][{x2;v:key}][number]" value="{x2;eval: echo intval($exam['examsetting']['questype'][v:key]['number'])}" size="2" msg="您必须填写总题数"/>
							<span class="info">&nbsp;题，每题&nbsp;</span><input class="input-mini" needle="needle" type="text" name="args[examsetting][questype][{x2;v:key}][score]" value="{x2;eval: echo floatval($exam['examsetting']['questype'][v:key]['score'])}" size="2" msg="您必须填写每题的分值"/>
							<span class="info">&nbsp;分，描述&nbsp;</span><input class="input-mini" type="text" name="args[examsetting][questype][{x2;v:key}][describe]" value="{x2;$exam['examsetting']['questype'][v:key]['describe']}" size="12"/>
							<span class="info">&nbsp;难度题数：易&nbsp;</span><input class="input-mini" type="text" name="args[examsetting][questype][{x2;v:key}][easynumber]" value="{x2;eval: echo intval($exam['examsetting']['questype'][v:key]['easynumber'])}" size="2" msg="您需要填写简单题的数量，最小为0"/>
		  					<span class="info">&nbsp;中&nbsp;</span><input class="input-mini" type="text" needle="needle" name="args[examsetting][questype][{x2;v:key}][middlenumber]" value="{x2;eval: echo intval($exam['examsetting']['questype'][v:key]['middlenumber'])}" size="2" msg="您需要填写中等难度题的数量，最小为0"/>
		  					<span class="info">&nbsp;难&nbsp;</span><input class="input-mini" type="text" needle="needle" name="args[examsetting][questype][{x2;v:key}][hardnumber]" value="{x2;eval: echo intval($exam['examsetting']['questype'][v:key]['hardnumber'])}" size="2" datatype="number" msg="您需要填写难题的数量，最小为0"/>
						</div>
					</div>
					{x2;endtree}
					{x2;endif}
			    </div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-primary" type="submit">提交</button>
						<input type="hidden" name="submitsetting" value="1"/>
					  	<input type="hidden" name="page" value="{x2;$page}" />
					  	<input name="args[examsubject]" type="hidden" value="{x2;$exam['examsubject']}">
					  	<input name="examid" type="hidden" value="{x2;$exam['examid']}">
					    {x2;tree:$search,arg,aid}
							<input type="hidden" name="search[{x2;v:key}]" value="{x2;v:arg}"/>
						{x2;endtree}
					</div>
				</div>
			</form>
			<div id="sptype" class="hide">
			    <div class="control-group">
			        <label class="control-label">题量配比：</label>
		          	<div class="controls">
			          	<label class="radio inline">题量配比模式关闭时，此设置不生效。题量配比操作繁琐，请尽量熟悉后再行操作。题量配比会受考场中考试范围制约，请谨慎配置。</label>
			       </div>
			    </div>
			    {x2;tree:$questypes,questype,qid}
				<div class="control-group questpanel panel_{x2;v:questype['questid']}">
					<label class="control-label" for="content">{x2;v:questype['questype']}：</label>
					<div class="controls">
						<span class="info">共&nbsp;</span>
						<input id="iselectallnumber_{x2;v:key}" type="text" class="input-mini" needle="needle" name="args[examsetting][questype][{x2;v:key}][number]" value="{x2;eval: echo intval($exam['examsetting']['questype'][v:key]['number'])}" size="2" msg="您必须填写总题数"/>
						<span class="info">&nbsp;题，每题&nbsp;</span><input class="input-mini" needle="needle" type="text" name="args[examsetting][questype][{x2;v:key}][score]" value="{x2;eval: echo floatval($exam['examsetting']['questype'][v:key]['score'])}" size="2" msg="您必须填写每题的分值"/>
						<span class="info">&nbsp;分，描述&nbsp;</span><input class="input-mini" type="text" name="args[examsetting][questype][{x2;v:key}][describe]" value="{x2;$exam['examsetting']['questype'][v:key]['describe']}" size="12"/>
					</div>
				</div>
				<div class="control-group questpanel panel_{x2;v:questype['questid']}">
					<label class="control-label" for="content">配比率：</label>
					<div class="controls">
						<textarea class="input-xxlarge" rows="7" cols="4" name="args[examsetting][examscale][{x2;v:questype['questid']}]">{x2;$exam['examsetting']['examscale'][v:questype['questid']]}</textarea>
					</div>
				</div>
				{x2;endtree}
			</div>
			<div id="normaltype" class="hide">
				{x2;tree:$questypes,questype,qid}
				<div class="control-group questpanel panel_{x2;v:questype['questid']}">
					<label class="control-label" for="content">{x2;v:questype['questype']}：</label>
					<div class="controls">
						<span class="info">共&nbsp;</span>
						<input id="iselectallnumber_{x2;v:key}" type="text" class="input-mini" needle="needle" name="args[examsetting][questype][{x2;v:key}][number]" value="{x2;eval: echo intval($exam['examsetting']['questype'][v:key]['number'])}" size="2" msg="您必须填写总题数"/>
						<span class="info">&nbsp;题，每题&nbsp;</span><input class="input-mini" needle="needle" type="text" name="args[examsetting][questype][{x2;v:key}][score]" value="{x2;eval: echo floatval($exam['examsetting']['questype'][v:key]['score'])}" size="2" msg="您必须填写每题的分值"/>
						<span class="info">&nbsp;分，描述&nbsp;</span><input class="input-mini" type="text" name="args[examsetting][questype][{x2;v:key}][describe]" value="{x2;$exam['examsetting']['questype'][v:key]['describe']}" size="12"/>
						<span class="info">&nbsp;难度题数：易&nbsp;</span><input class="input-mini" type="text" name="args[examsetting][questype][{x2;v:key}][easynumber]" value="{x2;eval: echo intval($exam['examsetting']['questype'][v:key]['easynumber'])}" size="2" msg="您需要填写简单题的数量，最小为0"/>
	  					<span class="info">&nbsp;中&nbsp;</span><input class="input-mini" type="text" needle="needle" name="args[examsetting][questype][{x2;v:key}][middlenumber]" value="{x2;eval: echo intval($exam['examsetting']['questype'][v:key]['middlenumber'])}" size="2" msg="您需要填写中等难度题的数量，最小为0"/>
	  					<span class="info">&nbsp;难&nbsp;</span><input class="input-mini" type="text" needle="needle" name="args[examsetting][questype][{x2;v:key}][hardnumber]" value="{x2;eval: echo intval($exam['examsetting']['questype'][v:key]['hardnumber'])}" size="2" datatype="number" msg="您需要填写难题的数量，最小为0"/>
					</div>
				</div>
				{x2;endtree}
			</div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
<script>
$.getJSON('index.php?exam-master-basic-getsubjectquestype&subjectid={x2;$exam['examsubject']}&'+Math.random(),function(data){$('.questpanel').hide();$('.questypepanelinput').val('0');for(x in data){$('.panel_'+data[x]).show();$('#panel_'+data[x]).val('1');}});
</script>
</body>
</html>
{x2;endif}