<?php

namespace Home\Controller;

use Think\Controller;

class WeixinappController extends Controller {
    
    /**
     * 入口文件
     */
    public function index() {
       // $this->valid();
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        if (!empty($postStr)) {
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
              the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $time = time();
            if ('subscribe' == $postObj->Event) {
                $this->subscribe($fromUsername, $toUsername, $time);
            }
        } else {
            echo "";
        }
    }
    
    /**
     * 关注的回复信息
     * @param type $fromUsername
     * @param type $toUsername
     * @param type $time
     */
    public function subscribe($fromUsername,$toUsername,$time) {
        $subscribe = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                    </xml>";
        $msgType = "text";
        $contentStr = "您好，欢迎关注91搜墓网微信公众平台。";
        $resultStr = sprintf($subscribe, $fromUsername, $toUsername, $time, $msgType, $contentStr);
        echo $resultStr;die;
    }
    

    /**
     * 接口配置验证
     */
    public function valid() {
        $echoStr = $_GET["echostr"];
        //valid signature , option
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature() {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = C('TOKEN');
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

}
