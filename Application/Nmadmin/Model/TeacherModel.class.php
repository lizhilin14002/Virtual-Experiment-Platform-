<?php
namespace Nmadmin\Model;
use Think\Model;
class TeacherModel extends Model {
// 定义自动验证:验证输入情况 name=title，需要验证，未满足提示信息
protected $_validate = array(
    array('teacherid','require','教师ID未填写'),
    array('teachername','require','教师名称未填写'),
    array('teacherid', '', '教师ID已存在！', 0, 'unique', 1)
);
// 定义自动完成:自动完成 time 完善时间信息
protected $_auto = array(
    //array('id','time',1,'function'),
);
}
?>