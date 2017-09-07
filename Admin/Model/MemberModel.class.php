<?php
namespace Admin\Model;

use Think\Model\RelationModel;
class MemberModel extends RelationModel
{
	protected $_link = array(
		'MebmerBank' =>array(
			'mapping_type' => self::HAS_MANY,
			'class_name' => 'MemberBank',
			'foreign_key' =>'member_id',
		),
		'Relation' =>array(
		    'mapping_type' => self::HAS_ONE,
			'class_name' => 'OthersMemberRelation',
			'foreign_key' =>'member_id',
            'mapping_key' => 'id',
            'mapping_fields' => 'member_num_bysender,last_captial_num,capital_settlement_time',

		),
		
	);
}