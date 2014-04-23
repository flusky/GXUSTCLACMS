<?php
return array(

	# 数据库配置项
	'DB_TYPE'   => 'mysqli',	// 数据库类型
	'DB_HOST'   => 'localhost', // 服务器地址
	'DB_NAME'   => 'thinkphp',	// 数据库名
	'DB_USER'   => 'root',		// 用户名
	'DB_PWD'    => '1234',		// 密码
	'DB_PORT'   => 3306,		// 端口
	'DB_PREFIX' => 'gxustcla_', // 数据库表前缀 
	'DB_CHARSET'=> 'utf8',		// 字符集

	# URL配置
	'URL_CASE_INSENSITIVE'  =>  true,	//设置URL不区分大小写  
	'URL_MODEL'				=>	1,		//URL模式设置为PATHINFO
	'URL_ROUTER_ON'			=>	true,	//开启路由
);
