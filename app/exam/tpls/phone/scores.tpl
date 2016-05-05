{x2;include:header}
<body>
{x2;include:nav}
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<div class="examform">
				<ul class="breadcrumb">
					<li>
						<span class="icon-home"></span> <a href="index.php?exam-phone">考场选择</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-phone-basics">{x2;$data['currentbasic']['basic']}</a> <span class="divider">/</span>
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
				<table class="table table-bordered table-hover">
					<tr class="info">
						<td>名次</td>
						<td>用户名</td>
                        <td>得分</td>
						<td>考试时间</td>
					</tr>
					{x2;tree:$scores['data'],score,sid}
					<tr>
						<td>{x2;eval: echo ($page - 1)*20 + v:sid}</td>
						<td>{x2;v:score['ehusername']}</td>
						<td>{x2;v:score['ehscore']}</td>
						<td>{x2;date:v:score['ehstarttime'],'Y-m-d'}</td>
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