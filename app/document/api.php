<?php

class app
{
	public $G;
	private $sc = 'testSys&dongao';

	public function __construct(&$G)
	{
		$this->G = $G;
		$this->ev = $this->G->make('ev');
		$this->files = $this->G->make('files');
		$this->session = $this->G->make('session');
		$this->user = $this->G->make('user','user');
		$this->apps = $this->G->make('apps','core');
		$_user = $this->_user = $this->session->getSessionUser();
		$group = $this->user->getGroupById($_user['sessiongroupid']);
		if(!$_user['sessionuserid'])
		{
			if($this->ev->get('userhash'))
			exit(json_encode(array(
				'statusCode' => 300,
				"message" => "请您重新登录",
			    "callbackType" => 'forward',
			    "forwardUrl" => "index.php?user-app-login"
			)));
			else
			{
				header("location:index.php?user-app-login");
				exit;
			}
		}
		$this->attach = $this->G->make('attach','document');
		$this->allowexts = $this->attach->getAllowAttachExts();
	}

	public function index()
	{
		header("location:".'index.php?'.$this->G->app.'-app');
	}

	public function dstatus()
	{
		$number = 3;
		$a = array();
		$a['status'] = 'succ';
		$a['url'] = 'files/attach/images/content/20150117/14215094601346.mp3?';
		echo json_encode($a);
	}

	public function upload()
	{
		$fn = $this->ev->get('CKEditorFuncNum');
		$upfile = $this->ev->getFile('upload');
		$path = 'files/attach/files/content/'.date('Ymd').'/';
		if($upfile)
		$fileurl = $this->files->uploadFile($upfile,$path,NULL,NULL,$this->allowexts);
		if($fileurl)
		{
			$message = '上传成功!';
			$args = array();
			$args['attpath'] = $fileurl;
			$args['atttitle'] = $upfile['name'];
			$args['attext'] = $this->files->getFileExtName($upfile['name']);
			$args['attsize'] = $upfile['size'];
			$args['attuserid'] = $this->_user['sessionuserid'];
			$args['attcntype'] = $upfile['type'];
			$this->attach->addAttach($args);
			$str = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$fn.', \''.WP.'/'.$fileurl.'\', \''.$message.'\');</script>';
		}
		else
		{
			$message = '上传失败，附件类型不符!';
			$str = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$fn.',false, \''.$message.'\');</script>';
		}
		echo $str;
	}

	public function uploadfile()
	{
		$fn = $this->ev->get('CKEditorFuncNum');
		$upfile = $this->ev->getFile('upload');
		$path = 'files/attach/files/content/'.date('Ymd').'/';
		if($upfile)
		$fileurl = $this->files->uploadFile($upfile,$path,NULL,NULL,$this->allowexts);
		if($fileurl)
		{
			$message = '上传成功!';
			$args = array();
			$args['attpath'] = $fileurl;
			$args['atttitle'] = $upfile['name'];
			$args['attext'] = $this->files->getFileExtName($upfile['name']);
			$args['attsize'] = $upfile['size'];
			$args['attuserid'] = $this->_user['sessionuserid'];
			$args['attcntype'] = $upfile['type'];
			$this->attach->addAttach($args);
			$str = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$fn.', \''.WP.'/'.$fileurl.'\', \''.$message.'\');</script>';
		}
		else
		{
			$message = '上传失败，附件类型不符!';
			$str = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$fn.',false, \''.$message.'\');</script>';
		}
		echo $str;
	}

	public function swfupload()
	{
		$path = 'files/attach/images/content/'.date('Ymd').'/';
		$upfile = $this->ev->getFile('Filedata');
		if($upfile)
		$fileurl = $this->files->uploadFile($upfile,$path,NULL,NULL,$this->allowexts);
		if($fileurl)
		{
			$args = array();
			$args['attpath'] = $fileurl;
			$args['atttitle'] = $upfile['name'];
			$args['attext'] = $this->files->getFileExtName($upfile['name']);
			$args['attsize'] = $upfile['size'];
			$args['attuserid'] = $this->_user['sessionuserid'];
			$args['attcntype'] = $upfile['type'];
			$this->attach->addAttach($args);
			if($this->ev->get('imgwidth') || $this->ev->get('imgheight'))
			{
				if($this->files->thumb($fileurl,$fileurl.'.png',$this->ev->get('imgwidth'),$this->ev->get('imgheight')))
				$thumb = $fileurl.'.png';
				else
				$thumb = $fileurl;
			}
			else
			$thumb = $fileurl;
			exit(json_encode(array('status' => 'succ','thumb' => $thumb)));
		}
		else
		{
			exit(json_encode(array('status' => 'fail')));
		}
	}

	public function swfuploadvideo()
	{
		$path = 'files/attach/images/content/'.date('Ymd').'/';
		$fileurl = $this->files->uploadFile($this->ev->getFile('Filedata'),$path,NULL,NULL,$this->allowexts);
		echo $fileurl;
	}
}

?>