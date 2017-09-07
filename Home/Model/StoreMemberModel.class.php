<?php
namespace Home\Model;

use Think\Model;
/**
 * Description of StoreMemberModel
 *
 * @author Wang Qiang <wangqiang@huigeyuan.com>
 * @version 1.0
 */
class StoreMemberModel extends Model{

    /**
     * 验证商家登陆的账号密码是否正确
     * @param string $storeLoginName    //登陆账号
     * @param string $storeLoginPwd     //密码
     * @return boolean                  //登陆成功返回true,否则返回false
     */
    public function checkLogin($storeLoginName,$storeLoginPwd){
        $password = encryptAdmin($storeLoginPwd);
        $where['store_login_name'] = $storeLoginName;
        $where['store_login_pwd'] = $password;
        $where['status'] = C('NORMAL_STATUS');
        $data = $this->where($where)->find();
        if(!empty($data)){
            $level = 2;
            if($data['admin_id'] != 0){
                $level = 1;
            }
            session('storecenter.level',$level);
            if(!empty($data['pid']) && $data['pid'] != 0){
                session('storecenter.pid',$data['pid']);
                // 如果属于集团账号取出所有权限节点
                $privileges = M('StoreCenterPrivilege')->field('id,name')->select();
            }else{
                $prIdTrees = explode(',',$data['privilege']);
                if(!empty($prIdTrees)){
                    $where['id'] = array('in',$prIdTrees);
                    $privileges = M('StoreCenterPrivilege')->where($where)->field('id,name')->select();
                }
            }
            if($privileges){
                foreach ($privileges as $val) {
                    $prIds[] = $val['id'];
                    // 权限名称
                    $prName[] = $val['name'];
                }
                session('storecenter.prIds',$prIds);
                session('storecenter.prName',$prName);
            }
            session('storecenter.id',$data['id']);
            session('storecenter.store_name',$data['store_name']);
            session('storecenter.store_id',$data['store_id']);
            session('storecenter.store_login_name',$data['store_login_name']);
            return TRUE;
        }else{
            return FALSE;
        }
    }
}
