<?php
namespace Home\Controller;

use Think\Controller;
use Common\Extend\SendMsg;
/**
 * Description of MemberController
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class MemberController extends Controller{

    /**
     * 用户注册
     */
    public function login(){
        $mobile = '';
        $password = '';
        $loginState = '';
        $lgstatus = session('loginState');
        if(isset($lgstatus) &&  $lgstatus == 1) {
            $mobile = session('member_mobile');
            $password = session('password');
            $loginState = 1;
        }
        $this->assign('mobile',$mobile);
        $this->assign('password',$password);
        $this->assign('loginState',$loginState);
        $this->display();
    }

    /**
     * 提交登录表单
     * 
     * @return void
     */
    public function submitlogin(){
        if(IS_POST){
            $result = array('flag'=>0,'msg'=>'用户名或密码错误');
            $postData = I('post.');
            $mobile = $postData['mobile'];
            $password = encryptHome($postData['password']);
            $where['mobile'] =$mobile;
            $where['password'] =$password;
            $member = M('Member')->where($where)->field('id,mobile,name,status')->find();
            if(!empty($member)){
                if($member['status']==C('NORMAL_STATUS')){
                    if($postData['loginState']) {
                        session('loginState',1);
                        cookie('loginState',1,time()+C('HOME_LIFETIME'));
                        session('password',$postData['password']);
                    }

                    session('member_id',$member['id']);
                    session('member_name',$member['name']);
                    session('member_mobile',$member['mobile']);
                    cookie('mobile',$result['mobile'],time()+C('HOME_LIFETIME'));
                    cookie('password',$result['password'],time()+C('HOME_LIFETIME'));
                    $result['flag'] = 1;
                    $result['msg'] ='登陆成功';
                }else{
                    $result['flag'] = 0;
                    $result['msg'] ='该账号被禁用，有问题请联系客服人员';
                }
            }
            echo json_encode($result);
        }
    }


    /**
     * 用户注册显示页面
     */
    public function register() {
        //判断是否登录
        $admin_id = session('member_name');
        if(!empty($admin_id)){
            $this->redirect('/');
        }else{
            $this->display();
        }
    }

    /**
     * 检测手机号是否存在
     */
    public function checkusermobile() {
        $result = array('flag'=>0,'msg'=>'');
        $where['mobile'] = I('post.mobile');
        $where['status'] = C('NORMAL_STATUS');
        $member = M('Member')->where($where)->find();
        if(!empty($member)){
            $result['flag'] = 1;
            $result['msg'] = '该手机号已存在';
        }
        echo json_encode($result);
    }

    /**
     * 注册时发送短信息
     */
    public function sendmessage() {
        if(IS_POST){
            header("Content-Type:text/html; charset=utf-8");
            $mobile = I('post.mobile');
            if(preg_match('/^1[3|4|5|7|8][0-9]\d{8}$/',$mobile)){
                //判断发送验证码的次数是否超过了每个人每天限制的次数
                $messageCode = D('MsgCode');
                $isMaxSendNum = $messageCode->isMaxSendNum($mobile);
                if($isMaxSendNum){
                    $result = array('flag'=>0, 'msg'=>"请不要恶意点击");
                }else{
                    $mobile_code = rand(100000,999999);
                    $message = "动态验证码 " . $mobile_code . " 工作人员不会向你索要，请勿向任何人泄露。" . date("Y-m-d H:i:s", time()) . "【91搜墓网】";
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
                        
                        $msgcodedata['mobile'] = $mobile;
                        $msgcodedata['code'] = $mobile_code;
                        $msgcodedata['type'] = C('MSGCODE_TYPE.REGISTER');
                        $msgcodedata['created_time'] = time();
                        if($messageCode->create($msgcodedata) && $messageCode->add()){
                            $result = array('flag'=>1, 'msg'=>"发送成功");
                        }
                    } else {
                        $result = array('flag'=>0, 'msg'=>"验证码发送失败");
                    }
                }
            } else {
                $result = array('flag'=>0, 'msg'=>"手机格式不正确,请认真填写");
            }

            echo json_encode($result);
        }
    }
    /**
     * 提交用户注册信息
     */
    public function submitregister() {
        if(IS_POST){
            $postData = I('post.');
            $mobile = $postData['mobile'];
            if($postData['name']=='' || $postData['mobile']=='' || $postData['password']==''){
                $result['flag'] = '0';
                $result['msg'] = '信息填写不全';
            }else{
                $memberModel = M('Member');
                //判断手机号是否存在
                $where['mobile'] = $mobile;
                $where['status'] = C('NORMAL_STATUS');
                $member = $memberModel->where($where)->find();
                if(!empty($member)){
                    $result['flag'] = '1';
                    $result['msg'] = '该手机号存在';
                }else{
                    //检测动态验证
                    $msgcode = $postData['msgcode'];
                    $MsgCodeModel = D('MsgCode');
                    $type = C('MSGCODE_TYPE.REGISTER');
                    $code_result = $MsgCodeModel->checkMessageCode($type,$mobile,$msgcode);
                    if(!$code_result){
                        $result['flag'] = '2';
                        $result['msg'] = '动态校验码错误';
                    }else{
                        $memberData['mobile'] = $mobile;
                        $memberData['name'] = $postData['name'];
                        $memberData['member_type'] = C('MEMBER_FRONT_REGISTER');
                        $memberData['check_mobile'] = C('NORMAL_STATUS');
                        $memberData['password'] = encryptHome($postData['password']);
                        $memberData['reg_ip'] = get_client_ip(1,TRUE);
                        $memberData['status'] =  C('NORMAL_STATUS');
                        $memberData['created_time'] =  date('Y-m-d H:i:s');
                        $memberModel->create($memberData);
                        $insertid = $memberModel->add();
                        if($insertid){
                            session('member_id',$insertid);
                            session('member_name',$postData['name']);
                            session('member_mobile',$mobile);
                            $result['flag'] = '10';
                            $result['msg'] = '注册成功';
                        }else{
                            $result['flag'] = '3';
                            $result['msg'] = '注册失败';
                        }
                    }
                }
            }
            echo json_encode($result);
        }
    }
    
    /**
     * 用户退出登录
     * 
     * @return void
     */
    public function logout() {
        session('member_id',null);
        session('member_name',null);
        session('member_mobile',null);
        $this->redirect('/');
    }
}
