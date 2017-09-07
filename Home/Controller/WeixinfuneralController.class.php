<?php
namespace Home\Controller;

use Think\Controller;
/**
 * 微信陵园控制器
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class WeixinfuneralController extends Controller{
    
    public function index() {
        
        $provinceId = I('get.province');
        if(!empty($provinceId)){
            $region = M('Region')->where('region_id='.$provinceId)->field('region_id,region_name')->find();
            $provinceName = substr($region['region_name'], 0, 6);
            $where['province_id'] = $provinceId;
        }else{
            $provinceName = C('CHINA_MSG'); 
        }
        $where['state'] = array('gt',C('DEFAULT_STATUS'));
        $where['category_id'] = C('CATEGORY_FUNERAL_ID');
        $storeList = D('Store')->relation('StoreContact')->where($where)->field('store_id,store_name,store_banner,address')->select();
        session('ip_region_name', $provinceName);
        //状态会员
        $this->storeList = $storeList;
        $this->provinceName = $provinceName;
        $this->display();
    }
    
    /**
     * 殡仪馆详情页
     * 
     * @param int $store_id
     * 
     * @return void
     */
    public function detail($store_id) {
        $storeModel = D('Store');
        $storeInfo = $storeModel->relation('StoreContact')->find($store_id);
        if(empty($storeInfo)){
            header("Content-type:text/html;charset=utf-8");
            echo '没有该陵园';die;
        }
        $this->storeInfo = $storeInfo;
        $this->display();
    }
    
    /**
     * 切换地区展示页面
     * 
     * @return void
     */
    public function changeprovince() {
        $storeModel = D('Store');
        //获取有会员的省份
        $where['category_id'] = C('CATEGORY_FUNERAL_ID');
        $where['state'] = array('neq', -1);
        $provinces = M('Store')->where($where)->group('province_id')->getField('store_id, province_id');
        
        if(!empty($provinces)){
            $map['region_id'] = array('in',$provinces);
            $region = M('Region')->where($map)->field('region_id,region_name')->order('sort asc')->select();
            $this->region = $region;
            $this->display();
        }
    }
    
    /**
     * 搜索
     * 
     * @return void
     */
    public function search(){
        $wd = I('get.wd');
        $storeModel = M('Store');
        if(!empty($wd)){
            //获取sphinx对象
            $sphinxClient = $this->sphinxClient();
            $sphinxClient->SetMatchMode(SPH_MATCH_ALL);//匹配所有查询词(默认模式);
            //会员状态  取反  非删除的数据
            $sphinxClient -> SetFilter("state", array(C('DELETE_STATUS')), true);
            //会员类型
            $sphinxClient -> setSortMode(SPH_SORT_EXTENDED, '@weight DESC');
            $sphinxClient -> SetSortMode( SPH_SORT_EXTENDED, "member_status DESC");
            //如果添加第三个参数， true 则是取反
            $sphinxClient->SetFilter("category_id", array(C('CATEGORY_FUNERAL_ID')));
            $sphinxClient->SetMatchMode(SPH_MATCH_ALL);
            $sphinxResult = $sphinxClient->query($wd, "*");
            //完全匹配数据，如果数据没有那么进行模糊匹配
            if(!$sphinxResult['matches']){
                $sphinxClient->SetMatchMode(SPH_MATCH_ANY);
                $sphinxResult = $sphinxClient->query($wd, "*");
            }
            if (!empty($sphinxResult)) {
                foreach ($sphinxResult['matches'] as $sid=>  $matchVal) {
                    $storeIds[] = $sid;
                    $categoryId = $matchVal['attrs']['category_id'];
                }
                $store = D('store');
                $storeList = $store -> getStoreByIds($storeIds);
            }
            $this->memberStatusYh = $memberStatusYh;
            $this->storeList = $storeList;
        }
        $this->display();
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
}
