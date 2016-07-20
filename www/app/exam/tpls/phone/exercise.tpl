{x2;include:header}
<body>
{x2;include:nav}
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<div class="examform">
				<ul class="breadcrumb">
					<li>
						<span class="icon-home"></span> <a href="index.php?exam-phone">考场选择</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-phone-basics">{x2;$data['currentbasic']['basic']}</a> <span class="divider">/</span>
					</li>
					<li class="active">
						强化训练
					</li>
				</ul>
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#" data-toggle="tab">强化训练</a>
					</li>
				</ul>
				<form action="index.php?exam-phone-exercise" id="exer" method="post">
                	<div class="control-group">
						<label class="control-label" for="inputEmail">章节：</label>
						<div class="controls">
							<select autocomplete="off" name="args[sectionid]" class="combox input-medium" target="questionnumbers" refUrl="index.php?exam-phone-exercise-ajax-getQuestionNumber&sectionid={value}" needle="needle" msg="请选择章节">
                        		<option value="">请选择章节</option>
                        		{x2;tree:$sections,section,sid}
                        		<option value="{x2;v:section['sectionid']}">{x2;v:section['section']}</option>
                        		{x2;endtree}
                        	</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">题型：</label>
						<div class="controls">
							<select autocomplete="off" id="questionnumbers" name="args[questid]" needle="needle" msg="请选择题型">
                        		<option value="">请先选择章节</option>
                        	</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label"></label>
						<div class="controls">
							<input type="hidden" name="setExecriseConfig" value="1" />
							<button type="submit" class="btn btn-primary">来十道</button>
						</div>
					</div>
                </form>
			</div>
		</div>
	</div>
</div>
{x2;include:foot}
</body>
</html>