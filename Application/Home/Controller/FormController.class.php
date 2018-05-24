<?php
namespace Home\Controller;
use Think\Controller;
class FormController extends Controller{
    //验证码生成
    public function myverify(){  
        $Verify = new \Think\Verify();  
        $Verify->fontSize = 18;  
        $Verify->length   = 4;  
        $Verify->useNoise = false;  
        $Verify->codeSet = '0123456789';  
        $Verify->imageW = 130;  
        $Verify->imageH = 50;  
        //$Verify->expire = 600;  
        $Verify->entry();  
    }
    public function register(){
        $this->nav();
        $this->display();
    }
    //注册逻辑
    public function register_process(){
        $verify = $_POST['verify'];
        //验证码检测
        if(!check_verify($verify)){  
        $this->error("验证码输错了哦！");
        }
        $User = D('User');
        $password = md5($_POST['password']);
        if($User->create()) {
            //追加会员等级信息：默认为普通会员
            $User->rank= "初级会员" ;
            $User->password = $password; 
            $User->addtime = time();
            $result = $User->add();
            if($result) {
            $this->success('注册成功，请登录！',U('/Home/Form/login'));//若提交完成则显示成功消息
            }else{
            $this->error('数据添加错误！');
            }
        }else{
        $this->error($User->getError());
        }
    }

    public function login(){
        $this->nav();
        $this->display();
    }

    //登陆逻辑
    public function login_process($username = '', $password = ''){ 
        $username = $_POST['user'];
        $password = md5($_POST['password']);
        $verify = $_POST['verify'];
        //验证码检测
        if(!check_verify($verify)){  
        $this->error("验证码输错了哦！");
        }
        //进行验证
        $Data = M('user');
        $where = "username='" . $username . "' AND password='" . $password . "'";
        $result = $Data->where($where)->find();

        if($result){
            //读取会员等级信息
            session('username',$username);

            $this->success('登录成功！',U('/Home/index'));//若提交完成则显示成功消息
        }else{
            $this->error('用户名或密码错误！');//否则提示
        }
    }
    //顾客 退出登录 逻辑
    public function logout(){
        if(isset($_SESSION['username'])){
            session('username',null);
            session('userrank',null);
            session('[destroy]');
            $this->success('用户已退出！', U('/Home/index'));
        }else{
            $this->redirect('/Home/index');
        }
    }
    public function wxlogin(){ 
        $username = $_GET['user'];
        $Data = M('user');
        $where = "username='" . $username . "'";
        $result = $Data->where($where)->find();

        if($result){
            //读取会员等级信息
            $rank = $Data->where($where)->getfield('rank');

            session('username',$username);
            session('userrank',$rank);

            $this->success('登录成功！',U('/Home/index'));//若提交完成则显示成功消息
        }else{
            $this->error('用户名或密码错误！');//否则提示
        }
    }
    public function change(){
        $this->nav();
        if (isset($_SESSION['username'])) {
            $Data = M('user');
            $username = $_SESSION['username'];
            $where ="username='" . $username . "'";
            $result = $Data->where($where)->find();
            $this->assign('result',$result);
            if($result['openid']==''){
               $this->assign('type','普通注册用户'); 
            }else{
               $this->assign('type','微信用户');  
            }
            $this->display();
        }else{
            $this->redirect('/Home/Form/login');
        }
    }
    public function checkpw($username = ''){ 
        if (isset($_SESSION['username'])) {
            $username= I('get.username');
            $password= I('get.password');
            $Data = M('user');
            $result = $Data->where("username='" . $username . "'")->getField('password');
            if(md5($password) == $result){
                $data = "true";
            }else{
                //notfind
                $data = "false";
            }
        }else{
            // no access
                $data = "null";
        }
        //$this->ajaxReturn($data)
        $this->ajaxReturn($data,'eval');
    }
    public function changepassword(){ 
        if (isset($_SESSION['username'])) {
            $password = I('post.newpassword');
            $Data = M('user');
            $username = $_SESSION['username'];

            $where ="username='" . $username . "'";

            $Data->password = md5($password);

            $result = $Data->where($where)->save();
            $this->success('修改成功，请重新登录','logout');
        }else{
            $this->redirect('login');
        }
    }
    public function nav(){
        //顶部导航
        $nav = M('type1');
        $navlist = $nav->select();
        $this->assign('navlist',$navlist);
    }   

}