<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
use Common\Extend\SendMsg;
use Think\Model;
use Think\Page;

/**
 * 购墓订单控制器
 * 主要包含：预约，审核，佣金，返现，完成，添加，订单分配
 */
class OrderGraveController extends BaseController
{

   public function getCondition(){
        $where = array();
        $store_id = I('get.store_id');
        $mobile = I('get.mobile');
        $appointment_time = I('get.appoint_time');
        $start_time = I('get.start_time');
        $end_time = I('get.end_time');
        if(!empty($store_id)){
            $where['store_id'] = $store_id;
        }
        if(!empty($mobile)){
            $where['mobile'] = $mobile;
        }
        if(!empty($appointment_time)){
            $where['appoint_time'] = strtotime($appointment_time);
        }
      
        //商务跟踪权限判断
        $tmp = session('businessPrivilege');
        if(!empty($tmp)){
            $where['order_flow_id'] = session('admin_id');
        }
        return $where;
    }

     /**
     * 获取搜索商家名称
     */
    public function searchStore($where){
        //查询出待支付的商家名称
        $orderObj = M('orderGrave')->where($where)->field('store_id,store_name')->select();
        //用于搜索商家名称的数组
        foreach ($orderObj as $key => $value) {
            $store_name[$value['store_id']] = $value['store_name'];
        }
        $this->assign('store_name',$store_name);
    }

    /**商务跟踪判断**/
    public function power(){
        if(session('?admin_id')){
          $ret=  M('RoleUser')->where('user_id='.session('admin_id'))->find();

          if($ret['role_id'] == C('BUSINESS_DEPART') && $ret['role_job_id']==C('BEIJING_BUSINESS_DEPART')){
               $where = session('admin_id');
          }
        }
        return $where;
    }

    /**
     * 预约订单列表
     */
    public function appointList() {

        $order = D('OrderGrave');
        $where['status'] = C('ORDER_STATUS.DEFAULT');
        $where['store_status'] = array('gt',0);
        $searchCondition = $this->getCondition();
        $this->searchStore($where);//查找商家名称
        if(!empty($searchCondition)){
            $where['_complex'] = $searchCondition;
        }

        $ordermen =  $this->power();
        if($ordermen){
            $where['order_flow_id'] =  $ordermen;

        }

        $fileds = 'id,store_id,member_id,mobile,buyer,store_status,pushed_status,appoint_time,created_time,store_name,apply_return_status,order_flow_id';
        $count = $order->where($where)->count();
        $Page = new Page($count, C('DEFAULT_PAGE_SIZE'));
        $list = $order->where($where)->field($fileds)->relation('store_contact')->order('created_time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $show = $Page->show();
        $store = M('store')->where($map)->field('store_id,store_name')->select();
        $this->assign('store',$store);
        $this->assign('order_flow', $this->getBusinessMen(false,false));//商务跟踪人
        $this->assign('workmen',$this->getBusinessMen());
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show);
        $this->display();
    }

    /**
     * 非会员预约列表
     */
    public function notvip(){
        $order = D('OrderGrave');
        $where['store_status'] = C('DEFAULT_STATUS');
        $where['status'] = C('ORDER_STATUS.DEFAULT');
         $searchCondition = $this->getCondition();
        $this->searchStore($where);//查找商家名称
        if(!empty($searchCondition)){
            $where['_complex'] = $searchCondition;
        }
       $ordermen =  $this->power();
        if($ordermen){
            $where['order_flow_id'] =  $ordermen;

        }
        $fileds = 'id,buyer,store_id,mobile,store_status,appoint_time,created_time,store_name,order_flow_id';
        $count = $order->where($where)->count();
        $Page = new Page($count, C('DEFAULT_PAGE_SIZE'));
        $list = $order->where($where)->field($fileds)->relation('store_contact')->order('created_time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $show = $Page->show();
        $store = M('store')->where($map)->field('store_id,store_name')->select();
        $this->assign('store',$store);
        $this->assign('order_flow', $this->getBusinessMen(false,false));//商务跟踪人
        $this->assign('workmen',$this->getBusinessMen());
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show);
        $this->display();
    }

     /**
     * 有意向订单列表
     */
    public function Interesting() {
        $order = D('OrderGrave');
        $where['status'] = C('ORDER_STATUS.INTERESTING');
        $searchCondition = $this->getCondition();
        $this->searchStore($where);//查找商家名称
        if(!empty($searchCondition)){
            $where['_complex'] = $searchCondition;
        }
       $ordermen =  $this->power();
        if($ordermen){
            $where['order_flow_id'] =  $ordermen;

        }

         $fileds = 'id,store_id,member_id,mobile,buyer,store_status,pushed_status,appoint_time,created_time,store_name,apply_return_status,order_flow_id,interest_time';
        $count = $order->where($where)->count();
        $Page = new Page($count, C('DEFAULT_PAGE_SIZE'));
        $list = $order->where($where)->field($fileds)->relation('store_contact')->order('created_time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();

        $show = $Page->show();
        $store = M('store')->where($map)->field('store_id,store_name')->select();
        $this->assign('store',$store);
        $this->assign('order_flow', $this->getBusinessMen(false,false));//商务跟踪人
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show);
        $this->display();
    }
    /**
     * 后台手动添加订单
     *
     */
    public function handleAdd() {
            if (IS_POST) {
                $data =  I('post.');
                if($data['status_num'] ==0){
                    $info = $data['info'];
                    $set = $data['set'];
                    $store = $set['store'];
                    $arr = explode('_', $store);
                    $orderInfo['province_id'] = $arr[0];
                    $orderInfo['city_id'] = $arr[1];
                    $orderInfo['store_id'] = $arr[2];
                    $orderInfo['store_name'] = $arr[3];
                    $orderInfo['buyer'] = $info['name'];
                    $orderInfo['mobile'] = $info['mobile'];
                    $orderInfo['status'] = C('DEFAULT_STATUS');
                    $orderInfo['order_grave_sn'] = makeSn();
                    $orderInfo['order_type'] = 2;
                    $orderInfo['member_status'] = $data['status_num'];
                    $orderInfo['created_time'] = time();
                    $orderInfo['appoint_time'] = strtotime($info['appoint_time']);
                    $orderInfo['order_flow_id'] = session('admin_id');
                    $order = M('OrderGrave')->add($orderInfo);
                    if($order){
                        $this->success('操作成功',U('/OrderGrave/notvip'));        
                    }                    
                }else{

                    $this->extend($data);
                }
            } else {
                $provinces = D('region')->getProvince();
                $this->assign('provinces', $provinces);
                 $this->assign('order_flow', $this->getBusinessMen(true,false));
                $this->display();
            }
    }

    /**
     * 封装添加或修改订单信息方法
     */
    private function extend($datainfo) {
                $data = $datainfo;
                $info = $data['info'];
                $set = $data['set'];
                $apply_return_status = $data['apply_return_status'];
                $store = $set['store'];
                $store_contanctman_mobile = I('post.mobile');
                $store_contanctman = I('post.contactman');
                $msg_store = I('post.msg_store');
                //将后台输入信息存入预约订单中
                $contactman = $data['contactman'];
                $result = array();
                $result['buyer'] = $info['name'];
                $result['order_type'] = C('ORDER_TYPE_BACK');//后台手动添加订单
                $result['mobile'] = $store_contanctman_mobile[count($store_contanctman_mobile)-1];
                $result['appoint_time'] = strtotime($info['appoint_time']); 
                // $result['order_flow_id'] = $info['order_flow_id'];
                $result['order_flow_id'] = session('admin_id');//将跟踪人改为当前操作人
                $result['member_status'] = C('NORMAL_STATUS');
                $result['option_id'] = session('admin_id');
                $result['remark']  =  $info['remark'];
                $memberModel = M('member');
                $memberInfo = $memberModel->where("mobile='".$info['mobile']."'")->find();//查询用户是否存在
                //开启事务
                $model = new Model();
                $model->startTrans();
                if(!empty($memberInfo)){
                    //用户存在 不用插入用户
                    $memberId = $memberInfo['id'];
                }else{
                    //用户不存在,则重新插入用户
                    $memberInfo['member_type']='2';
                    $memberInfo['name']=$info['name'];
                    $memberInfo['mobile']=$info['mobile'];
                    $memberInfo['check_mobile']=C('CHECK_MOBILE_FINISH');
                    $memberInfo['password']= encryptHome($info['mobile']);
                    $memberInfo['status']=C('NORMAL_STATUS');
                    $memberInfo['created_time']= date("Y-m-d H:i:s",time());
                    $memberInfo['updated_time']= date("Y-m-d H:i:s",time());

                    if($memberModel->create($memberInfo)){
                        $resultdata = $memberModel->add();
                        if(!$resultdata){
                            $this->error('用户新增失败');die;
                        }else{
                            $memberId = $resultdata;
                        }
                    }else{
                        $this->error('用户新增失败');die;
                    }
                }
                //订单的信息增加
                $arr = explode('_', $store);
                $result['province_id'] = $arr[0];
                $result['city_id'] = $arr[1];
                $result['store_id'] = $arr[2];
                $result['store_name'] = $arr[3];
                $result['created_time'] = time();
                $result['status'] = '0';
                $result['order_type'] = C('ORDER_TYPE_BACK');
                $result['order_grave_sn'] = makeSn();
                $result['status_num'] = 
                $result['store_status'] = $data['status_num'];
                $result['return_percent'] = $data['return_percent'];//返现比例
                $result['mobile'] = $info['mobile'];
                $result['option_id'] = session('admin_id');
                $result['member_id'] = $memberId;
                $result['apply_return_status'] = $apply_return_status;
                $orderModel = M('orderGrave');
                $orderdata =  $orderModel->data($result)->add();
                if($orderdata){
                    $order_id = $orderdata;
                }  else {
                    $model->rollback();
                    $this->error('操作失败');die;
                }
            //判断陵园联系人
            $store_mobile = $store_contanctman_mobile[0];//原始数据里的联系人-无论是固话还是手机号
            $contactman  =$store_contanctman[0];
            $i = 0;
            foreach($store_mobile as $k=>$v){
                if($v!='' && $contactman[$k]!=''){
                    $storecontactModel = M('storeContact');
                    $result = $storecontactModel->where("mobile='".$v."' and contact_name='".$contactman[$k]."' and status=1")->find();
                    if(empty($result)){
                        //插入到陵园联系表中
                        $storeContactData[$i]['store_id'] = $arr[2];
                        $storeContactData[$i]['contact_name'] = $contactman[$k];
                        $storeContactData[$i]['mobile'] = $v;
                        $storeContactData[$i]['status'] = C('NORMAL_STATUS');
                        $storeContactData[$i]['created_time'] = time();
                        $storeContactData[$i]['updated_time'] = time();
                        $storeContactData[$i]['admin_id'] = session('admin_id');
                        $i++;
                    }
                }
            }
            $orderMsgModel = M('OrderGraveMsg');
            //客户短信的插入
            $customMsg['order_id'] = $order_id;
            $customMsg['classify'] = '1';
            $customMsg['name'] = $info['name'];
            $customMsg['mobile'] = $info['mobile'];
            $customMsg['msg'] = $info['msg_customer'];
            $customMsg['status'] = C('DEPARTMENT_TYPE');
            $customMsg['created_time'] = time();
            $customMsg['admin_id'] = session('admin_id');
            if($info['msg_customer']!='') {
                if(!($orderMsgModel->add($customMsg))) {
                    $model->rollback();
                    $this->error('操作失败');die;
                }
            }
            //商家短信的插入
            
            $num = count($data['mobile']);
                if($num == 1){
                         $memberMsg['order_id'] = $order_id;
                         $memberMsg['classify'] = '2';
                         $memberMsg['name'] = $data['contactman'][0];
                         $memberMsg['mobile'] = $data['mobile'][0];
                        
                         $memberMsg['msg'] =  $data['msg_store'][0];
                         $memberMsg['status'] = C('DEPARTMENT_TYPE');
                         $memberMsg['created_time'] = time();
                         $memberMsg['admin_id'] = session('admin_id');
                         $resultOrder = $orderMsgModel->add($memberMsg);
                         if(!$resultOrder){
                            $model->rollback();
                            $this->error('操作失败');die;
                         }
                 }elseif($num > 1){
                     for($i=0;$i<$num;$i++){
                         $memberMsg[$i]['order_id'] = $order_id;
                         $memberMsg[$i]['classify'] = '2';
                         $memberMsg[$i]['name'] = $data['contactman'][$i];
                         $memberMsg[$i]['mobile'] = $data['mobile'][$i];
                         $memberMsg[$i]['msg'] =  $data['msg_store'][$i];
                         $memberMsg[$i]['status'] = C('DEPARTMENT_TYPE');
                         $memberMsg[$i]['created_time'] = time();
                         $memberMsg[$i]['admin_id'] = session('admin_id');
                          
                 }

                 if(!$orderMsgModel->addAll($memberMsg)){
                             $model->rollback();
                             $this->error('操作失败');die;
                }
             }
           
            $model->commit();
            $this->success('操作成功',U('/OrderGrave/appointList'));
    }


    /**
     * 编辑订单
     */
   public function editOrder() {
        if(IS_POST){
                $data = I('post.');
                $info = $data['info'];
                $set = $data['set'];
                $storestatus = M('OrderGrave')->where('id='.$info['orderid'])->find();
                $store = $set['store'];
                $orderModel = M('OrderGrave');
                if($storestatus['store_status'] ==0){
                        $info = $data['info'];
                        $set = $data['set'];
                        $store = $set['store'];
                        $arr = explode('_', $store);
                        $orderInfo['province_id'] = $arr[0];
                        $orderInfo['city_id'] = $arr[1];
                        $orderInfo['store_id'] = $arr[2];
                        $orderInfo['store_name'] = $arr[3];
                        $orderInfo['buyer'] = $info['name'];
                        $orderInfo['mobile'] = $info['mobile'];
                        $orderInfo['order_grave_sn'] = makeSn();
                        $orderInfo['order_type'] = 2;
                        $orderInfo['member_status'] = $data['status_num'];
                        $orderInfo['updated_time'] = time();

                        $orderInfo['appoint_time'] = strtotime($info['appoint_time']);
                        $orderInfo['order_flow_id'] = session('admin_id');
                        $orderModel->create($orderInfo);
                        $orderdata =  $orderModel->where('id='.$info['orderid'])->save();
                        if($orderdata){
                           return  $this->success('操作成功',U('/OrderGrave/appointList'));
                        }
        }else{
                //将后台输入信息存入预约订单中
                $contactman = $data['contactman'];
                $result = array();
                $result['buyer'] = $info['name'];
                $result['order_type'] = C('ORDER_TYPE_BACK');//后台手动修改订单
                $result['mobile'] = $info['mobile'];
                $result['apply_return_status'] = $info['apply_return_status'];
                $result['return_percent'] = $data['return_percent'];//返现比例
                $result['appoint_time'] = strtotime($info['appoint_time']);
                $result['order_flow_id'] = $info['order_flow_id'];
                $result['member_status'] = C('NORMAL_STATUS');
                $result['remark']   = $info['remark'];
                $memberModel = M('member');
                $memberInfo = $memberModel->where("mobile='".$info['mobile']."'")->find();
                 //开启事务
                  $model = new Model();
                  $model->startTrans();
                if(!empty($memberInfo)){
                    //用户存在 不用插入用户
                    $memberId = $memberInfo['id'];
                }else{
                    //用户不存在,则重新插入用户
                    $memberInfo['member_type']='2';
                    $memberInfo['name']=$info['name'];
                    $memberInfo['mobile']=$info['mobile'];
                    $memberInfo['check_mobile']=C('CHECK_MOBILE_FINISH');
                    $memberInfo['password']= encryptHome($info['mobile']);
                    $memberInfo['status']=C('NORMAL_STATUS');
                    $memberInfo['created_time']= date("Y-m-d H:i:s",time());
                    $memberInfo['updated_time']= date("Y-m-d H:i:s",time());

                    if($memberModel->create($memberInfo)){
                        $resultdata = $memberModel->add();
                        if(!$resultdata){
                            $this->error('用户新增失败');die;
                        }else{
                            $memberId = $resultdata;
                        }
                    }else{
                        $this->error('用户新增失败');die;
                    }
                }
                $orderMsgModel = M('OrderGraveMsg');
                // $ishave = $orderMsgModel->where('order_id='.$info['orderid'])->select();
                //客户短信的插入
                $customMsg['order_id'] = $info['orderid'];
                $customMsg['classify'] = '1';
                $customMsg['name'] = $info['name'];
                $customMsg['mobile'] = $info['mobile'];
                $customMsg['msg'] = $info['msg_customer'];
                $customMsg['status'] = C('DEPARTMENT_TYPE');
                $customMsg['created_time'] = time();
                $customMsg['admin_id'] = session('admin_id');
                
               if($info['msg_customer']!='') {
                    $orderMsgModel->create($customMsg);
                    if(!($orderMsgModel->add())) {
                        $model->rollback();
                        $this->error('操作失败');die;
                    }
                }
                //商家短信的插入
            
                $num = count($data['mobile']);

                if($num == 1){
                         $memberMsg['order_id'] = $info['orderid'];
                         $memberMsg['classify'] = '2';
                         $memberMsg['name'] = $data['contactman'][0];
                         $memberMsg['mobile'] = $data['mobile'][0];
                         $memberMsg['msg'] =  $data['msg_store'][0];
                         $memberMsg['status'] = C('DEPARTMENT_TYPE');
                         $memberMsg['created_time'] = time();
                         $memberMsg['admin_id'] = session('admin_id');

                         if(!$orderMsgModel->add($memberMsg)){
                            $model->rollback();
                            $this->error('操作失败');die;
                         }
                         
                 }elseif($num > 1){
                     for($i=0;$i<$num;$i++){
                         $memberMsg[$i]['order_id'] = $info['orderid'];
                         $memberMsg[$i]['classify'] = '2';
                         $memberMsg[$i]['name'] = $data['contactman'][$i];
                         $memberMsg[$i]['mobile'] = $data['mobile'][$i];
                         $memberMsg[$i]['msg'] =  $data['msg_store'][$i];
                         $memberMsg[$i]['status'] = C('DEPARTMENT_TYPE');
                         $memberMsg[$i]['created_time'] = time();
                         $memberMsg[$i]['admin_id'] = session('admin_id');

                 }
               
                  if(!$orderMsgModel->addAll($memberMsg)){
                             $model->rollback();
                             $this->error('操作失败');die;
                }
            }    
                //订单的信息更新
                $arr = explode('_', $store);
                if(!$info['order_grave_sn']){
                    $result['order_grave_sn'] = makeSn();
                }
                $result['province_id'] = $arr[0];
                $result['city_id'] = $arr[1];
                $result['store_id'] = $arr[2];
                $result['store_name'] = $arr[3];
                $result['status'] = '0';
                $result['store_status'] = $storestatus['store_status'];
                $result['member_id'] = $memberId;
                $result['updated_time'] = time();

                $orderModel->create($result);
                $orderdata =  $orderModel->where('id='.$info['orderid'])->save();


            if($orderdata){
                $model->commit();
                $this->success('操作成功',U('/OrderGrave/appointList'));
            }  else {
                $model->rollback();
                $this->error('操作失败');die;
            }
          }
        }else{

            $orderId = I('get.orderid');
            $Region = M('region');
            $order = D('orderGrave');
            $regions = $Region->field("region_id,region_name")->where('pid=2')->select();//获取所有省份
            $info = $order->where('id='.$orderId)->find();
            $stores = array();
            if (!empty($info['province_id'])) {
                $storeObj = M('store');
                $stores = $storeObj->field('province_id, city_id,store_id,store_name')->where('province_id = '.$info['province_id'])->select();
            }
            if (!empty($info['store_id'])) {
                $storeContactObj = M('store_contact');
                $storeContact = $storeContactObj->field('contact_name, mobile')->where('store_id = '.$info['store_id'].' and status=1')->select();
            }
            $orderMsgModel = M('OrderGraveMsg');
            $customMsgInfo = $orderMsgModel->where('order_id='.$orderId.' and classify='.C('MSG_CUSTOMER').' and status>=0')->find();
            $contactInfo = $orderMsgModel->where('order_id='.$orderId.' and classify='.C('MSG_CEMETERY').' and status>=0')->select();
            $this->assign('order_flow', $this->getBusinessMen(false,false));
            $this->assign('workmen',$this->getBusinessMen());
            $this->assign("regions", $regions);
            $this->assign("storeContact", $storeContact);
            $this->assign("customMsgInfo", $customMsgInfo);
            $this->assign("contactInfo", $contactInfo);
            $this->assign("info", $info);
            $this->assign("eStores", $stores);
            $this->assign('returnstatus', C('APPLY_RETURN_STATUS'));
            $this->display();

        }
    }

    /**
     * 根据省份ID获取数据正常的商家
     *
     * @return Json String
     */
    public function getStoresByRegionId() {
        $provinceId = I('post.provinceId');
        $result = array('code'=>0,'data'=>array());
        $where['category_id'] = C('CATEGORY_CEMETERY_ID');
        $where['province_id'] = $provinceId;
        $where['status'] = C('NORMAL_STATUS');
        $fields = 'city_id,store_id,store_name,store_profiles_id,member_status';
        $stores = D('store')->field($fields)->where($where)->select();
        //var_dump($stores);die;
        if(!empty($stores)) {
            $result['code'] = 1;
            $result['data'] = $stores;
        }
        echo json_encode($result);
    }


     /**
     * 查看跟踪信息列表
     *
     */
     public function ordersfollow() {
        $orderid = I('post.orderId');
        $orderType = I('post.orderType');
        $result = array('flag'=>0,'msg'=>'操作错误');
        $where['order_id'] = $orderid;
        if(!empty($orderType)){
            $where['order_type'] = $orderType;
        }else{
            $where['order_type'] = 0;
        }
        $orderinfo = M('OrderGraveFollow')->where($where)->order('created_time desc')->select();
        if(!empty($orderinfo)){
            $result = array('flag'=>1,'data'=>$orderinfo);
        }
        echo json_encode($result); 
    }

    /**
     * 添加跟踪信息
     */
     public function addorderfollow() {
        if(IS_POST){
            $question = I('post.question');
            $orderid = I('post.orderid');
            $type = I('post.type');
            $member_id = I('post.member_id');
            $orderType = I('post.orderType');
            if(!empty($orderType)){
                $data['order_type'] = $orderType;
            }
            $orderfollow = M('OrderGraveFollow');
            $data['type'] = $type;
            $data['question'] = $question;
            $data['order_id'] = $orderid;
            $data['member_id'] = $member_id;
            $data['created_time'] = date('Y-m-d H:i:s'); 
            $data['admin_id'] = session('admin_id');
            $data['order_sn'] = makeSn();
            $orderfollow->create($data);
            if ($orderfollow->add()) {
                $data['flag'] = 1;
                $data['msg'] = '添加成功';
            } else {
                $data['flag'] = 0;
                $data['msg'] = '添加失败';
            }
            echo json_encode($data);
        }
    }
    /**
     *
     * 审核订单列表
     */
    public function checkList() {
        $arr = array(C('ORDER_STATUS.OK'),C('ORDER_STATUS.CHECK_SUCCESS'));
        //客户购墓完成
        $where['status'] = array('in', $arr);//1
        //推送财务状态--尚未发送
        $where['send_finance_status'] = C('SEND_FINANCE_STATUS.DEFAULT');//0
       $ordermen =  $this->power();
        if($ordermen){
            $where['order_flow_id'] =  $ordermen;

        }

        $searchCondition = $this->getCondition();
        $this->searchStore($where);//查找商家名称
        if(!empty($searchCondition)){
            $where['_complex'] = $searchCondition;
        }
        $count = M('orderGrave')->where($where)->count();
        $Page = new Page($count, C('DEFAULT_PAGE_SIZE'));
        $show = $Page->show();
        $followInfo = M('orderGrave')->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->order('created_time desc')->select();
        //判断是否为会员--会员存在审核
        $member = $followInfo['return_percent'];
        if(!empty($member)) {
            return $followInfo;
        }
        $store = M('store')->where($map)->field('store_id,store_name')->select();
        $this->assign('pay_type',C('PAY_TYPE'));
        $this->assign('store',$store);
        $this->assign('order_flow', $this->getBusinessMen(false,false));//商务跟踪人
        $this->assign('page', $show);
        $this->assign('list', $followInfo);
        $this->display();
    }

     /**
     * 获取票据信息
     */
    public function orderbill(){
        $orderId = I('post.orderId');
        $where['order_id'] = $orderId;
        $where['status'] = C('DEFAULT_STATUS');
        $orderbill = M('OrderGraveBill')->where($where)->select();
        if($orderbill){
            $result = $orderbill;
        }
        echo json_encode($result);
    }


     /**
     * 查看票据信息
     */
    public function orderbillinfo(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $order_id = I('post.orderId');
        if(!empty($order_id)){
            $where['order_grave_id']=$order_id;
            $orderbill = M('OrderGraveBill')->where($where)->select();
            foreach($orderbill as $v){
                $types[$v["type"]]=C('BILL_TYPE.'.$v["type"]);
            }
            if(count($orderbill) == 0){
                $result=array('flag'=>1,'msg'=>'暂无数据');
            }else if(count($orderbill) > 0){
                $result=array('flag'=>2,'data'=>$orderbill,'types'=>$types);
            }
        }
        echo json_encode($result);
    }


    /**
     * 通过订单ID获取数据
     */
    public function byOrderId() {
        $orderId = I('post.orderId');
        $orderModel = M('OrderGrave');
        $field = 'brokerage_percent,return_percent';
        $datainfo = M('OrderGrave')->where('id='.$orderId)->field($field)->find();
        if($datainfo){
           $result=array('flag'=>1,'data'=>$datainfo);
        }
    }

   /**
     * 审核票据信息
     */
    public function checkbill() {
        $postInfo = I('post.');
        $orderId = I('post.id');
        $adminId =  session('admin_id');
        $orderModel = M('OrderGrave');
        $isapply = $postInfo['return_pesent_status'];
        $status = $postInfo['status'];
        $field = 'member_id';
        $memberId = M('OrderGrave')->where('id='.$orderId)->field($field)->find();
        $orderGraveBill = M('OrderGraveBill');
        if(!$status == C('ORDER_STATUS.OK')) {
            $result = array('flag'=>0,'msg'=>'信息出错');
            echo json_encode($result);die;
        }else{
            //开启事物
             $model = new Model();
             $model->startTrans();
            if($isapply=='0'){//如果申请返现状态为0并且返现比例为空，则默认为不需要返现
                $data['total_price'] = $postInfo['total_price'];
                $data['tomb_price'] = $postInfo['tomb_price'];
                $data['brokerage_money'] = $postInfo['brokerage_money'];
                $data['brokerage_percent'] = $postInfo['brokerage_percent'];
                $data['apply_return_status'] = C('APPLY_RETURN_STATUS.DEFAULT_STATUS');//不返现
                $data['status'] = C('ORDER_STATUS.CHECK_SUCCESS');//审核成功带收佣金
                $data['id'] = $orderId;
                // $orderModel->where('id='.$orderId)->create($data);
                $result = $orderModel->data($data)->save();
                if($result){
                    $model->commit();
                    $result = array('flag'=>1,'msg'=>'无需返现审核成功');
                    echo json_encode($result);die;    
                }
            }else{
                 // $imagesRet = upload('image', C('ORDER_BILL_IMAGE'));
                //上传票据
                // if(!$imagesRet['ok']){
                //    $result = array('flag'=>0,'msg'=>'请上传票据的文件');
                //    echo json_encode($result);die;    
                // }else{
                // var_dump($imagesRet);die;
                    $data['apply_return_status'] = C('APPLY_RETURN_STATUS.OK_CHECK_RETURN_STATUS');//申请返现审核成功
                    $data['status'] = C('ORDER_STATUS.CHECK_SUCCESS');//审核成功待收佣金
                    $data['total_price'] = $postInfo['total_price'];
                    $data['tomb_price'] = $postInfo['tomb_price'];
                    $data['brokerage_percent'] = $postInfo['brokerage_percent'];
                    $data['return_percent'] = $postInfo['return_percent'];
                    $data['brokerage_money'] = $postInfo['brokerage_money'];
                    $data['return_money'] =  $postInfo['return_money'];
                    $where['id'] = $postInfo['id'];
                    $orderModel->create($data);
                    $resultdata = $orderModel->where($where)->save();
                    //数据写入到票据表中
                    $imagesRet = upload('image', C('ORDER_BILL_IMAGE'));
                    foreach ($imagesRet['images'] as $k=>$v){
                        $billData[$k]['order_grave_id'] = $orderId;
                        $billData[$k]['type'] = C('BILL_TYPE.BROKERAGE');
                        $billData[$k]['bill_image'] = C('IMG_HOST').$v;
                        $billData[$k]['created_time'] = time();
                        $billData[$k]['bill_status'] = C('AUDIT_STATUS.SUCCESS');
                    }
                    $ordersBillModel = M('OrderGraveBill');
                    $orderBillRet = $ordersBillModel->addAll($billData);
                    //用户信息
                    $memberInfo['member_id']=$memberId['member_id'];
                    $memberInfo['bank']=$postInfo['bank_type'];
                    // $memberInfo['bank_type']=$postInfo['bank_type'];
                    $memberInfo['bank_member']=$postInfo['bank_member'];
                    $memberInfo['bank_account']=$postInfo['bank_account'];
                    $memberInfo['admin_id'] =   session('admin_id');
                    $memberInfo['created_time'] = date('Y-m-d H:i:s');
                    $memberresult = M('MemberBank')->add($memberInfo);
    
                    // if($resultdata && $memberresult != false && $orderBillRet!=false){
                    if($resultdata && $memberresult != false){
                 
                        $model->commit();
                        $data['flag']=1;
                        $data['msg']='操作成功';
                    }else{
                        $model->rollback();
                        $data['flag']=0;
                        $data['msg']='操作失败';
                    }
                    echo json_encode($data);
                // }   
           }
        }

    }
  

    /**
     * 根据商家ID获取商家联系人
     *
     */
    public function getStoreContact() {

        $storeId = I('post.store_id');
        $result = array('code'=>0,'data'=>array());
        $where['store_id'] = $storeId;
        $where['status'] = C('NORMAL_STATUS');
        $fileds = 'contact_name,mobile,tel';
        $data = M('store_contact')->field($fields)->where($where)->select();
        if(!empty($data)) {
            $result['flag'] = 1;
            $result['data'] = $data;
        }
        echo json_encode($result);
    }


    /**
     * 根据商家ID获取佣金比例
     */
    public function getPesentById(){
        $storeId = I('post.store_id');
        $data = M('store')->where('store_id='.$storeId)->field('store_profiles_id')->find();
        $profilesId = $data['store_profiles_id'];
        $where['id'] = $profilesId;
        $where['status'] = array('gt', 0);
        $datainfo = M('StoreProfilesDetail')->where($where)->field('return_amount')->find();
        
        $return_amount = $datainfo['return_amount'];
        if($return_amount) {
            $result['return_amount'] = $return_amount;
            $result['flag'] = 1;
        }else{
            $result['flag'] = 0;
        }
        echo json_encode($result);
    }


    //根据订单ID获取返现比例
    public function getPercentById(){
        $orderId = I('post.orderId');
        $field = 'return_percent,apply_return_status';
        $datainfo = M('OrderGrave')->where('id='.$orderId)->field($field)->find();
        $apply_return_status  = $datainfo['apply_return_status'];
        if($apply_return_status){
            $result['apply_return_status'] = $apply_return_status;
            $result['return_percent'] = $datainfo['return_percent'];
            $result['flag'] = 1;
        }else{
            $result['flag'] = 0;
        }
        echo json_encode($result);

    }


     /**
     * 更改订单跟踪人(更改委派人)
     */
    public function editflowman() {
        $where['id'] = I("post.orderId");
        $datas['order_flow_id'] = I('post.flowman');
        $res = M('orderGrave')->where($where)->save($datas);
        if (!is_bool($res)) {
            $data['flag'] = 1;
            $data['msg'] = '委派成功';
        } else {
            $data['flag'] = 0;
            $data['msg'] = '委派失败';
        }
        echo json_encode($data);
    }


     /**
     * 更改留言订单跟踪人(更改委派人)
     */
    public function editleaveflowman() {
        $where['id'] = I("post.orderId");
        $datas['order_flow_id'] = I('post.flowman');
        $res = M('appoint')->where($where)->save($datas);
        if (!is_bool($res)) {
            $data['flag'] = 1;
            $data['msg'] = '委派成功';
        } else {
            $data['flag'] = 0;
            $data['msg'] = '委派失败';
        }
        echo json_encode($data);
    }


     /*
      * 强制退单
      * return string(json);
      */
    public function forceback(){
        $result = array('flag'=>0,'msg'=>'退单失败！');
        $data = I('post.');
        if(!empty($data['id'])){
            $fields = 'id, order_grave_sn, status, apply_return_status,success_time, payfor_us_time, payfor_customer_time,brokerage_percent,brokerage_money,paid_in_amount,return_money,back_reason,success_time,store_id';
            $forceBackWhere['id'] = $data['id'];
            $forceBackWhere['status'] = array('gt', 0);
            $orderGraveModel = M('order_grave');
            $findData= $orderGraveModel->field($fields)->where($forceBackWhere)->find();
            if(!empty($findData)){
                $storeId = M('Store')->field('store_profiles_id,member_status')->where('store_id = '.$findData['store_id'])->find();
                //判断是否为会员
                if(empty($storeId['member_status'])){
                    $result = array('flag' => 1,'msg' => '允许退单');
                }
                $bankInfo = M('StoreProfilesDetail')->field('id,bank,bank_member,bank_account')->where('id = '.$storeId['store_profiles_id'])->find();
                $findData['bank_account'] = $bankInfo['bank_account'];
                $findData['bank_member'] = $bankInfo['bank_member'];
                $findData['bank'] = $bankInfo['bank'];
                $findData['profilesId'] = $bankInfo['id'];
                $result = array('flag'=>1,'data'=>$findData);
            }
        }
        echo json_encode($result);
    }

    /**
     * 审核阶段 、陵园支付阶段、客户返现阶段  、购墓成功之后 退购
     * 默认新订单不存在退单的问题
     *
     * @return bool
     */
    public function singleBack() {
        $result = array( 'flag' => 0,'msg' => '退单失败');
        if (IS_GET) {
            $id = I('get.id');
            $fields = 'id, order_grave_sn, status, apply_return_status,success_time, payfor_us_time, payfor_customer_time,brokerage_percent,brokerage_money,paid_in_amount,return_money,back_reason,success_time,store_id';
            $singleBackWhere['id'] = $id;
            $singleBackWhere['status'] = array('gt', 0);
            $orderGraveModel = M('order_grave');
            $data = $orderGraveModel->field($fields)->where($singleBackWhere)->find();
            if ($data) {
                $storeId = M('Store')->field('store_profiles_id,member_status')->where('store_id = '.$data['store_id'])->find();
                //判断是否为会员
                /*if(empty($storeId['member_status'])){
                    $result = array('flag' => 1,'msg' => '允许退单');
                }*/
                $bankInfo = M('StoreProfilesDetail')->field('id,bank,bank_member,bank_account')->where('id = '.$storeId['store_profiles_id'])->find();
                //首先判断处于那种状态
                $currentStatus = $data['status'];//0默认新订单，1达成交易，10完成订单，20 申请退单，-1删除
                //$currentBrokerageStatus = $data['brokerage_status'];//佣金状态，0默认，1待收款，10完成',
                $backData = array();
                $backData['id'] = $id;
                //首先判断处于那种阶段，然后判断时间
                //审核阶段，陵园未支付之前，可以直接退单
                if ($currentStatus == C('ORDER_STATUS.OK')||$currentStatus == C('ORDER_STATUS.CHECK_SUCCESS')) {
                    $result = array('flag' => 1,'msg' => '允许退单');
                } else if($currentStatus == C('ORDER_STATUS.SUCCESS') || $currentStatus == C('ORDER_STATUS.RETURN_SUCCESS')|| $currentStatus == C('ORDER_STATUS.GET_MONEY')) {
                //陵园已经支付佣金，如果已经给予客户返现，则退款时候需要进行处理实际的退款数据，其他的不用考虑
                    $endTime = $data['success_time'] + C('PAY_ACTIVE_TIME');
                    if (time() <= $endTime) {//如果时间范围之内，可以退款
                        $result = array(
                            'flag' => 2,
                            'msg' => '允许退单，陵园打款时间：'.date('Y-m-d H:i:s', $data['success_time']),
                            'data' => array(
                                'brokerage_percent' => $data['brokerage_percent'],//佣金比例
                                'brokerage_money'=> $data['brokerage_money'],//佣金金额
                                'paid_in_amount' => $data['paid_in_amount'],//实际金额
                                'return_money' => $data['return_money'],//返现金额
                                'back_reason' => $data['back_reason'],//返现金额
                                //银行信息
                                'bank_account' => $bankInfo['bank_account'],
                                'bank_member' => $bankInfo['bank_member'],
                                'bank' => $bankInfo['bank'],
                                'profilesId' => $bankInfo['id'],
                            )
                        );
                    } else {//不可以退款
                        $backData['status'] = C('ORDER_STATUS.STOP');
                        $backData['back_apply_time'] = time();
                        $ret  = $orderGraveModel->save($backData);
                        if ($ret !== false) {
                            $result = array(
                                'flag' => 3,
                                'msg' => '时间过长，不允许退单，购墓成功时间：'.date('Y-m-d H:i:s', $data['success_time'])
                            );
                        } else {
                            $result = array(
                                'flag' => 4,
                                'msg' => '时间过长，不允许退单，操作失败，请重试'
                            );
                        }
                    }
                }
            } else {
                //数据不存在，或者已经删除
                $result = array(
                    'flag' => 0,
                    'msg' => '数据错误'
                );
            }
        }else if(IS_POST){
            $result = array( 'flag' => 0, 'msg' => '操作失败！');
            $datas['id'] = I('post.id');
            $profilesData['id'] = I('post.profilesId');
            $profilesData['bank'] = I('post.bank');
            $profilesData['bank_member'] = I('post.bank_member');
            $profilesData['bank_account'] = I('post.bank_account');
            $profilesData['updated_time'] = time();
            if(!(empty($datas['id'])&&empty($profilesData['id']))){
                //开启事务
                $model = new Model();
                $model->startTrans();
                $datas['back_reason'] = I('post.back_reason');
                $datas['back_money'] = I('post.back_money');
                $datas['status'] = C('ORDER_STATUS.ALLOW');
                $datas['back_apply_time'] = time();
                if((M('order_grave')->save($datas))&&(M('StoreProfilesDetail')->save($profilesData))){
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功！';
                    $model->commit();
                }else{
                    $model->rollback();
                }
            }
            die(json_encode($result));
        }
        echo json_encode($result);
    }
    /*
     * 提交退单信息
     */
    public function backReason(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $data = I('post.');
        $data['status'] = C('ORDER_STATUS.BACK_SUCCESS');
        $data['back_apply_time'] = time();
        if(M('order_grave')->save($data)){
            $result = array('flag'=>1,'msg'=>'操作成功！');
        }
        echo json_encode($result);
    }
    
    /**
     * 操作退款审核
     *
     * @return Json String
     */
    public function checkSingleBack() {
        $result = array(
            'flag' => 0,
            'msg' => '审核退款操作错误'
        );
        if (IS_POST) {
            $id = I('post.id');
            $checkDatas = array();
            $checkDatas['id'] = $id;
            $checkDatas['back_approval_time'] = NOW_TIME;
            $checkDatas['check_person_id'] = session('admin_id');
            $checkDatas['back_fact_money'] = I('post.back_fact_money');//实际退款金额
            $checkDatas['back_reason'] = I('post.back_reason');//退款原因
            $checkDatas['back_money'] = I('post.back_money');//数据不可以修改
            $ret = $M('order_grave')->save($checkDatas);
            if ($ret) {
                $result = array(
                    'flag' => 1,
                    'msg' => '审核退款操作成功'
                );
            } else {
                $result = array(
                    'flag' => 0,
                    'msg' => '审核退款操作失败'
                );
            }
        }
        echo json_encode($result);
    }


    /**
     * 财务确认退款
     *
     * @return Json String
     */
    public function financeMakeSure() {
        $result = array(
            'flag' => 0,
            'msg' => '退款操作错误'
        );
        if (IS_POST) {
            $id = I('post.id');
            $financeDatas = array();
            $financeDatas['id'] = $id;
            $financeDatas['back_order_admin_id'] = session('admin_id');//财务操作人
            $financeDatas['back_money_time'] = NOW_TIME;//打款时间
            //$financeDatas['back_order_admin_id'] = I('');//打款记录图片 功能添加之后需要使用事物提交
            $ret = M('order_grave')->save($financeDatas);
            if ($ret) {
                $result = array(
                    'flag' => 1,
                    'msg' => '退款完成'
                );
            } else {
                $result = array(
                    'flag' => 0,
                    'msg' => '退款操作失败'
                );
            }
        }
        echo json_encode($result);
    }


    /**
     * 推送给财务
     */
    public function sendtofinance() {
            if(IS_POST){
            $result = array('flag'=>0,'msg'=>'操作失败');
            $order_id = I('post.orderId');
            if(!empty($order_id)){
                $ordersModel = M('OrderGrave');
                $data = array();
                $data['send_finance_admin_id'] = session('admin_id');
                $data['send_finance_status'] = '1';//发送给财务
                $data['send_finance_time'] = time();
                $data['updated_time'] = time();

                $orderInfo = $ordersModel->where('id='.$order_id)->save($data);
                if($orderInfo){
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }
            }
            echo json_encode($result);
        }
    }


     /**
     * 陵园支付列表
     */
    public function storepaylist(){

        //陵园待支付给我们
        // $where['brokerage_status'] = C('BROKERAGE_STATUS.WAITING');
        //客户与陵园达成交易
        $where['status'] = C('ORDER_STATUS.CHECK_SUCCESS');//3
        $this->searchStore($where);//查找商家名称

        //已发送财务
        $where['send_finance_status'] = C('SEND_TO_FINANCE.SUCCESS');
        
        $searchCondition = $this->getCondition();
        if(!empty($searchCondition)){
            $where['_complex'] = $searchCondition;
        }
        $ordermen =  $this->power();
        if($ordermen){
            $where['order_flow_id'] =  $ordermen;

        }

        $count = M('OrderGrave')->where($where)->count();
        $Page = new Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $followInfo = D('OrderGrave')->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->order('created_time desc')->select();
        $map['category_id'] = C('CATEGORY_CEMETERY_ID');
        $store = M('store')->where($map)->field('store_id,store_name')->select();
        $this->assign('order_flow', $this->getBusinessMen(false,false));
        $this->assign('store',$store);
        $this->assign('page', $show);
        $this->assign('list', $followInfo);
        $this->display();
    }
     /**
     * 获取返现状态及订单所在商家的信息,点击购墓成功后弹出的页面用
     *
     */
    public function getStoreInfo(){
        $result = array('flag'=>0,'apply_return_status'=>'0','member_status'=>'0');
        $where['id'] = I('post.orderId');
        $orderInfo = M('OrderGrave')->where($where)->field('apply_return_status,store_id')->find();
        if(!empty($orderInfo)){
            $storeInfo = M('Store')->field('member_status')->find($orderInfo['store_id']);
            $result['flag'] = 1;
            $result['apply_return_status'] = $orderInfo['apply_return_status'];
            $result['member_status'] = $storeInfo['member_status'];
        }
        echo json_encode($result);
    }

    /**
     * 合作成功
     */
    public function cooperatesuccess() {
        $orderId = I('post.orderId');
        $orderModel = M('orderGrave');
        $apply_return_status = I('post.apply_return_status');
        $order = $orderModel->where('id=' . $orderId)->field('id,store_id,status')->find();
        if (empty($order)) {
            $data['flag'] = 0;
            $data['msg'] = '数据没找到';
        } else {
            $store_id = $order['store_id'];
            //通过商家id,查找该商家是否是会员单位，如果是的话，进入返现等步骤，反则该订单直接结束。
            $store = M('store')->where('store_id=' . $store_id)->field('store_id,member_status')->find();
            if (empty($store)) {
                $data['flag'] = 0;
                $data['msg'] = '商家不存在';
            } else {

                if ($store['member_status'] == C('STOER_MERMBER') || $store['member_status'] == C('STOER_MERMBER_PERSON') || $store['member_status'] == C('STOER_MERMBER_AD') || $store['member_status'] == C('STOER_MERMBER_V')) {
                    //商家会员或者是个人会员或者广告会员
                    $info['status'] = C('ORDER_STATUS.OK');
                    $info['id'] = $orderId;
                    $info['success_time'] = time();//购墓成交时间
                    $info['updated_time'] = time();//购墓成交时间


                    if(!empty($apply_return_status)){
                        $info['apply_return_status'] = $apply_return_status;
                    }
                    if ($orderModel->where('id='.$info['id'])->save($info)) {
                        $data['flag'] = 1;
                        $data['msg'] = '操作成功';
                    } else {

                        $data['flag'] = 0;
                        $data['msg'] = '操作失败';
                    }

                } else {
                    //不是上面的两个会员,订单不涉及返现，直接完成
                    $info['status'] = C('ORDER_STATUS.SUCCESS');
                    $info['id'] = $orderId;
                    $info['success_time'] = time();//购墓成交时间
                    $info['updated_time'] = time();
                    if ($orderModel->where('id='.$info['id'])->save($info)) {
                        $data['flag'] = 1;
                        $data['msg'] = '操作成功';
                    } else {
                        $data['flag'] = 0;
                        $data['msg'] = '操作失败';
                    }
                }
            }
        }
        echo json_encode($data);
    }


      /**
     * 合作失败
     */
    public function cooperatefail() {
        $orderId = I('post.orderId');
        $reason = I('post.reason');
        $orderModel = M('orderGrave');
        $order = $orderModel->where('id=' . $orderId)->field('id,store_id,status')->find();
        if (empty($order)) {
            $data['flag'] = 0;
            $data['msg'] = '数据没找到';
        } else {
            $info['id'] = $orderId;
            $info['reason'] = $reason;
            $info['updated_time'] = time();
            $info['status'] = C('ORDER_STATUS.FAIL');
            if ($orderModel->where('id='.$orderId)->save($info)) {
                $data['flag'] = 1;
                $data['msg'] = '操作成功';
            } else {
                $data['flag'] = 0;
                $data['msg'] = '操作失败';
            }
        }
        echo json_encode($data);
    }


    /*
     * 通过订单id,获取短消息列表
     */
    public function ordermsglist(){
        $orderid = I('get.orderid');
        $where['order_id'] = $orderid;
        $where['status'] = array('egt',0);

        $ordermsg = M('OrderGraveMsg')->where($where)->select();
        $this->assign('list', $ordermsg);
        $this->display();
    }



   /**
     * 编辑订单短消息
     */
    public function editOrderMsg() {
        $orderMsgModel = M('OrderGraveMsg');
        if(IS_POST){
            $data['id'] = I('post.msgid');
            $data['msg'] = I('post.msg');
            $orderMsgModel->create($data);
            $orderinfo = $orderMsgModel->where('id='.$data['id'])->save();
            if($orderinfo){
                $result['flag']=1;
                $result['msg']='操作成功';
            }else{
                $result['flag']=0;
                $result['msg']='操作失败';
            }
        }else{
            $id = I('get.id');
            $orderMsg = $orderMsgModel->field('msg')->where('id='.$id)->find();
            if(empty($orderMsg)){
                $result['flag']=0;
                $result['data']='操作失败！';
            }else{
                $result['flag']=1;
                $result['data']=$orderMsg['msg'];
            }
        }
        echo json_encode($result);
    }
    /**
     * 发送短消息
     */
    public function sendmessage(){
        $id = I('post.id');
        $orderMsgModel = M('OrderGraveMsg');
        $orderMsg = $orderMsgModel->where('id='.$id)->find();
        if(empty($orderMsg)){
            $result['flag'] = 0;
            $result['msg'] = '操作失败';
        }else{
            $sendmsgobj = new SendMsg();
            //开启事务
            $model = new Model();
            $model->startTrans();

            $msgLogData['status'] = C('MSG_SEND_STATUS');
            $msgLogData['sender'] = session('admin_id');
            $msgLogData['send_time'] = time();
            $orderMsgModel->create($msgLogData);
            $resultdata = $orderMsgModel->where('id='.$id)->save();
            if($resultdata){
                    $rst = $sendmsgobj->sendMsg($orderMsg['mobile'], $orderMsg['msg']);
                    if($rst){
                        $model->commit();
                        $result['flag'] = 1;
                        $result['msg'] = '发送成功';
                    }  else {
                        $model->rollback();
                        $result['flag'] = 1;
                        $result['msg'] = '发送失败';
                    }
                }else{
                    $model->rollback();
                    $result['flag'] = 0;
                    $result['msg'] = '操作失败';
                }
           
        }
        echo json_encode($result);
    }


    /*
     * 推送给陵园
     */
    public function push() {
        $orderid = I('post.orderid');
        $orderModel = M('orderGrave');
        $data['id'] = $orderid;
        $data['pushed_status'] = C('SEND_TO_STORE.SUCCESS');//已推送
        $data['pushed_time'] = time();
        $data['updated_time'] = time();

        if($orderModel->where('id='.$orderid)->save($data)){
            $result['flag']=1;
            $result['msg']='操作成功';
        }else{
            $result['flag']=0;
            $result['msg']='操作失败';
        }
        echo json_encode($result);
    }

     /**
     * 用户返现订单
     */
    public function returnPesentList() {
        //客户购墓完成
        $sendarr = array(C('SEND_TO_FINANCE.SUCCESS'),C('SEND_TO_FINANCE.SUCCESS_FINANCE'));
        //佣金收到
        $where['status'] = C('ORDER_STATUS.GET_MONEY');
       $ordermen =  $this->power();
        if($ordermen){
            $where['order_flow_id'] =  $ordermen;

        }

        //推送财务状态--已发送
        $tuisong = array(C('APPLY_RETURN_STATUS.NEED_RETURN_STATUS'),C('APPLY_RETURN_STATUS.OK_CHECK_RETURN_STATUS'));
        $where['send_finance_status'] = array('in',$sendarr);//已发送至财务
        $where['apply_return_status'] = array('in',$tuisong);//客户返现状态--审核完成或者申请返现
        $searchCondition = $this->getCondition();
        if(!empty($searchCondition)){
            $where['_complex'] = $searchCondition;
        }
        $count = M('orderGrave')->where($where)->count();
        $Page = new Page($count, C('DEFAULT_PAGE_SIZE'));
        $show = $Page->show();
        $followInfo = M('OrderGrave')->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->order('created_time desc')->select();
        //判断是否为会员--会员存在审核
        $member = $followInfo['return_percent'];
        if(!empty($member)) {
            return $followInfo;
        }
        $store = M('store')->where($map)->field('store_id,store_name')->select();
        $this->assign('store',$store);
        $this->assign('order_flow', $this->getBusinessMen(false,false));//商务跟踪人
        $this->assign('page', $show);
        $this->assign('list', $followInfo);
        $this->display();
    }


        /**
     * 通过AJAX传输的陵园名查找会员状态
     */
    public function getMemberStatus() {
        if(IS_POST) {
            $store_id = I('post.store_id');
            $storeObj = M('Store');
            $data = $storeObj->where("store_id=".$store_id)->field('member_status')->find();//'member_status'=>'20'
            $member_status = C('MEMBER_STATUS');
            $info['member_status'] = $member_status[$data['member_status']];
            $info['num'] = $data['member_status'];
            echo json_encode($info);  
        }else{
            $this->error('会员状态不存在');
        }
    }

    /**
     * 完成订单
     */
    public function finish() {

        $arr = array(C('ORDER_STATUS.SUCCESS'),C('ORDER_STATUS.STOP'));
        $where['status'] = array('in',$arr); //订单状态  --已完成
        // $where['brokerage_status'] = C('BROKERAGE_STATUS.SUCCESS');//佣金状态 已完成
        $searchCondition = $this->getCondition();
        $this->searchStore($where);//查找商家名称

        if(!empty($searchCondition)){
            $where['_complex'] = $searchCondition;
        }
       $ordermen =  $this->power();
        if($ordermen){
            $where['order_flow_id'] =  $ordermen;

        }

        $count = M('orderGrave')->where($where)->count();
        $Page = new Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $followInfo = M('OrderGrave')->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->order('updated_time desc')->select();
        $store = M('store')->where($map)->field('store_id,store_name')->select();
        $this->assign('store',$store);
        $this->assign('pay_type',C('PAY_TYPE'));
       $this->assign('order_flow', $this->getBusinessMen(false,false));//商务跟踪人
        $this->assign('page', $show);
        $this->assign('list', $followInfo);
        $this->display();
    }


   /**
     * 后台手动审核的时候，获取用户的银行卡信息及订单的返现状态
     */
    public function getmemberbankinfo(){
        if(IS_POST){
            $memberId = I('post.member_id');
            $memberModel  = M('MemberBank');
            $data = $memberModel->field('bank,bank_type,bank_member,bank_account')->where('member_id='.$memberId)->find();
            if(!empty($data)){
                $result['flag']=1;
                $result['data']=$data;
            }else{
                $result['flag']=0;
                $result['data']='';
            }
            echo json_encode($result);
           
        }
    }


    /**
     * 前台留言审核==列表
     */
    public function leaveMessage() {

        $order = D('appoint');
        $arr = array(C('APPOINT_STATUS.WAITING'),C('APPOINT_STATUS.ON_LOAD'),C('APPOINT_STATUS.REFUSE'),C('APPOINT_STATUS.SUCCESS'));
        $where['status'] = array('in',$arr);
        $ordermen =  $this->power();
        if($ordermen){
            $where['order_flow_id'] =  $ordermen;
        }
        $count = $order->where($where)->count();
        $Page = new Page($count, C('DEFAULT_PAGE_SIZE'));
        $show = $Page->show();
        $list = $order->where($where)->order('created_time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('order_flow', $this->getBusinessMen(false,false));//商务跟踪人
        $this->assign('workmen',$this->getBusinessMen());
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show);
        $this->display();

    }

    /**
     * 前台留言--拒绝
     */
    public function refuse() {
        $id = I('post.orderId');
        $order = M('appoint');
        $data['status'] = C('APPOINT_STATUS.REFUSE'); 
        $data['id'] = $id;
        $order->create($data); 
        $info = $order->save();
        if($result) {
            $result['flag']=1;
            $result['msg']='操作成功';
        }else{
            $result['flag']=0;
            $result['msg']='操作失败';
        }
        echo json_encode($result);

    }

    /**
     * 前台留言--成功
     */
    public function leaveMessageSuccess() {
        $id = I('post.orderId');
        $order = D('appoint');
        $data['status'] = C('APPOINT_STATUS.SUCCESS'); 
        $where['id']=$id;
        $result = $order->where($where)->save($data);//修改留言订单表状态信息

        $info =  $order->where($where)->find();
        $memberModel = M('member');
        $memberInfo = $memberModel->where("mobile='".$info['mobile']."'")->find();//查询用户是否存在
            if(!empty($memberInfo)){
                //用户存在 不用插入用户
                $memberId = $memberInfo['id'];
            }else{
                //用户不存在,则重新插入用户
                $memberInfo['member_type']='1';
                $memberInfo['name']=$info['buyer'];
                $memberInfo['mobile']=$info['mobile'];
                $memberInfo['check_mobile']=C('CHECK_MOBILE_FINISH');
                $memberInfo['password']= encryptHome($info['mobile']);
                $memberInfo['status']=C('NORMAL_STATUS');
                $memberInfo['created_time']= time();
                $memberInfo['updated_time']= time();
                if($memberModel->create($memberInfo)){
                    $resultdata = $memberModel->add();
                    if(!$resultdata){
                        $this->error('用户新增失败');die;
                        }else{
                            $memberId = $resultdata;
                        }
                    }else{
                        $this->error('用户新增失败');die;
                    }
                }
                //订单的信息增加
                $resultOrder['created_time'] = time();
                $resultOrder['status'] = '0';
                $resultOrder['order_type'] = C('ORDER_TYPE_QIAN');
                $resultOrder['member_id'] = $memberId;
                $resultOrder['mobile'] = $info['mobile'];
                $resultOrder['buyer'] = $info['buyer'];
                $resultOrder['follow_man'] = $info['order_flow_id'];
                $orderModel = M('OrderGrave');
                $orderdata =  $orderModel->add($resultOrder);
                if($orderdata){
                     $order_id = $orderdata;
                }  else {
                    $this->error('操作失败');die;
                }
       
        if($orderdata && $resultdata) {
            $result['flag']=1;
            $result['msg']='操作成功';
        }else{
            $result['flag']=0;
            $result['msg']='操作失败';
        }
        echo json_encode($result);
    }

    /**
     * 前台留言-删除  硬删除
     */

    public function del() {
        $id = I('post.orderId');
        $order = M('appoint');
        $data['id'] = $id;
        $info =  $order->where($data)->delete(); 
        if($info) {
            $result['flag']=1;
            $result['msg']='操作成功';
        }else{
            $result['flag']=0;
            $result['msg']='操作失败';
        }
        echo json_encode($result);

    }


    /*
     * 退单列表
     * return viod;
     */
    public function singleBackList(){
        $search = I('post.');
        if(!empty($search['SearchStore'])){
            $where['store_id'] = $search['SearchStore'];
        }
        if(!empty($search['status'])){
            $where['status'] = $search['status'];
        }else{
            $where['status'] = array('in',array(C('ORDER_STATUS.BACK_SUCCESS'),C('ORDER_STATUS.ALLOW'))); 
        }
        if(!empty($search['mobile'])){
            $where['mobile'] = array('like','%'.$search['mobile'].'%');
        }
       $ordermen =  $this->power();
        if($ordermen){
            $where['order_flow_id'] =  $ordermen;

        }




        $count = M('orderGrave')->where($where)->count();
        $Page = new Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $orderGraveModel = D('orderGrave');
        $list = $orderGraveModel->relation('back_bill')->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->order('back_apply_time desc')->select();
        $storeWhere['status'] = array('in',array(C('ORDER_STATUS.STOP'),C('ORDER_STATUS.BACK_SUCCESS'),C('ORDER_STATUS.ALLOW'))); 
        $listStore = $orderGraveModel->field('store_id,store_name')->where($storeWhere)->select();
        foreach($listStore as  $value){
            $searchlist[$value['store_id']] = $value['store_name'];
        }
        
        $this->assign('search',$search);
        $this->assign('Searchlist',$searchlist);
        $this->assign('page', $show);
        $this->assign('list', $list);
        $this->display();
    }


    /**
     * 将订单转换为有意向订单
     */
    public function ChangeInterest() {
        $data = I('post.');
        $order = M('OrderGraveFollow');
        $id = $data['orderid'];
        $datainfo['interest_time'] = strtotime($data['interest_time']);
        $datainfo['status'] = C('ORDER_STATUS.INTERESTING');
        $resultdata = M('OrderGrave')->where('id='.$id)->save($datainfo);
        $info['type'] = 1;
        $info['order_id'] = $id;
        $info['admin_id'] = session('admin_id');
        $info['question'] = $data['reason'];
        $info['created_time'] = date('Y-m-d H:i:s');   
        $info['updated_time'] = date('Y-m-d H:i:s');   

        $order->create($info);
        $finally = $order->add();
        if($resultdata){
            $result['flag']=1;
        }else{
            $result['flag']=0;
        }
        echo json_encode($result);
    }


    /**
     * 追加有意向时间
     */
    public function addInterestTime(){
        $data = I('post.');
        $id = $data['orderid'];
        $reason['reason'] = $data['reason'];
        $reason['interest_time'] = strtotime($data['interest_time']);
        M('OrderGrave')->create($reason);
        $resultdata = M('OrderGrave')->where('id='.$id)->save();
        if($resultdata){
             $result['flag']= 1;
        }else{
            $result['flag']=0;
        }
        echo json_encode($result);

    }

    /**
     * 再次预约
     */
    public function appointagin(){
       if (IS_POST) {
                $data =  I('post.');
                if($data['status_num'] ==0){
                    $info = $data['info'];
                    $set = $data['set'];
                    $store = $set['store'];
                    $arr = explode('_', $store);
                    $orderInfo['province_id'] = $arr[0];
                    $orderInfo['city_id'] = $arr[1];
                    $orderInfo['store_id'] = $arr[2];
                    $orderInfo['store_name'] = $arr[3];
                    $orderInfo['buyer'] = $info['name'];
                    $orderInfo['mobile'] = $info['mobile'];
                    $orderInfo['status'] = C('DEFAULT_STATUS');
                    $orderInfo['order_grave_sn'] = makeSn();
                    $orderInfo['order_type'] = 2;
                    $orderInfo['member_status'] = $data['status_num'];
                    $orderInfo['created_time'] = time();
                    $orderInfo['appoint_time'] = $info['appoint_time'];
                    $orderInfo['order_flow_id'] = session('admin_id');
                    $order = M('OrderGrave')->add($orderInfo);
                    if($order){
                        $this->success('操作成功',U('/OrderGrave/notvip'));        
                    }                    
                }else{
                    $this->extend($data);
                }
        }else{
            $id= I('get.id');
            $orderId = I('get.orderid');
            $Region = M('region');
            $order = D('OrderGrave');
            $provinces = D('region')->getProvince();
            $regions = $Region->field("region_id,region_name")->where('pid=2')->select();//获取所有省份

            if(!empty($id)){
                $msg = D('appoint');
                $info = $msg->where('id='.$id)->find();
            }else{
                $info = $order->where('id='.$orderId)->find();
            }
            $this->assign('provinces', $provinces);
          $this->assign('order_flow', $this->getBusinessMen());
            $this->assign("info", $info);
            $this->display();

        }
        
    }

    /**
     * 与平台无关订单
     */
    public function NoRelation(){
        $id = I('post.orderId');
        $data['status'] = C('ORDER_STATUS.NO_RELATION');
        $data['updated_time'] = time();
        M('OrderGrave')->create($data);
        $ordermen =  $this->power();
        if($ordermen){
            $where['order_flow_id'] =  $ordermen;

        }

        $where['id'] = $id;
        $resultdata = M('OrderGrave')->where($where)->save();
        if($resultdata){
            $result['flag']= 1;
        }else{
            $result['flag'] = 0;
        }
        echo json_encode($result); 
    }
    

    /**
     *  后期申请返现
     */
    public function appointreturn() {
        if(IS_POST){
            if($_FILES['image']['name'])
            $result = array('flag'=>0,'msg'=>'操作失败');
            $postData = I('post.');
            $order_id = $postData['order_id'];
            $member_id = $postData['memberId'];
            $where['status'] = C('ORDER_STATUS.SUCCESS');
            // $where['brokerage_status'] = C('BROKERAGE_STATUS.SUCCESS');
            $where['apply_return_status'] = C('APPLY_RETURN_STATUS.DEFAULT_STATUS');
            $where['id'] = $order_id;
            $model = new Model();
            $orderModel = M('OrderGrave');
            $memberModel = M('Member');
            $orderInfo = $orderModel->where($where)->field('id,member_id,brokerage_percent,tomb_price,reason')->find();
            $memberInfo = $memberModel->field('id')->find($member_id);
            if(!empty($orderInfo) && !empty($memberInfo) && $memberInfo['id']==$orderInfo['member_id']){
                if($orderInfo['brokerage_percent']<=$postData['return_pesent_percent']){
                    $result['flag'] = 0;
                    $result['msg'] = '返现比率不能大于佣金比率';
                    echo json_encode($result);die;
                }
                $imagesRet = upload('image', C('ORDER_BILL_IMAGE'));
                // if(!$imagesRet['ok']){
                //     $result = array('flag'=>0,'msg'=>'请上传票据的文件');
                // }else{
                    //数据写入到票据表中
                    $model->startTrans();
                    $ordersBillModel = M('OrderGraveBill');
                    foreach ($imagesRet['images'] as $k=>$v){
                        $billData[$k]['order_grave_id'] = $orderInfo['id'];
                        $billData[$k]['status'] = C('NORMAL_STATUS');
                        $billData[$k]['bill_image'] = C('IMG_HOST').$v;
                        $billData[$k]['type'] = C('BILL_TYPE.CASH');
                        $billData[$k]['created_time'] = time();
                        $billData[$k]['bill_status'] = C('AUDIT_STATUS.SUCCESS');
                    }
                    $orderBillRet = $ordersBillModel->addAll($billData);
                    //用户的银行卡信息写入用户的表中
                    $memberModel = M('MemberBank');
                    $memberData['bank_type'] = '1';
                    $memberData['bank'] = $postData['bank_type'];
                    $memberData['member_id'] = $postData['memberId'];
                    $memberData['bank_account'] = $postData['bank_account'];
                    $memberData['bank_member'] = $postData['bank_member'];
                    $memberData['created_time'] = date('Y-m-d H:i:s');
                    $memberData['admin_id'] = session('admin_id');
                    $member_info = $memberModel->where('member_id='.$member_id)->find();
                    if(empty($member_info)){
                        $memberRet  = $memberModel->add($memberData);
                    }else{
                        $memberModel->create($memberData);
                        $memberRet = $memberModel->where('member_id='.$member_id)->save();
                    }
                    //返现数据写入订单表
                    $orderData['id'] = $order_id;
                    // $orderData['return_percent'] = $postData['return_pesent_percent'] * $orderInfo['tomb_price']/100;
                    $orderData['return_percent'] = $postData['return_pesent_percent'];
                    $orderData['return_money'] = $postData['return_money'];
                    $orderData['updated_time'] = time();
                    $orderData['status']   = C('ORDER_STATUS.GET_MONEY');
                    $orderData['apply_return_status'] = C('APPLY_RETURN_STATUS.OK_CHECK_RETURN_STATUS');
                    $orderData['payfor_customer_time'] = time();
                    $orderModel->create($orderData);
                    $orderRet = $orderModel->save();
                    // if($orderRet!=false && $memberRet!=false && $orderBillRet!=false){
                    if($orderRet!=false && $memberRet!=false){
                    
                        $result['flag'] = 1;
                        $result['msg'] = '操作成功';
                        $model->commit();
                    }else{
                        $result['msg'] = '数据写入失败';
                        $model->rollback();
                    }
                }
            }else{
                $result['flag'] = 0;
                $result['msg'] = '该信息不符合申请返现的条件';
            }
            echo json_encode($result);
        // }
    }

    /**
     * 订单完成后申请返现推送给财务
     */
    public function appointsendtofinance() {
        $id = I('post.orderId');
        $data['send_finance_status'] = C('SEND_TO_FINANCE.SUCCESS_FINANCE');
        $data['send_finance_admin_id'] = session('admin_id');
        $data['send_finance_time']  = time();
        M('OrderGrave')->create($data);
        $resultdata = M('OrderGrave')->where('id='.$id)->save();
        if($resultdata){
            $result['flag'] = 1;
            $result['msg'] = '推送成功';
        }else{
            $result['flag'] = 0;
            $result['msg'] = '推送失败';
        }
        echo json_encode($result);
    }


    /**
     * 订单委派列表
     */
    public function Share(){ 
        $order = D('OrderGrave');
        $where['status'] = array('not in','-1,10,30,31');
        $searchCondition = $this->getCondition();
        $this->searchStore($where);//查找商家名称
        if(!empty($searchCondition)){
            $where['_complex'] = $searchCondition;
        }
       $ordermen =  $this->power();
        if($ordermen){
            $where['order_flow_id'] =  $ordermen;

        }
        $fileds = 'id,store_id,member_id,mobile,buyer,store_status,pushed_status,appoint_time,created_time,store_name,apply_return_status,order_flow_id,status';
        $count = $order->where($where)->count();
        $Page = new Page($count, C('DEFAULT_PAGE_SIZE'));
        $list = $order->where($where)->field($fileds)->order('created_time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $show = $Page->show();
        $store = M('store')->where($map)->field('store_id,store_name')->select();
        $this->assign('store',$store);
        $this->assign('order_flow', $this->getBusinessMen(false,false));//商务跟踪人
        $this->assign('workmen',$this->getBusinessMen());
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show);
        $this->display();
    }


    /**
     * 更改跟踪人
     */
    public function changeFlowMan(){
        $postData = I('post.');
        $where['id'] = array('in',$postData['id']);
        $ret = M('OrderGrave')->where($where)->setField('order_flow_id',$postData['flow_man']);
        if($ret){
            $result['flag'] = 1;
            $result['msg'] = '操作成功';
        }else{
            $result['flag'] = 0;
            $result['msg'] = '操作失败';
        }
        echo json_encode($result);
    }


    /**订单回收站**/
    public function orderback(){
        $order = M('OrderGrave');
        $searchCondition = $this->getCondition();
        $this->searchStore($where);//查找商家名称
        if(!empty($searchCondition)){
            $where['_complex'] = $searchCondition;
        }
        $ordermen =  $this->power();
        if($ordermen){
            $where['order_flow_id'] =  $ordermen;

        }
        $conf = array(C('ORDER_STATUS.NO_RELATION'),C('ORDER_STATUS.FAIL'));
        $where['status'] = array('in',$conf);//31,1
        $field = 'id,order_type,mobile,buyer,order_flow_id,appoint_time,store_status,created_time,success_time,store_name,reason,updated_time';
        $count = $order->where($where)->count();
        $Page = new Page($count, C('DEFAULT_PAGE_SIZE'));
        $list = $order->where($where)->field($fileds)->order('created_time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();

        $show = $Page->show();
        $this->assign('order_flow', $this->getBusinessMen(false,false));//商务跟踪人
        $this->assign('workmen',$this->getBusinessMen());
        $this->assign('list',$list);
        $this->assign('page', $show);

        $this->display();
    }
    

    /**审核完成后查看信息**/
    public function lookinfo(){
        $memberId = I('post.memberId');
        $orderId = I('post.orderId');
        $orderfield = 'total_price,tomb_price,apply_return_status,brokerage_percent,brokerage_money,return_percent,return_money';
        $memberfield = 'bank_type,bank,bank_account,bank_member';
        $orderinfo = M('OrderGrave')->where('id='.$orderId)->field($orderfield)->find();
        $memberinfo = M('MemberBank')->where('member_id='.$memberId)->field($memberfield)->find();
        if($orderinfo){
            $result['flag'] = 1;
            $result['order'] = $orderinfo;
            $result['member'] = $memberinfo;
        }else{
            $result['flag'] = 0;
        }
        echo json_encode($result);
    }
    
}