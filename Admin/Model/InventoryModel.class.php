<?php
namespace Admin\Model;

use Think\Model\RelationModel;
class InventoryModel extends RelationModel
{
    protected $_link = array(
        'Admin' =>array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'Admin',
            'foreign_key' => 'id',
            'mapping_key' => 'admin_id',
            'mapping_fields' => 'nickname', 
        )
    );
}