			<form id="form1" name="form1" action="index.php?exam-app-lesson-ajax-questions">
                {x2;if:$question['questionid']}
                <div id="question_{x2;$question['questionid']}" class="paperexamcontent">
					<div class="media well">
						<ul class="nav nav-tabs">
							<li class="active">
								<span class="badge badge-info questionindex">{x2;$number}</span></a>
							</li>
							<li class="btn-group pull-right">
								<button class="btn" type="button" onclick="javascript:favorquestion('{x2;$question['questionid']}');"><em class="icon-heart" title="收藏"></em></button>
							</li>
						</ul>
						<div class="media-body well text-warning">
							<a name="question_{x2;$question['questionid']}"></a>{x2;realhtml:$question['question']}
						</div>
						{x2;if:!$questype['questsort']}
						{x2;if:$questype['questchoice'] != 5}
						<div class="media-body well">
	                    	{x2;realhtml:$question['questionselect']}
	                    </div>
	                    {x2;endif}
						<div class="media-body well questionanswerbox" id="answernotice_{x2;$question['questionid']}">
	                    	{x2;if:$questype['questchoice'] == 1 || $questype['questchoice'] == 4}
		                        {x2;tree:$selectorder,so,sid}
		                        {x2;if:v:key == $question['questionselectnumber']}
		                        {x2;eval: break;}
		                        {x2;endif}
		                        <label class="radio inline"><input type="radio" name="question[{x2;$question['questionid']}]" rel="{x2;$question['questionid']}" value="{x2;v:so}" {x2;if:v:so == $sessionvars['examsessionuseranswer'][$question['questionid']]}checked{x2;endif}/>{x2;v:so} </label>
		                        {x2;endtree}
	                        {x2;elseif:$questype['questchoice'] == 5}
		                        <input type="text" class="input-xlarge" name="question[{x2;$question['questionid']}]" value="{x2;$sessionvars['examsessionuseranswer'][$question['questionid']]}" rel="{x2;$question['questionid']}"/>
		                    {x2;else}
		                        {x2;tree:$selectorder,so,sid}
		                        {x2;if:v:key >= $question['questionselectnumber']}
		                        {x2;eval: break;}
		                        {x2;endif}
		                        <label class="checkbox inline"><input type="checkbox" name="question[{x2;$question['questionid']}][{x2;v:key}]" rel="{x2;$question['questionid']}" value="{x2;v:so}" {x2;if:in_array(v:so,$sessionvars['examsessionuseranswer'][$question['questionid']])}checked{x2;endif}/>{x2;v:so} </label>
		                        {x2;endtree}
	                        {x2;endif}
	                    </div>
						{x2;else}
						<div class="media-body well questionanswerbox">
							{x2;eval: $dataid = $question['questionid']}
							<textarea class="jckeditor" etype="simple" id="editor{x2;$dataid}" name="question[{x2;$dataid}]" rel="{x2;$question['questionid']}">{x2;realhtml:$sessionvars['examsessionuseranswer'][$dataid]}</textarea>
						</div>
						{x2;endif}
						<div class="media-body well">
							<div class="btn-group pull-right hide answerbox">
			            		{x2;if:$number > 1}
			            		<a class="btn ajax" target="questionpanel" href="index.php?{x2;$_app}-app-lesson-ajax-questions&number={x2;eval: echo intval($number - 1)}" title="上一题">上一题</a>
			            		{x2;endif}
								<a class="btn ajax" target="questionpanel" href="index.php?{x2;$_app}-app-lesson-ajax-questions&number={x2;eval: echo intval($number + 1)}" title="下一题">下一题</a>
			            	</div>
			            	<div class="btn-group pull-right">
			            		<a class="btn questionbtn" href="javascript:;" onclick="javascript:$('.questionbtn').addClass('hide');$('.answerbox').removeClass('hide');" title="查看答案">查看答案</a>
			            	</div>
		            	</div>
						<div class="media-body well answerbox hide">
							<h5>答案</h5>
							{x2;realhtml:$question['questionanswer']}
						</div>
						<div id="rightanswer_{x2;$question['questionid']}" class="hide">{x2;realhtml:$question['questionanswer']}</div>
						<div class="media-body well answerbox hide">
							<h5>解析</h5>
							{x2;realhtml:$question['questiondescribe']}
						</div>
					</div>
				</div>
				{x2;else}
                <div id="questionrow_{x2;$question['qrid']}">
					<div class="media well">
						<ul class="nav nav-tabs">
							<li class="active">
								<span class="badge badge-info questionindex">{x2;$number}</span>
							</li>
						</ul>
						<div class="media-body well">
							{x2;realhtml:$question['qrquestion']}
						</div>
						{x2;eval:v:tmpa = array();}
						{x2;tree:$question['data'],data,did}
						{x2;eval:v:tmpa[v:did] = v:data;}
						{x2;endtree}
						{x2;tree:$question['data'],data,did}
						<div class="paperexamcontent_{x2;v:data['questionid']}">
							<ul class="nav nav-tabs">
								<li class="active">
									<span class="badge questionindex">{x2;v:did}</span>
								</li>
								<li class="btn-group pull-right">
									<button class="btn" type="button" onclick="javascript:favorquestion('{x2;v:data['questionid']}');"><em class="icon-heart" title="收藏"></em></button>
								</li>
							</ul>
							<div class="media-body well text-warning">
								<a name="qrchild_{x2;v:data['questionid']}"></a>{x2;realhtml:v:data['question']}
							</div>
							{x2;if:!$questype['questsort']}
							{x2;if:$questype['questchoice'] != 5}
							<div class="media-body well">
		                    	{x2;realhtml:v:data['questionselect']}
		                    </div>
		                    {x2;endif}
							<div class="media-body well questionanswerbox">
		                    	{x2;if:$questype['questchoice'] == 1 || $questype['questchoice'] == 4}
			                        {x2;tree:$selectorder,so,sid}
			                        {x2;if:v:key == v:data['questionselectnumber']}
			                        {x2;eval: break;}
			                        {x2;endif}
			                        <label class="radio inline"><input type="radio" name="question[{x2;v:data['questionid']}]" rel="{x2;v:data['questionid']}" value="{x2;v:so}" {x2;if:v:so == $sessionvars['examsessionuseranswer'][v:data['questionid']]}checked{x2;endif}/>{x2;v:so} </label>
			                        {x2;endtree}
		                        {x2;elseif:$questype['questchoice'] == 5}
		                        	<input type="text" class="input-xlarge" name="question[{x2;v:data['questionid']}]" value="{x2;$sessionvars['examsessionuseranswer'][v:data['questionid']]}" rel="{x2;v:data['questionid']}"/>
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
							<div class="media-body well questionanswerbox">
								{x2;eval: $dataid = v:data['questionid']}
								<textarea class="jckeditor" etype="simple" id="editor{x2;$dataid}" name="question[{x2;$dataid}]" rel="{x2;v:data['questionid']}">{x2;realhtml:$sessionvars['examsessionuseranswer'][$dataid]}</textarea>
							</div>
							{x2;endif}
							<div class="media-body well">
								<div class="btn-group pull-right hide answerbox">
				            		{x2;if:$number > 1}
					            		{x2;if:v:did == 1}
					            		<a class="btn ajax" target="questionpanel" href="index.php?{x2;$_app}-app-lesson-ajax-questions&number={x2;eval: echo intval($number - $prenumer)}" title="上一题">上一题</a>
					            		{x2;else}
					            		<a class="btn" href="#qrchild_{x2;eval: echo v:tmpa[v:did - 1]['questionid']}" title="上一题">上一题</a>
					            		{x2;endif}
					            	{x2;else}
					            		{x2;if:v:did > 1}
					            		<a class="btn" href="#qrchild_{x2;eval: echo v:tmpa[v:did - 1]['questionid']}" title="上一题">上一题</a>
					            		{x2;endif}
				            		{x2;endif}
				            		{x2;if:v:did < count(v:tmpa)}
				            		<a class="btn" href="#qrchild_{x2;eval: echo v:tmpa[v:did + 1]['questionid']}" title="下一题">下一题</a>
				            		{x2;else}
					            		{x2;if:(v:did + $number) < $allnumber}
										<a class="btn ajax" target="questionpanel" href="index.php?{x2;$_app}-app-lesson-ajax-questions&number={x2;eval: echo intval($number + count(v:tmpa))}" title="下一题">下一题</a>
										{x2;endif}
									{x2;endif}
				            	</div>
				            	<div class="btn-group pull-right">
				            		<a class="btn questionbtn" href="javascript:;" onclick="javascript:$('.paperexamcontent_{x2;v:data['questionid']}').find('.questionbtn').addClass('hide');$('.paperexamcontent_{x2;v:data['questionid']}').find('.answerbox').removeClass('hide');" title="查看答案">查看答案</a>
				            	</div>
			            	</div>
			            	<div id="rightanswer_{x2;v:data['questionid']}" class="hide">{x2;realhtml:v:data['questionanswer']}</div>
							<div class="media-body well answerbox hide">
								<h5>答案</h5>
								{x2;realhtml:v:data['questionanswer']}
							</div>
							<div class="media-body well answerbox hide">
								<h5>解析</h5>
								{x2;realhtml:v:data['questiondescribe']}
							</div>
						</div>
						{x2;endtree}
					</div>
				</div>
				{x2;endif}
			</form>
			<script type="text/javascript">
				$("input:radio").click(function(){
					var _this = $(this);
					var qid = _this.attr('rel');
					if(_this.val() == $("#rightanswer_"+qid).html())
					{
						_this.parents('.media-body').addClass('alert-success').addClass('alert').html('恭喜您回答正确！');
					}
					else
					{
						_this.parents('.media-body').addClass('alert-error').addClass('alert').html('回答错误，正确答案为：'+$("#rightanswer_"+qid).html()+'，您选择的答案是：'+_this.val());
					}
					$('.questionbtn').addClass('hide');
					$('.answerbox').removeClass('hide');
				});
			</script>