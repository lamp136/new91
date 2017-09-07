<?php
namespace Admin\Model;

use Think\Model\RelationModel;

/**
 * 广告模型
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class AdvertisingBannerModel extends RelationModel{
    
    protected $_link = array(
        // 广告位
        'Adpos' => array(
            'mapping_type'   => self::HAS_ONE,
            'class_name'     => 'AdvertisingPosition',
            'foreign_key'    => 'id',
            'mapping_key'    => 'ad_position_id',
            'mapping_fields' => 'position_name', 
        ),

        // 省份
        'Province' => array(
            'mapping_type'   => self::HAS_ONE,
            'class_name'     => 'Region',
            'foreign_key'    => 'region_id',
            'mapping_key'    => 'province_id',
            'mapping_fields' => 'region_name', 
        ),
    );

    protected function _before_insert(&$data, $options) {
        $data['admin_id'] = session('admin_id');
        $data['created_time'] = time();
        $data['start_time'] = $data['start_time']==''?0:strtotime($data['start_time']);
        $data['end_time'] = $data['end_time']==''?0:strtotime($data['end_time']);
        if ($_FILES['image']['error'] == 0 && !empty($_FILES['image']['tmp_name'])) {
            $ret = uploadOne('image', C('AD_IMAGES'),FALSE,FALSE);
            if ($ret['ok'] == 0) {
                $this->error = $ret['error'];
                return FALSE;
            } else {
                $data['banner_url'] = $ret['images'][0];
            }
        }
    }
    
    protected function _before_update(&$data, $options) {
        $data['start_time'] = $data['start_time']==''?0:strtotime($data['start_time']);
        $data['end_time'] = $data['end_time']==''?0:strtotime($data['end_time']);
        $data['admin_id'] = session('admin_id');
        $data['updated_time'] = time();
        if ($_FILES['image']['error'] == 0 && !empty($_FILES['image']['tmp_name'])) {
            $ret = uploadOne('image', C('AD_IMAGES'),FALSE,FALSE);
            if ($ret['ok'] == 0) {
                $this->error = $ret['error'];
                return FALSE;
            } else {
                $data['banner_url'] = $ret['images'][0];
            }
        }
    }
    
}
