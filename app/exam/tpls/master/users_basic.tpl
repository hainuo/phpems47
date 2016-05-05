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
				<li><a href="index.php?{x2;$_app}-master-users">开通课程</a> <span class="divider">/</span></li>
				<li class="active">课程选择</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">课程选择</a>
				</li>
				<li class="dropdown pull-right">
					<a href="index.php?{x2;$_app}-master-users">开通课程</a>
				</li>
			</ul>
	        <form action="index.php?exam-master-users-basics&userid={x2;$userid}" method="post" class="form-inline">
				<table class="table">
					<thead>
						<tr>
							<th colspan="6">搜索</th>
						</tr>
					</thead>
					<tr>
						<td>
							考场ID：
						</td>
						<td>
							<input name="search[basicid]" class="inline" type="text" class="number" value="{x2;$search['basicid']}"/>
						</td>
						<td>
							关键字：
						</td>
						<td>
							<input name="search[keyword]" type="text" value="{x2;$search['keyword']}"/>
						</td>
						<td>
							地区：
						</td>
			        	<td>
			        		<select name="search[basicareaid]">
			        		<option value="0">选择地区</option>
					  		{x2;tree:$areas,area,aid}
					  		<option value="{x2;v:area['areaid']}"{x2;if:v:area['areaid'] == $search['basicareaid']} selected{x2;endif}>{x2;v:area['area']}</option>
					  		{x2;endtree}
					  		</select>
			        	</td>
			        </tr>
			        <tr>
			        	<td>
							API标识：
						</td>
						<td>
							<input class="inline" name="search[basicapi]" type="text" value="{x2;$search['basicapi']}"/>
						</td>
						<td>
							科目：
						</td>
						<td>
			        		<select name="search[basicsubjectid]">
			        		<option value="0">选择科目</option>
					  		{x2;tree:$subjects,subject,sid}
					  		<option value="{x2;v:subject['subjectid']}"{x2;if:v:subject['subjectid'] == $search['basicsubjectid']} selected{x2;endif}>{x2;v:subject['subject']}</option>
					  		{x2;endtree}
					  		</select>
			        	</td>
						<td>
							<button class="btn btn-primary" type="submit">搜索</button>
							<input type="hidden" value="1" name="search[argsmodel]" />
						</td>
						<td></td>
					</tr>
				</table>
			</form>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>考场ID</th>
				        <th>考场名称</th>
				        <th>考场地区</th>
				        <th>考试科目</th>
				        <th>到期时间</th>
				        <th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                    {x2;tree:$basics['data'],basic,bid}
			        <tr>
						<td>
							{x2;v:basic['basicid']}
						</td>
						<td>
							{x2;v:basic['basic']}
						</td>
						<td>
							{x2;$areas[v:basic['basicareaid']]['area']}
						</td>
						<td>
							{x2;$subjects[v:basic['basicsubjectid']]['subject']}
						</td>
						<td>
							{x2;if:$openbasics[v:basic['basicid']]}{x2;date:$openbasics[v:basic['basicid']]['obendtime'],'Y-m-d'}{x2;else}未开启{x2;endif}
						</td>
						<td>
							{x2;if:$openbasics[v:basic['basicid']]}<a class="ajax btn" title="关闭考场" href="index.php?exam-master-users-closebasics&userid={x2;$userid}&basicid={x2;v:basic['basicid']}"><em class="icon-minus-sign"></em></a>{x2;else}<a class="ajax btn" href="index.php?exam-master-users-openbasics&userid={x2;$userid}&basicid={x2;v:basic['basicid']}" title="开启考场"><em class="icon-plus-sign"></em></a>{x2;endif}
						</td>
			        </tr>
			        {x2;endtree}
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
	            <ul>{x2;$basics['pages']}</ul>
	        </div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}