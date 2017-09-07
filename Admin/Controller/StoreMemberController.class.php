<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;
use Think\Page;

class StoreMemberController extends BaseController
{
	public function index(){
		$where['state'] = C('NORMAL_STATUS');
        $where['category_id'] = C('CATEGORY_CEMETERY_ID');
        $store = M('store')->where($where)->field('store_id,store_name')->select();
        $where = array();
        $store_id = I('get.store_id');
        $pid = I('get.pid');
        if(!empty($store_id)){
            $condition['store_id'] = $store_id;
        }
        if(!empty($pid)){
            $condition['pid'] = $pid;
        }

        $storeMemberData = M('StoreMember');
        $condition['admin_id'] = array('neq',0);
        $total = $storeMemberData->where($condition)->count();
        $page = new Page($total,C('PAGE_SIZE'));
        $pageshow = $page->show();
        $list = $storeMemberData->where($condition)->limit($page->firstRow,$page->listRows)->order('store_name asc')->select();
        $condition['admin_id'] = 0;
        $datas = $storeMemberData->where($condition)->select();
        $levels = array();
        if($total > 1){
            foreach ($list as $key => $val) {
                $levels[$key] = $val;
                foreach ($datas as $k => $v) {
                    if(strstr($v['store_login_name'],$val['store_login_name'].'_')){
                        $levels[$key]['sublevel'][] = $v;
                    }
                }
            }
        }else{
            $levels = $list;
        }
        // 获取所有集团
        $groupData = M('Category')->where('pid='.C('CATEGORY_GROUP_ID').' and is_show='.C('NORMAL_STATUS'))->field('cid,name')->select();
        $group = array();
        if(!empty($groupData)){
            foreach($groupData as $k => $v){
                $group[$v['cid']] = $v;
            }
        }
        $this->page = $pageshow;
        $this->list = $levels;
        $this->group = $group;
        $this->store = $store;
		$this->display();
	}

	/**
     * 添加账号
     * 
     * @return void
     */
    public function add(){
        if(IS_POST){
            $result = array('flag'=>0,'msg'=>'操作失败');
            $postData = I('post.');
            $storeMemberModel = M('StoreMember');
            $storemember = $storeMemberModel->field('id')->where("store_login_name='".$postData['store_login_name']."'")->find();
            if(!empty($storemember)){
                $result = array('flag'=>0,'msg'=>'该账号已经存在');
            }else{
                if(!empty($postData['store'])){
                    $storeArr = explode('-',$postData['store']);
                    $data['store_id'] = $storeArr[0];
                    $data['store_name'] = $storeArr[1];
                }
                if(!empty($postData['pid'])){
                    $data['pid'] = $postData['pid'];
                }
                $data['store_login_name'] = $postData['store_login_name'];
                $data['store_login_pwd'] = encryptAdmin($postData['store_login_pwd']);
                $data['admin_id'] = session('admin_id');
                $data['created_time'] = date('Y-m-d H:i:s');
                $data['updated_time'] = date('Y-m-d H:i:s');
                $data['status'] = C('NORMAL_STATUS');
                if($storeMemberModel->create($data) && $storeMemberModel->add()){
                    $result['flag'] = 1;
                    $result['msg'] = '添加成功';
                }
            }
            echo json_encode($result);
        }
    }
    
    /**
     * 禁用或启用
     * 
     * @return void
     */
    public function delete(){
        if(IS_POST){
            $result = array('flag'=>0,'msg'=>'操作失败');
            $postData = I('post.');
            $StoreMemberModel = M('StoreMember');
            $data['id'] = $postData['id'];
            if($postData['act'] == 'del'){
                $parent = $StoreMemberModel->where($data)->field('id,store_login_name,admin_id')->find();
                if($parent['admin_id'] != 0){
                    // 如果禁用的是父账号
                    $allAccount = $StoreMemberModel->where('admin_id = 0')->field('id,store_login_name')->select();
                    // 查出所有父账号下的子账号
                    if($allAccount){
                        foreach ($allAccount as $key => $val) {
                            if(strstr($val['store_login_name'],$parent['store_login_name'].'_')){
                                $ids[] = $val['id'];
                            }
                        }
                    }
                    array_push($ids, $postData['id']);
                    // 禁用所有子账号(包括父账号)
                    $data['id'] = array('in',$ids);
                }
                $data['status'] = C('DELETE_STATUS');
            }else if($postData['act'] == 'enable'){
                $data['status'] = C('NORMAL_STATUS');
            }
            if($StoreMemberModel->data($data)->save()){
                $result['flag'] = 1;
                $result['msg'] = '操作成功';
            }
            echo json_encode($result);
        }
    }
    
    /**
     * 修改密码
     * 
     * @return void
     */
    public function edit() {
        $storeMemberModel = M('StoreMember');
        if(IS_POST){
            $postData = I('post.');
            $storeMember = $storeMemberModel->field('id')->find($postData['id']);
            $result = array('flag'=>0,'msg'=>'操作失败');
            if(!empty($storeMember)){
                $password = encryptAdmin($postData['store_login_pwd']);
                $updateResult = $storeMemberModel->where('id='.$postData['id'])->setField('store_login_pwd', $password);
                if($updateResult!==false){
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }
            }
        }else{
            $id = I('get.id');
            $storeMember = $storeMemberModel->find($id);
            if(!empty($storeMember)){
                $result['flag'] = 1;
                $result['data'] = $storeMember;
            }else{
                $result['flag'] = 0;
                $result['data'] = '';
            }
        }
        echo json_encode($result);
    }

    public function getStoreCenterPrivilege(){
        $storeMember = M('StoreMember');
        $result = array('flag' => 0,'msg' => '操作失败');
        if(IS_POST){
            $priData = I('post.');
            $data['id'] = $priData['id'];
            $data['privilege'] = '';
            if($priData['rules']){
                $priTree = implode(',',$priData['rules']);
                if(!empty($priTree)){
                    $data['privilege'] = $priTree;
                }
            }
            if($storeMember->data($data)->save()){
                $result = array('flag' => 1,'msg' => '操作成功');
            }
        }else{
            $id = I('get.id');
            $userPri = $storeMember->where('id='.$id)->field('privilege')->find();
            $privilegeModel = M('StoreCenterPrivilege');
            $privileges = $privilegeModel->where('status='.C('NORMAL_STATUS'))->field('id,level,pid,name,title')->order('sort desc')->select();
            $privilegeTree = $this->getTree($privileges, 0);
            $result = array('flag' => 1,'data' => $privilegeTree,'pri' => $userPri['privilege']);
        }
        echo json_encode($result);
    }

    public function getTree($data,$pid=0){
        $result = array();
        foreach ($data as $v){
            // 找当前分类的子分类，默认从顶级开始找
            if ($v['pid'] == $pid){
                // 找到了，继续以找到的分类为当前分类，找它的后代节点,并将结果放到当前元素的下标为child的元素中
                $v['child'] = $this->getTree($data,$v['id']);
                // 然后将$v 保存到$list中
                $result[] = $v;
            }
        }
        return $result;
    }
}