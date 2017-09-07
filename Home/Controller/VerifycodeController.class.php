<?php
namespace Home\Controller;

use Think\Controller;
/**
 * Description of VerifycodeController
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class VerifycodeController extends Controller{
    
    /**
     * 验证码生成
     */
    function verify_code()
    {
        $verify = new \Think\Verify();
        $verify->fontSize = 20;
        $verify->length   = 4;
        $verify->useNoise = false;
        $verify->codeSet = '0123456789';
        $verify->imageW = 0;
        $verify->imageH = 0;
        $verify->entry();
    }
    
    
}
