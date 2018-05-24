<?php
namespace Home\Model;
use Think\Model;
class CartModel extends Model {
// 定义自动验证:验证标题输入情况 name=title，需要验证，未满足提示信息
protected $_validate = array(

);
// 定义自动完成:自动完成 time 完善时间信息
protected $_auto = array(
    
);
}

// 主要是用于表单的自动验证和自动完成，具体用法我们会用另外的篇幅单独讲述，这里暂时先略过。我们只要了解的是，如果使用D函数实例化模型类，一般需要对应一个数据模型类，而且create方法会自动把表单提交的数据进行自动验证和自动完成（如果有定义的话），如果自动验证失败，就可以通过模型的getError方法获取验证提示信息，如果验证通过，就表示数据对象已经成功创建，但目前只是保存在内存中，直到我们调用add方法写入数据到数据库。
// 如果你的数据完全是内部操作写入而不是通过表单的话（也就是说可以充分信任数据的安全），那么可以直接使用add方法、$Form = D('Form');$data['title'] = 'ThinkPHP';$data['content'] = '表单内容';$Form->add($data);
?>
