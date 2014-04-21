<?php

/**
* @file SysconfigAction.class.php
* @brief 系统配置控制器
* @author Lyy    <panus@163.com>
* @version gxustcla 1.0
* @date 2014-03-25
 */

class SysconfigAction extends CommonAction{
    protected $table;   //要备份的表名
    protected $ext = '.sql';    //备份文件的后名

   
    public function backdb(){
        if(IS_POST){
            $this->table = I('post.table');
            $create_sql = $this->showCreateTable($this->table);
            $insert_sql= $this->showInsertSql($this->table);
            $bool = $this->writeFile($create_sql.$insert_sql);
            //$this->success($bool);
            if($bool){
                $this->success($bool.'---备份成功!');
            }else{
                $this->error('无法创建备份目录!');
            }

        }else{
            $tables = M()->query("show table status");
            $this->assign("tables",$tables);
            $this->display();
        }
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief backupimg 备份图片
        *
        * @Returns   void 
     */
    /* --------------------------------------------------------------*/
    public function backupimg(){
        import('ORG.Util.ZipPack'); //引入压缩类
        $zip =  new ZipPack(ROOT.'/image.zip');

        //备份目录,从入口文件开始，不加/
        $res = $zip->addDir('Upload');  //备份上传图片
        $res .= $zip->addDir('ueditor/php/upload');
        //$res .= $zip->addDir('要备份的目录');
        
        $this->success($res,U('sysconfig/backdb'));
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief recoverdb 还原数据库
        *
        * @Returns   void 
     */
    /* --------------------------------------------------------------*/
    public function recoverdb(){
        if(IS_POST){
            $file1 = C('BACKUP_PATH').'/'.I('post.table');
            if(file_exists($file1)){
                $sql_str = file_get_contents($file1);
                $sql_str = explode(';',$sql_str);
                array_pop($sql_str);
                $model = new Model();
                foreach($sql_str as $val){
                    $model->query(trim($val));
                }
                
                $this->success('还原成功',U('sysconfig/recoverdb'));
            }
        }else{
            if(is_dir(C('BACKUP_PATH'))){
                $open = opendir(C('BACKUP_PATH'));
                while(($file = readdir($open)) !== false){
                    if($file != '.' && $file !='..'){
                        $sqlFiles[] = $file;
                    }
                }
                $this->assign('sql',$sqlFiles);
            }
            $this->display();
        }
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief showCreateTable 生成表结构SQL
        *
        * @Param   $table   要生成的表
        *
        * @Returns   $string 
     */
    /* --------------------------------------------------------------*/
    protected function showCreateTable($table){
        $drop = "DROP TABLE IF EXISTS `$table`;\n";
        $create_sql = M()->query("show create table $table");
        return $drop.$create_sql[0]['Create Table'].";\n";
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief showInsertSql 返回数据的SQL
        *
        * @Param   $table   数据表
        *
        * @Returns    string
     */
    /* --------------------------------------------------------------*/
    protected function showInsertSql($table){
        $insert = '';
        $data = M()->table($table)->select();   //传表的完整名称
        foreach($data as $value){
            $douhao = '';
            $field_value = ''; 
            foreach($value as $val){
                $val = addslashes($val);    //转义字符串里面的单引号
                $field_value .=$douhao."'$val'";    //加上单引号
                $douhao = ',';
            }
            //组合sql语句
            $insert .= "INSERT INTO {$this->table} VALUES(".$field_value.");\n";

        }
        return $insert;
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief delSqlFile 删除备份的SQL文件
        *
        * @Returns   bool 
     */
    /* --------------------------------------------------------------*/
    public function delSqlFile(){
        $file = C('BACKUP_PATH').$_GET['file'];
        if(file_exists($file)){
            $this->success(unlink($file));
        }
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief writeFile 将内容写入文件
        *
        * @Param   $content 要写入的内容
        *
        * @Returns   bool or int 
     */
    /* --------------------------------------------------------------*/
    protected function writeFile($content){
        if(!is_dir(C('BACKUP_PATH'))){   //如果备份目录不存在
            if(!mkdir(C('BACKUP_PATH'))) return false;  //创建目录失败返回false
        }
        $file = C('BACKUP_PATH').$this->table.date('Ymd').$this->ext;
        //return file_put_contents($file,$content);
        $open = fopen($file,'w');   //写入方式
        $int = fwrite($open,$content);  //将内容写入文件
        fclose($open);  //关闭资源
        return $int;
    }
}
