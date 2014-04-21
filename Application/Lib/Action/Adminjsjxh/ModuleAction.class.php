<?php
/**
* @file ModuleAction.class.php
* @brief 模块管理控制器
* @author Lyy    <panus@163.com>
* @version gxustcla 1.0
* @date 2014-03-12
 */

class ModuleAction extends CommonAction{

    /* --------------------------------------------------------------*/
    /**
        * @brief flink 友情链接模块
        *
        * @Returns   void 
     */
    /* --------------------------------------------------------------*/
    public function flink(){
        if(IS_POST){
            $flink = D('Flink');
            //判断表的操作
            if(I('post.handle') == 'add'){
                if($flink->create())
                    $bool = $flink->add();
                else
                    $this->error($flink->getError());
            }elseif(I('post.handle') == 'del'){
                $id = I('get.id');
                //删除链接的logo
                $thumb = $flink->field('logo')->where("id=$id")->find();
                if(!empty($thumb)){
                    $thumb = $thumb['logo'];
                    $thumb = C('UPLOAD_PATH').$thumb;
                    if(file_exists($thumb)){
                        unlink($thumb);
                    }
                }
                $bool  = $flink->delete($id);
            }else{
                if($flink->create())
                    $bool = $flink->save();
                else
                    $this->error($flink->getError());
            }
            if($bool)
                $this->success(L('_OPERATION_SUCCESS_'),U('module/flink'));
            else
                $this->error(L('_OPERATION_FAIL_'));
            
        }else{
            //dump(C('DATA_CACHE_PATH'));
            $flink = M('flink')->select();
            $this->assign('flink',$flink);
            $this->display();
        }
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief clearCache 删除缓存
        *
        * @Returns   void 
     */
    /* --------------------------------------------------------------*/
    public function clearCache(){
        if($this->clearDir(DATA_PATH) && $this->clearDir(CACHE_PATH)){
            $this->success(L('_OPERATION_SUCCESS_'),U('module/flink'));
        }else{
            $this->error(L('_OPERATION_FAIL_'));
        }
    }

    public function clearLogs(){
        if($this->clearDir(LOG_PATH))
            $this->success(L('_OPERATION_SUCCESS_'),U('module/flink'));
        else
            $this->error(L('_OPERATION_FAIL_'));
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief clearDir 删除一个目录
        *
        * @Param   $dir 要删除的目录
        *
        * @Returns   bool 
     */
    /* --------------------------------------------------------------*/
    public function clearDir($dir = ''){
        if(is_dir($dir)){
            $open = opendir($dir);
            while(($file = readdir($open)) !== false ){
                if($file != '.' && $file != '..'){
                    //unlink("$dir/$file");
                    if(is_dir("$dir/$file")){
                        $this->clearDir("$dir/$file");
                    }else{
                        unlink("$dir/$file");
                    }
                }
            }
            return true;
        }else{
            return false;
        }
    }
}
