<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="title" content="无纸化模拟考试系统">
<meta name="description" content="无纸化模拟考试系统">
<meta name="keywords" content="无纸化模拟考试系统">
<meta name="apple-mobile-web-app-capable" content="yes" />
<title>PHPEMS无纸化模拟考试系统</title>
<link href="app/core/styles/css/bootstrap.css" rel="stylesheet">
<link href="app/core/styles/css/plugin.css" rel="stylesheet">
<link href="app/user/styles/css/theme.css" rel="stylesheet" type="text/css" />
<link href="app/core/styles/css/datetimepicker.css" rel="stylesheet">
<script type="text/javascript" src="app/core/styles/js/jquery-1.9.1.min.js"></script>
<link rel="stylesheet" href="app/exam/styles/css/mathquill.css" type="text/css">
<script type="text/javascript" src="app/core/styles/js/jquery-ui.js"></script>
<script type="text/javascript" src="app/core/styles/js/jquery.json.js"></script>
<script type="text/javascript" src="app/core/styles/js/bootstrap.min.js"></script>
<script type="text/javascript" src="app/core/styles/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="app/core/styles/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="app/core/styles/js/swfu/swfupload.js"></script>
<script type="text/javascript" src="app/core/styles/js/plugin.js"></script>
<script src="app/exam/styles/js/plugin.js"></script>
</head>
<body>
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<form class="examform form-horizontal" id="form1" name="form1" action="index.php?exam-app-exam-score" method="post">
				<h3 class="text-center">{x2;$sessionvars['examsession']}</h3>
				{x2;eval: v:oid = 0}
				{x2;tree:$questype,quest,qid}
				{x2;if:$sessionvars['examsessionquestion']['questions'][v:quest['questid']] || $sessionvars['examsessionquestion']['questionrows'][v:quest['questid']]}
				{x2;if:$data['currentbasic']['basicexam']['changesequence']}
				{x2;eval: shuffle($sessionvars['examsessionquestion']['questions'][v:quest['questid']]);}
				{x2;eval: shuffle($sessionvars['examsessionquestion']['questionrows'][v:quest['questid']]);}
				{x2;endif}
				{x2;eval: v:oid++}
				<div id="panel-type{x2;v:quest['questid']}" class="tab-pane{x2;if:(!$ctype && v:qid == 1) || ($ctype == v:quest['questid'])} active{x2;endif}">
					<ul class="breadcrumb">
						<li>
							<h5>{x2;v:oid}、{x2;v:quest['questype']}{x2;$sessionvars['examsessionsetting']['examsetting']['questype'][v:quest['questid']]['describe']}</h5>
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
								{x2;if:$setting['examtype'] == 3}
								<li class="btn-group pull-right">
									<a href="index.php?exam-master-exams-modifypaper&examid={x2;$setting['examid']}&questionid={x2;v:question['questionid']}" class="btn"><em class="icon-edit" title="修改"></em></a>
								</li>
								{x2;endif}
							</ul>
							<div class="media-body well text-warning">
								<a name="question_{x2;v:question['questionid']}"></a>{x2;realhtml:v:question['question']}<input id="time_{x2;v:question['questionid']}" type="hidden" name="time[{x2;v:question['questionid']}]"/>
							</div>
							{x2;if:!v:quest['questsort']}
							<div class="media-body well">
		                    	{x2;realhtml:v:question['questionselect']}
		                    </div>
							<div class="media-body well">
		                    	{x2;if:v:quest['questchoice'] == 1 || v:quest['questchoice'] == 4}
			                        {x2;tree:$selectorder,so,sid}
			                        {x2;if:v:key == v:question['questionselectnumber']}
			                        {x2;eval: break;}
			                        {x2;endif}
			                        <label class="radio inline"><input type="radio" name="question[{x2;v:question['questionid']}]" rel="{x2;v:question['questionid']}" value="{x2;v:so}" {x2;if:v:so == $sessionvars['examsessionuseranswer'][v:question['questionid']]}checked{x2;endif}/>{x2;v:so} </label>
			                        {x2;endtree}
		                        {x2;else}
			                        {x2;tree:$selectorder,so,sid}
			                        {x2;if:v:key >= v:question['questionselectnumber']}
			                        {x2;eval: break;}
			                        {x2;endif}
			                        <label class="checkbox inline"><input type="checkbox" name="question[{x2;v:question['questionid']}][{x2;v:key}]" rel="{x2;v:question['questionid']}" value="{x2;v:so}" {x2;if:in_array(v:so,$sessionvars['examsessionuseranswer'][v:question['questionid']])}checked{x2;endif}/>{x2;v:so} </label>
			                        {x2;endtree}
		                        {x2;endif}
		                    </div>
							{x2;else}
							<div class="media-body well">
								{x2;eval: $dataid = v:question['questionid']}
								<textarea class="jckeditor" etype="simple" id="editor{x2;$dataid}" name="question[{x2;$dataid}]" rel="{x2;v:question['questionid']}">{x2;realhtml:$sessionvars['examsessionuseranswer'][$dataid]}</textarea>
							</div>
							{x2;endif}
							<div class="media-body well">
		                    	参考答案：{x2;realhtml:v:question['questionanswer']}
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
								{x2;if:$setting['examtype'] == 3}
								<li class="btn-group pull-right">
									<a href="index.php?exam-master-exams-modifypaper&examid={x2;$setting['examid']}&qrid={x2;v:questionrow['qrid']}" class="btn"><em class="icon-edit" title="修改"></em></a>
								</li>
								{x2;endif}
							</ul>
							<div class="media-body well">
								{x2;realhtml:v:questionrow['qrquestion']}
							</div>
							{x2;tree:v:questionrow['data'],data,did}
							<div class="paperexamcontent">
								<ul class="nav nav-tabs">
									<li class="active">
										<span class="badge questionindex">{x2;v:did}</span>
									</li>
									{x2;if:$setting['examtype'] == 3}
									<li class="btn-group pull-right">
										<a href="index.php?exam-master-exams-modifypaper&examid={x2;$setting['examid']}&questionid={x2;v:data['questionid']}" class="btn"><em class="icon-edit" title="修改"></em></a>
									</li>
									{x2;endif}
								</ul>
								<div class="media-body well text-warning">
									<a name="question_{x2;v:data['questionid']}"></a>{x2;realhtml:v:data['question']}<input id="time_{x2;v:data['questionid']}" type="hidden" name="time[{x2;v:data['questionid']}]"/>
								</div>
								{x2;if:!v:quest['questsort']}
								<div class="media-body well">
			                    	{x2;realhtml:v:data['questionselect']}
			                    </div>
								<div class="media-body well">
			                    	{x2;if:v:quest['questchoice'] == 1 || v:quest['questchoice'] == 4}
				                        {x2;tree:$selectorder,so,sid}
				                        {x2;if:v:key == v:data['questionselectnumber']}
				                        {x2;eval: break;}
				                        {x2;endif}
				                        <label class="radio inline"><input type="radio" name="question[{x2;v:data['questionid']}]" rel="{x2;v:data['questionid']}" value="{x2;v:so}" {x2;if:v:so == $sessionvars['examsessionuseranswer'][v:data['questionid']]}checked{x2;endif}/>{x2;v:so} </label>
				                        {x2;endtree}
			                        {x2;else}
				                        {x2;tree:$selectorder,so,sid}
				                        {x2;if:v:key >= v:data['questionselectnumber']}
				                        {x2;eval: break;}
				                        {x2;endif}
				                        <label class="checkbox inline"><input type="checkbox" name="question[{x2;v:data['questionid']}][{x2;v:key}]" rel="{x2;v:data['questionid']}" value="{x2;v:so}" {x2;if:in_array(v:so,$sessionvars['examsessionuseranswer'][v:data['questionid']])}checked{x2;endif}/>{x2;v:so} </label>
				                        {x2;endtree}
			                        {x2;endif}
			                    </div>
								{x2;else}
								<div class="media-body well">
									{x2;eval: $dataid = v:data['questionid']}
									<textarea class="jckeditor" etype="simple" id="editor{x2;$dataid}" name="question[{x2;$dataid}]" rel="{x2;v:data['questionid']}">{x2;realhtml:$sessionvars['examsessionuseranswer'][$dataid]}</textarea>
								</div>
								{x2;endif}
								<div class="media-body well">
			                    	参考答案：{x2;realhtml:v:data['questionanswer']}
			                    </div>
							</div>
							{x2;endtree}
						</div>
					</div>
					{x2;endtree}
				</div>
				{x2;endif}
				{x2;endtree}
				<div aria-hidden="true" id="submodal" class="modal hide fade" role="dialog" aria-labelledby="#mySubModalLabel">
					<div class="modal-header">
						<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
						<h3 id="mySubModalLabel">
							交卷
						</h3>
					</div>
					<div class="modal-body" id="modal-body" style="max-height:100%;">
						<p>共有试题 <span class="allquestionnumber">50</span> 题，已做 <span class="yesdonumber">0</span> 题。您确认要交卷吗？</p>
					</div>
					<div class="modal-footer">
						 <button type="button" onclick="javascript:submitPaper();" class="btn btn-primary">确定交卷</button>
						 <input type="hidden" name="insertscore" value="1"/>
						 <button aria-hidden="true" class="btn" type="button" data-dismiss="modal">再检查一下</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div aria-hidden="true" id="fenlumodal" class="modal hide fade" role="dialog" aria-labelledby="#myFenluModalLabel">
	<div class="modal-header">
		<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
		<h3 id="myFenluModalLabel">
			交卷
		</h3>
	</div>
	<div class="modal-body" id="modal-fenlubody" style="max-height:100%;">
		<p>共有试题 <span class="allquestionnumber">50</span> 题，已做 <span class="yesdonumber">0</span> 题。您确认要交卷吗？</p>
	</div>
	<div class="modal-footer">
		 <button type="button" class="btn btn-primary">确定</button>
		 <button aria-hidden="true" class="btn" type="button" data-dismiss="modal">取消</button>
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
</body>
</html>