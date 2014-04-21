<?php

/**
* @file AdminerModel.class.php
* @brief    管理员模型
* @author Lyy    <panus@163.com>
* @version no define
* @date 2014-03-04
 */

class AdminerModel extends Model{
    //用户的自动验证
    protected $_validate = array(
        array('username','require','用户名不能为空'),
        array('username','','用户名已经存在',0,'unique',1),
        array('passwd','require','密码不能为空'),
        array('passwd','5,16','密码长度为5-16个字符',1,'length'),
        array('username','4,10','用户名为4-10个字符',1,'length'),
        array('confirmpw','passwd','两次密码不一致',0,'confirm'),
        
    );

    protected $_auto = array(
        array('savetime','time',3,'function'),
        array('passwd','md6',3,'function'),
    );


    /* --------------------------------------------------------------*/
    /**
        * @brief login 管理员登陆
        *
        * @Param   $user    用户名
        * @Param   $password    密码
        *
        * @Returns    bool
     */
    /* --------------------------------------------------------------*/
    public function login($user,$password){
        $password = md6($password);
        $result = $this->where(array('username'=>$user,'passwd'=>$password))->find();
        if($result){
            session('user',$user);  
            session('logintime',time());
            setcookie('LOGIN_ID',C('COOKIE_LOGIN_KEY'),time()+C('COOKIE_EXPIRE'),'/');   
            //$cookie = $_COOKIE[C('COOKIE_LOGIN')].C('COOKIE_LOGIN_KEY');
            session('login',md6(C('COOKIE_LOGIN_KEY')));  //session 的login状态

            return true;
        }else{
            return false;
        }
    }

   
}
