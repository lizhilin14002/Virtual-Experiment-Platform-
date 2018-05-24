<?php
namespace Nmadmin\Controller;
use Think\Controller;
class SlideshowController extends Controller {
    public function index($adminid = ''){
        if (isset($_SESSION['adminid'])) {
        	$Data2 = M('slideshow');
	        $focus2 = $Data2->field('url')->select();
	        $this->assign('list',$focus2);

            $this->display();
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
        
    }
    public function change($adminid = ''){
    	$id = $_GET['id'];

	    if (isset($_SESSION['adminid'])) {
	    	$Data=D("Slideshow");
	    	if($Data->create()){

	            if(isset($_FILES['img'])){
	            //上传图片
	            $upload = new \Think\Upload();// 实例化上传类
	            $upload->maxSize = 2*1024*1024;// 设置附件上传大小:2M
	            $upload->exts = array('jpg');// 设置附件上传类型
	            $upload->rootPath = './Public/image/'; // 设置附件上传根目录
	            $upload->savePath = '';
	            $upload->saveName = "Slideshow$id";//固定文件名
	            $upload->saveExt = "jpg";//固定后缀
	            $upload->replace = true;//允许替换
	            $upload->autoSub = false;//关闭。生成子目录
	            // 上传单个文件 
	            $info = $upload->uploadOne($_FILES['img']);
	            if($info){
	            	$fullpath = $upload->rootPath.$info['savename'];
	                $image = new \Think\Image(); 
	                $image->open($fullpath);
	                // 生成一个固定大小1920*700的缩略图并替换原图
	                $image->thumb(1920, 700,\Think\Image::IMAGE_THUMB_FIXED)->save($fullpath);
	            }

	          if(isset($_POST['url'])){
	          	$Data->url = $_POST['url'];
	          	$where ="id='" . $id . "'";
	          	$result = $Data->where($where)->save();
	          	if(!$result) {// 上传错误提示错误信息
	                $this->error("修改成功！");
	            }else{
	            	$this->success('修改成功！'); 
	                $this->redirect('/Nmadmin/Slideshow');
	            }
	          }
	      }}else{$this->error('未输入数据！');}
	            }else{$this->redirect('/Nmadmin/Form/login');}
	}

}