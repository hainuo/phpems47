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
				<li class="active">编辑{x2;if:$fieldpublic}公共{x2;else}模型{x2;endif}字段</li>
			</ul>
			<div id="tabs-694325" class="tabbable">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#panel-344373" data-toggle="tab">样式编辑</a>
					</li>
					<li>
						<a href="#panel-788842" data-toggle="tab">数据编辑</a>
					</li>
					<li class="pull-right">
						<a href="index.php?{x2;$_app}-master-module-fields&moduleid={x2;$module['moduleid']}">字段列表</a>
					</li>
				</ul>
				<div class="tab-content">
					<div id="panel-344373" class="tab-pane active">
						<form action="index.php?{x2;$_app}-master-module-modifyfield" method="post" class="form-horizontal">
							<fieldset>
								<legend>{x2;$field['field']}</legend>
								<div class="control-group">
									<label class="control-label">字段别名：</label>
									<div class="controls">
										<input type="text" size="40" name="args[fieldtitle]" needle="needle" datatype="userName" id="fieldtitle" msg="您必须填写字段别名，字段别名必须为中英文字符或数字" value="{x2;$field['fieldtitle']}"/>
									</div>
								</div>
								<div class="control-group">
									<label for="fieldhtmltype" class="control-label">HTML类型：</label>
									<div class="controls">
										<select class="fselect" name="args[fieldhtmltype]" id="fieldhtmltype">
									  		<option value="text"{x2;if:$field['fieldhtmltype'] == 'text'} selected{x2;endif}>文本域(text)</option>
									  		<option value="htmltime"{x2;if:$field['fieldhtmltype'] == 'htmltime'} selected{x2;endif}>时间文本域(htmltime)</option>
									  		<option value="password"{x2;if:$field['fieldhtmltype'] == 'password'} selected{x2;endif}>密码域(password)</option>
									  		<option value="hidden"{x2;if:$field['fieldhtmltype'] == 'hidden'} selected{x2;endif}>隐藏域(hidden)</option>
									  		<option value="select"{x2;if:$field['fieldhtmltype'] == 'select'} selected{x2;endif}>下拉菜单/选择框(select)</option>
									  		<option value="radio"{x2;if:$field['fieldhtmltype'] == 'radio'} selected{x2;endif}>单选框(radio)</option>
									  		<option value="checkbox"{x2;if:$field['fieldhtmltype'] == 'checkbox'} selected{x2;endif}>复选框(checkbox)</option>
									  		<option value="checkboxarray"{x2;if:$field['fieldhtmltype'] == 'checkboxarray'} selected{x2;endif}>复选框组(checkboxarray)</option>
									  		<option value="textarea"{x2;if:$field['fieldhtmltype'] == 'textarea'} selected{x2;endif}>文本区域(textarea)</option>
									  		<option value="editor"{x2;if:$field['fieldhtmltype'] == 'editor'} selected{x2;endif}>编辑器(editor)</option>
									  		<option value="thumb"{x2;if:$field['fieldhtmltype'] == 'thumb'} selected{x2;endif}>缩略图上传(thumb)</option>
									  		<option value="picture"{x2;if:$field['fieldhtmltype'] == 'picture'} selected{x2;endif}>组图上传(picture)</option>
									  		<option value="auto"{x2;if:$field['fieldhtmltype'] == 'auto'} selected{x2;endif}>自定义(auto)</option>
									  	</select>
								  	</div>
								</div>
								<div class="control-group">
						        	<label class="control-label">HTML属性：</label>
		      						<div class="controls">
			      						<textarea class="input-xxlarge" rows="7" cols="4" name="args[fieldhtmlproperty]" id="fieldhtmlproperty">{x2;$field['fieldhtmlproperty']}</textarea>
										<span class="help-block">每行一个，等号隔开，如：style=width:100px;</span>
									</div>
						        </div>
						        <div class="control-group">
							        <label class="control-label">可选值列表：</label>
							        <div class="controls">
								        <textarea class="input-xxlarge" rows="7" cols="4" name="args[fieldvalues]" id="fieldvalues">{x2;$field['fieldvalues']}</textarea>
								        <span class="help-block">每行一个，等号隔开，如：属性=值;</span>
							        </div>
						        </div>
						        <div class="control-group">
							        <label class="control-label">默认值：</label>
							        <div class="controls">
							        	<input type="text" size="40" name="args[fielddefault]" class="input-text" id="fielddefault" value="{x2;$field['fielddefault']}"/>
						        	</div>
						        </div>
						        <div class="control-group">
							        <label class="control-label">禁止修改：</label>
						          	<div class="controls">
							          	<label class="checkbox inline">
							          		<input type="checkbox" name="args[fieldforbidactors][]" value="-1" {x2;if:strpos($field['fieldforbidactors'],',-1,') !== false}checked="true"{x2;endif}/> 本用户
							          	</label>
							          	{x2;tree:$groups,group,gid}
							          	{x2;if:v:group['groupmoduleid'] == 1}
							          	<label class="checkbox inline">
							          		<input type="checkbox" name="args[fieldforbidactors][]" value="{x2;v:group['groupid']}" {x2;if:strpos($field['fieldforbidactors'],','.v:group['groupid'].',') !== false}checked="true"{x2;endif}/> {x2;v:group['groupname']}
							          	</label>
							          	{x2;endif}
							          	{x2;endtree}
						          	</div>
						        </div>
						        <div class="control-group">
							        <label class="control-label">字段描述：</label>
							        <div class="controls">
							        	<textarea class="input-xxlarge" rows="7" cols="4" name="args[fielddescribe]" id="fielddescribe">{x2;$field['fielddescribe']}</textarea>
						        	</div>
						        </div>
						        <div class="control-group">
							        <label class="control-label">系统字段：</label>
						          	<div class="controls">
										<label class="radio inline">
							          		<input type="radio" class="input-text" name="args[fieldsystem]" value="1"{x2;if:$field['fieldsystem']} checked{x2;endif}/> 作为系统字段
							          	</label>
							          	<label class="radio inline">
							          		<input type="radio" class="input-text" name="args[fieldsystem]" value="0"{x2;if:!$field['fieldsystem']} checked{x2;endif}/> 作为普通字段
							          	</label>
							          	<span class="help-block">系统字段不能被删除</span>
							       </div>
							    </div>
						        <div class="control-group">
						            <div class="controls">
							            <button class="btn btn-primary" type="submit">提交</button>
							            <input type="hidden" name="moduleid" value="{x2;$field['fieldmoduleid']}"/>
							            <input type="hidden" name="fieldid" value="{x2;$fieldid}"/>
							            <input type="hidden" name="modifyfieldhtml" value="1"/>
						            </div>
						        </div>
							</fieldset>
						</form>
					</div>
					<div id="panel-788842" class="tab-pane">
						<form action="index.php?{x2;$_app}-master-module-modifyfield" method="post" class="form-horizontal">
							<fieldset>
								<legend>{x2;$field['field']}</legend>
								<div class="control-group">
							        <label class="control-label">字段类型：</label>
									<div class="controls">
										<select id="fieldtype" name="args[fieldtype]">
											<option value="int"{x2;if:$field['fieldtype'] == 'int'} selected{x2;endif}>整型(int/time)</option>
											<option value="varchar"{x2;if:$field['fieldtype'] == 'varchar'} selected{x2;endif}>0~255字符串型(varchar)</option>
											<option value="decimal"{x2;if:$field['fieldtype'] == 'decimal'} selected{x2;endif}>浮点型(decimal)</option>
											<option value="text"{x2;if:$field['fieldtype'] == 'text'} selected{x2;endif}>长文字型(text)</option>
										</select>
									</div>
								</div>
								<div class="control-group">
							        <label class="control-label">字段长度：</label>
									<div class="controls">
										<input type="text" size="16" name="args[fieldlength]" class="input-text" id="fieldlength" value="{x2;$field['fieldlength']}"/>
									</div>
								</div>
								<div class="control-group">
							        <label class="control-label">索引类型：</label>
									<div class="controls">
										<select class="fselect" name="args[fieldindextype]" id="fieldindextype">
									  		<option value="0">无(NULL)</option>
									  		<option value="INDEX"{x2;if:$field['fieldindextype'] == 'INDEX'} selected{x2;endif}>普通索引(INDEX)</option>
									  		<option value="UNIQUE"{x2;if:$field['fieldindextype'] == 'UNIQUE'} selected{x2;endif}>不重复索引(UNIQUE)</option>
									  		<option value="FULLTEXT"{x2;if:$field['fieldindextype'] == 'FULLTEXT'} selected{x2;endif}>全文索引(FULLTEXT)</option>
									  	</select>
								  	</div>
								</div>
								<div class="control-group">
									<div class="controls">
										<button class="btn btn-primary" type="submit">提交</button>
							            <input type="hidden" name="moduleid" value="{x2;$field['fieldmoduleid']}"/>
							            <input type="hidden" name="fieldid" value="{x2;$fieldid}"/>
							            <input type="hidden" name="modifyfielddata" value="1"/>
						            </div>
						        </div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}