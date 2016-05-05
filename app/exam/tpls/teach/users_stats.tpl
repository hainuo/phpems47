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
				<li class="active">成绩分析</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="index.php?exam-teach-users-stats&basicid={x2;$basicid}{x2;$u}">试题正确率分析</a>
				</li>
				<li>
					<a href="index.php?exam-teach-users-stats&basicid={x2;$basicid}{x2;$u}&type=1">知识点正确率分析</a>
				</li>
			</ul>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>ID</th>
	                    <th width="50%">试题名称</th>
	                    <th>A</th>
	                    <th>B</th>
	                    <th>C</th>
	                    <th>D</th>
	                    <th>正确次数</th>
	                    <th>出现次数</th>
				        <th>正确率</th>
	                </tr>
	            </thead>
	            <tbody>
                    {x2;tree:$stats['data'],stat,sid}
			        <tr>
						<td>
							{x2;v:stat['id']}
						</td>
						<td>
							{x2;realhtml:v:stat['title']}
						</td>
						<td>
							{x2;eval: echo round(100 * v:stat['A']/v:stat['number'],2)}%
						</td>
						<td>
							{x2;eval: echo round(100 * v:stat['B']/v:stat['number'],2)}%
						</td>
						<td>
							{x2;eval: echo round(100 * v:stat['C']/v:stat['number'],2)}%
						</td>
						<td>
							{x2;eval: echo round(100 * v:stat['D']/v:stat['number'],2)}%
						</td>
						<td>
							{x2;eval: echo intval(v:stat['right'])}
						</td>
						<td>
							{x2;v:stat['number']}
						</td>
						<td>
							{x2;eval: echo round(100 * v:stat['right']/v:stat['number'],2)}%
						</td>
					</tr>
			        {x2;endtree}
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
	            <ul>{x2;$stats['pages']}</ul>
	        </div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}