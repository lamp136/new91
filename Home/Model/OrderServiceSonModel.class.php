<?php
namespace Home\Model;

use Think\Model\RelationModel;
/**
 * OrderServiceSonModel
 *
 * @author Wang Qiang <wangqiang@huigeyuan.com>
 */
class OrderServiceSonModel extends RelationModel
{
	protected $_link = array(
		// 子订单
		'GrandChild' => array(
			'mapping_type' => self::HAS_MANY,
            'class_name' => 'OrderServiceGrandchild',
            'foreign_key' => 'order_son_id',
            'mapping_key' => 'id',
            'mapping_fields' => 'id,province,city,goods_name,number,pay_time,image_url,thumb_url,remark',
            'mapping_order' => 'created_time desc',
		),
	);
}
