{x2;if:!$userhash}
{x2;include:header}
<body>
<script src="app/exam/styles/js/plugin.js"></script>
{x2;include:nav}
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
{x2;endif}
			<div class="examform" style="position:relative;">
				<div class="scoreArea">{x2;$sessionvars['examsessionscore']}</div>
				<ul class="breadcrumb">
					<li>
						<span class="icon-home"></span> <a href="index.php?exam-phone">考场选择</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-phone-basics">{x2;$data['currentbasic']['basic']}</a> <span class="divider">/</span>
					</li>
					<li class="active">
						习题收藏
					</li>
				</ul>
				<ul class="nav nav-tabs">
					<li{x2;if:!$type} class="active"{x2;endif}>
						<a href="index.php?exam-phone-favor">普通试题</a>
					</li>
					<li{x2;if:$type} class="active"{x2;endif}>
						<a href="index.php?exam-phone-favor&type=1">题冒题</a>
					</li>
				</ul>
				<form action="index.php?exam-phone-favor" method="post">
					<table class="table">
						<thead>
			                <tr>
						        <th colspan="3">搜索</th>
			                </tr>
			            </thead>
						<tr style="line-height:3em;font-size:14px;">
							<td>
								题型：
							</td>
							<td>
								<select name="search[questype]" class="span12">
		                        	<option value="0">请选择题型</option>
		                        	{x2;tree:$questype,quest,qid}
		                    		<option value="{x2;v:quest['questid']}"{x2;if:$search['questype'] == v:quest['questid']} selected{x2;endif}>{x2;v:quest['questype']}</option>
		                    		{x2;endtree}
		                        </select>
							</td>
							<td>
								<button class="btn btn-primary" type="submit">提交</button>
								<input type="hidden" value="{x2;$type}" name="type" />
							</td>
						</tr>
					</table>
					<div class="input">
						<input type="hidden" value="1" name="search[argsmodel]" />
					</div>
				</form>
				{x2;if:$type}
					{x2;eval:v:ishead = 0}
					{x2;eval:v:ispre = 0}
					{x2;tree:$favors['data'],question,qid}
						{x2;if:v:pre != v:question['questionparent']}
						{x2;eval:v:ishead = 0}
						{x2;endif}
						<div>
							<div class="media well">
								{x2;if:!v:ishead}
								<div class="media-body well">
									{x2;realhtml:v:question['qrquestion']}
								</div>
								{x2;endif}
								<div class="paperexamcontent decidediv">
									<ul class="nav nav-tabs">
										<li class="active">
											<span class="badge questionindex">{x2;eval: echo ($page-1)*20+v:qid}</span></a>
										</li>
										<li class="btn-group pull-right">
											<button class="btn" type="button" onclick="javascript:delfavorquestion('{x2;v:question['favorid']}');"><em class="icon-remove" title="删除"></em></button>
										</li>
									</ul>
									<div class="media-body well text-warning">
										<a name="question_{x2;v:data['questionid']}"></a>{x2;realhtml:v:question['question']}
									</div>
									{x2;if:!$questypes[v:question['questiontype']]['questsort']}
									<div class="media-body well">
				                    	{x2;realhtml:v:question['questionselect']}
				                    </div>
				                    {x2;endif}
									<div class="media-body well">
										<ul class="unstyled">
				                        	<li class="text-error">正确答案：</li>
				                            <li class="text-success">{x2;realhtml:v:question['questionanswer']}</li>
				                        	<li><span class="text-info">所在章：</span>{x2;tree:v:questionrow['qrknowsid'],knowsid,kid}&nbsp;&nbsp;{x2;$globalsections[$globalknows[v:knowsid['knowsid']]['knowssectionid']]['section']}&nbsp;{x2;endtree}</li>
				                        	<li><span class="text-info">知识点：</span>{x2;tree:v:questionrow['qrknowsid'],knowsid,kid}&nbsp;&nbsp;{x2;$globalknows[v:knowsid['knowsid']]['knows']}&nbsp;{x2;endtree}</li>
				                        	<li class="text-info">答案解析：</li>
			                        		<li class="text-success">{x2;realhtml:v:question['questiondescribe']}</li>
				                        </ul>
									</div>
								</div>
							</div>
						</div>
						{x2;eval:v:ishead++}
			            {x2;eval:v:pre=v:question['questionparent']}
					{x2;endtree}
				{x2;else}
					{x2;tree:$favors['data'],question,qid}
					<div id="question_{x2;v:question['questionid']}" class="paperexamcontent decidediv">
						<div class="media well">
							<ul class="nav nav-tabs">
								<li class="active">
									<span class="badge badge-info questionindex">{x2;eval: echo ($page-1)*20+v:qid}</span></a>
								</li>
								<li class="btn-group pull-right">
									<button class="btn" type="button" onclick="javascript:delfavorquestion('{x2;v:question['favorid']}');"><em class="icon-remove" title="删除"></em></button>
								</li>
							</ul>
							<div class="media-body well text-warning">
								<a name="question_{x2;v:question['questionid']}"></a>{x2;realhtml:v:question['question']}
							</div>
							{x2;if:!$questypes[v:question['questiontype']]['questsort']}
							<div class="media-body well">
		                    	{x2;realhtml:v:question['questionselect']}
		                    </div>
		                    {x2;endif}
							<div class="media-body well">
		                    	<ul class="unstyled">
		                        	<li class="text-error">正确答案：</li>
		                            <li class="text-success">{x2;realhtml:v:question['questionanswer']}</li>
		                        	<li><span class="text-info">所在章：</span>{x2;tree:v:question['questionknowsid'],knowsid,kid}&nbsp;&nbsp;{x2;$globalsections[$globalknows[v:knowsid['knowsid']]['knowssectionid']]['section']}&nbsp;{x2;endtree}</li>
		                        	<li class="text-success"><span class="text-info">知识点：</span>{x2;tree:v:question['questionknowsid'],knowsid,kid}&nbsp;&nbsp;{x2;$globalknows[v:knowsid['knowsid']]['knows']}&nbsp;{x2;endtree}</li>
		                        	<li class="text-info">答案解析：</li>
		                        	<li class="text-success">{x2;realhtml:v:question['questiondescribe']}</li>
		                        </ul>
		                    </div>
						</div>
					</div>
					{x2;endtree}
				{x2;endif}
				<div class="pagination pagination-right">
		            <ul>{x2;$favors['pages']}</ul>
		        </div>
			</div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
{x2;include:foot}
</body>
</html>
{x2;endif}