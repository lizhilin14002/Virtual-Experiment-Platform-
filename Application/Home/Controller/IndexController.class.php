<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    
    public function index(){
        //首页课程推荐
        // $recommend = M();
        // $recommendlist = $recommend->query("SELECT recommend.id as rid,course.* FROM recommend left join course on recommend.courseid=course.id");
        // //$recommendlist = $recommend-> field('recommend.id as rid，course.*') ->join('course on recommend.courseid=course.id')->select();
        // $this->assign('recommendlist',$recommendlist);
        // // //收藏数统计
        // $collection = M('course');
        // $collectionrank = $collection->order('number desc')->limit(4)->select();
        // $this->assign('collectionrank',$collectionrank);
        // //课程数量统计
        // $Data = M('course');
        // $courselist = $Data->count();
        // $this->assign('coursenumber',$courselist);
        // //讲师统计
        // $teacher = M('teacher');
        // $teachernumber = $teacher->count();
        // $this->assign('teachernumber',$teachernumber);

        // $userlist = M('user');
        // $usernumber = $userlist->count();
        // $this->assign('usernumber',$usernumber);
        // //幻灯片
        // $Data2 = M('slideshow');
        // $focus2 = $Data2->select();
        // $this->assign('result',$focus2);
        // //新闻公告
        $Data1 = M('news');
        $focus1 = $Data1->where("type1id=3")->order('newsid desc')->limit(5)->select();
        $this->assign('newslist1',$focus1);
        $focus2 = $Data1->where("type2id=5")->order('newsid desc')->limit(4)->select();
        $this->assign('newslist2',$focus2);

        $course = M('resources'); 
        $courselist = $course->order('rid desc')->limit(12)->select();
        $this->assign('courselist',$courselist);

        $this->assign('courselist',$courselist);
        $nav = M('type1');
        $navlist = $nav->select();
        $this->assign('navlist',$navlist);
        $this->display();
    }
    public function about(){
    $Data = M('about');
    $result = $Data->find(1);
    $this->assign('result',$result);
    $this->display();
    }

}