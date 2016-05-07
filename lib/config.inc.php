<?php
define('DOMAINTYPE','off');
define('CH','exam_');
define('CDO','');
define('CP','/');
define('CRT',180);
define('CS','xn9dylsl012002');
define('HE','utf-8');
define('PN',10);
define('TIME',time());
if(dirname($_SERVER['SCRIPT_NAME']))
define('WP','http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']));
else
define('WP','http://'.$_SERVER['SERVER_NAME'].'/');

define('DB','exam');//MYSQL数据库名
define('DH','localhost');//MYSQL主机名，不用改
define('DU','root');//MYSQL数据库用户名
define('DP','Ncss2015');//MYSQL数据库用户密码
define('DTH','x2_');//系统表前缀，不用改

?>
