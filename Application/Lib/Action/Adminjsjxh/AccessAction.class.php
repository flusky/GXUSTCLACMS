<?php

/**
* @file AccessAction.class.php
* @brief 权限管理控制器
* @author Lyy    <panus@163.com>
* @version gxustcla 1.0
* @date 2014-03-06
 */

class AccessAction extends CommonAction{

    /* --------------------------------------------------------------*/
    /**
        * @brief userLs 管理员列表
        *
        * @Returns   void 
     */
    /* --------------------------------------------------------------*/
    public function user(){
        $user = M('adminer')->alias('a')->field('a.id,a.username,a.savetime,g.title')->join('left join cc_auth_group g on a.level_id=g.id')->select();
        //dump($user);
        $this->assign('user',$user);
        $this->display();
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief edituser 添加、修改用户信息
        *
        * @Returns  void
     */
    /* --------------------------------------------------------------*/
    public function edituser(){
        if(IS_POST){
            if(check_verify($_POST['verify'])){ //判断验证码是否通过
                $user = D('Adminer');
                if($user->create()){    //自动验证
                    if(I('get.id')){    //有ID项为更新用户信息
                        $id = I('get.id');
                        $bool = $user->where("id=$id")->save();
                    }else{
                        $bool = $user->add();
                    }
                    if($bool)
                        $this->success(L('_OPERATION_SUCCESS_'),U('access/user'));
                    else
                        $this->error(L('_OPERATION_FAIL_'));
                }
                else
                    $this->error($user->getError());
            }
            else
                $this->error(L('_VERIFY_ERROR_'));
        }else{
            $group = M('auth_group')->select();
            $this->assign('group',$group);
            if(I('get.id')){
                $data = M('adminer')->find(I('get.id'));
                $this->assign('data',$data);
                $this->display();
            }else{
                $this->display('adduser');
            }
        }
    }

    
}
