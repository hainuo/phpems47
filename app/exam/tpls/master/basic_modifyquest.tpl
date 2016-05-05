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
				<li><a href="index.php?{x2;$_app}-master-basic-questype">题型管理</a> <span class="divider">/</span></li>
				<li class="active">修改题型</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">修改题型</a>
				</li>
				<li class="pull-right">
					<a href="index.php?exam-master-basic-questype&page={x2;$page}{x2;$u}">题型管理</a>
				</li>
			</ul>
	        <form action="index.php?exam-master-basic-modifyquestype" method="post" class="form-horizontal">
				<fieldset>
				<div class="control-group">
					<label for="questype" class="control-label">题型名称：</label>
					<div class="controls">
						<input name="args[questype]" id="questype" type="text" size="30" value="{x2;$quest['questype']}" class="required" alt="请输入题型名称" />
					</div>
				</div>
				<!--
				<div class="control-group">
					<label for="questype" class="control-label">识别码：</label>
					<div class="controls">
						<input name="args[questchar]" id="questype" type="text" size="30" value="{x2;$quest['questchar']}" needle="needle" alt="请输入题型识别码" />
					</div>
				</div>
				-->
				<div class="control-group">
					<label for="questsort" class="control-label">题型分类：</label>
					<div class="controls">
						<select class="combox" id="questsort" name="args[questsort]" onchange="javascript:if($(this).val() == '1')$('#choicebox').hide();else $('#choicebox').show();">
							<option value="1"{x2;if:$quest['questsort']} selected{x2;endif}>主观题</option>
  							<option value="0"{x2;if:!$quest['questsort']} selected{x2;endif}>客观题</option>
						</select>
					</div>
				</div>
				<div id="choicebox" class="control-group"{x2;if:$quest['questsort']} style="display:none;"{x2;endif}>
					<label for="questchoice" class="control-label">选项分类：</label>
					<div class="controls">
						<select class="combox" name="args[questchoice]" id="questchoice">
							<option value="1"{x2;if:$quest['questchoice']==1} selected{x2;endif}>单选</option>
	  						<option value="2"{x2;if:$quest['questchoice']==2} selected{x2;endif}>多选</option>
	  						<option value="3"{x2;if:$quest['questchoice']==3} selected{x2;endif}>不定项选</option>
	  						<option value="4"{x2;if:$quest['questchoice']==4} selected{x2;endif}>判断</option>
	  						<option value="5"{x2;if:$quest['questchoice']==5} selected{x2;endif}>定值填空题</option>
						</select>
						<span class="help-block">不定项选按照选对答案数给分，判断题将自动生成判断选项。</span>
					</div>
				</div>
				<div class="control-group">
				  	<div class="controls">
					  	<button class="btn btn-primary" type="submit">提交</button>
					  	<input type="hidden" name="page" value="{x2;$page}"/>
					  	<input type="hidden" name="questid" value="{x2;$quest['questid']}"/>
						<input type="hidden" name="modifyquestype" value="1"/>
					  	{x2;tree:$search,arg,aid}
						<input type="hidden" name="search[{x2;v:key}]" value="{x2;v:arg}"/>
						{x2;endtree}
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