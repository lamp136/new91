<?php 
namespace  Admin\Controller;
use Admin\Controller\BaseController;
use Think\Page;
/*
 * 个人中心控制器
 * 
 * @author he qingyu<heqingyu@huigeyuan.com>
 * @date 2016/8/23
 */
class UserCenterController extends BaseController{
    /*
     * 个人帐号信息
     */
    public function personCenter(){
        $id = session('admin_id');
        $data = M('admin')->where('id='.$id)->find();
        //dump($data);die;
        $this->assign('data',$data);
        $this->display();
    }
    /*
     * 更改密码
     */
    public function editPassword(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $action = I('post.action');
        if($action == 'get'){
            $data['id'] = session('admin_id');
            $data['pwd'] = encryptAdmin(I('post.pwd'));
            $res = M('admin')->where($data)->find();
            if(!empty($res)){
                $result['flag'] = 1;
                $result['msg'] = '操作成功！';
            }
        }else if($action == 'post'){
            $data['id'] = session('admin_id');
            $data['pwd'] = encryptAdmin(I('post.newpassword'));
            if(M('admin')->save($data)){
                $result['flag'] = 1;
                $result['msg'] = '操作成功！';
            }
        }
        echo json_encode($result);
    }
    /*
     * 我的任务
     */
    public function myJobs(){
        $this->display();
    }
    
}