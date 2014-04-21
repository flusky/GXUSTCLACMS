<?php
/**
* @file IndexAction.class.php
* @brief 后台首页控制器
* @author Lyy    <panus@163.com>
* @version gxustcla 1.0
* @date 2014-03-05
 */

class IndexAction extends CommonAction{
    public function index(){
        $this->display();
    }

    public function head(){
        $this->display();
    }
    public function menu(){
        $this->display();
    }
    public function content(){
        //dump($_COOKIE);
        //dump($_SESSION);
        $this->display();
    }
}
