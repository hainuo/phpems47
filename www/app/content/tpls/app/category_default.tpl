{x2;include:header}
<body>
{x2;include:nav}
<div class="row-fluid">
	<div class="container-fluid">
		<div class="span9 examcontent">
			<div class="exambox">
				<div class="examform">
					<ul class="breadcrumb">
						<li>
							<span class="icon-home"></span> <a href="index.php">主页</a> <span class="divider">/</span>
						</li>
						{x2;tree:$catbread,cb,cbid}
						<li><a href="index.php?content-app-category&catid={x2;v:cb['catid']}">{x2;v:cb['catname']}</a> <span class="divider">/</span></li>
						{x2;endtree}
						<li class="active">{x2;$cat['catname']}</li>
					</ul>
					<h5 class="title">{x2;$cat['catname']}</h5>
					<ul>
						{x2;tree:$contents['data'],content,cid}
						<li><a href="index.php?content-app-content&contentid={x2;v:content['contentid']}">{x2;v:content['contenttitle']}</a></li>
						{x2;if:v:cid % 5 == 0}
						</ul>
						<ul>
						{x2;endif}
						{x2;endtree}
					</ul>
					<div class="pagination pagination-right">
						<ul>{x2;$categorys['pages']}</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="span3 examcontent">
			<div class="exambox">
				<div class="examform">
					<h5 class="title">分类列表</h5>
					<ul>
						{x2;if:$catchildren}
						{x2;tree:$catchildren,cat,cid}
						<li><a href="index.php?content-app-category&catid={x2;v:cat['catid']}">{x2;v:cat['catname']}</a></li>
						{x2;endtree}
						{x2;else}
						{x2;tree:$catbrother,cat,cid}
						<li><a href="index.php?content-app-category&catid={x2;v:cat['catid']}">{x2;v:cat['catname']}</a></li>
						{x2;endtree}
						{x2;endif}
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
{x2;include:foot}
<script>
$(function() {
    $('.banner').unslider({dots: true});
});
</script>
</body>
</html>