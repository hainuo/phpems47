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
				<li class="active">科目管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">科目管理</a>
				</li>
				<li class="dropdown pull-right">
					<a href="index.php?exam-master-basic-addsubject">添加科目</a>
				</li>
			</ul>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>科目ID</th>
						<th>科目名称</th>
						<th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                    <?php $sid = 0; foreach($this->tpl_var['subjects'] as $key => $subject){  $sid++; ?>
					<tr>
						<td><?php echo $subject['subjectid'];?></td>
						<td><?php echo $subject['subject'];?></td>
						<td>
							<div class="btn-group">
								<a class="btn ajax" href="index.php?exam-master-basic-output&subjectid=<?php echo $subject['subjectid'];?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="导出题库"><em class="icon-download-alt"></em></a>
								<!--
								<a class="btn ajax" href="index.php?exam-master-basic-outputknows&subjectid=<?php echo $subject['subjectid'];?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="导出知识点"><em class="icon-download-alt"></em></a>
								-->
								<a class="btn" href="index.php?exam-master-basic-section&subjectid=<?php echo $subject['subjectid'];?>&page=1&basicid=<?php echo $basic['basicid'];?><?php echo $this->tpl_var['u']; ?>" title="章节列表"><em class="icon-th-list"></em></a>
								<a class="btn" href="index.php?exam-master-basic-modifysubject&subjectid=<?php echo $subject['subjectid'];?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="修改科目信息"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?exam-master-basic-delsubject&subjectid=<?php echo $subject['subjectid'];?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="删除科目"><em class="icon-remove"></em></a>
							</div>
						</td>
					</tr>
					<?php } ?>
	        	</tbody>
	        </table>
<?php if(!$this->tpl_var['userhash']){?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>