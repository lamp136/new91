<?php
namespace Admin\Model;

use Think\Model;

/**
 * Description of PrivilegeModel
 *
 * @author hqy
 * @version 1.0
 * @date 2016/7/8
 */
class PrivilegeModel extends Model{
    
    
    /**
     * 将查出来的结果重新排序.
     * 
     * @param array $data
     * @param int $pid 
     * @return array
     */
    public function getPrivilegeTree($data, $pid = 0){
        static $result = array();
        foreach($data as $v){
            if($v['pid']==$pid){
                $result[] = $v;
                $this->getPrivilegeTree($data,$v['id']);//递归调用
            }
        }
        return $result;
    }
    
    /**
     * 获取某个菜单下所有的权限,只取出菜单的id数组集合
     * @staticvar array $result
     * @param type $pid
     * @return array
     */
    public function getChildPrivilege($pid = array()){
        static $result = array();
        $where['pid'] = array('in',$pid);
        $where['status'] = C('NORMAL_STATUS');
        $data = $this->where($where)->select();
        foreach($data as $v){
            $pids[] = $v['id'];
            $result[] = $v['id'];
        }
        if(!empty($pids)){
            $this->getChildPrivilege($pids);    //递归调用
        }
        return $result;
    }
    
    /**
     * 递归调用，将权限节点，子节点放在父节点的一个数组中
     * @staticvar array $result 存放排序后的数组
     * @param array $data
     * @param int $pid
     * @return array
     */
    public function getTree($data,$pid=0){
        $result = array();
        foreach ($data as $v){
            //找当前分类的子分类，默认从顶级开始找
            if ($v['pid'] == $pid){
                //找到了，继续以找到的分类为当前分类，找它的后代节点,并将结果放到当前元素的下标为child的元素中
                $v['child'] = $this->getTree($data,$v['id']);
                //然后将$v 保存到$list中
                $result[] = $v;
            }
        }
        return $result;
    }
    
    /**
     * 获取用户的权限节点
     * @param int $userid
     * @return array
     */
    public function getUsetPrivilege($userid){
        //获取用户的职位
        $data = array('name'=>array(),'ids'=>array());
        $priIdsData = array();
        $privileges = array();
        $roleUser = M('role_user')->where('user_id='.$userid)->select();
        if(!empty($roleUser)){
           foreach ($roleUser as $roleUserV){
               $role_Job[] = $roleUserV['role_job_id'];
           }
           $map['status'] = C('NORMAL_STATUS');
           $map['id'] = array('in',$role_Job);
           $roleData = M('role')->where($map)->select();
           //dump($roleData);die;
           if(!empty($roleData)){
               foreach ($roleData as $key => $value) {
                   if($value['privilege']!=''){
                        $priIds = explode(',', $value['privilege']);
                        $priIdsData = array_merge($priIdsData,$priIds);
                   }
                    //为商务部门的跟踪权限设定seeionsession
                    if(in_array($value['id'],C('BUSINESS_PRIVILEGE'))){
                        session('businessPrivilege',true);
                    }
               }
               $priIdsData = array_unique($priIdsData);
               //dump($priIdsData);die;
               if(!empty($priIdsData)){
                    $data['ids'] = $priIdsData;
                    $where['status'] = C('NORMAL_STATUS');
                    $where['id'] = array('in',$priIdsData);
                    $privileges = M('Privilege')->where($where)->select();
                    //dump($privileges);die;
                }
                if(!empty($privileges)){
                    foreach ($privileges as $prival){
                        $data['name'][] = $prival['name'];
                    }
                }
           }
        }
        return $data;
    }
    
    
    /**
     * 获取顶级菜单
     */
    public function gettopmenu($id,$level=0){
        $topmemnid = '';
        $result = $this->field('id,pid,level')->where("id=".$id)->find();
        if(!empty($result)){
            if($result['level']!=$level){
                return $this->gettopmenu($result['pid'],$level);
            }
            $topmemnid = $result['id'];
            
        }
        return $topmemnid;
    }
    
    /**
     * 递归调用，将权限节点，子节点放在父节点的一个数组中,只取出用户的权限
     * @staticvar array $result 存放排序后的数组
     * @param array $data
     * @param int $pid
     * @return array
     */
    public function getMenuTree($data,$pid=0){
        $result = array();
        foreach ($data as $v){
            //找当前分类的子分类，默认从顶级开始找
            if ($v['pid'] == $pid && in_array($v['id'], session('privilegeIdsData'))){
                
                //找到了，继续以找到的分类为当前分类，找它的后代节点,并将结果放到当前元素的下标为child的元素中
                $v['child'] = $this->getMenuTree($data,$v['id']);
                //然后将$v 保存到$list中
                $result[] = $v;
            }
            continue;
        }
        return $result;
    }
    
}
