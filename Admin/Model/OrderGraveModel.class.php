<?php
namespace Admin\Model;
use Think\Model;
use Think\Model\RelationModel;


/**
 * Description of OrdersModel
 *
 * @author wangdong
 * @version 1.1
 */
class OrderGraveModel extends RelationModel {

    protected $_link = array(
        'Member' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'Member',
            'foreign_key' => 'id',
            'mapping_key' => 'member_id',
            'mapping_fields' => 'bank,bank_account,bank_member,bank_type', 
        ),
        //客户联系短信
        'Custom_msg' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'OrdersMsg',
            'foreign_key' => 'order_id',
            'mapping_key' => 'id',
            'mapping_fields' => 'name,msg', 
            'condition' =>'classify=1 and status>=0',
        ),
        
        //商家陵园联系短信
        'Store_msg' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'OrdersMsg',
            'foreign_key' => 'order_id',
            'mapping_key' => 'id',
            'mapping_fields' => 'name,msg', 
            'condition' =>'classify=2 and status>=0',
        ),
        //查找地区name
        'province_name' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'Region',
            'foreign_key' => 'region_id',
            'mapping_key' => 'province_id',
            'mapping_fields' => 'region_name', 
        ),

        //查找地区用于统计各省购墓订单收支情况
        'Analysis_province_name' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'Region',
            'foreign_key' => 'region_id',
            'mapping_key' => 'province_id',
            'mapping_fields' => 'region_name', 
        ),
        //查找陵园联系人
        'store_contact' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'storeContact',
            'foreign_key' => 'store_id',
            'mapping_key' => 'store_id',
            'mapping_fields' => 'contact_name,mobile', 
        ),
        //查找退单票据
        'back_bill' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'OrderGraveBill',
            'foreign_key' => 'order_grave_id',
            'mapping_key' => 'id',
            'condition' =>'type = 3',
            'mapping_fields' => 'bill_image',
        ),
       
    );
}
