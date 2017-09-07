<?php
namespace Admin\Model;

use Think\Model\RelationModel;

class GoodsAttrModel extends RelationModel
{
	protected $_link = array(
		'Goods' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'Goods',
            'foreign_key' => 'id',
            'mapping_key' => 'goods_id',
            'mapping_fields' => 'goods_type', 
        ),
        'Attribute' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'Attribute',
            'foreign_key' => 'id',
            'mapping_key' => 'attr_id',
            'mapping_fields' => 'attr_name', 
        ),
	);
}