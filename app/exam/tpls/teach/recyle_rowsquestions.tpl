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
				<li class="active">回收站</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">已删题冒题</a>
				</li>
			</ul>
	        <table class="table table-hover">
	            <thead>
	                <tr>
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
						<td>
							{x2;v:question['qrid']}
						</td>
						<td>
							{x2;$questypes[v:question['qrtype']]['questype']}
						</td>
						<td>
							<a title="查看试题" class="selfmodal" href="javascript:;" url="index.php?exam-teach-rowsquestions-detail&questionid={x2;v:question['qrid']}&{x2;c:TIME}" data-target="#modal">{x2;realsubstring: v:question['qrquestion'],120}</a>
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
	                    		<a class="btn ajax" href="index.php?exam-teach-rowsquestions-backquestion&page={x2;$page}&questionid={x2;v:question['qrid']}{x2;$u}" title="恢复本题将会恢复本题下所有已删除子题"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?exam-teach-recyle-finaldelrowsquestion&page={x2;$page}&questionid={x2;v:question['qrid']}{x2;$u}" title="彻底删除"><em class="icon-remove"></em></a>
	                    	</div>
	                    </td>
			        </tr>
			        {x2;endtree}
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
				<ul>{x2;$questions['pages']}</ul>
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
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}