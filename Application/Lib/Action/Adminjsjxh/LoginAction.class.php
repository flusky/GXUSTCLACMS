<?php
/**
* @file LoginAction.class.php
* @brief 登陆控制器
* @author Lyy    <panus@163.com>
* @version gxustcla 1.0
* @date 2014-03-05
 */

class LoginAction extends Action{
    public function index(){
        //if($_SESSION['login'] && $_SESSION['login'] == md6('true')){
            //$this->redirect('index/index');
        //}
        //先判断是否还是登陆状态
        if($_COOKIE['LOGIN_ID']){
            if($_SESSION['login'] == md6($_COOKIE['LOGIN_ID'])){
                $this->redirect('index/index');
            }
        }
        //dump($_COOKIE);
        //dump($_SESSION);
        $this->display();
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief login 用户登陆方法
        *
        * @Returns   string 
     */
    /* --------------------------------------------------------------*/
    public function login(){
        if(check_verify($_POST['verify'])){
            $user = trim(I('post.username'));
            $pwd = trim(I('post.passwd'));
            $login = D('Adminer')->login($user,$pwd);
            if($login){
                $this->success(L('_LOGIN_SUCCESS_'),U('index/index'));
            }else{
                $this->error(L('_LOGIN_ERROR_'));
            }
        }else{
            $this->error(L('_VERIFY_ERROR_'));
        }
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief logout 用户退出登陆方法
        *
        * @Returns    void
     */
    /* --------------------------------------------------------------*/
    public function logout(){
        $_SESSION = array();
        session_destroy();
        setcookie('LOGIN_ID','',time()-10,'/');
        //让session id 过期
        setcookie(session_name(),'',time()-10,'/');
        $this->redirect('login/index');
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief vcode 输出验证码
        *
        * @Returns    void
     */
    /* --------------------------------------------------------------*/
    public function vcode(){
        import('ORG.Util.Verify');
        $verify=new Verify();
        $verify->entry(1);
    }

    
}
