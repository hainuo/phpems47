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
				<li><a href="index.php?{x2;$_app}-master-contents&page={x2;$page}">内容管理</a> <span class="divider">/</span></li>
				<li class="active">修改内容</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">修改内容</a>
				</li>
				<li class="pull-right">
					<a href="index.php?{x2;$_app}-master-contents&catid={x2;$content['contentid']}&page={x2;$page}">内容管理</a>
				</li>
			</ul>
			<form action="index.php?content-master-contents-edit" method="post" class="form-horizontal">
				<div class="control-group">
		            <label for="contenttitle" class="control-label">标题：</label>
		            <div class="controls">
					    <input type="text" id="contenttitle" name="args[contenttitle]" needle="needle" msg="您必须输入标题" value="{x2;$content['contenttitle']}">
			        </div>
		        </div>
		        <!--
		        <div class="controls">
		            <label for="block" class="control-label">标题颜色：</label>
		            <input type="text" name="args[contenttitle]" needle="needle" msg="您必须输入标题">
		        </div>
		        <div class="controls">
		            <label for="block" class="control-label">标题加粗：</label>
		            <input type="text" name="args[contenttitle]" needle="needle" msg="您必须输入标题">
		        </div>

		        <div class="control-group">
		            <label for="contentmoduleid" class="control-label">模型：</label>
		            <div class="controls">
					    <select id="contentmoduleid" msg="您必须选择信息模型" refreshjs="on" needle="needle" class="combox" name="args[contentmoduleid]" refUrl="index.php?content-master-module-moduleforms&moduleid={value}" target="contentforms">
			            	<option value="">选择信息模型</option>
			            	{x2;tree:$modules,module,mid}
			            	<option value="{x2;v:module['moduleid']}">{x2;v:module['modulename']}</option>
			            	{x2;endtree}
			            </select>
			        </div>
		        </div>
		        -->
		        <div class="control-group">
		            <label for="block" class="control-label">缩略图：</label>
		            <div class="controls">
			            <div class="thumbuper pull-left">
							<div class="thumbnail">
								<a href="javascript:;" class="second label""><em class="uploadbutton" id="contentthumb" exectype="thumb"></em></a>
								<div class="first" id="contentthumb_percent"></div>
								<div class="boot"><img src="{x2;if:$content['contentthumb']}{x2;$content['contentthumb']}{x2;else}app/core/styles/images/noimage.gif{x2;endif}" id="contentthumb_view"/><input type="hidden" name="args[contentthumb]" value="{x2;$content['contentthumb']}" id="contentthumb_value"/></div>
							</div>
						</div>
					</div>
		        </div>
		        <div class="control-group">
		            <label for="contentlink" class="control-label">站外链接：</label>
		            <div class="controls">
					    <input type="text" id="contentlink" name="args[contentlink]" value="{x2;if:$content['contentlink']}{x2;realhtml:$content['contentlink']}{x2;endif}">
			        </div>
		        </div>
		        <div class="control-group">
		            <label for="contentdescribe" class="control-label">摘要：</label>
		            <div class="controls">
					    <textarea id="contentdescribe" class="input-xxlarge" name="args[contentdescribe]" rows="7" cols="4">{x2;$content['contentdescribe']}</textarea>
			        </div>
		        </div>
    			{x2;tree:$forms,form,fid}
				<div class="control-group">
					<label for="{x2;v:form['id']}" class="control-label">{x2;v:form['title']}</label>
					<div class="controls">
						{x2;v:form['html']}
					</div>
				</div>
				{x2;endtree}
		    	<div class="control-group">
		            <label for="contenttext" class="control-label">内容</label>
		            <div class="controls">
					    <textarea id="contenttext" rows="7" cols="4" class="ckeditor" name="args[contenttext]">{x2;$content['contenttext']}</textarea>
			        </div>
		        </div>
		        <div class="control-group">
		            <label for="contenttemplate" class="control-label">模版：</label>
		            <div class="controls">
					    <select name="args[contenttemplate]" id="contenttemplate">
			            	{x2;tree:$tpls,tpl,tid}
			            	<option value="{x2;v:tpl}">{x2;v:tpl}</option>
			            	{x2;endtree}
			            </select>
			        </div>
		        </div>
		        <div class="control-group">
		            <div class="controls">
			            <button class="btn btn-primary" type="submit">提交</button>
			            <input type="hidden" name="contentid" value="{x2;$contentid}">
			            <input type="hidden" name="gotopos" value="1">
			            <input type="hidden" name="submit" value="1">
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