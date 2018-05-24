<?php
namespace Nmadmin\Controller;
use Think\Controller;
class TeacherController extends Controller {
    //用户管理
    public function index($adminid = ''){
        if (isset($_SESSION['adminid'])) {
            $Data = M('Teacher');
            $count = $Data->count();
            $p = getpage($count,10);
            $result = $Data->limit($p->firstRow, $p->listRows)->select();
            $this->assign('empty','<span class="empty">暂无用户</span>');
            $this->assign('list',$result);
            $this->assign('page', $p->show());
            $this->display();
        }else{
            $this->redirect('/Admin/Form/login');
        }
    }
    public function changeuser(){
        if (isset($_SESSION['adminid'])) {
            $teacherid = $_GET['id'];
            $Data = M('teacher');
            $where ="teacherid='" . $teacherid . "'";
            $result = $Data->where($where)->find();
            $this->assign('teacher',$result);
            $this->display();
        }else{
            $this->redirect('/Teacher/Form/login');
        }
    }
    public function add_user(){
        if (isset($_SESSION['adminid'])) {
            $Data = M('teacher');
            if($Data->create()){
                $Data->teacherpw = md5(11);
                $result = $Data->add();
                if($result !== "false"){
                    $this->success('教师信息已添加！','index');
                }else{
                    $this->error('教师信息修改错误！');
                }
            }
        }else{
            $this->redirect('/Teacher/Form/login');
        }
    }
    public function change_user(){
        if (isset($_SESSION['adminid'])) {
            $Data = M('teacher');
            if($Data->create()){
                if($_FILES['teacherimg']['size'] > 0){
                    //上传图片
                    $tid = $_POST['teacherid'];
                    $upload = new \Think\Upload();// 实例化上传类
                    $upload->maxSize = 2*1024*1024;// 设置附件上传大小:2M
                    $upload->exts = array('jpg', 'png', 'jpeg');// 设置附件上传类型
                    $upload->rootPath = './Public/image/'; // 设置附件上传根目录
                    $upload->savePath = '';
                    $upload->saveName = "head_$tid";
                    $upload->saveExt = "jpg";//固定后缀
                    $upload->replace = true;//允许替换
                    $upload->autoSub = false;//关闭。生成子目录
                    // 上传单个文件
                    $info   =   $upload->uploadOne($_FILES['teacherimg']);
                    if($info) {// 上传错误提示错误信息
                        // $this->error($upload->getError());
                        $Data->teacherimg = $info['savename'];
                        $fullpath = $upload->rootPath.$info['savename'];
                        $image = new \Think\Image();
                        $image->open($fullpath);
                        // 生成图片我的缩略图大小并替换原图
                        $image->thumb(200, 200,\Think\Image::IMAGE_THUMB_FIXED)->save($fullpath);
                    }
                }
                $result = $Data->save();
                //获取全路径
                
                if($result !== "false"){
                    $this->success('教师信息已修改！');
                }else{
                    $this->error('教师信息修改错误！');
                }
            }
        }else{
            $this->redirect('/Teacher/Form/login');
        }
    }
    public function delete(){
        if (isset($_SESSION['adminid'])) {
            $Data = M('teacher');
            $tid = $_GET['id'];
                $result = $Data->where("teacherid=$tid")->delete();
                if($result !== "false"){
                    $this->success('教师信息已删除！','index');
                }else{
                    $this->error('教师信息修改错误！');
                }
        }else{
            $this->redirect('/Teacher/Form/login');
        }
    }
}