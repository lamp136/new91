<?php
namespace Home\Model;

use Think\Model\RelationModel;
/**
 * Description of OrdersModel
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class OrderGraveModel extends RelationModel{
    protected $_link = array(
        'Province' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'Region',
            'foreign_key' => 'region_id',
            'mapping_key' => 'province_id',
            'mapping_fields' => 'region_name',
        ),
        //订单联系人的关联
        'CustomMsg' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'OrderGraveMsg',
            'foreign_key' => 'order_id',
            'mapping_key' => 'id',
            'mapping_fields' => 'name,mobile,msg',
            'condition' => 'status=1 and classify=1',
            'mapping_order' => 'send_time desc',
        ),
        'StoreMsg' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'OrderGraveMsg',
            'foreign_key' => 'order_id',
            'mapping_key' => 'id',
            'mapping_fields' => 'msg,name,mobile',
            'condition' => 'status=1 and classify=2',
            'mapping_order' => 'send_time desc',
        ),
        
    );

    /**
     * 获取最新预约信息
     * @param type $num     条数
     *
     * @return array
     */
    public function getLastestOrders($num=8){
        $orders = $this->where('status!='.C('ORDER_STATUS.FAIL'))->field('store_id,store_name,mobile,appoint_time,province_id')->order('created_time desc')->limit($num)->select();
        if(!empty($orders)){
            foreach ($orders as $v){
                $provinces[] = $v['province_id'];
            }
            $map['region_id'] = array('in',$provinces);
            $region = M('Region')->where($map)->getField('region_id,region_name,abbreviate');
            foreach ($orders as $k=>$v){
                $orders[$k]['province'] = $region[$v['province_id']]['region_name'];
                $orders[$k]['abbreviate'] = $region[$v['province_id']]['abbreviate'];
            }
        }
        return $orders;
    }
}
