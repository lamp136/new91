<?php
namespace Home\Controller;
use Home\Controller\BaseController;

class IntroController extends BaseController
{
    /**
     * 站点地图
     *
     * @return void
     */
    public function sitemap(){
        //$where['__REGION__.state'] = array('neq',C('DELETE_STATUS'));
        $storeDatas = M('Store')->join('__REGION__ on __STORE__.province_id=__REGION__.region_id', 'left')->where('hgy91_store.status > 0 and hgy91_region.state!=-1')->field('store_id,store_name,member_status,province_id,abbreviate,region_name,category_id')->order('member_status desc,hgy91_region.sort asc')->select();
        foreach($storeDatas as $k=>$v){
            $store[$v['abbreviate']][$v['category_id']][] = array('store_id'=>$v['store_id'],'store_name'=>$v['store_name'],'member_status'=>$v['member_status']);
            if(!array_key_exists('region_name', $store[$v['abbreviate']])){
                $store[$v['abbreviate']]['region_name'] = $v['region_name'];
            }
            if(!array_key_exists('abbreviate', $store[$v['abbreviate']])){
                $store[$v['abbreviate']]['abbreviate'] = $v['abbreviate'];
            }
        }
        $storeMember = getStoreMember(false,'yh');
        $this->storeMember = $storeMember;
        $this->store = $store;
        $this->display();
    }

    public function links() {
        $this->display();
    }

    /**
     * 陵园合作申请
     * array(
     *     'status' => true|false         //flag
     *     'msg'    => '成功|失败的信息',
     *     'data' => array(
     *
     *     )
     * )
     *
     * @return array
     */
    public function collaborate(){
        $cemetery_name = I("post.name");
        $cemetery_linkman = I("post.linkman");
        $cemetery_mobile = I("post.mobile");
        $returnInfo = array(
        	'status' =>false,
        	'msg' =>''
        );
       
        //验证IP
        $ip = get_client_ip(1);
        $collaborate = M("collaborate");
        //获取当前日期并生成时间戳
        $date = date("Y-m-d").' 00:00:00';
        $time = strtotime($date);
        //查询相同IP当天预约次数并进行判断
        $res=$collaborate->where("ip=".$ip." and created_time>".$time)->count();
        if($res >= C('BOOK_EVERY_IP_NUM')){
             $returnInfo['msg']='今天预约次过多!';
        }else{
            //封装数据
            $data['ip'] = $ip;
            $data['cemetery'] = $cemetery_name;
            $data['name'] = $cemetery_linkman;
            $data['mobile'] = $cemetery_mobile;
            $data['created_time']=$data['updated_time']=time();
                 //获取收件人邮箱
                $where['type'] = array_search('陵园合作申请',C('EMAIL_MSG'));
                $emailData = M('EmailSheet')->field('email_address')->where($where)->select();
                if(!empty($emailData)){
                    $emailAdd = array();
                    foreach($emailData as $val){
                        $emailAdd[] = $val['email_address']; 
                    }
                    //发送邮件
                    $content = '陵园联系人：'.$data['name'].' 陵园手机号：'.$data['mobile'].' 陵园名称：'.$data['cemetery'].' 请及时联系！本邮件系统自动发送请忽回复！';
                    if(sendMail($emailAdd,'陵园合作申请',$content)){
                        $status = 1;
                        $send_time = date('Y-m-d H:i:s');
                    }else{
                        $status = 0;
                    }
                    //插入数据库
                    foreach($emailData as $val){
                        $addData[] = array('type'=>$where['type'],'email_address'=>$val['email_address'],'title'=>'陵园合作申请','content'=>$content,'status'=>$status,'send_time'=>$send_time,'creat_time'=>date('Y-m-d H:i:s'));
                    }
                    M('EmailLog')->addAll($addData);
                }
            //写入数据并判断
            if($collaborate->data($data)->add()){
                $returnInfo['status'] = true;
	        $returnInfo['msg'] = '亲爱的 '.$cemetery_linkman.' 你好,请稍等,我们的客服人员会联系你！';
            }else{
                $returnInfo['msg'] = '申请失败！';
            }
        }
        echo json_encode($returnInfo);
    }
}