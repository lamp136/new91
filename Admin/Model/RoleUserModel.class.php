<?php
namespace Admin\Model;
use Think\Model\RelationModel;

/**
 * Description of PositionModel
 *
 * @author hqy
 * @version 1.0
 */
class RoleUserModel extends RelationModel{

    protected $_link = array(
        'Admin' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'Admin',
            'foreign_key' => 'id',
            //'condition' => 'status=1',
            'mapping_key' => 'user_id',
            'mapping_fields' => 'nickname,email,status', 
        ),
    );
}
