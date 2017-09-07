<?php
namespace Admin\Model;
use Think\Model;
use Think\Model\RelationModel;

class AttributeModel extends RelationModel{
	protected $_link = array(
        'Category' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'category',
            'foreign_key' => 'cid',
            'mapping_key' => 'category_id',
            'mapping_fields' => 'name', 
        ),
    );
}