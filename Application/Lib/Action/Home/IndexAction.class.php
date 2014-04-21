<?php
/**
* @file IndexAction.class.php
* @brief 首页控制器
* @author Lyy    <panus@163.com>
* @version gxustcla 1.0
* @date 2014-03-11
 */

class IndexAction extends Action {
    /* --------------------------------------------------------------*/
    /**
        * @brief index 显示首的方法
        *
        * @Returns   void 
     */
    /* --------------------------------------------------------------*/
    public function index(){
        $art = M('article');
        $notice = $art->field('id,title,content,description')->where("cid='82'")->order('update_time desc')->cache(C('DB_CACHE'))->find();    //显示最新公告
        //dump($notice);
        $news = $art->field('id,title,description')->where("cid = '81'")->limit('0,2')->cache(C('DB_CACHE'))->select();       //显示新闻动态
        $nav = M('column')->where(array('show_index'=>'1'))->cache(C('DB_CACHE'))->order('sortid asc')->select();    //显示首页导航
        $focus = $art->field("id,title,thumb,description")->where(array('imgtype'=>'1'))->cache(C('DB_CACHE'))->order('update_time desc')->limit('0,4')->select();   //显示焦点图
        $this->flink();
        $this->assign('focus',$focus);
        $this->assign('nav',$nav);
        $this->assign('news',$news);
        $this->assign('notice',$notice);
        $this->display();
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief listpage 列表页
        *
        * @Returns   void 
     */
    /* --------------------------------------------------------------*/
    public function listpage(){
        $template = '';
        $cid = I('get.cid');
        $type = M('column')->where("id=$cid")->find();
        if($type['type'] == 2){
            $art = M('picture')->cache(C('DB_CACHE'))->where("cid=$cid")->order('pushtime desc')->select();
            $template='lspicture';
        }elseif($type['type'] == 3){
            $art = M('download')->cache(C('DB_CACHE'))->where("cid=$cid")->order('push_time desc')->select();
            $template = 'downls'; 
        }else{
            $art = M('article')->field('id,cid,title')->cache(C('DB_CACHE'))->where("cid=$cid")->order('update_time desc')->select();
        }

        $this->nav();
        $this->assign('art',$art);
        $this->assign('type',$type);
        $this->display($template);
    }

    /* --------------------------------------------------------------*/
    /**
        * @brief info 显示文章信息
        *
        * @Returns  void  
     */
    /* --------------------------------------------------------------*/
    public function info(){
        //dump($_GET);
        $article = M('article');
        if(I('get.cid')){   //传的是栏目id
            $data = $article->where(array('cid'=>I('get.cid')))->order('update_time desc')->find();
            $article->where(array('cid'=>I('get.cid')))->setInc('scan_times');      //浏览次数增1

            $type = M('column')->find(I('get.cid'));
        }elseif(I('get.aid')){      //传的是文章id
            $data = $article->find(I('get.aid'));
            $article->where(array('id'=>I('get.aid')))->setInc('scan_times');     
            $type = M('column')->find($data['cid']);
        }
        $this->assign('data',$data);
        $this->assign('type',$type);    //显示其属栏目
        $this->nav();   //显示导航条
        $this->display();
    }

    public function picture(){
        $data = M('picture')->find(I('get.aid'));
        M('picture')->where(array('id'=>I('get.aid')))->setInc('scantimes');
        $data['images']=explode(',',$data['images']);
        $type = M('column')->find($data['cid']);
        $this->assign('type',$type);
        $this->assign('data',$data);
        $this->nav();
        $this->display();
    }

    protected function flink(){
        $flink = M('flink')->order('id asc')->select();
        $this->assign('flink',$flink);
    }
    protected function nav(){
        $column = M('column')->cache(C('DB_CACHE'))->select();
        $this->assign('column',$column);
    }
}
