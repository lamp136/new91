<?php
namespace Home\Model;
use Think\Model;
/**
 * Description of MsgCodeModel
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class MsgCodeModel extends Model
{

    /**
     * 判断一个手机号的短信发送次数是否达到了最大的发送次数
     * @return boolean
     */
    public function isMaxSendNum($mobile){
        $total = $this->where('mobile='.$mobile.' and created_time between '.strtotime(date("Y-m-d")."00:00:00").' and '.strtotime(date("Y-m-d")."23:59:59"))->count();
        if ((int)$total==C('EVERYDAY_SEND_MESSAGE_NUM')) {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    /**
     * 判断验证码是否正确，如果正确的话返回true,否则返回false
     * @param int $type                 验证码的类型
     * @param int $mobile               手机号
     * @param string $message_code      验证码
     * @return boolean
     */
    public function checkMessageCode($type,$mobile,$message_code){
        $where['type'] = $type;
        $where['mobile'] = $mobile;
        $where['code'] = $message_code;
        $where['status'] = C('MESSAGE_CODE_AVAILABLE');
        $where['created_time'] = array('gt',  (time()-600));
        $data = $this->field('mobile')->where($where)->order('created_time desc')->find();
        if(empty($data)){
            return false;
        }else{
            //将状态设置为已失效。
            $result = $this->where($where)->setField('status',C('MESSAGE_CODE_USED'));
            return true;
        }
    }
}
