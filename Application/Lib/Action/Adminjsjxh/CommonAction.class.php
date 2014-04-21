<?php

/**
* @file CommonAction.class.php
* @brief 公用控制器
* @author Lyy    <panus@163.com>
* @version gxustcla 1.0
* @date 2014-03-15
 */

class CommonAction extends Action{
    /* --------------------------------------------------------------*/
    /**
        * @brief _initialize 子类的初始化接口
        *
        * @Returns  void
     */
    /* --------------------------------------------------------------*/
    public function _initialize(){
        //调用login的logout方法 
        if(empty($_COOKIE['LOGIN_ID']) || empty($_SESSION['login']) || $_SESSION['login'] != md6($_COOKIE['LOGIN_ID'])){
            $logout = C('ADMIN_GROUP').'/Login/logout';
            R($logout);
        }
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief swfUpload 图片上传方法
        *
        * @Returns  json 
     */
    /* --------------------------------------------------------------*/
    public function swfUpload($dir=''){
        import('ORG.Net.UploadFile');
        $upload = new UploadFile();
        $upload->maxSize = 5000000;    //最大为5M
        $upload->allowExts = array('jpg','gif','png','jpeg');
        //$upload->autoSub = true;
        //$upload->savePath = C('UPLOAD_PATH');
        $upload->savePath = $dir ? $dir : C('UPLOAD_PATH');
        if(!$upload->upload()){
            $this->error($upload->getErrorMsg(),'',true);
        }else{
            $this->success($upload->getUploadFileInfo(),'',true);
        }
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief showpage 公用分页方法
        *
        * @Param   $table   要分页的表
        * @Param   $lsRows  每页显示条数
        *
        * @Returns    object
     */
    /* --------------------------------------------------------------*/
    public function showpage($table){
        import('ORG.Util.MyPage');// 导入分页类
        $tab_obj =M($table);
        $count = $tab_obj->count();
        $listRows = C('LIST_ROWS') ? C('LIST_ROWS') : 5;
        $page = new MyPage($count,$listRows);
        return $page;
    }
}
