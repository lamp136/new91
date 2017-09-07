<?php
namespace Admin\Model;

use Think\Model\RelationModel;

class StoreProfilesDetailModel extends RelationModel
{
	protected $_link = array(
		'StoreProfiles' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'StoreProfiles',
            'foreign_key' => 'id',
            'mapping_key' => 'profiles_id',
            'mapping_fields' => 'province_id,city_id',
        ),
	);
}