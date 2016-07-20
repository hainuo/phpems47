<?php if(!$this->tpl_var['userhash']){?>
<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			<?php $this->_compileInclude('menu'); ?>
		</div>
		<div class="span10" id="datacontent">
<?php } ?>
			<ul class="breadcrumb">
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master"><?php echo $this->tpl_var['apps'][$this->tpl_var['_app']]['appname'];?></a> <span class="divider">/</span></li>
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-exams&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">试卷管理</a> <span class="divider">/</span></li>
				<li class="active">即时组卷</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">即时组卷</a>
				</li>
				<li class="pull-right">
					<a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-exams&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">试卷管理</a>
				</li>
			</ul>
	        <form action="index.php?exam-master-exams-modify" method="post" class="form-horizontal">
				<div class="control-group">
					<label class="control-label">试卷名称：</label>
					<div class="controls">
			  			<input type="text" name="args[exam]" value="<?php echo $this->tpl_var['exam']['exam'];?>" needle="needle" msg="您必须为该试卷输入一个名称"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">评卷方式</label>
					<div class="controls">
						<label class="radio inline">
							<input name="args[examdecide]" type="radio" value="1"<?php if($this->tpl_var['exam']['examdecide']){?> checked<?php } ?>/>教师评卷
						</label>
						<label class="radio inline">
							<input name="args[examdecide]" type="radio" value="0"<?php if(!$this->tpl_var['exam']['examdecide']){?> checked<?php } ?>/>学生自评
						</label>
						<span class="help-block">教师评卷时有主观题则需要教师在后台评分后才能显示分数，无主观题自动显示分数。</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">考试科目：</label>
				  	<div class="controls">
					  	<label class="radio inline">
						  	<input type="hidden" name="args[examsubject]" value="<?php echo $this->tpl_var['exam']['examsubject'];?>" />
						  	<?php echo $this->tpl_var['subjects'][$this->tpl_var['exam']['examsubject']]['subject'];?>
					  	</label>
			  		</div>
				</div>
				<div class="control-group">
					<label class="control-label">考试时间：</label>
			  		<div class="controls">
			  			<input type="text" name="args[examsetting][examtime]" size="4" needle="needle" class="inline" value="<?php echo $this->tpl_var['exam']['examsetting']['examtime'];?>"/> 分钟
			  		</div>
				</div>
				<div class="control-group">
					<label class="control-label">考试时间：</label>
			  		<div class="controls">
			  			<input type="text" name="args[examsetting][examtime]" value="<?php echo $this->tpl_var['exam']['examsetting']['examtime'];?>" size="4" needle="needle" class="inline"/> 分钟
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">来源：</label>
			  		<div class="controls">
			  			<input type="text" name="args[examsetting][comfrom]" value="<?php echo $this->tpl_var['exam']['examsetting']['comfrom'];?>" size="4"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">试卷总分：</label>
			  		<div class="controls">
			  			<input type="text" name="args[examsetting][score]" value="<?php echo $this->tpl_var['exam']['examsetting']['score'];?>" size="4" needle="needle" msg="你要为本考卷设置总分" datatype="number"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">及格线：</label>
			  		<div class="controls">
			  			<input type="text" name="args[examsetting][passscore]" value="<?php echo $this->tpl_var['exam']['examsetting']['passscore'];?>" size="4" needle="needle" msg="你要为本考卷设置一个及格分数线" datatype="number"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">题型排序</label>
					<div class="controls">
						<div class="sortable btn-group">
							<?php if($this->tpl_var['exam']['examsetting']['questypelite']){?>
							<?php $eqid = 0; foreach($this->tpl_var['exam']['examsetting']['questypelite'] as $key => $qlid){  $eqid++; ?>
							<a class="btn questpanel panel_<?php echo $key;?>"><?php echo $this->tpl_var['questypes'][$key]['questype'];?><input type="hidden" name="args[examsetting][questypelite][<?php echo $key;?>]" value="1" class="questypepanelinput" id="panel_<?php echo $key;?>"/></a>
							<?php } ?>
							<?php } else { ?>
							<?php $qid = 0; foreach($this->tpl_var['questypes'] as $key => $questype){  $qid++; ?>
							<a class="btn questpanel panel_<?php echo $questype['questid'];?>"><?php echo $questype['questype'];?><input type="hidden" name="args[examsetting][questypelite][<?php echo $questype['questid'];?>]" value="1" class="questypepanelinput" id="panel_<?php echo $questype['questid'];?>"/></a>
							<?php } ?>
							<?php } ?>
						</div>
						<span class="help-block">拖拽进行题型排序</span>
					</div>
				</div>
				<?php $qid = 0; foreach($this->tpl_var['questypes'] as $key => $questype){  $qid++; ?>
				<div class="control-group questpanel panel_<?php echo $questype['questid'];?>">
					<label class="control-label"><?php echo $questype['questype'];?>：</label>
					<div class="controls">
						<span class="info">共&nbsp;</span>
						<input id="iselectallnumber_<?php echo $questype['questid'];?>" type="text" class="input-mini" needle="needle" name="args[examsetting][questype][<?php echo $questype['questid'];?>][number]" value=" <?php  echo intval($exam['examsetting']['questype'][$questype['questid']]['number']); ?>" size="2" msg="您必须填写总题数"/>
						<span class="info">&nbsp;题，每题&nbsp;</span><input class="input-mini" needle="needle" type="text" name="args[examsetting][questype][<?php echo $questype['questid'];?>][score]" value=" <?php  echo floatval($exam['examsetting']['questype'][$questype['questid']]['score']); ?>" size="2" msg="您必须填写每题的分值"/>
						<span class="info">&nbsp;分，描述&nbsp;</span><input class="input-large" type="text" name="args[examsetting][questype][<?php echo $questype['questid'];?>][describe]" value="<?php echo $this->tpl_var['exam']['examsetting']['questype'][$questype['questid']]['describe'];?>" size="12"/>
					</div>
				</div>
				<?php } ?>
				<div class="control-group">
					<label for="username" class="control-label">示范格式</label>
					<div class="controls">
						<img src="app/exam/styles/image/demo2.png" />
					</div>
				</div>
				<div class="control-group">
					<label for="lesson_video" class="control-label">待导入文件</label>
					<div class="controls">
						<span class="input-append">
							<input type="text" name="uploadfile" id="uploadfile_value" class="inline uploadvideo" msg="必须先上传CSV文件"/>
							<span id="uploadfile_percent" class="add-on">0.00%</span>
						</span>
						<span class="btn">
							<a id="uploadfile" class="uploadbutton" exectype="upfile" uptypes="*.csv">选择文件</a>
						</span>
						<span class="help-block">注意：导入文件必须为csv文件，可用excel另存为csv，为保证程序正常导入，每个CSV文件请不要超过2M，否则可能导入失败</span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
					  	<button class="btn btn-primary" type="submit">提交</button>
						<input type="hidden" name="submitsetting" value="1"/>
						<input name="examid" type="hidden" value="<?php echo $this->tpl_var['exam']['examid'];?>">
					</div>
				</div>
			</form>
			<div aria-hidden="true" id="modal" class="modal hide fade" role="dialog" aria-labelledby="#myModalLabel">
				<div class="modal-header">
					<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
					<h3 id="myModalLabel">
						试题列表
					</h3>
				</div>
				<div class="modal-body" id="modal-body">asdasdasdasdsa</div>
				<div class="modal-footer">
					 <button aria-hidden="true" class="btn" data-dismiss="modal">完成</button>
				</div>
			</div>
<?php if(!$this->tpl_var['userhash']){?>
		</div>
	</div>
</div>
<script>
$.getJSON('index.php?exam-master-basic-getsubjectquestype&subjectid=<?php echo $this->tpl_var['exam']['examsubject'];?>&'+Math.random(),function(data){$('.questpanel').hide();$('.questypepanelinput').val('0');for(x in data){$('.panel_'+data[x]).show();$('#panel_'+data[x]).val('1');}});
</script>
</body>
</html>
<?php } ?>