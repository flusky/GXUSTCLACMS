<?php
/**
* @file DownloadModel.class.php
* @brief 下载表模型
* @author Lyy    <panus@163.com>
* @version gxustcla 1.0
* @date 2014-03-10
 */


class DownloadModel extends Model{

    protected $_validate = array(
        array('cid','number','所属栏目填id'),
        array('down_times','number','下载次数只能是数字'),
        array('name','require','名称不能为空'),
        array('down_url','require','下载地址不能为空'),
    );

    protected $_auto = array(
        array('push_time','time',3,'function'),
    );
}
