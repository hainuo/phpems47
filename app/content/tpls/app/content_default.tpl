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
						<li class="active"><a href="index.php?content-app-category&catid={x2;$cat['catid']}">{x2;$cat['catname']}</a></li>
					</ul>
					<h5 class="title text-center">{x2;$content['contenttitle']}</h5>
					<p class="text-right">发布时间：{x2;date:$content['contentinputtime'],'Y-m-d'}</p>
					<div id="contentTxt">{x2;realhtml:$content['contenttext']}</div>
					<div  style="margin-top:20px;border-top:1px solid #dddddd;padding-top:20px;">
						<div class="bshare-custom pull-right">
							<a class="bshare-qzone" title="分享到QQ空间"></a>
							<a class="bshare-sinaminiblog" title="分享到新浪微博"></a>
							<a class="bshare-renren" title="分享到人人网"></a>
							<a class="bshare-qqmb" title="分享到腾讯微博"></a>
							<a class="bshare-neteasemb" title="分享到网易微博"></a>
							<a class="bshare-more bshare-more-icon more-style-addthis" title="更多平台"></a>
							<span class="BSHARE_COUNT bshare-share-count">0</span>
						</div>
						<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh"></script>
						<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
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