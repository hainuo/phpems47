{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			{x2;include:menu}
		</div>
		<div class="span10" id="datacontent">
			<ul class="breadcrumb">
				<li><a href="index.php?{x2;$_app}-master">{x2;$apps[$_app]['appname']}</a> <span class="divider">/</span></li>
				<li><a href="index.php?{x2;$_app}-master-category">分类管理</a> <span class="divider">/</span></li>
				<li class="active">添加分类</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">添加分类</a>
				</li>
				<li class="pull-right">
					<a href="index.php?{x2;$_app}-master-category&parent={x2;$category['catparent']}">分类列表</a>
				</li>
			</ul>
			<form action="index.php?{x2;$_app}-master-category-edit" method="post" class="form-horizontal">
				<fieldset>
					<div class="control-group">
					</div>
					<div class="control-group">
						<label for="modulename" class="control-label">分类名称</label>
						<div class="controls">
							<input type="text" id="input1" name="args[catname]" value="{x2;$category['catname']}" datatype="userName" needle="needle" msg="您必须输入中英文字符的分类名称">
							<span class="help-block">请输入分类名称</span>
						</div>
					</div>
					{x2;if:!$cat['catparent']}
					<div class="control-group">
						<label for="modulename" class="control-label">前台显示</label>
						<div class="controls">
							<label class="radio inline">
				          		<input type="radio" class="input-text" name="args[catinmenu]" value="1"{x2;if:$category['catinmenu']} checked{x2;endif}/> 不显示
				          	</label>
				          	<label class="radio inline">
				          		<input type="radio" class="input-text" name="args[catinmenu]" value="0"{x2;if:!$category['catinmenu']} checked{x2;endif}/> 显示
				          	</label>
				          	<span class="help-block">勾选此项后，分类将显示在内容模块前台的分类列表区域。</span>
						</div>
					</div>
					{x2;endif}
					<div class="control-group">
						<label for="modulename" class="control-label">在首页展示内容</label>
						<div class="controls">
							<input type="text" name="args[catindex]" value="{x2;if:$category['catindex']}{x2;$category['catindex']}{x2;else}0{x2;endif}" datatype="number" needle="needle" msg="您必须填写展示内容条数"> 条
							<span class="help-block">填写展示内容条数，如果不需要在首页展示，请填写0。</span>
						</div>
					</div>
					<div class="control-group">
						<label for="modulecode" class="control-label">分类排序</label>
						<div class="controls">
							<input type="text" id="input2" name="args[catlite]" value="{x2;$category['catlite']}" datatype="number" msg="排序为整数">
						</div>
					</div>
					<div class="control-group">
						<label for="moduledescribe" class="control-label">外链地址</label>
						<div class="controls">
							<input type="text" name="args[caturl]" value="{x2;realhtml:$category['caturl']}">
						</div>
					</div>
					<div class="control-group">
						<label for="moduledescribe" class="control-label">使用外链地址</label>
						<div class="controls">
							<label class="radio inline">
								<input type="radio"  name="args[catuseurl]" value="1"{x2;if:$category['catuseurl']} checked{x2;endif}>使用
							</label>
			            	<label class="radio inline">
			            		<input type="radio"  name="args[catuseurl]" value="0"{x2;if:!$category['catuseurl']} checked{x2;endif}>不使用
			            	</label>
							<span class="help-block">填写外链地址后，该分类会直接转到外链地址</span>
						</div>
					</div>
					<div class="control-group">
						<label for="moduledescribe" class="control-label">发布用户</label>
						<div class="controls">
							<input type="text" name="args[catmanager][pubusers]" value="{x2;$category['catmanager']['pubusers']}">
							<span class="help-block">填写用户ID，用英文逗号隔开</span>
						</div>
					</div>
					<div class="control-group">
						<label for="moduledescribe" class="control-label">发布角色</label>
						<div class="controls">
							<input type="text" name="args[catmanager][pubgroups]" value="{x2;$category['catmanager']['pubgroups']}">
							<span class="help-block">填写角色ID，用英文逗号隔开</span>
						</div>
					</div>
					<div class="control-group">
						<label for="modulecode" class="control-label">分类模板</label>
						<div class="controls">
							<select name="args[cattpl]">
				            	{x2;tree:$tpls,tpl,tid}
				            	<option value="{x2;v:tpl}"{x2;if:$category['cattpl'] == v:tpl} selected{x2;endif}>{x2;v:tpl}</option>
				            	{x2;endtree}
				            </select>
						</div>
					</div>
					<div class="control-group">
						<label for="moduledescribe" class="control-label">分类图片</label>
						<div class="controls">
							<div class="thumbuper pull-left">
								<div class="thumbnail">
									<a href="javascript:;" class="second label""><em class="uploadbutton" id="catimg" exectype="thumb"></em></a>
									<div class="first" id="catimg_percent"></div>
									<div class="boot"><img src="{x2;if:$category['catimg']}{x2;$category['catimg']}{x2;else}app/core/styles/images/noimage.gif{x2;endif}" id="catimg_view"/><input type="hidden" name="args[catimg]" value="{x2;$category['catimg']}" id="catimg_value"/></div>
								</div>
							</div>
						</div>
					</div>
					<div class="control-group">
						<label for="catdes" class="control-label">分类简介</label>
						<div class="controls">
							<textarea class="input-xxlarge ckeditor" rows="7" id="catdes" name="args[catdes]">{x2;realhtml:$category['catdes']}</textarea>
							<span class="help-block">对这个模型进行描述</span>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<button class="btn btn-primary" type="submit">提交</button>
							<input type="hidden" name="submit" value="1">
				            <input type="hidden" name="page" value="{x2;$page}">
				            <input type="hidden" name="catid" value="{x2;$catid}">
				            <input type="hidden" name="parent" value="{x2;$parent}">
							{x2;tree:$search,arg,aid}
							<input type="hidden" name="search[{x2;v:key}]" value="{x2;v:arg}"/>
							{x2;endtree}
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
</body>
</html>