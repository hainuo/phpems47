{x2;include:header}
<body>
{x2;include:nav}
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<div class="examform">
				<ul class="breadcrumb">
					<li>
						<span class="icon-home"></span> <a href="index.php?exam">考场选择</a> <span class="divider">/</span>
					</li>
					<li class="active">
						{x2;$data['currentbasic']['basic']}
					</li>
				</ul>
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#" data-toggle="tab">学习考试</a>
					</li>
				</ul>
				<ul class="thumbnails">
					{x2;if:!$data['currentbasic']['basicexam']['model'] || $data['currentbasic']['basicexam']['model'] == 1}
					<li class="span2">
						<div class="thumbnail">
							<img src="app/core/styles/images/icons/colors.png"/>
							<div class="caption">
								<p class="text-center">
									<a class="btn btn-primary" href="index.php?exam-app-lesson">课后练习</a>
								</p>
							</div>
						</div>
					</li>
					<li class="span2">
						<div class="thumbnail">
							<img src="app/core/styles/images/icons/Pensils.png"/>
							<div class="caption">
								<p class="text-center">
									<a class="btn btn-primary" href="index.php?exam-app-exercise">强化训练</a>
								</p>
							</div>
						</div>
					</li>
					<li class="span2">
						<div class="thumbnail">
							<img src="app/core/styles/images/icons/Clipboard.png"/>
							<div class="caption">
								<p class="text-center">
									<a class="btn btn-primary" href="index.php?exam-app-exampaper">模拟考试</a>
								</p>
							</div>
						</div>
					</li>
					{x2;endif}
					{x2;if:!$data['currentbasic']['basicexam']['model'] || $data['currentbasic']['basicexam']['model'] == 2}
					<li class="span2">
						<div class="thumbnail">
							<img src="app/core/styles/images/icons/Watches.png"/>
							<div class="caption">
								<p class="text-center">
									<a class="btn btn-primary" href="index.php?exam-app-exam">正式考试</a>
								</p>
							</div>
						</div>
					</li>
					{x2;if:$sessionvars}
					{x2;if:$data['currentbasic']['basicexam']['opentime']['start'] && $data['currentbasic']['basicexam']['opentime']['end']}
						 {x2;if: $data['currentbasic']['basicexam']['opentime']['start'] <= TIME && $data['currentbasic']['basicexam']['opentime']['end'] >= TIME}
						 <li class="span2">
							<div class="thumbnail">
								<img src="app/core/styles/images/icons/Compas.png"/>
								<div class="caption">
									<p class="text-center">
										<a class="ajax btn btn-primary" href="index.php?exam-app-recover">意外续考</a>
									</p>
								</div>
							</div>
						 </li>
						 {x2;endif}
					{x2;else}
					<li class="span2">
						<div class="thumbnail">
							<img src="app/core/styles/images/icons/Compas.png"/>
							<div class="caption">
								<p class="text-center">
									<a class="ajax btn btn-primary" href="index.php?exam-app-recover">意外续考</a>
								</p>
							</div>
						</div>
					</li>
					{x2;endif}
					{x2;endif}
					{x2;endif}
				</ul>
				{x2;if:!$data['currentbasic']['basicexam']['model'] || $data['currentbasic']['basicexam']['model'] == 1}
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#" data-toggle="tab">改错复习</a>
					</li>
				</ul>
				<ul class="thumbnails">
					<li class="span2">
						<div class="thumbnail">
							<img src="app/core/styles/images/icons/Map.png"/>
							<div class="caption">
								<p class="text-center">
									<a class="btn btn-primary" href="index.php?exam-app-history">考试记录</a>
								</p>
							</div>
						</div>
					</li>
					<li class="span2">
						<div class="thumbnail">
							<img src="app/core/styles/images/icons/Pocket.png"/>
							<div class="caption">
								<p class="text-center">
									<a class="btn btn-primary" href="index.php?exam-app-favor">习题收藏</a>
								</p>
							</div>
						</div>
					</li>
					<li class="span2">
						<div class="thumbnail">
							<img src="app/core/styles/images/icons/Retina-Ready.png"/>
							<div class="caption">
								<p class="text-center">
									<a class="btn btn-primary" href="index.php?exam-app-score">成绩单</a>
								</p>
							</div>
						</div>
					</li>
				</ul>
				{x2;endif}
			</div>
		</div>
	</div>
</div>
{x2;include:foot}
</body>
</html>