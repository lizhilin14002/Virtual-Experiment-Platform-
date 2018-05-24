<?php
namespace Nmadmin\Controller;
use Think\Controller;
class DownloadController extends Controller {
    public function index($adminid = ''){
        if (isset($_SESSION['adminid'])) {
            $Data = M('downloads');
            $count = $Data->count();
            $p = getpage($count,10);
            $result = $Data->limit($p->firstRow, $p->listRows)->select();
            $this->assign('empty','<span class="empty">暂无新闻</span>');
            $this->assign('list',$result);
            $this->assign('page', $p->show());
            $this->display();
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    public function add_process($adminid = ''){
        if (isset($_SESSION['adminid'])) {
            $Data = M('downloads');
            if($Data->create()){
                //添加时间信息
                $Data->daddtime = date("Y-m-d H:i:s" ,time());
                $result = $Data->add();
                $newid = $result;
                if($_FILES['dattachment']['size'] > 0){
                    $upload = new \Think\Upload();// 实例化上传类
                    $upload->maxSize = 20*1024*1024;// 设置附件上传大小:20M
                    $upload->exts = array('zip', '7z');// 设置附件上传类型
                    $upload->rootPath = './Public/downloads/'; // 设置附件上传根目录
                    $upload->autoSub = true;//关闭。生成子目录
                    $upload->subName = "downloads_$newid";
                    $upload->saveName = "downloads_$newid";
                    $upload->replace = true;//允许替换
                    
                    // 上传单个文件
                    $info   =   $upload->uploadOne($_FILES['dattachment']);
                    if($info) {// 上传错误提示错误信息
                        // $this->error($upload->getError());
                        $fullpath = $info['savepath'].$info['savename'];
                        
                        $result = $Data->where("did=$newid")->setField('dattachment',$fullpath);
                    }else{
                        $this->error($upload->getError());
                    }
                }
                
                if($result){
                    $this->success('资源共享已发布！');
                }else{
                    $this->error('发布错误！');
                }
            }
            
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    public function delete_download(){
        if (isset($_SESSION['adminid'])) {
            $did= $_GET['id'];
            $adminid= $_SESSION['adminid'];
            $Data = M('downloads');
            $result = $Data->where("did='" . $did . "'")->delete();
            $this->success('删除成功！');
            $this->redirect('/Nmadmin/Download');
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    public function change(){
        if (isset($_SESSION['adminid'])) {
            $did= $_GET['id'];
            $Data = M('downloads');
            $where = "did='" . $did . "'";
            $result = $Data->where($where)->find();
            $this->assign('list',$result);
            $this->display();
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    public function change_download(){
        if (isset($_SESSION['adminid'])) {
            $Data = D('downloads');
            if($Data->create()){
                $Data->daddtime = date("Y-m-d H:i:s" ,time());
                if($_FILES['dattachment']['size'] > 0){
                    //上传图片
                    $postid = $_POST['did'];
                    $upload = new \Think\Upload();// 实例化上传类
                    $upload->maxSize = 20*1024*1024;// 设置附件上传大小:20M
                    $upload->exts = array('7z', 'zip');// 设置附件上传类型
                    $upload->rootPath = './Public/downloads/'; // 设置附件上传根目录
                    $upload->autoSub = true;//关闭。生成子目录
                    $upload->subName = "downloads_$postid";
                    $upload->saveName = "downloads_$postid";
                    // $upload->saveExt = "jpg";//固定后缀
                    $upload->replace = true;//允许替换
                    
                    // 上传单个文件
                    $info   =   $upload->uploadOne($_FILES['dattachment']);
                    if($info) {// 上传错误提示错误信息
                        // $this->error($upload->getError());
                        $fullpath = $info['savepath'].$info['savename'];
                        $Data->dattachment = $fullpath;
                    }else{
                        $this->error($upload->getError());
                    }
                    $result = $Data->save();
                    //获取全路径
                    
                    if($result !== "false"){
                        $this->success('资源共享信息已修改！');
                    }else{
                        $this->error('资源共享信息修改错误！');
                    }
                }
            }
        }else{
                $this->redirect('/Nmadmin/Form/login');
            }
        }
    }