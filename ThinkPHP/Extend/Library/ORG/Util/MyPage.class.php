<?php
class MyPage {
    public $allRows;    //总条数
    public $listRows;   //每页显示条数
    public $nowPage;    //当前页数
    public $pages;      //总页数
    protected $var;     //uri分页变量
    public $firstRow;   //起始limit
    public $nowUri;     //当前uri
    public $prev;       //上一页
    public $next;       //下一页

    public function __construct($allRows,$listRows=5){
        $this->allRows=$allRows;
        $this->listRows=$listRows;
        $this->pages=ceil($allRows/$listRows);
        //$this->var=C('VAR_PAGE') ? C('VAR_PAGE') : 'page';
        $this->var='page';
        $this->config();
        //analysis uri param
        
    }

    public function config(){
        $get=(int)$_GET[$this->var];
        if(empty($get) || $get < 0){
            $this->nowPage=1;
        }else if($get >= $this->pages){
            $this->nowPage=$this->pages;
        }else{
            $this->nowPage=$get;
        }
        $this->prev=$this->nowPage-1;
        $this->next=$this->nowPage+1;
        $this->firstRow=($this->nowPage - 1) * $this->listRows;
    }
    /**
        * @brief iterateVisible 迭代属性 
        *
        * @Returns  array
     */
    public function iterateVisible(){
        //分析url参数,get方式为 ?key=val&key1=val1;
        $str=trim($_SERVER['REQUEST_URI']);
        $query_string=trim($_SERVER['QUERY_STRING']);
        
        if(!empty($query_string)){
            //如果有$this->var这个参数,上下页采用替换模式
            if(stristr($query_string,$this->var)){   
                $this->prev=preg_replace("/({$this->var})=\d+/i","$1={$this->prev}",$str);
                $this->next=preg_replace("/({$this->var})=\d+/i","$1={$this->next}",$str);
                for($i=1;$i<=$this->pages;$i++){
                    $property['url'][$i]=preg_replace("/({$this->var})=\d+/i","$1={$i}",$str);
                }
            }else {
                //如果没有则在末尾加上:&pags=n;
                $this->prev=$str."&{$this->var}={$this->prev}";
                $this->next=$str."&{$this->var}={$this->next}";
                for($i=1;$i<=$this->pages;$i++){
                    $property['url'][$i]=$str."&{$this->var}={$i}";
                }
            }
        }else{
            //没有任何参数则让其自动加上
            $this->prev=$str."?{$this->var}={$this->prev}";
            $this->next=$str."?{$this->var}={$this->next}";
            for($i=1;$i<=$this->pages;$i++){
                $property['url'][$i]=$str."?{$this->var}={$i}";
            }
        }
        //迭代当前类的属性
        foreach($this as $key => $value){
            $property[$key]=$value;
        }
        return $property;
    }
}
