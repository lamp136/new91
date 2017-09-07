<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;

/**
 * Description of PositionController
 *
 * @author hqy
 * @version 1.0
 */
class PositionController extends BaseController{
    
    public function index(){
        $roleModel = D('role');
        $list = $roleModel->getData();
        $treeData = $roleModel::getAllRoleData($list, 0);
        $this->assign('list', $treeData); 
        $this->display();
    }
    
    /**
     * 获取部门信息
     */
    public function getdepartment(){
        $roleModel = D('role');
        $data = $roleModel->getData(0);
        if(empty($data)){
            $result['flag'] = 0;
            $result['data'] = '请先添加部门';
        }else{
            $result['flag'] = 1;
            $result['data'] = $data;
        }
        echo json_encode($result);
    }
    
    /**
     * 添加职位
     */
    public function addposition(){
        if(IS_POST){
            $info = I('post.info');
            $roleData['type'] = C('ROLE_TYPE');
            $roleData['title'] = $info['title'];
            $roleData['level'] = 1;
            $roleData['pid'] = $info['pid'];
            $roleData['sort'] = $info['sort'];
            $roleData['status'] = C('NORMAL_STATUS');
            
            $roleModel = M('role');
            if($roleModel->create($roleData) && $roleModel->add()){
                $result['flag']=1;
                $result['msg'] = '添加成功';
            }else{
                $result['flag']=0;
                $result['msg'] = '添加失败';
            }
            echo json_encode($result);
        }
    }
    
    /**
     * 删除职位
     */
    public function delposition(){
        if(IS_POST){
            $id = I('post.id');
            $info['status'] = I('post.status');
            $info['id'] = $id;
            $roleModel = M('role');
            if($roleModel->save($info)){
                 $result['flag']=1;
                 $result['msg'] = '删除成功';
             }else{
                 $result['flag']=0;
                 $result['msg'] = '删除失败';
             }
             echo json_encode($result);
       }
    }
    
    /**
     * 编辑职位
     */
    public function editposition(){
        $roleModel = D('role');
        if(IS_POST){
            $info = I('post.editinfo');
            $roleData['id'] = $info['id'];
            $roleData['title'] = $info['title'];
            $roleData['sort'] = $info['sort'];
            $roleData['pid'] = $info['pid'];
            if($roleModel->create($roleData) && $roleModel->save()){
                $result['flag']=1;
                $result['msg'] = '修改成功';
            }else{
                $result['flag']=0;
                $result['msg'] = '修改失败';
            }
            
        }else{
            $id = I('get.id');
            $data = $roleModel->where('id='.$id)->find();
            $department = $roleModel->getData(0);
            if(!empty($data)){
                $result['flag']=1;
                $result['data'] = $data;
                $result['department'] = $department;
            }else{
                $result['flag']=0;
                $result['data'] = '';
            }
        }
        echo json_encode($result);
    }
    
    /**
     * 添加职位上的人员
     */
    public function adduser() {
        $roleuserModel = M('role_user');
        if(IS_POST){
            $positionId = I('post.position_id');
            $uid = I('post.uid');
            $result['flag'] = 0;
            $result['msg'] = '新增失败';
            if(empty($uid)){
                $result['flag'] = 0;
                $result['msg'] = '没有选择新增的人员';
            }else{
                $role = M('role')->where('id='.$positionId)->field('pid')->find();
                if(!empty($role)){
                    foreach($uid as $v){
                        $roleuserData['role_id'] = $role['pid'];
                        $roleuserData['role_job_id'] = $positionId;
                        $roleuserData['user_id'] = $v;
                        $roleuserModel->create($roleuserData);
                        $roleuserModel->add();
                        session('BusinessMen','');
                    }
                    $result['flag'] = 1;
                    $result['msg'] = '新增成功';
                }
            }
        }else{
            $id = I('get.id');
            //获取所有的用户信息
            $adminModel = M('admin');
            $admindata = $adminModel->field('id,nickname,email')->where("status=".C('NORMAL_STATUS'). " and email!='".C('ADMIN_EMAIL')."'")->select();
            //获取该职位下的人员
            $roleuser = $roleuserModel->field('user_id')->where('role_job_id='.$id)->select();
            $roleuserinfo = array();
            if(!empty($roleuser)){
                foreach($roleuser as $v){
                    $roleuserinfo[] = $v['user_id'];
                }
            }
            if(!empty($admindata)){
                $result['flag'] = 1;
                $result['admindata'] = $admindata;
                $result['roleuser'] = $roleuserinfo;
            }else{
                $result['flag'] = 0;
            }
        }
        echo json_encode($result);
    }
    
    
    /**
     * 查看职位对应的人员
     */
    public function positionuser(){
        if(IS_POST){
            $positionId = I('post.id');
            $roleuser = D('role_user')->where('role_job_id='.$positionId)->relation('Admin')->select();
            if(empty($roleuser)){
                $result['flag'] = 0;
                $result['data'] = '没有记录';
            }else{
                $result['flag'] = 1;
                $result['data'] = $roleuser;
            }
            echo json_encode($result);
        }
    }
    
    /**
     * 通过职位id和用户id 删除职位下对应的人员
     */
    public function delpositionuser(){
        if(IS_POST){
            $positionId = I('post.positionId');
            $userId = I('post.userId');
            $data = M('role_user')->where('role_job_id='.$positionId.' and user_id='.$userId)->delete();
            if($data){
                session('BusinessMen','');
                $result['flag'] = 1;
                $result['msg'] = '删除成功';
            }else{
                $result['flag'] = 0;
                $result['msg'] = '删除失败';
            }
            echo json_encode($result);
        }
    }
    
    /**
     * 职位权限的设置
     */
    public function privilegeset(){
        $roleModel = M('role');
        if(IS_POST){
            $id = I('post.id');
            $pri = I('post.rules');
            $priData = implode(',', $pri);
            if(empty($priData)){
                $info['privilege'] = '';
            }else{
                $info['privilege'] = $priData;
            }
            $info['id'] = $id;
            $roleModel->create($info);
            if($roleModel->save()!==false){
                $this->success('操作成功', U('index'));die;
            }else{
                $this->error('没有选择权限');die;
            }
            
        }else{
            $id = I('get.id');
            //获取所有顶级栏目的权限
            $first_privilege = M('privilege')->where('status='.C('NORMAL_STATUS').' and pid=0')->order('sort desc')->select();
            //获得所有的权限节点
            $privilegeModle = D('privilege');
            $privileges = $privilegeModle->where('status='.C('NORMAL_STATUS'))->order('sort desc')->select();
            $privilegeTree = $privilegeModle->getTree($privileges, 0);
            //dump($privilegeTree);die;
            //获得该职位的权限
            $roleData = $roleModel->where('id='.$id)->find();
            $role = explode(',', $roleData['privilege']);
            //var_dump($roleData);die;
            $this->assign('first_privilege',$first_privilege);
            $this->assign('privilegeTree',$privilegeTree);
            $this->assign('role',$role);
            $this->assign('rolename',$roleData['title']);
            $this->display();
        }
    }
}
