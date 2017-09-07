<?php
namespace Home\Controller;
use Think\Controller;
use Common\Extend\IpLocale;
/**
 * 控制器的基础类
  *
  * @author  Gavin
  * @date：2015年12月19日 下午1:58:27
  * @version 1.0
 */
class BaseController extends Controller
{
    /**
     *  初始化数据
     *  比如：打开网站之后的IP判断问题
     *
     * @return void
     */
    public function _initialize() {
        //IP定位是否开启
        $ipLocation = C('IP_LOCATION');
        //获取IP
        $ip = get_client_ip();
        $session_regiod_id = session('ip_region_id');
        /**
         * 如果开启IP定位，并且session中没有地区ID那么进行IP定位
         * 如果没有开启IP定位，并且session中没有地区ID那么默认到全国
         */
        if ($ipLocation && empty($session_regiod_id)) {
        	$locale = New IpLocale();
        	$areas = $locale->getProvinceCityId ( $ip ); // 根据ip获取登录地区
        	$loginProvId = isset ( $areas ['provid'] ) && ! empty ( $areas ['provid'] ) ? $areas ['provid'] : 2;
        	session('ip_region_id', $loginProvId);
        	session('ip_region_name', $areas['name']);

        	if ($loginProvId == C('CHINA_NUM')) {
        		session('ip_region_abbr', strtolower(C('CHINA_ABBR')));
        	} else {
        		$ret = M('Region')->where('region_id='.$loginProvId)->getField('abbreviate');
        		$abbr = strtolower($ret);
        		session('ip_region_abbr', $abbr);

        		if (strtolower(CONTROLLER_NAME) == 'index' && strtolower(ACTION_NAME) != 'changearea') {
        			$this->redirect('/'.$abbr);
        			return;
        		}
        	}
          } else if(!$ipLocation && empty($session_regiod_id)) {
        	session('ip_region_id',C('CHINA_NUM'));
        	session('ip_region_name',C('CHINA_MSG'));
        	session('ip_region_abbr', strtolower(C('CHINA_ABBR')));
        }
        $sessionRegionName = session('ip_region_name');
        $regionName = empty($sessionRegionName) ? C('CHINA_MSG') : $sessionRegionName;

        //购物车数量显示
        $member_id = session('member_id');
        if($member_id){
            $num = M('shoppingCar')->where('member_id='.$member_id)->sum('num');
            if($num){
                $number = $num;
            }else{
                $number = 0;
            }
        }else{
            $number = 0;
        }
        

        $this->assign('number',$number);
        $this->assign ( "controllerName", strtolower (CONTROLLER_NAME) );

        $this->assign('regionName', $regionName);
        $this->assign('ip_region_abbr',  session('ip_region_abbr'));
        $this->assign('regionId', session('ip_region_id'));
        //导航顶部的地区
        $this->getAllProvince();

    }
    /**
     * 获取所有的省份
     *
     * @return void
     */
    public function getAllProvince() {
        $region = D('Region');
        //获取全国省份
        $region = $region->getProvinces(false);
        $this->assign('region', $region);
    }
    /**
     * 其他栏目的惠民政策新闻获取
     *
     * @param int $num 获取的数量，如果是0 则是使用默认数量
     *
     * @return void
     */
    public function hmzc($num=0) {
        if (empty($num)) {
            $num = C('DEFAULT_SIZE');
        } else {
            $num = (int)$num;
        }

        //惠民政策
        $hmzc = D('News')->getNewsByCategory(C('CATEGOTY_LAWS_REGULATIONS'), $num);
        $this->assign('hmzc', $hmzc);
    }
    /**
     * 殡葬文化
     * 获取一条推荐的新闻，推荐的新闻后台添加的时候必须带图片
     *
     * @param  int $num 获取的数量，如果是0 则是使用默认殡葬文化的数量
     *
     * @return void
     */
    public function bzwh($num=0) {
        if (empty($num)) {
            $num = C('DEFAULT_SIZE');
        } else {
            $num = (int)$num;
        }
        //获取一条推荐的新闻
        $where['category_pid'] = C('CATEGOTY_FUNERAL_CULTURE');
        $where['recommend'] = C('RECOMMEND_STATUS');
        $where['status'] = C('NORMAL_STATUS');
        $newsModel = D('News');
        $bzwhtj =$newsModel->relation('Img')->where($where)->field('id,title')->order('created_time desc')->find();
        $bzwhcond['category_id'] = C('CATEGOTY_FUNERAL_CULTURE');
        if (!empty($bzwhtj)) {
            $bzwhcond['id'] = array('not in',$bzwhtj['id']);
        } else {
            $num = C('DEFAULT_SIZE');
        }
        $bzwh = $newsModel->getNewsByCondition($bzwhcond,$num);

        $this->assign('bzwh', $bzwh);
        $this->assign('bzwhtj', $bzwhtj);
    }
    /**
     * 风水文化
     * 获取一条推荐的新闻，推荐的新闻后台添加的时候必须带图片
     *
     * @param  int $num 获取的数量，如果是0 则是使用新闻默认的数量
     *
     * @return
     */
    public function fswh($num=0) {
        if (empty($num)) {
            $num = C('DEFAULT_SIZE');
        } else {
            $num = (int)$num;
        }
        //风水文化
        //获取一条推荐的新闻，推荐的新闻后台添加的时候必须带图片
        $where['category_pid'] = C('CATEGOEY_FENGSHUI_CULTURE');
        $where['recommend'] = C('RECOMMEND_STATUS');
        $where['status'] = C('NORMAL_STATUS');
        $newsModel = D('News');
        $fswhtj = $newsModel->relation('Img')->where($where)->field('id,title')->order('created_time desc')->find();
        $fswhcond['category_pid'] = C('CATEGOEY_FENGSHUI_CULTURE');
        if (!empty($fswhtj)) {
            $fswhcond['id'] = array('not in',$fswhtj['id']);
        }
        $fswh = $newsModel->getNewsByCondition($fswhcond,$num);
        $this->assign('fswhtj', $fswhtj);
        $this->assign('fswh', $fswh);
    }
    /**
     * 陵园首页、列表页SEO数据
     *
     * @param string $type 是指首页还是列表页
     *
     * @return
     */
    public function getHomeSeo($type='') {
        $provinceId = session('ip_region_id');
        if (empty($provinceId)) {
            $provinceId = C('CHINA_NUM');
        }
        $types = C('SEO_TYPE');
        if (empty($type) || !in_array($type, $types)) {
            $type = C('SEO_TYPE.CEMETERY_HOME');
        }
        $where['province_id'] = $provinceId;
        $where['type'] = $type;
        $where['status'] = C('NORMAL_STATUS');
        $seo = M('Seo')->field('seo_title, seo_keywords, seo_description')->where($where)->find();
        //TODO 数据为空判断
        if (empty($seo)) {
             $seo['seo_title'] = "全国陵园墓地公墓，墓地价格，风水-91搜墓网";
             $seo['seo_keywords']= "全国陵园墓地，公墓，墓地价格，陵园风水-91搜墓网";
             $seo['seo_description'] = "91搜墓网是全国最大的陵园公墓网络搜索平台，提供公墓，陵园，周边墓地，周边公墓，墓地价格，墓地风水，为需要购买墓地的用户提供真实有效的陵园信息资源和便快捷的贴心服务。全国统一咨询热线：400-8010-344。";
        }
        
        $this->assign('seoInfo', $seo);
    }
    /**
     *获取友情链接
     *
     * @return void
     */
    protected function getFriendlink(){
        $provinceId = session('ip_region_id');
        $where['status'] = C('NORMAL_STATUS');
        $link = M('Friendlink')->field('name,url,province_id')->where($where)->order('sort DESC')->select(); 
        foreach ($link as $key => $value) {
            $province_id = explode(',',$value['province_id']);
            if(in_array($provinceId,$province_id)){
                $friendlinks[] = $value;
            }
        }
        $this->assign('friendlinks',$friendlinks);
    }
    /**
     * 获取广告位的图片
     * 如果在他自己的广告位上获取不到图片或则数量不够，则剩余的获取共享图片
     * 以自己位置上的图片为准
     *
     * @param int $positionId  广告位置ID
     * @param int $provinceId 省份ID
     * @param number $num  获取的数量
     * @param boolearn $bool 是否需返回值，默认不需要
     *
     * @return void
     */
    public function getAdBanner($positionId, $provinceId, $num=1, $bool=false) {
        if (!empty($positionId)) {
            $provinceId = empty($provinceId) ? C('CHINA_NUM') : (int)$provinceId;
            $where['province_id'] = $provinceId;
            $where['ad_position_id'] = $positionId;
            $where['status'] = C('NORMAL_STATUS');
            $fields = array('banner_name, banner_url, banner_link,share');
            $ad = M('AdvertisingBanner');
            //分享的数据条件
            $tmpCond['status'] = C('NORMAL_STATUS');
            $tmpCond['share'] = C('SHARE_STATUS');
            $ads = array();
            if ($num == 1) {
                $ads =$ad ->field($fields)->where($where)->order('sort DESC')->find();
                if (empty($ads) && $positionId == C('HOME_BANNER') && $provinceId != C('CHINA_NUM')) {
                    $ads = $ad -> field($fields)->where($tmpCond)->order('sort DESC')->find();
                }
            } else {
                $retAds = $ad->field($fields)->where($where)->order('sort DESC')->limit($num)->select();
                $count = count($retAds);
                $residue = $num-$count;
                //获取分享图片仅仅适用于轮播图
                if ($residue > 0 && $positionId == C('HOME_BANNER') && $provinceId != C('CHINA_NUM') ) {
                    $tmpAds = $ad->field($fields)->where($tmpCond)->order('sort DESC')->limit($residue)->select();
                    if (empty($count)) {
                        $ads = $tmpAds;
                    } else {
                        $ads = array_merge($retAds, $tmpAds);
                    }
                } else {
                    $ads = $retAds;
                }
            }//end if else num == 1
            if ($bool) {
                return $ads;
            } else {
                $this->assign('ads', $ads);
            }
        }//end if  $positionId
    }
}