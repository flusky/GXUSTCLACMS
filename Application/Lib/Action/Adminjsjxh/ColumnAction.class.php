<?php

/**
* @file ColumnAction.class.php
* @brief 栏目控制器
* @author Lyy    <panus@163.com>
* @version gxustcla 1.0
* @date 2014-03-05
 */

class ColumnAction extends CommonAction{

    /* --------------------------------------------------------------*/
    /**
        * @brief index 栏目列表显示
        *
        * @Returns   void 
     */
    /* --------------------------------------------------------------*/
    public function index(){
        if(IS_POST){
            $ids = I('post.ids');
            $sortids = I('post.sortids');
            foreach($ids as $key => $value){
                $bool[]=M('column')->where("id = {$value}")->save(array('sortid'=>$sortids[$key]));
            }
            $this->success(implode(',',$bool));
        }else{
            $column = M('column')->order('sortid asc')->select();
            $this->assign('column',$column);
            $this->display();
        }
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief add 栏目添加更新方法
        *
        * @Returns   void 
     */
    /* --------------------------------------------------------------*/
    public function add(){
        if(IS_POST){
            $column = D('Column');
            $id = I('get.cid');
            if($column->create()){
                if(I('post.update')){
                    $result = $column->where("id=$id")->save();
                }else{
                    $result = $column->add();
                }
                if($result){
                    $this->success(L('_OPERATION_SUCCESS_'),U('column/index'));
                }else{
                    $this->error($column->getError());
                }
            }else{
                $this->error($column->getError());
            }
        }else{
            if(I('get.cid')){
                $id = I('get.cid');
                $data = M('column')->find($id);
                $this->assign('column',$data);
                $this->display('edit');
            }else{
                $this->display();
            }
        }
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief del 栏目删除方法
        *
        * @Returns   void 
     */
    /* --------------------------------------------------------------*/
    public function del(){
            $id = I('get.cid');
            $column = M('column');
            $result = $column->delete($id);
            if($result){
                $this->success(L('_OPERATION_SUCCESS_'),U('column/index'));
            }else{
                $this->error($column->getError());
            }
    }

}
