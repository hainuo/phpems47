<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="title" content="{x2;$apps['exam']['appsetting']['seo']['title']}">
<meta name="description" content="{x2;$apps['exam']['appsetting']['seo']['description']}">
<meta name="keywords" content="{x2;$apps['exam']['appsetting']['seo']['keywords']}">
<meta name="apple-mobile-web-app-capable" content="yes" />
<title>{x2;$sessionvars['examsession']}</title>
<link href="{x2;c:WP}app/core/styles/css/bootstrap.css" rel="stylesheet">
<link href="{x2;c:WP}app/core/styles/css/plugin.css" rel="stylesheet">
<link href="{x2;c:WP}app/user/styles/css/theme.css" rel="stylesheet" type="text/css" />
<link href="{x2;c:WP}app/core/styles/css/datepicker.css" rel="stylesheet">
<script type="text/javascript" src="{x2;c:WP}app/core/styles/js/jquery-1.9.1.min.js"></script>
<link rel="stylesheet" href="{x2;c:WP}app/exam/styles/css/mathquill.css" type="text/css">
<script type="text/javascript" src="{x2;c:WP}app/core/styles/js/jquery-ui.js"></script>
<script type="text/javascript" src="{x2;c:WP}app/core/styles/js/jquery.json.js"></script>
<script type="text/javascript" src="{x2;c:WP}app/core/styles/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{x2;c:WP}app/core/styles/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="{x2;c:WP}app/core/styles/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="{x2;c:WP}app/core/styles/js/swfu/swfupload.js"></script>
<script type="text/javascript" src="{x2;c:WP}app/core/styles/js/plugin.js"></script>
</head>
<body>
<script src="{x2;c:WP}app/exam/styles/js/plugin.js"></script>
<div class="row-fluid">
	<div class="container examcontent">
		<div class="exambox" id="datacontent" style="border:0px;">
			<div class="examform" style="position:relative;">
				<div class="scoreArea">{x2;$sessionvars['examsessionscore']}</div>
				<h3 class="text-center">{x2;$sessionvars['examsession']}</h3>
				<p class="text-center">姓名：{x2;$user['username']}&nbsp;&nbsp;考试时间：{x2;date:$eh['ehstarttime'],'Y-m-d'}</p>
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
						<div class="media well">
							<ul class="nav nav-tabs">
								<li class="active">
									<span class="badge badge-info questionindex">{x2;v:tid}</span></a>
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
		                  		<p class="text-error">本题得分：{x2;$sessionvars['examsessionscorelist'][v:question['questionid']]}分</p>
		                  	</div>
							<div class="media-body well">
		                    	<ul class="unstyled">
		                        	<li class="text-error">正确答案：</li>
		                            <li class="text-success">{x2;realhtml:v:question['questionanswer']}</li>
		                        	<li class="text-info">考生答案：</li>
		                            <li class="text-success">{x2;if:is_array($sessionvars['examsessionuseranswer'][v:question['questionid']])}{x2;eval: echo implode('',$sessionvars['examsessionuseranswer'][v:question['questionid']])}{x2;else}{x2;realhtml:$sessionvars['examsessionuseranswer'][v:question['questionid']]}{x2;endif}</li>
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
								<ul class="nav nav-tabs">
									<li class="active">
										<span class="badge questionindex">{x2;v:did}</span></a>
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
			                  		<p class="text-error">本题得分：{x2;$sessionvars['examsessionscorelist'][v:data['questionid']]}分</p>
			                  	</div>
								<div class="media-body well">
									<ul class="unstyled">
			                        	<li class="text-error">正确答案：</li>
			                            <li class="text-success">{x2;realhtml:v:data['questionanswer']}</li>
			                        	<li class="text-info">考生答案：</li>
			                            <li class="text-success">{x2;if:is_array($sessionvars['examsessionuseranswer'][v:data['questionid']])}{x2;eval: echo implode('',$sessionvars['examsessionuseranswer'][v:data['questionid']])}{x2;else}{x2;realhtml:$sessionvars['examsessionuseranswer'][v:data['questionid']]}{x2;endif}</li>
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
</body>
</html>