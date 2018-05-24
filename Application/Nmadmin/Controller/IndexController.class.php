<?php
namespace Nmadmin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index($adminid = ''){
        if (isset($_SESSION['adminid'])) {
        	// $course = M('course');
            // $coursecount = $course->count();
            $User = M('User');
            $Usercount = $User->count();
            $News = M('News');
            $Newscount = $News->count();

            // $this->assign('course',$bookcount);
            $this->assign('User',$Usercount);
            $this->assign('News',$Newscount);
            $this->display();
        }else{
            $this->redirect('/Nmadmin/Form/login');
        }
        
    }
}