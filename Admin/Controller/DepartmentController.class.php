<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;
/**
 * Description of DepartmentController
 *
 * @author hqy
 * @version 1.0
 * @date 2016/7/12
 */
class DepartmentController extends BaseController{
    
    /**
     * 部门列表
     */
    public function index(){
        $where['type'] = C('DEPARTMENT_TYPE');
        //$where['status'] = C('NORMAL_STATUS');
        $list = M('role')->where($where)->order('sort desc,id desc')->select();
        $this->assign('list', $list); 
        $this->display();
    }
    
    /**
     * 部门添加
     */
    public function adddepartment() {
        if(IS_POST){
            $info = I('post.info');
            $roleData['type'] = C('DEPARTMENT_TYPE');
            $roleData['title'] = $info['title'];
            $roleData['level'] = 0;
            $roleData['pid'] = 0;
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
     * 删除部门
     */
    public function deldepartment() {
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
     * 修改部门
     */
    public function editdepartment(){
        $roleModel = M('role');
        if(IS_POST){
            $info = I('post.editinfo');
            $roleData['id'] = $info['id'];
            $roleData['title'] = $info['title'];
            $roleData['sort'] = $info['sort'];
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
            if(!empty($data)){
                $result['flag']=1;
                $result['data'] = $data;
            }else{
                $result['flag']=0;
                $result['data'] = '';
            }
        }
        echo json_encode($result);
    }
    
}
