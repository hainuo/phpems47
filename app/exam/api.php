<?php

class app
{
	public $G;
	//联系密钥
	private $sc = 'exam@phpems.net';

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
		$this->exam = $this->G->make('exam','exam');
		$this->user = $this->G->make('user','user');
	}

	public function index()
	{
		header("location:".'index.php?'.$this->G->app.'-app');
	}

	public function test()
	{
		$page = intval($this->ev->get('page'));
		$r = glob("csv/*.csv");
		if(!$r[$page])
		{
			echo 'OK';
			exit;
		}
		setlocale(LC_ALL,'zh_CN');
		$handle = fopen($r[$page],"r");
		$out = "out/".$r[$page];
		echo $out;
		$fp = fopen($out,"w");
		$i = 0;
		$alldata = array();
		while ($data = fgetcsv($handle,1024))
		{
			if($i && $data[5])
			{
				$code = $data[5];
				$cnt = strip_tags(file_get_contents("http://oypx.kjcytk.com/member/QuestionAnswerOne.aspx?QuestionId={$data[5]}&action=dYhUr5v9eh0="));
				$cnt = iconv("utf-8","gbk",$cnt);
				$data[6] = $cnt;
				fputcsv($fp,$data);
			}
			$i++;
		}
		fclose($handle);
		fclose($fp);
		$page++;
		echo "<script>window.location = 'index.php?exam-api-test&page={$page}'</script>";
	}

	//通过接口进行登录
	public function login()
	{
		$sign = $this->ev->get('sign');
		$userid = $this->ev->get('userid');
		$username = $this->ev->get('username');
		$useremail = $this->ev->get('useremail');
		$ts = $this->ev->get('ts');
		$rand =rand(1,6);
		if($rand == 5)
		{
			$this->session->clearOutTimeUser();
			$this->exam->clearOutTimeExamSession();
		}
		if($sign == md5($userid.$username.$useremail.$this->sc.$ts))
		{
			$user = $this->G->make('user','user');
			$u = $user->getUserByUserName($username);
			if(!$u)
			{
				$defaultgroup = $this->user->getDefaultGroup();
				$pass = md5(rand(1000,9999));
				$id = $this->user->insertUser(array('username' => $username,'usergroupid' => $defaultgroup['groupid'],'userpassword' => md5($pass),'useremail' => $useremail));
				$this->session->setSessionUser(array('sessionuserid'=>$id,'sessionpassword'=>md5($pass),'sessionip'=>$this->ev->getClientIp(),'sessiongroupid'=>$defaultgroup,'sessionlogintime'=>TIME,'sessionusername'=>$username));
			}
			else
			{
				$args = array('sessionuserid'=>$u['userid'],'sessionpassword'=>$u['userpassword'],'sessionip'=>$this->ev->getClientIp(),'sessiongroupid'=>$u['usergroupid'],'sessionlogintime'=>TIME,'sessionusername'=>$u['username']);
				$this->session->setSessionUser($args);
			}
			header("location:".'index.php?'.$this->G->app.'-app');
		}
		else
		header("location:".'index.php?exam');
		exit(0);
	}

	//退出登录
	public function logout()
	{
		$this->session->clearSessionUser();
		header("location:".'index.php?'.$this->G->app.'-app');
	}
}

?>