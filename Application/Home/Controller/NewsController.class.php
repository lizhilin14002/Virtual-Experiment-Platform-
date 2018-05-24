<?php
namespace Home\Controller;
use Think\Controller;
class NewsController extends Controller {
    
    public function index(){
        $type1= $_GET['type1'];
        $type2= $_GET['type2'];
        $nav = M('type1');
        $nav2 = M('type2');
        $news = M('news');
        $this->assign('empty','<span class="empty">暂无公告</span>');

        // 打印导航栏
        $this->nav($type1,$type2);

        //输出右侧部分
        if($type2==''){
            // $nav2list = $nav->field('type1name as type2name')->where("type1id=$type1")->select();
            // $this->assign('nav2list',$nav2list);
            $count = $news->where("type1id=$type1")->count();
            $p = getpage($count,10);
            $rightpart = $news->where("type1id=$type1")->order('newsid desc')->limit($p->firstRow, $p->listRows)->select();
            $this->assign('page', $p->show());
        }
        else if($type2!=''){
            $nav2name = $nav2->where("type2id=$type2")->find();
            $this->assign('nav2name',$nav2name);
            // $this->assign('ceshi',$nav2name['alonenewsid']);
            if($nav2name['mtype']=='1'){
                $newsid = $nav2name['alonenewsid'];
                $rightpart = $news->where("newsid=$newsid")->find();
                // $this->assign('ceshi',$nav2name['alonenewsid']);
            }else{
                $count = $news->where("type2id=$type2")->count();
                $p = getpage($count,10);
                $rightpart = $news->where("type2id=$type2")->order('newsid desc')->limit($p->firstRow, $p->listRows)->select();
                $this->assign('page', $p->show());
            }
        }  
        $this->assign('choose',$nav2name['mtype']);         
        $this->assign('result',$rightpart);
        $this->display();
    }

    public function news(){
        $nav = M('type1');
        $nav2 = M('type2');
        $newsid= $_GET['id'];
        $news = M('news');
        $result = $news->find($newsid);
        // $result = $news->join('type1 on news.type1id = type1.type1id')->find($newsid);
        $type1= $result['type1id'];
        $type2= $result['type2id'];
        if($type2!=''){
            $nav2name = $nav2->where("type2id=$type2")->find();
            $this->assign('nav2name',$nav2name);
        } 
        $this->nav($type1,$type2);
        $this->assign('result',$result);
        
        $this->display();
    }

    public function nav($type1,$type2){
        //顶部导航
        $nav = M('type1');
        $nav2 = M('type2');
        $navlist = $nav->select();
        $this->assign('navlist',$navlist);

        //获取该页所属一级导航的名称
        $nav1name = $nav->where("type1id=$type1")->find();
        $this->assign('nav1name',$nav1name);

        //获取所属一级导航下的二级导航列表
        $nav2list = $nav2->where("type1id=$type1")->select();
        $this->assign('nav2list',$nav2list);
    }

}