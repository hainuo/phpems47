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
				<li><a href="index.php?{x2;$_app}-teach-users">课程成绩</a> <span class="divider">/</span></li>
				<li class="active">教师评卷</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">教师评卷</a>
				</li>
			</ul>
			<form action="index.php?exam-teach-users-makescore" method="post" class="form-horizontal">
			{x2;eval: v:oid = 0}
			{x2;tree:$questype,quest,qid}
			{x2;eval: v:oid++}
			{x2;if:v:quest['questsort']}
			{x2;if:$sessionvars['ehquestion']['questions'][v:quest['questid']] || $sessionvars['ehquestion']['questionrows'][v:quest['questid']]}
			<h4 class="qu_type">{x2;$ols[v:oid]}、{x2;v:quest['questype']}</h4>
			{x2;eval: v:tid = 0}
			{x2;tree:$sessionvars['ehquestion']['questions'][v:quest['questid']],question,qnid}
			{x2;eval: v:tid++}
			<table class="table">
				<tr>
					<td style="width:80px;">第{x2;v:tid}题</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>标题：</td>
					<td>{x2;eval: echo strip_tags(html_entity_decode(v:question['question']))}</td>
				</tr>
				<tr>
					<td>标准答案：</td>
					<td>{x2;realhtml:v:question['questionanswer']}</td>
				</tr>
				<tr>
					<td>考生答案：</td>
					<td>{x2;realhtml:$sessionvars['ehuseranswer'][v:question['questionid']]}</td>
				</tr>
				<tr>
					<td colspan="2">【请根据参考答案给出分值】<input style="width:80px;" type="text" needle="needle" msg="您必须给出一个分数" name="score[{x2;v:question['questionid']}]" value=""> <span class="ml_10 red font_12">提示：本题共{x2;$sessionvars['ehsetting']['examsetting']['questype'][v:quest['questid']]['score']}分，可输入0.5的倍数。</span></td>
				</tr>
			</table>
			{x2;endtree}
			{x2;tree:$sessionvars['ehquestion']['questionrows'][v:quest['questid']],rowsquestion,qrid}
			{x2;eval: v:tid++}
			<table class="table">
				<tr>
					<td>
						<table>
						<tr>
							<td>第{x2;v:tid}题</td>
						</tr>
						<tr>
							<td>{x2;realhtml:v:rowsquestion['qrquestion']}</td>
						</tr>
						</table>
						{x2;tree:v:rowsquestion['data'],question,cqid}
						<table class="searchContent" width="96%">
							<tr>
								<td style="width:80px;">第{x2;v:cqid}题</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>标题：</td>
								<td>{x2;eval: echo strip_tags(html_entity_decode(v:question['question']))}</td>
							</tr>
							<tr>
								<td>标准答案：</td>
								<td>{x2;realhtml:v:question['questionanswer']}</td>
							</tr>
							<tr>
								<td>考生答案：</td>
								<td>{x2;realhtml:$sessionvars['ehuseranswer'][v:data['questionid']]}&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2">【请根据参考答案给出分值】<input style="width:80px;" needle="needle" msg="您必须给出一个分数" type="text" name="score[{x2;v:question['questionid']}]" value=""><span class="ml_10 red font_12">提示：本题共{x2;$sessionvars['ehsetting']['examsetting']['questype'][v:quest['questid']]['score']}分，可输入0.5的倍数。</span></td>
							</tr>
						</table>
						{x2;endtree}
					</td>
				</tr>
			</table>
			{x2;endtree}
		{x2;endif}
	{x2;endif}
{x2;endtree}
		<div class="control-group">
            <div class="controls">
            	<input type="hidden" name="makescore" value="1" />
            	<input type="hidden" name="ehid" value="{x2;$sessionvars['ehid']}" />
            	<button class="btn btn-primary" type="submit">评分完毕</button>
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