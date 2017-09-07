<?php
namespace Admin\Model;
use Think\Model;
use Think\Model\RelationModel;
class StoreModel extends RelationModel
{
    /**
     * 获取陵园的ID,名称,省份，市区，陵园状态、是否是会员
     *
     * @return array
     */
    public function getCemeteryName($store_id=null) {
        $fields = 'store_id, store_name, province_id, city_id, status, member_status';
        if($store_id){
            $where['store_id'] = $store_id;
            $datas = $this->field($fields)->where($where)->find();
        }else{
            $datas = $this->field($fields)->where(array('category_id'=>37))-> select();
        }

        return $datas;
    }

    protected $_link = array(
        // 省份
        'Province' => array(
            'mapping_type'   => self::HAS_ONE,
            'class_name'     => 'Region',
            'foreign_key'    => 'region_id',
            'mapping_key'    => 'province_id',
            'mapping_fields' => 'region_name',
        ),

        // 市区
        'City' => array(
            'mapping_type'   => self::HAS_ONE,
            'class_name'     => 'Region',
            'foreign_key'    => 'region_id',
            'mapping_key'    => 'city_id',
            'mapping_fields' => 'region_name',
        ),
        'StoreProtilesDetail' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'StoreProfilesDetail',
            'foreign_key' => 'id',
            'mapping_key' => 'store_profiles_id',
            'mapping_fields' => 'return_amount,category_id',
        ),
          //查找返现比例
        'return_amount' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'storeProfiles',
            'foreign_key' => 'id',
            'mapping_key' => 'store_profiles_id',
            'mapping_fields' => 'return_amount', 
        ),
    );
}