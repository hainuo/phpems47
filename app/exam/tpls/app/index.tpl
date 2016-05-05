{x2;include:header}
<body>
{x2;include:nav}
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
					{x2;tree:$basics,basic,bid}
					<li class="span2">
						<div class="thumbnail">
							<img alt="300x200" src="{x2;if:v:basic['basicthumb']}{x2;v:basic['basicthumb']}{x2;else}app/exam/styles/image/paper.png{x2;endif}"/>
							<div class="caption">
								<p class="text-center">
									<a class="ajax btn btn-primary" href="index.php?{x2;$_app}-app-index-setCurrentBasic&basicid={x2;v:basic['basicid']}" title="{x2;v:basic['basic']}">{x2;substring:v:basic['basic'],15}</a>
								</p>
							</div>
						</div>
					</li>
					{x2;if:v:bid % 6 == 0}
					</ul>
					<ul class="thumbnails">
					{x2;endif}
					{x2;endtree}
				</ul>
			</div>
		</div>
	</div>
</div>
{x2;include:foot}
</body>
</html>