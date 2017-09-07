<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;

/**
 * 商家后台菜单管理
 *
 * @author WangQiang
 * @version 1.0
 */
class StoreCenterPrivilegeController extends BaseController
{
    public function storePrivilegeList(){
        // 获取点击的左侧菜单显示菜单
        $first = array();
        $two = array();
        $three = array();
        $id = I('get.id');
        // 获取当前菜单
        // 获取该菜单下的功能块
        $firstWhere['level'] = 1;
        $first = M('StoreCenterPrivilege')->field('id,title')->where($firstWhere)->order('sort desc')->select();
        // dump($first);exit;
        if(!empty($first)){
            foreach($first as $v){
                $ids[] = $v['id'];
            }
            //该功能块下的菜单
            $where['pid'] = array('in', $ids);
            $twoPrivilege = M('StoreCenterPrivilege')->field('id,title,pid')->where($where)->order('sort desc, id desc')->select();
            //获取该菜单下的操作方法
            if(!empty($twoPrivilege)){
                $childIds = array();
                foreach ($twoPrivilege as $val){
                    $childIds[] = $val['id'];
                    $two[$val['pid']][] = $val;
                }
                $whereThree['pid'] = array('in', $childIds);
                $subPrivilege = M('StoreCenterPrivilege')->field('id,title,pid')->where($whereThree)->order('sort desc, id desc')->select();
                if(!empty($subPrivilege)){
                    foreach ($subPrivilege as $value){
                        $three[$value['pid']][] = $value;
                    }
                }
            }
        }
        $this->assign('first',$first);
        $this->assign('two',$two);
        $this->assign('three',$three);
        $this->display();
    }

    public function addPrivilege(){
        if(IS_POST){
            $result = array('flag' => 0,'msg' => '添加失败');
            $info = I('Privilege');
            $info['level'] = 0;
            $info['create_time'] = time();
            $info['admin_id'] = session('admin_id');
            $privilegeModel = M('StoreCenterPrivilege');
            $pid = $info['pid'];
            $info['level'] = 1;
            if($pid != 0){
                $preprivilege = $privilegeModel->field('level')->where('id='.$pid)->find();
                if(!empty($preprivilege)){
                    $info['level'] = $preprivilege['level'] + 1;
                }
            }
            if($privilegeModel->data($info)->add()){
                $result['flag'] = 1;
                $result['msg'] = '添加成功';
            }
            echo json_encode($result);
        }
    }

    /**
     * 修改菜单
     */
    public function editPrivilege(){
        $result = array('flag' => 0,'msg' => '操作失败');
        if(IS_GET){
            $id = I('get.id');
            $result['flag'] = 0;
            $currentprivilege = M('StoreCenterPrivilege')->where('id='.$id)->find();
            $privilegedatas = M('StoreCenterPrivilege')->field('id,title,level,pid')
                ->where('level in (0,1,2) and status='.C('NORMAL_STATUS'))
                ->select();
            $privilegeTree = D('privilege')->getPrivilegeTree($privilegedatas, 0);
            if(!empty($currentprivilege)){
                $result['flag'] = 1;
                $result['privilegeTree'] = $privilegeTree;
                $result['currentprivilege'] = $currentprivilege;
            }
        }elseif(IS_POST){
            $editData = I('post.editPrivilege');
            $id = $editData['id'];
            //获取该权限原来的pid
            $privilegeModel = M('StoreCenterPrivilege');
            $oldprivilege = $privilegeModel->field('pid')->where('id='.$id)->find();
            if(!empty($oldprivilege)){
                //获取该类别下的菜单下的所有子类
                $childPrivilegeIds = $this->getChildPrivilege($id);
                if(in_array($editData['pid'], $childPrivilegeIds)){
                    $result['flag'] = 0;
                    $result['msg'] = '修改后其上级菜单不能为自己的子菜单';
                }else{
                    $preprivilege = $privilegeModel->field('level')->where('id='.$editData['pid'])->find();
                    if(empty($preprivilege)){
                        $editData['level'] = 1;
                    }else{
                        $editData['level'] = $preprivilege['level'] + 1;
                    }
                    $editData['update_time'] = NOW_TIME;
                    if($privilegeModel->data($editData)->save()){
                        $result['flag'] = 1;
                        $result['msg'] = '修改成功';
                    }
                }
            }
        }
        echo json_encode($result);
    }

    /*
     * 删除菜单
     */
    public function delPrivilege(){
        $result = array('flag'=>0,'msg'=>'删除失败！');
        $id = I('post.id');
        if(!empty($id)){
            $privilegeModel = M('StoreCenterPrivilege');
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

    /**
     * 获取菜单权限信息,取去前三级的权限
     */
    public function getPrivilege(){
        $privilegedatas = M('StoreCenterPrivilege')->field('id,title,level,pid')->where('level in (0,1,2) and status='.C('NORMAL_STATUS'))->select();
        $result['flag'] = 0;
        $result['data'] = array();
        $privilegeTree = D('privilege')->getPrivilegeTree($privilegedatas, 0);
        if(!empty($privilegeTree)){
            $result['flag'] = 1;
            $result['data'] = $privilegeTree;
        }
        echo json_encode($result);
    }

    public function getChildPrivilege($pid = array()){
        static $result = array();
        $where['pid'] = array('in',$pid);
        $where['status'] = C('NORMAL_STATUS');
        $data = M('StoreCenterPrivilege')->where($where)->select();
        foreach($data as $v){
            $pids[] = $v['id'];
            $result[] = $v['id'];
        }
        if(!empty($pids)){
            $this->getChildPrivilege($pids);    //递归调用
        }
        return $result;
    }
}