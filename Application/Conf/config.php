<?php
return array(

    //'WEB_DOMAIN'    =>DOMAIN,
    'WEB_TITLE'     =>'广西科技大学大学生计算机爱好者协会——传播计算机文化，打造E时代精神,我们在努力!',
    'WEB_KEYWORDS'  =>'广西科技大学计算机,广西科技大学计算机协会,计算机爱好者,计算机爱好者协会,大学生计算机爱好者,广西科技大学计算机爱好者协会',
    'WEB_DESCRIPTION'   =>'广西科技大学大学生计算机爱好者协会成立于1991年10月，是广西科技大学成立最早的协会之一学术性学生社团。计算机爱好者协会自成立以来就得到计算机教学部、团委及校内广大计算机爱好者的大力支持，协会得到了健康的发展，计算机爱好者协会历史久，实力雄厚，经验丰富，适应时代潮流，是校内电脑类社团最强的社团，协会以“传播计算机文化，打造E时代精神”为宗旨，经常举行各种学习性和娱乐性比赛，深受广大学生的厚爱.',
    'WEB_COPYRIGHT' =>'CopyRight&nbsp;广西科技大学计算机爱好者协会&nbsp;&copy;&nbsp;2014&nbsp;All Rights Reserved',

    'APP_GROUP_LIST' => 'Home,Adminjsjxh', //项目分组设定
    'DEFAULT_GROUP'  => 'Home', //默认分组
    'ADMIN_GROUP'   =>'Adminjsjxh',

    'TMPL_L_DELIM'=>'<{',		//模板边界符
	'TMPL_R_DELIM'=>'}>',
    //扩展模板变量
    'TMPL_PARSE_STRING'  =>array(
        '__STATIC__'    => DOMAIN.'/Static',
        '__UPLOAD__'    =>DOMAIN.'/Upload',
    ),
    

    'SHOW_PAGE_TRACE' =>true, // 显示页面Trace信息

    'URL_CASE_INSENSITIVE'  => true,   // 默认false 表示URL区分大小写 true则表示不区分大小写

    'DB_TYPE'               => 'mysqli',     // 数据库类型
    'DB_HOST'               => 'localhost', // 服务器地址
	'DB_NAME'               => 'metro',          // 数据库名
   	'DB_USER'               => 'root',      // 用户名	q
   	'DB_PWD'                => '1234',          // 密码
   	'DB_PORT'               => '3306',        // 端口
   	'DB_PREFIX'             => 'cc_',    // 数据库表前缀
   	'DB_FIELDTYPE_CHECK'    => false,       // 是否进行字段类型检查
   	'DB_FIELDS_CACHE'       => false,        // 是否启用字段缓存
	'DB_CHARSET'            => 'utf8',      // 数据库编码默认采用utf8
    'DB_CACHE'  =>false, //是否开启查询缓存

    
    'COOKIE_EXPIRE'     => COOKIE_EXPIRE ,
    'COOKIE_LOGIN_KEY'      => 'gxustcla',    //保存在客户端的cookie name


    'DATA_CACHE_PATH'   =>DATA_PATH.'Home',
    'DATA_CACHE_TIME'  =>24*3600,  //缓存有效期为一天



    'LOG_RECORD' => true, // 开启日志记录
    //'LOG_LEVEL'  =>'EMERG,ALERT,CRIT,ERR', // 只记录EMERG ALERT CRIT ERR 错误
    
     "URL_MODEL" => 2, //除了可以不需要在URL里面写入口文件，和可以定义.htaccess 文件外

     'BACKUP_PATH'=>APP_PATH.'Backup/',
);
?>
