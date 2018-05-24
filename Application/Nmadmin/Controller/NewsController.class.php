<?php
namespace Nmadmin\Controller;
use Think\Controller;
class NewsController extends Controller {
    // public function index($adminid = ''){
    //     if (isset($_SESSION['adminid'])) {
    //         $Data = M('News');
    //         $count = $Data->count();
    //         $p = getpage($count,10);
    //         $result = $Data->limit($p->firstRow, $p->listRows)->select();
    //         $this->assign('empty','<span class="empty">暂无新闻</span>');
    //         $this->assign('list',$result);
    //         $this->assign('page', $p->show());
    //         $this->display();
    //     }else{
    //         $this->redirect('/Nmadmin/Form/login');
    //     }
    // }
    
    public function index($adminid = '',$type1id = '',$type2id = ''){
        if (isset($_SESSION['adminid'])) {
            $type1id = $_GET['type1id'];
            $type2id = $_GET['type2id'];
            $nav = M('type1');
            $nav2 = M('type2');
            $news = M('news');
            //获取一级导航名称
            $nav1name = $nav->where("type1id=$type1id")->find();
            $this->assign('nav1name',$nav1name['type1name']);
            if($type2id == ''){
                //仅一级导航列表、无子集
                $count = $news->where("type1id=$type1id")->count();
                $p = getpage($count,10);
                $list = $news->where("type1id=$type1id")->order('newsid desc')->limit($p->firstRow, $p->listRows)->select();
                $this->assign('page', $p->show());
            }else{
                //获取二级导航名称
                $nav2name = $nav2->where("type2id=$type2id")->find();
                $this->assign('nav2name',$nav2name['type2name']);
                if($nav2name['mtype']=='1'){
                    //单独页面
                    $newsid = $nav2name['alonenewsid'];
                    //至读页修改
                    $this->redirect('News/change', array('id' => $newsid));
                }else{
                    //文章列表
                    $count = $news->where("type2id=$type2id")->count();
                    $p = getpage($count,10);
                    $list = $news->where("type2id=$type2id")->order('newsid desc')->limit($p->firstRow, $p->listRows)->select();
                    $this->assign('page', $p->show());
                }
            }
            $this->assign('choose',$nav2name['mtype']);
            $this->assign('list',$list);
            $this->assign('empty','<span class="empty">暂无新闻</span>');
            $this->assign('page', $p->show());
            $this->display();
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    public function add_process($adminid = ''){
        if (isset($_SESSION['adminid'])) {
            $Data = M('News');
            if($Data->create()){
                //添加时间信息
                $Data->newsaddtime = date("Y-m-d H:i:s" ,time());
                $result = $Data->add();
                $newid = $result;
                if($_FILES['newsimg']['size'] > 0){
                    $upload = new \Think\Upload();// 实例化上传类
                    $upload->maxSize = 2*1024*1024;// 设置附件上传大小:2M
                    $upload->exts = array('jpg', 'png', 'jpeg');// 设置附件上传类型
                    $upload->rootPath = './Public/image/'; // 设置附件上传根目录
                    $upload->autoSub = false;//关闭。生成子目录
                    // $upload->subName = "course_$newid";
                    $upload->saveName = "course_$newid";
                    $upload->saveExt = "jpg";//固定后缀
                    $upload->replace = true;//允许替换
                    
                    // 上传单个文件
                    $info   =   $upload->uploadOne($_FILES['newsimg']);
                    if($info) {// 上传错误提示错误信息
                        // $this->error($upload->getError());
                        $fullpath = $upload->rootPath.$info['savename'];
                        $newsimgpath = $info['savename'];
                        
                        $image = new \Think\Image();
                        $image->open($fullpath);
                        // 生成图片我的缩略图大小并替换原图
                        $image->thumb(800, 450,\Think\Image::IMAGE_THUMB_FIXED)->save($fullpath);
                        $result = $Data->where("newsid=$newid")->setField('newsimg',$newsimgpath);
                    }else{
                        $this->error($upload->getError());
                    }
                }
                
                if($result){
                    $this->success('文章已发布！');
                }else{
                    $this->error('发布错误！');
                }
            }
            
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    public function change_process($adminid = ''){
        if (isset($_SESSION['adminid'])) {
            $Data = M('News');
            if($Data->create()){
                $Data->newsaddtime = date("Y-m-d H:i:s" ,time());
                if($_FILES['newsimg']['size'] > 0){
                    //上传图片
                    $postid = $_POST['newsid'];
                    $upload = new \Think\Upload();// 实例化上传类
                    $upload->maxSize = 2*1024*1024;// 设置附件上传大小:2M
                    $upload->exts = array('jpg', 'png', 'jpeg');// 设置附件上传类型
                    $upload->rootPath = './Public/image/'; // 设置附件上传根目录
                    $upload->autoSub = false;//关闭。生成子目录
                    // $upload->subName = "course_$postid";
                    $upload->saveName = "course_$postid";
                    $upload->saveExt = "jpg";//固定后缀
                    $upload->replace = true;//允许替换
                    
                    // 上传单个文件
                    $info   =   $upload->uploadOne($_FILES['newsimg']);
                    if($info) {// 上传错误提示错误信息
                        // $this->error($upload->getError());
                        $fullpath = $upload->rootPath.$info['savename'];
                        $Data->newsimg = $info['savename'];
                        
                        $image = new \Think\Image();
                        $image->open($fullpath);
                        // 生成图片我的缩略图大小并替换原图
                        $image->thumb(800, 450,\Think\Image::IMAGE_THUMB_FIXED)->save($fullpath);
                    }
                }
                $result = $Data->save();
                //获取全路径
                
                if($result !== "false"){
                    $this->success('文章信息已修改！');
                }else{
                    $this->error('文章信息修改错误！');
                }
            }
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    public function change($adminid = ''){
        if (isset($_SESSION['adminid'])) {
            $id= $_GET['id'];
            $Data = M('News');
            $result = $Data->find($id);
            $this->assign('list',$result);
            $this->display();
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    public function delete($adminid = ''){
        if (isset($_SESSION['adminid'])) {
            $id= $_GET['id'];
            $Data = M('News');
            $result = $Data->where("id='" . $id . "'")->delete();
            $this->success('删除成功！');
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
    }
    public function delete_all($adminid = ''){
        $adminid = $_SESSION['adminid'];
        $id = $_GET['id'];
        if(isset($adminid)){
            $Data = M('News');//获取当期模块的操作对象
            //判断id是数组还是一个数值
            if(is_array($id)){
                $where = 'id in('.implode(',',$id).')';
            }else{
                $where = 'id='.$id;
            }
            $list=$Data->where($where)->delete();
            if($list!==false) {
                $this->success("成功删除{$list}条！");
            }else{
                $this->error('删除失败！');
            }
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
    }
}