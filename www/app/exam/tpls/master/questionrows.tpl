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
				<li class="active">题冒题管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">题冒题管理</a>
				</li>
				<li class="dropdown pull-right">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">添加题冒<strong class="caret"></strong></a>
					<ul class="dropdown-menu">
						<li><a href="index.php?{x2;$_app}-master-rowsquestions-addquestionrows&page={x2;$page}{x2;$u}">单题添加</a></li>
						<li><a href="index.php?{x2;$_app}-master-rowsquestions-bataddquestionrows&page={x2;$page}{x2;$u}">批量添加</a></li>
					</ul>
				</li>
			</ul>
	        <form action="index.php?exam-master-rowsquestions" method="post">
				<table class="table">
					<tr>
						<td>
							试题ID：
						</td>
						<td>
							<input name="search[questionid]" class="input-small" size="25" type="text" class="number" value="{x2;$search['questionid']}"/>
						</td>
						<td>
							录入时间：
						</td>
						<td>
							<input class="input-small datetimepicker" data-date="{x2;date:TIME,'Y-m-d'}" data-date-format="yyyy-mm-dd" type="text" name="search[stime]" size="10" id="stime" value="{x2;$search['stime']}"/> - <input class="input-small datetimepicker" data-date="{x2;date:TIME,'Y-m-d'}" data-date-format="yyyy-mm-dd" size="10" type="text" name="search[etime]" id="etime" value="{x2;$search['etime']}"/>
						</td>
						<td>
							关键字：
						</td>
						<td>
							<input class="input-small" name="search[keyword]" size="25" type="text" value="{x2;$search['keyword']}"/>
						</td>
					</tr>
			        <tr>
						<td>
							科目：
						</td>
						<td>
			        		<select name="search[questionsubjectid]" class="combox input-medium" target="sectionselect" refUrl="?exam-master-questions-ajax-getsectionsbysubjectid&subjectid={value}">
			        		<option value="0">选择科目</option>
					  		{x2;tree:$subjects,subject,sid}
					  		<option value="{x2;v:subject['subjectid']}"{x2;if:v:subject['subjectid'] == $search['questionsubjectid']} selected{x2;endif}>{x2;v:subject['subject']}</option>
					  		{x2;endtree}
					  		</select>
			        	</td>
			        	<td>
							章节：
						</td>
						<td>
					  		<select name="search[questionsectionid]" class="combox input-medium" id="sectionselect" target="knowsselect" refUrl="?exam-master-questions-ajax-getknowsbysectionid&sectionid={value}">
					  		<option value="0">选择章节</option>
					  		{x2;if:$sections}
					  		{x2;tree:$sections,section,sid}
					  		<option value="{x2;v:section['sectionid']}"{x2;if:v:section['sectionid'] == $search['questionsectionid']} selected{x2;endif}>{x2;v:section['section']}</option>
					  		{x2;endtree}
					  		{x2;endif}
					  		</select>
			        	</td>
			        	<td>
							知识点：
						</td>
						<td>
					  		<select name="search[questionknowsid]" id="knowsselect" class="input-medium">
						  		<option value="">选择知识点</option>
						  		{x2;if:$knows}
						  		{x2;tree:$knows,know,kid}
						  		<option value="{x2;v:know['knowsid']}"{x2;if:v:know['knowsid'] == $search['questionknowsid']} selected{x2;endif}>{x2;v:know['knows']}</option>
						  		{x2;endtree}
						  		{x2;endif}
					  		</select>
			        	</td>
					</tr>
					<tr>
						<td>
							录入人：
						</td>
			        	<td>
			        		<input class="input-small" name="search[username]" size="25" type="text" value="{x2;$search['username']}"/>
			        	</td>
			        	<td>
							试题类型：
						</td>
						<td>
							<select name="search[questiontype]" class="input-medium">
						  		<option value="0">类型不限</option>
						  		{x2;tree:$questypes,questype,qid}
						  		<option value="{x2;v:questype['questid']}">{x2;v:questype['questype']}</option>
						  		{x2;endtree}
					  		</select>
						</td>
						<td>
							难度：
						</td>
						<td>
							<select name="search[qrlevel]" class="input-medium">
						  		<option value="0">难度不限</option>
								<option value="1"{x2;if:$search['qrlevel'] == 1} selected{x2;endif}>易</option>
								<option value="2"{x2;if:$search['qrlevel'] == 2} selected{x2;endif}>中</option>
								<option value="3"{x2;if:$search['qrlevel'] == 3} selected{x2;endif}>难</option>
					  		</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<button class="btn btn-primary" type="submit">搜索</button>
							<input type="hidden" value="1" name="search[argsmodel]" />
						</td>
						<td colspan="4"></td>
					</tr>
				</table>
			</form>
			<form action="index.php?exam-master-rowsquestions-batdel" method="post">
				<fieldset>
			        <table class="table table-hover">
			            <thead>
			                <tr>
			                    <th><input type="checkbox" class="checkall" target="delids"/></th>
			                    <th>ID</th>
						        <th>试题类型</th>
						        <th>试题内容</th>
						        <th>录入人</th>
						        <th>录入时间</th>
						        <th>难度</th>
						        <th>操作</th>
			                </tr>
			            </thead>
			            <tbody>
		                    {x2;tree:$questions['data'],question,qid}
					        <tr>
								<td><input type="checkbox" name="delids[{x2;v:question['qrid']}]" value="1"></td>
								<td>
									{x2;v:question['qrid']}
								</td>
								<td>
									{x2;$questypes[v:question['qrtype']]['questype']}
								</td>
								<td>
									<a title="查看试题" class="selfmodal" href="javascript:;" url="index.php?exam-master-rowsquestions-detail&questionid={x2;v:question['qrid']}&{x2;c:TIME}" data-target="#modal">{x2;substring:strip_tags(html_entity_decode(v:question['qrquestion'])),135}</a>
								</td>
								<td>
									{x2;v:question['qrusername']}
								</td>
								<td>
									{x2;date:v:question['qrtime'],'Y-m-d'}
								</td>
								<td>
									{x2;if:v:question['qrlevel']==2}中{x2;elseif:v:question['qrlevel']==3}难{x2;elseif:v:question['qrlevel']==1}易{x2;endif}
								</td>
								<td>
									<div class="btn-group">
			                    		<a class="btn" href="index.php?exam-master-rowsquestions-rowsdetail&questionid={x2;v:question['qrid']}&page={x2;$page}{x2;$u}" title="子试题列表"><em class="icon-th-list"></em></a>
										<a class="btn" href="index.php?exam-master-rowsquestions-modifyquestion&questionid={x2;v:question['qrid']}&page={x2;$page}{x2;$u}" title="修改"><em class="icon-edit"></em></a>
										<a class="btn confirm" href="index.php?exam-master-rowsquestions-delquestion&questionid={x2;v:question['qrid']}&page={x2;$page}{x2;$u}" title="删除"><em class="icon-remove"></em></a>
			                    	</div>
								</td>
					        </tr>
					        {x2;endtree}
			        	</tbody>
			        </table>
			        <div class="control-group">
			            <div class="controls">
				            <label class="radio inline">
				                <input type="radio" name="action" value="delete" checked/>删除
				            </label>
				            {x2;tree:$search,arg,sid}
				            <input type="hidden" name="search[{x2;v:key}]" value="{x2;v:arg}"/>
				            {x2;endtree}
				            <label class="radio inline">
				            	<button class="btn btn-primary" type="submit">提交</button>
				            </label>
				            <input type="hidden" name="page" value="{x2;$page}"/>
				        </div>
			        </div>
			        <div class="pagination pagination-right">
			            <ul>{x2;$questions['pages']}</ul>
			        </div>
				</fieldset>
			</form>
	        <div aria-hidden="true" id="modal" class="modal hide fade" role="dialog" aria-labelledby="#myModalLabel">
				<div class="modal-header">
					<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
					<h3 id="myModalLabel">
						试题详情
					</h3>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					 <button aria-hidden="true" class="btn" data-dismiss="modal">关闭</button>
				</div>
			</div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}