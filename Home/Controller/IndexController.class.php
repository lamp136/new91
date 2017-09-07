<?php
namespace Home\Controller;
use Home\Controller\BaseController;
use Org\Net\IpLocation;
use Think\Cache\Driver\Redis;
class IndexController extends BaseController {

    public function index(){
        $sessionIpRegionId = session('ip_region_id');
        //获取公司动态
        $newsModel = D('News');
        $gsdt = $newsModel ->getNewsByCategory(C('CATEGOTY_COMPANY_DYNAMIC'),15);
        //常见问题
        $cjwt = $newsModel->getNewsByCategory(C('CATEGOTY_SENSE'), 10);
        //风水文化
        $this->fswh(9);
        //企业软文
        $qyrw = $newsModel->getNewsByCategory(C('CATEGOTY_COM_CULTURE'),6);
        //最新资讯
        $latestnewscond['category_id'] = array('not in',array(C('CATEGOTY_COMPANY_DYNAMIC'),C('CATEGOTY_SENSE'),C('CATEGOTY_FUNERAL_CULTURE'),C('CATEGOTY_FS_FORTUNES'),C('CATEGOTY_COM_CULTURE')));
        $latestnewscond['status'] = C('NORMAL_STATUS');
        $latestnews = $newsModel->getNewsByCondition($latestnewscond,14);
        //最新预约信息
        $appointInfo = D('OrderGrave')->getLastestOrders();
        //获取最新陵园
        $newstorecond['state'] = C('NORMAL_STATUS');
        $newstorecond['category_id'] = C('CATEGORY_CEMETERY_ID');
        //$newstorecond['member_status'] = array('gt', 0);
        if ($sessionIpRegionId != C('CHINA_NUM')) {
            $newstorecond['province_id'] = $sessionIpRegionId;
        }
        $storeModel = D('Store');

        $newstore = $storeModel->where($newstorecond)->field('store_id,store_name,store_banner,feature,member_status,summary,min_price')->order('member_status desc, created_time desc')->limit(5)->select();
        //风水推荐
        $fstj = $storeModel->getStoreRecommend(C('STORE_RECOMMEND.GEOMANCY'),$sessionIpRegionId);
        
        //环境推荐
        $hjtj = $storeModel->getStoreRecommend(C('STORE_RECOMMEND.ENVIRONMENT'),$sessionIpRegionId);
        //交通推荐
        $jttj = $storeModel->getStoreRecommend(C('STORE_RECOMMEND.TRANSPORT'),$sessionIpRegionId);
        //陵园会员
        $storeMembersYH = getStoreMember(false, 'yh');
        $this->assign('storeMembersYH', $storeMembersYH);
        $storeMembersVip = getStoreMember(false, 'vip');
        $this->assign('storeMembersVip', $storeMembersVip);

        //网站首页SEO数据
        $this->getHomeSeo();
        
        //首页的轮播图
        $this->getAdBanner(C('HOME_BANNER'), $sessionIpRegionId, C('HOME_BANNER_NUM'));
        //首页横幅
        $hengfuAd = $this->getAdBanner(C('HOME_FVLON'), 0, 1, true);
        //右侧广告位4个
        $firstAd = $this->getAdBanner(C('HOME_NEW_APPIONT_DOWN'), 0, 1, true);
        $secAd = $this->getAdBanner(C('HOME_COMPANY_NEWS_DOWN'), 0, 1, true);
        $thirdAd = $this->getAdBanner(C('HOME_FENGSHUI_DOWN'), 0, 1, true);
        $forthAd = $this->getAdBanner(C('HOME_QUESTION_DOWN'), 0, 1, true);
        //友情链接
        $this->getFriendlink();

        $this->assign('hengfuAd', $hengfuAd);
        $this->assign('firstAd', $firstAd);
        $this->assign('secAd', $secAd);
        $this->assign('thirdAd', $thirdAd);
        $this->assign('forthAd', $forthAd);

        $this->assign('gsdt',$gsdt);
        $this->assign('cjwt',$cjwt);
        
        $this->assign('qyrw',$qyrw);
        $this->assign('latestnews',$latestnews);
        $this->assign('appointInfo',$appointInfo);
        $this->assign('newstore',$newstore);
        $this->assign('fstj',$fstj);
        $this->assign('hjtj',$hjtj);
        $this->assign('jttj',$jttj);
        $this->display('Index:index');
    }

    /**
     * 搜索建议提示
     * @return json
     */
    public function searchAutoHint(){
        $storeName = I('post.store_name');
        $result = array('flag'=>0,'data'=>'');
        if(!empty($storeName) && $storeName != ' '){
            $matchWords = $this->matchWord($storeName);
            if(!empty($matchWords)){
                $result = array('flag'=>1,'data'=>$matchWords);
            }
        }

        echo json_encode($result);
    }

    /**
     * 获取相似数据
     * @param  string $storeName 前台输入的名字
     * @return array
     */
    private function matchWord($storeName){
        $redis = new Redis(
            array(
                'prefix' => 'd_',
                'type'   => 'redis',
                'expire' => 3600*24*5,
                'host'   => '127.0.0.1', 
                'port'   => '6379'
            )
        );
        $storeData = $redis->get('store_data');
        // 如果redis中store_data为空，则重新获取并存入redis
        if(empty($storeData)){
            $storeData = M('store')->where('member_status > 0')->field('store_name')->order('store_name asc')->select();
            $redis->set('store_data',$storeData);
        }
        $count = count($storeData);
        for ($i=0; $i < $count; $i++) { 
            // 匹配相似的数据
            if(preg_match('/'.$storeName.'/i',$storeData[$i]['store_name'])){
                $data[] = $storeData[$i]['store_name'];
            }
        }
        
        return $data;
    }

    public function changeArea() {
        $abbr = I('area');
        $region = D('Region');
        $area = $region->getByAbbreviate($abbr);
        if (!$area) {
        	$this->redirect("/");
        }else {
        	session('ip_region_id', $area['region_id']);
        	session('ip_region_name', $area['region_name']);
        	session('ip_region_abbr', strtolower($area['abbreviate']));
        	$this->assign('regionName', $area['region_name']);

        	//获取所有的地区缩写
        	//$ret = M('Region')->where('pid=2')->getField('region_id, abbreviate');
        	if (strtolower($abbr) == strtolower(C('CHINA_ABBR'))) {
        		$this->redirect("/");
        	} else {
        		$this->index();
        	}
        }
    }
}