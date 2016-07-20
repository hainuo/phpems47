{x2;include:header}
<body>
{x2;include:nav}
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<div class="examform">
				<ul class="breadcrumb">
					<li>
						<span class="icon-home"></span> <a href="index.php?exam">考场选择</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-app-basics">{x2;$data['currentbasic']['basic']}</a> <span class="divider">/</span>
					</li>
					<li class="active">
						成绩单
					</li>
				</ul>
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#">成绩单</a>
					</li>
				</ul>
				<p>您的最高分：<span class="text-warning">{x2;$s['score']}</span> 您的最好名次：<span class="text-warning">{x2;$s['index']}</span></p>
				<table class="table table-bordered table-hover">
					<tr class="info">
						<td>名次</td>
						<td>用户名</td>
                        <td>得分</td>
						<td>考试时间</td>
						<td>用时</td>
					</tr>
					{x2;tree:$scores['data'],score,sid}
					<tr>
						<td>{x2;eval: echo ($page - 1)*20 + v:sid}</td>
						<td>{x2;v:score['ehusername']}</td>
						<td>{x2;v:score['ehscore']}</td>
						<td>{x2;date:v:score['ehstarttime'],'Y-m-d H:i:s'}</td>
						<td>{x2;if:v:score['ehtime'] >= 60}{x2;if:v:score['ehtime']%60}{x2;eval: echo intval(v:score['ehtime']/60)+1}{x2;else}{x2;eval: echo intval(v:score['ehtime']/60)}{x2;endif}分钟{x2;else}{x2;v:score['ehtime']}秒{x2;endif}</td>
					</tr>
				{x2;endtree}
				</table>
				<div class="pagination pagination-right">
					<ul>{x2;$scores['pages']}</ul>
				</div>
			</div>
		</div>
	</div>
</div>
{x2;include:foot}
</body>
</html>