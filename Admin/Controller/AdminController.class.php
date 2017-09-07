<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;

/**
 * 后台用户控制器
 * @author hqy
 * @version 1.0
 * @date 2016/7/11
 */
class AdminController extends BaseController{
    /**
     * 添加用户
     */
    public function addAdmin()
    {
        if(IS_POST){
            $adminModel = M('admin');
            $password = I('post.pwd');
            $pwd = encryptAdmin($password);
            $data['nickname'] = I('post.nickname');
            $data['email'] = I('post.email');
            $data['email_address'] = I('post.email_address');
            $data['pwd'] = $pwd;
            $data['status'] = C("NORMAL_STATUS");
            $data['created_time'] = date('Y-m-d H:i:s');
            $data['updated_time'] = date('Y-m-d H:i:s');
            if($adminModel->add($data)){
                session('AllMen','');
                $this->redirect('Admin/adminList');
            }else{
                $this->error('添加失败');
            }
        }else{
            $this->display();
        }

    }
    /**
     * 用户列表
     */
    public function adminList()
    {
        //筛选条件
        $status = I('data');
        if(empty($status)){
            $where['status'] = C('NORMAL_STATUS');
        }else if($status == 'all'){
            $where['status'] = array('in',array('1','-1'));
        }else{
            $where['status'] = $status; 
        }
            
        $admin = M('admin');
        $p = I('get.p');
        $nowPage = empty($p)? C('PAGE_DEFAULT'):$p;
        $count = $admin->where($where)->count();
        $Page = new \Think\Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $list= $admin->limit($Page->firstRow, $Page->listRows)->where($where)->order('id DESC')->select();
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->assign('nowPage',$nowPage);
        $this->display();
    }
    /**
     * 修改密码
     */
    public function editPassword()
    {
        $result = array();
        $adminId = I('post.dataId');
        $pwd = I('post.pwd');
        if(!empty($adminId)){
            $data['pwd'] = encryptAdmin($pwd);
            $data['updated_time'] = date('Y-m-d H:i:s');
            $data['id'] = $adminId;
            $res = M('admin')->save($data);
            if($res){
                $result['flag'] = 1;
                $result['msg'] = '修改成功！';
            }else{
                $result['flag'] = 0;
                $result['msg'] = '修改失败！';
            }
        }else {
            $result['flag'] = 0;
            $result['msg'] = '操作失败！';
        }
        echo json_encode($result);
    }
    
    /**
     * 修改admin的的状态
     */
    public function updateStatus()
    {    
        $result = array('flag'=>0,'result'=>'操作失败！');
        $status = I("post.status");
        $data['id'] = I('post.id');
        if(!empty($data['id'])){
            if($status == C('NORMAL_STATUS')){
                $data['status'] = C('DELETE_STATUS');
            }else if($status == C('DELETE_STATUS')){
                $data['status'] = C('NORMAL_STATUS');
            }
            if(M('admin')->save($data)){
                $result['flag']   = 1;
                $result['result'] = '操作成功！';
            }
        }
        echo json_encode($result);
    }

    //验证登录账号唯一性
    public function checkEmail(){
        $result = array();
        $email = I('post.email');
        $info = M('admin')->where("email='$email'")->count();
        if($info){
            $result['flag'] = 0;
            $result['msg'] ='该用户已存在！';
        }else{
            $result['flag'] = 1;
            $result['msg'] ='合法用户！';
        }
        echo json_encode($result);
    }
    /*
     * 编辑用户信息
     * return string(json);
     */
    public function editAdmin(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $id = I('post.id');
        if(!empty($id)){
            $action = I('post.action');
            $adminModel= M('admin');
            if($action == 'get'){
                $data = $adminModel->where('id='.$id)->find();
                $result = array('flag'=>1,'data'=>$data);
            }else if($action == 'post'){
                $data = I('post.');
                //dump($data);die;
                $data['updated_time'] = date('Y-m-d H:i:s',time());
                
                $where['id'] = array('neq',$data['id']);
                //$where['nickname'] = I('nickname');
                $where['email'] = I('email');
                $judge = $adminModel->where($where)->count();
                if($judge){
                    $result = array('flag'=>3,'msg'=>'该登录用户名已存在！');
                }else if($adminModel->save($data)){
                    session('AllMen','');
                    $result = array('flag'=>2,'msg'=>'操作成功！');
                }
            }
        }
        echo json_encode($result);
    }
}