<?php
namespace Home\Controller;

use Home\Controller\BaseController;
use Think\Page;
/**
 * 殡仪馆控制器
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class FuneralController extends BaseController
{
    /**
     * 殡仪馆首页
     */
    public function lists(){
        $store = D('Store');
        $region = D('Region');
        $cityId = I('get.city');
        $provinceId = I('get.province');
        $regionAbbr = I('get.region');
        if ($regionAbbr) {
            $tmpAbbr = strtolower($regionAbbr);
            $area = D('Region')->getByAbbreviate($tmpAbbr);
            if ($area) {
                session('ip_region_id', $area['region_id']);
                session('ip_region_name', $area['region_name']);
                session('ip_region_abbr', strtolower($area['abbreviate']));
                if (!$provinceId) {
                    $provinceId = $area['region_id'];
                }
                $this->assign('regionName', $area['region_name']);
            }
        } else {
            if (empty($provinceId)) {
                $provinceId = C('CHINA_NUM');
            }
            session('ip_region_id', C('CHINA_NUM'));
            session('ip_region_name', C('CHINA_MSG'));
            session('ip_region_abbr', C('CHINA_ABBR'));
            $this->assign('regionName', C('CHINA_MSG'));

        }
        $cities = array();

        if (empty($provinceId)) {
            $provinceId = C('CHINA_NUM');
        }
        if(!empty($provinceId) && $provinceId!= C('CHINA_NUM')){
            $where['province_id'] = $provinceId;
        }
        if (!empty($cityId)) {
            $where['city_id'] = $cityId;
        }

        $provinceIds = $store->getAlreadyStoreProvince(C('CATEGORY_FUNERAL_ID'));
        $totalProvince = count($provinceIds);
        $conds['region_id'] = array('in',$provinceIds);
        $provinces = $region->where($conds)->field('region_id,region_name,abbreviate')->select();
        if ($provinceId != C('CHINA_NUM')) {
            $cityIds = $store->getAlreadyStoreCity($provinceId,C('CATEGORY_FUNERAL_ID'));
            $cities = $region->getByIds($cityIds);
        }

        $provinceWhere['region_id'] = $provinceId;
        $cityWhere['region_id'] = $cityId;
        $provincename = $region->where($provinceWhere)->getField('region_name');
        $cityname = $region->where($cityWhere)->getField('region_name');

        //商家数据
        $where['status'] = array('neq',C('DELETE_STATUS'));
        $where['category_id'] = C('CATEGORY_FUNERAL_ID');
        $total = $store ->where($where)->count();
        $page = new Page($total, C('DEFAULT_PAGE_SIZE'));
        $pageshow = $page->frontshow();
        $datas = $store->relation('StoreContact')->where($where)->field('store_id,store_name,store_banner,address')->limit($page->firstRow,$page->listRows)->select();

        //白事常识
        $Newsfuneral = D('News')->getNewsByCategory(C('CATEGOTY_SENSE'), 10);
        //推荐陵园
        $cond['category_id'] = C('CATEGORY_CEMETERY_ID');
        $cond['status'] = array('egt',1);
        if($provinceId == C('CHINA_NUM')){
            $cond['member_status'] = array('gt',C('DEFAULT_STATUS'));
            $storeIds = M('Store')->where($cond)->field('store_id')->select();
            foreach ($storeIds as $v){
                $storeArr[] = $v['store_id'];
            }
            $storeArrIds = array_rand($storeArr, 5);
            foreach ($storeArrIds as $m){
                $idsarr[] = $storeIds[$m]['store_id'];
            }
            $map['store_id'] = array('in',$idsarr);
            $cemetery = M('Store')->field('store_id,store_name,store_banner,feature,member_status')->where($map)->select();
        }else{
            $cond['province_id'] = $provinceId;
            if(!empty($cityId)){
                $cond['city_id'] = $cityId;
            }
            $cemetery = M('store')->where($cond)->field('store_id,store_name,store_banner,feature,member_status')->order('member_status desc, sort desc')->limit(5)->select();
        }
        //SEO信息
        $seoCond['type'] = C('SEO_TYPE.FUNERAL_LIST');
        $seoCond['status'] = C('NORMAL_STATUS');
        $seoCond['province_id'] = $provinceId;
        $seoInfo = M('Seo')->where($seoCond)->field('id,seo_title,seo_keywords,seo_description')->find();
        $storeMembersYH = getStoreMember(false, 'yh');
        $this->storeMembersYH = $storeMembersYH;
        $this->datas = $datas;
        $this->provinceId = $provinceId;
        $this->cityId = $cityId;
        $this->cities = $cities;
        $this->totalProvinces = $totalProvince;
        $this->provinces = $provinces;
        $this->total = $total;
        $this->provincename = $provincename;
        $this->cityname = $cityname;
        $this->page = $pageshow;
        $this->Newsfuneral = $Newsfuneral;
        $this->cemetery = $cemetery;
        $this->seoInfo = $seoInfo;
        $this->display();
    }

    /**
     * 殡仪馆详情页
     */
    public function detail(){
        $store_id = I('get.store_id');
        $storeModel = D('store');
        $fields = 'store_id, store_name, category_id, seo_title, seo_keywords, seo_description, summary, content, province_id, city_id, address, status, level, longitude, latitude, hits';
        $storeInfo = $storeModel->relation(array('StoreContact','StoreImg'))->field($fields)->find($store_id);
        // 浏览量
        $storeInfo['hits'] = $storeModel->getStoreHits($store_id,$storeInfo['hits']);
        //附近的殡仪馆
        $province = $storeInfo['province_id'];
        $city_id = $storeInfo['city_id'];
        if(!empty($province)){
            $cond['province_id'] = $province;
        }
        if(!empty($city_id)){
            $cond['city_id'] = $city_id;
        }
        $cond['category_id'] = C('CATEGORY_CEMETERY_ID');
        $cond['status'] = array('egt',1);
        $cemetery = M('store')->where($cond)->field('store_id,store_name,store_banner,feature')->order('member_status desc, sort desc')->limit(5)->select();
        $storeMembersYH = getStoreMember(false, 'yh');
        //该殡仪馆下资讯
        $map['store_id'] = $store_id;
        $map['status'] = C('NORMAL_STATUS');
        $map['category_id'] =C('CATEGOTY_STORE_DYNAMIC');
        $cemetery_news = M('news')->where($map)->field('id,title,top')->order('sort desc')->limit(10)->select();
        //该殡仪馆下资质
        $where['store_id'] = $store_id;
        $where['status'] = C('NORMAL_STATUS');
        $honor = M('StoreImages')->where($where)->field('id,thumb_image_url')->select(); 

        $this->honor = $honor;
        $this->cemetery_news = $cemetery_news;
        $this->storeMembersYH = $storeMembersYH;
        $this->cemetery = $cemetery;
        $this->storeInfo = $storeInfo;
        $this->display();
    }

    
}
