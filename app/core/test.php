<?php

class app
{
	public $G;

	public function __construct(&$G)
	{
		$this->G = $G;
		$this->sql = $this->G->make('pdosql');
		$this->db = $this->G->make('pepdo');
		$this->ev = $this->G->make('ev');
	}

	public function index()
	{
		$userid = $this->ev->get('userid');
		//$data = array('user',array(array('AND',"userid = :userid",'userid',$userid)));
		//$sql = $this->sql->makeDelete($data);
		//$r = $this->db->exec($sql);

		//$data = array('user',array("usertruename" => 'dddaaa'),array(array('AND',"userid = :userid",'userid',$userid)));
		//$sql = $this->sql->makeUpdate($data);
		//$r = $this->db->exec($sql);


		//$data = array('*',array('user','user_group'),array(array("AND","user.usergroupid = user_group.groupid"),array("AND","userid = :userid","userid",$userid)));
		//$sql = $this->sql->makeSelect($data);
		$sql = array('sql' => 'show tables');
		$r = $this->db->fetchAll($sql);
		print_r($r);
	}
}

?>