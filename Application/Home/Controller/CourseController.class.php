<?php
namespace Home\Controller;
use Think\Controller;
class CourseController extends Controller {
    
    public function index(){
        if(!$_GET['query']){
            $name = ''; 
        }else{
            $name = $_GET['query'];
        }
        $this->nav();
        $course = M('resources'); 

        $this->assign('empty','<span class="empty">查无结果</span>');
        $where = "rtitle like'%" .$name. "%' or rcontent like'%".$name."%'";
        $count = $course->where($where)->count();
        $p = getpage($count,16);
        $courselist = $course->where($where)->order('rid desc')->limit($p->firstRow, $p->listRows)->select();

        $this->assign('page', $p->show());
        $this->assign('courselist',$courselist);
        $this->display();
    }
    public function course(){
        if (isset($_SESSION['username'])) {
            $rid= $_GET['courseid'];
            $this->nav();
            $course = M('resources'); 
            $result = $course->find($rid);
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