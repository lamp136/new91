<?php
namespace Admin\Model;
use Think\Model;
use Think\Model\RelationModel;


class OrderServiceMainModel extends RelationModel{
	protected $_link = array(
        'OrderServiceSon' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'OrderServiceSon',
            'foreign_key' => 'order_main_id',
            'mapping_key' => 'id',
            //'mapping_fields' => 'id',
            //'condition' => 'status = 5',
        ),
        'OrderServiceGrandchild' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'OrderServiceGrandchild',
            'foreign_key' => 'order_main_id',
            'mapping_key' => 'id',
            //'mapping_fields' => 'id',
        )
    );
}