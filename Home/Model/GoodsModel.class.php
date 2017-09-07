<?php
namespace Home\Model;

use Think\Model\RelationModel;
/**
 * Description of Goodsmodel
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class GoodsModel extends RelationModel{
    
    protected $_link = array(
        'Img' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'GoodsImages',
            'foreign_key' => 'goods_id',
            'mapping_key' => 'id',
            'mapping_fields' => 'image_url',
            'condition' => 'status=1',
        ),
        'Color' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'GoodsAttr',
            'foreign_key' => 'goods_id',
            'mapping_key' => 'id',
            'mapping_fields' => 'attr_value',
            'condition' => 'attr_id=53',
        ),
        'Area' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'GoodsAttr',
            'foreign_key' => 'goods_id',
            'mapping_key' => 'id',
            'mapping_fields' => 'attr_value',
            'condition' => 'attr_id=52',
        ),
        'Material' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'GoodsAttr',
            'foreign_key' => 'goods_id',
            'mapping_key' => 'id',
            'mapping_fields' => 'attr_value',
            'condition' => 'attr_id=50',
        ),
        'Grave' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'GoodsAttr',
            'foreign_key' => 'goods_id',
            'mapping_key' => 'id',
            'mapping_fields' => 'attr_value',
            'condition' => 'attr_id=54',
        ),
    	'WAIGUAN' => array(
       	    'mapping_type' => self::HAS_ONE,
     	    'class_name' => 'GoodsAttr',
     	    'foreign_key' => 'goods_id',
     	    'mapping_key' => 'id',
     	    'mapping_fields' => 'attr_value',
            'condition' => 'attr_id=48',
      	),
    );
}
