<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
use Common\Extend\SendMsg;
use Think\Model;
use Think\Page;
    /**
 * 财务信息
 * @package Admin\Controller
 */

class MoneyController extends BaseController
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
        // if(!empty($start_time) && empty($end_time)){
        //     $where['created_time'] = array('egt',strtotime($start_time));
        // }
        // if(!empty($end_time) && empty($start_time)){
        //     $where['created_time'] = array('elt',  strtotime($end_time.' 23:59:59'));
        // }
        // if(!empty($start_time) && !empty($end_time)){
        //     $where['created_time'] = array('BETWEEN',array(strtotime($start_time),strtotime($end_time.' 23:59:59')));
        // }
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
        $orderObj = M('OrderGrave')->where($where)->field('store_id,store_name')->select();
        //用于搜索商家名称的数组
        foreach ($orderObj as $key => $value) {
            $store_name[$value['store_id']] = $value['store_name'];
        }
        $this->assign('store_name',$store_name);
    }
   
    /**
     * 陵园支付列表
     */
    public function storePaylist(){
        //陵园待支付给我们
        // $where['brokerage_status'] = C('BROKERAGE_STATUS.WAITING');
        //审核成功
        $where['status'] = C('ORDER_STATUS.CHECK_SUCCESS');
        //已发送财务
        $where['send_finance_status'] = C('SEND_TO_FINANCE.SUCCESS');
        $this->searchStore($where);//查找商家名称
        $searchCondition = $this->getCondition();
        if(!empty($searchCondition)){
            $where['_complex'] = $searchCondition;
        }
        $count = M('OrderGrave')->where($where)->count();
        $Page = new Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $followInfo = D('OrderGrave')->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->order('created_time desc')->select();
        
        $this->assign('order_flow', $this->getBusinessMen(false,false));
        $this->assign('page', $show);
        $this->assign('list', $followInfo);
        $this->display();
    }

    /**
     * 支付完成
     */
    public function payforSuccess() {

        $id = I('post.orderid');
        $resultdata = I('post.paid_in_amount');
        $data = M('OrderGrave')->where('id='.$id)->find();
        //订单-->客陵双方交易完成; 财务-->已发送至财务; 佣金-->待支付;
         // if($data['status'] == C('ORDER_STATUS.OK') && $data['send_finance_status'] == C('SEND_TO_FINANCE.SUCCESS') && $data['brokerage_status'] = C('BROKERAGE_STATUS.WAITING')) {
        //开启事务
        if(($data['apply_return_status']) == C('APPLY_RETURN_STATUS.DEFAULT_STATUS')) { 
        //不需要返现
            $model = new Model();
            $model->startTrans();
            $data['payfor_us_time'] = time(); //陵园支付给我们的时间
            $data['store_pay_admin_id'] = session('admin_id'); //确认陵园支付的人的ID
            $data['status'] = C('ORDER_STATUS.SUCCESS');//订单状态--已完成
            $data['updated_time'] = time();
            $data['apply_return_status'] =C('APPLY_RETURN_STATUS.DEFAULT_STATUS');
            // $data['brokerage_status'] = C('BROKERAGE_STATUS.GET_MONEY'); //佣金状态--> 已支付
            $data['paid_in_amount'] = $resultdata; //实收佣金金额
            $data['payfor_us_time'] = time();//陵园支付给我们的时间
            if(empty($data)){
                $model->rollback();
                $result['flag'] = 0;
                $result['msg'] = '数据有误';
                echo json_encode($result);die;
            }
            //数据写入到票据表中
            //上传票据
            $imagesRet = upload('image', C('ORDER_BILL_IMAGE'));
            // if(!$imagesRet['ok']){
            //     // $result = array('flag'=>0,'msg'=>'请上传票据的文件');
            //     // echo json_encode($result);die;  
            // }else{
                $ordersBillModel = M('OrderGraveBill');
                foreach ($imagesRet['images'] as $k=>$v){
                $billData[$k]['order_grave_id'] = $id;
                $billData[$k]['type'] = C('BILL_TYPE.BROKERAGE');
                $billData[$k]['bill_image'] = C('IMG_HOST').$v;
                $billData[$k]['created_time'] = time();
                $billData[$k]['bill_status'] = C('AUDIT_STATUS.SUCCESS');
                }   
            $orderBillRet = $ordersBillModel->addAll($billData);
            M('OrderGrave')->create($data);
            $datainfo = M('OrderGrave')->where('id='.$id)->save();
            if($datainfo){
                $model->commit();
                $result['flag'] = 1;
                $result['msg'] = '操作成功';
            }else{
                $model->rollback();
                $result['flag'] = 0;
                $result['msg'] = '操作失败';
            }
        // } 
       }else{  //需要返现
            $model = new Model();
            $model->startTrans();
            $data['payfor_us_time'] = time(); //陵园支付给我们的时间
            $data['store_pay_admin_id'] = session('admin_id'); //确认陵园支付的人的ID
            $data['updated_time'] = time();
            $data['status'] = C('ORDER_STATUS.GET_MONEY'); //佣金状态--> 已支付
            $data['apply_return_status']  = C('APPLY_RETURN_STATUS.OK_CHECK_RETURN_STATUS');//审核完成
            $data['paid_in_amount'] = $resultdata; //实收佣金金额
            //如果任何一个数据为空，则事务回滚
            if(empty($data)){
                $model->rollback();
                $result['flag'] = 0;
                $result['msg'] = '数据有误';
            }
            $imagesRet = upload('image', C('ORDER_BILL_IMAGE'));
            // if(!$imagesRet['ok']){
                // $result = array('flag'=>0,'msg'=>'请上传票据的文件');
                // echo json_encode($result);die;  
             
            // }else{
                $ordersBillModel = M('OrderGraveBill');
                foreach ($imagesRet['images'] as $k=>$v){
                $billData[$k]['order_grave_id'] = $id;
                $billData[$k]['type'] = C('BILL_TYPE.BROKERAGE');
                $billData[$k]['bill_image'] = C('IMG_HOST').$v;
                $billData[$k]['created_time'] = time();
                $billData[$k]['bill_status'] = C('AUDIT_STATUS.SUCCESS');
                }   
            $orderBillRet = $ordersBillModel->addAll($billData);
            M('OrderGrave')->create($data);
            $datainfo = M('OrderGrave')->where('id='.$id)->save();
            if($datainfo){
                $model->commit();
                $result['flag'] = 1;
                $result['msg'] = '操作成功';
            }else{
                $model->rollback();
                $result['flag'] = 0;
                $result['msg'] = '操作失败';
            }
           
       }
        echo json_encode($result);
  
    }

     /**
     * 用户返现订单
     */
    public function returnPesentList() {
        $sendarr = array(C('SEND_TO_FINANCE.SUCCESS'),C('SEND_TO_FINANCE.SUCCESS_FINANCE'));
        $tuisong = array(C('APPLY_RETURN_STATUS.NEED_RETURN_STATUS'),C('APPLY_RETURN_STATUS.OK_CHECK_RETURN_STATUS'));
        //佣金支付完成
        $where['status'] = C('ORDER_STATUS.GET_MONEY');//4
        //推送财务状态--已发送
        $where['send_finance_status'] = array('in',$sendarr);//已发送至财务1,2
        $where['apply_return_status'] = array('in',$tuisong);//客户返现状态--审核完成或者申请返现
        
        //2客户返现状态--审核完成
        $this->searchStore($where);//查找商家名称
        $searchCondition = $this->getCondition();
        if(!empty($searchCondition)){
            $where['_complex'] = $searchCondition;
        }
        $count = M('OrderGrave')->where($where)->count();
        $Page = new Page($count, C('DEFAULT_PAGE_SIZE'));
        $show = $Page->show();
        $followInfo = M('OrderGrave')->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->order('created_time desc')->select();

        //判断是否为会员--会员存在审核
        $member = $followInfo['return_percent'];
        if(!empty($member)) {
            return $followInfo;
        }
        
        $this->assign('order_flow', $this->getBusinessMen(false,false));//商务跟踪人
        $this->assign('page', $show);
        $this->assign('list', $followInfo);
        $this->display();
    }

     /**
      * 点击返现完成查询会员信息
      */
    public function memberMessage(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $memberId=I('memberId');
        if(!empty($memberId)){
            $memberBank = M('MemberBank');
            $message = $memberBank->where('member_id='.$memberId)->field('bank,bank_account,bank_member')->find();
            if($message){
                $message['bank'] = C('PAY_TYPE.'.$message['bank']);
                $result = array('flag'=>1,'data'=>$message);
            }
        }
        echo json_encode($result);
    }

    /**
     * 返现完成
     */
    public function returnForSuccess() {
        $id = I('orderid');
        $resultdata = I('post.return_money');
        $data = M('OrderGrave')->where('id='.$id)->find();
        //订单-->客陵双方交易完成; 财务-->已发送至财务; 佣金-->待支付;
         // if($data['status'] == C('ORDER_STATUS.OK') && $data['send_finance_status'] == C('SEND_TO_FINANCE.SUCCESS') && $data['brokerage_status'] = C('BROKERAGE_STATUS.WAITING')) {
        //开启事务
        
        //上传票据
        if ($_FILES['image']['error'] == 0 && !empty($_FILES['image']['tmp_name'])){
            $ret = uploadOne('image', C('ORDER_BILL_IMAGE'));
            if ($ret['ok'] == 0) {
                $this->error = $ret['error'];
                $result['flag'] = 0;
                $result['msg'] = '操作(票据上传)失败';
            }else{
                $info['bill_image'] = C('IMG_HOST') . $ret['images'][0];
                $info['order_grave_id'] = $id;
                $info['type'] = C('BILL_TYPE.CASH');
                $info['created_time'] = time();
                $billRes = M('order_grave_bill')->add($info);
                if(!$billRes){
                    $result['flag'] = 0;
                    $result['msg'] = '上传票据失败';
                }
            }
        }
            $model = new Model();
            $model->startTrans();
            $data['return_pay_admin_id'] = session('admin_id'); //确认返现的人的ID
            $data['status'] = C('ORDER_STATUS.SUCCESS');//返现完成--订单完成
            $data['updated_time'] = time();
            $data['return_fact_money'] = $resultdata; //实际返现金额金额
            $data['apply_return_status'] = C('APPLY_RETURN_STATUS.OK_CHECK_RETURN_STATUS');//返现状态--完成
            $data['payfor_customer_time'] = time();//返现给客户的时间
            if(empty($data)){
                $model->rollback();
                $result['flag'] = 0;
                $result['msg'] = '数据有误';
            }
            M('OrderGrave')->create($data);
            $datainfo = M('OrderGrave')->where('id='.$id)->save();
            if(!$datainfo){
                $model->rollback();
                $result['flag'] = 0;
                $result['msg'] = '操作失败';
            }else{
                $model->commit();
                $result['flag'] = 1;
                $result['msg'] = '操作成功';
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
     * 完成订单
     */
    public function finish() {
      // $arr = array(C('ORDER_STATUS.SUCCESS'));
      // $where['status'] = array('in',$arr); //订单状态  --已完成
      // $where['brokerage_status'] = C('BROKERAGE_STATUS.SUCCESS');//佣金状态 已完成
      $where['status'] = C('ORDER_STATUS.SUCCESS');
      $this->searchStore($where);//查找商家名称
      $searchCondition = $this->getCondition();
        if(!empty($searchCondition)){
            $where['_complex'] = $searchCondition;
        }
        $count = M('OrderGrave')->where($where)->count();
        $Page = new Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $followInfo = M('OrderGrave')->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->order('success_time desc')->select();
        
        $this->assign('page', $show);
        $this->assign('list', $followInfo);
        $this->display();
    }
    
    /*
     * 财务退单列表
     * return viod;
     */
    public function singleBackList(){
        $search = I('post.');
        if(!empty($search['SearchStore'])){
            $where['store_id'] = $search['SearchStore'];
        }
        $where['status'] = array('in',array(C('ORDER_STATUS.ALLOW'),C('ORDER_STATUS.BACK_SUCCESS'))); 
        $where['back_money'] = array('not in',array('0'));
        if(!empty($search['mobile'])){
            $where['mobile'] = array('like','%'.$search['mobile'].'%');
        }
        $count = M('OrderGrave')->where($where)->count();
        $Page = new Page($count, C('PAGE_SIZE'));
        $show = $Page->show();
        $OrderGraveModel = M('OrderGrave');
        $list = $OrderGraveModel->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->order('status ASC,updated_time DESC')->select();
       
        $storeWhere['status'] = array('in',array(C('ORDER_STATUS.ALLOW'),C('ORDER_STATUS.BACK_SUCCESS')));
        $storeWhere['back_fact_money'] = array('not in',array('0'));
        $listStore = $OrderGraveModel->field('store_id,store_name')->where($storeWhere)->select();
        foreach($listStore as  $value){
            $searchlist[$value['store_id']] = $value['store_name'];
        }
        $this->assign('search',$search);
        $this->assign('Searchlist',$searchlist);
        $this->assign('page', $show);
        $this->assign('list', $list);
        $this->display();
    }
    /*
     * 财务退单查看银行信息
     */
    public function bankMsg(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $storeId = I('post.id');
        if(!empty($storeId)){
            $storeId = M('Store')->field('store_profiles_id')->where('store_id = '.$storeId)->find();
            $bankInfo = M('StoreProfilesDetail')->field('id,bank,bank_member,bank_account')->where('id = '.$storeId['store_profiles_id'])->find();
            if($bankInfo){
                $result = array('flag'=>1,'data'=>$bankInfo);
            }
        }
        echo json_encode($result);
    }
    
    /*
     * 财务确定退单打款
     * 
     * @return String Json
     */
    public function paymoney(){
        $data = I('post.');
        
        $result = array('flag'=>0,'msg'=>'操作失败！');
        if($data['action'] == 'get'){
            if(!empty($data['id'])){
                $data = M('order_grave')->field('id,brokerage_percent,brokerage_money,paid_in_amount,return_money,back_money')->where('id = '.$data['id'])->find();
                $result = array('flag' => 1, 'data' => $data);
            }
        }else if($data['action'] == 'post'){
            if(!empty($data['id'])){
                //开启事务
                $model = new Model();
                $model->startTrans();
                //上传票据图片
                if ($_FILES['image']['error'] == 0 && !empty($_FILES['image']['tmp_name'])) {
                    $ret = uploadOne('image', C('ORDER_BILL_IMAGE'));
                    if ($ret['ok'] == 0) {
                        $this->error = $ret['error'];
                        $result = array('flag'=>0,'msg'=>'操作(票据上传)失败！');
                        echo json_encode($result);die;
                    }else{
                        $info['bill_image'] = C('IMG_HOST') . $ret['images'][0];
                        $info['order_grave_id'] = $data['id'];
                        $info['type'] = C('BILL_TYPE.BACK');
                        $info['created_time'] = time();
                        $billRes = M('order_grave_bill')->add($info);
                        if(!empty($billRes)){
                            $result = array('flag'=>0,'msg'=>'图片信息写入失败！');
                            echo json_encode($result); die;
                        }
                    }
                }
                $datas['id'] = $data['id'];
                $datas['back_fact_money'] = $data['back_fact_money'];
                $datas['status'] = C('ORDER_STATUS.BACK_SUCCESS');
                $datas['updated_time'] = time();
                $datas['back_money_time'] = date('y-m-d h:i:s',time());
                if(M('order_grave')->save($datas)){
                    $model->commit();
                    $result = array('flag' => 1, 'msg' => '操作成功！');
                }else {
                    $model->rollback();
                } 
            }
        }
        echo json_encode($result);
    }
 }

