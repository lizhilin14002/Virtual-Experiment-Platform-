<?php
namespace Nmadmin\Controller;
use Think\Controller;
class FormController extends Controller{
    //验证码生成
    public function myverify(){  
        $Verify = new \Think\Verify();  
        $Verify->fontSize = 18;  
        $Verify->length   = 4;  
        $Verify->useNoise = false;  
        $Verify->codeSet = 'abcdefghij';  
        $Verify->imageW = 130;  
        $Verify->imageH = 50;  
        //$Verify->expire = 600;  
        $Verify->entry();  
    }
    //富文本框->图片上传接口 逻辑->ajax[file.img]->ajaxreturn[fullpath]
    public function upload(){
        if(isset($_FILES['img'])){
            //上传图片
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 2*1024*1024;// 设置附件上传大小:2M
            $upload->exts = array('jpg', 'png', 'jpeg');// 设置附件上传类型
            
            $upload->rootPath = './Public/image/'; // 设置附件上传根目录
            $upload->savePath = '';
            $upload->autoSub = false;//关闭。生成子目录
            // 上传单个文件
            $info   =   $upload->uploadOne($_FILES['img']);
            if($info) {// 上传错误提示错误信息
                // $this->error($upload->getError());
                // $Data->img = 'upload/'.$info['savename'];
                $fullpath = '../Public/image/'.$info['savename'];
                //$fullpath = '/Public/image/'.$info['savename'];
                // $data['status']  = 1;
                $data = $fullpath;
                $this->ajaxReturn($data,'eval');
            }
        }
    }

    //管理员 登陆逻辑
    public function login_process(){
    $adminame = $_POST['ausername'];
    $adminpw = md5($_POST['apassword']);
    $verify = $_POST['verify'];
    //验证码检测
    if(!check_verify($verify)){  
    $this->error("验证码输入错误！");
    }
    //验证中...
    $Data = M('admin');
    $result = $Data->where("name='" . $adminame . "' AND pass='" . $adminpw . "'")->find();

    if($result){
        session('adminid',$result["id"]);
        session('adminname',$result["name"]);
        //session('adminimg',$result["adminimg"]);
        $this->success('登录成功！',U('/Nmadmin/index'));//若提交完成则显示成功消息
    }else{
        $this->error('用户名或密码错误！');//否则提示
    }
    }
    //管理员 退出登录 逻辑
    public function logout(){
        if(isset($_SESSION['adminid'])){
            session('adminid',null);
            session('adminname',null);
            session('adminimg',null);
            session('[destroy]');
            $this->success('用户已退出！', U('/Nmadmin/Form/login'));
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
    }
}