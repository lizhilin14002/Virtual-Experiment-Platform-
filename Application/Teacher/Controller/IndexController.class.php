<?php
namespace Teacher\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        if (isset($_SESSION['teachername'])) {
            $Data = M('course');
        	$teacherid = $_SESSION['teacherid'];
            $where ="teacherid='" . $teacherid . "'";
            $result = $Data->order('id desc')->where($where)->select();

            $this->assign('mycourse',$result);
            $this->display();
        }else{
            $this->redirect('/Teacher/Form/login');
        }
        
    }
}