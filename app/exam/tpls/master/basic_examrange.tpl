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
				<li><a href="index.php?{x2;$_app}-master-basic&page={x2;$page}{x2;$u}">考场管理</a> <span class="divider">/</span></li>
				<li class="active">考试范围</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">考试范围</a>
				</li>
				<li class="dropdown pull-right">
					<a href="index.php?exam-master-basic&page={x2;$page}{x2;$u}">考场管理</a>
				</li>
			</ul>
	        <form action="?exam-master-basic-setexamrange" method="post" class="form-horizontal">
				<table class="table">
					<thead>
					<tr>
						<th colspan="8">{x2;$basic['basic']}</th>
					</tr>
					</thead>
					<tr>
						<td>
							考场ID：
						</td>
						<td>
							{x2;$basic['basicid']}
						</td>
						<td>
							科目：
						</td>
						<td>
							{x2;$subjects[$basic['basicsubjectid']]['subject']}
						</td>
						<td>
							地区：
						</td>
			        	<td>
			        		{x2;$areas[$basic['basicareaid']]['area']}
			        	</td>
			        	<td>
							API标识：
						</td>
						<td>
							{x2;$basic['basicapi']}
						</td>
					</tr>
				</table>
				<div class="control-group">
					<label class="control-label">章节选择：<input type="checkbox" onclick="javascript:$('.section:checkbox').prop('checked',$(this).is(':checked'));"> </label>
				</div>
				{x2;tree:$sections,section,sid}
				<div class="control-group">
					<label class="control-label">
				        <label class="checkbox inline"><input type="checkbox" onclick="javascript:$('.sec_{x2;v:section['sectionid']}:checkbox').prop('checked',$(this).is(':checked'));"> {x2;v:section['section']}</label>
				    </label>
				    <div class="controls" style="text-indent:10px;">
				    	{x2;tree:$knows[v:section['sectionid']],know,kid}
				    	<label class="checkbox inline"><input type="checkbox" value="{x2;v:know['knowsid']}" name="args[basicknows][{x2;v:section['sectionid']}][{x2;v:know['knowsid']}]" class="section sec_{x2;v:section['sectionid']}" {x2;if:$basic['basicknows'][v:section['sectionid']][v:know['knowsid']] == v:know['knowsid']}checked{x2;endif}/>{x2;v:know['knows']}</label>
				    	{x2;endtree}
				    </div>
				</div>
				{x2;endif}
				<div class="control-group">
					<label for="basicexam_auto" class="control-label">考场模式：</label>
					<div class="controls">
						<label class="radio inline">
				          		<input type="radio" class="input-text" name="args[basicexam][model]" value="0"{x2;if:$basic['basicexam']['model'] == 0} checked{x2;endif}/> 全功能模式（练习和正式考试均开放）
			          	</label>
			          	<label class="radio inline">
			          		<input type="radio" class="input-text" name="args[basicexam][model]" value="1"{x2;if:$basic['basicexam']['model'] == 1} checked{x2;endif}/> 练习模式（仅练习功能开放）
			          	</label>
			          	<label class="radio inline">
			          		<input type="radio" class="input-text" name="args[basicexam][model]" value="2"{x2;if:$basic['basicexam']['model'] == 2} checked{x2;endif}/> 考试模式（仅正式考试开放）
			          	</label>
					</div>
				</div>
				<div class="control-group">
					<label for="basicexam_auto" class="control-label">正式考试试题排序：</label>
					<div class="controls">
						<label class="radio inline">
				          	<input type="radio" class="input-text" name="args[basicexam][changesequence]" value="0"{x2;if:$basic['basicexam']['changesequence'] == 0} checked{x2;endif}/> 不打乱试题排序
			          	</label>
			          	<label class="radio inline">
			          		<input type="radio" class="input-text" name="args[basicexam][changesequence]" value="1"{x2;if:$basic['basicexam']['changesequence'] == 1} checked{x2;endif}/> 打乱试题排序
			          	</label>
					</div>
				</div>
				<div class="control-group">
					<label for="basicexam_auto" class="control-label">绑定模拟考试试卷：</label>
					<div class="controls">
						<input type="text" id="basicexam_auto" name="args[basicexam][auto]" needle="needle" msg="您必须填写至少一个试卷" value="{x2;$basic['basicexam']['auto']}" /> <a class="selfmodal btn" href="javascript:;" data-target="#modal" url="index.php?exam-master-exams-selectexams&search[subjectid]={x2;$basic['basicsubjectid']}&exams={basicexam_auto}&useframe=1&target=basicexam_auto" valuefrom="basicexam_auto">选卷</a>
						<span class="help-block">请在试卷管理处查看试卷ID，将数字ID填写在这里，多个请用英文逗号（,）隔开。留空或填0时将无法进行该项考试。</span>
					</div>
				</div>
				<div class="control-group">
					<label for="basicexam_autotemplate" class="control-label">模拟考试模板：</label>
					<div class="controls">
						<select id="basicexam_autotemplate" name="args[basicexam][autotemplate]">
							{x2;tree:$tpls['ep'],tpl,tid}
			            	<option value="{x2;v:tpl}"{x2;if:$basic['basicexam']['autotemplate'] == v:tpl} selected{x2;endif}>{x2;v:tpl}</option>
			            	{x2;endtree}
		            	</select>
					</div>
				</div>
				<div class="control-group">
					<label for="basicexam_self" class="control-label">绑定正式考试试卷：</label>
					<div class="controls">
						<input type="text" id="basicexam_self" name="args[basicexam][self]" needle="needle" msg="您必须填写至少一个试卷" value="{x2;$basic['basicexam']['self']}" /> <a class="selfmodal btn" href="javascript:;" data-target="#modal" url="index.php?exam-master-exams-selectexams&search[subjectid]={x2;$basic['basicsubjectid']}&exams={basicexam_self}&useframe=1&target=basicexam_self" valuefrom="basicexam_self">选卷</a>
						<span class="help-block">请在试卷管理处查看试卷ID，将数字ID填写在这里，多个请用英文逗号（,）隔开。留空或填0时将无法进行该项考试。</span>
					</div>
				</div>
				<div class="control-group">
					<label for="basicexam_selftemplate" class="control-label">正式考试试卷模板：</label>
					<div class="controls">
						<select id="basicexam_selftemplate" name="args[basicexam][selftemplate]">
			            	{x2;tree:$tpls['pp'],tpl,tid}
			            	<option value="{x2;v:tpl}"{x2;if:$basic['basicexam']['selftemplate'] == v:tpl} selected{x2;endif}>{x2;v:tpl}</option>
			            	{x2;endtree}
			            </select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">正式考试开启时间：</label>
					<div class="controls">
						<input name="args[basicexam][opentime][start]" type="text" value="{x2;if:$basic['basicexam']['opentime']['start']}{x2;date:$basic['basicexam']['opentime']['start'],'Y-m-d H:i:s'}{x2;else}0{x2;endif}" needle="needle" msg="您必须输入一个开启时间起点" /> - <input name="args[basicexam][opentime][end]" type="text" value="{x2;if:$basic['basicexam']['opentime']['end']}{x2;date:$basic['basicexam']['opentime']['end'],'Y-m-d H:i:s'}{x2;else}0{x2;endif}" needle="needle" msg="您必须输入一个开启时间终点" />
						<span class="help-block">开始结束时间均需填写，格式为2014-05-01 08:00:00，不限制开启时间请任意一项填写0。如果设置的结束时间减去5分钟比考生交卷时间要早，则系统按照结束时间减去5分钟收卷。</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">正式考试抽卷规则：</label>
					<div class="controls">
						<label class="radio inline">
			          		<input type="radio" class="input-text" name="args[basicexam][selectrule]" value="1"{x2;if:$basic['basicexam']['selectrule']} checked{x2;endif}/> 系统随机抽卷
			          	</label>
			          	<label class="checkbox inline">
			          		<input type="radio" class="input-text" name="args[basicexam][selectrule]" value="0"{x2;if:!$basic['basicexam']['selectrule']} checked{x2;endif}/> 用户手动选卷
			          	</label>
						<span class="help-block">系统随机抽卷时，用户无法看到试卷列表，系统会随机挑选试卷供用户考试。手选试卷时，系统列出试卷列表供用户选择进行考试。</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">正式考试限考次数：</label>
					<div class="controls">
						<input name="args[basicexam][examnumber]" type="text" value="{x2;if:$basic['basicexam']['examnumber']}{x2;$basic['basicexam']['examnumber']}{x2;else}0{x2;endif}" needle="needle" msg="您必须输入考试次数" />
						<span class="help-block">不限制次数请填写0，当您选择抽卷规则为系统随机抽卷时，限考次数为所有试卷限考次数，当您选择抽卷规则为用户自选时，限考次数为每套试卷限考次数。即如果设置限考次数为x，当随机抽卷时，用户一共可以考试x次；手选试卷时，用户每套试卷可考试x次。</span>
					</div>
				</div>
				<div class="control-group">
					<label for="basicexam_auto" class="control-label">交卷后：</label>
					<div class="controls">
						<label class="radio inline">
				          		<input type="radio" class="input-text" name="args[basicexam][notviewscore]" value="0"{x2;if:$basic['basicexam']['notviewscore'] == 0} checked{x2;endif}/> 直接显示分数
			          	</label>
			          	<label class="radio inline">
			          		<input type="radio" class="input-text" name="args[basicexam][notviewscore]" value="1"{x2;if:$basic['basicexam']['notviewscore'] == 1} checked{x2;endif}/> 暂不显示分数
			          	</label>
					</div>
				</div>
				<div class="submit">
					<div class="controls">
						<button class="btn btn-primary" type="submit">提交</button>
						<input type="hidden" name="page" value="{x2;$page}"/>
						<input type="hidden" name="setexamrange" value="1"/>
						<input type="hidden" name="basicid" value="{x2;$basic['basicid']}"/>
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
<div aria-hidden="true" id="modal" class="modal hide fade" role="dialog" aria-labelledby="#myModalLabel">
	<div class="modal-header">
		<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
		<h3 id="myModalLabel">
			试卷列表
		</h3>
	</div>
	<div class="modal-body" id="modal-body">asdasdasdasdsa</div>
	<div class="modal-footer">
		 <button aria-hidden="true" class="btn" data-dismiss="modal">完成</button>
	</div>
</div>
</body>
</html>
{x2;endif}