<?php

class PictureModel extends Model{
    protected $_validate = array(
        array('title','require','相册标题不能为空'),
        array('images','require','图片至少上传一张'),
    );

    protected $_auto = array(
        array('pushtime','time',3,'function'),
    );

}
