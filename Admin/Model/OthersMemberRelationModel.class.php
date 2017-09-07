<?php
namespace Admin\Model;
use Think\Model;
use Think\Model\RelationModel;
class OthersMemberRelationModel extends RelationModel
{
	protected $_link = array(
		
		'Info' =>array(
		    'mapping_type' => self::HAS_ONE,
			'class_name' => 'Member',
			'foreign_key' =>'id',
            'mapping_key' => 'member_id',
            'mapping_fields' => 'name',

		)
		
	);
}