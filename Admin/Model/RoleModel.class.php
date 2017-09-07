<?php
namespace Admin\Model;
use Think\Model;

/**
 * Description of RoleModel
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class RoleModel extends Model{

    /**
     * 获取role中所有的正常的数据
     * @param int $type
     * @return array
     */
    public function getData($type=''){
        if($type===0 || $type===1){
            $map['type'] = $type;
        }
        //$map['status'] = C('NORMAL_STATUS');
        return $this->where($map)->order('sort DESC')->select();
    }

    /**
     * 将role表输出成树状结构
     *
     * @param array $roleDatas
     * @param int $pid
     * @return array
     */
    static function getAllRoleData($roleDatas,$pid=0) {
        static $datas;
        if ($roleDatas != NULL || !empty($roleDatas)) {
            foreach ($roleDatas as $key =>$roleData) {
                if($roleData['pid']==$pid){
                    $datas[] = $roleData;
                    self::getAllRoleData($roleDatas,$roleData['id']);
                }
            }
        }

      return $datas;
    }
}
