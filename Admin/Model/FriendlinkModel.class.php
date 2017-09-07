<?php
namespace Admin\Model;

use Think\Model\RelationModel;

/**
 * Description of FriendlinkModel
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class FriendlinkModel extends RelationModel{

    protected $_link = array(
        'Province' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'Region',
            'foreign_key' => 'region_id',
            'mapping_key' => 'province_id',
            'mapping_fields' => 'region_name', 
        ),
        'City' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'Region',
            'foreign_key' => 'region_id',
            'mapping_key' => 'city_id',
            'mapping_fields' => 'region_name', 
        ),
    );
}
