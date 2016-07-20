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
				<li class="active">添加内容</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">添加内容</a>
				</li>
				<li class="pull-right">
					<a href="index.php?{x2;$_app}-master-contents&catid={x2;$catid}&page={x2;$page}">内容管理</a>
				</li>
			</ul>
			<form action="index.php?content-master-contents-add" method="post" class="form-horizontal">
				<div class="control-group">
		            <label for="contenttitle" class="control-label">标题：</label>
		            <div class="controls">
					    <input type="text" id="contenttitle" name="args[contenttitle]" needle="needle" msg="您必须输入标题">
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
		        -->
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
		        <div class="control-group">
		            <label for="block" class="control-label">缩略图：</label>
		            <div class="controls">
			            <div class="thumbuper pull-left">
							<div class="thumbnail">
								<a href="javascript:;" class="second label""><em class="uploadbutton" id="contentthumb" exectype="thumb"></em></a>
								<div class="first" id="contentthumb_percent"></div>
								<div class="boot"><img src="app/core/styles/images/noimage.gif" id="contentthumb_view"/><input type="hidden" name="args[contentthumb]" value="" id="contentthumb_value"/></div>
							</div>
						</div>
					</div>
		        </div>
		        <div class="control-group">
		            <label for="contentcatid" class="control-label">分类：</label>
		        	<div class="controls form-inline">
					    <select id="contentcatid" msg="您必须选择一个分类" needle="needle" class="autocombox input-medium" name="args[contentcatid]" refUrl="index.php?content-master-category-ajax-getchildcategory&catid={value}">
			            	<option value="">选择一级分类</option>
			            	{x2;tree:$parentcat,cat,cid}
			            	<option value="{x2;v:cat['catid']}">{x2;v:cat['catname']}</option>
			            	{x2;endtree}
			            </select>
			        </div>
		        </div>
		        <div class="control-group">
		            <label for="contentlink" class="control-label">站外链接：</label>
		            <div class="controls">
					    <input type="text" id="contentlink" name="args[contentlink]">
			        </div>
		        </div>
		        <div class="control-group">
		            <label for="contentdescribe" class="control-label">摘要：</label>
		            <div class="controls">
					    <textarea id="contentdescribe" class="input-xxlarge" name="args[contentdescribe]" rows="7" cols="4"></textarea>
			        </div>
		        </div>
		    	<div id="contentforms"></div>
		    	<div class="control-group">
		            <label for="contenttext" class="control-label">内容</label>
		            <div class="controls">
					    <textarea id="contenttext" rows="7" cols="4" class="ckeditor" name="args[contenttext]"></textarea>
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
		        {x2;if:$poses}
		        <div class="control-group">
		            <label class="control-label">推荐到：</label>
	            	<div class="controls">
					    {x2;tree:$poses,pos,pid}
		            	<label class="checkbox inline">
		            		<input type="checkbox" value="{x2;v:pos['posid']}" name="position[]">{x2;v:pos['posname']}
		            	</label>
		            	{x2;endtree}
			        </div>
		        </div>
		        {x2;endif}
		        <div class="control-group">
		            <div class="controls">
			            <button class="btn btn-primary" type="submit">提交</button>
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