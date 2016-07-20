{x2;if:!$userhash}
{x2;include:header}
<body>
{x2;include:nav}
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
{x2;endif}
			<div class="examform">
				<ul class="breadcrumb">
					<li>
						<span class="icon-home"></span> <a href="index.php?exam">考场选择</a> <span class="divider">/</span>
					</li>
					<li class="active">
						开通考场
					</li>
				</ul>
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#" data-toggle="tab">开通考场</a>
					</li>
				</ul>
				<form action="index.php?exam-app-basics-open" method="post">
					<table class="table">
						<thead>
			                <tr>
						        <th colspan="5">搜索</th>
			                </tr>
			            </thead>
						<tr>
							<td>
								是否免费：
							</td>
							<td>
								<select name="search[basicdemo]" class="input-medium">
									<option value="0">不限</option>
									<option value="1"{x2;if:$search['basicdemo']} selected{x2;endif}>免费</option>
								</select>
							</td>
							<td>
								关键字：
							</td>
							<td>
								<input class="input-medium" name="search[keyword]" type="text" value="{x2;$search['keyword']}"/>
							</td>
							<td></td>
						</tr>
				        <tr>
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
								<button class="btn btn-primary" type="submit">提交</button>
							</td>
						</tr>
					</table>
					<div class="input">
						<input type="hidden" value="1" name="search[argsmodel]" />
					</div>
				</form>
				<div class="span12">
		            <ul class="thumbnails">
						{x2;tree:$basics['data'],basic,bid}
						<li class="span2">
							<div class="thumbnail">
								<a class="thumbnail" href="index.php?exam-app-basics-detail&basicid={x2;v:basic['basicid']}" title="{x2;v:basic['basic']}"><img alt="300x200" src="{x2;if:v:basic['basicthumb']}{x2;v:basic['basicthumb']}{x2;else}app/exam/styles/image/paper.png{x2;endif}" style="width:160px;"/></a>
								<div class="caption">
									<div class="text-center">
										<h6>{x2;substring:v:basic['basic'],28}</h6>
										<p>
										{x2;if:$data['openbasics'][v:basic['basicid']]}
										<a class="btn" href="javascript:;" title="{x2;v:basic['basic']}">已开通</a>
										{x2;else}
											{x2;if:v:basic['basicdemo']}
											<a class="btn btn-success" href="index.php?exam-app-basics-detail&basicid={x2;v:basic['basicid']}" title="{x2;v:basic['basic']}">免费开通</a>
											{x2;else}
											<a class="btn btn-primary" href="index.php?exam-app-basics-detail&basicid={x2;v:basic['basicid']}" title="{x2;v:basic['basic']}">去开通</a>
											{x2;endif}
										{x2;endif}
										</p>
									</div>
								</div>
							</div>
						</li>
						{x2;if:v:bid % 6 == 0}
						</ul>
						<ul class="thumbnails">
						{x2;endif}
						{x2;endtree}
					</ul>
				</div>
				<div class="pagination pagination-right">
					<ul>{x2;$basics['pages']}</ul>
		        </div>
			</div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
{x2;include:foot}
</body>
</html>
{x2;endif}