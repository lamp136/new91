<?php
namespace Admin\Controller;

use Think\Controller;
/**
 * 后台登陆控制器
 *
 * @author hgy
 */
class LoginController extends Controller
{
    /**
     * 登陆方法
     * 如果直接访问其他方法没有登陆直接跳转到这里
     *
     * @return void |
     */
    public function login()
    { 
        if(IS_POST){
            $verify = I('code');
            $checkVerify = $this->checkVerifyCode($verify);
            if(!$checkVerify){
                $result['flag'] = 1;
                $result['msg']  = '亲，验证码输错了哦！';
            } else {
                $pwd      = I('password');
                $password = encryptAdmin($pwd);
                $email    = I("email");

                $where = array(
                    'pwd'    => $password,
                    'email'  => $email,
                );
                $admin    = M("Admin");
                $info     = $admin->where($where)->find();
                if($info) {
                    //首先判断用户是否正常
                    if ($info['status'] == C('DELETE_STATUS')) {
                        $result['flag'] = 2;
                        $result['msg'] = '该账号已被禁用';
                    } else{
                        //判断用户是否是超级用户
                        if($email!=C('ADMIN_EMAIL')){
                            //获取该用户具有的权限
                            $privilege = D('privilege')->getUsetPrivilege($info['id']);
                            session('privilegeData',$privilege['name']);
                            session('privilegeIdsData',$privilege['ids']);
                        }
                        session('email',$email);
                        session('admin_id',$info['id']);
                        $result['flag'] = 3;
                        $result['msg'] = '登录成功';
                        /**
                         * 写入登录log
                         */
                        $login_log_db = M('LoginLogs');
                        $login_log_db->add(array(
                            'admin_id'    => $info['id'],
                            'client_name' => $info['email'],
                            'user_agent'  => get_client_browser(),
                            'login_ip'    => get_client_ip(1),
                            'login_time'  => date('Y-m-d H:i:s'),
                        ));
                    }
                } else {
                    $result['flag'] = 4;
                    $result['msg'] = '用户名或密码错误';
                }
            }
            echo json_encode($result);
        }else{
            if(session('?admin_id')){
                $this->redirect('Index/index');
            }
            $this->display();
        }
    }
    /**
     * 获取验证码
     *
     *@return void
     */
    public function getVerifyCode()
    {
        $verify = new \Think\Verify();
        $verify->fontSize = 20;
        $verify->length   = 4;
        $verify->useNoise = false;
        $verify->codeSet  = '0123456789';
        $verify->imageW   = 0;
        $verify->imageH   = 0;
        $verify->useCurve = false;
        $verify->entry();
    }

    /**
     * 验证 验证码
     *
     * @param string $code 用户验证码
     * @param string $id   验证码标识
     *
     * @return bool
     */
    public function checkVerifyCode($code, $id='')
    {
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }
    /**
     * 推出登陆
     *
     * @return void
     */
    public function logout()
    {
        session('email',null);
        session('admin_id',null);
        session('businessPrivilege',null);
        $this->redirect('Login/login','');
    }
}