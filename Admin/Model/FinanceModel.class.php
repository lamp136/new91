<?php
namespace Admin\Model;
use Think\Model;
use Think\Model\RelationModel;

class FinanceModel extends RelationModel{
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
        'Image' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'FinanceImage',
            'foreign_key' => 'finance_id',
            'mapping_key' => 'id',
            'mapping_fields' => 'title,url,pic_url,type', 
        ),
    );
}