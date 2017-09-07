<?php
namespace Common\Extend;
//设置默认时区为北京时间
date_default_timezone_set('PRC');
/**
 * 使用redis
 *
 * @author hgy
 *
 */
class RedisSearch
{
        protected $link; //redis连接
        
	/**
	 * 初始化服务，默认有值
	 *
	 * @param string $host 服务器地址
	 * @param string $port 端口号
	 */
	public function __construct($host='', $port='') {
            $redis_host = $host ?$host : '127.0.0.1';
            $redis_port = $port ?$port : '6379';
            $this->link = new \Redis();
            $this->link->pconnect($redis_host,$redis_port); 
	}
	/**
	 * 精确获取陵园名称
	 *
	 * @param string $keyname redis中存储的下标值
	 *
	 * @return string
	 */
	public function getCemeteryname(String $keyname) {
            $result = $this->link->get($keyname);
           /* if(!empty($get_info)){
                $result[] = $get_info;
            }
            $hgetall_info = $this->link->hgetall($keyname);
            if(!empty($hgetall_info)){
                $result[] = $hgetall_info;
            }*/
            return $result;
	}
	/**
	 * 根据输入的词获取陵园名称列表(模糊查询)
	 *
	 * @param string $input 根据输入的词获取对应的数据信息
	 *
	 * @return array
	 */
	public function getCemeterynames(String $input) {
            $info = $this->link->keys('*'.$input."*");
            for($i=0;$i<count($info);$i++){
                $result[] = getCemeteryname($input);
            }
            return $result;
	}
	/**
	 * 把陵园名称添加到对应的数据中
	 * TODO 此方法中 key 可以根据name制定规则,不需要传递 key根据实际情况
	 *
	 * @param String $key          下标
	 * @param string $cemeteryname 数据名称
	 *
	 * @return void | bool
	 */
	public function addCemeteryname(string $key, string $name) {
            /*当$name为数组时认为HASH类型，当为字符串时为字符串型*/
            if(is_array($name)){
                $res = $this->link->hmset($key,$name);
            }else{
                $res = $this->link->set($key,$name);
            }
            return $res;
	}
	/**
	 * 删除对应的数据
	 * TODO 此方法中 key 可以根据name制定规则,不需要传递 key根据实际情况
	 *
	 * @param string $key  下标
	 * @param string $name 数据名称
	 */
	public function delCemeteryname(string $key, string $name) {
            /*如果只传$key为字符串型删除用del。当$key和$name都传过来为hash类型*/
            if(empty($name)){
                $this->link->del($key);
            }else{
                $this->link->hdel($key,$name);
            }
	}
	/**
	 * 清空数据
	 *
	 * return void
	 */
	public function cleanall() {
            $res = $this->link->keys('*');
            $this->link->del($res);
	}
}