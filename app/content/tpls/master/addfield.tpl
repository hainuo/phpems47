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
				<li><a href="index.php?{x2;$_app}-master-module">用户模型</a> <span class="divider">/</span></li>
				<li><a href="index.php?{x2;$_app}-master-module-fields&moduleid={x2;$module['moduleid']}">字段管理</a> <span class="divider">/</span></li>
				<li class="active">添加{x2;if:$fieldpublic}公共{x2;else}模型{x2;endif}字段</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">字段管理</a>
				</li>
				<li class="pull-right">
					<a href="index.php?{x2;$_app}-master-module-fields&moduleid={x2;$module['moduleid']}">字段列表</a>
				</li>
			</ul>
			<form action="?{x2;$_app}-master-module-addfield" method="post" class="form-horizontal">
				<fieldset>
					{x2;if:$fieldpublic}
					<legend>公共字段</legend>
					{x2;else}
					<legend>{x2;$module['modulename']}</legend>
					{x2;endif}
					<div class="control-group">
						<label for="fieldtitle" class="control-label">字段别名：</label>
						<div class="controls">
							<input type="text" size="40" name="args[fieldtitle]" needle="needle" datatype="userName" id="fieldtitle" msg="您必须填写字段别名，字段别名必须为中英文字符或数字"/>
						</div>
					</div>
					{x2;if:$fieldpublic}
					<div class="control-group">
						<label for="field" class="control-label">字段名称：</label>
						<div class="controls">
							<input type="text" size="40" name="args[field]" needle="needle" datatype="datatable" id="field" msg="您必须填写字段名称，必须为英文字符和数字"/>
							<span class="help-block">填写英文字符或数字组成的字段名称</span>
						</div>
					</div>
					{x2;else}
					<div class="control-group">
						<label for="field" class="control-label">字段名称：</label>
						<div class="controls">
							<div class="input-prepend">
								<span class="add-on">{x2;$module['modulecode']}_</span>
								<input type="text" size="40" name="args[field]" needle="needle" datatype="datatable" id="field" msg="您必须填写字段名称，必须为英文字符和数字"/>
							</div>
							<span class="help-block">填写英文字符或数字组成的字段名称</span>
						</div>
					</div>
					{x2;endif}
					<div class="control-group">
						<label for="fieldtype" class="control-label">字段类型：</label>
						<div class="controls">
							<select class="combox" id="fieldtype" name="args[fieldtype]">
				          		<option value="int">整型(int/time)</option>
				          		<option value="varchar">0~255字符串型(varchar)</option>
				          		<option value="decimal">浮点型(decimal)</option>
				          		<option value="text">长文字型(text)</option>
				          	</select>
			          	</div>
					</div>
					<div class="control-group">
						<label for="fieldlength" class="control-label">字段长度：</label>
						<div class="controls">
							<input type="text" size="16" name="args[fieldlength]" id="fieldlength" value=""/>
							<span class="help-block">字段类型为整形或者字符串型时格式为正整数，如“7”，浮点型时如“10,2”，长文字型时不填</span>
						</div>
					</div>
					<div class="control-group">
						<label for="fieldhtmltype" class="control-label">HTML类型：</label>
						<div class="controls">
							<select class="combox" name="args[fieldhtmltype]" id="fieldhtmltype">
				          		<option value="text">文本域(text)</option>
				          		<option value="htmltime">时间文本域(htmltime)</option>
				          		<option value="password">密码域(password)</option>
				          		<option value="hidden">隐藏域(hidden)</option>
				          		<option value="select">下拉菜单/选择框(select)</option>
				          		<option value="radio">单选框(radio)</option>
				          		<option value="checkbox">复选框(checkbox)</option>
				          		<option value="checkboxarray">复选框组(checkboxarray)</option>
				          		<option value="textarea">文本区域(textarea)</option>
				          		<option value="editor">编辑器(editor)</option>
				          		<option value="thumb">缩略图上传(thumb)</option>
				          		<option value="picture">组图上传(picture)</option>
				          		<option value="auto">自定义(auto)</option>
				          	</select>
			          	</div>
					</div>
			        <div class="control-group">
			        	<label for="fieldhtmlproperty" class="control-label">HTML属性：</label>
	  					<div class="controls">
							<textarea class="input-xxlarge" rows="7" cols="4" name="args[fieldhtmlproperty]" id="fieldhtmlproperty"></textarea>
	  						<span class="help-block">每行一个，等号隔开，如：style=width:100px;如果需要对表单内容进行验证请查看《表单验证属性》进行配置</span>
	  					</div>
			        </div>
			        <div class="control-group">
				        <label for="fieldvalues" class="control-label">可选值列表：</label>
				        <div class="controls">
							<textarea class="input-xxlarge" rows="7" cols="4" name="args[fieldvalues]" id="fieldvalues"></textarea>
				        	<span class="help-block">每行一个，等号隔开，如：属性=值;</span>
				        </div>
			        </div>
			        <div class="control-group">
				        <label for="fielddefault" class="control-label">默认值：</label>
				        <div class="controls">
							<input type="text" size="40" name="args[fielddefault]" class="input-text" id="fielddefault" value=""/>
						</div>
			        </div>
			        <div class="control-group">
				        <label for="fieldindextype" class="control-label">索引类型：</label>
				        <div class="controls">
							<select name="args[fieldindextype]" id="fieldindextype">
				          		<option value="0">无(NULL)</option>
				          		<option value="INDEX">普通索引(INDEX)</option>
				          		<option value="UNIQUE">不重复索引(UNIQUE)</option>
				          		<option value="FULLTEXT">全文索引(FULLTEXT)</option>
				          	</select>
						</div>
			        </div>
			        <div class="control-group">
				        <label class="control-label">禁止修改：</label>
			          	<div class="controls">
							<label class="checkbox inline">
				          		<input type="checkbox" class="input-text" name="args[fieldforbidactors][]" value="-1"/> 本用户
				          	</label>
				          	{x2;tree:$groups,group,gid}
				          	{x2;if:v:group['groupmoduleid'] == 1}
				          	<label class="checkbox inline">
				          		<input type="checkbox" class="input-text" name="args[fieldforbidactors][]" value="{x2;v:group['groupid']}"/> {x2;v:group['groupname']}
				          	</label>
				          	{x2;endif}
				          	{x2;endtree}
						</div>
			        </div>
			        <div class="control-group">
				        <label class="control-label">系统字段：</label>
			          	<div class="controls">
							<label class="radio inline">
				          		<input type="radio" class="input-text" name="args[fieldsystem]" value="1"/> 作为系统字段
				          	</label>
				          	<label class="radio inline">
				          		<input type="radio" class="input-text" name="args[fieldsystem]" value="0" checked/> 作为普通字段
				          	</label>
				          	<span class="help-block">系统字段不能被删除</span>
				       </div>
				    </div>
			        <div class="control-group">
				        <label for="fielddescribe" class="control-label">字段描述：</label>
				        <div class="controls">
							<textarea class="input-xxlarge" rows="7" cols="4" name="args[fielddescribe]" id="fielddescribe"></textarea>
			        	</div>
			        </div>
			        <div class="control-group">
			            <div class="controls">
				            <button class="btn btn-primary" type="submit">提交</button>
				            <input type="hidden" name="submit" value="1">
				            <input type="hidden" name="page" value="{x2;$page}">
				            <input type="hidden" name="insertfield" value="1"/>
							<input type="hidden" name="args[fieldmoduleid]" value="{x2;$moduleid}"/>
							<input type="hidden" name="args[fieldpublic]" value="{x2;$fieldpublic}"/>
						</div>
			        </div>
				</fieldset>
			</form>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}