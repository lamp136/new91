<?php
namespace Home\Controller;

use Home\Controller\BaseController;
use Think\Page;
use Common\Extend\SendMsg;
/**
 * Description of CemeteryController
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class CemeteryController extends BaseController{

    /**
     * 陵园列表页
     */
    public function index() {
        $cityId = I('get.city');
        $distance = I('get.distance');
        $provinceId = I('get.province');
        $regionAbbr = I('get.region');
        // 根据后缀获取地区ID 如果ABBR存在优先走ABBR,条件永远都是第一位
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
        //获取公里数
        $distances = array(
            C('DISTANCE_1_10'),
            C('DISTANCE_10_20'),
            C('DISTANCE_20_30'),
            C('DISTANCE_30_40'),
            C('DISTANCE_40_50'),
            C('DISTANCE_50_80'),
            C('DISTANCE_80')
        );
        if (empty($distance) || !in_array($distance, $distances)) {
            $distance = '';
        }
        $store = D('Store');
        $total = $store -> getTotal($provinceId, $cityId, $distance);
        $page = new Page($total, C('DEFAULT_PAGE_SIZE'));
        $show = $page->frontshow();
        $datas = $store->getList($provinceId, $page->firstRow, $page->listRows, $cityId, $distance);
        //获取商家的名称
        $provinceWhere['region_id'] = $provinceId;
        $cityWhere['region_id'] = $cityId;
        $region = D('Region');
        $provincename = $region->where($provinceWhere)->getField('region_name');
        $cityname = $region->where($cityWhere)->getField('region_name');
        $totalProvince = 0;
        if ($provinceId != C('CHINA_NUM')) {
            $cityIds = $store->getAlreadyStoreCity($provinceId);
            $cities = $region->getByIds($cityIds);
        }
        $provinceIds = $store -> getAlreadyStoreProvince();
        $totalProvince = count($provinceIds);
        $provinceWhere['region_id'] = array('in',$provinceIds);
        $provinces = $region->where($provinceWhere)->field('region_id,region_name,abbreviate')->select();

        $this->assign('distances', $distances);
        $this->assign('countDistance', count($distances));
        //获取商家会员
        $storeMembersYH = getStoreMember(false, 'yh');
        $storeMembersVip = getStoreMember(false, 'vip');
        //惠民政策
        $this->hmzc();
        //殡葬文化
        $this->bzwh();

        //陵园列表页SEO数据
        $this->getHomeSeo(C('SEO_TYPE.CEMETERY_LIST'));

        //广告
        $this->getAdBanner(C('CEMETERY_HUIMIN_DOWN'), 0, 1);

        $this->assign('datas', $datas);
        $this->assign('page', $show);
        $this->assign('storeMembersYH', $storeMembersYH);
        $this->assign('storeMembersVip', $storeMembersVip);
        $this->assign('provinceId', $provinceId);
        $this->assign('cityId', $cityId);
        $this->assign('total', $total);
        $this->assign('provincename', $provincename);
        $this->assign('cityname', $cityname);
        $this->assign('provinces', $provinces);
        $this->assign('totalProvinces', $totalProvince);
        $this->assign('cities', $cities);
        $this->assign('selectDistance', $distance);
        $this->assign('memberStatus', getStoreMember(false,'all'));
        $this->display();
    }

    /**
     * 陵园详情页
     */
    public function detail(){
        $store_id = I('get.store_id');
        $storeModel = D('store');
        //陵园基础信息
        $fields = 'store_id,store_name,seo_title,seo_keywords,seo_description,content,province_id,city_id,address,status,review_price,review_traffic,review_ambient,review_service,longitude,latitude,hits,member_status,feature,environment,geomantic,min_price,distance';
        $storeInfo = $storeModel->field($fields)->relation('StoreImg')->find($store_id);
        // 浏览量
        $storeInfo['hits'] = $storeModel->getStoreHits($store_id,$storeInfo['hits']);
        //陵园景观
        $lyjgCond['album_id'] = array('in',array(C('STORE_IMG_SCENERY'),C('STORE_IMG_FACILITY')));
        $lyjgCond['state'] = C('NORMAL_STATUS');
        $lyjgCond['store_id'] = $store_id;
        $lyjg = M('StoreImages')->field('image_url')->where($lyjgCond)->order('sort desc,id desc')->select();
        //名人墓地
        $mrmdCond['store_id'] = $store_id;
        $mrmdCond['recommended'] = C('NORMAL_STATUS');
        $mrmd = M('CelebrityCemetery')->where($mrmdCond)->field('id,name,born_in,died_in,summary,image_url')->order('sort desc,id desc')->limit(3)->select();
        //陵园资质
        $aptitude = M('StoreImages')->where('store_id='.$store_id.' and album_id=5')->field('image_url,title')->order('sort desc')->select();
        //陵园动态
        $storeNews = M('News')->where('store_id='.$store_id.' and category_id='.C('CATEGOTY_STORE_DYNAMIC').' and status='.C('NORMAL_STATUS'))->order('sort desc,created_time desc')->limit(8)->select();
        //惠民政策
        $hmzc = D('News')->getNewsByCategory(C('CATEGOTY_STORE_DYNAMIC'),10);
        //风水文化
        //获取一条推荐的新闻，推荐的新闻后台添加的时候必须带图片
        $fswhtj = D('News')->relation('Img')->where('recommend='.C('NORMAL_STATUS').' and category_pid='.C('CATEGOEY_FENGSHUI_CULTURE'))->field('id,title')->order('id desc')->find();
        $fswhcond['category_pid'] = C('CATEGOEY_FENGSHUI_CULTURE');
        $fswhcond['id'] = array('not in',$fswhtj['id']);
        $fswh = D('News')->getNewsByCondition($fswhcond,8);
        //墓碑展示
        $goods = D('Goods')->Relation(array('Img','Color','Area','Material','Grave', 'WAIGUAN'))->where('store_id='.$store_id.' and status='.C('NORMAL_STATUS').' and store_show='.C('NORMAL_STATUS'))->field('id,goods_name,store_id')->limit(3)->select();
        //获取陵园所在市
        $province = M('region')->where('region_id='.$storeInfo['province_id'])->field('region_name')->find();
        $city = M('region')->where('region_id='.$storeInfo['city_id'])->field('region_name')->find();

        //获取用户的评论
        $comment = M('Comment')->where('store_id='.$store_id.' and comment_status='.C('NORMAL_STATUS'))->field('mobile,comment_time,content,environment,service,price,traffic')->order('set_top desc,replay_time desc')->select();
        if(!empty($comment)){
            foreach($comment as $key=>$val){
                $total = $val['environment']+$val['service']+$val['price']+$val['traffic'];
                $score = round($total/4, 2);
                $comment[$key]['score'] = $score;
            }
        }
        //陵园的评分，四舍五入取整
        $storeScoreTotal = $storeInfo['review_price'] + $storeInfo['review_traffic'] + $storeInfo['review_ambient'] + $storeInfo['review_service'];
        $storeScore = round($storeScoreTotal/4);
        //广告
        $this->getAdBanner(C('NEWS_DETAIL_PAGE'), 0, 1);

        //判断是否收藏
        $memberId = session('member_id');
        $judge = '';
        if(!empty($memberId)){
            $judge = M('collect')->where('member_id='.$memberId.' and store_id='.$store_id.' and status = '.C('NORMAL_STATUS'))->find();
        }
        $this->judge = $judge;
        $this->storeScore = $storeScore;
        $this->aptitude = $aptitude;
        $this->storeInfo = $storeInfo;
        $this->lyjg = $lyjg;
        $this->mrmd = $mrmd;
        $this->storeNews = $storeNews;
        $this->hmzc = $hmzc;
        $this->fswh = $fswh;
        $this->fswhtj = $fswhtj;
        $this->goods = $goods;
        $this->city = $city;
        $this->province = $province;
        $this->storeId = $store_id;
        $this->comment = $comment;
        //判断是否是广告会员，显示不同的模板
        if($storeInfo['member_status']==C('STOER_MERMBER_AD')){
            //获取陵园联系电话
            $contact = M('StoreContact')->where('store_id='.$store_id.' and status='.C('NORMAL_STATUS'))->field('tel')->find();
            $this->contact = $contact;
            $this->display('advipdetail');
        }else{
            $this->display();
        }
    }

    /**
     * 墓型列表
     */
    public function tomb(){
        $store_id = I('get.store_id');
        $where['store_id'] = $store_id;
        $where['status'] = C('NORMAL_STATUS');
        $total = M('Goods')->where($where)->count();
        $page = new Page($total,12);
        $pageshow = $page->frontshow();
        $tombList = D('Goods')->Relation(array('Img','Color','Area','Material','Grave', 'WAIGUAN'))->where($where)->field('id,goods_name,store_id')->order('store_show desc,created_time desc')->limit($page->firstRow,$page->listRows)->select();
        $storeInfo = D('Store')->where('store_id='.$store_id)->field('store_name,store_id, province_id, status')->find();
        //获取所有的省份
        $region = D('Region')->getProvinces();
        $this->tombList = $tombList;
        $this->pageshow = $pageshow;
        $this->storeInfo = $storeInfo;
        $this->region = $region;
        $this->display();
    }

    /**
     * 名人墓地
     */
    public function famous() {
        $store_id = I('get.store_id');
        $where['store_id'] = $store_id;
        $where['status'] = C('NORMAL_STATUS');
        $totalRows = M('CelebrityCemetery')->where($where)->count();
        $page = new Page($totalRows,9);
        $pageshow = $page->frontshow();

        $celebrityList = M('CelebrityCemetery')->where($where)->field('id,name,born_in,died_in,summary,image_url')->order('sort desc')->limit($page->firstRow,$page->listRows)->select();
        //获取所有的省份
        $region = D('Region')->getProvinces();
        //获得陵园的名称
        $storeInfo = M('Store')->where('store_id='.$store_id)->field('store_name,store_id, province_id')->find();
        $this->pageshow = $pageshow;
        $this->celebrityList = $celebrityList;
        $this->region = $region;
        $this->storeInfo = $storeInfo;
        $this->display();
    }

    /**
     * 名人墓地详情页
     */
    public function famousdetail(){
        $id = I('get.id');
        $celebrityinfo = D('CelebrityCemetery')->relation('Store')->find($id);
        //其他名人
        $otheCelebrity = M('CelebrityCemetery')->where('store_id='.$celebrityinfo['store_id'].' and id!='.$id.' and status='.C('NORMAL_STATUS'))->field('id,name,born_in,died_in')->select();
        //大家都在关注的名人墓位，通过sort 排序
        $attentionCelebrity = M('CelebrityCemetery')->where('status='.C('NORMAL_STATUS'))->field('id,name,born_in,died_in')->order('sort desc')->limit(10)->select();
        //获取该名人所在陵园的封面
        $storeImg = M('Store')->where('store_id='.$celebrityinfo['store_id'])->field('store_id,store_name,store_banner,member_status')->order('sort desc')->find();
        //获取所有的省份
        $region = D('Region')->getProvinces();
        //获取商家会员
        $storeMembersYH = getStoreMember(false, 'yh');
        $storeMembersVip = getStoreMember(false, 'vip');
        $this->assign('storeMembersYH', $storeMembersYH);
        $this->assign('storeMembersVip', $storeMembersVip);
        $this->assign('celebrityinfo',$celebrityinfo);
        $this->assign('otheCelebrity',$otheCelebrity);
        $this->assign('attentionCelebrity',$attentionCelebrity);
        $this->assign('storeImg',$storeImg);
        $this->assign('region',$region);
        $this->display();
    }

    public function appoint() {
        //判断session中用户手机号是否存在，不存在跳转到登陆页
        // $form = __SELF__;
        // $url='/login?url='.$form;
       $member_mobile = session('member_mobile');
       //  if(empty($member_mobile)){
       //      header('Location: '.$url);
       //  }
        //获取所有的省份
        $store_id = I('get.store_id');
        $region = D('Region')->getProvinces();
        //获得陵园的名称
        $storeInfo = M('Store')->where('store_id='.$store_id)->field('store_name,store_id')->find();
        $this->region = $region;
        $this->storeInfo = $storeInfo;
        $this->display();
    }

    public function submitappoint() {
        if(IS_POST){
            $postData = I('post.');
            $mobile = $postData['mobile'];
            $store_id = $postData['store_id'];
            $result = array('flag'=>0,'msg'=>'操作失败');

            $storeInfo = M('Store')->field('store_id,store_name,province_id,city_id,member_status')->find($store_id);
            if(empty($storeInfo)){
                $result['flag'] = '1';
                $result['msg'] = '商家不存在';
            }else{
                $orderModel = M('OrderGrave');
                //先判断该用户预约的次数
                //获取当前日期并生成时间戳
                $date = date("Y-m-d").' 00:00:00';
                $time = strtotime($date);
                //查询相同IP当天预约次数并进行判断
                $res = $orderModel->where("mobile='".$mobile."' and created_time>".$time)->count();
                if($res >= C('BOOK_EVERY_IP_NUM')){
                    $result['flag'] = '4';
                    $result['msg'] = '预约失败，今天预约次数过多';
                    echo json_encode($result); die;
                }
                //如果用户输入的手机号和session中的手机号不一样，那么需要判断验证码是正确
                if(is_null(session('member_id')) || session('member_mobile')!=$postData['mobile']){
                    $msgcode = $postData['msgcode'];
                    $MsgCodeModel = D('MsgCode');
                    $type = C('MSGCODE_TYPE.APPOINT');
                    $code_result = $MsgCodeModel->checkMessageCode($type,$mobile,$msgcode);
                    if(!$code_result){
                        $result['flag'] = '2';
                        $result['msg'] = '动态校验码错误';
                        echo json_encode($result);die;
                    }
                }
                //判断用户是否存登录（如果没有登录还要判断是否注册）
                if(is_null(session('member_id'))){
                    $member_id = getMemberId($mobile,$postData['buyer']);
                }else{
                    $member_id = session('member_id');
                }
                $orderData['order_grave_sn'] = makeSn();
                $orderData['order_type'] = C('ORDER_TYPE_FRONT');
                $orderData['store_id'] = $storeInfo['store_id'];
                $orderData['store_name'] = $storeInfo['store_name'];
                $orderData['province_id'] = $storeInfo['province_id'];
                $orderData['city_id'] = $storeInfo['city_id'];
                $orderData['member_id'] = $member_id;
                $orderData['buyer'] = $postData['buyer'];
                $orderData['mobile'] = $postData['mobile'];
                $orderData['appoint_time'] = time();
                $orderData['client_ip'] = get_client_ip(1,TRUE);
                $orderData['created_time'] = time();
                $orderData['store_status'] = $storeInfo['member_status'];
                
                $filterRet = $orderModel->create($orderData);
                $orderId = $orderModel->add();
                if($filterRet && $orderId){
                    $this->_sendToServicer($orderId, $postData['buyer'], $postData['mobile'], $storeInfo['store_name']);
                    
                    //获取收件人邮箱
                    $where['type'] = array_search('预约看墓',C('EMAIL_MSG'));
                    $emailData = M('EmailSheet')->field('email_address')->where($where)->select();
                    if(!empty($emailData)){
                        $emailAdd = array();
                        foreach($emailData as $val){
                            $emailAdd[] = $val['email_address']; 
                        }
                        //获取商家类型
                        $allMember = getStoreMember();
                        if($storeInfo['member_status'] == '0'){
                            $member  = '非会员';
                        }else if($storeInfo['member_status'] == '19'){
                            $member  = '商家会员';
                        }else{
                            $member  = $allMember[$storeInfo['member_status']];
                        }
                        //发送邮件
                        $content = '预约时间：'.date('Y-m-d H:i:s',time()).'  预约人：'.$orderData['buyer'].'   预约人手机号：'.$orderData['mobile'].'   预约陵园:'.$storeInfo['store_name'].'('.$member.')';
                        if(sendMail($emailAdd,'预约看墓',$content)){
                            $status = 1;
                            $send_time = date('Y-m-d H:i:s');
                        }else{
                            $status = 0;
                        }
                        //插入数据库
                        foreach($emailData as $val){
                            $addData[] = array(
                                'type'          => $where['type'],
                                'email_address' => $val['email_address'],
                                'title'         => '预约看墓',
                                'content'       => $content,
                                'status'        => $status,
                                'send_time'     => $send_time,
                                'creat_time'    => date('Y-m-d H:i:s')
                            );
                        }
                        M('EmailLog')->addAll($addData);
                    }
                    
                    $result['flag'] = '10';
                    $result['msg'] = '预约成功';
                }else{
                    $result['flag'] = '3';
                    $result['msg'] = '预约失败，请联系客服人员';
                }
            }

            echo json_encode($result);
        }
    }

    /**
     * 预约时发送短信息
     */
    public function sendmessage() {
        if(IS_POST){
            header("Content-Type:text/html; charset=utf-8");
            $mobile = I('post.mobile');
            if(preg_match('/^1[3|4|5|7|8][0-9]\d{8}$/',$mobile)){
                //判断发送验证码的次数是否超过了每个人每天限制的次数
                $messageCode = D('MsgCode');
                $isMaxSendNum = $messageCode->isMaxSendNum($mobile);
                if($isMaxSendNum){
                    $result = array('flag'=>0, 'msg'=>"请不要恶意点击");
                }else{
                    $mobile_code = rand(100000,999999);
                    $message = "动态验证码 " . $mobile_code . " 工作人员不会向你索要，请勿向任何人泄露。" . date("Y-m-d H:i:s", time()) . "【91搜墓网】";
                    $sendMsg = new SendMsg();
                    $ret = $sendMsg->sendMsg($mobile,$message);
                    if ($ret) {
                        $msgcodedata['mobile'] = $mobile;
                        $msgcodedata['code'] = $mobile_code;
                        $msgcodedata['type'] = C('MSGCODE_TYPE.APPOINT');
                        $msgcodedata['created_time'] = time();
                        if($messageCode->create($msgcodedata) && $messageCode->add()){
                            //将发送的短信写入短信记录中
                            $msglogData['classify'] = C('MSG_LOG_APPOINT');
                            $msglogData['mobile'] = $mobile;
                            $msglogData['msg'] = $message;
                            $msglogData['status'] = C('MSG_SEND_STATUS');
                            $msglogData['created_time'] = time();
                            $msglogData['send_time'] = time();
                            $msglogModel = M('MsgLog');
                            $msglogModel->create($msglogData);
                            $msglogModel->add();

                            $result = array('flag'=>1, 'msg'=>"发送成功");
                        }
                    } else {
                        $result = array('flag'=>0, 'msg'=>"验证码发送失败");
                    }
                }
            } else {
                $result = array('flag'=>0, 'msg'=>"手机格式不正确,请认真填写");
            }
            echo json_encode($result);
        }
    }

     /**
     * 预约看墓
     * array(
     *     'status' => true|false         //flag
     *     'msg'    => '成功|失败的信息',
     *     'data' => array(
     *          'field1'=>1,
     *          'field2'=>2
     *     )
     * )
     *
     * @return array
     */
    public function book(){
        $yu_name = I("post.name");
        $yu_mobile = I("post.mobile");
        $returnInfo = array(
            'status' =>false,
            'msg' =>''
        );
        //验证IP
        $ip = get_client_ip(1);
        $book = M("appoint");
        //获取当前日期并生成时间戳
        $date = date("Y-m-d").' 00:00:00';
        $time = strtotime($date);
        //查询相同IP当天预约次数并进行判断
        $res=$book->where("ip=".$ip." and created_time>".$time)->count();
        if($res >= C('BOOK_EVERY_IP_NUM')){
             $returnInfo['msg']='今天预约次过多!';
        } else {
            //封装数据
            $data['ip'] = $ip;
            $data['buyer'] = $yu_name;
            $data['mobile'] = $yu_mobile;
            $data['created_time'] = $data['updated_time'] = time();
            $data['status'] = C('DEFAULT_STATUS');
            //获取收件人邮箱
            $where['type'] = array_search('预约看墓',C('EMAIL_MSG'));
            $emailData = M('EmailSheet')->field('email_address')->where($where)->select();
            if(!empty($emailData)){
                $emailAdd = array();
                foreach($emailData as $val){
                    $emailAdd[] = $val['email_address']; 
                }
                //发送邮件
                $content = '预约时间：'.date('Y-m-d H:i:s',time()).'，预约人：'.$data['buyer'].' 预约人手机号：'.$data['mobile'].' 请及时联系！本邮件系统自动发送请忽回复！';
                if(sendMail($emailAdd,'预约看墓',$content)){
                    $status = 1;
                    $send_time = date('Y-m-d H:i:s');
                }else{
                    $status = 0;
                }
                //插入数据库
                foreach($emailData as $val){
                    $addData[] = array(
                        'type'          => $where['type'],
                        'email_address' => $val['email_address'],
                        'title'         => '预约看墓',
                        'content'       => $content,
                        'status'        => $status,
                        'send_time'     => $send_time,
                        'creat_time'    => date('Y-m-d H:i:s')
                    );
                }
                M('EmailLog')->addAll($addData);
            }

            //写入数据并判断
            if($book->data($data)->add()){
                $returnInfo['status'] = true;
                $returnInfo['msg'] = '亲爱的 '.$yu_name.' 您好,信息保存成功,稍后我们的客服人员会联系您！';
            }else{
                $returnInfo['msg'] = '预约失败，请重新预约！';
            }
        }

        echo json_encode($returnInfo);
    }

    /**
     * 发送给固定的商务部人员
     *
     * @return bool
     */
    private function _sendToServicer($orderId, $uname, $tel, $storename) {
        $mobile = C('BUSINESS_SERVICER_MOBILE');
        if (empty($uname) || empty($tel) || empty($storename)) {
            return false;
        }
        $msg = '亲,您有一条来自91搜墓网的客户预约信息,客户：'.$uname.'，电话：'.$tel.'，商家名称：'.$storename.'，请及时关注【91搜墓网】';
        $sendMsg = new SendMsg();
        $mobiles = explode(",", $mobile);
        $count = count($mobiles);
        for($i=0; $i<$count;$i++) {
            $sendMsg->sendMsg($mobile,$msg);
            $data['order_id']     = $orderId;
            $data['classify']     = C('PLATFORM_NUM');
            $data['msg']          = $msg;
            $data['mobile']       = $mobiles[$i];
            $data['status']       = C('MSG_SEND_STATUS');
            $data['created_time'] = time();
            $data['send_time']    = time();
            M('MsgLog') -> add($data);
        }
    }
    /**
     * 所有名人墓地列表
     *
     *@return void
     */
    public function lists(){
        $where['status'] = C('NORMAL_STATUS');
        $total = M('CelebrityCemetery')->where($where)->count();
        $page = new Page($total,12);
        $pageshow = $page->frontshow();

        $list = M('CelebrityCemetery')->field('id,name,born_in,died_in,summary,image_url')->where($where)->order('sort desc,id desc')->limit($page->firstRow,$page->listRows)->select();

        $this->pageshow = $pageshow;
        $this->assign('list',$list);
        $this->display();
    }

    /**
     * 添加收藏
     *
     * @return json_encode(result);
     */
    public function collect(){
        $map = I("post.");
        $map['member_id']    =  session('member_id');
        $collect = M('collect');
        $info = $collect->where($map)->find();
        if(!empty($info)){
            if($info['status'] == C('NORMAL_STATUS') ){
                $result['flag'] = 1;
                $result['msg'] = session('member_name').'您好，已关注！';
            }else{
                $data['status'] =  C('NORMAL_STATUS');
                $res = $collect->where($map)->save($data);
                if($res){
                    $result['flag']  = 1;
                    $result['msg']   = session('member_name').'您好，关注成功！';
                }else{
                    $result['flag']  = 0;
                    $result['msg']   = session('member_name').'您好，关注失败！';
                }
            }
        }else{
            $map['create_time']  =  time();
            $collect = $collect->data($map)->add();
            if($collect){
                $result['flag']  = 1;
                $result['msg']   =  session('member_name').'您好，关注成功！';
            }else{
                $result['flag']  = 0;
                $result['msg']   =  session('member_name').'您好，关注失败！';
            }
        }
        echo json_encode($result);
    }
}
