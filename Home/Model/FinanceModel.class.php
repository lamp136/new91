<?php 
namespace Home\Model;

use Think\Model\RelationModel;

/**
 * 融资信息
 */
class FinanceModel extends RelationModel{

    protected $_link = array(
        'Img' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'financeImage',
            'foreign_key' => 'finance_id',
            'mapping_key' => 'id',
            'condition' =>'type=1 and recommends=1',
        ),

        'Imgs' => array(
        	'mapping_type' => self::HAS_MANY,
            'class_name' => 'financeImage',
            'foreign_key' => 'finance_id',
            'mapping_key' => 'id',
            'mapping_fields' => 'type,title,url,pic_url,recommends',
            
        ),
    );
}
