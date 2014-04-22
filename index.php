<?php

define('APP_DEBUG', true);								//开启调试模式，项目部署时请注释该行
define('ROOT',		dirname(__FILE__));					//设置根目录的绝对路径
define('DOMAIN',	'http://127.0.0.1:1000/gxustcla/');	//设置域名
define('APP_NAME',	'Application');						//应用名
define('APP_PATH',	'./Application/' );					//应用目录
define('COOKIE_EXPIRE',24*3600);						//Cookie有效期

require('./ThinkPHP/ThinkPHP.php');						//加载框架文件
