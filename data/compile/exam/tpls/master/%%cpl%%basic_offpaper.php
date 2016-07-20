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
				<li class="active">考试调度</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">考试调度</a>
				</li>
			</ul>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>SessionId</th>
						<th>用户名</th>
						<th>真实姓名</th>
						<th>试卷名</th>
						<th>开考时间</th>
						<th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                    <?php $uid = 0; foreach($this->tpl_var['sessionusers']['data'] as $key => $user){  $uid++; ?>
					<tr>
						<td><?php echo $user['examsessionid'];?></td>
						<td><?php echo $user['username'];?></td>
						<td><?php echo $user['usertruename'];?></td>
						<td><?php echo $user['examsessionsetting']['exam'];?></td>
						<td><?php echo date('m-d H:i',$user['examsessionstarttime']); ?></td>
						<td>
							<div class="btn-group">
								<!--
								<a class="btn" href="index.php?exam-master-basic-modifysubject&subjectid=<?php echo $subject['subjectid'];?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="修改模型信息"><em class="icon-edit"></em></a>
								-->
								<a class="btn confirm" msg="确定要强行收卷？" href="index.php?exam-master-basic-savepaper&examsessionid=<?php echo $user['examsessionid'];?>" title="强行收卷"><em class="icon-remove"></em></a>
							</div>
						</td>
					</tr>
					<?php } ?>
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
	            <ul><?php echo $this->tpl_var['sessionusers']['pages'];?></ul>
	        </div>
<?php if(!$this->tpl_var['userhash']){?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>