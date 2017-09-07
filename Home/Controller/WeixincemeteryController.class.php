<?php
namespace Home\Controller;

use Think\Controller;
use Common\Extend\IpLocale;
/**
 * 微信陵园控制器
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class WeixincemeteryController extends Controller{
    
    /**
     * 陵园列表页
     */
    public function index() {
        $provinceId = I('get.province');
        if(!empty($provinceId)){
            $region = M('Region')->where('region_id='.$provinceId)->field('region_id,region_name')->find();
            session('ip_region_id', $region['region_id']);
            session('ip_region_name', substr($region['region_name'], 0, 6));
        }
        $session_regiod_id = session('ip_region_id');
        //定位
        if(empty($session_regiod_id)){
            $ip = get_client_ip();
            $locale = New IpLocale();
            $areas = $locale->getProvinceCityId ( $ip ); // 根据ip获取登录地区
            $loginProvId = isset ( $areas ['provid'] ) && ! empty ( $areas ['provid'] ) ? $areas ['provid'] : 2;
            session('ip_region_id', $loginProvId);
            session('ip_region_name', $areas['name']);
            //如果是全国的话，那么定位到北京
            if ($loginProvId == C('CHINA_NUM')){
                session('ip_region_id', 3);
                session('ip_region_name', '北京');
            }
        }
        $where['state'] = array('gt',C('DEFAULT_STATUS'));
        $where['member_status'] = array('gt',C('DEFAULT_STATUS'));
        $where['province_id'] = session('ip_region_id');
        $where['category_id'] = C('CATEGORY_CEMETERY_ID');
        $storeList = M('Store')->where($where)->field('store_id,store_name,store_banner,member_status,feature,price_range')->select();
        
        //状态会员
        $memberStatusYh = getStoreMember(FALSE, 'yh');
        $this->memberStatusYh = $memberStatusYh;
        $this->storeList = $storeList;
        $this->provinceName = session('ip_region_name');
        $this->display();
    }
    
    /**
     * 陵园详情页
     * 
     * @param int $store_id 陵园id
     * 
     * @return viod
     */
    public function detail($store_id) {
        $storeModel = M('Store');
        $storeInfo = $storeModel->find($store_id);
        if(empty($storeInfo)) {
            header("Content-type:text/html;charset=utf-8");
            echo '没有该陵园';
            die;
        }
        $city = M('Region')->where('region_id='.$storeInfo['city_id'])->field('region_name')->find();
        $this->city = $city;
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
        $where['category_id'] = C('CATEGORY_CEMETERY_ID');
        $where['state'] = array('neq', -1);
        $where['member_status'] = array('gt',C('DEFAULT_STATUS'));
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
            $sphinxClient -> SetFilter("member_status", array(C('DEFAULT_STATUS')), true);
            //排序
            $sphinxClient -> setSortMode(SPH_SORT_EXTENDED, '@weight DESC');
            $sphinxClient -> SetSortMode( SPH_SORT_EXTENDED, "member_status DESC");
            //如果添加第三个参数， true 则是取反
            $sphinxClient->SetFilter("category_id", array(C('CATEGORY_CEMETERY_ID')));
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
    
    
    /**
     * 关于我们
     * 
     * @return void
     */
    public function aboutus() {
        //获取有会员的省份
        $where['category_id'] = C('CATEGORY_CEMETERY_ID');
        $where['state'] = array('neq', -1);
        $where['member_status'] = array('gt',C('DEFAULT_STATUS'));
        $provinces = M('Store')->where($where)->group('province_id')->getField('store_id, province_id');
        $region = array();
        if(!empty($provinces)){
            $map['region_id'] = array('in',$provinces);
            $region = M('Region')->where($map)->field('region_id,region_name')->order('sort asc')->select();
        }
        $this->region = $region;
        $this->display();
    }
    
    public function joinus() {
        $this->display();
    }
    
    /**
     * 陵园合作申请
     * 
     * @return json
     */
    public function collaborate(){
        $cemetery_name = I("post.name");
        $cemetery_linkman = I("post.linkman");
        $cemetery_mobile = I("post.mobile");
        $returnInfo = array(
        	'status' =>false,
        	'msg' =>''
        );
        //验证IP
        $ip = get_client_ip(1);
        $collaborate = M("collaborate");
        //获取当前日期并生成时间戳
        $date = date("Y-m-d").' 00:00:00';
        $time = strtotime($date);
        //查询相同IP当天预约次数并进行判断
        $res=$collaborate->where("ip=".$ip." and created_time>".$time)->count();
        if($res >= C('BOOK_EVERY_IP_NUM')){
            $returnInfo['msg']='今天预约次过多!';
        }else{
            //封装数据
            $data['ip'] = $ip;
            $data['cemetery'] = $cemetery_name;
            $data['name'] = $cemetery_linkman;
            $data['mobile'] = $cemetery_mobile;
            $data['created_time']=$data['updated_time']=time();
            //写入数据并判断
            if($collaborate->data($data)->add()){
                $returnInfo['status'] = true;
	        $returnInfo['msg'] = '亲爱的'.$cemetery_linkman.'你好,请稍等,我们的客服人员会联系你！';
            }else{
                $returnInfo['msg'] = '申请失败！';
            }
        }
        echo json_encode($returnInfo);
    }
}
