<?php

    /**
     * 前台订单的状态
     *
     * @param int $status                   订单的状态
     * @param int $audit_status             票据的状态
     * @param int $return_pesent_status     返现的状态
     * @param int $send_to_finance          是否推送给财务
     *
     * @return string                       返回订单的状态
     */

    function orderStatus($status,$audit_status,$return_pesent_status,$send_to_finance){
        $shen = array(1,3,5);
        $tui = array(21,22);
        if($status==C('ORDER_STATUS.DEFAULT') || $status ==C('ORDER_STATUS.INTERESTING')){
            return '下单成功';
        }else if($status==C('ORDER_STATUS.FAIL')){
            return '交易取消';
        }else if($status==C('ORDER_STATUS.SUCCESS')){
            return '已完成';
        }else if($status==C('ORDER_STATUS.GET_MONEY')){
            return '待返现';
        }else if(in_array($status,$shen)){
            return '购墓成功';
        }else if(in_array($status,$tui)){
            return '退单审核中';
        }else if($status == C('ORDER_STATUS.BACK_SUCCESS')){
            return '退单完成';
        }
            
    }

    /**
     * 订单的操作状态
     *
     * @param int $status               订单的状态
     * @param int $audit_status         票据的状态
     * @param int $return_pesent_status 返现状态
     * @param int $member_staus         会员状态
     * @param int $order_id             订单的id
     * @param int $commend_status       是否已经评论
     * @return void 输出链接地址
     */
    // function orderOperrate($status,$audit_status,$store_status,$return_pesent_status,$order_id,$commend_status){
            
    //     //非会员完成订单
    //     if($store_status == 0 && $status == C('ORDER_STATUS.SUCCESS') && $commend_status==0){
    //             echo "<a  class='order_evaluate'>待评价</a>";

    //     }else if($store_status == 0 && $status == C('ORDER_STATUS.SUCCESS') && $commend_status==1){
    //             echo "<a  class='comment'>查看评论</a>";

    //     }else if($store_status !=0){
    //             if($store_status !=0 &&$status ==C('ORDER_STATUS.SUCCESS') && $return_pesent_status ==0 && $commend_status==0){//会员不需要返现待评价
    //               echo "<a  class='order_evaluate'>待评价</a>";

    //             }else if( $store_status !=0 && $return_pesent_status ==0 && $status ==C('ORDER_STATUS.SUCCESS')&& $commend_status==1){//会员不需要返现查看评论
    //                 echo "<a  class='comment'>查看评论</a>";

    //             }else if($store_status !=0 &&$return_pesent_status !=0 && $status==C('ORDER_STATUS.GET_MONEY') && $audit_status==0){//会员需要返现，申请返现需上传票据 状态为已收佣金
    //                 echo "<a href=".U('/uploadbill/'.$order_id)." class='order_bill'>上传票据</a><br>";
    //                 // echo "<a class='returnmoney'>申请返现</a>"; 

    //             }else if($store_status !=0 && $status==C('ORDER_STATUS.RETURN_SUCCESS')){//会员返现成功 
    //                 echo "<a>返现成功</a>";

    //             }else if($store_status !=0 && $return_pesent_status ==2 && $status==C('ORDER_STATUS.SUCCESS') && $commend_status==0){//会员需要返现，申请返现需上传票据
    //                 echo "<a  class='order_evaluate'>待评价</a><br>";
    //                 // echo "<a  class='orderback'>申请退单</a>";

    //             }else if($store_status !=0 && $return_pesent_status ==2 && $status==C('ORDER_STATUS.SUCCESS') && $commend_status==1){//申返审核完成，订单完成，
    //                 echo "<a  class='comment'>查看评论</a><br>";
    //                 // echo "<a  class='orderback'>申请退单</a>";
    //             }
    //         }
    // }

    function autoVer($url){
        if (file_exists('./Public'.$url)) {
            $ver = filemtime($_SERVER['DOCUMENT_ROOT'].'./Public'.$url);
            echo $url.'?v='.$ver;
        }
    }

    function getMemberId($mobile,$name){
        $memberModel = M('member');
        $member = $memberModel->where("mobile='".$mobile."'")->find();
        if(empty($member)){
            $password =  encryptHome(substr($mobile,-6));
            $memberData['mobile'] = $mobile;
            $memberData['name'] = $name;
            $memberData['member_type'] = C('MEMBER_FRONT_REGISTER');
            $memberData['check_mobile'] = C('NORMAL_STATUS');
            $memberData['password'] = $password;
            $memberData['reg_ip'] = get_client_ip(1,TRUE);
            $memberData['status'] =  C('NORMAL_STATUS');
            $memberData['created_time'] =  date('Y-m-d H:i:s');
            if($memberModel->create($memberData) && $memberModel->add()){
                $membeId = $memberModel->getLastInsID();
                session('member_id',$membeId);
                session('member_name',$memberData['name']);
                session('member_mobile',$memberData['mobile']);
                return $membeId;
            }  else {
                return 0;
            }
        }
        session('member_id',$member['id']);
        session('member_name',$member['name']);
        session('member_mobile',$member['mobile']);
        return $member['id'];
    }

