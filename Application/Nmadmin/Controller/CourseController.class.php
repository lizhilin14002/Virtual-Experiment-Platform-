<?php
namespace Nmadmin\Controller;
use Think\Controller;
class courseController extends Controller {
    public function index(){
        if (isset($_SESSION['adminid'])) {
            $Data = M('resources');
            $count = $Data->count();
            $p = getpage($count,10);
            $result = $Data->order('rid desc')->where($where)->limit($p->firstRow, $p->listRows)->select();
            $this->assign('empty','<div class="col-md-12 column empty">暂无课程</div>');
            $this->assign('list',$result);
            $this->assign('page', $p->show());
            $this->display();
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    public function search(){
        if (isset($_SESSION['adminid'])) {
            $name = $_GET['name'];
            $Data = M('resources');
            $where = "rtitle like'" . "%".$name."%" . "' or rcontent like'" . "%".$name."%" . "'";
            $count = $Data->where($where)->count();
            $p = getpage($count,10);
            $result = $Data->order('id desc')->where($where)->limit($p->firstRow, $p->listRows)->select();
            $this->assign('empty','<div class="col-md-12 column empty">暂无课程</div>');
            $this->assign('list',$result);
            $this->assign('page', $p->show());
            $this->display();
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    
    public function course(){
        if (isset($_SESSION['adminid'])) {
            $Data = M('resources');
            $adminid = $_SESSION['adminid'];
            $courseid = $_GET['id'];
            $where ="rid='" . $courseid . "'";
            $result = $Data->where($where)->find();
            $this->assign('course',$result);
            $this->display();
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    public function attachment(){
        if (isset($_SESSION['adminid'])) {
            $Data = M('resources');
            $adminid = $_SESSION['adminid'];
            $courseid = $_GET['id'];
            $where ="rid='" . $courseid . "'";
            $result = $Data->where($where)->find();
            $this->assign('course',$result);
            $this->display();
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    public function add_course(){
        if (isset($_SESSION['adminid'])) {
            $Data = M('resources');
            if($Data->create()){
                $Data->addtime = date("Y-m-d H:i:s" ,time());
                $result = $Data->add();
                $newid = $result;
                if($_FILES['rtopimg']['size'] > 0){
                    $upload = new \Think\Upload();// 实例化上传类
                    $upload->maxSize = 2*1024*1024;// 设置附件上传大小:2M
                    $upload->exts = array('jpg', 'png', 'jpeg');// 设置附件上传类型
                    $upload->rootPath = './Public/resources/'; // 设置附件上传根目录
                    $upload->autoSub = true;//关闭。生成子目录
                    $upload->subName = "course_$newid";
                    $upload->saveName = "course_$newid";
                    $upload->saveExt = "jpg";//固定后缀
                    $upload->replace = true;//允许替换
                    
                    // 上传单个文件
                    $info   =   $upload->uploadOne($_FILES['rtopimg']);
                    if($info) {// 上传错误提示错误信息
                        // $this->error($upload->getError());
                        $fullpath = $upload->rootPath.$info['savepath'].$info['savename'];
                        $rtopimgpath = $info['savepath'].$info['savename'];
                        
                        $image = new \Think\Image();
                        $image->open($fullpath);
                        // 生成图片我的缩略图大小并替换原图
                        $image->thumb(800, 450,\Think\Image::IMAGE_THUMB_FIXED)->save($fullpath);
                        $result = $Data->where("rid=$newid")->setField('rtopimg',$rtopimgpath);
                    }else{
                        $this->error($upload->getError());
                    }
                }
                
                if($result){
                    $this->success('课程已发布！');
                }else{
                    $this->error('发布错误！');
                }
            }
            
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    public function delete_course(){
        if (isset($_SESSION['adminid'])) {
            $rid= $_GET['id'];
            $adminid= $_SESSION['adminid'];
            $Data = M('resources');
            $result = $Data->where("rid='" . $rid . "'")->delete();
            $this->success('删除成功！');
            $this->redirect('/Nmadmin/Course');
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    public function changecourse(){
        if (isset($_SESSION['adminid'])) {
            $rid= $_GET['id'];
            $Data = M('resources');
            $where ="rid='" . $rid . "'";
            $result = $Data->where($where)->find();
            $this->assign('course',$result);
            $this->display();
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    public function change_course(){
        if (isset($_SESSION['adminid'])) {
            $Data = M('resources');
            if($Data->create()){
                if($_FILES['rtopimg']['size'] > 0){
                    //上传图片
                    $postid = $_POST['rid'];
                    $upload = new \Think\Upload();// 实例化上传类
                    $upload->maxSize = 2*1024*1024;// 设置附件上传大小:2M
                    $upload->exts = array('jpg', 'png', 'jpeg');// 设置附件上传类型
                    $upload->rootPath = './Public/resources/'; // 设置附件上传根目录
                    $upload->autoSub = true;//关闭。生成子目录
                    $upload->subName = "course_$postid";
                    $upload->saveName = "course_$postid";
                    $upload->saveExt = "jpg";//固定后缀
                    $upload->replace = true;//允许替换
                    
                    // 上传单个文件
                    $info   =   $upload->uploadOne($_FILES['rtopimg']);
                    if($info) {// 上传错误提示错误信息
                        // $this->error($upload->getError());
                        $fullpath = $upload->rootPath.$info['savepath'].$info['savename'];
                        $Data->rtopimg = $info['savepath'].$info['savename'];
                        
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
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    public function change_attachment(){
        if (isset($_SESSION['adminid'])) {
            $Data = M('resources');
            $rtype = $_POST['rattachtype'];
            if ($rtype == 1){
                if($_FILES["rattachment"]["type"] != "application/x-shockwave-flash" ||get_ext($_FILES["rattachment"]["name"]) != "swf"){
                    $this->error("附件文件扩展名与所需类型不一致，请检查！");
                }
            }else if ($rtype == 2){
                if($_FILES["rattachment"]["type"] != "video/mp4" ||get_ext($_FILES["rattachment"]["name"]) != "mp4"){
                    $this->error("附件文件扩展名与所需类型不一致，请检查！");
                }
            }else if ($rtype == 3){
                if($_FILES["rattachment"]["type"] != "text/html" ||get_ext($_FILES["rattachment"]["name"]) != "html"){
                    $this->error("unity网页文件扩展名与所需类型不一致，请检查！");
                }else if(get_ext($_FILES["uattachment"]["name"]) != "unity3d"){
                    $this->error("unity资源包扩展名与所需类型不一致，请检查！");
                }
            }else{
                $this->error("文件类型未指定");
            }
            if($Data->create()){
                if($_FILES['rattachment']['size'] > 0){
                    //上传附件
                    $postid = $_POST['rid'];
                    $upload = new \Think\Upload();// 实例化上传类
                    $upload->maxSize = 50*1024*1024;// 设置附件上传大小:2M
                    $upload->exts = array('swf', 'mp4', 'html');// 设置附件上传类型
                    $upload->rootPath = './Public/resources/'; // 设置附件上传根目录
                    $upload->autoSub = true;//关闭。生成子目录
                    $upload->subName = "course_$postid";
                    $upload->saveName = "";
                    $upload->replace = true;//允许替换
                    
                    // 上传单个文件
                    $info   =   $upload->uploadOne($_FILES['rattachment']);
                    if($info) {// 上传错误提示错误信息
                        
                        $fullpath = $upload->rootPath.$info['savepath'].$info['savename'];
                        $Data->rattachment = $info['savepath'].$info['savename'];
                    }else{
                        $this->error($upload->getError());
                    }
                }
                if($rtype == 3 && $_FILES['uattachment']['size'] > 0){
                    //上传附件
                    $postid = $_POST['rid'];
                    $upload = new \Think\Upload();// 实例化上传类
                    $upload->maxSize = 100*1024*1024;// 设置附件上传大小:2M
                    $upload->rootPath = './Public/resources/'; // 设置附件上传根目录
                    $upload->autoSub = true;//关闭。生成子目录
                    $upload->subName = "course_$postid";
                    $upload->saveName = "";
                    $upload->replace = true;//允许替换
                    
                    // 上传单个文件
                    $info   =   $upload->uploadOne($_FILES['uattachment']);
                    if($info) {// 上传错误提示错误信息
                        
                        $fullpath = $upload->rootPath.$info['savepath'].$info['savename'];
                        $Data->uattachment = $info['savepath'].$info['savename'];
                    }else{
                        $this->error($upload->getError());
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
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    // public function addsection(){
    //     if (isset($_SESSION['adminid'])) {
    //         $id= $_GET['id'];
    //         $Data = M('resources');
    //         $where ="id='" . $id . "'";
    //         $result = $Data->where($where)->find();
    //         $this->assign('course',$result);
    //         $this->display();
    //     }else{
    //         $this->redirect('/Nmadmin/Form/login');
    //     }
    // }
    // public function add_section(){
    //     if (isset($_SESSION['adminid'])) {
    //         $Data = M('section');
    //         if($Data->create()){
    //              $Data->paper='#';
    //              $Data->resource='#';
    //              $Data->courseware='#';
    //              $result = $Data->add();
    //             if($result){
    //                 $this->success('新章节已发布！');
    //                 }else{
    //                     $this->error('发布错误！');
    //                 }
    //         }
    //     }
    //     else{
    //         $this->redirect('/Nmadmin/Form/login');
    //     }
    // }
    // public function changesection(){
    //     if (isset($_SESSION['adminid'])) {
    //         $id= $_GET['id'];
    //         $Data = M('section');
    //         $where ="sectionid='" . $id . "'";
    //         $result = $Data->where($where)->find();
    //         $this->assign('section',$result);
    //         $this->display();
    //     }else{
    //         $this->redirect('/Nmadmin/Form/login');
    //     }
    // }
    // public function change_section(){
    //     if (isset($_SESSION['adminid'])) {
    //         $Data = M('section');
    //         if($Data->create()){
    //              $Data->paper='#';
    //              $Data->resource='#';
    //              $Data->courseware='#';
    //              $result = $Data->save();
    //             if($result){
    //                 $this->success('章节已修改！');
    //                 }else{
    //                     $this->error('修改错误！');
    //                 }
    //         }
    //     }
    //     else{
    //         $this->redirect('/Nmadmin/Form/login');
    //     }
    // }
    public function add_courseware(){
        if (isset($_SESSION['adminid'])) {
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
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    public function add_paper(){
        if (isset($_SESSION['adminid'])) {
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
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    public function add_resource(){
        if (isset($_SESSION['adminid'])) {
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
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    public function delete_section(){
        if (isset($_SESSION['adminid'])) {
            $id= $_GET['id'];
            $Data = M('section');
            $result = $Data->where("sectionid='" . $id . "'")->delete();
            $this->success('删除成功！');
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    public function delete($usernameA = ''){
        if (isset($_SESSION['usernameA'])) {
            $id= $_GET['id'];
            $Data = M('book');
            $result = $Data->where("id='" . $id . "'")->delete();
            $this->success('删除成功！');
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
    }
}