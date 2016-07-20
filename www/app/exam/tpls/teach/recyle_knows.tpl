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
					<a href="#">已删知识点</a>
				</li>
			</ul>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>知识点ID</th>
						<th>知识点名称</th>
						<th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                    {x2;tree:$knows['data'],know,kid}
					<tr>
						<td>{x2;v:know['knowsid']}</td>
						<td>{x2;v:know['knows']}</td>
						<td>
							<div class="btn-group">
	                    		<a class="btn ajax" href="index.php?exam-teach-recyle-backknows&page={x2;$page}&knowsid={x2;v:know['knowsid']}{x2;$u}" title="修改"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?exam-teach-recyle-delknows&page={x2;$page}&knowsid={x2;v:know['knowsid']}{x2;$u}" title="删除"><em class="icon-remove"></em></a>
	                    	</div>
	                    </td>
					</tr>
					{x2;endtree}
	        	</tbody>
	        </table>
	        <!--
	        <div class="control-group">
	            <div class="controls">
		            <label class="radio inline">
		                <input type="radio" name="action" value="reback" />恢复
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
		            <input type="hidden" name="modifycontentsequence" value="1"/>
		            <input type="hidden" name="catid" value="{x2;$catid}"/>
		            <input type="hidden" name="page" value="{x2;$page}"/>
		        </div>
	        </div>
			-->
			<div class="pagination pagination-right">
				<ul>{x2;$knows['pages']}</ul>
			</div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}