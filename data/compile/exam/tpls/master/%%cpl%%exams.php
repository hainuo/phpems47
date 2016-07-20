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
				<li class="active">试卷管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">试卷管理</a>
				</li>
				<li class="dropdown pull-right">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">添加试卷<strong class="caret"></strong></a>
					<ul class="dropdown-menu">
						<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-exams-autopage&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">随机组卷</a></li>
						<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-exams-selfpage&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">手动组卷</a></li>
					</ul>
				</li>
			</ul>
	        <form action="index.php?exam-master-exams" method="post">
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
							选择类型：
						</td>
						<td>
							<select name="search[examtype]">
								<option value="0">不限</option>
								<option value="1"<?php if($this->tpl_var['search']['examtype'] == 1){?> selected<?php } ?>>随机抽题</option>
								<option value="2"<?php if($this->tpl_var['search']['examtype'] == 2){?> selected<?php } ?>>手动抽题</option>
								<option value="3"<?php if($this->tpl_var['search']['examtype'] == 3){?> selected<?php } ?>>即时组卷</option>
							</select>
						</td>
						<td>
							选择科目：
						</td>
						<td>
							<select name="search[examsubject]">
								<option value="0">不限</option>
								<?php $sid = 0; foreach($this->tpl_var['subjects'] as $key => $subject){  $sid++; ?>
						  		<option value="<?php echo $subject['subjectid'];?>"<?php if($subject['subjectid'] == $this->tpl_var['search']['examsubject']){?> selected<?php } ?>><?php echo $subject['subject'];?></option>
						  		<?php } ?>
							</select>
						</td>
						<td>
							<button class="btn btn-primary" type="submit">搜索</button>
							<input type="hidden" value="1" name="search[argsmodel]" />
						</td>
					</tr>
				</table>
			</form>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>ID</th>
				        <th>考试名称</th>
				        <th>组卷人</th>
				        <th>组卷类型</th>
				        <th>组卷时间</th>
				        <th>考试科目</th>
				        <th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                    <?php $eid = 0; foreach($this->tpl_var['exams']['data'] as $key => $exam){  $eid++; ?>
			        <tr>
						<td>
							<?php echo $exam['examid'];?>
						</td>
						<td>
							<?php echo $exam['exam'];?>
						</td>
						<td>
							<?php echo $exam['examauthor'];?>
						</td>
						<td>
							<?php if($exam['examtype'] == 1){?>随机组卷<?php } elseif($exam['examtype'] == 2){?>手工组卷<?php } else { ?>即时组卷<?php } ?>
						</td>
						<td>
							<?php echo date('Y-m-d',$exam['examtime']); ?>
						</td>
						<td>
							<?php echo $this->tpl_var['subjects'][$exam['examsubject']]['subject'];?>
						</td>
						<td>
							<div class="btn-group">
	                    		<?php if($exam['examtype'] != 1){?>
	                    		<a class="btn" target="_blank" href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-exams-preview&examid=<?php echo $exam['examid'];?><?php echo $this->tpl_var['u']; ?>" title="查看试卷"><em class="icon-list-alt"></em></a>
	                    		<?php } ?>
	                    		<?php if($exam['examtype'] == 3){?>
	                    		<a class="btn ajax" href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-exams-outcsv&page=<?php echo $this->tpl_var['page']; ?>&examid=<?php echo $exam['examid'];?><?php echo $this->tpl_var['u']; ?>" title="下载csv"><em class="icon-download-alt"></em></a>
	                    		<?php } ?>
	                    		<a class="btn" href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-exams-modify&page=<?php echo $this->tpl_var['page']; ?>&examid=<?php echo $exam['examid'];?><?php echo $this->tpl_var['u']; ?>" title="修改"><em class="icon-edit"></em></a>
								<a class="btn confirm" href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-exams-del&page=<?php echo $this->tpl_var['page']; ?>&examid=<?php echo $exam['examid'];?><?php echo $this->tpl_var['u']; ?>" title="删除"><em class="icon-remove"></em></a>
	                    	</div>
						</td>
			        </tr>
			        <?php } ?>
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
	            <ul><?php echo $this->tpl_var['exams']['pages'];?></ul>
	        </div>
<?php if(!$this->tpl_var['userhash']){?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>