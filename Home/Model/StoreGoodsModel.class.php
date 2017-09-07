<?php
namespace Home\Model;
use Think\Model;
use Think\Model\RelationModel;

class StoreGoodsModel extends RelationModel{
	protected $_link = array(
        'Single' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'singleProduct',
            'foreign_key' => 'package_skuid',
            'mapping_key' => 'skuid',
            'mapping_fields' => 'service_goods_name,number,skuid', 
        ),

        'IMAGE' => array(
        	'mapping_type' => self::HAS_MANY,
            'class_name' => 'storeGoodsImage',
            'foreign_key' => 'store_goods_id',
            'mapping_key' => 'id',
            'condition'  => 'status=1',
        ),
    );
}