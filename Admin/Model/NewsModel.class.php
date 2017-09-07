<?php
namespace Admin\Model;
use Think\Model;
use Think\Model\RelationModel;

class NewsModel extends RelationModel{
	protected $_link = array(
        'name' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'category',
            'foreign_key' => 'cid',
            'mapping_key' => 'category_id',
            'mapping_fields' => 'name', 
        ),
        'nickName' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'admin',
            'foreign_key' => 'id',
            'mapping_key' => 'admin_id',
            'mapping_fields' => 'nickname', 
        ),  
    );
}