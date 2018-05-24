<?php
namespace Nmadmin\Controller;
use Think\Controller;
class UserController extends Controller {
    //用户管理
    public function index($adminid = ''){
        if (isset($_SESSION['adminid'])) {
            $Data = M('User');
            $count = $Data->count();
            $p = getpage($count,10);
            $result = $Data->limit($p->firstRow, $p->listRows)->select();
            $this->assign('empty','<span class="empty">暂无用户</span>');
            $this->assign('list',$result);
            $this->assign('page', $p->show());
            $this->display();
        }else{
            $this->redirect('/Admin/Form/login');
        }
        
    }
    //修改等级
    public function changerank($adminid = ''){
        if (isset($_SESSION['adminid'])) {
        $id= $_GET['id'];
        $rank = $_POST['rank'];
        $Data = M('User');
        $where ="id='" . $id . "'";
        $result = $Data-> where($where)->setField('rank',$rank);
            if($result){
                $this->success('等级调整成功！');
            }else{
                $this->error('等级调整失败！');
            }
        }else{
            $this->redirect('/Admin/Form/login');
        }
    }
}