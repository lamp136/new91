<?php
namespace Home\Model;

use Think\Model\RelationModel;
/**
 * Description of CollectModel
 *
 * @author He qingyu <heqingyu@huigeyuan.com>
 * @version 1.0
 */
class CollectModel extends RelationModel{
    protected $_link = array(
        'Store' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'Store',
            'foreign_key' => 'store_id',
            'mapping_key' => 'store_id',
            'mapping_fields' => 'store_name,store_banner',
        ),
    );
    
}
