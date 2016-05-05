{x2;include:header}
<body>
{x2;include:nav}
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<div class="examform" style="position:relative;">
				<div class="scoreArea">{x2;$sessionvars['examsessionscore']}</div>
				<ul class="breadcrumb">
					<li>
						<span class="icon-home"></span> <a href="index.php?exam">考场选择</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-app-basics">{x2;$data['currentbasic']['basic']}</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-app-history&ehtype={x2;$ehtype}">考试记录</a> <span class="divider">/</span>
					</li>
					<li class="active">
						查看解析
					</li>
				</ul>
				<h3 class="text-center">{x2;$sessionvars['examsession']}</h3>
				{x2;eval: v:oid = 0}
				{x2;tree:$questype,quest,qid}
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
	                <div id="question_{x2;v:question['questionid']}" class="paperexamcontent decidediv">
						{x2;if:$sessionvars['examsessionscorelist'][v:question['questionid']] && $sessionvars['examsessionscorelist'][v:question['questionid']] == $sessionvars['examsessionsetting']['examsetting']['questype'][v:quest['questid']]['score']}<div class="right"></div>{x2;else}<div class="wrong"></div>{x2;endif}
						<div class="media well">
							<ul class="nav nav-tabs">
								<li class="active">
									<span class="badge badge-info questionindex">{x2;v:tid}</span></a>
								</li>
								<li class="btn-group pull-right">
									<button class="btn" type="button" onclick="javascript:favorquestion('{x2;v:question['questionid']}');"><em class="icon-heart" title="收藏"></em></button>
								</li>
							</ul>
							<div class="media-body well text-warning">
								<a name="question_{x2;v:question['questionid']}"></a>{x2;realhtml:v:question['question']}
							</div>
							{x2;if:!v:quest['questsort']}
							<div class="media-body well">
		                    	{x2;realhtml:v:question['questionselect']}
		                    </div>
		                    {x2;endif}
							<div class="media-body well">
		                  		<p class="text-error">本题得分：{x2;$sessionvars['examsessionscorelist'][v:question['questionid']]}分{x2;if:$sessionvars['examsessiontimelist'][v:question['questionid']]} &nbsp;&nbsp;做题时间：{x2;date:$sessionvars['examsessiontimelist'][v:question['questionid']],'Y-m-d H:i:s'}{x2;endif}</p>
		                  	</div>
							<div class="media-body well">
		                    	<ul class="unstyled">
		                        	<li class="text-error">正确答案：</li>
		                            <li class="text-success">{x2;realhtml:v:question['questionanswer']}</li>
		                        	<li class="text-info">您的答案：</li>
		                            <li class="text-success">{x2;if:is_array($sessionvars['examsessionuseranswer'][v:question['questionid']])}{x2;eval: echo implode('',$sessionvars['examsessionuseranswer'][v:question['questionid']])}{x2;else}{x2;realhtml:$sessionvars['examsessionuseranswer'][v:question['questionid']]}{x2;endif}</li>
		                        	<li><span class="text-info">所在章：</span>{x2;tree:v:question['questionknowsid'],knowsid,kid}&nbsp;&nbsp;{x2;$globalsections[$globalknows[v:knowsid['knowsid']]['knowssectionid']]['section']}&nbsp;{x2;endtree}</li>
		                        	<li class="text-success"><span class="text-info">知识点：</span>{x2;tree:v:question['questionknowsid'],knowsid,kid}&nbsp;&nbsp;{x2;$globalknows[v:knowsid['knowsid']]['knows']}&nbsp;{x2;endtree}</li>
		                        	<li class="text-info">答案解析：</li>
		                        	<li class="text-success">{x2;realhtml:v:question['questiondescribe']}</li>
		                        </ul>
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
							<div class="paperexamcontent decidediv">
								{x2;if:$sessionvars['examsessionscorelist'][v:data['questionid']] && $sessionvars['examsessionscorelist'][v:data['questionid']] == $sessionvars['examsessionsetting']['examsetting']['questype'][v:quest['questid']]['score']}<div class="right"></div>{x2;else}<div class="wrong"></div>{x2;endif}
								<ul class="nav nav-tabs">
									<li class="active">
										<span class="badge questionindex">{x2;v:did}</span></a>
									</li>
									<li class="btn-group pull-right">
										<button class="btn" type="button" onclick="javascript:favorquestion('{x2;v:data['questionid']}');"><em class="icon-heart" title="收藏"></em></button>
									</li>
								</ul>
								<div class="media-body well text-warning">
									<a name="question_{x2;v:data['questionid']}"></a>{x2;realhtml:v:data['question']}
								</div>
								{x2;if:!v:quest['questsort']}
								<div class="media-body well">
			                    	{x2;realhtml:v:data['questionselect']}
			                    </div>
			                    {x2;endif}
								<div class="media-body well">
			                  		<p class="text-error">本题得分：{x2;$sessionvars['examsessionscorelist'][v:data['questionid']]}分{x2;$sessionvars['examsessiontimelist'][v:data['questionid']]}{x2;if:$sessionvars['examsessiontimelist'][v:data['questionid']]}&nbsp;&nbsp;做题时间：{x2;date:$sessionvars['examsessiontimelist'][v:data['questionid']],'Y-m-d H:i:s'}{x2;endif}</p>
			                  	</div>
								<div class="media-body well">
									<ul class="unstyled">
			                        	<li class="text-error">正确答案：</li>
			                            <li class="text-success">{x2;realhtml:v:data['questionanswer']}</li>
			                        	<li class="text-info">您的答案：</li>
			                            <li class="text-success">{x2;if:is_array($sessionvars['examsessionuseranswer'][v:data['questionid']])}{x2;eval: echo implode('',$sessionvars['examsessionuseranswer'][v:data['questionid']])}{x2;else}{x2;realhtml:$sessionvars['examsessionuseranswer'][v:data['questionid']]}{x2;endif}</li>
			                        	<li><span class="text-info">所在章：</span>{x2;tree:v:questionrow['qrknowsid'],knowsid,kid}&nbsp;&nbsp;{x2;$globalsections[$globalknows[v:knowsid['knowsid']]['knowssectionid']]['section']}&nbsp;{x2;endtree}</li>
			                        	<li><span class="text-info">知识点：</span>{x2;tree:v:questionrow['qrknowsid'],knowsid,kid}&nbsp;&nbsp;{x2;$globalknows[v:knowsid['knowsid']]['knows']}&nbsp;{x2;endtree}</li>
			                        	<li class="text-info">答案解析：</li>
		                        		<li class="text-success">{x2;realhtml:v:data['questiondescribe']}</li>
			                        </ul>
								</div>
							</div>
							{x2;endtree}
						</div>
					</div>
					{x2;endtree}
				</div>
				{x2;endif}
				{x2;endtree}
			</div>
		</div>
	</div>
</div>
<div aria-hidden="true" id="modal" class="modal hide fade" role="dialog" aria-labelledby="#myModalLabel">
	<div class="modal-header">
		<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
		<h3 id="myModalLabel">
			试题列表
		</h3>
	</div>
	<div class="modal-body" id="modal-body" style="max-height:560px;">
		{x2;eval: v:oid = 0}
    	{x2;tree:$questype,quest,qid}
    	{x2;if:$sessionvars['examsessionquestion']['questions'][v:quest['questid']] || $sessionvars['examsessionquestion']['questionrows'][v:quest['questid']]}
        {x2;eval: v:oid++}
        <dl class="clear">
        	<dt class="float_l"><b>{x2;v:oid}、{x2;v:quest['questype']}</b></dt>
            <dd>
            	{x2;eval: v:tid = 0}
                {x2;tree:$sessionvars['examsessionquestion']['questions'][v:quest['questid']],question,qnid}
                {x2;eval: v:tid++}
            	<a id="sign_{x2;v:question['questionid']}" href="#question_{x2;v:question['questionid']}" rel="0" class="badge questionindex{x2;if:$sessionvars['examsessionsign'][v:question['questionid']]} signBorder{x2;endif}">{x2;v:tid}</a>
            	{x2;endtree}
            	{x2;tree:$sessionvars['examsessionquestion']['questionrows'][v:quest['questid']],questionrow,qrid}
                {x2;eval: v:tid++}
                {x2;tree:v:questionrow['data'],data,did}
				<a id="sign_{x2;v:data['questionid']}" href="#question_{x2;v:data['questionid']}" rel="0" class="badge questionindex{x2;if:$sessionvars['examsessionsign'][v:data['questionid']]} signBorder{x2;endif}">{x2;v:tid}-{x2;v:did}</a>
                {x2;endtree}
                {x2;endtree}
            </dd>
        </dl>
        {x2;endif}
        {x2;endtree}
	</div>
	<div class="modal-footer">
		 <button aria-hidden="true" class="btn" data-dismiss="modal">隐藏</button>
	</div>
</div>
<div class="row-fluid">
	<div class="toolcontent">
		<div class="container-fluid footcontent">
			<div class="span6">
				<ul class="unstyled">
					<li><h6><a href="#top"><em class="icon-circle-arrow-up"></em>回顶部</a> &nbsp; <a href="#modal" data-toggle="modal"><em class="icon-calendar"></em>试题列表</a></h6></li>
				</ul>
			</div>
			<div class="span6">
				<ul class="unstyled">
					<li><h6>共 <span class="allquestionnumber">50</span> 题 总分：<span class="orange">{x2;$sessionvars['examsessionsetting']['examsetting']['score']}</span>分 合格分数线：<span class="orange">{x2;$sessionvars['examsessionsetting']['examsetting']['passscore']}</span>分 考试时间：<span class="orange">{x2;$sessionvars['examsessionsetting']['examsetting']['examtime']}</span>分钟</h6></li>
				</ul>
			</div>
		</div>
	</div>
</div>
{x2;include:foot}
</body>
</html>