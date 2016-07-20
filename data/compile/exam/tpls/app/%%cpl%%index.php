<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<div class="examform">
				<ul class="thumbnails">
					<li class="span2">
						<div class="thumbnail">
							<img alt="300x200" src="app/core/styles/images/icons/Book.png"/>
							<div class="caption">
								<p class="text-center">
									<a class="btn btn-warning" href="index.php?exam-app-basics-open" title="开通新考场">开通新考场</a>
								</p>
							</div>
						</div>
					</li>
				</ul>
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#panel-461715" data-toggle="tab">我的考场</a>
					</li>
				</ul>
				<ul class="thumbnails">
					<?php $bid = 0; foreach($this->tpl_var['basics'] as $key => $basic){  $bid++; ?>
					<li class="span2">
						<div class="thumbnail">
							<img alt="300x200" src="<?php if($basic['basicthumb']){?><?php echo $basic['basicthumb'];?><?php } else { ?>app/exam/styles/image/paper.png<?php } ?>"/>
							<div class="caption">
								<p class="text-center">
									<a class="ajax btn btn-primary" href="index.php?<?php echo $this->tpl_var['_app']; ?>-app-index-setCurrentBasic&basicid=<?php echo $basic['basicid'];?>" title="<?php echo $basic['basic'];?>"><?php echo $this->G->make('strings')->subString($basic['basic'],15); ?></a>
								</p>
							</div>
						</div>
					</li>
					<?php if($bid % 6 == 0){?>
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
</body>
</html>