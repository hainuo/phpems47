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
					<li>
						<a href="index.php?exam-app-basics">{x2;$data['currentbasic']['basic']}</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-app-lesson">课后练习</a> <span class="divider">/</span>
					</li>
					<li class="active">
						{x2;$knows['knows']}（{x2;$questype['questype']}）
					</li>
				</ul>
				<div id="questionpanel"></div>
			</div>
		</div>
	</div>
</div>
{x2;include:foot}
<script type="text/javascript">
$(document).ready(function(){
	submitAjax({"url":"index.php?exam-app-lesson-ajax-questions","target":"questionpanel"});
});
</script>
</body>
</html>