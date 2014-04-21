<?php
/**
* @file ArticleAction.class.php
* @brief 文章管理控制器
* @author Lyy    <panus@163.com>
* @version gxustcla 1.0
* @date 2014-03-05
 */

class ArticleAction extends CommonAction{

    /* --------------------------------------------------------------*/
    /**
        * @brief index 显示文章列表
        *
        * @Returns   void 
     */
    /* --------------------------------------------------------------*/
    public function index(){
        $article = M('article');
        //调用分页方法
        $page = R('Admin/Common/showpage',array('article'));
        $article->alias('art')->field('art.id,art.title,art.pass,art.update_time,art.author,c.typename,c.type,art.scan_times')->order("pass desc , update_time desc");
        //分页的limit
        $article->limit($page->firstRow,$page->listRows);
        $article->join('join cc_column c on c.id=art.cid');
        $data = $article->select();
        $this->assign('a',$data);
        $this->assign('property',$page->iterateVisible());//传递分页参数到模板
        $this->display();
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief pass 审核文章方法
        *
        * @Returns   void 
     */
    /* --------------------------------------------------------------*/
    public function pass(){
        $id = I('get.aid');
        $result = M('article')->where("id=$id")->save(array('pass'=>'1'));
        if($result){
            $this->success(L('_OPERATION_SUCCESS_'),U('article/index'));
        }else{
            $this->error(L('_OPERATION_FAIL_'));
        }
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief add 添加文章或更新文章
        *
        * @Returns   void 
     */
    /* --------------------------------------------------------------*/
    public function add(){
        if(IS_POST){
            $data = $_POST;  //ajax 以get参数传过来
            if(I('post.thumbs')){
                $data['thumb'] = I('post.thumbs');
            }
            $a = D('Article');  //实例化文章模型
            if($a->create($data)){
                if($data['handle'] == 'add'){   //添加文章
                    if($a->add()){
                        $this->success(L('_OPERATION_SUCCESS_'),U('article/index'));
                    }else{
                        $this->error($a->getError());
                    }
                }elseif($data['handle'] == 'update'){   //更新文章
                    //获取文章ID
                    $aid = I('get.aid');    
                    if($a->where("id=$aid")->save()){
                        $this->success(L('_OPERATION_SUCCESS_'),U('article/index'));
                    }else{
                        $this->error($a->getError());
                    }
                }
            }else{
                $this->error($a->getError());
            }
        }else{
            $column = M('column')->field('id,typename,type')->where(array('type'=>'1'))->select();
            $this->assign('column',$column);
            if(I('get.aid')){   //如果是编辑文章就加载相应模板
                $id =I('get.aid');
                $art_data =M('article')->find($id);
                $this->assign('article',$art_data);
                $this->display('edit');
            }else{
                $this->display();
            }
        }
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief del 文章删除方法
        *
        * @Returns   void 
     */
    /* --------------------------------------------------------------*/
    public function del(){
        $id = I('get.aid');
        $article = M('article');
        $data = $article->find($id);
        $url = array();
        //看content中有没有图片
        if(strpos($data['content'],'img')){
            $pattern = "/src=\"(.*?(\.jpg|png|gif|jpeg))\"/i";
            //将图片路径匹配出来
            preg_match_all($pattern,$data['content'],$result);
            //dump($result);
            //获取图片路径
            $imgurl = $result[1];
            //将域名替换为.
            $url = str_replace(DOMAIN,ROOT,$imgurl);
        }
        //将缩略图路径也加进$url
        if(isset($data['thumb'])){
            $thumb=explode(',',$data['thumb']);
            if(is_array($thumb)){
                foreach($thumb as $value){
                    array_push($url,C('UPLOAD_PATH').$value);
                }
            }else{
                array_push($url,C('UPLOAD_PATH').$thumb);
            }
        }
        //dump($url);
        //exit;
        foreach($url as $value){
            if(file_exists($value)){
                unlink($value);
            }
        }
        $bool=$article->delete($id);
        if($bool)
            $this->success($bool."---".L('_OPERATION_SUCCESS_'),U('article/index'));
        else
            $this->error($article->getError());
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief downls 下载资源列表
        *
        * @Returns   void 
     */
    /* --------------------------------------------------------------*/
    public function downls(){
        $download=D('Download');
        if(IS_POST){    //ajax增加或删除
            $id=I('get.id');
            if(I('post.handle') == 'del'){
               $bool = $download->delete($id);
            }elseif(I('post.handle') == 'add'){
                if($download->create($_GET))
                    $bool = $download->add();
                else
                    $this->error($download->getError());
            }
            if($bool)
                $this->success(L('_OPERATION_SUCCESS_'),U('article/downls'));
            else
                $this->error(L('_OPERATION_FAIL_'));
        }else{
            $down = $download->alias('d')->field('d.id,d.cid,d.name,d.down_url,d.down_times,d.push_time,c.typename')->order('push_time desc')->join('cc_column c on d.cid=c.id')->select();
            //dump($down);
            $this->assign('down',$down);
            $this->display();
        }
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief picture 显示相册列表
        *
        * @Returns   void 
     */
    /* --------------------------------------------------------------*/
    public function picture(){
        if(IS_POST){
            $id = I('get.id');
            $data = M('picture')->field('images')->where(array('id'=>$id))->find();
            if($data['images']){
                $images = explode(',',$data['images']);
                foreach($images as $val){
                    $file = C('PICTURE_UPLOAD_PATH').$val;
                    if(file_exists($file)){
                        unlink($file);
                    }
                }
            }
            $bool =M('picture')->delete($id);
            $this->success($bool.'----'.L('_OPERATION_SUCCESS_'),U('article/picture'));
            
        }else{
            $picture = M('picture')->alias('p')->field('p.id,p.title,p.images,p.scantimes,p.pushtime,c.typename')->join('left join cc_column c on p.cid=c.id')->order('pushtime desc')->select();
            $this->assign('picture',$picture);
            $this->display();
        }
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief addpicture 添加、更新相册
        *
        * @Returns   void 
     */
    /* --------------------------------------------------------------*/
    public function addpicture(){
        if(IS_POST){
            $model=D('Picture');
            if(I('post.uploadify')){
                $_POST['images'] = I('post.uploadify');
            }
            //$dump = var_dump($_POST['images']);
            if($model->create()){
                if(I('get.id')){    //有id传值则更新表
                    $id = I('get.id');
                    $bool = $model->where("id=$id")->save(); 
                }else{
                    $bool = $model->add();
                }
                if($bool)
                    $this->success(L('_OPERATION_SUCCESS_'),U('article/picture'));
                else
                    $this->error(L('_OPERATION_FAIL_'));
            }else{
                $this->error($model->getError());
            }
        }else{
            $this->assign('column',M('column')->where("type='2'")->select());
            if(I('get.id')){
                $data = M('picture')->find(I('get.id'));
                $this->assign('data',$data);
                $this->display('editpicture');
            }else{
                $this->display();
            }
        }
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief imgUpload 调用公用控制器里面的地传方法
        *
        * @Returns   void 
     */
    /* --------------------------------------------------------------*/
    public function imgUpload(){
        $action = C('ADMIN_GROUP').'/Common/swfUpload';
        R($action,array(C('PICTURE_UPLOAD_PATH')));
    }

}
