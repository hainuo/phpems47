<?php

class app
{
	public $G;

	public function __construct(&$G)
	{
		$this->G = $G;
		$this->files = $this->G->make('files');
		$this->session = $this->G->make('session');
		$this->tpl = $this->G->make('tpl');
		$this->ev = $this->G->make('ev');
	}

	public function randcode()
	{
		header("Content-type: image/png");
		$rand = $this->session->setRandCode($rand);
		echo $this->files->createRandImage($rand,67,30);
	}

	public function setsessionid()
	{
		header("Content-type:application/x-javascript");
		$sessionid = $this->session->getSessionId();
		$this->tpl->assign("sessionid",$sessionid);
		$this->tpl->display('setsession');
	}

	public function finger()
	{
		exit;
		header("Content-type:application/x-javascript");
		$sessionid = $this->session->getSessionId();
		$finger = md5($this->ev->get('finger'));
		if($finger != $sessionid)
		{
			$this->ev->setCookie('psid',$finger,3600*24);
			if(!$this->ev->get('unreload'))
			echo 'window.location.reload();';
		}
		else
		{
			echo 'console.log("ok")';
		}
	}
}

?>