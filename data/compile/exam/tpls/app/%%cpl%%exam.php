<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<div class="examform">
				<ul class="breadcrumb">
					<li>
						<span class="icon-home"></span> <a href="index.php?exam">考场选择</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-app-basics"><?php echo $this->tpl_var['data']['currentbasic']['basic'];?></a> <span class="divider">/</span>
					</li>
					<li class="active">
						考前押题
					</li>
				</ul>
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#" data-toggle="tab">考前押题</a>
					</li>
				</ul>
				<div class="alert alert-info">
					<strong>提示：</strong>
					<p>本考场开启时间 <?php if($this->tpl_var['data']['currentbasic']['basicexam']['opentime']['start'] && $this->tpl_var['data']['currentbasic']['basicexam']['opentime']['end']){?><?php echo date('Y-m-d H:i:s',$data['currentbasic']['basicexam']['opentime']['start']); ?> - <?php echo date('Y-m-d H:i:s',$data['currentbasic']['basicexam']['opentime']['end']); ?><?php } else { ?>不限<?php } ?> ； 考试次数 <?php if($this->tpl_var['data']['currentbasic']['basicexam']['examnumber']){?><?php echo $this->tpl_var['data']['currentbasic']['basicexam']['examnumber'];?><?php } else { ?>不限<?php } ?> ； 抽卷规则 <?php if($this->tpl_var['data']['currentbasic']['basicexam']['selectrule']){?>系统随机抽卷<?php } else { ?>用户手选试卷<?php } ?>。</p>
				</div>
            	<ul class="unstyled">
                	<li><b>1、</b>点击考试名称按钮进入答题界面，考试开始计时。</li>
                	<li><b>2、</b>在随机考试过程中，您可以通过顶部的考试时间来掌握自己的做题时间。</li>
                	<li><b>3、</b>提交试卷后，可以通过“查看答案和解析”功能进行总结学习。</li>
                	<li><b>4、</b>系统自动记录历年真题及模拟的考试记录，学员考试结束后可以进入“答题记录”功能进行查看。</li>
                	<li>&nbsp;</li>
                </ul>
				<?php if($this->tpl_var['data']['currentbasic']['basicexam']['opentime']['start'] && $this->tpl_var['data']['currentbasic']['basicexam']['opentime']['end']){?>
					<?php if($this->tpl_var['data']['currentbasic']['basicexam']['opentime']['start'] <= TIME && $this->tpl_var['data']['currentbasic']['basicexam']['opentime']['end'] >= TIME){?>
						<?php if($this->tpl_var['data']['currentbasic']['basicexam']['selectrule']){?>
						<div>
							<div class="span4"></div>
							<?php if($this->tpl_var['data']['currentbasic']['basicexam']['examnumber'] > 0 && $this->tpl_var['number']['all'] >= $this->tpl_var['data']['currentbasic']['basicexam']['examnumber']){?>
							<div class="span4 text-center"><a class="btn" href="javascript:;">您的考试次数已经用完</a></div>
							<?php } else { ?>
							<div class="span4 text-center"><a class="ajax btn btn-primary" href="index.php?exam-app-exam-selectquestions&examid=<?php echo $exam['examid'];?>" action-before="clearStorage">开始考试</a></div>
							<?php } ?>
							<div class="span4"></div>
						</div>
						<?php } else { ?>
						<ul class="thumbnails">
							<?php $eid = 0; foreach($this->tpl_var['exams']['data'] as $key => $exam){  $eid++; ?>
							<li class="span2">
								<div class="thumbnail">
									<img src="app/core/styles/images/icons/Watches.png"/>
									<div class="caption">
										<p class="text-center">
											<?php if($this->tpl_var['data']['currentbasic']['basicexam']['examnumber'] > 0 && $this->tpl_var['number']['child'][$exam['examid']] >= $this->tpl_var['data']['currentbasic']['basicexam']['examnumber']){?>
											<a class="btn" href="javascript:;" title="考试次数已经用完"><?php echo $this->G->make('strings')->subString($exam['exam'],80); ?></a>
											<?php } else { ?>
											<a class="ajax btn btn-primary" href="index.php?exam-app-exam-selectquestions&examid=<?php echo $exam['examid'];?>" title="<?php echo $exam['exam'];?>" action-before="clearStorage"><?php echo $this->G->make('strings')->subString($exam['exam'],80); ?></a>
											<?php } ?>
										</p>
									</div>
								</div>
							</li>
							<?php } ?>
						</ul>
						<div class="pagination pagination-right">
				            <ul><?php echo $this->tpl_var['exams']['pages'];?></ul>
				        </div>
						<?php } ?>
					<?php } else { ?>
						<p class="alert">本考场开放考试时间为：<?php echo date('Y-m-d H:i:s',$data['currentbasic']['basicexam']['opentime']['start']); ?> - <?php echo date('Y-m-d H:i:s',$data['currentbasic']['basicexam']['opentime']['end']); ?>，目前不是考试时间，请在规定时间内前来考试哦。</p>
					<?php } ?>
				<?php } else { ?>
				<?php if($this->tpl_var['data']['currentbasic']['basicexam']['selectrule']){?>
				<div>
					<div class="span4"></div>
					<?php if($this->tpl_var['data']['currentbasic']['basicexam']['examnumber'] > 0 && $this->tpl_var['number']['all'] >= $this->tpl_var['data']['currentbasic']['basicexam']['examnumber']){?>
					<div class="span4 text-center"><a class="btn" href="javascript:;">您的考试次数已经用完</a></div>
					<?php } else { ?>
					<div class="span4 text-center"><a class="ajax btn btn-primary" href="index.php?exam-app-exam-selectquestions&examid=<?php echo $exam['examid'];?>" action-before="clearStorage">开始考试</a></div>
					<?php } ?>
					<div class="span4"></div>
				</div>
				<?php } else { ?>
				<ul class="thumbnails">
					<?php $eid = 0; foreach($this->tpl_var['exams']['data'] as $key => $exam){  $eid++; ?>
					<li class="span2">
						<div class="thumbnail">
							<img src="app/core/styles/images/icons/Watches.png"/>
							<div class="caption">
								<p class="text-center">
									<?php if($this->tpl_var['data']['currentbasic']['basicexam']['examnumber'] > 0 && $this->tpl_var['number']['child'][$exam['examid']] >= $this->tpl_var['data']['currentbasic']['basicexam']['examnumber']){?>
									<a class="btn" href="javascript:;" title="考试次数已经用完"><?php echo $this->G->make('strings')->subString($exam['exam'],80); ?></a>
									<?php } else { ?>
									<a class="ajax btn btn-primary" href="index.php?exam-app-exam-selectquestions&examid=<?php echo $exam['examid'];?>" title="<?php echo $exam['exam'];?>" action-before="clearStorage"><?php echo $this->G->make('strings')->subString($exam['exam'],80); ?></a>
									<?php } ?>
								</p>
							</div>
						</div>
					</li>
					<?php if($eid % 6 == 0){?>
					</ul>
					<ul class="thumbnails">
					<?php } ?>
					<?php } ?>
					<div class="pagination pagination-right">
			            <ul><?php echo $this->tpl_var['exams']['pages'];?></ul>
			        </div>
				</ul>
				<?php } ?>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php $this->_compileInclude('foot'); ?>
</body>
</html>