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
		$this->user = $this->G->make('user','user');
		$this->_user = $_user = $this->session->getSessionUser();
		$group = $this->user->getGroupById($_user['sessiongroupid']);
		if($group['groupmoduleid'] != 1)
		{
			if($this->ev->get('userhash'))
			exit(json_encode(array(
				'statusCode' => 300,
				"message" => "请您重新登录",
			    "callbackType" => 'forward',
			    "forwardUrl" => "index.php?core-master-login"
			)));
			else
			{
				header("location:?core-master-login");
				exit;
			}
		}
		//生产一个对象
		$this->tpl = $this->G->make('tpl');
		$this->sql = $this->G->make('sql');
		$this->pdosql = $this->G->make('pdosql');
		$this->db = $this->G->make('pepdo');
		$this->pg = $this->G->make('pg');
		$this->html = $this->G->make('html');
		$this->apps = $this->G->make('apps','core');
		$this->attach = $this->G->make('attach','document');
		$this->tpl->assign('userhash',$this->ev->get('userhash'));
		$localapps = $this->apps->getLocalAppList();
		$apps = $this->apps->getAppList();
		$this->tpl->assign('localapps',$localapps);
		$this->tpl->assign('apps',$apps);
		$this->tpl->assign('_user',$this->user->getUserById($_user['sessionuserid']));
	}

	public function attachtype()
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
			//删除附件类型
			case 'del':
			$page = $this->ev->get('page');
			$atid = $this->ev->get('atid');
			$this->attach->delAttachtypeById($atid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?document-master-attachtype&page={$page}{$u}"
			);
			$this->G->R($message);
			break;

			//删除附件类型
			case 'batdel':
			$page = $this->ev->get('page');
			$delids = $this->ev->get('delids');
			foreach($delids as $atid)
			$this->attach->delAttachtypeById($atid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?document-master-attachtype&page={$page}{$u}"
			);
			$this->G->R($message);
			break;

			case 'modify':
			$page = $this->ev->get('page');
			$atid = $this->ev->get('atid');
			if($this->ev->get('modifyattachtype'))
			{
				$args = $this->ev->get('args');
				$this->attach->modifyAttachtypeById($args,$atid);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?document-master-attachtype&page={$page}{$u}"
				);
				$this->G->R($message);
			}
			else
			{
				$attachtype = $this->attach->getAttachtypeById($atid);
				$this->tpl->assign('attachtype',$attachtype);
				$this->tpl->display('types_modify');
			}
			break;

			case 'add':
			if($this->ev->get('inserttype'))
			{
				$args = $this->ev->get('args');
				$id = $this->attach->addAttachtype($args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?document-master-attachtype{$u}"
				);
				$this->G->R($message);
			}
			else
			{
				$this->tpl->display('types_add');
			}
			break;

			default:
			$types = $this->attach->getAttachtypeList();
			$this->tpl->assign('types',$types);
			$this->tpl->display('types');
			break;
		}
	}

	public function index()
	{
		$this->tpl->display('index');
	}

	public function files()
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
			//删除附件
			case 'del':
			$page = $this->ev->get('page');
			$attid = $this->ev->get('attid');
			$this->attach->delAttach($attid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "reload"
			);
			$this->G->R($message);
			break;

			//批量删除附件
			case 'batdel':
			$page = $this->ev->get('page');
			$delids = $this->ev->get('delids');
			foreach($delids as $attid => $p)
			$this->attach->delAttach($attid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "reload"
			);
			$this->G->R($message);
			break;

			//编辑附件
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
					"forwardUrl" => "index.php?exam-master-questions&page={$page}{$u}"
				);
				else
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-questions&page={$page}{$u}"
				);
				$this->G->R($message);
			}
			else
			{
				$page = $this->ev->get('page');
				$questionparent = $this->ev->get('questionparent');
				$knowsid = $this->ev->get('knowsid');
				$questionid = $this->ev->get('questionid');
				$questypes = $this->basic->getQuestypeList();
				$question = $this->exam->getQuestionByArgs("questionid = '{$questionid}'");
				$subjects = $this->basic->getSubjectList();
				foreach($question['questionknowsid'] as $key => $p)
				{
					$knows = $this->section->getKnowsByArgs("knowsid = '{$p['knowsid']}'");
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

			case 'detail':
			$questionid = $this->ev->get('questionid');
			$questionparent = $this->ev->get('questionparent');
			if($questionparent)
			{
				$questions = $this->exam->getQuestionByArgs("questionparent = '{$questionparent}'");
			}
			else
			{
				$question = $this->exam->getQuestionByArgs("questionid = '{$questionid}'");
				$sections = array();
				foreach($question['questionknowsid'] as $key => $p)
				{
					$knows = $this->section->getKnowsByArgs("knowsid = '{$p['knowsid']}'");
					$question['questionknowsid'][$key]['knows'] = $knows['knows'];
					$sections[] = $this->section->getSectionByArgs("sectionid = '{$knows['knowssectionid']}'");
				}
				$subject = $this->basic->getSubjectById($sections[0]['sectionsubjectid']);
			}
			$this->tpl->assign("subject",$subject);
			$this->tpl->assign("sections",$sections);
			$this->tpl->assign("question",$question);
			$this->tpl->assign("questions",$questions);
			$this->tpl->display('question_detail');
			break;

			//附件列表（可根据条件进行查询）
			default:
			$page = $this->ev->get('page');
			$page = $page > 0?$page:1;
			$types = $this->attach->getAttachtypeList();
			$args = array();
			if($search['attid'])
			{
				$args[] = array('AND',"attid = :attid",'attid',$search['attid']);
			}
			if($search['stime'])
			{
				$args[] = array('AND',"attinputtime >= :attinputtime",'attinputtime',strtotime($search['stime']));
			}
			if($search['etime'])
			{
				$args[] = array('AND',"attinputtime <= :attinputtime",'attinputtime',strtotime($search['etime']));
			}
			if($search['atttype'])
			{
				$exts = implode(',',explode(',',$types[$search['atttype']]['attachexts']));
				if($exts)
				$args[] = array('AND',"find_in_set(attext,:attext)",'attext',$exts);
			}
			if($search['username'])
			{
				$user = $this->user->getUserByUserName($search['username']);
				if($user)
				$args[] = array('AND',"attuserid = :attuserid",'attuserid',$user['userid']);
			}
			$attach = $this->attach->getAttachList($args,$page);
			$this->tpl->assign('attachtypes',$types);
			$this->tpl->assign('attach',$attach);
			$this->tpl->display('attachs');
		}
	}
}

?>