<?php
namespace Home\Model;

use Think\Model\RelationModel;
/**
 * Description of StoreModel
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class StoreModel extends RelationModel{
    protected $_link = array(
        'StoreImg' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'StoreImages',
            'foreign_key' => 'store_id',
            'mapping_key' => 'store_id',
            'mapping_fields' => 'thumb_image_url, title, image_url',
            'condition' => 'album_id=1 and set_photo_album_status=1 and state=1',
        ),
        'StoreContact' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'StoreContact',
            'foreign_key' => 'store_id',
            'mapping_key' => 'store_id',
            'mapping_fields' => 'tel',
            'condition' => 'status=1',
        )
    );

    /**
     * 通过商家的ID获取商家的数据信息
     *
     * @param array $ids
     */
    public function getStoreByIds(Array $ids, $categoryId='') {
        if (empty($ids)) {
            return array();
        }

        if (!empty($categoryId)) {
        	$where['category_id'] = C('CATEGORY_CEMETERY_ID');
            if ($categoryId == C('CATEGORY_FUNERAL_ID')) {
                $where['category_id'] = C('CATEGORY_FUNERAL_ID');
            }
        }
        $where['store_id'] = array('in', $ids);
        $where['status'] = array('neq', C('DELETE_STATUS'));
        $fields = '`store_id`, `store_name`,`store_banner`, `category_id`, `summary`, `province_id`, `city_id`, `member_status`, `address`, `status`, `review_price`, `review_traffic`, `review_ambient`, `review_service`, `feature`, `min_price`';
        $order = 'member_status DESC';
        $store = $this->field($fields)->where($where)->order($order) ->select();

        return $store;
    }

    /**
     * 通过商家ID集合获取每一个商家的一个联系方式
     *
     * @param array $storeIds 商家ID的数据集合
     *
     * @return array
     */
    public function getContactBySids(Array $storeIds) {
        if (empty($storeIds)) {
            return array();
        }
        $storeContact = M('StoreContact');
        $where['store_id'] = array('in', $storeIds);
        $where['status'] = C('NORMAL_STATUS');

        return $storeContact -> where($where)->getField('store_id, tel');
    }

    /**
     * 获取对应列表的首页数据的总数
     *
     * @param number $provinceId    省份ID
     * @param Number $pagefirst   分页相关
     * @param Number $pagelist    分页相关
     * @param number $cityId          市区ID
     * @param number $distance    距离
     *
     * @return number
     */
    public function getList($provinceId, $pagefirst, $pagelist, $cityId=0, $distance=0, $categoryId='') {
        if (empty($provinceId)) {
            return array();
        }

        //公里数判断
        $distances = array(
            C('DISTANCE_1_10'),
            C('DISTANCE_10_20'),
            C('DISTANCE_20_30'),
            C('DISTANCE_30_40'),
            C('DISTANCE_40_50'),
            C('DISTANCE_50_80'),
            C('DISTANCE_80')
        );
        if (!empty($distance) && in_array($distance, $distances)) {
            $distanceArr = explode('-', $distance);
            $start = (int)$distanceArr[0];
            $end = (int)$distanceArr[1];
            $where['distance'] = array('BETWEEN', array($start, $end));
        }

        $where['status'] = array('gt', 0);
        if ($provinceId != C('CHINA_NUM')) {
            $where['province_id'] = $provinceId;
        }

        if ($cityId) {
            $where['city_id'] = $cityId;
        }
        $where['category_id'] = C('CATEGORY_CEMETERY_ID');
    	if (!empty($categoryId) && $categoryId == C('CATEGORY_FUNERAL_ID')) {
               $where['category_id'] = C('CATEGORY_FUNERAL_ID');
        }

        $fields = '`store_id`, `store_name`, `store_banner`, `category_id`, `summary`, `province_id`, `city_id`, `member_status`, `status`, `review_price`, `review_traffic`, `review_ambient`, `review_service`, `feature`, `min_price`';
        return $this->field($fields)->where($where)->limit($pagefirst, $pagelist)->order('member_status DESC')->select();
    }

    /**
     * 获取对应列表的首页数据的总数
     *
     * @param Integer $provinceId    省份ID
     * @param number $cityId          市区ID
     * @param number $distance    距离
     *
     * @return number
     */
    public function getTotal($provinceId, $cityId=0, $distance=0, $categoryId='') {
        if (empty($provinceId)) {
            return 0;
        }
        //公里数判断
        $distances = array(
            C('DISTANCE_1_10'),
            C('DISTANCE_10_20'),
            C('DISTANCE_20_30'),
            C('DISTANCE_30_40'),
            C('DISTANCE_40_50'),
            C('DISTANCE_50_80'),
            C('DISTANCE_80')
        );
        if (!empty($distance) && in_array($distance, $distances)) {
            $distanceArr = explode('-', $distance);
            $start = (int)$distanceArr[0];
            $end = (int)$distanceArr[1];
            $where['distance'] = array('BETWEEN', array($start, $end));
        }
        $where['status'] = array('gt', 0);
        if ($provinceId != C('CHINA_NUM')) {
            $where['province_id'] = $provinceId;
        }

        if ($cityId) {
            $where['city_id'] = $cityId;
        }
        if (empty($categoryId)) {
            $where['category_id'] = C('CATEGORY_CEMETERY_ID');
        }
    	$where['category_id'] = C('CATEGORY_CEMETERY_ID');
    	if (!empty($categoryId) && $categoryId == C('CATEGORY_FUNERAL_ID')) {
            $where['category_id'] = C('CATEGORY_FUNERAL_ID');
        }


        return $this->where($where)->count();
    }

    /**
     * 获取现在已存在商家的省份
     *
     * @param number $categoryId 分类ID，默认是 陵园的ID
     *
     * @return array
     */
    public function getAlreadyStoreProvince($categoryId=0) {
        if (empty($categoryId)) {
            $categoryId = C('CATEGORY_CEMETERY_ID');
        }
        $where['category_id'] = (int)$categoryId;
        $where['status'] = array('neq', -1);

        return $this->where($where)->group('province_id')->getField('store_id, province_id');
    }

    /**
     * 获取某一个省份的市区数据
     *
     * @param Number $provinceId 省份ID
     * @param number $categoryId  分类ID
     *
     * @return array
     */
    public function getAlreadyStoreCity($provinceId, $categoryId = 0) {
        if (empty($provinceId)) {
            return array();
        }
        if (empty($categoryId)) {
            $categoryId = C('CATEGORY_CEMETERY_ID');
        }
        $where['category_id'] = (int)$categoryId;
        $where['province_id'] = (int)$provinceId;
        $where['status'] = array('neq', -1);

        return $this->where($where)->group('city_id')->getField('store_id, city_id');
    }
    /**
     * 获取推荐陵园的信息
     * @param int $type     推荐类型
     * @param int $region   推荐省份
     * @param int $num      条数
     * @return array
     */
    public function getStoreRecommend($type,$regionId,$num=6) {
        $storeDatas = array();
        S(array('prefix'=>C('HOME_CACHE_PREFIX')));
        $storeDatas = S($type.$regionId);
        if(empty($storeDatas)){
            $storeDatas = $this->_randRegionStore($regionId,$num);
            S($type.$regionId,$storeDatas,C('HOME_CHINA_CACHE_TIME'));
        }
        return $storeDatas;
    }
    /*
     * 随机获取地区商品
     * @param int $num    条数
     * @param int $region   推荐省份
     * @return array
     */
    public function _randRegionStore($regionId,$num){
        $where['status'] = C('NORMAL_STATUS');
        if($regionId!=C('CHINA_NUM')){
            $where['province_id'] = $regionId;
        }
        $where['category_id'] = C('CATEGORY_CEMETERY_ID');
        $where['member_status'] = array('in',array(C('STOER_MERMBER'),C('STOER_MERMBER_PERSON'),C('STOER_MERMBER_AD')));
        $store = D('store');

        $memberAllDatas = $store->where($where)->getField('store_id,store_name,store_banner,feature,member_status,summary,min_price,province_id');
        $memberId = array();
        foreach($memberAllDatas as $k=>$v){
            $memberId[] = $k;
        }
        //获取会员ID
        $memberNum = count($memberId);
        if(($num>0)&&($memberNum>=$num)){
            $needMemberId = array();
            $randMemberId = array_rand($memberId,$num);
            if($num==1){
                $needMemberId[] = $memberId[$randMemberId];
            }else{
                for($i=0;$i<$num;$i++){
                    $needMemberId[] = $memberId[$randMemberId[$i]];
                }
            }
        }
        //获取非会员
        $twoNum=$num-$memberNum;
        if($twoNum>0){
            //获取非会员数据
            $where['member_status'] = C('DEFAULT_STATUS');

            $noMemberData = $store->where($where)->getField('store_id,store_name,store_banner,feature,summary,min_price');
            foreach($noMemberData as $k=>$v){
                $noMeberId[] = $k;
            }
            $resultData = array();
            $resultNoMemberData = array();
            //判断非会员数量是否够用
            if($twoNum>count($noMeberId)){
                foreach($noMeberId as $k=>$v){
                    $resultNoMemberData[] =  $noMemberData[$v];
                }
            }else{
                $randNoMeberId = array_rand($noMeberId,$twoNum);
                if($twoNum==1){
                    $resultNoMemberData[] = $noMemberData[$noMeberId[$randNoMeberId]];
                }else{
                    foreach($randNoMeberId as $k=>$v){
                        $resultNoMemberData[] =  $noMemberData[$noMeberId[$v]];
                    }
                }
            }
            foreach($memberId as $k=>$v){
                $resultData[]=$memberAllDatas[$v];
            }
            return array_merge_recursive($resultData,$resultNoMemberData);
        }else{
            //返回会员数量满足需要数量返回数据
            foreach($needMemberId as $k=>$v){
                $resultData[]=$memberAllDatas[$v];
            }
            return $resultData;
        }
    }
    
    /**
     * 获取陵园\殡仪馆 浏览量
     * @param int $storeId 商家id
     * @param int $hits    默认浏览量
     */
    public function getStoreHits($storeId,$hits){
        if(!empty($storeId)){
            $where['store_id'] = $storeId;
            $this->where($where)->setInc('hits',1);
            if(C('HITS_TURN_ON')){
                $fileHits = F('hits_'.$storeId,'',C('HITS_CACHE_FILE'));
                if(empty($fileHits)){
                    $randHits = rand(200000,300000) + $hits;
                    $totalHits = $randHits;
                }else{
                    $totalHits = $fileHits+1;
                }
                F('hits_'.$storeId,$totalHits,C('HITS_CACHE_FILE'));
            }
        }

        return $totalHits;
    }
}