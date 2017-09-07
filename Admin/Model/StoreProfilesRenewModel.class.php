<?php
namespace Admin\Model;

use Think\Model;

/**
 * Description of StoreProfilesRenewModel
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class StoreProfilesRenewModel extends Model{

    protected function _before_insert(&$data, $options) {
        $store_profiles_detail_id = $data['store_profiles_detail_id'];
        $storeProfilesModel = D('StoreProfilesDetail');
        $storeProfilesInfo = $storeProfilesModel->field('end_time')->find($store_profiles_detail_id);
        $data['up_end_time'] = $storeProfilesInfo['end_time'];
        if(I('post.renew_start_time')==''){
            if(!empty($storeProfilesInfo)){
                $data['renew_start_time'] = $storeProfilesInfo['end_time'];
            }else{
                return false;
            }
        }else{
            $data['renew_start_time'] = strtotime(I('post.renew_start_time'));
        }
        $data['renew_end_time'] = strtotime(I('post.renew_end_time'));
        $data['admin_id'] = session('admin_id');
        $data['created_time'] = time();
    }
}
