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
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-basic&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">考场管理</a> <span class="divider">/</span></li>
				<li class="active">考试范围</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">考试范围</a>
				</li>
				<li class="dropdown pull-right">
					<a href="index.php?exam-master-basic&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">考场管理</a>
				</li>
			</ul>
	        <form action="?exam-master-basic-setexamrange" method="post" class="form-horizontal">
				<table class="table">
					<thead>
					<tr>
						<th colspan="8"><?php echo $this->tpl_var['basic']['basic'];?></th>
					</tr>
					</thead>
					<tr>
						<td>
							考场ID：
						</td>
						<td>
							<?php echo $this->tpl_var['basic']['basicid'];?>
						</td>
						<td>
							科目：
						</td>
						<td>
							<?php echo $this->tpl_var['subjects'][$this->tpl_var['basic']['basicsubjectid']]['subject'];?>
						</td>
						<td>
							地区：
						</td>
			        	<td>
			        		<?php echo $this->tpl_var['areas'][$this->tpl_var['basic']['basicareaid']]['area'];?>
			        	</td>
			        	<td>
							API标识：
						</td>
						<td>
							<?php echo $this->tpl_var['basic']['basicapi'];?>
						</td>
					</tr>
				</table>
				<div class="control-group">
					<label class="control-label">章节选择：<input type="checkbox" onclick="javascript:$('.section:checkbox').prop('checked',$(this).is(':checked'));"> </label>
				</div>
				<?php $sid = 0; foreach($this->tpl_var['sections'] as $key => $section){  $sid++; ?>
				<div class="control-group">
					<label class="control-label">
				        <label class="checkbox inline"><input type="checkbox" onclick="javascript:$('.sec_<?php echo $section['sectionid'];?>:checkbox').prop('checked',$(this).is(':checked'));"> <?php echo $section['section'];?></label>
				    </label>
				    <div class="controls" style="text-indent:10px;">
				    	<?php $kid = 0; foreach($this->tpl_var['knows'][$section['sectionid']] as $key => $know){  $kid++; ?>
				    	<label class="checkbox inline"><input type="checkbox" value="<?php echo $know['knowsid'];?>" name="args[basicknows][<?php echo $section['sectionid'];?>][<?php echo $know['knowsid'];?>]" class="section sec_<?php echo $section['sectionid'];?>" <?php if($this->tpl_var['basic']['basicknows'][$section['sectionid']][$know['knowsid']] == $know['knowsid']){?>checked<?php } ?>/><?php echo $know['knows'];?></label>
				    	<?php } ?>
				    </div>
				</div>
				<?php } ?>
				<div class="control-group">
					<label for="basicexam_auto" class="control-label">考场模式：</label>
					<div class="controls">
						<label class="radio inline">
				          		<input type="radio" class="input-text" name="args[basicexam][model]" value="0"<?php if($this->tpl_var['basic']['basicexam']['model'] == 0){?> checked<?php } ?>/> 全功能模式（练习和考前押题均开放）
			          	</label>
			          	<label class="radio inline">
			          		<input type="radio" class="input-text" name="args[basicexam][model]" value="1"<?php if($this->tpl_var['basic']['basicexam']['model'] == 1){?> checked<?php } ?>/> 练习模式（仅练习功能开放）
			          	</label>
			          	<label class="radio inline">
			          		<input type="radio" class="input-text" name="args[basicexam][model]" value="2"<?php if($this->tpl_var['basic']['basicexam']['model'] == 2){?> checked<?php } ?>/> 考试模式（仅考前押题开放）
			          	</label>
					</div>
				</div>
				<div class="control-group">
					<label for="basicexam_auto" class="control-label">考前押题试题排序：</label>
					<div class="controls">
						<label class="radio inline">
				          	<input type="radio" class="input-text" name="args[basicexam][changesequence]" value="0"<?php if($this->tpl_var['basic']['basicexam']['changesequence'] == 0){?> checked<?php } ?>/> 不打乱试题排序
			          	</label>
			          	<label class="radio inline">
			          		<input type="radio" class="input-text" name="args[basicexam][changesequence]" value="1"<?php if($this->tpl_var['basic']['basicexam']['changesequence'] == 1){?> checked<?php } ?>/> 打乱试题排序
			          	</label>
					</div>
				</div>
				<div class="control-group">
					<label for="basicexam_auto" class="control-label">绑定历年真题及模拟试卷：</label>
					<div class="controls">
						<input type="text" id="basicexam_auto" name="args[basicexam][auto]" needle="needle" msg="您必须填写至少一个试卷" value="<?php echo $this->tpl_var['basic']['basicexam']['auto'];?>" /> <a class="selfmodal btn" href="javascript:;" data-target="#modal" url="index.php?exam-master-exams-selectexams&search[subjectid]=<?php echo $this->tpl_var['basic']['basicsubjectid'];?>&exams={basicexam_auto}&useframe=1&target=basicexam_auto" valuefrom="basicexam_auto">选卷</a>
						<span class="help-block">请在试卷管理处查看试卷ID，将数字ID填写在这里，多个请用英文逗号（,）隔开。留空或填0时将无法进行该项考试。</span>
					</div>
				</div>
				<div class="control-group">
					<label for="basicexam_autotemplate" class="control-label">历年真题及模拟模板：</label>
					<div class="controls">
						<select id="basicexam_autotemplate" name="args[basicexam][autotemplate]">
							<?php $tid = 0; foreach($this->tpl_var['tpls']['ep'] as $key => $tpl){  $tid++; ?>
			            	<option value="<?php echo $tpl;?>"<?php if($this->tpl_var['basic']['basicexam']['autotemplate'] == $tpl){?> selected<?php } ?>><?php echo $tpl;?></option>
			            	<?php } ?>
		            	</select>
					</div>
				</div>
				<div class="control-group">
					<label for="basicexam_self" class="control-label">绑定考前押题试卷：</label>
					<div class="controls">
						<input type="text" id="basicexam_self" name="args[basicexam][self]" needle="needle" msg="您必须填写至少一个试卷" value="<?php echo $this->tpl_var['basic']['basicexam']['self'];?>" /> <a class="selfmodal btn" href="javascript:;" data-target="#modal" url="index.php?exam-master-exams-selectexams&search[subjectid]=<?php echo $this->tpl_var['basic']['basicsubjectid'];?>&exams={basicexam_self}&useframe=1&target=basicexam_self" valuefrom="basicexam_self">选卷</a>
						<span class="help-block">请在试卷管理处查看试卷ID，将数字ID填写在这里，多个请用英文逗号（,）隔开。留空或填0时将无法进行该项考试。</span>
					</div>
				</div>
				<div class="control-group">
					<label for="basicexam_selftemplate" class="control-label">考前押题试卷模板：</label>
					<div class="controls">
						<select id="basicexam_selftemplate" name="args[basicexam][selftemplate]">
			            	<?php $tid = 0; foreach($this->tpl_var['tpls']['pp'] as $key => $tpl){  $tid++; ?>
			            	<option value="<?php echo $tpl;?>"<?php if($this->tpl_var['basic']['basicexam']['selftemplate'] == $tpl){?> selected<?php } ?>><?php echo $tpl;?></option>
			            	<?php } ?>
			            </select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">考前押题开启时间：</label>
					<div class="controls">
						<input name="args[basicexam][opentime][start]" type="text" value="<?php if($this->tpl_var['basic']['basicexam']['opentime']['start']){?><?php echo date('Y-m-d H:i:s',$basic['basicexam']['opentime']['start']); ?><?php } else { ?>0<?php } ?>" needle="needle" msg="您必须输入一个开启时间起点" /> - <input name="args[basicexam][opentime][end]" type="text" value="<?php if($this->tpl_var['basic']['basicexam']['opentime']['end']){?><?php echo date('Y-m-d H:i:s',$basic['basicexam']['opentime']['end']); ?><?php } else { ?>0<?php } ?>" needle="needle" msg="您必须输入一个开启时间终点" />
						<span class="help-block">开始结束时间均需填写，格式为2014-05-01 08:00:00，不限制开启时间请任意一项填写0。如果设置的结束时间减去5分钟比考生交卷时间要早，则系统按照结束时间减去5分钟收卷。</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">考前押题抽卷规则：</label>
					<div class="controls">
						<label class="radio inline">
			          		<input type="radio" class="input-text" name="args[basicexam][selectrule]" value="1"<?php if($this->tpl_var['basic']['basicexam']['selectrule']){?> checked<?php } ?>/> 系统随机抽卷
			          	</label>
			          	<label class="checkbox inline">
			          		<input type="radio" class="input-text" name="args[basicexam][selectrule]" value="0"<?php if(!$this->tpl_var['basic']['basicexam']['selectrule']){?> checked<?php } ?>/> 用户手动选卷
			          	</label>
						<span class="help-block">系统随机抽卷时，用户无法看到试卷列表，系统会随机挑选试卷供用户考试。手选试卷时，系统列出试卷列表供用户选择进行考试。</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">考前押题限考次数：</label>
					<div class="controls">
						<input name="args[basicexam][examnumber]" type="text" value="<?php if($this->tpl_var['basic']['basicexam']['examnumber']){?><?php echo $this->tpl_var['basic']['basicexam']['examnumber'];?><?php } else { ?>0<?php } ?>" needle="needle" msg="您必须输入考试次数" />
						<span class="help-block">不限制次数请填写0，当您选择抽卷规则为系统随机抽卷时，限考次数为所有试卷限考次数，当您选择抽卷规则为用户自选时，限考次数为每套试卷限考次数。即如果设置限考次数为x，当随机抽卷时，用户一共可以考试x次；手选试卷时，用户每套试卷可考试x次。</span>
					</div>
				</div>
				<div class="control-group">
					<label for="basicexam_auto" class="control-label">交卷后：</label>
					<div class="controls">
						<label class="radio inline">
				          		<input type="radio" class="input-text" name="args[basicexam][notviewscore]" value="0"<?php if($this->tpl_var['basic']['basicexam']['notviewscore'] == 0){?> checked<?php } ?>/> 直接显示分数
			          	</label>
			          	<label class="radio inline">
			          		<input type="radio" class="input-text" name="args[basicexam][notviewscore]" value="1"<?php if($this->tpl_var['basic']['basicexam']['notviewscore'] == 1){?> checked<?php } ?>/> 暂不显示分数
			          	</label>
					</div>
				</div>
				<div class="submit">
					<div class="controls">
						<button class="btn btn-primary" type="submit">提交</button>
						<input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>"/>
						<input type="hidden" name="setexamrange" value="1"/>
						<input type="hidden" name="basicid" value="<?php echo $this->tpl_var['basic']['basicid'];?>"/>
						<?php $aid = 0; foreach($this->tpl_var['search'] as $key => $arg){  $aid++; ?>
						<input type="hidden" name="search[<?php echo $key;?>]" value="<?php echo $arg;?>"/>
						<?php } ?>
					</div>
				</div>
			</form>
<?php if(!$this->tpl_var['userhash']){?>
		</div>
	</div>
</div>
<div aria-hidden="true" id="modal" class="modal hide fade" role="dialog" aria-labelledby="#myModalLabel">
	<div class="modal-header">
		<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
		<h3 id="myModalLabel">
			试卷列表
		</h3>
	</div>
	<div class="modal-body" id="modal-body">asdasdasdasdsa</div>
	<div class="modal-footer">
		 <button aria-hidden="true" class="btn" data-dismiss="modal">完成</button>
	</div>
</div>
</body>
</html>
<?php } ?>