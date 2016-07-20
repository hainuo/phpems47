<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="title" content="金考必过在线试题系统">
<meta name="description" content="金考必过在线试题系统">
<meta name="keywords" content="金考必过在线试题系统">
<meta name="apple-mobile-web-app-capable" content="yes" />
<title>金考必过金考必过在线试题系统</title>
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
				<h3 class="text-center"><?php echo $this->tpl_var['sessionvars']['examsession'];?></h3>
				 <?php  $oid = 0; ?>
				<?php $qid = 0; foreach($this->tpl_var['questype'] as $key => $quest){  $qid++; ?>
				<?php if($this->tpl_var['sessionvars']['examsessionquestion']['questions'][$quest['questid']] || $this->tpl_var['sessionvars']['examsessionquestion']['questionrows'][$quest['questid']]){?>
				<?php if($this->tpl_var['data']['currentbasic']['basicexam']['changesequence']){?>
				 <?php  shuffle($sessionvars['examsessionquestion']['questions'][$quest['questid']]);; ?>
				 <?php  shuffle($sessionvars['examsessionquestion']['questionrows'][$quest['questid']]);; ?>
				<?php } ?>
				 <?php  $oid++; ?>
				<div id="panel-type<?php echo $quest['questid'];?>" class="tab-pane<?php if((!$this->tpl_var['ctype'] && $qid == 1) || ($this->tpl_var['ctype'] == $quest['questid'])){?> active<?php } ?>">
					<ul class="breadcrumb">
						<li>
							<h5><?php echo $oid;?>、<?php echo $quest['questype'];?><?php echo $this->tpl_var['sessionvars']['examsessionsetting']['examsetting']['questype'][$quest['questid']]['describe'];?></h5>
						</li>
					</ul>
					 <?php  $tid = 0; ?>
	                <?php $qnid = 0; foreach($this->tpl_var['sessionvars']['examsessionquestion']['questions'][$quest['questid']] as $key => $question){  $qnid++; ?>
	                 <?php  $tid++; ?>
	                <div id="question_<?php echo $question['questionid'];?>" class="paperexamcontent">
						<div class="media well">
							<ul class="nav nav-tabs">
								<li class="active">
									<span class="badge badge-info questionindex"><?php echo $tid;?></span></a>
								</li>
								<?php if($this->tpl_var['setting']['examtype'] == 3){?>
								<li class="btn-group pull-right">
									<a href="index.php?exam-master-exams-modifypaper&examid=<?php echo $this->tpl_var['setting']['examid'];?>&questionid=<?php echo $question['questionid'];?>" class="btn"><em class="icon-edit" title="修改"></em></a>
								</li>
								<?php } ?>
							</ul>
							<div class="media-body well text-warning">
								<a name="question_<?php echo $question['questionid'];?>"></a><?php echo html_entity_decode($this->ev->stripSlashes($question['question'])); ?><input id="time_<?php echo $question['questionid'];?>" type="hidden" name="time[<?php echo $question['questionid'];?>]"/>
							</div>
							<?php if(!$quest['questsort']){?>
							<div class="media-body well">
		                    	<?php echo html_entity_decode($this->ev->stripSlashes($question['questionselect'])); ?>
		                    </div>
							<div class="media-body well">
		                    	<?php if($quest['questchoice'] == 1 || $quest['questchoice'] == 4){?>
			                        <?php $sid = 0; foreach($this->tpl_var['selectorder'] as $key => $so){  $sid++; ?>
			                        <?php if($key == $question['questionselectnumber']){?>
			                         <?php  break;; ?>
			                        <?php } ?>
			                        <label class="radio inline"><input type="radio" name="question[<?php echo $question['questionid'];?>]" rel="<?php echo $question['questionid'];?>" value="<?php echo $so;?>" <?php if($so == $this->tpl_var['sessionvars']['examsessionuseranswer'][$question['questionid']]){?>checked<?php } ?>/><?php echo $so;?> </label>
			                        <?php } ?>
		                        <?php } else { ?>
			                        <?php $sid = 0; foreach($this->tpl_var['selectorder'] as $key => $so){  $sid++; ?>
			                        <?php if($key >= $question['questionselectnumber']){?>
			                         <?php  break;; ?>
			                        <?php } ?>
			                        <label class="checkbox inline"><input type="checkbox" name="question[<?php echo $question['questionid'];?>][<?php echo $key;?>]" rel="<?php echo $question['questionid'];?>" value="<?php echo $so;?>" <?php if(in_array($so,$this->tpl_var['sessionvars']['examsessionuseranswer'][$question['questionid']])){?>checked<?php } ?>/><?php echo $so;?> </label>
			                        <?php } ?>
		                        <?php } ?>
		                    </div>
							<?php } else { ?>
							<div class="media-body well">
								 <?php  $dataid = $question['questionid']; ?>
								<textarea class="jckeditor" etype="simple" id="editor<?php echo $this->tpl_var['dataid']; ?>" name="question[<?php echo $this->tpl_var['dataid']; ?>]" rel="<?php echo $question['questionid'];?>"><?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['sessionvars']['examsessionuseranswer'][$this->tpl_var['dataid']])); ?></textarea>
							</div>
							<?php } ?>
							<div class="media-body well">
		                    	参考答案：<?php echo html_entity_decode($this->ev->stripSlashes($question['questionanswer'])); ?>
		                    </div>
						</div>
					</div>
					<?php } ?>
					<?php $qrid = 0; foreach($this->tpl_var['sessionvars']['examsessionquestion']['questionrows'][$quest['questid']] as $key => $questionrow){  $qrid++; ?>
	                 <?php  $tid++; ?>
	                <div id="questionrow_<?php echo $questionrow['qrid'];?>">
						<div class="media well">
							<ul class="nav nav-tabs">
								<li class="active">
									<span class="badge badge-info questionindex"><?php echo $tid;?></span>
								</li>
								<?php if($this->tpl_var['setting']['examtype'] == 3){?>
								<li class="btn-group pull-right">
									<a href="index.php?exam-master-exams-modifypaper&examid=<?php echo $this->tpl_var['setting']['examid'];?>&qrid=<?php echo $questionrow['qrid'];?>" class="btn"><em class="icon-edit" title="修改"></em></a>
								</li>
								<?php } ?>
							</ul>
							<div class="media-body well">
								<?php echo html_entity_decode($this->ev->stripSlashes($questionrow['qrquestion'])); ?>
							</div>
							<?php $did = 0; foreach($questionrow['data'] as $key => $data){  $did++; ?>
							<div class="paperexamcontent">
								<ul class="nav nav-tabs">
									<li class="active">
										<span class="badge questionindex"><?php echo $did;?></span>
									</li>
									<?php if($this->tpl_var['setting']['examtype'] == 3){?>
									<li class="btn-group pull-right">
										<a href="index.php?exam-master-exams-modifypaper&examid=<?php echo $this->tpl_var['setting']['examid'];?>&questionid=<?php echo $data['questionid'];?>" class="btn"><em class="icon-edit" title="修改"></em></a>
									</li>
									<?php } ?>
								</ul>
								<div class="media-body well text-warning">
									<a name="question_<?php echo $data['questionid'];?>"></a><?php echo html_entity_decode($this->ev->stripSlashes($data['question'])); ?><input id="time_<?php echo $data['questionid'];?>" type="hidden" name="time[<?php echo $data['questionid'];?>]"/>
								</div>
								<?php if(!$quest['questsort']){?>
								<div class="media-body well">
			                    	<?php echo html_entity_decode($this->ev->stripSlashes($data['questionselect'])); ?>
			                    </div>
								<div class="media-body well">
			                    	<?php if($quest['questchoice'] == 1 || $quest['questchoice'] == 4){?>
				                        <?php $sid = 0; foreach($this->tpl_var['selectorder'] as $key => $so){  $sid++; ?>
				                        <?php if($key == $data['questionselectnumber']){?>
				                         <?php  break;; ?>
				                        <?php } ?>
				                        <label class="radio inline"><input type="radio" name="question[<?php echo $data['questionid'];?>]" rel="<?php echo $data['questionid'];?>" value="<?php echo $so;?>" <?php if($so == $this->tpl_var['sessionvars']['examsessionuseranswer'][$data['questionid']]){?>checked<?php } ?>/><?php echo $so;?> </label>
				                        <?php } ?>
			                        <?php } else { ?>
				                        <?php $sid = 0; foreach($this->tpl_var['selectorder'] as $key => $so){  $sid++; ?>
				                        <?php if($key >= $data['questionselectnumber']){?>
				                         <?php  break;; ?>
				                        <?php } ?>
				                        <label class="checkbox inline"><input type="checkbox" name="question[<?php echo $data['questionid'];?>][<?php echo $key;?>]" rel="<?php echo $data['questionid'];?>" value="<?php echo $so;?>" <?php if(in_array($so,$this->tpl_var['sessionvars']['examsessionuseranswer'][$data['questionid']])){?>checked<?php } ?>/><?php echo $so;?> </label>
				                        <?php } ?>
			                        <?php } ?>
			                    </div>
								<?php } else { ?>
								<div class="media-body well">
									 <?php  $dataid = $data['questionid']; ?>
									<textarea class="jckeditor" etype="simple" id="editor<?php echo $this->tpl_var['dataid']; ?>" name="question[<?php echo $this->tpl_var['dataid']; ?>]" rel="<?php echo $data['questionid'];?>"><?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['sessionvars']['examsessionuseranswer'][$this->tpl_var['dataid']])); ?></textarea>
								</div>
								<?php } ?>
								<div class="media-body well">
			                    	参考答案：<?php echo html_entity_decode($this->ev->stripSlashes($data['questionanswer'])); ?>
			                    </div>
							</div>
							<?php } ?>
						</div>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
				<?php } ?>
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
		 <?php  $oid = 0; ?>
    	<?php $qid = 0; foreach($this->tpl_var['questype'] as $key => $quest){  $qid++; ?>
    	<?php if($this->tpl_var['sessionvars']['examsessionquestion']['questions'][$quest['questid']] || $this->tpl_var['sessionvars']['examsessionquestion']['questionrows'][$quest['questid']]){?>
         <?php  $oid++; ?>
        <dl class="clear">
        	<dt class="float_l"><b><?php echo $oid;?>、<?php echo $quest['questype'];?></b></dt>
            <dd>
            	 <?php  $tid = 0; ?>
                <?php $qnid = 0; foreach($this->tpl_var['sessionvars']['examsessionquestion']['questions'][$quest['questid']] as $key => $question){  $qnid++; ?>
                 <?php  $tid++; ?>
            	<a id="sign_<?php echo $question['questionid'];?>" href="#question_<?php echo $question['questionid'];?>" rel="0" class="badge questionindex<?php if($this->tpl_var['sessionvars']['examsessionsign'][$question['questionid']]){?> signBorder<?php } ?>"><?php echo $tid;?></a>
            	<?php } ?>
            	<?php $qrid = 0; foreach($this->tpl_var['sessionvars']['examsessionquestion']['questionrows'][$quest['questid']] as $key => $questionrow){  $qrid++; ?>
                 <?php  $tid++; ?>
                <?php $did = 0; foreach($questionrow['data'] as $key => $data){  $did++; ?>
				<a id="sign_<?php echo $data['questionid'];?>" href="#question_<?php echo $data['questionid'];?>" rel="0" class="badge questionindex<?php if($this->tpl_var['sessionvars']['examsessionsign'][$data['questionid']]){?> signBorder<?php } ?>"><?php echo $tid;?>-<?php echo $did;?></a>
                <?php } ?>
                <?php } ?>
            </dd>
        </dl>
        <?php } ?>
        <?php } ?>
	</div>
	<div class="modal-footer">
		 <button aria-hidden="true" class="btn" data-dismiss="modal">隐藏</button>
	</div>
</div>
</body>
</html>