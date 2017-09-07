<?php
namespace Admin\Model;
use Think\Model;
use Think\Model\RelationModel;

class StorageModel extends RelationModel{
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