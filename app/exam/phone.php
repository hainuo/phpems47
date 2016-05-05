<?php

class app
{
	public $G;
	public $data = array();
	public $sessionvars;

	public function __construct(&$G)
	{
		$this->G = $G;
		$this->ev = $this->G->make('ev');
		$this->tpl = $this->G->make('tpl');
		$this->sql = $this->G->make('sql');
		$this->db = $this->G->make('pepdo');
		$this->pg = $this->G->make('pg');
		$this->html = $this->G->make('html');
		$this->session = $this->G->make('session');
		$this->_user = $this->session->getSessionUser();
		if(!$this->_user['sessionuserid'])
		{
			if($this->ev->get('userhash'))
			exit(json_encode(array(
				'statusCode' => 300,
				"message" => "请您重新登录",
			    "callbackType" => 'forward',
			    "forwardUrl" => "index.php?user-phone-login"
			)));
			else
			{
				header("location:index.php?user-phone-login");
				exit;
			}
		}
		$this->user = $this->G->make('user','user');
		$this->exam = $this->G->make('exam','exam');
		$this->basic = $this->G->make('basic','exam');
		$this->section = $this->G->make('section','exam');
		$this->question = $this->G->make('question','exam');
		$this->favor = $this->G->make('favor','exam');
		$this->sessionvars = $this->exam->getExamSessionBySessionid();
		$this->questypes = $this->basic->getQuestypeList();
		$this->subjects = $this->basic->getSubjectList();
		$openbasics = trim($this->sessionvars['examsessionopenbasics']," ,");
		$this->data['openbasics'] = $this->basic->getBasicsByApi($openbasics);
		if(!$this->data['openbasics'])$this->data['openbasics'] = $this->basic->getOpenBasicsByUserid($this->_user['sessionuserid']);
		//if(!$this->data['openbasics'])$this->data['openbasics'] = $this->basic->getBasicsByArgs(array(array("AND","basicdemo = 1")));
		if(!$this->_user['sessioncurrent'] || !$this->data['openbasics'][$this->_user['sessioncurrent']])
		{
			$this->data['currentbasic'] = current($this->data['openbasics']);
			$this->_user['sessioncurrent'] = $this->data['currentbasic']['basicid'];
			$this->session->setSessionValue(array('sessioncurrent'=>$this->_user['sessioncurrent']));
		}
		else
		$this->data['currentbasic'] = $this->data['openbasics'][$this->_user['sessioncurrent']];
		$this->selectorder = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N');
		$this->tpl->assign('ols',array(1=>'一','二','三','四','五','六','七','八','九','十','十一','十二','十三','十四','十五','十六','十七','十八','十九','二十'));
		$this->tpl->assign('selectorder',$this->selectorder);
		//$this->tpl->assign('data',&$this->data);
		$this->tpl->assign('data',$this->data);
		$this->tpl->assign('questypes',$this->questypes);
		$this->tpl->assign('subjects',$this->subjects);
		$this->tpl->assign('globalsections',$this->section->getSectionListByArgs(array(array("AND","sectionsubjectid = :sectionsubjectid",'sectionsubjectid',$this->data['currentbasic']['basicsubjectid']))));
		$this->tpl->assign('globalknows',$this->section->getAllKnowsBySubject($this->data['currentbasic']['basicsubjectid']));
		$this->tpl->assign('_user',$this->user->getUserById($this->_user['sessionuserid']));
		$this->tpl->assign('userhash',$this->ev->get('userhash'));
	}

	public function basics()
	{
		$action = $this->ev->url(3);
		$page = $this->ev->get('page');
		switch($action)
		{
			default:
			if(!$this->data['openbasics'])exit(header("location:index.php?exam-app"));
			$sessionvars = $this->exam->getExamSessionBySessionid();
			if($sessionvars && $sessionvars['examsessionbasic']== $this->_user['sessioncurrent'] && $sessionvars['examsessionstatus'] < 2 && $sessionvars['examsessiontype'] == 2 && ($sessionvars['examsessionstarttime']+$sessionvars['examsessiontime']*60 - TIME))
			$this->tpl->assign('sessionvars',$sessionvars);
			$this->tpl->display('basics');
		}
	}
	//首页
	public function index()
	{
		$action = $this->ev->url(3);
		switch($action)
		{
			case 'setCurrentBasic':
			$basicid = $this->ev->get('basicid');
			$this->session->setSessionValue(array('sessioncurrent'=>$basicid));
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
			    "callbackType" => 'forward',
			    "forwardUrl" => "index.php?exam-phone-basics"
			);
			$this->G->R($message);
			break;

			case 'ajax':
			switch($this->ev->url(4))
			{
				//根据章节获取知识点信息
				case 'getknowsbysectionid':
				$sectionid = $this->ev->get('sectionid');
				$knowsids = trim(implode(",",$this->data['currentbasic']['basicknows'][$sectionid]),", ");
				$aknows = $this->section->getKnowsListByArgs(array(array("AND","find_in_set(knowsid,:knowsid)",'knowsid',$knowsids),array("AND","knowsstatus = 1")));
				if($sectionid)
				$data = '<option value="0">选择知识点</option>'."\n";
				else
				$data = '<option value="0">请先选择章节</option>'."\n";
				foreach($aknows as $knows)
				{
					$data .= '<option value="'.$knows['knowsid'].'">'.$knows['knows'].'</option>'."\n";
				}
				exit($data);
				break;

				//获取剩余时间
				case 'lefttime':
				$sessionvars = $this->exam->getExamSessionBySessionid();
				$lefttime = TIME - $sessionvars['examsessionstarttime'];
				if($lefttime < 0 )$lefttime = 0;
				exit("{$lefttime}");
				break;

				//根据科目获取章节信息
				case 'getsectionsbysubjectid':
				$esid = $this->ev->get('subjectid');
				$knowsids = trim(implode(",",$this->data['currentbasic']['basicknows'][$sectionid]),", ");
				$aknows = $this->section->getSectionListByArgs(array(array("AND","sectionsubjectid = :sectionsubjectid",'sectionsubjectid',$esid)));
				$data = array(array(0,'选择章节'));
				foreach($aknows as $knows)
				{
					$data[] = array($knows['sectionid'],$knows['section']);
				}
				exit(json_encode($data));
				break;

				//标注题目
				case 'sign':
				$questionid = intval($this->ev->get('questionid'));
				$url = $this->G->make('strings')->destr($this->ev->get('url'));
				$sessionvars = $this->exam->getExamSessionBySessionid();
				$args['examsessionsign'] = $sessionvars['examsessionsign'];
				if($questionid && !$args['examsessionsign'][$questionid])
				{
					$args['examsessionsign'][$questionid] = 1;
					$args['examsessionsign'] = $this->ev->addSlashes($args['examsessionsign']);
					$this->exam->modifyExamSession($args);
					exit('1');
				}
				else
				{
					unset($args['examsessionsign'][$questionid]);
					$args['examsessionsign'] = $this->ev->addSlashes($args['examsessionsign']);
					$this->exam->modifyExamSession($args);
					exit('2');
				}
				break;

				default:
			}
			break;

			default:
			$this->tpl->assign('basics',$this->data['openbasics']);
			$this->tpl->display('index');
			break;
		}
	}

	public function score()
	{
		$page = $this->ev->get('page');
		$page = $page < 1?1:$page;
		$scores = $this->favor->getExamScoreListByBasicId($this->data['currentbasic']['basicid'],$page);
		$this->tpl->assign('page',$page);
		$this->tpl->assign('scores',$scores);
		$this->tpl->display('scores');
	}

	//强化训练
	public function exercise()
	{
		$action = $this->ev->url(3);
		switch($action)
		{
			//重新抽题
			case 'reload':
			$args = array('examsessionkey' => 0);
			$this->exam->modifyExamSession($args);
			header("location:index.php?exam-phone-exercise");
			exit;
			break;

			case 'ajax':
			switch($this->ev->url(4))
			{
				//获取剩余考试时间
				case 'getexamlefttime':
				$sessionvars = $this->exam->getExamSessionBySessionid();
				$lefttime = 0;
				if($sessionvars['examsessionstatus'] == 0 && $sessionvars['examsessiontype'] == 1)
				{
					if(TIME > ($sessionvars['examsessionstarttime'] + $sessionvars['examsessiontime']*60))
					{
						$lefttime = $sessionvars['examsessiontime']*60;
					}
					else
					{
						$lefttime = TIME - $sessionvars['examsessionstarttime'];
					}
				}
				echo $lefttime;
				exit();
				break;

				case 'getQuestionNumber':
				$questype = $this->basic->getQuestypeList();
				$sectionid = $this->ev->get('sectionid');
				$knowids = $this->ev->get('knowsid');
				if(!$knowids)
				{
					if(!$sectionid)$knows = $this->section->getAllKnowsBySubject($this->data['currentsubject']['subjectid']);
					else
					$knows = $this->section->getKnowsListByArgs(array(array("AND","knowssectionid = :knowssectionid",'knowssectionid',$sectionid),array("AND","knowsstatus = 1")));
					foreach($knows as $key => $p)
					$knowids .= "{$key},";
					$knowids = trim($knowids," ,");
				}
				$numbers = array();
				$numbers = array();
				foreach($questype as $p)
				{
					$numbers[$p['questid']] = intval(ceil($this->exam->getQuestionNumberByQuestypeAndKnowsid($p['questid'],$knowids)));
				}
				$this->tpl->assign('numbers',$numbers);
				$this->tpl->assign('questype',$questype);
				$this->tpl->display('exercise_number');
				break;

				case 'saveUserAnswer':
				$question = $this->ev->post('question');
				foreach($question as $key => $t)
				{
					if($t == '')unset($question[$key]);
				}
				$this->exam->modifyExamSession(array('examsessionuseranswer'=>$this->ev->addSlashes($question)));
				echo is_array($question)?count($question):0;
				exit;
				break;

				default:
			}
			break;

			//查看考试后的题目及答案
			case 'view':
			$sessionvars = $this->exam->getExamSessionBySessionid();
			if($sessionvars['examsessiontype'])
			{
				if($sessionvars['examsessiontype'] == 1)
				header("location:index.php?exam-phone-exampaper-view");
				else
				header("location:index.php?exam-phone-exam-view");
				exit;
			}
			$this->tpl->assign('questype',$this->basic->getQuestypeList());
			$this->tpl->assign('sessionvars',$sessionvars);
			$this->tpl->display('exercise_view');
			break;

			//计算主观题分数和显示分数
			case 'makescore':
			if($this->ev->get('makescore'))
			{
				$questype = $this->basic->getQuestypeList();
				$sessionvars = $this->exam->getExamSessionBySessionid();
				$score = $this->ev->get('score');
				$sumscore = 0;
				if(is_array($score))
				{
					foreach($score as $key => $p)
					{
						$sessionvars['examsessionscorelist'][$key] = $p;
					}
				}
				foreach($sessionvars['examsessionscorelist'] as $p)
				{
					$sumscore = $sumscore + floatval($p);
				}
				$sessionvars['examsessionscore'] = $sumscore;
				$args['examsessionscorelist'] = $sessionvars['examsessionscorelist'];
				$allnumber = floatval(count($sessionvars['examsessionscorelist']));
				$args['examsessionscore'] = floatval(($sessionvars['examsessionscore']*100)/$allnumber);
				$args['examsessionstatus'] = 2;
				$this->exam->modifyExamSession($args);
				$ehid = $this->favor->addExamHistory();
				if($this->ev->get('direct'))
				{
					header("location:index.php?exam-phone-exercise-makescore&ehid={$ehid}");
					exit;
				}
				else
				{
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功",
					    "callbackType" => 'forward',
					    "forwardUrl" => "index.php?exam-phone-exercise-makescore&ehid={$ehid}"
					);
					$this->G->R($message);
				}
			}
			else
			{
				$ehid = $this->ev->get('ehid');
				$eh = $this->favor->getExamHistoryById($ehid);
				$sessionvars = array(
					'examsession' => $eh['ehexam'],
					'examsessiontype'=> $eh['ehtype'] == 2?1:$eh['ehtype'],
					'examsessionsetting'=> $eh['ehsetting'],
					'examsessionbasic'=> $eh['ehbasicid'],
					'examsessionquestion'=> $eh['ehquestion'],
					'examsessionuseranswer'=>$eh['ehanswer'],
					'examsessiontime'=> $eh['ehtime'],
					'examsessionscorelist'=> $eh['ehscorelist'],
					'examsessionscore'=>$eh['ehscore'],
					'examsessionstarttime'=>$eh['ehstarttime']
				);

				$questype = $this->basic->getQuestypeList();
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
					if($sessionvars['examsessionquestion']['questions'][$key])
					{
						foreach($sessionvars['examsessionquestion']['questions'][$key] as $p)
						{
							$number[$key]++;
							$allnumber++;
							if($sessionvars['examsessionscorelist'][$p['questionid']] == 1)
							{
								$right[$key]++;
								$allright++;
							}
							$score[$key] = $score[$key]+$sessionvars['examsessionscorelist'][$p['questionid']];
						}
					}
					if($sessionvars['examsessionquestion']['questionrows'][$key])
					{
						foreach($sessionvars['examsessionquestion']['questionrows'][$key] as $v)
						{
							foreach($v['data'] as $p)
							{
								$number[$key]++;
								$allnumber++;
								if($sessionvars['examsessionscorelist'][$p['questionid']] == 1)
								{
									$right[$key]++;
									$allright++;
								}
								$score[$key] = $score[$key]+$sessionvars['examsessionscorelist'][$p['questionid']];
							}
						}
					}
				}
				$this->tpl->assign('ehid',$ehid);
				$this->tpl->assign('questype',$questype);
				$this->tpl->assign('allright',$allright);
				$this->tpl->assign('allnumber',$allnumber);
				$this->tpl->assign('right',$right);
				$this->tpl->assign('score',$score);
				$this->tpl->assign('number',$number);
				$this->tpl->assign('questype',$questype);
				$this->tpl->assign('sessionvars',$sessionvars);
				$this->tpl->display('exercise_score');
			}
			break;

			//评分和显示分数
			case 'score':
			$questype = $this->basic->getQuestypeList();
			$sessionvars = $this->exam->getExamSessionBySessionid();
			$needhand = 0;
			if($this->ev->get('insertscore'))
			{
				$question = $this->ev->get('question');
				foreach($question as $key => $a)
				$sessionvars['examsessionuseranswer'][$key] = $a;
				foreach($sessionvars['examsessionquestion']['questions'] as $key => $tmp)
				{
					if(!$questype[$key]['questsort'])
					{
						foreach($tmp as $p)
						{
							if(is_array($sessionvars['examsessionuseranswer'][$p['questionid']]))
							{
								$nanswer = '';
								$answer = $sessionvars['examsessionuseranswer'][$p['questionid']];
								asort($answer);
								$nanswer = implode("",$answer);
								if($nanswer == $p['questionanswer'])$score = 1;
								else
								{
									if($questype[$key]['questchoice'] == 3)
									{
										$alen = strlen($p['questionanswer']);
										$rlen = 0;
										foreach($answer as $t)
										{
											if(strpos($p['questionanswer'],$t) === false)
											{
												$rlen = 0;
												break;
											}
											else
											{
												$rlen ++;
											}
										}
										$score = floatval($rlen/$alen);
									}
									else $score = 0;
								}
							}
							else
							{
								$answer = $sessionvars['examsessionuseranswer'][$p['questionid']];
								if($answer == $p['questionanswer'])$score = 1;
								else $score = 0;
							}
							$scorelist[$p['questionid']] = $score;
						}
					}
					else
					{
						if(is_array($tmp) && count($tmp))
						$needhand = 1;
					}
				}
				foreach($sessionvars['examsessionquestion']['questionrows'] as $key => $tmp)
				{
					if(!$questype[$key]['questsort'])
					{
						foreach($tmp as $tmp2)
						{
							foreach($tmp2['data'] as $p)
							{
								if(is_array($sessionvars['examsessionuseranswer'][$p['questionid']]))
								{
									$answer = $sessionvars['examsessionuseranswer'][$p['questionid']];
									asort($answer);
									$nanswer = implode("",$answer);
									if($nanswer == $p['questionanswer'])$score = 1;
									else
									{
										if($questype[$key]['questchoice'] == 3)
										{
											$alen = strlen($p['questionanswer']);
											$rlen = 0;
											foreach($answer as $t)
											{
												if(strpos($p['questionanswer'],$t) === false)
												{
													$rlen = 0;
													break;
												}
												else
												{
													$rlen ++;
												}
											}
											$score = $rlen/$alen;
										}
										else $score = 0;
									}
								}
								else
								{
									$answer = $sessionvars['examsessionuseranswer'][$p['questionid']];
									if($answer == $p['questionanswer'])$score = 1;
									else $score = 0;
								}
								$scorelist[$p['questionid']] = $score;
							}
						}
					}
					else
					{
						if(!$needhand)
						{
							if(is_array($tmp) && count($tmp))
							$needhand = 1;
						}
					}
				}
				$args['examsessionuseranswer'] = $question;
				$args['examsessionscorelist'] = $scorelist;
				if(!$needhand)
				{
					$args['examsessionstatus'] = 2;
					$this->exam->modifyExamSession($args);
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功",
					    "callbackType" => 'forward',
					    "forwardUrl" => "index.php?exam-phone-exercise-makescore&makescore=1&direct=1"
					);
				}
				else
				{
					$args['examsessionstatus'] = 1;
					$this->exam->modifyExamSession($args);
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功",
					    "callbackType" => 'forward',
					    "forwardUrl" => "index.php?exam-phone-exercise-score"
					);
				}
				$this->G->R($message);
			}
			else
			{
				if($sessionvars['examsessionstatus'] == 2)
				{
					header("location:index.php?exam-phone-exercise-makescore");
					exit;
				}
				else
				{
					$this->tpl->assign('sessionvars',$sessionvars);
					$this->tpl->assign('questype',$questype);
					$this->tpl->display('exercise_mkscore');
				}
			}
			break;

			case 'paper':
			$sessionvars = $this->exam->getExamSessionBySessionid();
			$lefttime = 0;
			$questype = $this->basic->getQuestypeList();
			if($sessionvars['examsessionstatus'] == 2)
			{
				header("location:index.php?exam-phone-exercise-makescore&makescore=1&direct=1");
				exit;
			}
			elseif($sessionvars['examsessionstatus'] == 1)
			{
				header("location:index.php?exam-phone-exercise-score");
				exit;
			}
			else
			{
				$this->tpl->assign('questype',$questype);
				$this->tpl->assign('sessionvars',$sessionvars);
				$this->tpl->assign('lefttime',$lefttime);
				$this->tpl->assign('donumber',is_array($sessionvars['examsessionuseranswer'])?count($sessionvars['examsessionuseranswer']):0);
				$this->tpl->display('exercise_paper');
			}
			break;

			/**
			case 'selectquestions':
			$knowsid = $this->ev->get('knowsid');
			$knows = $this->section->getKnowsByArgs("knowsid = '{$knowsid}'");
			if(!$knows['knowsid'])header("location:index.php?exam-phone-exercise");
			$args = array('score'=>100,'examtime'=>60,'title'=>date('Y-m-d').$knows['knows']."知识点强化训练");
			$args['knowsid'] = $knowsid;
			$sessionvars = $this->exam->getExamSessionBySessionid();
			$questype = $this->basic->getQuestypeList();
			foreach($questype as $p)
			{
				$args['number'][$p['questid']] = rand(5,10);
			}
			arsort($args['number']);
			$dt = key($args['number']);
			$questionids = $this->question->selectQuestionsByKnows($args['knowsid'],$args['number'],$dt);
			$questions = array();
			$questionrows = array();
			foreach($questionids['question'] as $key => $p)
			{
				$ids = "";
				if(count($p))
				{
					foreach($p as $t)
					{
						$ids .= $t.',';
					}
					$ids = trim($ids," ,");
					if(!$ids)$ids = 0;
					$questions[$key] = $this->exam->getQuestionListByArgs("questionid IN ({$ids})");
				}
			}
			foreach($questionids['questionrow'] as $key => $p)
			{
				$ids = "";
				if(is_array($p))
				{
					if(count($p))
					{
						foreach($p as $t)
						{
							$questionrows[$key][$t] = $this->exam->getQuestionRowsByArgs("qrid = '{$t}'");
						}
					}
				}
				else $questionrows[$key][$p] = $this->exam->getQuestionRowsByArgs("qrid = '{$p}'");
			}
			$sargs['examsessionquestion'] = $this->ev->addSlashes(serialize(array('questionids'=>$questionids,'questions'=>$questions,'questionrows'=>$questionrows)));
			$sargs['examsessionsetting'] = $this->ev->addSlashes(serialize(array('examsetting' => $args)));
			$sargs['examsessionstarttime'] = TIME;
			$sargs['examsessionuseranswer'] = NULL;
			$sargs['examsession'] = $args['title'];
			$sargs['examsessiontime'] = $args['examtime']>0?$args['examtime']:60;
			$sargs['examsessionstatus'] = 0;
			$sargs['examsessiontype'] = 0;
			$sargs['examsessionbasic'] = $this->data['currentbasic']['basicid'];
			$sargs['examsessionkey'] = md5($args['knowsid']);
			$sargs['examsessionissave'] = 0;
			$sargs['examsessionsign'] = NULL;
			$sargs['examsessionscore'] = 0;
			$sargs['examsessionscorelist'] = '';
			if($sessionvars['examsessionid'])
			$this->exam->modifyExamSession($sargs);
			else
			$this->exam->insertExamSession($sargs);
			header("location:index.php?exam-phone-exercise-paper");
			break;

			//强化训练考试页面
			default:
			$sectionids = trim(implode(",",$this->data['currentbasic']['basicsection']),", ");
			$sections = $this->section->getSectionListByArgs("sectionid IN ({$sectionids})");
			$knows = array();
			foreach($this->data['currentbasic']['basicsection'] as $p)
			{
				$knowsids = trim(implode(",",$this->data['currentbasic']['basicknows'][$p]),", ");
				$knows[$p] = $this->section->getKnowsListByArgs(array("knowsid IN ({$knowsids})","knowsstatus = 1"));
			}
			$this->tpl->assign('sections',$sections);
			$this->tpl->assign('knows',$knows);
			$this->tpl->display('exercise');
			**/
			default:
			$questype = $this->basic->getQuestypeList();
			if($this->ev->get('setExecriseConfig'))
			{
				$args = $this->ev->get('args');
				$args['title'] = date('m-d H:i').'来10道';
				$sessionvars = $this->exam->getExamSessionBySessionid();
				if(!$args['knowsid'])
				{
					$args['knowsid'] = '';
					if($args['sectionid'])
					$knowsids = $this->section->getKnowsListByArgs(array(array("AND","knowssectionid = :knowssectionid",'knowssectionid',$args['sectionid']),array("AND","knowsstatus = 1")));
					else
					{
						$knowsids = $this->section->getAllKnowsBySubject($this->data['currentsubject']['subjectid']);
					}
					foreach($knowsids as $key => $p)
					$args['knowsid'] .= intval($key).",";
					$args['knowsid'] = trim($args['knowsid']," ,");
				}
				/**
				arsort($args['number']);
				$snumber = 0;
				foreach($args['number'] as $key => $v)
				{
					$snumber += $v;
					if($snumber > 100)
					{
						$message = array(
							'statusCode' => 300,
							"message" => "强化练习最多一次只能抽取100道题"
						);
						$this->G->R($message);
					}
				}
				$dt = key($args['number']);
				$questionids = $this->question->selectQuestionsByKnows($args['knowsid'],$args['number'],$dt);
				**/
				$args['number'] = array($args['questid'] => 10);
				$questionids = $this->question->selectQuestionsByKnows($args['knowsid'],$args['number']);
				$questions = array();
				$questionrows = array();
				foreach($questionids['question'] as $key => $p)
				{
					$ids = "";
					if(count($p))
					{
						foreach($p as $t)
						{
							$ids .= $t.',';
						}
						$ids = trim($ids," ,");
						if(!$ids)$ids = 0;
						$questions[$key] = $this->exam->getQuestionListByIds($ids);
					}
				}
				foreach($questionids['questionrow'] as $key => $p)
				{
					$ids = "";
					if(is_array($p))
					{
						if(count($p))
						{
							foreach($p as $t)
							{
								$questionrows[$key][$t] = $this->exam->getQuestionRowsById($t);
							}
						}
					}
					else $questionrows[$key][$p] = $this->exam->getQuestionRowsByArgs(array(array("AND","qrid = :qrid",'qrid',$p)));
				}
				$sargs['examsessionquestion'] = array('questionids'=>$questionids,'questions'=>$questions,'questionrows'=>$questionrows);
				$sargs['examsessionsetting'] = $args;
				$sargs['examsessionstarttime'] = TIME;
				$sargs['examsessionuseranswer'] = NULL;
				$sargs['examsession'] = $args['title'];
				$sargs['examsessiontime'] = $args['time']>0?$args['time']:60;
				$sargs['examsessionstatus'] = 0;
				$sargs['examsessiontype'] = 0;
				$sargs['examsessionbasic'] = $this->data['currentbasic']['basicid'];
				$sargs['examsessionkey'] = md5($args['knowsid']);
				$sargs['examsessionissave'] = 0;
				$sargs['examsessionsign'] = NULL;
				$sargs['examsessionsign'] = '';
				if($sessionvars['examsessionid'])
				$this->exam->modifyExamSession($sargs);
				else
				$this->exam->insertExamSession($sargs);
				$message = array(
					'statusCode' => 200,
					"message" => "抽题成功，正在转入试题页面",
				    "callbackType" => 'forward',
				    "forwardUrl" => "index.php?exam-phone-exercise-paper"
				);
				$this->G->R($message);
			}
			else
			{
				$sections = $this->section->getSectionListByArgs(array(array("AND","sectionsubjectid = :sectionsubjectid",'sectionsubjectid',$this->data['currentbasic']['basicsubjectid'])));
				$knows = $this->section->getAllKnowsBySubject($this->data['currentbasic']['basicsubjectid']);
				$knowids = '';
				foreach($knows as $key => $p)
				$knowids .= "{$key},";
				$knowids = trim($knowids," ,");
				$numbers = array();
				foreach($questype as $p)
				{
					$numbers[$p['questid']] = intval(ceil($this->exam->getQuestionNumberByQuestypeAndKnowsid($p['questid'],$knowids)));
				}
				$this->tpl->assign('basicnow',$this->data['currentbasic']);
				$this->tpl->assign('sections',$sections);
				$this->tpl->assign('questype',$questype);
				$this->tpl->assign('numbers',$numbers);
				$this->tpl->display('exercise');
			}
		}
	}

	//考试历史记录
	public function history()
	{
		$action = $this->ev->url(3);
		switch($action)
		{
			//删除考试历史记录
			case 'del':
			$ehid = $this->ev->get('ehid');
			$ehtype = $this->ev->get('ehtype');
			$page = $this->ev->get('page');
			$this->favor->delExamHistory($ehid,$this->_user['sessionuserid']);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
			    "callbackType" => 'forward',
			    "forwardUrl" => "?exam-phone-history&ehtype={$ehtype}&page={$page}"
			);
			$this->G->R($message);
			break;

			//批量删除强化训练历史记录
			case 'batdelexercise':
			$exercise = $this->ev->get('exercise');
			foreach($exercise as $p)
			$this->favor->delExamHistory($p,$this->_user['sessionuserid']);
			header("location:index.php?exam-phone-history");
			exit;
			break;

			//批量删除模拟考试历史记录
			case 'batdelexam':
			$exam = $this->ev->get('exam');
			foreach($exam as $p)
			$this->favor->delExamHistory($p,$this->_user['sessionuserid']);
			header("location:index.php?exam-phone-history");
			exit;
			break;

			//查看历史记录列表
			case 'view':
			$ehid = $this->ev->get('ehid');
			$eh = $this->favor->getExamHistoryById($ehid);
			$questype = $this->basic->getQuestypeList();
			$sessionvars = array('examsession'=>$eh['ehexam'],'examsessionscore'=>$eh['ehscore'],'examsessionscorelist'=>$eh['ehscorelist'],'examsessionsetting'=>$eh['ehsetting'],'examsessionquestion'=>$eh['ehquestion'],'examsessionuseranswer'=>$eh['ehuseranswer']);
			$this->tpl->assign('sessionvars',$sessionvars);
			$this->tpl->assign('questype',$questype);
			$this->tpl->assign('ehtype',$eh['ehtype']);
			if($eh['ehtype'] == 2)
			$this->tpl->display('history_examview');
			elseif($eh['ehtype'] == 1)
			$this->tpl->display('history_exampaperview');
			else
			$this->tpl->display('history_exerciseview');
			break;

			//查看历史记录列表
			case 'wrongs':
			$ehid = $this->ev->get('ehid');
			$eh = $this->favor->getExamHistoryById($ehid);
			$questype = $this->basic->getQuestypeList();
			$sessionvars = array('examsession'=>$eh['ehexam'],'examsessionscorelist'=>$eh['ehscorelist'],'examsessionsetting'=>$eh['ehsetting'],'examsessionquestion'=>$eh['ehquestion'],'examsessionuseranswer'=>$eh['ehuseranswer']);
			$this->tpl->assign('sessionvars',$sessionvars);
			$this->tpl->assign('questype',$questype);
			if($eh['ehtype'] == 2)
			$this->tpl->display('history_examwrongs');
			elseif($eh['ehtype'] == 1)
			$this->tpl->display('history_exampaperwrongs');
			else
			$this->tpl->display('history_exercisewrongs');
			break;

			//以该记录题目重新出卷
			case 'redo':
			$ehid = $this->ev->get('ehid');
			$eh = $this->favor->getExamHistoryById($ehid);
			$args = array(
							'examsession' => $eh['ehexam'].'重做',
							'examsessiontype'=>$eh['ehtype'] == 2?1:$eh['ehtype'],
							'examsessionsetting'=>$eh['ehsetting'],
							'examsessionbasic'=>$eh['ehbasicid'],
							'examsessionquestion'=>$eh['ehquestion'],
							'examsessionuseranswer'=>'',
							'examsessiontime'=>$eh['ehtime'],
							'examsessionscorelist'=>'',
							'examsessionscore'=>0,
							'examsessionstarttime'=>TIME,
							'examsessionissave'=> 0,
							'examsessionstatus'=> 0
						);
			$es = $this->exam->getExamSessionBySessionid();
			if($es['examsessionid'])
			{
				$this->exam->modifyExamSession($args);
			}
			else
			{
				$this->exam->insertExamSession($args);
			}
			if($eh['ehtype'] == 1)
			$message = array(
				'statusCode' => 200,
				"message" => "试题加载成功，即将进入考试页面",
			    "callbackType" => 'forward',
			    "forwardUrl" => "index.php?exam-phone-exampaper-paper&act=history&examid={$eh['ehkey']}"
			);
			elseif($eh['ehtype'] == 2)
			$message = array(
				'statusCode' => 200,
				"message" => "试题加载成功，即将进入考试页面",
			    "callbackType" => 'forward',
			    "forwardUrl" => "index.php?exam-phone-exampaper-paper&act=history&examid={$eh['ehkey']}"
			);
			else
			$message = array(
				'statusCode' => 200,
				"message" => "试题加载成功，即将进入考试页面",
			    "callbackType" => 'forward',
			    "forwardUrl" => "index.php?exam-phone-exercise-paper&act=history&examid={$eh['ehkey']}"
			);
			$this->G->R($message);
			break;

			//答题记录列表
			default:
			$page = $this->ev->get('page');
			$ehtype = intval($this->ev->get('ehtype'));
			$page = $page > 0?$page:1;
			$basicid = $this->data['currentbasic']['basicid'];
			$exams = $this->favor->getExamHistoryListByArgs($page,10,array(array("AND","ehuserid = :ehuserid",'ehuserid',$this->_user['sessionuserid']),array("AND","ehbasicid = :ehbasicid",'ehbasicid',$basicid),array("AND","ehtype = :ehtype",'ehtype',$ehtype)));
			foreach($exams['data'] as $key => $p)
			{
				$exams['data'][$key]['errornumber'] = 0;
				$questions = unserialize($p['ehquestion']);
				$scorelist = unserialize($p['ehscorelist']);
				$examsetting = unserialize($p['ehsetting']);
				if(is_array($questions['questions']) && is_array($scorelist))
				{
					foreach($questions['questions'] as $nkey => $q)
					{
						if(is_array($q))
						{
							foreach($q as $qid => $t)
							{
								if($p['ehtype'] == 0)
								{
									if($scorelist[$qid] != 1)$exams['data'][$key]['errornumber']++;
								}
								elseif($p['ehtype'] == 1)
								{
									if($scorelist[$qid] != $examsetting['examsetting']['questype'][$nkey]['score'])$exams['data'][$key]['errornumber']++;
								}
								else
								{
									if($scorelist[$qid] != $examsetting['examsetting']['questype'][$nkey]['score'])$exams['data'][$key]['errornumber']++;
								}
							}
						}
					}
					foreach($questions['questionrows'] as $nkey => $qt)
					{
						foreach($qt as $qtid => $q)
						{
							if(is_array($q))
							{
								foreach($q['data'] as $qid => $t)
								{
									if($p['ehtype'] == 0)
									{
										if($scorelist[$qid] != 1)$exams['data'][$key]['errornumber']++;
									}
									elseif($p['ehtype'] == 1)
									{
										if($scorelist[$qid] != $examsetting['examsetting']['questype'][$nkey]['score'])$exams['data'][$key]['errornumber']++;
									}
									else
									{
										if($scorelist[$qid] != $examsetting['examsetting']['questype'][$nkey]['score'])$exams['data'][$key]['errornumber']++;
									}
								}
							}
						}
					}
				}
			}
			$avgscore = floatval($this->favor->getAvgScore(array(array("AND","ehuserid = :ehuserid",'ehuserid',$this->_user['sessionuserid']),array("AND","ehbasicid = :ehbasicid",'ehbasicid',$basicid),array("AND","ehtype = :ehtype",'ehtype',$ehtype))));
			$this->tpl->assign('ehtype',$ehtype);
			$this->tpl->assign('page',$page);
			$this->tpl->assign('exams',$exams);
			$this->tpl->assign('avgscore',$avgscore);
			$this->tpl->display('history');
			break;
		}
	}

	public function favor()
	{
		$examid = $this->ev->get('examid');
		if(!$examid)$examid = $this->_user['sessioncurrent'];
		if(!in_array($examid,$this->examids))
		{
			$t = current($this->userexams);
			$examid = $t['a2sexamid'];
		}
		$this->tpl->assign('examid',$examid);
		$action = $this->ev->url(3);
		switch($action)
		{
			case 'ajax':
			switch($this->ev->url(4))
			{
				//添加一个收藏
				case 'addfavor':
				$questionid = $this->ev->get('questionid');
				if($this->favor->getFavorByQuestionAndUserId($questionid,$this->_user['sessionuserid']))
				{
					exit('0');
				}
				else
				{
					$this->favor->favorQuestion($questionid,$this->_user['sessionuserid'],$this->data['currentbasic']['basicsubjectid']);
					exit('1');
				}
				break;

				//删除一个收藏
				case 'delfavor':
				$favorid = $this->ev->get('questionid');
				$this->favor->delFavorById($favorid);
				exit('1');
				break;

				default:
				break;
			}
			break;

			//收藏试题列表
			default:
			$page = $this->ev->get('page');
			$type = $this->ev->get('type');
			$search = $this->ev->get('search');
			$tmp = $this->section->getKnowsListByArgs(array(array("AND","knowssectionid = :knowssectionid",'knowssectionid',$search['sectionid']),array("AND","knowsstatus = 1")));
			if($search['sectionid'] && !$search['knowsid'])
			{
				$search['knowsid'] = '';
				if(is_array($tmp))
				{
					foreach($tmp as $p)
					$search['knowsid'] .= $p['knowsid'].",";
				}
			}
			$search['knowsid'] = trim($search['knowsid']," ,");
			$page = $page > 0?$page:1;
			$args = array(array("AND","favorsubjectid = :favorsubjectid",'favorsubjectid',$this->data['currentbasic']['basicsubjectid']),array("AND","favoruserid = :favoruserid",'favoruserid',$this->_user['sessionuserid']));
			if($search['knowsid'])$args[] = array("AND","find_in_set(quest2knows.qkknowsid,:qkknowsid)",'qkknowsid',$search['knowsid']);
			if($type)
			{
				if($search['questype'])$args[] =  array("AND","questionrows.qrtype = :qrtype",'qrtype',$search['questype']);
				$favors = $this->favor->getFavorListByUserid($page,20,$args,1);
			}
			else
			{
				if($search['questype'])$args[] = array("AND","questions.questiontype = :questiontype",'questiontype',$search['questype']);
				$favors = $this->favor->getFavorListByUserid($page,20,$args);
			}
			$sections = $this->section->getSectionListByArgs(array(array("AND","sectionsubjectid = :sectionsubjectid",'sectionsubjectid',$this->_user['sessioncurrent'])));
			$questype = $this->basic->getQuestypeList();
			$this->tpl->assign('sections',$sections);
			$this->tpl->assign('questype',$questype);
			$this->tpl->assign('search',$search);
			$this->tpl->assign('knowsids',$tmp);
			$this->tpl->assign('page',$page);
			$this->tpl->assign('type',$type);
			$this->tpl->assign('favors',$favors);
			$this->tpl->display('favor');
			break;
		}
	}
}

?>