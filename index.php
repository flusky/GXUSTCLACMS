<?php

define('APP_DEBUG', true);		//开启调试模式，项目部署时请注释该行

define('ROOT',		dirname(__FILE__));
define('DOMAIN',	'http://127.0.0.1:1000/gxustcla/');
define('APP_NAME',	'Application');
define('APP_PATH',	'./Application/' );
//cookie保存一天
define('COOKIE_EXPIRE',24*3600);

require('./ThinkPHP/ThinkPHP.php');
