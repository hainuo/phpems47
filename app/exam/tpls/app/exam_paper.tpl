{x2;include:header}
<body>
{x2;include:nav}
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<form class="examform form-horizontal" id="form1" name="form1" action="index.php?exam-app-exam-score" method="post">
				<ul class="breadcrumb">
					<li>
						<span class="icon-home"></span> <a href="index.php?exam">考场选择</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-app-basics">{x2;$data['currentbasic']['basic']}</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-app-exam">正式考试</a> <span class="divider">/</span>
					</li>
					<li class="active">
						{x2;$sessionvars['examsession']}
					</li>
				</ul>
				<h3 class="text-center">{x2;$sessionvars['examsession']}</h3>
				{x2;eval: v:oid = 0}
				{x2;tree:$sessionvars['examsessionsetting']['examsetting']['questypelite'],lite,qid}
				{x2;if:v:lite}
				{x2;eval: v:quest = v:key}
				{x2;if:$sessionvars['examsessionquestion']['questions'][v:quest] || $sessionvars['examsessionquestion']['questionrows'][v:quest]}
				{x2;if:$data['currentbasic']['basicexam']['changesequence']}
				{x2;eval: shuffle($sessionvars['examsessionquestion']['questions'][v:quest]);}
				{x2;eval: shuffle($sessionvars['examsessionquestion']['questionrows'][v:quest]);}
				{x2;endif}
				{x2;eval: v:oid++}
				<div id="panel-type{x2;v:quest}" class="tab-pane{x2;if:(!$ctype && v:qid == 1) || ($ctype == v:quest)} active{x2;endif}">
					<ul class="breadcrumb">
						<li>
							<h5>{x2;v:oid}、{x2;$questype[v:quest]['questype']}{x2;$sessionvars['examsessionsetting']['examsetting']['questype'][v:quest]['describe']}</h5>
						</li>
					</ul>
					{x2;eval: v:tid = 0}
	                {x2;tree:$sessionvars['examsessionquestion']['questions'][v:quest],question,qnid}
	                {x2;eval: v:tid++}
	                <div id="question_{x2;v:question['questionid']}" class="paperexamcontent">
						<div class="media well">
							<ul class="nav nav-tabs">
								<li class="active">
									<span class="badge badge-info questionindex">{x2;v:tid}</span></a>
								</li>
								<li class="btn-group pull-right">
									<button class="btn" type="button" onclick="javascript:signQuestion('{x2;v:question['questionid']}',this);"><em class="{x2;if:$sessionvars['examsessionsign'][v:question['questionid']]}icon-star{x2;else}icon-star-empty{x2;endif}" title="标注"></em></button>
								</li>
							</ul>
							<div class="media-body well text-warning">
								<a name="question_{x2;v:question['questionid']}"></a>{x2;realhtml:v:question['question']}<input id="time_{x2;v:question['questionid']}" type="hidden" name="time[{x2;v:question['questionid']}]"/>
							</div>
							{x2;if:!$questype[v:quest]['questsort']}
							{x2;if:v:question['questionselect'] && $questype[v:quest]['questchoice'] != 5}
							<div class="media-body well noborder">
		                    	{x2;realhtml:v:question['questionselect']}
		                    </div>
		                    {x2;endif}
							<div class="media-body well">
		                    	{x2;if:$questype[v:quest]['questchoice'] == 1 || $questype[v:quest]['questchoice'] == 4}
			                        {x2;tree:$selectorder,so,sid}
			                        {x2;if:v:key == v:question['questionselectnumber']}
			                        {x2;eval: break;}
			                        {x2;endif}
			                        <label class="radio inline"><input type="radio" name="question[{x2;v:question['questionid']}]" rel="{x2;v:question['questionid']}" value="{x2;v:so}" {x2;if:v:so == $sessionvars['examsessionuseranswer'][v:question['questionid']]}checked{x2;endif}/>{x2;v:so} </label>
			                        {x2;endtree}
			                    {x2;elseif:$questype[v:quest]['questchoice'] == 5}
		                        	<input type="text" class="input-xlarge" name="question[{x2;v:question['questionid']}]" value="{x2;$sessionvars['examsessionuseranswer'][v:question['questionid']]}" rel="{x2;v:question['questionid']}"/>
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
						</div>
					</div>
					{x2;endtree}
					{x2;tree:$sessionvars['examsessionquestion']['questionrows'][v:quest],questionrow,qrid}
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
										<span class="badge questionindex">{x2;v:did}</span>
									</li>
									<li class="btn-group pull-right">
										<button class="btn" type="button" onclick="javascript:signQuestion('{x2;v:data['questionid']}',this);"><em class="{x2;if:$sessionvars['examsessionsign'][v:data['questionid']]}icon-star{x2;else}icon-star-empty{x2;endif}" title="标注"></em></button>
									</li>
								</ul>
								<div class="media-body well text-warning">
									<a name="question_{x2;v:data['questionid']}"></a>{x2;realhtml:v:data['question']}<input id="time_{x2;v:data['questionid']}" type="hidden" name="time[{x2;v:data['questionid']}]"/>
								</div>
								{x2;if:!$questype[v:quest]['questsort']}
								{x2;if:v:data['questionselect'] && $questype[v:quest]['questchoice'] != 5}
								<div class="media-body well noborder">
			                    	{x2;realhtml:v:data['questionselect']}
			                    </div>
			                    {x2;endif}
								<div class="media-body well">
			                    	{x2;if:$questype[v:quest]['questchoice'] == 1 || $questype[v:quest]['questchoice'] == 4}
				                        {x2;tree:$selectorder,so,sid}
				                        {x2;if:v:key == v:data['questionselectnumber']}
				                        {x2;eval: break;}
				                        {x2;endif}
				                        <label class="radio inline"><input type="radio" name="question[{x2;v:data['questionid']}]" rel="{x2;v:data['questionid']}" value="{x2;v:so}" {x2;if:v:so == $sessionvars['examsessionuseranswer'][v:data['questionid']]}checked{x2;endif}/>{x2;v:so} </label>
				                        {x2;endtree}
			                        {x2;elseif:$questype[v:quest]['questchoice'] == 5}
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
								<div class="media-body well">
									{x2;eval: $dataid = v:data['questionid']}
									<textarea class="jckeditor" etype="simple" id="editor{x2;$dataid}" name="question[{x2;$dataid}]" rel="{x2;v:data['questionid']}">{x2;realhtml:$sessionvars['examsessionuseranswer'][$dataid]}</textarea>
								</div>
								{x2;endif}
							</div>
							{x2;endtree}
						</div>
					</div>
					{x2;endtree}
				</div>
				{x2;endif}
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
    	{x2;tree:$sessionvars['examsessionsetting']['examsetting']['questypelite'],lite,qid}
    	{x2;if:v:lite}
    	{x2;eval: v:quest = v:key}
    	{x2;if:$sessionvars['examsessionquestion']['questions'][v:quest] || $sessionvars['examsessionquestion']['questionrows'][v:quest]}
        {x2;eval: v:oid++}
        <dl class="clear">
        	<dt class="float_l"><b>{x2;v:oid}、{x2;$questype[v:quest]['questype']}</b></dt>
            <dd>
            	{x2;eval: v:tid = 0}
                {x2;tree:$sessionvars['examsessionquestion']['questions'][v:quest],question,qnid}
                {x2;eval: v:tid++}
            	<a id="sign_{x2;v:question['questionid']}" href="#question_{x2;v:question['questionid']}" rel="0" class="badge questionindex{x2;if:$sessionvars['examsessionsign'][v:question['questionid']]} signBorder{x2;endif}">{x2;v:tid}</a>
            	{x2;endtree}
            	{x2;tree:$sessionvars['examsessionquestion']['questionrows'][v:quest],questionrow,qrid}
                {x2;eval: v:tid++}
                {x2;tree:v:questionrow['data'],data,did}
				<a id="sign_{x2;v:data['questionid']}" href="#question_{x2;v:data['questionid']}" rel="0" class="badge questionindex{x2;if:$sessionvars['examsessionsign'][v:data['questionid']]} signBorder{x2;endif}">{x2;v:tid}-{x2;v:did}</a>
                {x2;endtree}
                {x2;endtree}
            </dd>
        </dl>
        {x2;endif}
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
			<div class="span2">
				<ul class="unstyled">
					<li><h4><img src="app/core/styles/images/icons/Watches.png" style="width:1.3em;"/> <span id="timer_h">00</span>：<span id="timer_m">00</span>：<span id="timer_s">00</span></h4></li>
				</ul>
			</div>
			<div class="span2">
				<ul class="unstyled">
					<li><h6><a href="#top"><em class="icon-circle-arrow-up"></em>回顶部</a> &nbsp; <a href="#modal" data-toggle="modal"><em class="icon-calendar"></em>试题列表</a></h6></li>
				</ul>
			</div>
			<div class="span6">
				<ul class="unstyled">
					<li><h6>已做 <span class="yesdonumber">0</span> 题 共 <span class="allquestionnumber">50</span> 题 总分：<span class="orange">{x2;$sessionvars['examsessionsetting']['examsetting']['score']}</span>分 合格分数线：<span class="orange">{x2;$sessionvars['examsessionsetting']['examsetting']['passscore']}</span>分 考试时间：<span class="orange">{x2;$sessionvars['examsessionsetting']['examsetting']['examtime']}</span>分钟</h6></li>
				</ul>
			</div>
			<div class="span2">
				<ul class="unstyled">
					<li class="text-right"><a href="#submodal" role="button" class="btn btn-primary" data-toggle="modal"> 交 卷 </a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$.get('index.php?exam-app-index-ajax-lefttime&rand'+Math.random(),function(data){
		var setting = {
			{x2;if:$data['currentbasic']['basicexam']['opentime']['start'] && $data['currentbasic']['basicexam']['opentime']['end']}
			{x2;if:$data['currentbasic']['basicexam']['opentime']['end']-300 <= ($sessionvars['examsessiontime'] * 60 + $sessionvars['examsessionstarttime'])}
			time:{x2;eval: echo intval(($data['currentbasic']['basicexam']['opentime']['end']- 300 - $sessionvars['examsessionstarttime'])/60)},
			{x2;else}
			time:{x2;$sessionvars['examsessiontime']},
			{x2;endif}
			{x2;else}
			time:{x2;$sessionvars['examsessiontime']},
			{x2;endif}
			hbox:$("#timer_h"),
			mbox:$("#timer_m"),
			sbox:$("#timer_s"),
			finish:function(){submitPaper();}
		}
		setting.lefttime = parseInt(data);
		countdown(setting);
	});
	//setInterval(refreshRecord,5000);
	setInterval(saveanswer,300000);

	$('.allquestionnumber').html($('.paperexamcontent').length);
	$('.yesdonumber').html($('#modal-body .badge-info').length);

	initData = $.parseJSON(storage.getItem('questions'));
	if(initData){
		for(var p in initData){
			if(p!='set')
			formData[p]=initData[p];
			$("#time_"+$('[name="'+p+'"]').attr('rel')).val(initData[p].time);
		}

		var textarea = $('#form1 textarea');
		$.each(textarea,function(){
			var _this = $(this);
			if(initData[_this.attr('name')])
			{
				_this.val(initData[_this.attr('name')].value);
				CKEDITOR.instances[_this.attr('id')].setData(initData[_this.attr('name')].value);
				if(initData[_this.attr('name')].value && initData[_this.attr('name')].value != '')
				batmark(_this.attr('rel'),initData[_this.attr('name')].value);
			}
		});

		var texts = $('#form1 :input[type=text]');
		$.each(texts,function(){
			var _this = $(this);
			if(initData[_this.attr('name')])
			{
				_this.val(initData[_this.attr('name')]?initData[_this.attr('name')].value:'');
				if(initData[_this.attr('name')].value && initData[_this.attr('name')].value != '')
				batmark(_this.attr('rel'),initData[_this.attr('name')].value);
			}
		});

		var radios = $('#form1 :input[type=radio]');
		$.each(radios,function(){
			var _= this, v = initData[_.name]?initData[_.name].value:null;
			var _this = $(this);
			if(v!=''&&v==_.value){
				_.checked = true;
				batmark(_this.attr('rel'),initData[_this.attr('name')].value);
			}else{
				_.checked=false;
			}
		});

		var checkboxs=$('#form1 :input[type=checkbox]');
		$.each(checkboxs,function(){
			var _=this,v=initData[_.name]?initData[_.name].value:null;
			var _this = $(this);
			if(v!=''&&v==_.value){
				_.checked=true;
				batmark(_this.attr('rel'),initData[_this.attr('name')].value);
			}else{
				_.checked=false;
			}
		});
	}

	$('#form1 :input[type=text]').change(function(){
		var _this=$(this);
		var p=[];
		p.push(_this.attr('name'));
		p.push(_this.val());
		p.push(Date.parse(new Date())/1000);
		$('#time_'+_this.attr('rel')).val(Date.parse(new Date())/1000);
		set.apply(formData,p);
		markQuestion(_this.attr('rel'),true);
	});

	$('#form1 :input[type=radio]').change(function(){
		var _=this;
		var _this=$(this);
		var p=[];
		p.push(_.name);
		if(_.checked){
			p.push(_.value);
			p.push(Date.parse(new Date())/1000);
			$('#time_'+_this.attr('rel')).val(Date.parse(new Date())/1000);
			set.apply(formData,p);
		}else{
			p.push('');
			p.push(null);
			set.apply(formData,p);
		}
		markQuestion(_this.attr('rel'));
	});

	$('#form1 textarea').change(function(){
		var _= this;
		var _this=$(this);
		var p=[];
		p.push(_.name);
		p.push(_.value);
		p.push(Date.parse(new Date())/1000);
		$('#time_'+_this.attr('rel')).val(Date.parse(new Date())/1000);
		set.apply(formData,p);
		markQuestion(_this.attr('rel'),true);
	});

	$('#form1 :input[type=checkbox]').change(function(){
		var _= this;
		var _this = $(this);
		var p=[];
		p.push(_.name);
		if(_.checked){
			p.push(_.value);
			p.push(Date.parse(new Date())/1000);
			$('#time_'+_this.attr('rel')).val(Date.parse(new Date())/1000);
			set.apply(formData,p);
		}else{
			p.push('');
			p.push(null);
			set.apply(formData,p);
		}
		markQuestion(_this.attr('rel'));
	});
});
</script>
{x2;include:foot}
<script>
$('body').css({'-moz-user-select':'-moz-none', '-moz-user-select':'none', '-o-user-select':'none','-khtml-user-select':'none', '-webkit-user-select':'none','-ms-user-select':'none', 'user-select':'none'}).bind('selectstart', function(){ return false; });
</script>
</body>
</html>