<?php

class FlinkModel extends Model{
    protected $_validate = array(
        array('name','require','链接名称不能为空'),
        array('url','require','url不能为空'),
    );
}
