<?php
namespace Nmadmin\Controller;
use Think\Controller;
class AboutController extends Controller {
    //网站简介：显示
    public function index($adminid = ''){
        if (isset($_SESSION['adminid'])) {
            //获取操作对象
            $Data = M('About');
            $result = $Data->find();
            $this->assign('list',$result);
            $this->display();
        }else{
            $this->redirect('/Admin/Form/login');
        }
    }
    //网站简介：修改处理
    public function change_process($adminid = ''){
        if (isset($_SESSION['adminid'])) {
            $Data = M('About');
            if($Data->create()){
                //补充时间信息
                $Data->addtime = date("Y-m-d H:i:s" ,time());
                $result = $Data->save();
                
                if($result !== "false"){
                    $this->success('简介已修改！','index');
                }else{
                    $this->error('简介修改错误！');
                }
            }
        }else{
            $this->redirect('/Admin/Form/login');
        }
    }
    
}