<?php
namespace Admin\Model;
use Think\Model;
use Think\Model\RelationModel;

/**
 * 这是一级服务表分类
 */
class OrderServiceSonModel extends RelationModel{
    protected $_link = array(
        'main' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name'   => 'OrderServiceMain',
            'foreign_key'  => 'id',
            'mapping_key'  => 'order_main_id',
            //'mapping_fields' => 'member_name,member_contact,member_id,price,logistics_number,coupon_price,price', 
        ),
        'child' => array(
           'mapping_type' => self::HAS_MANY,
           'class_name'   => 'OrderServiceGrandchild',
           'foreign_key'  => 'order_son_id',
           'mapping_key'  => 'id',
           //'mapping_fields' => 'member_name,member_contact,member_id,price,logistics_number,coupon_price,price', 
        ),  
        'orderback' => array(
           'mapping_type' => self::HAS_MANY,
           'class_name'   => 'OrderServiceMain',
           'foreign_key'  => 'id',
           'mapping_key'  => 'order_main_id',
           'mapping_fields' => 'member_name,member_contact,member_id,price,logistics_number,coupon_price,price', 
        ),  
    );
}