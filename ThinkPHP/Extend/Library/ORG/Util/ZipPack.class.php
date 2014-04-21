<?php
class ZipPack{
    protected $zip;

    public function __construct($zip){
        try{
            if(!extension_loaded('zip')){
                throw new Exception ('zip extension is not loaded');
            }
            //$this->zip = new ZipArchive();
            $this->zip = new ZipArchive;
            if(!file_exists($zip)){
                touch($zip);
            }
            if($this->zip->open($zip) !== true){
                throw new Exception('open zipfile fail');
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }
        
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief addFile 添加压缩文件
        *
        * @Param   $file    文件名
        *
        * @Returns   mixed 
     */
    /* --------------------------------------------------------------*/
    public function addFile($file){
       return $this->zip->addFile($file);
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief addDir 添加压缩目录
        *
        * @Param   $dir 要压缩的目录，用相对路径(入口文件下的某个目录,如Appclication、Static)
        *
        * @Returns  string 
     */
    /* --------------------------------------------------------------*/
    public function addDir($dir){
        static $bool='start';
        if(is_dir($dir)){
            $open = opendir($dir);
            while( ($file = readdir($open)) !== false ){
                if($file != '.' && $file != '..'){
                    if(is_dir("$dir/$file")){
                       $this->addDir("$dir/$file");
                    }else{
                        $bool .='-'.$this->addFile("$dir/$file");
                    }
                }
            }
            return $bool;
        }else{
            return false;
        }
    }

    function __destruct(){
        $this->zip->close();
    }

}
