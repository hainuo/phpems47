<?php

class app
{
	public $G;

	//初始化信息
	public function __construct(&$G)
	{
		$this->G = $G;
		$this->ev = $this->G->make('ev');
		$this->session = $this->G->make('session');
		$this->files = $this->G->make('files');
		$this->user = $this->G->make('user','user');
		$_user = $this->session->getSessionUser();

		$this->_user = $this->user->getUserById($_user['sessionuserid']);
		$this->_user['teacher_subjects'] = unserialize($this->_user['teacher_subjects']);
		$group = $this->user->getGroupById($_user['sessiongroupid']);
		if(!$this->_user['teacher_subjects'])
		{
			if($this->ev->get('userhash'))
			exit(json_encode(array(
				'statusCode' => 300,
				"message" => "您不具备管理权限",
			    "callbackType" => 'forward',
			    "forwardUrl" => "index.php?exam-app"
			)));
			else
			{
				header("location:index.php?exam-app");
				exit;
			}
		}
		//生产一个对象
		$this->teachsubjects = implode(',',$this->_user['teacher_subjects']);
		$this->tpl = $this->G->make('tpl');
		$this->sql = $this->G->make('sql');
		$this->db = $this->G->make('pepdo');

		$this->pg = $this->G->make('pg');
		$this->html = $this->G->make('html');
		$this->apps = $this->G->make('apps','core');
		$this->basic = $this->G->make('basic','exam');
		$this->area = $this->G->make('area','exam');

		$this->section = $this->G->make('section','exam');
		$this->favor = $this->G->make('favor','exam');
		$this->exam = $this->G->make('exam','exam');

		$this->tpl->assign('ols',array(1=>'一','二','三','四','五','六','七','八','九','十','十一','十二','十三','十四','十五','十六','十七','十八','十九','二十'));
		$this->tpl->assign('action',$this->ev->url(2)?$this->ev->url(2):'exams');
		$this->tpl->assign('_user',$this->_user);
		$this->tpl->assign('userhash',$this->ev->get('userhash'));
		$apps = $this->apps->getAppList();
		$this->tpl->assign('apps',$apps);
	}

	//设置基础信息，包括题型、地区、科目及关联关系
	public function basic()
	{
		$subaction = $this->ev->url(3);
		$search = $this->ev->get('search');
		$u = '';
		if($search)
		{
			$this->tpl->assign('search',$search);
			foreach($search as $key => $arg)
			{
				$u .= "&search[{$key}]={$arg}";
			}
		}
		$this->tpl->assign('u',$u);
		$page = $this->ev->get('page');
		$this->tpl->assign('page',$page);
		switch($subaction)
		{
			case 'getsubjectquestype':
			$subjectid = $this->ev->get('subjectid');
			$subject = $this->basic->getSubjectById($subjectid);
			$r = array();
			if($subject['subjectsetting']['questypes'])
			{
				foreach($subject['subjectsetting']['questypes'] as $key => $p)
				{
					if($p)$r[] = $key;
				}
			}
			exit(json_encode($r));
			break;

			//删除考试设置信息
			case 'delbasic':
			$page = $this->ev->get('page');
			$basicid = $this->ev->get('basicid');
			$this->basic->delBasic($basicid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-teach-basic&page={$page}{$u}"
			);
			exit(json_encode($message));
			break;

			//删除考试设置信息
			case 'batdelbasic':
			$page = $this->ev->get('page');
			$basicid = $this->ev->get('basicid');
			$this->basic->delBasic($basicid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-teach-basic&page={$page}{$u}"
			);
			exit(json_encode($message));
			break;

			case 'modifybasic':
			$page = $this->ev->get('page');
			if($this->ev->get('modifybasic'))
			{
				$basicid = $this->ev->get('basicid');
				$args = $this->ev->get('args');
				$this->basic->setBasicConfig($basicid,$args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-teach-basic&page={$page}{$u}"
				);
				exit(json_encode($message));
			}
			else
			{
				$basicid = $this->ev->get('basicid');
				$basic = $this->basic->getBasicById($basicid);
				$subjects = $this->basic->getSubjectList(array(array("AND","find_in_set(subjectid,:subjectid)",'subjectid',$this->teachsubjects)));
				$areas = $this->area->getAreaList();
				$this->tpl->assign('areas',$areas);
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->assign('basic',$basic);
				$this->tpl->display('basic_modify');
			}
			break;

			case 'setexamrange':
			$page = $this->ev->get('page');
			$basicid = $this->ev->get('basicid');
			if($this->ev->get('setexamrange'))
			{
				$args = $this->ev->get('args');
				$args['basicsection'] = array();
				if(is_array($args['basicknows']))
				foreach($args['basicknows'] as $key => $p)
				{
					$args['basicsection'][] = $key;
				}
				$args['basicexam']['opentime']['start'] = strtotime($args['basicexam']['opentime']['start']);
				$args['basicexam']['opentime']['end'] = strtotime($args['basicexam']['opentime']['end']);
				$args['basicsection'] = $args['basicsection'];
				$args['basicknows'] = $args['basicknows'];
				$args['basicexam'] = $args['basicexam'];
				$this->basic->setBasicConfig($basicid,$args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-teach-basic&page={$page}{$u}"
				);
				exit(json_encode($message));
			}
			else
			{
				$basic = $this->basic->getBasicById($basicid);
				$subjects = $this->basic->getSubjectList(array(array('AND',"find_in_set(subjectid,:subjectid)",'subjectid',$this->teachsubjects)));
				$areas = $this->area->getAreaList();
				$tmpknows = $this->section->getAllKnowsBySubject($basic['basicsubjectid']);
				$knows = array();
				$sections = $this->section->getSectionListByArgs(array(array('AND',"sectionsubjectid = :sectionsubjectid",'sectionsubjectid',$basic['basicsubjectid'])));
				foreach($tmpknows as $p)
				{
					$knows[$p['knowssectionid']][] = $p;
				}
				$tpls = array();
				foreach(glob("app/exam/tpls/app/exampaper_paper*.tpl") as $p)
				{
					$tpls['ep'][] = substr(basename($p),0,-4);
				}
				foreach(glob("app/exam/tpls/app/exam_paper*.tpl") as $p)
				{
					$tpls['pp'][] = substr(basename($p),0,-4);
				}
				$this->tpl->assign('tpls',$tpls);
				$this->tpl->assign('basic',$basic);
				$this->tpl->assign('areas',$areas);
				$this->tpl->assign('sections',$sections);
				$this->tpl->assign('knows',$knows);
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->display('basic_examrange');
			}
			break;

			case 'add':
			if($this->ev->get('insertbasic'))
			{
				$args = $this->ev->get('args');
				$page = $this->ev->get('page');
				$id = $this->basic->addBasic($args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-teach-basic-setexamrange&basicid={$id}&page={$page}{$u}"
				);
				exit(json_encode($message));
			}
			else
			{
				$subjects = $this->basic->getSubjectList(array(array("AND","find_in_set(subjectid,:subjectid)",'subjectid',$this->teachsubjects)));
				$areas = $this->area->getAreaList();
				$this->tpl->assign('areas',$areas);
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->display('basic_add');
			}
			break;

			default:
			$page = $this->ev->get('page');
			$page = $page > 1?$page:1;
			$subjects = $this->basic->getSubjectList(array(array('AND','find_in_set(subjectid,:subjectid)','subjectid',$this->teachsubjects)));
			$args = array(array('AND','find_in_set(basicsubjectid,:basicsubjectid)','basicsubjectid',$this->teachsubjects));
			if($search['basicid'])$args[] = array('AND',"basicid = :basicid",'basicid',$search['basicid']);
			else
			{
				if($search['keyword'])$args[] = array('AND',"basic LIKE :basic",'basic',"%{$search['keyword']}%");
				if($search['basicareaid'])$args[] = array('AND',"basicareaid = :basicareaid",'basicareaid',$search['basicareaid']);
				if($search['basicsubjectid'])$args[] = array('AND',"basicsubjectid = :basicsubjectid",'basicsubjectid',$search['basicsubjectid']);
				if($search['basicapi'])$args[] = array('AND',"basicapi = :basicapi",'basicapi',$search['basicapi']);
			}
			$basics = $this->basic->getBasicList($page,10,$args);
			$areas = $this->area->getAreaList();
			$this->tpl->assign('areas',$areas);
			$this->tpl->assign('subjects',$subjects);
			$this->tpl->assign('basics',$basics);
			$this->tpl->display('basic');
			break;
		}
	}

	public function index()
	{
		//$this->tpl->display('index');
		header("location:index.php?exam-teach-users");
	}

	public function questions()
	{
		$subaction = $this->ev->url(3);
		$search = $this->ev->get('search');
		$u = '';
		if($search)
		{
			$this->tpl->assign('search',$search);
			foreach($search as $key => $arg)
			{
				$u .= "&search[{$key}]={$arg}";
			}
		}
		$this->tpl->assign('u',$u);
		$page = $this->ev->get('page');
		$this->tpl->assign('page',$page);
		switch($subaction)
		{
			//搜索问题
			case 'makequery':
			$message = array(
				"statusCode" => 200,
				"message" => "操作成功，正在转入查询结果",
				"callbackType" => "forward",
			    "forwardUrl" => "?exam-teach-questions{$u}"
			);
			exit(json_encode($message));
			break;

			//添加问题
			case 'addquestion':
			if($this->ev->get('insertquestion'))
			{
				$type = $this->ev->get('type');
				$questionparent = $this->ev->get('questionparent');
				//批量添加
				if($type)
				{
					$page = $this->ev->get('page');
					$content = $this->ev->get('content');
					$this->exam->insertQuestionBat($content,$questionparent);
				}
				//单个添加
				else
				{
					$args = $this->ev->get('args');
					$targs = $this->ev->get('targs');
					if(!$questionparent)$questionparent = $args['questionparent'];
					$questype = $this->basic->getQuestypeById($args['questiontype']);
					$args['questionuserid'] = $this->_user['userid'];
					if($questype['questsort'])$choice = 0;
					else $choice = $questype['questchoice'];
					$args['questionanswer'] = $targs['questionanswer'.$choice];
					if(is_array($args['questionanswer']))$args['questionanswer'] = implode('',$args['questionanswer']);
					$page = $this->ev->get('page');
					$args['questioncreatetime'] = TIME;
					$args['questionusername'] = $this->_user['username'];
					$this->exam->addQuestions($args);
				}
				if($questionparent)
				{
					$this->exam->resetRowsQuestionNumber($questionparent);
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功",
						"callbackType" => "forward",
						"forwardUrl" => "?exam-teach-rowsquestions-rowsdetail&questionid={$questionparent}&page={$page}{$u}"
					);
				}
				else
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "?exam-teach-questions&page={$page}{$u}"
				);
				exit(json_encode($message));
			}
			else
			{

				$questypes = $this->basic->getQuestypeList();
				$subjects = $this->basic->getSubjectList(array(array('AND','find_in_set(subjectid,:subjectid)','subjectid',$this->teachsubjects)));
				$sections = $this->section->getSectionListByArgs(array(array('AND',"sectionsubjectid = :sectionsubjectid",'sectionsubjectid',$search['questionsubjectid'])));
				$knows = $this->section->getKnowsListByArgs(array(array('AND',"knowsstatus = 1"),array('AND',"knowssectionid = :knowssectionid",'knowssectionid',$search['questionsectionid'])));
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->assign('sections',$sections);
				$this->tpl->assign('knows',$knows);
				$this->tpl->assign('questypes',$questypes);
				$this->tpl->display('question_add');
			}
			break;

			//添加问题
			case 'bataddquestion':
			if($this->ev->get('insertquestion'))
			{
				$page = $this->ev->get('page');
				$content = $this->ev->get('content');
				$this->exam->insertQuestionBat($content,$questionparent);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-teach-questions&page={$page}{$u}"
				);
				exit(json_encode($message));
			}
			else
			{
				$this->tpl->display('question_batadd');
			}
			break;

			//删除问题
			case 'delquestion':
			$page = $this->ev->get('page');
			$questionid = $this->ev->get('questionid');
			$questionparent = $this->ev->get('questionparent');
			$this->exam->delQuestions($questionid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "?exam-teach-questions&page={$page}{$u}"
			);
			exit(json_encode($message));
			break;


			//恢复被删除的问题
			case 'backquestion':
			$page = $this->ev->get('page');
			$questionid = $this->ev->get('questionid');
			$questions = $this->exam->backQuestions($questionid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "?exam-teach-recyle&page={$page}"
			);
			exit(json_encode($message));
			break;

			//编辑问题
			case 'modifyquestion':
			if($this->ev->get('modifyquestion'))
			{
				$page = $this->ev->get('page');
				$args = $this->ev->get('args');
				$questionid = $this->ev->get('questionid');
				$targs = $this->ev->get('targs');
				$questype = $this->basic->getQuestypeById($args['questiontype']);
				if($questype['questsort'])$choice = 0;
				else $choice = $questype['questchoice'];
				$args['questionanswer'] = $targs['questionanswer'.$choice];
				if(is_array($args['questionanswer']))$args['questionanswer'] = implode('',$args['questionanswer']);
				$this->exam->modifyQuestions($questionid,$args);
				if($args['questionparent'])
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
					"forwardUrl" => "?exam-teach-questions&page={$page}{$u}"
				);
				else
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "?exam-teach-questions&page={$page}{$u}"
				);
				exit(json_encode($message));
			}
			else
			{
				$page = $this->ev->get('page');
				$questionparent = $this->ev->get('questionparent');
				$knowsid = $this->ev->get('knowsid');
				$questionid = $this->ev->get('questionid');
				$questypes = $this->basic->getQuestypeList();
				$question = $this->exam->getQuestionByArgs(array(array('AND',"questionid = :questionid",'questionid',$questionid)));
				$subjects = $this->basic->getSubjectList(array(array('AND','find_in_set(subjectid,:subjectid)','subjectid',$this->teachsubjects)));
				foreach($question['questionknowsid'] as $key => $p)
				{
					$knows = $this->section->getKnowsByArgs(array(array('AND',"knowsid = :knowsid",'knowsid',$p['knowsid'])));
					$question['questionknowsid'][$key]['knows'] = $knows['knows'];
				}
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->assign('questionparent',$questionparent);
				$this->tpl->assign('questypes',$questypes);
				$this->tpl->assign('page',$page);
				$this->tpl->assign('knowsid',$knowsid);
				$this->tpl->assign('question',$question);
				if($questionparent)
				$this->tpl->display('questionchildrows_modify');
				else
				$this->tpl->display('questions_modify');
			}
			break;

			case 'ajax':
			switch($this->ev->url(4))
			{
				//根据章节获取知识点信息
				case 'getknowsbysectionid':
				$sectionid = $this->ev->get('sectionid');
				$aknows = $this->section->getKnowsListByArgs(array(array('AND',"knowssectionid = :knowssectionid",'knowssectionid',$sectionid),array('AND',"knowsstatus = 1")));
				$data = array(array("",'选择知识点'));
				foreach($aknows as $knows)
				{
					$data[] = array($knows['knowsid'],$knows['knows']);
				}
				foreach($data as $p)
				{
					echo "<option value=\"{$p[0]}\">{$p[1]}</option>";
				}
				//exit(json_encode($data));
				break;

				//根据科目获取章节信息
				case 'getsectionsbysubjectid':
				$esid = $this->ev->get('subjectid');
				$aknows = $this->section->getSectionListByArgs(array(array('AND',"sectionsubjectid = :sectionsubjectid",'sectionsubjectid',$esid)));
				$data = array(array(0,'选择章节'));
				foreach($aknows as $knows)
				{
					$data[] = array($knows['sectionid'],$knows['section']);
				}
				foreach($data as $p)
				{
					echo "<option value=\"{$p[0]}\">{$p[1]}</option>";
				}
				//exit(json_encode($data));
				break;

				default:
			}
			break;

			case 'detail':
			$questionid = $this->ev->get('questionid');
			$questionparent = $this->ev->get('questionparent');
			if($questionparent)
			{
				$questions = $this->exam->getQuestionByArgs(array(array('AND',"questionparent = :questionparent",'questionparent',$questionparent)));
			}
			else
			{
				$question = $this->exam->getQuestionByArgs(array(array('AND',"questionid = :questionid",'questionid',$questionid)));
				$sections = array();
				foreach($question['questionknowsid'] as $key => $p)
				{
					$knows = $this->section->getKnowsByArgs(array(array('AND',"knowsid = :knowsid",'knowsid',$p['knowsid'])));
					$question['questionknowsid'][$key]['knows'] = $knows['knows'];
					$sections[] = $this->section->getSectionByArgs(array(array('AND',"sectionid = :sectionid",'sectionid',$knows['knowssectionid'])));
				}
				$subject = $this->basic->getSubjectById($sections[0]['sectionsubjectid']);
			}
			$this->tpl->assign("subject",$subject);
			$this->tpl->assign("sections",$sections);
			$this->tpl->assign("question",$question);
			$this->tpl->assign("questions",$questions);
			$this->tpl->display('question_detail');
			break;

			//试题列表（可根据条件进行查询）
			default:
			$page = $this->ev->get('page');
			$page = $page > 0?$page:1;
			$args = array(array('AND',"quest2knows.qkquestionid = questions.questionid"),array('AND',"questions.questionstatus = '1'"),array('AND',"questions.questionparent = 0"),array('AND',"quest2knows.qktype = 0") );
			if($search['questionid'])
			{
				$args[] = array('AND',"questions.questionid = :questionid",'questionid',$search['questionid']);
			}
			if($search['keyword'])
			{
				$args[] = array('AND',"questions.question LIKE :question",'question','%'.$search['keyword'].'%');
			}
			if($search['knowsids'])
			{
				$args[] = array('AND',"find_in_set(questions.questionknowsid ,:questionknowsid)",'questionknowsid',$search['knowsids']);
			}
			if($search['stime'])
			{
				$args[] = array('AND',"questions.questioncreatetime >= :questioncreatetime",'questioncreatetime',strtotime($search['stime']));
			}
			if($search['etime'])
			{
				$args[] = array('AND',"questions.questioncreatetime <= :questioncreatetime",'questioncreatetime',strtotime($search['etime']));
			}
			if($search['questiontype'])
			{
				$args[] = array('AND',"questions.questiontype = :questiontype",'questiontype',$search['questiontype']);
			}
			if($search['questionlevel'])
			{
				$args[] = array('AND',"questions.questionlevel = :questionlevel",'questionlevel',$search['questionlevel']);
			}
			if($search['questionknowsid'])
			{
				$args[] = array('AND',"quest2knows.qkknowsid = :qkknowsid",'qkknowsid',$search['questionknowsid']);
			}
			else
			{
				$tmpknows = '0';
				if($search['questionsectionid'])
				{
					$knows = $this->section->getKnowsListByArgs(array(array('AND',"knowsstatus = 1"),array('AND',"knowssectionid = :knowssectionid",'knowssectionid',$search['questionsectionid'])));
					foreach($knows as $p)
					{
						if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
					}
					$args[] = array('AND',"find_in_set(quest2knows.qkknowsid,:qkknowsid)",'qkknowsid',$tmpknows);
				}
				elseif($search['questionsubjectid'])
				{
					$knows = $this->section->getAllKnowsBySubject($search['questionsubjectid']);
					foreach($knows as $p)
					{
						if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
					}
					$args[] = array('AND',"find_in_set(quest2knows.qkknowsid,:qkknowsid)",'qkknowsid',$tmpknows);
				}
				else
				{
					$knows = $this->section->getAllKnowsBySubjects($this->teachsubjects);
					foreach($knows as $p)
					{
						if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
					}
					$args[] = array('AND',"find_in_set(quest2knows.qkknowsid,:qkknowsid)",'qkknowsid',$tmpknows);
				}
			}
			$questypes = $this->basic->getQuestypeList();
			$questions = $this->exam->getQuestionsList($page,10,$args);
			$subjects = $this->basic->getSubjectList(array(array('AND','find_in_set(subjectid,:subjectid)','subjectid',$this->teachsubjects)));
			$sections = $this->section->getSectionListByArgs(array(array('AND',"sectionsubjectid = :sectionsubjectid",'sectionsubjectid',$search['questionsubjectid'])));
			$knows = $this->section->getKnowsListByArgs(array(array('AND',"knowsstatus = 1"),array('AND',"knowssectionid = :knowssectionid",'knowssectionid',$search['questionsectionid'])));
			$this->tpl->assign('subjects',$subjects);
			$this->tpl->assign('sections',$sections);
			$this->tpl->assign('knows',$knows);
			$this->tpl->assign('questypes',$questypes);
			$this->tpl->assign('questions',$questions);
			$this->tpl->display('questions');
		}
	}

	public function rowsquestions()
	{
		$subaction = $this->ev->url(3);
		$search = $this->ev->get('search');
		$u = '';
		if($search)
		{
			$this->tpl->assign('search',$search);
			foreach($search as $key => $arg)
			{
				$u .= "&search[{$key}]={$arg}";
			}
		}
		$this->tpl->assign('u',$u);
		$page = $this->ev->get('page');
		$this->tpl->assign('page',$page);
		switch($subaction)
		{
			//删除问题
			case 'delquestion':
			$page = $this->ev->get('page');
			$questionid = $this->ev->get('questionid');
			$question = $this->exam->getQuestionRowsByArgs("qrid = '{$questionid}'");
			if($question['data'])
			{
				$message = array(
					'statusCode' => 300,
					"message" => "操作失败，请先删除子试题"
				);
				exit(json_encode($message));
			}
			$this->exam->delQuestionRows($questionid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-teach-rowsquestions&page={$page}{$u}"
			);
			exit(json_encode($message));
			break;

			//删除子问题
			case 'delchildquestion':
			$page = $this->ev->get('page');
			$questionid = $this->ev->get('questionid');
			$questionparent = $this->ev->get('questionparent');
			$this->exam->delQuestions($questionid);
			$this->exam->resetRowsQuestionNumber($questionparent);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
				"forwardUrl" => "index.php?exam-teach-rowsquestions-rowsdetail&questionid={$questionparent}&page={$page}{$u}"
			);
			exit(json_encode($message));
			break;

			//恢复被删除的问题
			case 'backquestion':
			$page = $this->ev->get('page');
			$questionid = $this->ev->get('questionid');
			$questions = $this->exam->backQuestionRows($questionid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-teach-recyle-rows&page={$page}"
			);
			exit(json_encode($message));
			break;

			//编辑问题
			case 'modifyquestion':
			if($this->ev->get('modifyquestion'))
			{
				$page = $this->ev->get('page');
				$args = $this->ev->get('args');
				$questionid = $this->ev->get('questionid');
				$this->exam->modifyQuestionRows($questionid,$args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-teach-rowsquestions&page={$page}{$u}"
				);
				exit(json_encode($message));
			}
			else
			{
				$page = $this->ev->get('page');
				$questionid = $this->ev->get('questionid');
				$question = $this->exam->getQuestionRowsByArgs(array(array("AND","qrid = :qrid",'qrid',$questionid)));
				$subjects = $this->basic->getSubjectList(array(array("AND","find_in_set(subjectid,:subjectid)",'subjectid',$this->teachsubjects)));
				$questypes = $this->basic->getQuestypeList();
				foreach($question['qrknowsid'] as $key => $p)
				{
					$knows = $this->section->getKnowsByArgs(array(array("AND","knowsid = :knowsid",'knowsid',$p['knowsid'])));
					$question['qrknowsid'][$key]['knows'] = $knows['knows'];
				}
				$this->tpl->assign('questypes',$questypes);
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->assign('page',$page);
				$this->tpl->assign('question',$question);
				$this->tpl->display('questionrows_modify');
			}
			break;

			//编辑子问题
			case 'modifychildquestion':
			if($this->ev->get('modifyquestion'))
			{
				$page = $this->ev->get('page');
				$args = $this->ev->get('args');
				$questionid = $this->ev->get('questionid');
				$targs = $this->ev->get('targs');
				$questype = $this->basic->getQuestypeById($args['questiontype']);
				if($questype['questsort'])$choice = 0;
				else $choice = $questype['questchoice'];
				$args['questionanswer'] = $targs['questionanswer'.$choice];
				if(is_array($args['questionanswer']))$args['questionanswer'] = implode('',$args['questionanswer']);
				$this->exam->modifyQuestions($questionid,$args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
					"forwardUrl" => "index.php?exam-teach-rowsquestions-rowsdetail&questionid={$args['questionparent']}&page={$page}{$u}"
				);
				exit(json_encode($message));
			}
			else
			{
				$page = $this->ev->get('page');
				$questionparent = $this->ev->get('questionparent');
				$knowsid = $this->ev->get('knowsid');
				$questionid = $this->ev->get('questionid');
				$questypes = $this->basic->getQuestypeList();
				$question = $this->exam->getQuestionByArgs("questionid = '{$questionid}'");
				$subjects = $this->basic->getSubjectList(array(array("AND","find_in_set(subjectid,:subjectid)",'subjectid',$this->teachsubjects)));
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->assign('questionparent',$questionparent);
				$this->tpl->assign('questypes',$questypes);
				$this->tpl->assign('page',$page);
				$this->tpl->assign('knowsid',$knowsid);
				$this->tpl->assign('question',$question);
				$this->tpl->display('questionchildrows_modify');
			}
			break;

			case 'detail':
			$questionid = $this->ev->get('questionid');
			$question = $this->exam->getQuestionRowsByArgs("qrid = '{$questionid}'");
			$sections = array();
			foreach($question['qrknowsid'] as $key => $p)
			{
				$knows = $this->section->getKnowsByArgs("knowsid = '{$p['knowsid']}'");
				$question['qrknowsid'][$key]['knows'] = $knows['knows'];
				$sections[] = $this->section->getSectionByArgs("sectionid = '{$knows['knowssectionid']}'");
			}
			$subject = $this->basic->getSubjectById($sections[0]['sectionsubjectid']);
			$this->tpl->assign("subject",$subject);
			$this->tpl->assign("sections",$sections);
			$this->tpl->assign("question",$question);
			$this->tpl->display('questionrows_detail');
			break;

			case 'rowsdetail':
			$questionid = $this->ev->get('questionid');
			$question = $this->exam->getQuestionRowsByArgs("qrid = '{$questionid}'");
			$questypes = $this->basic->getQuestypeList();
			$this->tpl->assign('questypes',$questypes);
			$this->tpl->assign("question",$question);
			$this->tpl->assign("questionparent",$questionid);
			$this->tpl->display('questionrows_list');
			break;

			case 'addchildquestion':
			$questionid = $this->ev->get('questionid');
			$question = $this->exam->getQuestionRowsByArgs("qrid = '{$questionid}'");
			$questypes = $this->basic->getQuestypeList();
			$this->tpl->assign('questypes',$questypes);
			$this->tpl->assign("question",$question);
			$this->tpl->assign("questionparent",$questionid);
			$this->tpl->display('questionrows_addchild');
			break;

			case 'bataddchildquestion':
			$questionid = $this->ev->get('questionid');
			$question = $this->exam->getQuestionRowsByArgs("qrid = '{$questionid}'");
			$questypes = $this->basic->getQuestypeList();
			$this->tpl->assign('questypes',$questypes);
			$this->tpl->assign("question",$question);
			$this->tpl->assign("questionparent",$questionid);
			$this->tpl->display('questionrows_bataddchild');
			break;

			case 'done':
			$sequence = $this->ev->get('sequence');
			$questionparent = $this->ev->get('questionparent');
			foreach($sequence as $key => $l)
			{
				$this->exam->modifyQuestionSequence($key,array('questionsequence'=>$l));
			}
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
				"forwardUrl" => "index.php?exam-teach-rowsquestions-rowsdetail&questionid={$questionparent}&page={$page}{$u}"
			);
			exit(json_encode($message));
			break;

			case 'bataddquestionrows':
			if($this->ev->get('insertquestion'))
			{
				$page = $this->ev->get('page');
				$content = $this->ev->get('content');
				$this->exam->insertQuestionRowsBat($content);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-teach-rowsquestions&page={$page}{$u}"
				);
				exit(json_encode($message));
			}
			else
			{
				$subjects = $this->basic->getSubjectList(array(array("AND","find_in_set(subjectid,:subjectid)",'subjectid',$this->teachsubjects)));
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->display('questionrows_batadd');
			}
			break;

			case 'addquestionrows':
			if($this->ev->get('insertquestion'))
			{
				$args = $this->ev->get('args');
				$args['qrtime'] = TIME;
				$args['qruserid'] = $this->_user['userid'];
				$args['qrusername'] = $this->_user['username'];
				$this->exam->addQuestionRows($args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-teach-rowsquestions&page={$page}{$u}"
				);
				exit(json_encode($message));
			}
			else
			{
				$subjects = $this->basic->getSubjectList(array(array("AND","find_in_set(subjectid,:subjectid)",'subjectid',$this->teachsubjects)));
				$questypes = $this->basic->getQuestypeList();
				$this->tpl->assign('questypes',$questypes);
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->display('questionrows_add');
			}
			break;

			//试题列表（可根据条件进行查询）
			default:
			$page = $this->ev->get('page');
			$page = $page > 0?$page:1;
			$args = array(array("AND","quest2knows.qkquestionid = questionrows.qrid"),array("AND","questionrows.qrstatus = '1'"));
			if($search['questionid'])
			{
				$args[] = array("AND","questionrows.qrid = :qrid",'qrid',$search['questionid']);
			}
			if($search['questiontype'])
			{
				$args[] = array("AND","questionrows.qrtype = :qrtype",'qrtype',$search['questiontype']);
			}
			if($search['keyword'])
			{
				$args[] = array("AND","questionrows.qrquestion LIKE :qrquestion",'qrquestion',"%{$search['keyword']}%");
			}
			if($search['stime'])
			{
				$args[] = array("AND","questionrows.qrtime >= :sqrtime",'sqrtime',strtotime($search['stime']));
			}
			if($search['etime'])
			{
				$args[] = array("AND","questionrows.qrtime >= :eqrtime",'eqrtime',strtotime($search['etime']));
			}
			if($search['qrlevel'])
			{
				$args[] = array("AND","questionrows.qrlevel = :qrlevel",'qrlevel',$search['qrlevel']);
			}
			if($search['questionknowsid'])
			{
				$args[] = array("AND","quest2knows.qkknowsid = :qkknowsid",'qkknowsid',$search['questionknowsid']);
			}
			else
			{
				$tmpknows = '0';
				if($search['questionsectionid'])
				{
					$knows = $this->section->getKnowsListByArgs(array(array("AND","knowsstatus = 1"),array("AND","knowssectionid = :knowssectionid",'knowssectionid',$search['questionsectionid'])));
					foreach($knows as $p)
					{
						if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
					}
					$args[] = array('AND',"find_in_set(quest2knows.qkknowsid,:qkknowsids)","qkknowsids",$tmpknows);
				}
				elseif($search['questionsubjectid'])
				{
					$knows = $this->section->getAllKnowsBySubject($search['questionsubjectid']);
					foreach($knows as $p)
					{
						if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
					}
					$args[] = array('AND',"find_in_set(quest2knows.qkknowsid,:qkknowsids)","qkknowsids",$tmpknows);
				}
				else
				{
					$knows = $this->section->getAllKnowsBySubjects($this->teachsubjects);
					foreach($knows as $p)
					{
						if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
					}
					$args[] = array('AND',"find_in_set(quest2knows.qkknowsid,:qkknowsids)","qkknowsids",$tmpknows);
				}
			}
			$questypes = $this->basic->getQuestypeList();
			$questions = $this->exam->getQuestionrowsList($page,10,$args);
			$subjects = $this->basic->getSubjectList(array(array("AND","find_in_set(subjectid,:subjectid)",'subjectid',$this->teachsubjects)));
			$sections = $this->section->getSectionListByArgs(array(array("AND","sectionsubjectid = :sectionsubjectid",'sectionsubjectid',$search['questionsubjectid'])));
			$knows = $this->section->getKnowsListByArgs(array(array("AND","knowsstatus = 1"),array("AND","knowssectionid = :knowssectionid",'knowssectionid',$search['questionsectionid'])));
			$this->tpl->assign('subjects',$subjects);
			$this->tpl->assign('sections',$sections);
			$this->tpl->assign('knows',$knows);
			$this->tpl->assign('questypes',$questypes);
			$this->tpl->assign('questions',$questions);
			$this->tpl->display('questionrows');
		}
	}

	public function recyle()
	{
		$subaction = $this->ev->url(3);
		switch($subaction)
		{
			//被删除的题帽题列表
			case 'rows':
			$page = $this->ev->get('page');
			$page = $page > 0?$page:1;
			$args = array(array("AND","questionrows.qrstatus = '0'"),array("AND","questionrows.qrid = quest2knows.qkquestionid"),array("AND","quest2knows.qktype = 1"));
			$knows = $this->section->getAllKnowsBySubjects($this->teachsubjects);
			foreach($knows as $p)
			{
				if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
			}
			$tmpknows = trim($tmpknows,', ');
			if(!$tmpknows)$tmpknows = 0;
			$args[] = array('AND',"find_in_set(quest2knows.qkknowsid,:qkknowsids)","qkknowsids",$tmpknows);
			$questypes = $this->basic->getQuestypeList();
			$questions = $this->exam->getQuestionrowsList($page,20,$args);
			$this->tpl->assign('page',$page);
			$this->tpl->assign('questypes',$questypes);
			$this->tpl->assign('questions',$questions);
			$this->tpl->display('recyle_rowsquestions');
			break;

			//彻底删除问题
			case 'finaldelquestion':
			$page = $this->ev->get('page');
			$questionid = $this->ev->get('questionid');
			$this->exam->fanalDelQuestions($questionid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-teach-recyle&page={$page}"
			);
			exit(json_encode($message));
			break;

			//彻底删除问题
			case 'finaldelrowsquestion':
			$page = $this->ev->get('page');
			$questionid = $this->ev->get('questionid');
			$this->exam->finalDelQuestionRows($questionid);
			$this->exam->fanalDelQuestionsByArgs("questionparent = '{$questionid}'");
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-teach-recyle-rows&page={$page}"
			);
			exit(json_encode($message));
			break;

			//被删除的试题列表
			default:
			$page = $this->ev->get('page');
			$page = $page > 0?$page:1;
			$args = array(array("AND","quest2knows.qkquestionid = questions.questionid"),array("AND","questions.questionstatus = '0'"),array("AND","questions.questionparent = 0"),array("AND","quest2knows.qktype = 0") );
			$knows = $this->section->getAllKnowsBySubjects($this->teachsubjects);
			foreach($knows as $p)
			{
				if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
			}
			$tmpknows = trim($tmpknows,', ');
			if(!$tmpknows)$tmpknows = 0;
			$args[] = array("AND","find_in_set(quest2knows.qkknowsid,:qkknowsid)",'qkknowsid',$tmpknows);
			$questypes = $this->basic->getQuestypeList();
			$questions = $this->exam->getQuestionsList($page,20,$args);
			$this->tpl->assign('page',$page);
			$this->tpl->assign('questypes',$questypes);
			$this->tpl->assign('questions',$questions);
			$this->tpl->display('recyle_questions');
			break;
		}
	}

	public function tools()
	{
		$subaction = $this->ev->url(3);
		switch($subaction)
		{
			case 'clear':
			$this->session->clearOutTimeUser();
			$this->exam->clearOutTimeExamSession();
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
			    "navTabId" => "",
			    "rel" => ""
			);
			exit(json_encode($message));
			break;

			default:
			$this->tpl->display('tools');
			break;
		}
	}

	public function exams()
	{
		$subaction = $this->ev->url(3);
		$search = $this->ev->get('search');
		$u = '';
		if($search)
		{
			$this->tpl->assign('search',$search);
			foreach($search as $key => $arg)
			{
				$u .= "&search[{$key}]={$arg}";
			}
		}
		$this->tpl->assign('u',$u);
		$page = $this->ev->get('page');
		$this->tpl->assign('page',$page);
		switch($subaction)
		{
			//删除一个考试配置
			case 'delexam':
			$examid = $this->ev->get('examid');
			$page = $this->ev->get('page');
			$this->exam->delExamSetting($examid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-teach-exams&page={$page}{$u}"
			);
			exit(json_encode($message));
			break;

			case 'ajax':
			switch($this->ev->url(4))
			{
				default:
				$subjectid = $this->ev->get('subjectid');
				$type = $this->ev->get('type');
				if($subjectid)
				{
					$basic = $this->basic->getBasicBySubjectId($subjectid);
					$questypes = $this->basic->getQuestypeList();
					$this->tpl->assign('questypes',$questypes);
					$this->tpl->assign("type",$type);
					$this->tpl->assign("subjectid",$subjectid);
					$this->tpl->assign("basic",$basic);
					$this->tpl->display('exams_ajaxsetting');
				}
			}
			break;

			case 'del':
			$page = $this->ev->get('page');
			$examid = $this->ev->get('examid');
			$this->exam->delExamSetting($examid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-teach-exams&page={$page}{$u}"
			);
			exit(json_encode($message));
			break;

			case 'autopage':
			if($this->ev->get('submitsetting'))
			{
				$args = $this->ev->get('args');
				$args['examsetting'] = $args['examsetting'];
				$args['examauthorid'] = $this->_user['userid'];
				$args['examauthor'] = $this->_user['username'];
				$args['examtype'] = 1;
				$this->exam->addExamSetting($args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "forwardUrl" => "index.php?exam-teach-exams&page={$page}{$u}"
				);
				exit(json_encode($message));
			}
			else
			{
				$subjects = $this->basic->getSubjectList("subjectid IN ({$this->teachsubjects})");
				$questypes = $this->basic->getQuestypeList();
				$this->tpl->assign('questypes',$questypes);
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->display('exams_auto');
			}
			break;

			case 'selfpage':
			if($this->ev->get('submitsetting'))
			{
				$args = $this->ev->get('args');
				$args['examsetting'] = $args['examsetting'];
				$args['examauthorid'] = $this->_user['userid'];
				$args['examauthor'] = $this->_user['username'];
				$args['examtype'] = 2;
				$args['examquestions'] = $args['examquestions'];
				$id = $this->exam->addExamSetting($args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-teach-exams-examself&examid={$id}&page={$page}{$u}"
				);
				exit(json_encode($message));
			}
			else
			{
				$subjects = $this->basic->getSubjectList(array(array("AND","find_in_set(subjectid,:subjectid)",'subjectid',$this->teachsubjects)));
				$questypes = $this->basic->getQuestypeList();
				$this->tpl->assign('questypes',$questypes);
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->display('exams_self');
			}
			break;

			case 'selected':
			$show = $this->ev->get('show');
			$questionids = trim($this->ev->get('questionids')," ,");
			$rowsquestionids = trim($this->ev->get('rowsquestionids')," ,");
			if(!$questionids)$questionids = '0';
			if(!$rowsquestionids)$rowsquestionids = '0';
			$questions = $this->exam->getQuestionListByArgs(array(array('AND',"questionstatus = 1"),array('AND',"find_in_set(questionid,:questionid)",'questionid',$questionids)));
			$rowsquestions = array();
			$rowsquestionids = explode(',',$rowsquestionids);
			foreach($rowsquestionids as $p)
			{
				if($p)
				$rowsquestions[$p] = $this->exam->getQuestionRowsByArgs(array(array('AND',"qrstatus = 1"),array('AND',"qrid = :qrid",'qrid',$p)));
			}
			$this->tpl->assign('rowsquestions',$rowsquestions);
			$this->tpl->assign('questions',$questions);
			$this->tpl->assign('show',$show);
			$this->tpl->display('exams_selected');
			break;

			case 'selectquestions':
			$useframe = $this->ev->get('useframe');
			$page = $this->ev->get('page');
			$page = $page > 0?$page:1;
			$this->pg->setUrlTarget('modal-body" class="ajax');
			if(!$search['questionisrows'])
			{
				$args = array(array("AND","quest2knows.qkquestionid = questions.questionid"),array("AND","questions.questionstatus = '1'"),array("AND","questions.questionparent = 0"),array("AND","quest2knows.qktype = 0") );
				if($search['keyword'])
				{
					$args[] = array("AND","questions.question LIKE :question",'question','%'.$search['keyword'].'%');
				}
				if($search['knowsids'])
				{
					$args[] = array("AND","find_in_set(questions.questionknowsid,:questionknowsid)",'questionknowsid',$search['knowsids']);
				}
				if($search['stime'])
				{
					$args[] = array("AND","questions.questioncreatetime >= :questioncreatetime",'questioncreatetime',strtotime($search['stime']));
				}
				if($search['etime'])
				{
					$args[] = array("AND","questions.questioncreatetime <= :questioncreatetime",'questioncreatetime',strtotime($search['etime']));
				}
				if($search['questiontype'])
				{
					$args[] = array("AND","questions.questiontype = :questiontype",'questiontype',$search['questiontype']);
				}
				if($search['questionlevel'])
				{
					$args[] = array("AND","questions.questionlevel = :questionlevel",'questionlevel',$search['questionlevel']);
				}
				if($search['questionknowsid'])
				{
					$args[] = array("AND","quest2knows.qkknowsid = :qkknowsid",'qkknowsid',$search['questionknowsid']);
				}
				else
				{
					$tmpknows = '0';
					if($search['questionsectionid'])
					{
						$knows = $this->section->getKnowsListByArgs(array(array("AND","knowsstatus = 1"),array("AND","knowssectionid = :knowssectionid",'knowssectionid',$search['questionsectionid'])));
						foreach($knows as $p)
						{
							if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
						}
						$args[] = array("AND","find_in_set(quest2knows.qkknowsid,:qkknowsid)",'qkknowsid' ,$tmpknows);
					}
					elseif($search['questionsubjectid'])
					{
						$knows = $this->section->getAllKnowsBySubject($search['questionsubjectid']);
						foreach($knows as $p)
						{
							if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
						}
						$args[] = array("AND","find_in_set(quest2knows.qkknowsid,:qkknowsid)",'qkknowsid',$tmpknows);
					}
					else
					{
						$knows = $this->section->getAllKnowsBySubjects($this->teachsubjects);
						foreach($knows as $p)
						{
							if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
						}
						$args[] = array("AND","find_in_set(quest2knows.qkknowsid,:qkknowsid)",'qkknowsid',$tmpknows);
					}
				}
				$questions = $this->exam->getQuestionsList($page,10,$args);
			}
			else
			{
				$args = array(array("AND","quest2knows.qkquestionid = questionrows.qrid"),array("AND","questionrows.qrstatus = '1'"));
				if($search['keyword'])
				{
					$args[] = array("AND","questionrows.qrquestion LIKE :qrquestion",'qrquestion','%'.$search['keyword'].'%');
				}
				if($search['questiontype'])
				{
					$args[] = array("AND","questionrows.qrtype = :qrtype",'qrtype',$search['questiontype']);
				}
				if($search['stime'])
				{
					$args[] = array("AND","questionrows.qrtime >= :qrtime",'qrtime',strtotime($search['stime']));
				}
				if($search['etime'])
				{
					$args[] = array("AND","questionrows.qrtime <= :qrtime",'qrtime',strtotime($search['etime']));
				}
				if($search['qrlevel'])
				{
					$args[] = array("AND","questionrows.qrlevel = :qrlevel",'qrlevel',$search['qrlevel']);
				}
				if($search['questionknowsid'])
				{
					$args[] = array("AND","quest2knows.qkknowsid = :qkknowsid",'qkknowsid',$search['questionknowsid']);
				}
				else
				{
					$tmpknows = '0';
					if($search['questionsectionid'])
					{
						$knows = $this->section->getKnowsListByArgs(array(array("AND","knowsstatus = 1"),array("AND","knowssectionid = :knowssectionid",'knowssectionid',$search['questionsectionid'])));
						foreach($knows as $p)
						{
							if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
						}
						$args[] = array("AND","find_in_set(quest2knows.qkknowsid,:qkknowsid)",'qkknowsid' ,$tmpknows);
					}
					elseif($search['questionsubjectid'])
					{
						$knows = $this->section->getAllKnowsBySubject($search['questionsubjectid']);
						foreach($knows as $p)
						{
							if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
						}
						$args[] = array("AND","find_in_set(quest2knows.qkknowsid,:qkknowsid)",'qkknowsid',$tmpknows);
					}
					else
					{
						$knows = $this->section->getAllKnowsBySubjects($this->teachsubjects);
						foreach($knows as $p)
						{
							if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
						}
						$args[] = array("AND","find_in_set(quest2knows.qkknowsid,:qkknowsid)",'qkknowsid',$tmpknows);
					}
				}
				$questions = $this->exam->getQuestionrowsList($page,10,$args);
			}
			if($useframe)$questions['pages'] = str_replace('&useframe=1','',$questions['pages']);
			$questypes = $this->basic->getQuestypeList();
			$sections = $this->section->getSectionListByArgs("sectionsubjectid = '{$search['questionsubjectid']}'");
			$knows = $this->section->getKnowsListByArgs(array("knowsstatus = 1","knowssectionid = '{$search['questionsectionid']}'"));
			$this->tpl->assign('subjects',$subjects);
			$this->tpl->assign('sections',$sections);
			$this->tpl->assign('knows',$knows);
			$this->tpl->assign('questypes',$questypes);
			$this->tpl->assign('questiontype',$search['questiontype']);
			$this->tpl->assign('questions',$questions);
			$this->tpl->assign('useframe',$useframe);
			$this->tpl->display('selectquestions');
			break;

			case 'modify':
			if($this->ev->get('submitsetting'))
			{
				$examid = $this->ev->get('examid');
				$args = $this->ev->get('args');
				$args['examsetting'] = $args['examsetting'];
				$args['examquestions'] = $args['examquestions'];
				$this->exam->modifyExamSetting($examid,$args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-teach-exams&page={$page}{$u}"
				);
				exit(json_encode($message));
			}
			else
			{
				$examid = $this->ev->get('examid');
				$exam = $this->exam->getExamSettingById($examid);
				$subjects = $this->basic->getSubjectList("subjectid IN ({$this->teachsubjects})");
				$questypes = $this->basic->getQuestypeList();
				foreach($exam['examquestions'] as $key => $p)
				{
					$exam['examnumber'][$key] = $this->exam->getExamQuestionNumber($p);
				}
				$this->tpl->assign('search',$search);
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->assign('exam',$exam);
				$this->tpl->assign('questypes',$questypes);
				if($exam['examtype'] == 1)
				$this->tpl->display('exams_modifyauto');
				else
				$this->tpl->display('exams_modifyself');
			}
			break;

			//考试设置列表
			default:
			$page = $this->ev->get('page');
			$page = $page > 0?$page:1;
			$args = array(array('AND','find_in_set(examsubject,:examsubject)','examsubject',$this->teachsubjects));
			if($search)
			{
				if($search['examsubject'])$args[] = array('AND',"examsubject = :examsubject",'examsubject',$search['examsubject']);
				if($search['examtype'])$args[] = "examtype = '{$search['examtype']}'";
			}
			if(!count($args))$args = 1;
			$exams = $this->exam->getExamSettingList($page,10,$args);
			$subjects = $this->basic->getSubjectList("subjectid IN ({$this->teachsubjects})");
			$this->tpl->assign('subjects',$subjects);
			$this->tpl->assign('exams',$exams);
			$this->tpl->display('exams');
		}
	}

	public function users()
	{
		$subaction = $this->ev->url(3);
		$search = $this->ev->get('search');
		$u = '';
		if($search)
		{
			$this->tpl->assign('search',$search);
			foreach($search as $key => $arg)
			{
				$u .= "&search[{$key}]={$arg}";
			}
		}
		$this->tpl->assign('u',$u);
		$page = $this->ev->get('page');
		if($page < 1)$page = 1;
		$this->tpl->assign('page',$page);
		switch($subaction)
		{
			case 'stats':
			$args = array();
			$basicid = $this->ev->get('basicid');
			$type = $this->ev->get('type');
			$this->tpl->assign('type',$type);
			$args[] =  array('AND',"ehbasicid = :ehbasicid",'ehbasicid',$basicid);
			if($search['stime'])
			{
				$stime = strtotime($search['stime']);
				$args[] = array('AND',"ehstarttime >= :stime",'stime',$stime);
			}
			if($search['etime'])
			{
				$etime = strtotime($search['etime']);
				$args[] = array('AND',"ehstarttime <= :etime",'etime',$etime);
			}
			if($search['sscore'])
			{
				$args[] = array('AND',"ehscore >= :sscore",'sscore',$search['sscore']);
			}
			if($search['escore'])
			{
				$args[] = array('AND',"ehscore <= :escore",'escore',$search['escore']);
			}
			if($search['examid'])
			{
				$args[] = array('AND',"ehexamid = :ehexamid",'ehexamid',$search['examid']);
			}
			$rs = $this->favor->getStatsAllExamHistoryByArgs($args);
			$number = count($rs);
			$stats = array();
			if(!$type)
			{
				$os = array('A','B','C','D','E','F','G','H');
				$questiontype = $this->basic->getQuestypeList();
				foreach($rs as $p)
				{
					foreach($p['ehquestion']['questions'] as $questions)
					{
						foreach($questions as $key => $question)
						{
							$stats[$question['questionid']]['title'] = $question['question'];
							$stats[$question['questionid']]['id'] = $question['questionid'];
							if($p['ehscorelist'][$question['questionid']] > 0)
							$stats[$question['questionid']]['right'] = intval($stats[$question['questionid']]['right']) + 1;
							$stats[$question['questionid']]['number'] = intval($stats[$question['questionid']]['number']) + 1;
							if($p['ehuseranswer'][$question['questionid']] && $questiontype[$question['questiontype']]['questsort'] == 0 && $questiontype[$question['questiontype']]['questchoice'] < 5)
							{
								foreach($os as $o)
								{
									if(strpos($p['ehuseranswer'][$question['questionid']],$o) !== false)
									$stats[$question['questionid']][$o] = intval($stats[$question['questionid']][$o]) + 1;
								}
							}
						}
					}
					foreach($p['ehquestion']['questionrows'] as $questionrows)
					{
						foreach($questionrows as $questionrow)
						{
							foreach($questionrow['data'] as $key => $question)
							{
								if(!$key)
								{
									$stats[$question['questionid']]['title'] = $questionrow['qrquestion'].'<br />'.$question['question'];
								}
								$stats[$question['questionid']]['id'] = $question['questionid'];
								if($p['ehscorelist'][$question['questionid']] > 0)
								$stats[$question['questionid']]['right'] = intval($stats[$question['questionid']]['right']) + 1;
								$stats[$question['questionid']]['number'] = intval($stats[$question['questionid']]['number']) + 1;
								if($p['ehuseranswer'][$question['questionid']] && $questiontype[$question['questiontype']]['questsort'] == 0 && $questiontype[$question['questiontype']]['questchoice'] < 5)
								{
									foreach($os as $o)
									{
										if(strpos($p['ehuseranswer'][$question['questionid']],$o) !== false)
										$stats[$question['questionid']][$o] = intval($stats[$question['questionid']][$o]) + 1;
									}
								}
							}
						}
					}
				}
				ksort($stats);
				$start = $page - 1;
				$start = $start >= 0?$start:0;
				$tmp = array_slice($stats,$start * 20,20);
				$pages = $this->pg->outPage($this->pg->getPagesNumber(count($stats),20),$page);
				$this->tpl->assign('stats',array('data' => $tmp,'pages' => $pages));
				$this->tpl->assign('basicid',$basicid);
				$this->tpl->display('users_stats');
			}
			else
			{
				foreach($rs as $p)
				{
					foreach($p['ehquestion']['questions'] as $questions)
					{
						foreach($questions as $key => $question)
						{
							foreach($question['questionknowsid'] as $knows)
							{
								$stats[$knows['knowsid']]['knowsid'] = $knows['knowsid'];
								$stats[$knows['knowsid']]['knows'] = $knows['knows'];
								$stats[$knows['knowsid']]['number'] = intval($stats[$knows['knowsid']]['number']) + 1;
								if($p['ehscorelist'][$question['questionid']] > 0)
								$stats[$knows['knowsid']]['right'] = intval($stats[$knows['knowsid']]['right']) + 1;
							}
						}
					}
					foreach($p['ehquestion']['questionrows'] as $questionrows)
					{
						foreach($questionrows as $questionrow)
						{
							foreach($questionrow['data'] as $key => $question)
							{

								foreach($questionrow['qrknowsid'] as $knows)
								{
									$stats[$knows['knowsid']]['knowsid'] = $knows['knowsid'];
									$stats[$knows['knowsid']]['knows'] = $knows['knows'];
									$stats[$knows['knowsid']]['number'] = intval($stats[$knows['knowsid']]['number']) + 1;
									if($p['ehscorelist'][$question['questionid']] > 0)
									$stats[$knows['knowsid']]['right'] = intval($stats[$knows['knowsid']]['right']) + 1;
								}
							}
						}
					}
				}
				ksort($stats);
				$start = $page - 1;
				$start = $start >= 0?$start:0;
				$tmp = array_slice($stats,$start * 20,20);
				$pages = $this->pg->outPage($this->pg->getPagesNumber(count($stats),20),$page);
				$this->tpl->assign('stats',array('data' => $tmp,'pages' => $pages));
				$this->tpl->assign('basicid',$basicid);
				$this->tpl->display('users_knowsstats');
			}
			break;

			case 'outscore':
			$args = array();
			$basicid = $this->ev->get('basicid');
			if($basicid)
			{
				$fname = 'data/score/'.TIME.'-'.$basicid.'-score.csv';
				$args[] =  array('AND',"ehbasicid = :ehbasicid",'ehbasicid',$basicid);
				if($search['stime'])
				{
					$stime = strtotime($search['stime']);
					$args[] = array('AND',"ehstarttime >= :stime",'stime',$stime);
				}
				if($search['etime'])
				{
					$etime = strtotime($search['etime']);
					$args[] = array('AND',"ehstarttime <= :etime",'etime',$etime);
				}
				if($search['sscore'])
				{
					$args[] = array('AND',"ehscore >= :sscore",'sscore',$search['sscore']);
				}
				if($search['escore'])
				{
					$args[] = array('AND',"ehscore <= :escore",'escore',$search['escore']);
				}
				if($search['examid'])
				{
					$args[] = array('AND',"ehexamid = :ehexamid",'ehexamid',$search['examid']);
				}
				$rs = $this->favor->getAllExamHistoryByArgs($args,array('ehusername','ehscore','usertruename'));
				$r = array();
				foreach($rs as $p)
				{
					$r[] = array('ehusername' => iconv("UTF-8","GBK",$p['ehusername']),'usertruename' => iconv("UTF-8","GBK",$p['usertruename']),'ehscore' => $p['ehscore']);
				}
				if($this->files->outCsv($fname,$r))
				$message = array(
					'statusCode' => 200,
					"message" => "成绩导出成功，转入下载页面，如果浏览器没有相应，请<a href=\"{$fname}\">点此下载</a>",
				    "callbackType" => 'forward',
				    "forwardUrl" => "{$fname}"
				);
				else
				$message = array(
					'statusCode' => 300,
					"message" => "成绩导出失败"
				);
			}
			else
			$message = array(
				'statusCode' => 300,
				"message" => "请选择好考场"
			);
			exit(json_encode($message));
			break;

			case 'readpaper':
			$ehid = $this->ev->get('ehid');
			$eh = $this->favor->getExamHistoryById($ehid);
			$questype = $this->basic->getQuestypeList();
			$sessionvars = array('examsession'=>$eh['ehexam'],'examsessionscore'=>$eh['ehscore'],'examsessionscorelist'=>$eh['ehscorelist'],'examsessionsetting'=>$eh['ehsetting'],'examsessionquestion'=>$eh['ehquestion'],'examsessionuseranswer'=>$eh['ehuseranswer']);
			$this->tpl->assign('eh',$eh);
			$this->tpl->assign('user',$this->user->getUserById($eh['ehuserid']));
			$this->tpl->assign('sessionvars',$sessionvars);
			$this->tpl->assign('questype',$questype);
			$this->tpl->display('exam_view');
			break;

			//计算主观题分数和显示分数
			case 'makescore':
			$questype = $this->basic->getQuestypeList();
			$ehid = $this->ev->get('ehid');
			$sessionvars = $this->favor->getExamHistoryById($ehid);
			if($this->ev->get('makescore'))
			{
				$score = $this->ev->get('score');
				$sumscore = 0;
				if(is_array($score))
				{
					foreach($score as $key => $p)
					{
						$sessionvars['ehscorelist'][$key] = $p;
					}
				}
				foreach($sessionvars['ehscorelist'] as $p)
				{
					$sumscore = $sumscore + floatval($p);
				}
				$sessionvars['ehscore'] = $sumscore;
				$args['ehscorelist'] = $sessionvars['ehscorelist'];
				$allnumber = floatval(count($sessionvars['ehscorelist']));
				$args['ehscore'] = $sessionvars['ehscore'];
				$args['ehstatus'] = 1;
				$this->favor->modifyExamHistory($args,$ehid);
				$message = array(
					'statusCode' => 200,
					"message" => "评分完成",
				    "forwardUrl" => "index.php?exam-teach-users-exams&basicid={$sessionvars['ehbasicid']}"
				);
				exit(json_encode($message));
			}
			else
			{
				$message = array(
					'statusCode' => 300,
					"message" => "非法参数"
				);
				exit(json_encode($message));
				$number = array();
				$right = array();
				$score = array();
				$allnumber = 0;
				$allright = 0;
				foreach($questype as $key => $q)
				{
					$number[$key] = 0;
					$right[$key] = 0;
					$score[$key] = 0;
					if($sessionvars['ehquestion']['questions'][$key])
					{
						foreach($sessionvars['ehquestion']['questions'][$key] as $p)
						{
							$number[$key]++;
							$allnumber++;
							if($sessionvars['ehscorelist'][$p['questionid']] == $sessionvars['ehsetting']['examsetting']['questype'][$key]['score'])
							{
								$right[$key]++;
								$allright++;
							}
							$score[$key] = $score[$key]+$sessionvars['ehscorelist'][$p['questionid']];
						}
					}
					if($sessionvars['ehquestion']['questionrows'][$key])
					{
						foreach($sessionvars['ehquestion']['questionrows'][$key] as $v)
						{
							foreach($v['data'] as $p)
							{
								$number[$key]++;
								$allnumber++;
								if($sessionvars['ehscorelist'][$p['questionid']] == $sessionvars['ehsetting']['examsetting']['questype'][$key]['score'])
								{
									$right[$key]++;
									$allright++;
								}
								$score[$key] = $score[$key]+$sessionvars['ehscorelist'][$p['questionid']];
							}
						}
					}
				}
				$this->tpl->assign('ehid',$ehid);
				$this->tpl->assign('allright',$allright);
				$this->tpl->assign('allnumber',$allnumber);
				$this->tpl->assign('right',$right);
				$this->tpl->assign('score',$score);
				$this->tpl->assign('number',$number);
				$this->tpl->assign('questype',$questype);
				$this->tpl->assign('sessionvars',$sessionvars);
				$this->tpl->display('exam_score');
			}
			break;

			case 'score':
			$ehid = $this->ev->get('ehid');
			$sessionvars = $this->favor->getExamHistoryById($ehid);
			$questype = $this->basic->getQuestypeList();
			$this->tpl->assign('ehid',$ehid);
			$this->tpl->assign('sessionvars',$sessionvars);
			$this->tpl->assign('questype',$questype);
			$this->tpl->display('users_decide');
			break;

			case 'scorelist':
			$page = $this->ev->get('page');
			$basicid = intval($this->ev->get('basicid'));
			$basic = $this->basic->getBasicById($basicid);
			$page = $page > 0?$page:1;
			$args = array();
			$args[] = array('AND',"ehtype = '2'");
			$args[] = array('AND',"ehstatus = '1'");
			$args[] = array('AND',"ehbasicid = :ehbasicid",'ehbasicid',$basicid);
			if($search['stime'])
			{
				$stime = strtotime($search['stime']);
				$args[] = array('AND',"ehstarttime >= :stime",'stime',$stime);
			}
			if($search['etime'])
			{
				$etime = strtotime($search['etime']);
				$args[] = array('AND',"ehstarttime <= :etime",'etime',$etime);
			}
			if($search['sscore'])
			{
				$args[] = array('AND',"ehscore >= :sscore",'sscore',$search['sscore']);
			}
			if($search['escore'])
			{
				$args[] = array('AND',"ehscore <= :escore",'escore',$search['escore']);
			}
			if($search['examid'])
			{
				$args[] = array('AND',"ehexamid = :ehexamid",'ehexamid',$search['examid']);
			}
			$exams = $this->favor->getExamHistoryListByArgs($page,30,$args);
			$ids = trim($basic['basicexam']['self'],', ');
			if(!$ids)$ids = '0';
			$exampaper = $this->exam->getExamSettingsByArgs(array(array("AND","find_in_set(examid,:examid)",'examid',$ids)));
			$this->tpl->assign('basicid',$basicid);
			$this->tpl->assign('basic',$basic);
			$this->tpl->assign('page',$page);
			$this->tpl->assign('exampaper',$exampaper);
			$this->tpl->assign('exams',$exams);
			$this->tpl->display('users_scorelist');
			break;

			case 'exams':
			$page = $this->ev->get('page');
			$basicid = intval($this->ev->get('basicid'));
			$page = $page > 0?$page:1;
			$exams = $this->favor->getExamHistoryListByArgs($page,10,array(array('AND',"ehstatus = '0'"),array('AND',"ehbasicid = :ehbasicid",'ehbasicid',$basicid)));
			$this->tpl->assign('page',$page);
			$this->tpl->assign('exams',$exams);
			$this->tpl->display('users_history');
			break;

			default:
			$page = $this->ev->get('page');
			$page = $page > 1?$page:1;
			$subjects = $this->basic->getSubjectList(array(array('AND',"find_in_set(subjectid,:subjectid)",'subjectid',$this->teachsubjects)));
			$args = array(array('AND',"find_in_set(basicsubjectid,:basicsubjectid)",'basicsubjectid',$this->teachsubjects));
			if($search['basicid'])$args[] = array('AND',"basicid = :basicid",'basicid',$search['basicid']);
			else
			{
				if($search['keyword'])$args[] = array('AND',"basic LIKE :basic",'basic',"%{$search['keyword']}%");
				if($search['basicareaid'])$args[] = array('AND',"basicareaid = :basicareaid",'basicareaid',$search['basicareaid']);
				if($search['basicsubjectid'])$args[] = array('AND',"basicsubjectid = :basicsubjectid",'basicsubjectid',$search['basicsubjectid']);
				if($search['basicapi'])$args[] = array('AND',"basicapi = :basicapi",'basicapi',$search['basicapi']);
			}
			$basics = $this->basic->getBasicList($page,10,$args);
			$areas = $this->area->getAreaList();
			$this->tpl->assign('areas',$areas);
			$this->tpl->assign('subjects',$subjects);
			$this->tpl->assign('basics',$basics);
			$this->tpl->display('users_basic');
			break;
		}
	}
}

?>