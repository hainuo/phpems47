{x2;include:header}
<body>
{x2;include:nav}
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<form class="examform form-horizontal" id="form1" name="form1" action="index.php?exam-app-exampaper-makescore">
				<ul class="breadcrumb">
					<li>
						<span class="icon-home"></span> <a href="index.php?exam">考场选择</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-app-basics">{x2;$data['currentbasic']['basic']}</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-app-exampaper">模拟考试</a> <span class="divider">/</span>
					</li>
					<li class="active">
						成绩单
					</li>
				</ul>
				<legend class="text-center"><h3>{x2;$sessionvars['examsession']}</h3></legend>
                <div>
                	<div class="span4">
                		<div class="boardscore">
                			<h1 class="text-center">{x2;$sessionvars['examsessionscore']}分</h1>
                		</div>
                	</div>
                	<div class="span8">
                		<div><b class="text-info">考试详情：</b></div>
              			<p>总分：<b class="text-warning">{x2;$sessionvars['examsessionsetting']['examsetting']['score']}</b>分 合格分数线：<b class="text-warning">{x2;$sessionvars['examsessionsetting']['examsetting']['passscore']}</b>分 答卷耗时：<b class="text-warning">{x2;if:$sessionvars['examsessiontime'] >= 60}{x2;if:$sessionvars['examsessiontime']%60}{x2;eval: echo intval($sessionvars['examsessiontime']/60)+1}{x2;else}{x2;eval: echo intval($sessionvars['examsessiontime']/60)}{x2;endif}分钟{x2;else}{x2;$sessionvars['examsessiontime']}秒{x2;endif}</b>分钟</p>
                  		<table class="table table-hover table-bordered">
                          <tr class="success">
                            <th>题型</th>
                            <th>总题数</th>
                            <th>答对题数</th>
                            <th>总分</th>
                            <th>得分</th>
                          </tr>
                          {x2;tree:$number,num,nid}
                          {x2;if:v:num}
                          <tr>
                            <td>{x2;$questype[v:key]['questype']}</td>
                            <td>{x2;v:num}</td>
                            <td>{x2;$right[v:key]}</td>
                            <td>{x2;eval: echo number_format(v:num*$sessionvars['examsessionsetting']['examsetting']['questype'][v:key]['score'],1)}</td>
                            <td>{x2;eval: echo number_format($score[v:key],1)}</td>
                          </tr>
                          {x2;endif}
                          {x2;endtree}
                          <tr>
                            <td colspan="5" align="left">本次考试共<b class="text-warning">{x2;$allnumber}</b>道题，总分<b class="text-warning">{x2;$sessionvars['examsessionsetting']['examsetting']['score']}</b>分，您做对<b class="text-warning">{x2;$allright}</b>道题，得到<b class="text-warning">{x2;$sessionvars['examsessionscore']}</b>分</td>
                          </tr>
                       </table>
                       <div class="text-center"><a href="index.php?exam-app-history-view&ehid={x2;$ehid}" class="btn btn-info">查看答案和解析</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?exam-app-history&ehtype=1" class="btn btn-info">进入我的考试记录</a></div>
                	</div>
                </div>
			</div>
		</div>
	</div>
</div>
{x2;include:foot}
</body>
</html>