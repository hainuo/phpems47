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
				<li class="active">试卷管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">试卷管理</a>
				</li>
				<li class="dropdown pull-right">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">添加试卷<strong class="caret"></strong></a>
					<ul class="dropdown-menu">
						<li><a href="index.php?{x2;$_app}-teach-exams-autopage&page={x2;$page}{x2;$u}">随机组卷</a></li>
						<li><a href="index.php?{x2;$_app}-teach-exams-selfpage&page={x2;$page}{x2;$u}">手动组卷</a></li>
					</ul>
				</li>
			</ul>
	        <form action="index.php?exam-teach-exams" method="post">
				<table class="table">
					<thead>
		                <tr>
					        <th colspan="2">搜索</th>
					        <th></th>
					        <th></th>
					        <th></th>
					        <th></th>
		                </tr>
		            </thead>
					<tr>
						<td>
							选择类型：
						</td>
						<td>
							<select name="search[examtype]">
								<option value="0">不限</option>
								<option value="1"{x2;if:$search['examtype'] == 1} selected{x2;endif}>随机抽题</option>
								<option value="2"{x2;if:$search['examtype'] == 2} selected{x2;endif}>手动抽题</option>
							</select>
						</td>
						<td>
							选择科目：
						</td>
						<td>
							<select name="search[examsubject]">
								<option value="0">不限</option>
								{x2;tree:$subjects,subject,sid}
						  		<option value="{x2;v:subject['subjectid']}"{x2;if:v:subject['subjectid'] == $search['examsubject']} selected{x2;endif}>{x2;v:subject['subject']}</option>
						  		{x2;endtree}
							</select>
						</td>
						<td>
							<button class="btn btn-primary" type="submit">搜索</button>
							<input type="hidden" value="1" name="search[argsmodel]" />
						</td>
					</tr>
				</table>
			</form>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>ID</th>
				        <th>考试名称</th>
				        <th>组卷人</th>
				        <th>组卷类型</th>
				        <th>组卷时间</th>
				        <th>考试科目</th>
				        <th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                    {x2;tree:$exams['data'],exam,eid}
			        <tr>
						<td>
							{x2;v:exam['examid']}
						</td>
						<td>
							{x2;v:exam['exam']}
						</td>
						<td>
							{x2;v:exam['examauthor']}
						</td>
						<td>
							{x2;if:v:exam['examtype'] == 1}随机组卷{x2;else}手工组卷{x2;endif}
						</td>
						<td>
							{x2;date:v:exam['examtime'],'Y-m-d'}
						</td>
						<td>
							{x2;$subjects[v:exam['examsubject']]['subject']}
						</td>
						<td>
							<div class="btn-group">
	                    		<a class="btn" href="index.php?{x2;$_app}-teach-exams-modify&page={x2;$page}&examid={x2;v:exam['examid']}{x2;$u}" title="修改"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?{x2;$_app}-teach-exams-del&page={x2;$page}&examid={x2;v:exam['examid']}{x2;$u}" title="删除"><em class="icon-remove"></em></a>
	                    	</div>
						</td>
			        </tr>
			        {x2;endtree}
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
	            <ul>{x2;$exams['pages']}</ul>
	        </div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}