<?php
namespace Admin\Model;

use Think\Model\RelationModel;

/**
 * Description of StoreProfilesModel
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class StoreProfilesModel extends RelationModel{

    protected $_link = array(
        'StoreProfilesDetail' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'StoreProfilesDetail',
            'foreign_key' => 'profiles_id',
            'mapping_key' => 'id',
            'condition' => 'status = 1',
        ),
        'StoreProfilesRenew' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'StoreProfilesRenew',
            'foreign_key' => 'store_profiles_id',
            'mapping_key' => 'id',
            'mapping_fields' => 'id,store_profiles_detail_id,renew_start_time,renew_end_time',
        ),
         'Province' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'region',
            'foreign_key' => 'region_id',
            'mapping_key' => 'province_id',
            'mapping_fields' => 'region_name',
        ),
        'City' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'region',
            'foreign_key' => 'region_id',
            'mapping_key' => 'city_id',
            'mapping_fields' => 'region_name',
        ),
        'DelStoreProtilesDetail' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'StoreProfilesDetail',
            'foreign_key' => 'profiles_id',
            'mapping_key' => 'id',
            'mapping_fields' => 'id,profile_name,category_id,return_amount,settlement_time,contact_man,telephone,mobile,member_status,start_time,end_time,status,remarks',
            'condition' => 'status = -1',
        ),
    );

}
