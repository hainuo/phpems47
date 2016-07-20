<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<div class="examform">
				<div class="banner span12">
					<ul class="unstyled">
						<?php $cid = 0; foreach($this->tpl_var['contents'][2]['data'] as $key => $content){  $cid++; ?>
						<li><div class="inner"><a href="index.php?content-app-content&contentid=<?php echo $content['contentid'];?>"><img src="<?php echo $content['contentthumb'];?>" /></a></div></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="container-fluid">
		<div class="span6 examcontent">
			<div class="exambox">
				<div class="examform">
					<h5 class="title">考试信息</h5>
					<ul>
						<?php $cid = 0; foreach($this->tpl_var['contents'][1]['data'] as $key => $content){  $cid++; ?>
						<li><a href="index.php?content-app-content&contentid=<?php echo $content['contentid'];?>"><?php echo $content['contenttitle'];?></a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="span3 examcontent">
			<div class="exambox">
				<div class="examform">
					<h5 class="title">一周学霸排行榜</h5>
					<ul>
						<?php $sid = 0; foreach($this->tpl_var['students']['td'] as $key => $stu){  $sid++; ?>
						<li><?php echo $stu['ehusername'];?> 考试 <?php echo $stu['number'];?>次 最高分  <?php  echo intval($stu['ehscore']); ?></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="span3 examcontent">
			<div class="exambox">
				<div class="examform">
					<h5 class="title">一月学霸排行榜</h5>
					<ul>
						<?php $sid = 0; foreach($this->tpl_var['students']['tm'] as $key => $stu){  $sid++; ?>
						<li><?php echo $stu['ehusername'];?> 考试 <?php echo $stu['number'];?>次 最高分  <?php  echo intval($stu['ehscore']); ?></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<?php $typeid = 0; foreach($this->tpl_var['typeBasics'] as $key => $type){  $typeid++; ?>
			<div class="examform">
				<h5 class="title" did="<?php echo $typeid;?>"><?php echo $type['info']['type'];?></h5>
				<ul class="thumbnails">
					<?php $hid = 0; foreach($type['basic'] as $key => $hot){  $hid++; ?>
					<li class="span2">
						<div class="thumbnail">
							<img alt="300x200" src="<?php echo $hot['basicthumb'];?>"/>
							<div class="caption">
								<p class="text-center">
									<a class="ajax btn btn-primary" href="index.php?exam-app-index-setCurrentBasic&basicid=<?php echo $hot['basicid'];?>" title="<?php echo $hot['basic'];?>"><?php echo $hot['basic'];?></a>
								</p>
							</div>
						</div>
					</li>
					<?php if($hid % 6 == 0){?>
				</ul>
				<ul class="thumbnails">
					<?php } ?>
					<?php } ?>
				</ul>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<div class="examform">
				<h5 class="title">热门考场</h5>
				<ul class="thumbnails">
					<?php $hid = 0; foreach($this->tpl_var['basics']['hot']['basic'] as $key => $hot){  $hid++; ?>
					<li class="span2">
						<div class="thumbnail">
							<span class="badge badge-warning"><?php echo $this->tpl_var['basics']['hot']['number'][$hot['basicid']];?></span>
							<img alt="300x200" src="<?php echo $hot['basicthumb'];?>"/>
							<div class="caption">
								<p class="text-center">
									<a class="ajax btn btn-primary" href="index.php?exam-app-index-setCurrentBasic&basicid=<?php echo $hot['basicid'];?>" title="<?php echo $hot['basic'];?>"><?php echo $hot['basic'];?></a>
								</p>
							</div>
						</div>
					</li>
					<?php if($hid % 6 == 0){?>
					</ul>
					<ul class="thumbnails">
					<?php } ?>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<div class="examform">
				<h5 class="title">最新考场</h5>
				<ul class="thumbnails">
					<?php $hid = 0; foreach($this->tpl_var['basics']['new']['data'] as $key => $new){  $hid++; ?>
					<li class="span2">
						<div class="thumbnail">
							<img alt="300x200" src="<?php echo $new['basicthumb'];?>"/>
							<div class="caption">
								<p class="text-center">
									<a class="ajax btn btn-primary" href="index.php?exam-app-index-setCurrentBasic&basicid=<?php echo $new['basicid'];?>" title="<?php echo $new['basic'];?>"><?php echo $new['basic'];?></a>
								</p>
							</div>
						</div>
					</li>
					<?php if($hid % 6 == 0){?>
					</ul>
					<ul class="thumbnails">
					<?php } ?>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php $this->_compileInclude('foot'); ?>
<script>
$(function() {
    $('.banner').unslider({dots: true});
});
</script>
</body>
</html>