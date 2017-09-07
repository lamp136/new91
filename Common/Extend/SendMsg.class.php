<?php
namespace Common\Extend;
//设置默认时区为北京时间
date_default_timezone_set('PRC');
/**
 * 发送短信的接口类 和 短信平台进行通信
  *
  * @author  Gavin
  * @date：2015年11月12日 下午4:47:16
  * @version 1.0
 */
class SendMsg
{
    //短信接口用户名 $uid
    private $uid = "tclkj03905";
    //短信接口密码 $passwd
    private $pwd = "hgy@mnc";
    //短信平台URL地址
    private $url = "http://inolink.com/WS/BatchSend.aspx";

    /**
     *发送短信的接口
     *
     * @param int      $mobile 手机号
     * @param String $msg     短信内容
     *
     * @return boolean
     */
    public function sendMsg(int $mobile, String $msg) {
        if (empty($mobile) || empty($msg)) {
            return false;
        }
        //对于传递的参数进行过滤
        $message = htmlspecialchars(trim($msg));
        $message = mb_convert_encoding($message, "GB2312", "UTF-8");
        $fields = array(
            'CorpID'=>urlencode($this->uid),
            'Pwd'=>urlencode($this->pwd),
            'Mobile'=>urlencode($mobile),
            'Content'=>urlencode($message),
            'Cell'=>'',
            'SendTime'=>''
        );

        $result = $this -> _postReqExec($fields);
        if ($result >= 0) {
            //发送成功
            return true;
        } else {
            //发送失败
            return false;
        }


    }
    /**
     * 通过CURL与短信平台进行通信
     *
     * @param array $fields 需要传递的数据参数
     *
     * @return int    如果返回值 >= 0 发送成功， <0 发送失败
     */
    private function _postReqExec(Array $fields) {
        $fields_string = "";
        foreach($fields as $key=>$value) {
            $fields_string .= $key.'='.$value.'&';
        }
        rtrim($fields_string,'&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
    /**
     * 获取六位的验证码
     *
     * @return number
     */
    protected function getCode() {
        return rand(100000, 999999);
    }
}
