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
				{x2;if:$catid}
				<li><a href="index.php?{x2;$_app}-master-contents">考场管理</a> <span class="divider">/</span></li>
				<li class="active">{x2;$categories[$catid]['catname']}</li>
				{x2;else}
				<li class="active">考场管理</li>
				{x2;endif}
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">考场管理</a>
				</li>
				<li class="pull-right">
					<a href="index.php?exam-master-basic-add">添加考场</a>
				</li>
			</ul>
			<form action="index.php?exam-master-basic" method="post">
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
							考场ID：
						</td>
						<td>
							<input name="search[basicid]" class="input-small" type="text" class="number" value="{x2;$search['basicid']}"/>
						</td>
						<td>
							关键字：
						</td>
						<td>
							<input class="input-medium" name="search[keyword]" type="text" value="{x2;$search['keyword']}"/>
						</td>
						<td>
							地区：
						</td>
			        	<td>
			        		<select name="search[basicareaid]" class="input-medium">
				        		<option value="0">选择地区</option>
						  		{x2;tree:$areas,area,aid}
						  		<option value="{x2;v:area['areaid']}"{x2;if:v:area['areaid'] == $search['basicareaid']} selected{x2;endif}>{x2;v:area['area']}</option>
						  		{x2;endtree}
					  		</select>
			        	</td>
			        	<td></td>
			        </tr>
			        <tr>
			        	<td>
							API标识：
						</td>
						<td>
							<input class="input-small" name="search[basicapi]" type="text" value="{x2;$search['basicapi']}"/>
						</td>
						<td>
							科目：
						</td>
						<td>
			        		<select name="search[basicsubjectid]" class="input-medium">
				        		<option value="0">选择科目</option>
						  		{x2;tree:$subjects,subject,sid}
						  		<option value="{x2;v:subject['subjectid']}"{x2;if:v:subject['subjectid'] == $search['basicsubjectid']} selected{x2;endif}>{x2;v:subject['subject']}</option>
						  		{x2;endtree}
					  		</select>
			        	</td>
			        	<td>
							状态：
						</td>
			        	<td>
			        		<select name="search[basicclosed]" class="input-medium">
				        		<option value="0">不限</option>
				        		<option value="1"{x2;if:1 == $search['basicclosed']} selected{x2;endif}>仅关闭</option>
				        		<option value="-1"{x2;if:-1 == $search['basicclosed']} selected{x2;endif}>仅开启</option>
					  		</select>
			        	</td>
						<td>
							<button class="btn btn-primary" type="submit">提交</button>
						</td>

					</tr>
				</table>
				<div class="input">
					<input type="hidden" value="1" name="search[argsmodel]" />
				</div>
			</form>
	        <form action="index.php?exam-master-basic-batdelbasic" method="post">
		        <table class="table table-hover">
		            <thead>
		                <tr>
		                    <th><input type="checkbox" class="checkall"/></th>
		                    <th>考场ID</th>
					        <th>考场名称</th>
					        <th>考场地区</th>
					        <th>考试科目</th>
					        <th>开通人数</th>
					        <th>状态</th>
					        <th>操作</th>
		                </tr>
		            </thead>
		            <tbody>
		                {x2;tree:$basics['data'],basic,bid}
				        <tr>
							<td>
								<input type="checkbox" name="delids[{x2;v:basic['basicid']}]" value="1"/>
							</td>
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
								<span class="autoloaditem" autoload="index.php?exam-master-basic-getbasicmembernumber&basicid={x2;v:basic['basicid']}"></span>
							</td>
							<td>
								{x2;if:v:basic['basicclosed']}关闭{x2;else}开启{x2;endif}
							</td>
							<td>
								<div class="btn-group">
									<a class="btn" href="index.php?exam-master-basic-offpaper&page={x2;$page}&basicid={x2;v:basic['basicid']}{x2;$u}" title="考试调度"><em class="icon-wrench"></em></a>
									<a class="btn" href="index.php?exam-master-basic-setexamrange&page={x2;$page}&basicid={x2;v:basic['basicid']}{x2;$u}" title="考试范围"><em class="icon-cog"></em></a>
									<a class="btn" href="index.php?exam-master-basic-modifybasic&page={x2;$page}&basicid={x2;v:basic['basicid']}{x2;$u}" title="修改"><em class="icon-edit"></em></a>
									<a class="btn confirm" href="index.php?exam-master-basic-delbasic&basicid={x2;v:basic['basicid']}&page={x2;$page}{x2;$u}" title="删除"><em class="icon-remove"></em></a>
								</div>
							</td>
				        </tr>
				        {x2;endtree}
		        	</tbody>
		        </table>
		        <div class="control-group">
		            <div class="controls">
		            	<button class="btn btn-primary" type="submit">删除</button>
		            </div>
				</div>
			</form>
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