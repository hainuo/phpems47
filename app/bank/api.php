<?php

class app
{
	public $G;

	public function __construct(&$G)
	{
		$this->G = $G;
		$this->files = $this->G->make('files');
		$this->session = $this->G->make('session');
	}

	public function randcode()
	{
		header("Content-type: image/png");
		$rand = $this->session->setRandCode($rand);
		echo $this->files->createRandImage($rand,90,36);
	}
}

?>