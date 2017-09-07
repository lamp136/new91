<?php
namespace Admin\Model;

use Think\Model;

/**
 * Description of AdvertisingPositionModel
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class AdvertisingPositionModel extends Model {

    
    protected function _before_insert(&$data, $options) {
        $data['admin_id'] = session('admin_id');
        $data['created_time'] = date('Y-m-d H:i:s',time());
    }
    
    protected function _before_update(&$data, $options) {
        $data['admin_id'] = session('admin_id');
    }
}
