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
				<li class="active">分类管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">分类管理</a>
				</li>
				<li class="dropdown pull-right">
					<a href="index.php?exam-master-basic-addtype">添加分类</a>
				</li>
			</ul>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>分类ID</th>
						<th>分类名称</th>
						<th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                    <?php $sid = 0; foreach($this->tpl_var['types'] as $key => $type){  $sid++; ?>
					<tr>
						<td><?php echo $type['typeid'];?></td>
						<td><?php echo $type['type'];?></td>
						<td>
							<div class="btn-group">
								<a class="btn" href="index.php?exam-master-basic-modifytype&typeid=<?php echo $type['typeid'];?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="修改分类信息"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?exam-master-basic-deltype&typeid=<?php echo $type['typeid'];?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="删除分类"><em class="icon-remove"></em></a>
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