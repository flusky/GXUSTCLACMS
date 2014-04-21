<?php
/**
* @file ArticleModel.class.php
* @brief 文章模型
* @author Lyy    <panus@163.com>
* @version gxustcla 1.0
* @date 2014-03-05
 */


class ArticleModel extends Model{
    protected $_validate = array(
        array('title','require','文章标题不能为空'),
        array('author','require','文章作者不能为空'),
        array('scan_times','require','浏览次数不能为空'),
        array('scan_times','number','浏览次数只能是数字'),
    );

    protected $_auto = array(
        array('update_time','time',3,'function'),
    );

    public function del($id){
        $data = $this->field('id,thum,content')->find($id);
        $imgurl = htmlspecialchars($data['content']);
        $pattern = "/src=(.*?)\/\d+\.(jpg|png|gif|jpeg)/i";
    }
}
