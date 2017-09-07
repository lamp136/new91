<?php
namespace Home\Controller;
use Home\Controller\BaseController;
use Think\Page;

/**
 * 搜索类
 * 主要针对页面顶部和首页的搜索
  *
  * @author  Gavin
  * @date：2015年12月19日 下午3:30:44
  * @version 1.0
 */
class SearchController extends BaseController
{
    /**
     * 搜索的主题方法
     *
     * @return void
     */
    public function searchd() {
        $type = 0;  //类型，陵园还是殡仪馆
        $searchKeyword   = I('get.wd');    //关键词搜索
        $province = I('get.province'); //省份
        $city = I('get.city');  //过滤页面的城市ID
        //分页
        $p = I('p');   //分页
        $this->_searchd($type, $searchKeyword, $province, $city, $p);
        $this->display();
    }
    /**
     * 搜索的主题方法
     *
     * @return void
     */
    public function cemetery() {
        $type = C('CATEGORY_CEMETERY_ID');  //类型，陵园还是殡仪馆
        $searchKeyword   = I('get.wd');    //关键词搜索
        $province = I('get.province'); //省份
        $city = I('get.city');  //过滤页面的城市ID
        //分页
        $p = I('p');   //分页
        $this->_searchd($type, $searchKeyword, $province, $city, $p);
        $this->display();
    }
    /**
     * 搜索的主题方法
     *
     * @return void
     */
    public function funeral() {
        $type = C('CATEGORY_FUNERAL_ID');  //类型，陵园还是殡仪馆
        $searchKeyword   = I('get.wd');    //关键词搜索
        $province = I('get.province'); //省份
        $city = I('get.city');  //过滤页面的城市ID
        //分页
        $p = I('p');   //分页
        $this->_searchd($type, $searchKeyword, $province, $city, $p);
        //白事常识
        $Newsfuneral = D('News')->getNewsByCategory(C('CATEGOTY_SENSE'), 10);

        //推荐陵园
        $cond['category_id'] = C('CATEGORY_CEMETERY_ID');
        $cond['state'] = array('egt',1);
        if(empty($province)){
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
            $cemetery = M('Store')->field('store_id,store_name,store_banner,feature')->where($map)->select();
        }else{

            $cond['province_id'] = $province;
            if(!empty($city)){
                $cond['city_id'] = $city;
            }
            $cemetery = M('store')->where($cond)->field('store_id,store_name,store_banner,feature')->order('member_status desc, sort desc')->limit(5)->select();
        }
        $this->cemetery = $cemetery;
        $this->Newsfuneral = $Newsfuneral;
        $this->display();
    }


    private function _searchd($type, $searchKeyword, $province, $city, $p=0) {
        if (!isset($p) || empty($p)) {
            $p = 1;
        }
        //当前页 用在数据查询中
        $currentP = $p -1;
        $offset = $currentP * C('DEFAULT_PAGE_SIZE');
        /**
         * 如果参数中获取不到省份那么就需要从COOKIE中获取
         */
        if (empty($province)) {
            $province = C('CHINA_NUM');
        }
        //获取搜索对应的省份和选中省份的市区
        $result = $this->_sphinxSearchd($searchKeyword, $type, $province, $city, 0, false);
        $provinces = array();
        $cities = array();
        $totalProvinces= 0;
        $region = D('region');
        $provinceWhere['region_id'] = $province;
        $cityWhere['region_id'] = $city;
        $provincename = $region->where($provinceWhere)->getField('region_name');
        $cityname = $region->where($cityWhere)->getField('region_name');
 
        $total = 0;
        $provinceIds = array();
        $citieIds = array();
        if (!empty($result['matches'])) {
            foreach ($result['matches'] as $mVal) {
                if ($province == C('CHINA_NUM') ) {
                    if (!in_array($mVal['attrs']['province_id'], $provinceIds)) {
                        $provinceIds[] = $mVal['attrs']['province_id'];
                    }
                }
                if ($province != C('CHINA_NUM') && $province == $mVal['attrs']['province_id'] ) {
                    if (!in_array($mVal['attrs']['city_id'], $citieIds)) {
                        $citieIds[] = $mVal['attrs']['city_id'];
                    }
                }
            }

            //获取地区的数据
            $provinces = $region->getByIds($provinceIds);
            $totalProvinces = count($provinceIds);
            $cities = $region->getByIds($citieIds);
        }
        
        //获取对应的商家数据
        $ret = $this->_sphinxSearchd($searchKeyword, $type, $province, $city, $offset);
        //分页
        $total = $ret['total'];
        $page = new Page($total, C('DEFAULT_PAGE_SIZE'));
        $show = $page->frontshow();
        //获取对应的商家数据
        $stores = array();
        $contact = array();
        $funeralIds = array();
        if (!empty($ret)) {
            foreach ($ret['matches'] as $sid=>  $matchVal) {
                $storeIds[] = $sid;
                $categoryId = $matchVal['attrs']['category_id'];
                if ($categoryId == C('CATEGORY_FUNERAL_ID')) {
                    $funeralIds[] = $sid;
                }
            }
            $store = D('store');
            $stores = $store -> getStoreByIds($storeIds, $type);
            $contact = $store->getContactBySids($funeralIds);
        }
       
        //获取商家会员
        $storeMembersYH = getStoreMember(false, 'yh');
        $storeMembersVip = getStoreMember(false, 'vip');
        //惠民政策
        $this->hmzc();
        //殡葬文化
        $this->bzwh();
        //陵园列表页SEO数据
        $this->getHomeSeo();

        $this->assign('page', $show);
        $this->assign('wd', $searchKeyword);
        $this->assign('stores', $stores);
        $this->assign('provinces', $provinces);
        $this->assign('totalProvinces', $totalProvinces);
        $this->assign('cities', $cities);
        $this->assign('provinceId', $province);
        $this->assign('cityId', $city);
        $this->assign('total', $total);
        $this->assign('provincename', $provincename);
        $this->assign('cityname', $cityname);
        $this->assign('contact', $contact);
        $this->assign('storeMembersYH', $storeMembersYH);
        $this->assign('storeMembersVip', $storeMembersVip);
        $this->assign('memberStatus', getStoreMember(false, 'all'));
    }
    /**
     * 实例化 sphinx 类
     *
     * @param String $host 服务的地址
     * @param Int $port       端口号
     *
     * @return SphinxClient
     */
    public function sphinxClient($host='', $port=9312) {
        if (empty($host)) {
            $host = C('SEARCH_SERVER');
        }
        import("Org.Sphinx.SphinxClient");
        $sphinxClient = new \SphinxClient();
        $sphinxClient -> SetServer($host, $port);

        return $sphinxClient;
    }

    private function _sphinxSearchd($wd, $type, $province, $city, $offset=0, $bool=true) {
        if (empty($wd) && empty($province)) {
            return array();
        }
        //获取sphinx对象
        $sphinxClient = $this->sphinxClient();
        /**
         * 地区过滤
         * 如果省份存在，并且不是全国进行条件过滤
         * 如果地区是全国，那么不需要过滤条件
         */
        if ($province && $province != C('CHINA_NUM')) {
            $filterProvince = (int)$province;
            $sphinxClient -> SetFilter("province_id", array($filterProvince));   //省份过滤条件
        }

        /**
         * 如果城市存在，那么也需要进行过滤，主要用在列表页的条件过滤上
         */
        if ($city && $bool) {
            $sphinxClient -> SetFilter("city_id", array((int)$city));   //省份过滤条件
        }
        if ($bool) {
            $sphinxClient -> SetLimits($offset, C('DEFAULT_PAGE_SIZE'));    //匹配的偏移量
        } else {
            $sphinxClient -> SetLimits(0, 1000);    //匹配的偏移量
        }


        $sphinxClient->SetMatchMode(SPH_MATCH_ALL);//匹配所有查询词(默认模式);
        //会员状态  取反  非删除的数据
        $sphinxClient -> SetFilter("state", array(C('DELETE_STATUS')), true);
        //排序
        $sphinxClient -> setSortMode(SPH_SORT_EXTENDED, '@weight DESC');
        $sphinxClient -> SetSortMode( SPH_SORT_EXTENDED, "member_status DESC");
        //数据类型 陵园还是殡仪馆
        if ($type && $type == C('CATEGORY_CEMETERY_ID')) {
            $filterCategory = array(C('CATEGORY_CEMETERY_ID'));
        } else if ($type && $type == C('CATEGORY_FUNERAL_ID')) {
            $filterCategory = array(C('CATEGORY_FUNERAL_ID'));
        } else {
            $filterCategory = array(C('CATEGORY_CEMETERY_ID'), C('CATEGORY_FUNERAL_ID'));
        }
        //如果添加第三个参数， true 则是取反
        $sphinxClient->SetFilter("category_id", $filterCategory);
        $sphinxClient->SetMatchMode(SPH_MATCH_ALL);
        $sphinxResult = $sphinxClient->query($wd, "*");
        //完全匹配数据，如果数据没有那么进行模糊匹配
        if(!$sphinxResult['matches']){
            $sphinxClient->SetMatchMode(SPH_MATCH_ANY);
            $sphinxResult = $sphinxClient->query($wd, "*");
        }
        return $sphinxResult;
    }

    /**
     * 网站顶部搜索词记录,不需要返回值
     *
     * @return void
     */
    public function searchKeywords() {
        $info = I('post.');
        $info['ip'] = ip2long(get_client_ip());
        $info['created_time'] = time();
        $info['type'] = C('SEARCH_TOP');
        $info['province_id'] = session('ip_region_id');
        if(!empty($info['keyword'])){
            $search_keywords = M('SearchKeywords');
            $search_keywords->create($info);
            $ret = $search_keywords->add();
        }
    }
    /**
     * 陵园数据搜索记录
     *
     * @return void
     */
    public function searchCemetery() {
        $info = I('post.');
        $info['ip'] = ip2long(get_client_ip());
        $info['created_time'] = time();
        $info['type'] = C('SEARCH_CEMETERY');
        if(!empty($info['keyword']) || !empty($info['provinceid'])){
            $search_keywords = M('SearchKeywords');
            $search_keywords->create($info);
            $ret = $search_keywords->add();
        }
    }
    /**
     * 殡仪馆数据搜索记录
     *
     * @return void
     */
    public function searchFuneral() {
        $info = I('post.');
        $info['ip'] = ip2long(get_client_ip());
        $info['created_time'] = time();
        $info['type'] = C('SEARCH_FUNERAL');
        if(!empty($info['keyword']) || !empty($info['provinceid'])){
            $search_keywords = M('SearchKeywords');
            $search_keywords->create($info);
            $ret = $search_keywords->add();
        }
    }

}