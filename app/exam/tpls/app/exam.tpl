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
						正式考试
					</li>
				</ul>
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#" data-toggle="tab">正式考试</a>
					</li>
				</ul>
				<div class="alert alert-info">
					<strong>提示：</strong>
					<p>本考场开启时间 {x2;if:$data['currentbasic']['basicexam']['opentime']['start'] && $data['currentbasic']['basicexam']['opentime']['end']}{x2;date:$data['currentbasic']['basicexam']['opentime']['start'],'Y-m-d H:i:s'} - {x2;date:$data['currentbasic']['basicexam']['opentime']['end'],'Y-m-d H:i:s'}{x2;else}不限{x2;endif} ； 考试次数 {x2;if:$data['currentbasic']['basicexam']['examnumber']}{x2;$data['currentbasic']['basicexam']['examnumber']}{x2;else}不限{x2;endif} ； 抽卷规则 {x2;if:$data['currentbasic']['basicexam']['selectrule']}系统随机抽卷{x2;else}用户手选试卷{x2;endif}。</p>
				</div>
            	<ul class="unstyled">
                	<li><b>1、</b>点击考试名称按钮进入答题界面，考试开始计时。</li>
                	<li><b>2、</b>在随机考试过程中，您可以通过顶部的考试时间来掌握自己的做题时间。</li>
                	<li><b>3、</b>提交试卷后，可以通过“查看答案和解析”功能进行总结学习。</li>
                	<li><b>4、</b>系统自动记录模拟考试的考试记录，学员考试结束后可以进入“答题记录”功能进行查看。</li>
                	<li>&nbsp;</li>
                </ul>
				{x2;if:$data['currentbasic']['basicexam']['opentime']['start'] && $data['currentbasic']['basicexam']['opentime']['end']}
					{x2;if:$data['currentbasic']['basicexam']['opentime']['start'] <= TIME && $data['currentbasic']['basicexam']['opentime']['end'] >= TIME}
						{x2;if:$data['currentbasic']['basicexam']['selectrule']}
						<div>
							<div class="span4"></div>
							{x2;if:$data['currentbasic']['basicexam']['examnumber'] > 0 && $number['all'] >= $data['currentbasic']['basicexam']['examnumber']}
							<div class="span4 text-center"><a class="btn" href="javascript:;">您的考试次数已经用完</a></div>
							{x2;else}
							<div class="span4 text-center"><a class="ajax btn btn-primary" href="index.php?exam-app-exam-selectquestions&examid={x2;v:exam['examid']}" action-before="clearStorage">开始考试</a></div>
							{x2;endif}
							<div class="span4"></div>
						</div>
						{x2;else}
						<ul class="thumbnails">
							{x2;tree:$exams['data'],exam,eid}
							<li class="span2">
								<div class="thumbnail">
									<img src="app/core/styles/images/icons/Watches.png"/>
									<div class="caption">
										<p class="text-center">
											{x2;if:$data['currentbasic']['basicexam']['examnumber'] > 0 && $number['child'][v:exam['examid']] >= $data['currentbasic']['basicexam']['examnumber']}
											<a class="btn" href="javascript:;" title="考试次数已经用完">{x2;substring:v:exam['exam'],28}</a>
											{x2;else}
											<a class="ajax btn btn-primary" href="index.php?exam-app-exam-selectquestions&examid={x2;v:exam['examid']}" title="{x2;v:exam['exam']}" action-before="clearStorage">{x2;substring:v:exam['exam'],28}</a>
											{x2;endif}
										</p>
									</div>
								</div>
							</li>
							{x2;endtree}
						</ul>
						<div class="pagination pagination-right">
				            <ul>{x2;$exams['pages']}</ul>
				        </div>
						{x2;endif}
					{x2;else}
						<p class="alert">本考场开放考试时间为：{x2;date:$data['currentbasic']['basicexam']['opentime']['start'],'Y-m-d H:i:s'} - {x2;date:$data['currentbasic']['basicexam']['opentime']['end'],'Y-m-d H:i:s'}，目前不是考试时间，请在规定时间内前来考试哦。</p>
					{x2;endif}
				{x2;else}
				{x2;if:$data['currentbasic']['basicexam']['selectrule']}
				<div>
					<div class="span4"></div>
					{x2;if:$data['currentbasic']['basicexam']['examnumber'] > 0 && $number['all'] >= $data['currentbasic']['basicexam']['examnumber']}
					<div class="span4 text-center"><a class="btn" href="javascript:;">您的考试次数已经用完</a></div>
					{x2;else}
					<div class="span4 text-center"><a class="ajax btn btn-primary" href="index.php?exam-app-exam-selectquestions&examid={x2;v:exam['examid']}" action-before="clearStorage">开始考试</a></div>
					{x2;endif}
					<div class="span4"></div>
				</div>
				{x2;else}
				<ul class="thumbnails">
					{x2;tree:$exams['data'],exam,eid}
					<li class="span2">
						<div class="thumbnail">
							<img src="app/core/styles/images/icons/Watches.png"/>
							<div class="caption">
								<p class="text-center">
									{x2;if:$data['currentbasic']['basicexam']['examnumber'] > 0 && $number['child'][v:exam['examid']] >= $data['currentbasic']['basicexam']['examnumber']}
									<a class="btn" href="javascript:;" title="考试次数已经用完">{x2;substring:v:exam['exam'],28}</a>
									{x2;else}
									<a class="ajax btn btn-primary" href="index.php?exam-app-exam-selectquestions&examid={x2;v:exam['examid']}" title="{x2;v:exam['exam']}" action-before="clearStorage">{x2;substring:v:exam['exam'],28}</a>
									{x2;endif}
								</p>
							</div>
						</div>
					</li>
					{x2;if:v:eid % 6 == 0}
					</ul>
					<ul class="thumbnails">
					{x2;endif}
					{x2;endtree}
					<div class="pagination pagination-right">
			            <ul>{x2;$exams['pages']}</ul>
			        </div>
				</ul>
				{x2;endif}
				{x2;endif}
			</div>
		</div>
	</div>
</div>
{x2;include:foot}
</body>
</html>