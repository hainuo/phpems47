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
				<li><a href="index.php?{x2;$_app}-teach-rowsquestions&page={x2;$page}{x2;$u}">题冒题管理</a> <span class="divider">/</span></li>
				<li class="active">子试题列表</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">子试题列表</a>
				</li>
				<li class="dropdown pull-right">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">添加子试题<strong class="caret"></strong></a>
					<ul class="dropdown-menu">
						<li><a href="index.php?{x2;$_app}-teach-rowsquestions-addchildquestion&questionid={x2;$questionparent}&page={x2;$page}{x2;$u}">单题添加</a></li>
						<li><a href="index.php?{x2;$_app}-teach-rowsquestions-bataddchildquestion&questionid={x2;$questionparent}&page={x2;$page}{x2;$u}">批量添加</a></li>
					</ul>
				</li>
			</ul>
			<form action="index.php?exam-teach-rowsquestions-done" method="post">
				<table class="table table-hover">
					<thead>
						<tr>
					        <th>题冒</th>
					        <th></th>
						</tr>
					</thead>
					<tbody>
				        <tr>
				          <td width="100">所属知识点：</td>
				          <td>{x2;tree:$question['qrknowsid'],know,kid}&nbsp;{x2;v:know['knows']}{x2;endtree}&nbsp;</td>
				        </tr>
				        <tr>
				          <td>题帽：</td>
				          <td>{x2;eval: echo html_entity_decode($question['qrquestion'])}</td>
				        </tr>
			        </tbody>
				</table>
				<div class="input">&nbsp;</div>
				<table class="table table-hover">
					<thead>
						<tr>
					        <th>ID</th>
					        <th>排序</th>
					        <th>试题类型</th>
					        <th>试题内容</th>
					        <th>操作</th>
						</tr>
					</thead>
					<tbody>
						{x2;tree:$question['data'],question,qid}
						<tr>
							<td>{x2;v:question['questionid']}</td>
							<td><input style="width:24px;padding:2px 5px;" type="text" name="sequence[{x2;v:question['questionid']}][]" value="{x2;v:question['questionsequence']}" /></td>
							<td>{x2;$questypes[v:question['questiontype']]['questype']}</td>
							<td>
								<a title="查看试题" class="selfmodal" href="javascript:;" url="index.php?exam-teach-questions-detail&questionid={x2;v:question['questionid']}" title="查看试题" data-target="#modal">{x2;eval: echo strip_tags(html_entity_decode(v:question['question']))}</a>
							</td>
							<td>
								<div class="btn-group">
		                    		<a class="btn" href="index.php?exam-teach-rowsquestions-modifychildquestion&page={x2;$page}&questionparent={x2;$question['qrid']}&questionid={x2;v:question['questionid']}{x2;$u}" title="修改"><em class="icon-edit"></em></a>
									<a class="btn ajax" href="index.php?exam-teach-rowsquestions-delchildquestion&questionparent={x2;$question['qrid']}&page={x2;$page}&questionid={x2;v:question['questionid']}{x2;$u}" title="删除"><em class="icon-remove"></em></a>
		                    	</div>
							</td>
						</tr>
						{x2;endtree}
					</tbody>
				</table>
				<div class="control-group">
		            <div class="controls">
			            <label class="radio inline">
			                <input type="radio" name="action" value="modify" checked/>排序
			            </label>
			            <label class="radio inline">
			                <input type="radio" name="action" value="delete" />删除
			            </label>
			            {x2;tree:$search,arg,sid}
			            <input type="hidden" name="search[{x2;v:key}]" value="{x2;v:arg}"/>
			            {x2;endtree}
			            <label class="radio inline">
			            	<button class="btn btn-primary" type="submit">提交</button>
			            </label>
			            <input type="hidden" name="modifyfieldsequence" value="1"/>
  						<input type="hidden" name="questionparent" value="{x2;$questionparent}"/>
			            <input type="hidden" name="page" value="{x2;$page}"/>
			        </div>
		        </div>
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
			</form>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}