<?php if(!$this->tpl_var['userhash']){?>
<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
<?php } ?>
			<div class="examform">
				<ul class="breadcrumb">
					<li>
						<span class="icon-home"></span> <a href="index.php?exam">考场选择</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-app-basics-open">开通考场</a> <span class="divider">/</span>
					</li>
					<li class="active">
						<?php echo $this->tpl_var['basic']['basic'];?>
					</li>
				</ul>
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#" data-toggle="tab">开通考场</a>
					</li>
				</ul>
				<div class="row-fluid">
					<div class="span1"></div>
					<div class="span3">
						<div class="thumbnail"><img alt="300x200" src="<?php if($this->tpl_var['basic']['basicthumb']){?><?php echo $this->tpl_var['basic']['basicthumb'];?><?php } else { ?>app/exam/styles/image/paper.png<?php } ?>" /></div>
					</div>
					<div class="span1"></div>
					<div class="span7">
						<div class="caption">
							<h3><?php echo $this->tpl_var['basic']['basic'];?></h3>
							<p>&nbsp;</p>
							<p>科目：<?php echo $this->tpl_var['subjects'][$this->tpl_var['basic']['basicsubjectid']]['subject'];?></p>
							<p>地区：<?php echo $this->tpl_var['areas'][$this->tpl_var['basic']['basicareaid']]['area'];?></p>
							<p>您现有积分：<?php echo $this->tpl_var['_user']['usercoin'];?> （<a href="index.php?user-center-payfor">支付宝充值</a> / <a href="#myModal" role="button" data-toggle="modal">代金券充值</a>）</p>
							<?php if($this->tpl_var['isopen']){?><p>到期时间：<?php echo date('Y-m-d',$isopen['obendtime']); ?></p><?php } ?>
						</div>
						<div>&nbsp;</div>
						<?php if(!$this->tpl_var['isopen']){?>
						<form action="index.php?exam-app-basics-openit" method="post">
							<?php if(!$this->tpl_var['basic']['basicdemo']){?>
								<?php if($this->tpl_var['price']){?>
								<p>
									<select name="opentype" class="input-large">
										<?php $pid = 0; foreach($this->tpl_var['price'] as $key => $p){  $pid++; ?>
										<option value="<?php echo $key;?>"><?php echo $p['price'];?>积分兑换<?php echo $p['time'];?>天</option>
										<?php } ?>
									</select>
								</p>
								<p>
									<input value="<?php echo $this->tpl_var['basic']['basicid'];?>" name="basicid" type="hidden"/>
									<input class="btn btn-primary" value="开通" type="submit"/>
								</p>
								<?php } else { ?>
								<p>
									<input class="btn" value="请管理员先在后台设置价格" type="button"/>
								</p>
								<?php } ?>
							<?php } else { ?>
							<p>
								<input value="<?php echo $this->tpl_var['basic']['basicid'];?>" name="basicid" type="hidden"/>
								<input class="btn btn-primary" value="开通" type="submit"/>
							</p>
							<?php } ?>
						</form>
						<?php } else { ?>
						<p>
							<a class="btn ajax" href="index.php?exam-app-index-setCurrentBasic&basicid=<?php echo $this->tpl_var['basic']['basicid'];?>">进入考场</a>
						</p>
						<?php } ?>
					</div>
				</div>
				<div class="pagination pagination-right">
					<ul><?php echo $this->tpl_var['basics']['pages'];?></ul>
		        </div>
			</div>
<?php if(!$this->tpl_var['userhash']){?>
		</div>
	</div>
</div>
<form aria-hidden="true" id="myModal" method="post" class="modal hide fade" role="dialog" aria-labelledby="#myModalLabel" action="index.php?exam-app-basics-coupon">
	<div class="modal-header">
		<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
		<h3 id="myModalLabel">
			代金券充值
		</h3>
	</div>
	<div class="modal-body" id="modal-body">
		<div class="control-group">
			<label class="control-label" for="content">代金券号码：</label>
	  		<div class="controls">
	  			<input type="text" name="couponsn" value="" needle="needle" msg="请输入16位代金券号码"/>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		 <input name="coupon" type="hidden" value="1">
		 <button class="btn" type="submit">充值</button>
	</div>
</form>
<?php $this->_compileInclude('foot'); ?>
</body>
</html>
<?php } ?>