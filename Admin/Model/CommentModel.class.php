<?php
namespace Admin\Model;

use Think\Model\RelationModel;

/**
 * Description of CommentModel
 *
 * @author Wang Qiang <Wangqiang@huigeyuan.com>
 * @version 1.0
 */
class CommentModel extends RelationModel{
	protected $_link = array(
		// 陵园
		'Store' => array(
			'mapping_type'   => self::HAS_ONE,
			'class_name'     => 'Store',
			'foreign_key'    => 'store_id',
			'mapping_key'    => 'store_id',
			'mapping_fields' => 'store_name',
		),
		// 会员
		'Member' => array(
			'mapping_type'   => self::HAS_ONE,
			'class_name'     => 'Member',
			'foreign_key'    => 'id',
			'mapping_key'    => 'member_id',
			'mapping_fields' => 'name,mobile',
		),
		// 商品
		'Goods' => array(
			'mapping_type'   => self::HAS_ONE,
			'class_name'     => 'Goods',
			'foreign_key'    => 'goods_id',
			'mapping_key'    => 'goods_id',
			'mapping_fields' => 'goods_name',
		),
		// 订单
		'Order' => array(
			'mapping_type'   => self::HAS_ONE,
			'class_name'     => 'Orders',
			'foreign_key'    => 'id',
			'mapping_key'    => 'order_id',
			'mapping_fields' => 'store_name',
		),
		// 用户
		'Admin' => array(
			'mapping_type'   => self::HAS_ONE,
			'class_name'     => 'Admin',
			'foreign_key'    => 'id',
			'mapping_key'    => 'admin_id',
			'mapping_fields' => 'email',
		),
	);
}
?>