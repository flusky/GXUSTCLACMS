<?php
namespace Admin\Controller;
use Think\Controller;

class SafeController extends Controller {
    
	public function showLoginPage(){
		$this->assign("TITLE",	"欢迎登陆广西科技大学计算机爱好者协会");
		$this->display();	
	}

}
