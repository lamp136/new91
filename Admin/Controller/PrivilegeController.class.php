<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;

/**
 * 权限节点控制器
 *
 * @author hqy
 * @version 1.0
 */
class PrivilegeController extends BaseController {
    
    /**
     * 权限列表
     */
    public function index(){
        //获取level为零的菜单
        $map['pid'] = 0;
        $map['status'] = C('NORMAL_STATUS');
        $privilegeMenu = M('privilege')->field('title,id')->where($map)->order('sort desc')->select();
        
        //获取点击的左侧菜单显示菜单
        $first = array();
        $two = array();
        $three = array();
        $id = I('get.id');
        //获取当前菜单
        if(empty($id)){
           $currentPrivilege = M('privilege')->field('id,title')->where('status='.C('NORMAL_STATUS').' and pid=0')->order('sort desc')->find();
           $id = $currentPrivilege['id'];
        }else{
            $currentPrivilege = M('privilege')->field('id,title')->where('status='.C('NORMAL_STATUS').' and id='.$id)->order('sort desc')->find();
        }
        //获取该菜单下的功能块
        $first = M('privilege')->field('id,title')->where('pid='.$id)->order('sort desc')->select();
        
        if(!empty($first)){
            foreach($first as $v){
                $ids[] = $v['id'];
            }
            //该功能块下的菜单
            $where['pid'] = array('in', $ids);
            $twoPrivilege = M('privilege')->field('id,title,pid')->where($where)->order('sort desc, id desc')->select();
            //获取该菜单下的操作方法
            if(!empty($twoPrivilege)){
                $childIds = array();
                foreach ($twoPrivilege as $val){
                    $childIds[] = $val['id'];
                    $two[$val['pid']][] = $val;
                }
                $whereThree['pid'] = array('in', $childIds);
                $subPrivilege = M('privilege')->field('id,title,pid')->where($whereThree)->order('sort desc, id desc')->select();
                if(!empty($subPrivilege)){
                    foreach ($subPrivilege as $value){
                        $three[$value['pid']][] = $value;
                    }
                }
            }
        }
        $this->assign('privilegeMenu',$privilegeMenu);
        $this->assign('currentPrivilege',$currentPrivilege);
        $this->assign('first',$first);
        $this->assign('two',$two);
        $this->assign('three',$three);
        $this->display();
    }
    
    /**
     * 获取菜单权限信息,取去前三级的权限
     */
    public function getprivilege(){
        $privilegedatas = M('privilege')->field('id,title,level,pid')
                ->where('level in (0,1,2) and status='.C('NORMAL_STATUS'))
                ->select();
        $result['flag'] = 0;
        $result['data'] = array();
        $privilegeTree = D('privilege')->getPrivilegeTree($privilegedatas, 0);
        if(!empty($privilegeTree)){
            $result['flag'] =1;
            $result['data'] =$privilegeTree;
        }
        echo json_encode($result);
    }
    
    /**
     * 添加菜单
     */
    public function addprivilege() {
        if(IS_POST){
            $info = I('Privilege');
            $info['level'] = 0;
            $info['create_time'] = time();
            $info['admin_id'] = session('admin_id');
            $privilegeModel = M('privilege');
            $pid = $info['pid'];
            if($pid!=0){
                $preprivilege = $privilegeModel->field('level')->where('id='.$pid)->find();
                if(!empty($preprivilege)){
                    $info['level'] = $preprivilege['level']+1;
                }
            }
            if($privilegeModel->create($info) && $privilegeModel->add()){
                $result['flag'] = 1;
                $result['msg'] = '添加成功';
            }else{
                $result['flag'] = 0;
                $result['msg'] = '添加失败';
            }
            echo json_encode($result);
        }
    }
    
    /**
     * 修改菜单
     */
    public function editprivilege(){
        if(IS_GET){
            $id = I('get.id');
            $result['flag'] = 0;
            $currentprivilege = M('privilege')->where('id='.$id)->find();
            $privilegedatas = M('privilege')->field('id,title,level,pid')
                ->where('level in (0,1,2) and status='.C('NORMAL_STATUS'))
                ->select();
            $privilegeTree = D('privilege')->getPrivilegeTree($privilegedatas, 0);
            if(!empty($currentprivilege)){
                $result['flag'] = 1;
                $result['privilegeTree'] = $privilegeTree;
                $result['currentprivilege'] = $currentprivilege;
            }
            echo json_encode($result);
        }elseif(IS_POST){
            $editData = I('post.editPrivilege');
            $id = $editData['id'];
            //获取该权限原来的pid
            $oldprivilege = M('privilege')->field('pid')->where('id='.$id)->find();
            $privilegeModel = D('privilege');
            if(!empty($oldprivilege)){
                //获取该类别下的菜单下的所有子类
                $childPrivilegeIds = $privilegeModel->getChildPrivilege($id);
                if(in_array($editData['pid'], $childPrivilegeIds)){
                    $result['flag'] = 0;
                    $result['msg'] = '修改后其上级菜单不能为自己的子菜单';
                }else{
                    $preprivilege = $privilegeModel->field('level')->where('id='.$editData['pid'])->find();
                    if(!empty($preprivilege)){
                        $editData['level'] = $preprivilege['level']+1;
                    }else{
                        $editData['level'] = 0;
                    }
                    $privilegeModel->create($editData);
                    if($privilegeModel->save()!==FALSE){
                        $result['flag'] = 1;
                        $result['msg'] = '修改成功';
                    }else{
                        $result['flag'] = 0;
                        $result['msg'] = '修改失败';
                    }
                }
            }else{
                $result['flag'] = 0;
                $result['msg'] = '操作失败';
            }
            echo json_encode($result);
        }
    }
    /*
     * 删除菜单
     * return json
     */
    public function delprivilege(){
        $result = array('flag'=>0,'msg'=>'删除失败！');
        $id = I('post.id');
        if(!empty($id)){
            $privilegeModel = M('privilege');
            if($privilegeModel->where('pid='.$id)->field('id')->find()){
                $result['flag'] = 0;
                $result['msg'] = '有子菜单存在，不能删除！';
            }else if($privilegeModel->where('id='.$id)->delete()){
                $result['flag'] = 1;
                $result['msg'] = '删除成功！';
            }
        }
        echo json_encode($result);
    }
}
