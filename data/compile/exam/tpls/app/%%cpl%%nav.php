<div class="row-fluid topLine">
	<div class="container-fluid">
		<div class="span4"></div>
		<div class="span8">
			<span class="pull-right">
			<?php if($this->tpl_var['_user']['userid']){?>
			您好（<?php echo $this->tpl_var['_user']['username'];?>）&nbsp;&nbsp;<a href="index.php?user-center"><em class="icon-user"></em> 用户中心</a><?php if($this->tpl_var['_user']['teacher_subjects']){?>&nbsp;&nbsp;<em class="icon-edit"></em> <a href="index.php?exam-teach">教师管理</a><?php } elseif($this->tpl_var['_user']['groupid'] == 1){?>&nbsp;&nbsp;<em class="icon-edit"></em> <a href="index.php?core-master">后台管理</a><?php } ?>&nbsp;&nbsp;<a class="ajax" href="index.php?user-app-logout"><em class="icon-lock"></em> 退出</a>
			<?php } else { ?>
			<a href="javascript:;" onclick="javascript:$.loginbox.show();"><em class="icon-lock"></em> 登录</a>&nbsp;&nbsp;<a href="index.php?user-center"><em class="icon-user"></em> 注册</a>
			<?php } ?>
			&nbsp;&nbsp;&nbsp;&nbsp;
			</span>
		</div>
	</div>
</div>
<div class="row-fluid top">
	<div class="container-fluid">
		<div class="span4"><a name="top"></a><h2><img src="app/user/styles/img/theme/logo.png" /></h2></div>
		<div class="span8">
			<div class="navbar" id="menuNav">
				<div class="">
					<div class="nav-collapse">
						<ul class="nav pull-right">
							<li class="mainmenu">
								<a href="index.php">主页</a>
							</li>
							<li class="active mainmenu">
								<a href="index.php?exam">在线考试</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>