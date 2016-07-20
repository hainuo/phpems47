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
				<li class="active">附件管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">附件管理</a>
				</li>
			</ul>
			<form action="index.php?document-master-files" method="post">
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
							附件ID：
						</td>
						<td>
							<input name="search[attid]" class="input-small" size="25" type="text" class="number" value="{x2;$search['attid']}"/>
						</td>
						<td>
							上传时间：
						</td>
						<td>
							<input class="input-small datetimepicker" data-date="{x2;date:TIME,'Y-m-d'}" data-date-format="yyyy-mm-dd" type="text" name="search[stime]" size="10" id="stime" value="{x2;$search['stime']}"/> - <input class="input-small datetimepicker" data-date="{x2;date:TIME,'Y-m-d'}" data-date-format="yyyy-mm-dd" size="10" type="text" name="search[etime]" id="etime" value="{x2;$search['etime']}"/>
						</td>
						<td>
							文件类型：
						</td>
						<td>
			        		<select name="search[atttype]" class="input-medium">
				        		<option value="0">选择文件类型</option>
						  		{x2;tree:$attachtypes,att,aid}
						  		<option value="{x2;v:att['atid']}"{x2;if:v:att['atid'] == $search['atttype']} selected{x2;endif}>{x2;v:att['attachtype']}</option>
						  		{x2;endtree}
					  		</select>
			        	</td>
					</tr>
					<tr>
						<td>
							上传用户：
						</td>
			        	<td>
			        		<input class="input-small" name="search[username]" size="25" type="text" value="{x2;$search['username']}"/>
			        	</td>
						<td colspan="2">
							<button class="btn btn-primary" type="submit">搜索</button>
							<input type="hidden" value="1" name="search[argsmodel]" />
						</td>
						<td colspan="2"></td>
					</tr>
				</table>
			</form>
			<form action="index.php?document-master-files-batdel" method="post">
				<fieldset>
					<table class="table table-hover">
			            <thead>
			                <tr>
			                    <th><input type="checkbox" class="checkall" target="delids"/></th>
			                    <th>ID</th>
						        <th>文件名</th>
						        <th>真实路径</th>
						        <th>录入时间</th>
						        <th>操作</th>
			                </tr>
			            </thead>
			            <tbody>
		                    {x2;tree:$attach['data'],attach,aid}
					        <tr>
								<td><input type="checkbox" name="delids[{x2;v:attach['attid']}]" value="1"></td>
								<td>
									{x2;v:attach['attid']}
								</td>
								<td>
									{x2;v:attach['atttitle']}
								</td>
								<td>
									{x2;v:attach['attpath']}
								</td>
								<td>
									{x2;date:v:attach['attinputtime'],'Y-m-d'}
								</td>
								<td>
									<div class="btn-group">
			                    		<a class="btn" href="index.php?document-master-files-modify&page={x2;$page}&attid={x2;v:attach['attid']}{x2;$u}" title="修改"><em class="icon-edit"></em></a>
										<a class="btn confirm" href="index.php?document-master-files-del&page={x2;$page}&attid={x2;v:attach['attid']}{x2;$u}" title="删除"><em class="icon-remove"></em></a>
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
			            <ul>{x2;$attach['pages']}</ul>
			        </div>
		        </fieldset>
			</form>
	        <div aria-hidden="true" id="modal" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel">
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