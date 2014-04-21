<?php
class ColumnModel extends Model{
    protected $_validate  = array(
        array('typename','require','栏目名称不能为空',1),
        array('type','require','栏目类型不能为空'),
    );
}
