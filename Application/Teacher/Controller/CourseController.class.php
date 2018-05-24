<?php 
namespace Teacher\Controller;
use Think\Controller;
class courseController extends Controller {
    public function index(){
        if (isset($_SESSION['teacherid'])) {
            $Data = M('course');
            $teacherid = $_SESSION['teacherid'];
            $where ="teacherid='" . $teacherid . "'";
            $count = $Data->where($where)->count();
            $p = getpage($count,10);
            $result = $Data->order('id desc')->where($where)->limit($p->firstRow, $p->listRows)->select();
            $this->assign('empty','<div class="col-md-12 column empty">暂无课程</div>');
            $this->assign('list',$result);
            $this->assign('page', $p->show());
            $this->display();
        }else{
            $this->redirect('/Teacher/Form/login');
        }
    } 
     public function course(){
        if (isset($_SESSION['teacherid'])) {
            $Data = M('course');
            $teacherid = $_SESSION['teacherid'];
            $courseid = $_GET['id'];
            $where ="id='" . $courseid . "'";
            $result = $Data->where($where)->find();
            if($result["teacherid"]==$teacherid){
                $this->assign('empty','<div class="col-md-12 column empty">暂无课程</div>');
                $this->assign('course',$result);
                $this->assign('courseid',$result["id"]);
                $this->assign('coursename',$result["name"]);
                $this->assign('coursesee',$result["see"]);
                $this->assign('coursenumber',$result["number"]);
                $section = M('section');
                $sectionlist = $section->where("courseid=$courseid")->select();
                $this->assign('sectionlist',$sectionlist);
                $this->display();
            }else{
                $this->redirect('/Teacher/Form/login');
            }
        }else{
            $this->redirect('/Teacher/Form/login');
        }
    }
    public function add_course(){
        if (isset($_SESSION['teacherid'])) {
            $Data = M('course');
             if($Data->create()){
                $Data->teacherid=$_SESSION['teacherid'];
                $Data->teachername=$_SESSION['teachername'];
                $Data->number=0;
                $Data->addtime = date("Y-m-d H:i:s" ,time());
                $result = $Data->add();
                $newid = $result;
                $path = "./Public/resource/course_".$newid;
                if (!file_exists($path)){
                    mkdir($path); 
                }
                //上传图片
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = 2*1024*1024;// 设置附件上传大小:2M
                $upload->exts = array('jpg', 'png', 'jpeg');// 设置附件上传类型
                $upload->rootPath = './Public/image/'; // 设置附件上传根目录
                $upload->savePath = '';
                $upload->saveName = "course_$newid";// 固定文件名
                $upload->saveExt = "jpg";//固定后缀
                $upload->replace = true;//允许替换
                $upload->autoSub = false;//关闭。生成子目录
                // 上传单个文件 
                $info   =   $upload->uploadOne($_FILES['img']);
                if(!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                }else{// 上传成功 获取上传文件信息

                //获取全路径
                $fullpath = $upload->rootPath.$info['savename'];
                $Data->where("id=$newid")->setField('img',$info['savename']);
                $image = new \Think\Image(); 
                $image->open($fullpath);
                // 生成一个固定大小为150*150的缩略图并保存为thumb.jpg
                $result = $image->thumb(800, 450,\Think\Image::IMAGE_THUMB_FIXED)->save($fullpath);
                    if($result){
                        $this->success('课程已发布！');
                        }else{
                            $this->error('发布错误！');
                        }
                    }

                }

        }else{
            $this->redirect('/Teacher/Form/login');
        }
    }
    public function delete_course(){
        if (isset($_SESSION['teacherid'])) {
            $id= $_GET['id'];
            $teacherid= $_SESSION['teacherid'];
            $Data = M('course');
            $result = $Data->where("id='" . $id . "'")->delete();
            $this->success('删除成功！');
            $this->redirect('/Teacher/Course');
        }else{
            $this->redirect('/Teacher/Form/login');
        }
    }
    public function changecourse(){
        if (isset($_SESSION['teacherid'])) {
            $id= $_GET['id'];
            $Data = M('course');
            $where ="id='" . $id . "'";
            $result = $Data->where($where)->find();
            $this->assign('course',$result);
            $this->display();
        }else{
            $this->redirect('/Teacher/Form/login');
        }
    }
    public function change_course(){
        if (isset($_SESSION['teacherid'])) {
            $Data = M('course');
            if($Data->create()){
                if(isset($_FILES['img'])){
                //上传图片
                $postid = $_POST['id'];
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = 2*1024*1024;// 设置附件上传大小:2M
                $upload->exts = array('jpg', 'png', 'jpeg');// 设置附件上传类型
                $upload->rootPath = './Public/image/'; // 设置附件上传根目录
                $upload->savePath = '';
                $upload->saveName = "course_$postid";
                $upload->saveExt = "jpg";//固定后缀
                $upload->replace = true;//允许替换
                $upload->autoSub = false;//关闭。生成子目录
                // 上传单个文件 
                $info   =   $upload->uploadOne($_FILES['img']);
                if($info) {// 上传错误提示错误信息
                    // $this->error($upload->getError());
                    $Data->img = $info['savename'];
                    $fullpath = $upload->rootPath.$info['savename'];
                    $image = new \Think\Image(); 
                    $image->open($fullpath);
                    // 生成图片我的缩略图大小并替换原图
                    $image->thumb(800, 450,\Think\Image::IMAGE_THUMB_FIXED)->save($fullpath);
                } 
                }
                $result = $Data->save();
                //获取全路径
                
                if($result !== "false"){
                    $this->success('课程信息已修改！');
                    }else{
                        $this->error('课程信息修改错误！');
                    }
                }
        }else{
            $this->redirect('/Teacher/Form/login');
        }
    }
    public function addsection(){
        if (isset($_SESSION['teacherid'])) {
            $id= $_GET['id'];
            $Data = M('course');
            $where ="id='" . $id . "'";
            $result = $Data->where($where)->find();
            $this->assign('course',$result);
            $this->display();
        }else{
            $this->redirect('/Teacher/Form/login');
        }
    }
    public function add_section(){
        if (isset($_SESSION['teacherid'])) {
            $Data = M('section');
            if($Data->create()){
                 $Data->paper='#';
                 $Data->resource='#';
                 $Data->courseware='#';   
                 $result = $Data->add();
                if($result){
                    $this->success('新章节已发布！');
                    }else{
                        $this->error('发布错误！');
                    }
            }   
        }
        else{
            $this->redirect('/Teacher/Form/login');
        }
    }
    public function changesection(){
        if (isset($_SESSION['teacherid'])) {
            $id= $_GET['id'];
            $Data = M('section');
            $where ="sectionid='" . $id . "'";
            $result = $Data->where($where)->find();
            $this->assign('section',$result);
            $this->display();
        }else{
            $this->redirect('/Teacher/Form/login');
        }
    }
    public function change_section(){
        if (isset($_SESSION['teacherid'])) {
            $Data = M('section');
            if($Data->create()){
                 $Data->paper='#';
                 $Data->resource='#';
                 $Data->courseware='#';   
                 $result = $Data->save();
                if($result){
                    $this->success('章节已修改！');
                    }else{
                        $this->error('修改错误！');
                    }
            }   
        }
        else{
            $this->redirect('/Teacher/Form/login');
        }
    }
    public function add_courseware(){
        if (isset($_SESSION['teacherid'])) {
            $Data = M('section');
            if($Data->create()){
                $postid = $_POST['sectionid'];
                $cid = $_POST['courseid'];
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = 20*1024*1024;// 设置附件上传大小:20M
                $upload->exts = array('pdf','PDF');// 设置附件上传类型
                $upload->rootPath = './Public/resource/course_'.$cid.'/'; // 设置附件上传根目录
                $upload->savePath = '';
                $upload->saveName = "".$postid."_courseware";
                $upload->saveExt = "pdf";//固定后缀
                $upload->replace = true;//允许替换
                $upload->autoSub = false;//关闭。生成子目录
                $Data->courseware="".$postid."_courseware.pdf";
                $info  =  $upload->upload();
                if($info !== "false"){
                if($result !== "false"){
                     $result = $Data->save();
                    $this->success('文件已上传！');
                    }else{
                        $this->error('文件已上传错误！');
                    }
                }
                }else{
                        $this->error('文件已上传错误！');
                }
        }else{
            $this->redirect('/Teacher/Form/login');
        }
    }
    public function add_paper(){
        if (isset($_SESSION['teacherid'])) {
            $Data = M('section');
            if($Data->create()){
                $postid = $_POST['sectionid'];
                $cid = $_POST['courseid'];
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = 20*1024*1024;// 设置附件上传大小:20M
                $upload->exts = array('pdf','PDF');// 设置附件上传类型
                $upload->rootPath = './Public/resource/course_'.$cid.'/'; // 设置附件上传根目录
                $upload->savePath = '';
                $upload->saveName = "".$postid."_paper";
                $upload->saveExt = "pdf";//固定后缀
                $upload->replace = true;//允许替换
                $upload->autoSub = false;//关闭。生成子目录
                $Data->paper="".$postid."_paper.pdf";
                $info  =  $upload->upload();
                if($info !== "false"){
                if($result !== "false"){
                     $result = $Data->save();
                    $this->success('文件已上传！');
                    }else{
                        $this->error('文件已上传错误！');
                    }
                }
                }else{
                        $this->error('文件已上传错误！');
                }
        }else{
            $this->redirect('/Teacher/Form/login');
        }
    }
    public function add_resource(){
        if (isset($_SESSION['teacherid'])) {
            $Data = M('section');
            if($Data->create()){
                $postid = $_POST['sectionid'];
                $cid = $_POST['courseid'];
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = 20*1024*1024;// 设置附件上传大小:20M
                $upload->exts = array('zip');// 设置附件上传类型
                $upload->rootPath = './Public/resource/course_'.$cid.'/'; // 设置附件上传根目录
                $upload->savePath = '';
                $upload->saveName = "".$postid."_resource";
                $upload->saveExt = "zip";//固定后缀
                $upload->replace = true;//允许替换
                $upload->autoSub = false;//关闭。生成子目录
                $Data->resource="".$postid."_resource.zip";
                $info  =  $upload->upload();
                if($info !== "false"){
                if($result !== "false"){
                     $result = $Data->save();
                    $this->success('文件已上传！');
                    }else{
                        $this->error('文件已上传错误！');
                    }
                }
                }else{
                        $this->error('文件已上传错误！');
                }
        }else{
            $this->redirect('/Teacher/Form/login');
        }
    }
    public function delete_section(){
        if (isset($_SESSION['teacherid'])) {
            $id= $_GET['id'];
            $Data = M('section');
            $result = $Data->where("sectionid='" . $id . "'")->delete();
            $this->success('删除成功！');
        }else{
            $this->redirect('/Teacher/Form/login');
        }
    }
}