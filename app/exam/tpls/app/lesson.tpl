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
					<li class="active">
						课后练习
					</li>
				</ul>
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#" data-toggle="tab">课后练习</a>
					</li>
				</ul>
				{x2;if:$record}
				<div class="alert alert-info">
					<strong>提示：</strong>
					<p>系统检测到您上次做到《{x2;$knows[$record['exerknowsid']]['knows']}》的{x2;$questype[$record['exerqutype']]['questype']}第{x2;$record['exernumber']}题，点此<a class="ajax" href="index.php?exam-app-lesson-ajax-setlesson&questype={x2;$record['exerqutype']}&knowsid={x2;$record['exerknowsid']}&number={x2;$record['exernumber']}">继续练习</a></p>
				</div>
				{x2;endif}
				{x2;tree:$sections,section,sid}
				<table class="table table-hover table-bordered">
					<tr class="info"><td colspan="6">{x2;v:section['section']}</td></tr>
					<tr>
						{x2;tree:$basic['basicknows'][v:section['sectionid']],know,kid}
				    	<td><a href="index.php?route=exam-app-lesson-lessonnumber&knowsid={x2;v:know}" target="lessonknows" class="ajax" onclick="javascript:$('#submodal').modal('show');">{x2;$knows[v:know]['knows']}</a></td>
				    	{x2;if:v:kid % 6 == 0}</tr><tr>{x2;endif}
				    	{x2;endtree}
				    	{x2;if:(v:kid % 6 != 0) && (v:kid/6 >= 1)}
				    	{x2;eval: v:mod = 6 - v:kid % 6;}
				    	<td colspan="{x2;v:mod}"></td>
				    	{x2;endif}
					</tr>
				</table>
				{x2;endif}
				<div aria-hidden="true" id="submodal" class="modal hide fade" role="dialog" aria-labelledby="#mySubModalLabel">
					<div class="modal-header">
						<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
						<h3 id="mySubModalLabel">
							题型
						</h3>
					</div>
					<div class="modal-body" id="modal-body" style="max-height:100%;">
						<div id="lessonknows"></div>
					</div>
					<div class="modal-footer">
						 <button aria-hidden="true" class="btn" type="button" data-dismiss="modal">再看看其他的</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{x2;include:foot}
</body>
</html>