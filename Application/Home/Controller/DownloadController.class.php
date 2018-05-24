<?php
namespace Home\Controller;
use Think\Controller;
class DownloadController extends Controller {
    
    public function index(){
        
        $this->nav();
        $downloads = M('downloads'); 

        $this->assign('empty','<span class="empty">查无结果</span>');
        $count = $downloads->count();
        $p = getpage($count,10);
        $downloadslist = $downloads->order('did desc')->limit($p->firstRow, $p->listRows)->select();

        $this->assign('page', $p->show());
        $this->assign('downloadslist',$downloadslist);

        $this->display();
    }

    public function download(){
        if (isset($_SESSION['username'])) {
            $did= $_GET['id'];
            $this->nav();
            $download = M('downloads'); 
            $result = $download->find($did);
            $this->assign('result', $result);
            $this->display();
        }else{
            $this->redirect('/Home/Form/login');
        }
    }

    public function nav(){
        //顶部导航
        $nav = M('type1');
        $navlist = $nav->select();
        $this->assign('navlist',$navlist);
    }

}