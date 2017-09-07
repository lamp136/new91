<?php
namespace Admin\Model;

use Think\Model\RelationModel;

/**
 * Description of SeoModel
 *
 * @author heqingyu
 * @version 1.0
 */
class SeoModel extends RelationModel{
    
    protected $_link = array(
        'Province' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'Region',
            'foreign_key' => 'region_id',
            'mapping_key' => 'province_id',
            'mapping_fields' => 'region_name', 
        ),
        'Category' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'Category',
            'foreign_key' => 'cid',
            'mapping_key' => 'category_id',
            'mapping_fields' => 'name', 
        ),
    );

    
    /**
     * 插入前的数据处理
     * @param array $data
     * @param type $options
     */
    protected function _before_insert(&$data, $options) {
        $data['admin_id'] = session('admin_id');
        $data['created_time'] = date('Y-m-d H:i:s');
        $data['updated_time'] = $data['created_time'];
    }
    
    /**
     * 修改前的数据处理
     * @param type $data
     * @param type $options
     */
    protected function _before_update(&$data, $options) {
        $data['admin_id'] = session('admin_id');
        $data['updated_time'] = date('Y-m-d H:i:s');
    }
}
