<?php
namespace Home\Controller;

use Home\Controller\BaseController;
use Home\Model;
use Think\Verify;
use Think\Page;
use Common\Extend\SendMsg;

/**
 * 用户中心控制器
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class UserCenterController extends BaseController{

    public function _initialize() {
        parent::_initialize();
        $sessionMemberId = session('member_id');
        if(empty($sessionMemberId)){
            $this->redirect('/login');
        }
    }

    /**
     * 个人资料展示页
     *
     * @return void
     */
    public function personal() {
        $memberModel = M('Member');
        $memberModelBank =  M('MemberBank');
        $sessionMemberId = session('member_id');
        $memberData = $memberModel->find($sessionMemberId);
        $memberBank = $memberModelBank->where('member_id='.$sessionMemberId )->find();
        $this->pay_type = C('PAY_TYPE');
        $this->memberData = $memberData;
        $this->memberBank = $memberBank;

        $this->display();
    }

    /**
     * 保存用户的修改信息
     *
     * @return string
     */
    public function savememberinfo(){
        if(IS_POST){
            $result = array('flag'=>0,'msg'=>'操作失败');
            $postData = I('post.');
            $MemberModel = M('member');
            if(strpos($postData['bank_account'], '**')!==false){
                //说明银行卡账号不修改
                unset($postData['bank_account']);
            }
            $memberId = session('member_id');
            $memb['id'] = $memberId;
            //以下存入用戶表中
            $memb['name'] = $postData['name'];
            session('member_name',$postData['name']);
            $memb['mobile'] = $postData['mobile'];
            $memb['updated_time'] = date('Y-m-d H:i:s',time());
            $MemberModel->create($memb);
            $membresult = $MemberModel->save();
            //以下存用戶銀行信息
            if(!empty($postData['bank_account'])){
                $bank['bank_type'] = $postData['bank_type'];
                $payType = C('PAY_TYPE');
                $bank['bank'] = $payType[$bank['bank_type']];
                $bank['bank_account'] = $postData['bank_account'];
                $bank['bank_member'] = $postData['bank_member'];
                $bank['status'] = C('NORMAL_STATUS');
                $MemberBank = M('MemberBank');
                $info = $MemberBank->where('member_id='.$memberId.' and status='.C('NORMAL_STATUS'))->count(); 
                if(!empty($info)){
                    $MemberBank->where('member_id='.$memberId)->save($bank);
                }else{
                    $bank['created_time'] = date('Y-m-d H:i:s',time());
                    $bank['member_id'] = $memberId;
                    $bank['region_ip'] = ip2long(get_client_ip());
                    $MemberBank->add($bank);
                }
            }
            if($membresult){
                $result['flag'] = 1;
                $result['msg'] = '修改成功';
            }
            echo json_encode($result);
        }
    }

    
   /**
    * 领取返现
    * 
    * @return void
    */
    // public function cashback(){
    //     $map['member_id'] = session('member_id');
    //     $map['status'] = C('ORDER_STATUS.SUCCESS');
    //     $map['apply_return_status'] = C('APPLY_RETURN_STATUS.OK_CHECK_RETURN_STATUS');
    //     // $map['bill_status'] = C('AUDIT_STATUS.DEFAULT');
    //     $cashback = M('OrderGrave')->where($map)->count();
    //     $this->assign('cashback',$cashback);
    //     $this->display();
    // }


    /**
     * 我的评价
     * 
     * @return
     */
    public function evaluate(){
        $map = I("post.");

        if(count($map)>4){
            $map['member_id'] = session('member_id');
            $map['mobile'] = session('member_mobile');
            $map['comment_time'] = date("Y-m-d H:i:s",time());

            // 评论过滤敏感词
            $path = './Public/Home/Files/keywords.txt';
            $file = file_get_contents($path);
            $badwords = explode("\n",$file);
            $content = I('content');
            $map['content'] = str_replace($badwords,"*",$content);
            
            $comment = M('comment')->data($map)->add();
            if($comment){
                $result['flag'] = 1;
                $result['msg']  =' 评论成功！';
            }else{
                $result['flag'] = 0;
                $result['msg']  =' 评论失败！';
            }
        }else{
            $result['flag'] = 0;
            $result['msg'] = '评论不能为空！';
        }
        echo json_encode($result);
    }
   
    /**
     * 保存用户修改的密码
     *
     * @retrun string
     */
    public function savepassword(){
        if(IS_POST){
            $result = array('flag'=>0,'msg'=>'操作失败');
            $memberModel = M('Member');
            $postData = I('post.');
            $memberId = session('member_id');
            if(empty($memberId)){
                $result['flag'] = 1;
                $result['msg'] = '登陆超时';
                echo json_encode($result);die;
            }
            // 核实验证码是否正确
            $verify = new Verify();
            $check = $verify->check($postData['code']);
            if(!$check){
                $result['flag'] = 2;
                $result['msg'] = '验证码错误';
                echo json_encode($result);die;
            }
            // 判断用户密码是否正确
            $password = encryptHome($postData['oldpassword']);
            $where['id'] = $memberId;
            $memberData = $memberModel->field('password')->find($memberId);
            if(empty($memberData) || $password!=$memberData['password']){
                $result['flag'] = 3;
                $result['msg'] = '原始密码错误';
                echo json_encode($result);die;
            }
            // 修改数据
            $updateData['id'] = $memberId;
            $updateData['password'] = encryptHome($postData['newpassword']);
            if($memberModel->create($updateData) && $memberModel->save()!==false){
                $result['flag'] = 10;
                $result['msg'] = '修改成功';
                echo json_encode($result);
            }else{
                $result['flag'] = 4;
                $result['msg'] = '修改失败';
                echo json_encode($result);
            }
        }
    }

    /**
     * 我的订单
     *
     * @return void
     */
    public function myorder(){
        $ordersModel = D('OrderGrave');
        $memberId = session('member_id');
        $totalRows = $ordersModel->where('member_id='.$memberId)->count();
        $page = new Page($totalRows,4);
        $pageshow = $page->frontshow();
        $orders = $ordersModel->where('member_id='.$memberId)->order('id desc')->limit($page->firstRow,$page->listRows)->select();

        for($i=0;$i<count($orders);$i++){
            $where['store_id'] = $orders[$i]['store_id'];
            $where['member_id'] = session('member_id');
            $msg = M('comment')->where($where)->count();
            if($msg){
                $orders[$i]['commend_status'] = 1;//已经评论
            }else{
                $orders[$i]['commend_status'] = 0;//未评论
            }
            $tiaojian['order_grave_id'] = $orders[$i]['id'];
            $billData = M('OrderGraveBill')->where($tiaojian)->count();
            if($billData){
                $orders[$i]['bill_status'] = 1;//有票据
            }else{
                $orders[$i]['bill_status'] = 0;//没有票据
            }

        }
        $this->orders = $orders;
        $this->pageshow = $pageshow;
        $this->display();
    }
    /**
     * 我的关注 
     * 
     * @return void
     */
    public function collect(){
        if(IS_POST){
            $info['collect_id'] = I('post.collect_id');
            $data['status'] = C('DELETE_STATUS');
            $res = M('collect')->where('id='.$info['collect_id'])->data($data)->save(); 
            if($res){
                $result['flag'] = 1;
                $result['msg'] = '取消关注成功';
            }else{
                $result['flag'] = 0;
                $result['msg'] = '取消关注失败！';
            }
            echo json_encode($result);die;
        }else{
            $member_id = session('member_id');
            $collectInfo = D('Collect')->relation(array('Store','StoreImg'))->where('member_id='.$member_id." and status=".C('NORMAL_STATUS'))->order("create_time desc")->select();
            $collectInfoNum = count($collectInfo);
            for($i=0;$i<$collectInfoNum;$i++){
                $store_id = $collectInfo[$i]['store_id'];
                //浏览量
                $fileHits = F('hits_'.$store_id,'',C('HITS_CACHE_FILE'));
                if(C('HITS_TURN_ON') && !empty($fileHits)){
                    $collectInfo[$i]['Store']['hits'] = $fileHits;
                }
                //评论星星
                //获取客户评论量
                /*$scores = M('comment')->field('environment,service,price,traffic')->where('store_id='.$store_id." and comment_status=".C('NORMAL_STATUS'))->select();
                $count = 0;
                foreach($scores as $key=>$value){
                    $count += array_sum($value)/4;
                }
                $collectInfo[$i]['scores'] = round($count/count($scores));*/
                //获取商家评论量
                $collectInfo[$i]['scores'] = round(($collectInfo[$i]['Store']['review_price']+$collectInfo[$i]['Store']['review_traffic']+$collectInfo[$i]['Store']['review_ambient']+$collectInfo[$i]['Store']['review_service'])/4);
            }
            $this->assign('collectInfo',$collectInfo);
            $this->display();
        }
    }

    /**查看我的评论**/
    public function comment(){
        $data = I('post.');
        $where['store_id'] = $data['store_id'];
        $where['member_id'] = $data['member_id'];
        $content  = M('comment')->where($where)->field('content,price,environment,service,traffic')->find();
        if($content){
            $result['flag'] == 1;
            $result['msg'] = $content['content'];
            $result['environment'] = $content['environment'];
            $result['price'] = $content['price'];
            $result['service'] = $content['service'];
            $result['traffic'] = $content['traffic'];

        }
        echo json_encode($result);die;
    }

    // /**申请退单**/
    // public function orderback(){
    //     $orderid =I('post.order_id');
    //     $status['status'] = C('ORDER_STATUS.APPLY_BACK');
    //     $status['back_apply_time'] = time();
    //     $orders = M('OrderGrave');
    //     $orders->where('id='.$orderid)->create($status);
    //     $info =$orders->save();
    //     if($info){
    //         $result['flag']=1; 
    //     }
    //     echo json_encode($result);die;
    // }


    /**申请退单**/
    public function orderback(){
   
        if(IS_POST){
            $orderid =I('post.order_id');
            $data = M('OrderGrave')->where('id='.$orderid)->find();
            header("Content-Type:text/html; charset=utf-8");
            $cusmobile = $data['mobile'];
            // $mobile = C('BUSINESS_SERVICER_MOBILE');
            $mobile = "15712890268";
            if(preg_match('/^1[3|4|5|7|8][0-9]\d{8}$/',$mobile)){
                //判断发送验证码的次数是否超过了每个人每天限制的次数
                $messageCode = D('MsgCode');
                $isMaxSendNum = $messageCode->isMaxSendNum($cusmobile);
                if($isMaxSendNum){
                    $result = array('flag'=>0, 'msg'=>"我们的工作人员会尽快与您取得联系");
                }else{
                    $buyer = $data['buyer'];
                    $storename = $data['store_name'];
                    $message = "工作人员请注意!订单编号为 " . $orderid . "的".$buyer."申请退单，其订单陵园为".$storename." 请及时与客户取得联系。" . date("Y-m-d H:i:s", time()) . "【91搜墓网】";
                    $sendMsg = new SendMsg();
                    $ret = $sendMsg->sendMsg($mobile,$message);
                    if ($ret) {
                        //将发送的短信写入短信记录中
                        $msglogData['classify'] = C('MSG_LOG_REGISTER');
                        $msglogData['mobile'] = $mobile;
                        $msglogData['msg'] = $message;
                        $msglogData['status'] = C('MSG_SEND_STATUS');
                        $msglogData['created_time'] = time();
                        $msglogData['send_time'] = time();
                        $msglogModel = M('MsgLog');
                        $msglogModel->create($msglogData);
                        $msglogModel->add();
                        
                        $msgcodedata['mobile'] = $cusmobile;
                        $msgcodedata['type'] = C('MSGCODE_TYPE.APPOINT');
                        $msgcodedata['created_time'] = time();
                        if($messageCode->create($msgcodedata) && $messageCode->add()){
                            $result = array('flag'=>1, 'msg'=>"发送申请成功,工作人员会尽快与您取得联系");
                        }
                    } else {
                        $result = array('flag'=>0, 'msg'=>"申请成功，请与91搜墓网工作人员取得联系。联系电话400-8010-344");
                    }
                }
            } else {
                $result = array('flag'=>0, 'msg'=>"申请成功，请与91搜墓网工作人员取得联系。联系电话400-8010-344");
            }

            echo json_encode($result);
        }
    }
         
    public function uploadbillinfo(){
        $memberId = session('member_id');
        $orderModele = M('OrderGrave');
        $order_id = I('post.order_id');
        $orderInfo = $orderModele->where('member_id='.$memberId.' and id='.$order_id)->field('order_grave_sn')->find();

        if(empty($orderInfo)){
            $result['flag'] =2;
            $result['msg'] = '信息错误';
        }
        $imagesRet = upload('image', C('ORDER_BILL_IMAGE'));
        if(!$imagesRet['ok']){
            $this->error('没有上传文件');
        }else{
            $model = new \Think\Model();
            $model->startTrans();
            //数据写入到票据表中
            $ordersBillModel = M('OrderGraveBill');
            foreach ($imagesRet['images'] as $k => $v){
                $billData[$k]['order_grave_id'] = $order_id;
                $billData[$k]['order_grave_sn'] = $orderInfo['order_grave_sn'];
                $billData[$k]['bill_image']     = C('IMG_HOST').$v;
                $billData[$k]['created_time']   = time();
                $billData[$k]['type']           = 2;
            }
            $orderBillRet = $ordersBillModel->addAll($billData);
            //同时将订单中的票据信息修改
            $orderData['id'] = $order_id;
            $orderData['apply_return_status'] = C('APPLY_RETURN_STATUS.NEED_RETURN_STATUS');
            $orderModele = M('OrderGrave');
            $orderModele->create($orderData);
            $orderRet = $orderModele->save();
            //var_dump($orderRet);die;
            if($orderRet!==false && $orderBillRet){
                $model->commit();
                $result['flag'] =1 ;
                $result['msg'] = '上传成功，请等待审核';
            }else{
                $model->rollback();
                 $result['flag'] =0 ;
                $result['msg'] = '上传失败';
            }
        }
        echo json_encode($result);die;
    } 
    
    /**
     * 上传票据
     */
    public function uploadbill(){
        $memberId = session('member_id');
        $orderModele = M('OrderGrave');

        $order_id = I('get.order_id');
        if(empty($order_id)){
            $this->error('参数错误');die;
        }
        $storeInfo = $orderModele->where('member_id='.$memberId)->field('id')->find($order_id);
        if(empty($storeInfo)){
            $this->error('信息错误');
        }
        $this->display();
    }
}
