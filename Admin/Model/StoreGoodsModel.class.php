<?php
namespace Admin\Model;
use Think\Model;
use Think\Model\RelationModel;

class StoreGoodsModel extends RelationModel{
	protected $_link = array(
        'Category' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'Category',
            'foreign_key' => 'cid',
            'mapping_key' => 'category_id',
            'mapping_fields' => 'name', 
        ),
    );
}