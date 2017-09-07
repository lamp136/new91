<?php
namespace Home\Controller;

use Think\Controller;
use Think\Page;
use Think\Verify;
/**
 * 商家控制器
 *
 * @author Wang Qiang <wangqiang@huigeyuan.com>
 * @version 2.0
 */
class StorecenterController extends Controller
{
    public function _initialize(){
        $actionName = ACTION_NAME;
        $path = CONTROLLER_NAME.'/'.$actionName;

        // 没有登陆的话跳转到登陆页
        // 获取左侧的菜单
        $privilegeModel = M('StoreCenterPrivilege');
        $currentpri = $privilegeModel->field('id,pid,level')->where("name='".$path."'")->find();

        // 通过顶级id 获取下面的子栏目
        $data = $privilegeModel->where("status=".C('NORMAL_STATUS')." and level<=2")->order('sort desc,id asc')->select();

        // 递归将权限重组,将左侧菜单列举出来.
        $menuData = $this->getMenuTree($data,0);
        foreach ($menuData as $key => $val) {
            foreach ($val['child'] as $k => $v) {
                if(in_array($path, $v)){
                    $menuData[$key]['flag'] = 1;
                }
            }
        }

        if(session('?storecenter.pid')){
            $ret = M('category')->where('cid='.session('storecenter.pid'))->field('name')->find();
            $topName = $ret['name'];
        }else{
            $topName = session('storecenter.store_name');
        }
        $this->assign('topName',$topName);
        $this->assign('menuData',$menuData);
        $this->assign('path',$path);
        $this->actionName = $actionName;

        // 不需要判断权限的方法
        $noPathArr = array(
            'Storecenter/login',
            'Storecenter/logout',
            'Storecenter/verify_code'
        );

        if(!session('storecenter.id') || !session('storecenter.store_login_name')){
            if(!in_array($path, $noPathArr)){
                $this->redirect('Storecenter/login');
            }
        }
        if(in_array($path,session('storecenter.prName')) || in_array($path, $noPathArr) || $path == 'Storecenter/storeorders'){
            return true;
        }else{
            $this->error('您没有权限访问');die;
        }
    }

    /**
     * 获取菜单树
     * @param  array   $data 需要处理的数据
     * @param  integer $pid  父级id
     * @return array
     */
    public function getMenuTree($data,$pid=0){
        $result = array();
        foreach ($data as $v){
            // 找当前分类的子分类，默认从顶级开始找
            if ($v['pid'] == $pid && in_array($v['id'],session('storecenter.prIds'))){
                // 找到了，继续以找到的分类为当前分类，找它的后代节点,并将结果放到当前元素的下标为child的元素中
                $v['child'] = $this->getMenuTree($data,$v['id']);
                // 然后将$v 保存到$list中
                $result[] = $v;
            }
            continue;
        }

        return $result;
    }

    /**
     * 用户登陆
     * 
     * @return void
     */
    public function login() {
        if(IS_POST){
            $postData = I('post.');
            $verifyCode = $postData['vcode'];
            // 核实验证码是否正确
            $verify = new Verify();
            $check = $verify->check($verifyCode);
            if(!$check){
                $ret = array('code' => 2,'msg' => '验证码错误');
            }else{
                $slname = $postData['slname'];
                $loginPwd = $postData['slpwd'];
                if(!empty($slname) && !empty($loginPwd)){
                    $storeMemberModel = D('StoreMember');
                    $storeData = $storeMemberModel->checkLogin($slname, $loginPwd);
                    if ($storeData) {
                        $ret = array('code' => 1,'msg' => '登录成功');
                    } else {
                        $ret = array('code' => 3,'msg' => '用户名或密码错误');
                    }
                }
            }
            echo json_encode($ret);
        }else{
            $id = session('storecenter.id');
            $store_login_name = session('storecenter.store_login_name');
            // 判断是否登录
            if(!empty($id) && !empty($store_login_name)){
                $this->redirect("Storecenter/storeorders");
            }

            $this->display();
        }
    }

    /**
     * 验证码生成
     */
    function verify_code(){
        $verify = new Verify();
        $verify->fontSize = 20;
        $verify->length   = 4;
        $verify->useNoise = false;
        $verify->codeSet  = '0123456789';
        $verify->imageW   = 0;
        $verify->imageH   = 0;
        $verify->entry();
    }

    /**
     * 预约订单列表
     * 
     * @return void
     */
    public function storeorders() {
        if(IS_GET) {
            $store_id = session('storecenter.store_id');
            $store_name = session('storecenter.store_name');
            $pid = session('storecenter.pid');
            $orderModel = D('OrderGrave');
            $storeModel = M('Store');
            //判断是否是集团账户,如果是集团账户，取出其下面的所有陵园
            if(!empty($pid)){
                $categoryData = M('Category')->field('name')->find($pid);
                $storeCond['category_pid'] = $pid;
                $storeData = $storeModel->where($storeCond)->field('store_id')->select();
                if(!empty($storeData)){
                    foreach ($storeData as $v){
                        $storeIds[] = $v['store_id'];
                    }
                }
            }else{
                $storeIds = $store_id;
            }

            if($storeIds){
                $orderCond['store_id'] = array('in',$storeIds);
                $orderCond['pushed_status'] = C('SEND_TO_STORE.SUCCESS');
                $search = I('get.name');
                if($search){
                    $orderCond['buyer|mobile'] = array('like','%'.$search.'%');
                }
                $count = $orderModel->where($orderCond)->count();
                $page = new Page($count,C('DEFAULT_PAGE_SIZE'));
                $pageshow = $page->show();
                $fields = 'id,order_grave_sn,order_type,buyer,mobile,store_id,store_name,status,appoint_time,pushed_status,pushed_time,tomb_user,tomb_address';
                $orderDatas = $orderModel->relation(array('CustomMsg','StoreMsg'))->field($fields)->where($orderCond)->limit($page->firstRow,$page->listRows)->select();
                $this->assign('orderStatus',C('ORDER_STATUS'));
                $this->assign("handOrders", $orderDatas);
                $this->assign("page", $pageshow);
            }
            $this->display();
        }
    }

    /**
     * 订单完成/失败 操作
     */
    public function set_order_status(){
        $result = array('code' => 0,'msg' => '操作失败');
        if(IS_POST){
            $orderGrave = M('OrderGrave');
            $orderInfo = I('post.');
            if($orderInfo['orderStatus']){
                $orderData['id'] = $orderInfo['orderId'];
                $orderData['status'] = $orderInfo['orderStatus'];
                if($orderInfo['orderStatus'] == C('ORDER_STATUS.FAIL')){
                    $orderData['reason'] = $orderInfo['reason'];
                }
                if($orderGrave->data($orderData)->save()){ 
                    $result = array('code' => 1,'msg' => '操作成功');
                }
            }
        }

        echo json_encode($result);
    }

    /**
     * 查看订单短信
     */
    public function get_order_msg(){
        $result = array('code' => 0,'data' => '');
        $getInfo = I('get.');
        $where['status'] = C('NORMAL_STATUS');
        if($getInfo['id']){
            $where['order_id'] = $getInfo['id'];
            if($getInfo['classify']){
                $where['classify'] = $getInfo['classify'];
            }
        }
        $msgModel = M('OrderGraveMsg');
        $msgList = $msgModel->where($where)->field('id,name,mobile,msg')->select();

        if(!empty($msgList)){
            $result = array('code' => 1,'data' => $msgList);
        }
        echo json_encode($result);
    }

    /**
     * 服务订单列表
     */
    public function service_order(){
        if(IS_GET){
            $storeCenter = session('storecenter');
            $storeModel = M('Store');
            //判断是否是集团账户,如果是集团账户，取出其下面的所有陵园
            if(!empty($storeCenter['pid'])){
                $categoryData = M('Category')->field('name')->find($storeCenter['pid']);
                $storeCond['category_pid'] = $storeCenter['pid'];
                $storeData = $storeModel->where($storeCond)->field('store_id')->select();
                if(!empty($storeData)){
                    foreach ($storeData as $v){
                        $storeIds[] = $v['store_id'];
                    }
                }
            }else{
                $storeIds = $storeCenter['store_id'];
            }
            $orderSeviceSon = D('OrderServiceSon');
            $where['store_id'] = array('in',$storeIds);
            $where['status'] = array('egt',C('NORMAL_STATUS'));
            $search = I('get.search_name');
            if($search){
                $where['store_name|order_son_sn'] = array('like','%'.$search.'%');
            }
            $count = $orderSeviceSon->where($where)->count();
            $page = new Page($count,C('DEFAULT_PAGE_SIZE'));
            $show = $page->show();
            $fields = 'id,order_son_sn,order_main_sn,order_main_id,store_id,store_name,store_sn,status,coupon_price,coupon_number,order_service_time,pay_time,back_apply_time,back_money_time,back_money,consignee,shipping_address,consignee_mobile,take_stock_people,take_stock_mobile,take_stock_time,actual_stock_time';
            $orderServiceList = $orderSeviceSon->where($where)->relation('GrandChild')->field($fields)->limit($page->firstRow,$page->listRows)->select();
            $region = M('region')->where('level > 0')->getField('region_id,region_name');
            $this->region = $region;
            $this->serviceOrderStatus = C('SERVICE_ORDER_STATUS');
            $this->page = $show;
            $this->orderList = $orderServiceList;
            $this->display();
        }
    }

    /**
     * 确认收货
     */
    public function confirm_receiving(){
        $ret = array('code' => 0,'msg' => '操作失败');
        $id = I('post.id');
        if($id){
            $data['id'] = $id;
            $data['status'] = C('SERVICE_ORDER_STATUS.SUCCESS');
            if(M('OrderServiceSon')->data($data)->save()){
                $ret = array('code' => 1,'msg' => '收货成功');
            }
        }
        echo json_encode($ret);
    }

    /**
     * 退出登陆
     * 
     * @return void
     */
    public function logout() {
        session('storecenter', null);
        // session_destroy();
        $this->redirect("Storecenter/login");
    }

    /**
     * 添加墓位使用人和墓位地址
     * 
     * @return string
     */
    public function tomb_address() {
        $ret = array('code'=>0, 'msg'=>'墓位信息更新失败');
        if(IS_POST) {
            $orderModel = M('OrderGrave');
            $sessionCenter = session('storecenter');
            //接收数据
            $postData = I('post.');
            $id = $postData['id'];
            $tomb_address = $postData['tomb_address'];
            $tomb_user = $postData['tomb_user'];
            $data['id'] = $id;
            $data['tomb_address'] = $tomb_address;
            $data['tomb_user'] = $tomb_user;
            $data['updated_time'] = time();
            if($orderModel->data($data)->save()){
                $ret = array('code' => 1,'msg' => '墓位信息更新成功');
            }
            echo json_encode($ret);
        }
    }

    /**
     * 账户中心
     * 
     * @return void 
     */
    public function account() {
        if(IS_GET) {
            $sessionData = session('storecenter');
            $storeMemberModel = M('StoreMember');
            $where = array();

            $storeLoginName = I('get.storeLoginName');
            if($storeLoginName){
                $where['store_login_name'] = array('like','%'.$storeLoginName.'%');
            }else{
                $where['admin_id'] = array('neq',0);
            }

            if(session('?storecenter.pid')){
                $storeCond['category_pid'] = session('storecenter.pid');
                $storeData = M('store')->where($storeCond)->field('store_id,store_name')->select();
                if(!empty($storeData)){
                    foreach ($storeData as $v){
                        $storeIds[] = $v['store_id'];
                    }
                }
            }else{
                $storeIds = session('storecenter.store_id');
            }
            $where['store_id'] = array('in',$storeIds);
            $count = $storeMemberModel->where($where)->count();
            $page = new Page($count,C('DEFAULT_PAGE_SIZE'));
            $pageshow = $page->show();
            $member = $storeMemberModel->where($where)->limit($page->firstRow,$page->listRows)->select();
            unset($where['admin_id']);
            $where['admin_id'] = 0;
            $datas = $storeMemberModel->where($where)->select();
            $trees = array();
            if(empty($storeLoginName)){
                foreach ($member as $key => $val) {
                    $trees[$key] = $val;
                    foreach ($datas as $k => $v) {
                        if(strstr($v['store_login_name'],$val['store_login_name'].'_')){
                            $trees[$key]['level'][] = $v;
                        }
                    }
                }
            }else{
                $trees = $member;
            }
            $this->trees = $trees;
            $this->page = $pageshow;
            $id = session('storecenter.id');
            $store_name = session('storecenter.store_name');
            $store_login_name = session('storecenter.store_login_name');
            $pid = session('storecenter.pid');

            $groupWhere['pid'] = C('CATEGORY_GROUP_ID');
            $groupWhere['is_show'] = C('NORMAL_STATUS');
            $groupData = M('Category')->where($groupWhere)->field('cid,name')->select();
            $group = array();
            if(!empty($groupData)){
                foreach($groupData as $k => $v){
                    $group[$v['cid']] = $v;
                }
            }
            $this->group = $group;
            $this->display();
        }
    }

    /**
     * 删除账户
     */
    public function del_account(){
        $result = array('code' => 0,'msg' => '删除失败');
        if(IS_POST){
            $id = I('post.id');
            if($id){
                $where['id'] = $id;
                $ret = M('StoreMember')->where($where)->delete();
                if($ret){
                    $result = array('code' => 1,'msg' => '删除成功');
                }
            }
        }
        echo json_encode($result);
    }

    /**
     * 保存修改的密码
     * 
     * @return string
     */
    public function uppwd() {
        $ret = array('code'=>0, 'msg'=>'');
        if (IS_POST) {
            $postData = I('post.');
            $pwd = $postData['pwd'];
            $repeatpwd = $postData['repeatpwd'];
            if (empty($pwd) || empty($repeatpwd) || $pwd != $repeatpwd) {
                $ret['msg'] = "密码为空或者两次密码不一致";
            } else {
                $data['id'] = $postData['id'];
                $data['store_login_pwd'] = encryptAdmin($postData['pwd']);
                $data['updated_time'] = date('Y-m-d H:i:s');
                $result = M('StoreMember')->data($data)->save();
                if ($result) {
                    if($postData['id'] == session('storecenter.id')){
                        $ret = array('code' => 1,'msg' => '密码修改成功，请重新登录!');
                        session('storecenter.store_id', null);
                        session('storecenter.store_name', null);
                        session('storecenter.id', null);
                        session('storecenter.store_login_name', null);
                        session('storecenter.pid', null);
                    }else{
                        $ret = array('code' => 2,'msg' => '修改成功');
                    }
                } else {
                    $ret['msg'] = "密码修改失败，请重新操作!";
                }
            }
        }
        echo json_encode($ret);
    }

    /**
     * 添加子账号
     */
    public function add_child_id(){
        if(IS_POST){
            $result = array('flag'=>0,'msg'=>'添加失败');
            $postVal = I('post.');
            if($postVal['parent_privilege']){
                $fPri = M('StoreMember')->where('id='.$postVal['pid'])->field('store_login_name,privilege')->find();
                $data['privilege'] = $fPri['privilege'];
            }
            $osln = $postVal['osln'];
            $data['store_id'] = $postVal['storeId'];
            $data['store_login_name'] = $osln.'_'.$postVal['store_login_name'];
            $data['store_login_pwd'] = encryptAdmin($postVal['store_login_pwd']);
            $data['store_name'] = $postVal['store_name'];
            $data['status'] = C('NORMAL_STATUS');
            $data['created_time'] = $data['updated_time'] = date('Y-m-d H:i:s');
            $ret = M('StoreMember')->data($data)->add();
            if($ret){
                $result = array('flag'=>1,'msg'=>'添加成功');
            }
            echo json_encode($result);
        }
    }
}