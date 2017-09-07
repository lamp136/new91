<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;
/**
 * email管理
 * @author heqingyu;
 * @date 2016/11/2 10/20/00;
 * @version 1.0
 */
class EmailController extends BaseController{
    /*
     * email列表
     */
    public function emailList(){
       /* $list = M('EmailSheet')->field('type')->select();
        $dataList = array();
        $email = C('EMAIL_MSG');
        foreach($list as $v){
            $dataList[$v['type']] = $email[$v['type']];
        }*/
        $this->assign('dataList',C('EMAIL_MSG'));
        $this->display();
    }
    /*
     * 查看收件人员
     */
    public function viewList(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $type = I('type');
        if(!empty($type)){
            $data = M('EmailSheet')->field('id,name,email_address,remark')->where('type ='.$type)->select();
            if(empty($data)){
                $result = array('flag'=>2,'msg'=>'暂无人员信息');
            }else{
                $result = array('flag'=>1,'data'=>$data);
            }
        }
        echo json_encode($result);
    }
    /*
     * 删除Email
     * return string(json);
     */
    public function delEmail(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $id = I('id');
        if(!empty($id)){
            $res = M('EmailSheet')->where('id='.$id)->delete();
            if($res){
                $result = array('flag'=>1,'msg'=>'操作成功！');
            }
        }
        echo json_encode($result);
    }
    /*
     * 添加收件人员
     * return string(void);
     */
    public function addperson(){
        $result = array('flag'=>0,'msg'=>'添加失败！');
        $data = I('post.');
        $emailSheetModel = M('EmailSheet');
        $countName = count($data['name']);
        $countEmailAddress = count($data['email_address']);
        if($countName == $countEmailAddress){
            $dataArray = array();
            $condition = array();
            for($i = 0;$i<$countName;$i++){
                $dataArray[] = array('type'=>$data['type'],'name'=>$data['name'][$i],'email_address'=>$data['email_address'][$i],'creat_time'=>date('Y-m-d H:i:s')); 
                $condition[] = $data['email_address'][$i];
            }
            $where['email_address'] = array('in',$condition);
            $where['type'] = $data['type'];
            $find = $emailSheetModel->where($where)->count();
            if($find>0){
                $result = array('flag'=>0,'msg'=>'请检查用户是否已存在！');
            }else{
                if($emailSheetModel->addAll($dataArray)){
                    $result = array('flag'=>1,'msg'=>'成功添加！');
                }
            }
        }
        echo json_encode($result);
    }
     /*
     * 乐融留言邮件列表
     * return void;
     */
    public function lrMessageEmailList(){
        $condition = array_search('91乐融留言',C('EMAIL_MSG'));
        $this->_sendList($condition);
    }
     /*
     * 陵园合作申请邮件列表
     * return void;
     */
    public function cemHezuoEmailList(){
        $condition = array_search('陵园合作申请',C('EMAIL_MSG'));
        $this->_sendList($condition);
    }
    /*
     * 预约看墓邮件列表
     * return void;
     */
    public function appiontEmailList(){
        $condition = array_search('预约看墓',C('EMAIL_MSG'));
        $this->_sendList($condition);
    }
    /*
     * 公共邮件列表
     */
    public function _sendList($condition){
        if(!empty($condition)){
            $where['type'] = $condition;
        }
        $emailLogModel = M('EmailLog');
        $count = $emailLogModel->where($where)->count(); 
        $Page = new \Think\Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        
        $list = $emailLogModel->order('id DESC')->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('title',C('EMAIL_MSG')[$condition]);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display('sendList');
    }
    
    
    
    
    /*
     * 发送邮件
     * return string(json);
     */
    public function sendMail(){
        $result = array('flag'=>0,'msg'=>'发送失败！');
        $id = I('id');
        if(!empty($id)){
            $emailLogModel = M('EmailLog');
            $data = $emailLogModel->field('email_address,title,content')->find($id);
            if(!empty($data)){
                if(sendMail($data['email_address'],$data['title'],$data['content'])){
                    $updata['status'] = 1;
                    $updata['send_time'] = date('Y-m-d H:i:s');
                    if($emailLogModel->where('id ='.$id)->save($updata)){
                        $result = array('flag'=>1,'msg'=>'成功发送！');
                    }
                }
            }
        }
        echo json_encode($result);
    }
}