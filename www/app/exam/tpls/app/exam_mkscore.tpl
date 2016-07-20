{x2;include:header}
<body>
{x2;include:nav}
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<form class="examform form-horizontal" id="form1" name="form1" action="index.php?exam-app-exam-makescore">
				<ul class="breadcrumb">
					<li>
						<span class="icon-home"></span> <a href="index.php?exam">考场选择</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-app-basics">{x2;$data['currentbasic']['basic']}</a> <span class="divider">/</span>
					</li>
					<li class="active">
						主观题评分
					</li>
				</ul>
				<h3 class="text-center">主观题评分（{x2;$sessionvars['examsession']}）</h3>
                <div class="well">
                	<ul class="unstyled">
                    	<li><b>阅卷规则</b></li>
                    	<li>1、客观题系统将自动核对学员答案。</li>
                    	<li>2、主观题请参照系统给出的答案自行核对，并给出分数。</li>
                    	<li>3、自行评分完毕后请单击“自行判卷无误，提交”按钮，将即刻为您生成本次测验的成绩单。</li>
                    </ul>
                    <p>以下题为主观题请参照正确答案后自行给出分数</p>
                </div>
				{x2;eval: v:oid = 0}
				{x2;tree:$questype,quest,qid}
				{x2;if:v:quest['questsort']}
				{x2;if:$sessionvars['examsessionquestion']['questions'][v:quest['questid']] || $sessionvars['examsessionquestion']['questionrows'][v:quest['questid']]}
				{x2;eval: v:oid++}
				<div id="panel-type{x2;v:quest['questid']}" class="tab-pane{x2;if:(!$ctype && v:qid == 1) || ($ctype == v:quest['questid'])} active{x2;endif}">
					<ul class="breadcrumb">
						<li>
							<h5>{x2;v:oid}、{x2;v:quest['questype']}</h5>
						</li>
					</ul>
					{x2;eval: v:tid = 0}
	                {x2;tree:$sessionvars['examsessionquestion']['questions'][v:quest['questid']],question,qnid}
	                {x2;eval: v:tid++}
	                <div id="question_{x2;v:question['questionid']}" class="paperexamcontent">
						<div class="media well">
							<ul class="nav nav-tabs">
								<li class="active">
									<span class="badge badge-info questionindex">{x2;v:tid}</span></a>
								</li>
								<li class="btn-group pull-right">
									<button class="btn" type="button"><em class="icon-heart" title="收藏"></em></button>
								</li>
							</ul>
							<div class="media-body well text-warning">
								<a name="question_{x2;v:question['questionid']}"></a>{x2;realhtml:v:question['question']}
							</div>
							<div class="media-body well">
		                    	<ul class="unstyled">
		                        	<li class="text-error">正确答案：</li>
		                            <li class="text-success">{x2;realhtml:v:question['questionanswer']}</li>
		                        	<li class="text-info">您的答案：</li>
		                            <li class="text-success">{x2;realhtml:$sessionvars['examsessionuseranswer'][v:question['questionid']]}</li>
		                        	<li><span class="text-info">所在章：</span>{x2;tree:v:question['questionknowsid'],knowsid,kid}&nbsp;&nbsp;{x2;$globalsections[$globalknows[v:knowsid['knowsid']]['knowssectionid']]['section']}&nbsp;{x2;endtree}</li>
		                        	<li class="text-success"><span class="text-info">知识点：</span>{x2;tree:v:question['questionknowsid'],knowsid,kid}&nbsp;&nbsp;{x2;$globalknows[v:knowsid['knowsid']]['knows']}&nbsp;{x2;endtree}</li>
		                        	<li class="text-info">答案解析：</li>
		                        	<li class="text-success">{x2;realhtml:v:question['questiondescribe']}</li>
		                        </ul>
		                    </div>
		                    <div class="media-body well">
		                  		【请根据参考答案给出分值】
		                  		<input type="text" name="score[{x2;v:question['questionid']}]" value="" maxvalue="{x2;$sessionvars['examsessionsetting']['examsetting']['questype'][v:quest['questid']]['score']}">
		                  		<span class="text-error">提示：本题共{x2;$sessionvars['examsessionsetting']['examsetting']['questype'][v:quest['questid']]['score']}分，可输入0.5的倍数。</span>
		                  	</div>
						</div>
					</div>
					{x2;endtree}
					{x2;tree:$sessionvars['examsessionquestion']['questionrows'][v:quest['questid']],questionrow,qrid}
	                {x2;eval: v:tid++}
	                <div id="questionrow_{x2;v:questionrow['qrid']}">
						<div class="media well">
							<ul class="nav nav-tabs">
								<li class="active">
									<span class="badge badge-info questionindex">{x2;v:tid}</span>
								</li>
							</ul>
							<div class="media-body well">
								{x2;realhtml:v:questionrow['qrquestion']}
							</div>
							{x2;tree:v:questionrow['data'],data,did}
							<div class="paperexamcontent">
								<ul class="nav nav-tabs">
									<li class="active">
										<span class="badge questionindex">{x2;v:did}</span></a>
									</li>
									<li class="btn-group pull-right">
										<button class="btn" type="button"><em class="icon-heart" title="收藏"></em></button>
									</li>
								</ul>
								<div class="media-body well text-warning">
									<a name="question_{x2;v:data['questionid']}"></a>{x2;realhtml:v:data['question']}
								</div>
								<div class="media-body well">
									<ul class="unstyled">
			                        	<li class="text-error">正确答案：</li>
			                            <li class="text-success">{x2;realhtml:v:data['questionanswer']}</li>
			                        	<li class="text-info">您的答案：</li>
			                            <li class="text-success">{x2;realhtml:$sessionvars['examsessionuseranswer'][v:data['questionid']]}</li>
			                        	<li><span class="text-info">所在章：</span>{x2;tree:v:questionrow['qrknowsid'],knowsid,kid}&nbsp;&nbsp;{x2;$globalsections[$globalknows[v:knowsid['knowsid']]['knowssectionid']]['section']}&nbsp;{x2;endtree}</li>
			                        	<li><span class="text-info">知识点：</span>{x2;tree:v:questionrow['qrknowsid'],knowsid,kid}&nbsp;&nbsp;{x2;$globalknows[v:knowsid['knowsid']]['knows']}&nbsp;{x2;endtree}</li>
			                        	<li class="text-info">答案解析：</li>
		                        		<li class="text-success">{x2;realhtml:v:data['questiondescribe']}</li>
			                        </ul>
								</div>
								<div class="media-body well">
			                  		【请根据参考答案给出分值】
			                  		<input type="text" name="score[{x2;v:data['questionid']}]" value="" maxvalue="{x2;$sessionvars['examsessionsetting']['examsetting']['questype'][v:quest['questid']]['score']}">
			                  		<span class="text-error">提示：本题共{x2;$sessionvars['examsessionsetting']['examsetting']['questype'][v:quest['questid']]['score']}分，可输入0.5的倍数。</span>
			                  	</div>
							</div>
							{x2;endtree}
						</div>
					</div>
					{x2;endtree}
				</div>
				{x2;endif}
				{x2;endif}
				{x2;endtree}
				<div class="span12 text-center">
					 <button type="submit" class="btn btn-primary">自行判分完毕，提交分数</button>
					 <input type="hidden" name="makescore" value="1"/>
				</div>
			</form>
		</div>
	</div>
</div>
{x2;include:foot}
</body>
</html>