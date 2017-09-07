<?php 
namespace Admin\Controller;
use Admin\Controller\BaseController;
use Think\Page;
use Think\Operation;
/**
 * 商家统计
 * 搜索词统计
 * 订单分析统计
 * 财务收支统计
 * 商务人员订单统计
 * 用户咨询统计
 */

class AnalysisController extends BaseController
{
    /**
    * 按时间段条件搜索公共方法
    */
    private function timeWhere($field){
        $where = array();
        $start_time = I('get.start_time');
        $end_time = I('get.end_time');
        if(!empty($start_time) && empty($end_time)){
            $where[$field] = array('egt',strtotime($start_time));
        }
        if(!empty($end_time) && empty($start_time)){
            $where[$field] = array('elt',strtotime($end_time.' 23:59:59'));
        }
        if(!empty($start_time) && !empty($end_time)){
            $where[$field] = array('BETWEEN',array(strtotime($start_time),strtotime($end_time.' 23:59:59')));
        }
        //默认当月
        if(empty($start_time)){
            $year = date("Y");
            $month = date('m')-3;
            if($month==0){
                $month = 1;
            }else if($month<0){
                $year = $year -1;
                $month = 12 + $month;
            }
            $where[$field] = array('egt',strtotime($year."-".$month."-1"));
            $start_time = $year."-".$month."-1";
        }
        $this->assign('start_time',$start_time);
        //dump($start_time);die;
        return $where;
    }
        
    /*
     * 搜索词列表，热词统计
     * return void()
     */
    public function searchKeywordsList(){
        $type = I('get.type');
        $where = array();
        $start_time = I('get.start_time');
        $end_time = I('get.end_time');
        if(!empty($start_time) && empty($end_time)){
            $where['created_time'] = array('egt',strtotime($start_time));
        }
        if(!empty($end_time) && empty($start_time)){
            $where['created_time'] = array('elt',strtotime($end_time.' 23:59:59'));
        }
        if(!empty($start_time) && !empty($end_time)){
            $where['created_time'] = array('BETWEEN',array(strtotime($start_time),strtotime($end_time.' 23:59:59')));
        }
        if(!empty($type)){
            $where['type'] = $type;
        }
        $searchKeywordsModel = M('SearchKeywords');
        $count = $searchKeywordsModel->where($where)->count();
        $page = new Page($count, C('DEFAULT_PAGE_SIZE'));
        $pageshow = $page->show();
        $dataList = $searchKeywordsModel->where($where)->limit($page->firstRow, $page->listRows)->order('created_time desc')->select();
        $region = $this->getRegionData(array('pid'=>C('CHINA_NUM'),'state'=>C("NORMAL_STATUS")),array('region_id,region_name'),'',true);
        $this->assign('region',$region);
        $this->assign('searchSource',getSearchSource()); 
        $this->assign('dataList',$dataList);
        $this->assign('start_time',$start_time);
        $this->assign('page',$pageshow);
        $this->display();
    }

     /**
    *热词(搜索比较多的词)统计
    *
    */
    public function searchHotKeywords(){
        //搜索时间段
        $where = array();
        $start_time = I('get.start_time');
        $end_time = I('get.end_time');
        if(!empty($start_time) && empty($end_time)){
            $where['created_time'] = array('egt',strtotime($start_time));
        }
        if(!empty($end_time) && empty($start_time)){
            $where['created_time'] = array('elt',strtotime($end_time.' 23:59:59'));
        }
        if(!empty($start_time) && !empty($end_time)){
            $where['created_time'] = array('BETWEEN',array(strtotime($start_time),strtotime($end_time.' 23:59:59')));
        }
        
        $datas = M('SearchKeywords')->where($where)->field('keyword,province_id,created_time')->select();
        $datasNum = count($datas);
        foreach($datas as $v){
            //用于列表
            if(array_key_exists($v['keyword'],$keywordList)){
                $keywordList[$v['keyword']] = array('num'=>($keywordList[$v['keyword']]['num']+1),'provinceStr'=>($keywordList[$v['keyword']]['provinceStr'].':'.$v['province_id']));
            }else{
                $keywordList[$v['keyword']] = array('num'=>1,'provinceStr'=>$v['province_id']);
            }
            //用于图形
            $keywordChart[] = $v['keyword'];
        }
        $tmpKeywordChart = array_count_values($keywordChart);
        arsort($tmpKeywordChart);//按照键值对关联数组进行降序排序
        $a = array_slice($tmpKeywordChart,0,C('ANALYSIS_KEYWORD_NUM'));
        foreach($a as $k=>$v){
            $keywordChartJson[] = array($k,$v);
        }
        $keywordChartJson[] = array('其他',$datasNum-array_sum($a));
        $this->assign('keywords',json_encode($keywordChartJson));

        $this->assign('hotkeywords',$keywordList);
        $this->assign('start_time',$start_time);
        $this->display();
    }
    /*
     * 查看省份出现搜索词数量
     * return String(json);
     */
    public function regionKeywordNum(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $provinceStr = I('post.provinceStr');
        if(!empty($provinceStr)){
            $provinceArray = explode(":",$provinceStr);
            $provinceNum = array_count_values($provinceArray);
            $region = $this->getRegionData(array('region_id'=>array('in',$provinceArray)),array('region_id,region_name'),'',true);
            foreach($region as $key=>$value){
                $data[] = array('num'=>$provinceNum[$key],'name'=>$value);
            }
            //dump($data);die;
            $result = array('flag'=>1,'data'=>$data);
        }
        echo json_encode($result);
    }
    /**
     * 平台收支统计
     */
    public function incomeExpenditure(){
        $list = array();
        //购墓金额
        $order = M('orderGrave');
        $where = $this->timeWhere('success_time');
        $where['status'] = array('eq',10);
        $amount_cemetery = $order->where($where)->field('paid_in_amount,return_money')->select();
        $cemetery_income = 0;//购墓收入金额
        $cemetery_expenditure = 0; //购墓支出金额
        foreach ($amount_cemetery as $key => $value) {
            $cemetery_income += $value['paid_in_amount'];
            $cemetery_expenditure += $value['return_money'];
        }
        //购墓盈余
        $cemetery_surplus = $cemetery_income - $cemetery_expenditure;
        $list[] = array('name'=>'购墓金额','income'=>$cemetery_income,'expenditure'=>$cemetery_expenditure,'surplus'=>$cemetery_surplus);

        
        //推广支出
        $inject = M('inject');
        $where = $this->timeWhere('investment_time');
        $promotion_income = 0; //推广收入总金额
        $promotion_expenditure = (int)$inject->where($where)->sum('investment_amount'); //推广支出金额
        $promotion_surplus = $promotion_income - $promotion_expenditure;//盈余
        $list[] = array('name'=>'推广支出','income'=>$promotion_income,'expenditure'=>$promotion_expenditure,'surplus'=>$promotion_surplus);
        
        //总计
        $total_income = 0;
        $total_expenditure = 0;
        $total_surplus = 0;
        foreach ($list as $key => $value) {
            $total_income += $value['income'];
            $total_expenditure += $value['expenditure'];
            $total_surplus += $value['surplus'];
        }
        $list[] = array('name'=>'总计','income'=>$total_income,'expenditure'=>$total_expenditure,'surplus'=>$total_surplus);
        
        //收支统计柱状图
        $inout['name'] = array('收入总金额','实际支出','平台盈余');
        $inout['value']['0']['data'] = array($total_income,$total_expenditure,$total_surplus);
        $inoutData = json_encode( $inout['value']);
        $inoutName = json_encode($inout['name']);

        //详细收支统计柱状图
        foreach ($list as $key => $value) {
            $detail_income['name'][] = $value['name'];
            $one [] = $value['income'];
            $two [] = $value['expenditure'];
            $three[] = $value['surplus'];
        }
        $detail_income['value'] = array(array('name'=>'收入总金额','data'=>$one),array('name'=>'实际支出','data'=>$two),array('name'=>'平台盈余','data'=>$three));
        
        $detailData = json_encode($detail_income['name']);
        $detailName = json_encode($detail_income['value']);
        $this->assign('detail_Name',$detailData);
        $this->assign('detail_Data',$detailName);
        $this->assign('inoutName',$inoutName);
        $this->assign('inoutData',$inoutData);
        $this->assign('list',$list);
        $this->display();
    }
    
    /**
     * 商务人员签单
     */
    public function businessManSign(){
        $where = array();
        $where = $this->timeWhere('created_time');
        $storeProfilesDetail = M('StoreProfilesDetail');
        $fields = 'id,profiles_id,profile_name,principal_id,created_time';
        $where['status'] = C('NORMAL_STATUS');
        $profilesData = $storeProfilesDetail->where($where)->field($fields)->select();
        $admin = M('admin')->getField('id,nickname');
        $datalist = array(); 
        foreach($profilesData as $val){
            if(array_key_exists($admin[$val['principal_id']],$datalist)){
                $datalist[$admin[$val['principal_id']]]['total'] += 1;
                $datalist[$admin[$val['principal_id']]]['profiles_id'] = $datalist[$admin[$val['principal_id']]]['profiles_id'].':'.$val['profiles_id'];
                $datalist[$admin[$val['principal_id']]]['profile_name'] = $datalist[$admin[$val['principal_id']]]['profile_name'].':'.$val['profile_name'];
            }else{
                $datalist[$admin[$val['principal_id']]]['total'] = 1;
                $datalist[$admin[$val['principal_id']]]['profiles_id'] = $val['profiles_id'];
                $datalist[$admin[$val['principal_id']]]['profile_name'] = $val['profile_name'];
            }
        }
        $this->datalist = $datalist;
        $this->display();
    }

    /**
     * 签单数据省份分布
     */
    public function signData(){
        $result = array('flag'=>0,'data'=>'数据为空');
        $provinceVal = I('post.profileId');
        if(!empty($provinceVal)){
            $regionData = $this->getRegionData(array('level'=>1),array('region_id,region_name'),'',true);
            $ret = explode(':', $provinceVal);
            $where['id'] = array('in',$ret);
            $datalist = M('StoreProfiles')->field('province_id')->where($where)->select();
            $data = array();
            foreach($datalist as $value){
                if(array_key_exists($regionData[$value['province_id']],$data)){
                    $data[$regionData[$value['province_id']]] += 1; 
                }else{
                    $data[$regionData[$value['province_id']]] = 1; 
                }
            }
            $result = array('flag'=>1,'data'=>$data);
        }
        echo json_encode($result);
    }
           
        /**
         * 陵园分布统计，运行完成之后会跳转到陵园分布列表
         * @return void
         */
        public function storeStat() {
            //获取地区表的数据
            $regionData = M('region')->where('state ='.C('NORMAL_STATUS'))->getField('region_id, region_name, pid');
            //根据地区表的数据进行商家统计(只统计陵园)
            $cemetoryData = M('store') ->field('store_id, store_name, province_id, city_id, status, member_status,category_id') -> where('category_id ='.C('CATEGORY_CEMETERY_ID'))-> select();
            //组装数据
            $tmpData = array();
            foreach($cemetoryData as $k=> $cemetory) {
                $provinceId = trim($cemetory['province_id']);
                $cityId = trim($cemetory['city_id']);
                //判断省份ID和市区ID是否存在数组，如果存在直接判断总数即可，如果不存在那么需要初始化对应的数据值
                if ( !array_key_exists($cityId, $tmpData)) {
                    //初始化市区默认值
                    $tmpData[$cityId]['region_id'] = $cityId;
                    $tmpData[$cityId]['type'] = 1;
                    $tmpData[$cityId]['pid'] = $provinceId;
                    $tmpData[$cityId]['total'] = 1;
                    //初始默认值
                    $tmpData[$cityId]['member_total'] = 0;
                    $tmpData[$cityId]['closed_total'] = 0;
                    $tmpData[$cityId]['full_total'] = 0;
                    $tmpData[$cityId]['no_member_total'] = 0;

                    //市区存在，省份一定存在，如果市区不存在，省份也可能存在
                    if (!array_key_exists($provinceId, $tmpData)) {
                        //初始化省份默认值
                        $tmpData[$provinceId]['region_id'] = $provinceId;
                        $tmpData[$provinceId]['type'] = 1;
                        $tmpData[$provinceId]['pid'] = C('CHINA_NUM');
                        $tmpData[$provinceId]['total'] =  1;
                        $tmpData[$provinceId]['member_total'] = 0;
                        $tmpData[$provinceId]['closed_total'] = 0;
                        $tmpData[$provinceId]['full_total'] = 0;
                        $tmpData[$provinceId]['no_member_total'] = 0;
                    } else {
                        $tmpData[$provinceId]['total'] += 1;
                    }

                    //是会员
                    if ( $cemetory['status'] == 1 && $cemetory['member_status'] > 0) {
                        $tmpData[$cityId]['member_total'] = 1;
                        if (array_key_exists($provinceId, $tmpData)) {
                            $tmpData[$provinceId]['member_total'] += 1;
                        } else {
                            $tmpData[$provinceId]['member_total'] = 1;
                        }
                    }
                    //不是会员，但是正常显示，即：非会员
                    if ($cemetory['status'] == 1 && $cemetory['member_status'] == 0) {
                        $tmpData[$cityId]['no_member_total'] = 1;
                        if (array_key_exists($provinceId, $tmpData)) {
                            $tmpData[$provinceId]['no_member_total'] += 1;
                        } else {
                            $tmpData[$provinceId]['no_member_total'] = 1;
                        }
                    }
                    //不管是不是会员 可以正常显示，但是墓位已经满了
                    if ($cemetory['status'] == 2) {
                        $tmpData[$cityId]['full_total'] = 1;
                        if (array_key_exists($provinceId, $tmpData)) {
                            $tmpData[$provinceId]['full_total'] += 1;
                        } else {
                            $tmpData[$provinceId]['full_total'] = 1;
                        }
                    }
                    //不管是不是会员 ，但是数据已经删除
                    if ($cemetory['status'] == -1) {
                        $tmpData[$cityId]['closed_total'] = 1;
                        if (array_key_exists($provinceId, $tmpData)) {
                            $tmpData[$provinceId]['closed_total'] += 1;
                        } else {
                            $tmpData[$provinceId]['closed_total'] = 1;
                        }
                    }
                } else {
                    $tmpData[$cityId]['total'] += 1;
                    $tmpData[$provinceId]['total'] +=  1;
                    //是会员
                    if ($cemetory['status'] == 1 && $cemetory['member_status'] >0) {
                        $tmpData[$cityId]['member_total'] += 1;
                        $tmpData[$provinceId]['member_total'] += 1;
                    }
                    //不是会员，但是正常显示，即：非会员
                    if ($cemetory['status'] == 1 && $cemetory['member_status'] == 0) {
                        $tmpData[$cityId]['no_member_total'] += 1;
                        $tmpData[$provinceId]['no_member_total'] += 1;
                    }
                    //不管是不是会员 可以正常显示，但是墓位已经满了
                    if ($cemetory['status'] == 2) {
                        $tmpData[$cityId]['full_total'] += 1;
                        $tmpData[$provinceId]['full_total'] += 1;
                    }
                    //不管是不是会员 ，但是数据已经删除
                    if ($cemetory['status'] == -1) {
                        $tmpData[$cityId]['closed_total'] += 1;
                        $tmpData[$provinceId]['closed_total'] += 1;
                    }
                }
            }//end foreach $cemetoryData
            
            $datas = array();
            //组装地区名称
            $i = 0;
            foreach ($regionData as $rId => $rData) {
                if ($rId == C('CHINA_NUM')) {
                    continue;
                }
                //陵园
                if (array_key_exists($rId, $tmpData)) {
                    $datas[$i]['region_id'] = $rId;
                    $datas[$i]['region_name'] = $rData['region_name'];
                    $datas[$i]['type'] =$tmpData[$rId]['type'];
                    $datas[$i]['pid'] = $tmpData[$rId]['pid'];
                    $datas[$i]['total'] = $tmpData[$rId]['total'];
                    $datas[$i]['no_member_total'] = $tmpData[$rId]['no_member_total'];
                    $datas[$i]['member_total'] = $tmpData[$rId]['member_total'];
                    $datas[$i]['closed_total'] = $tmpData[$rId]['closed_total'];
                    $datas[$i]['full_total'] = $tmpData[$rId]['full_total'];
                } else {
                    $datas[$i]['region_id'] = $rId;
                    $datas[$i]['region_name'] = $rData['region_name'];
                    $datas[$i]['type'] = 1;
                    $datas[$i]['pid'] = $rData['pid'];
                    $datas[$i]['total'] = 0;
                    $datas[$i]['no_member_total'] = 0;
                    $datas[$i]['member_total'] = 0;
                    $datas[$i]['closed_total'] = 0;
                    $datas[$i]['full_total'] = 0;
                }
                $datas[$i]['sort'] = $rId;
                $datas[$i]['created_time'] = date("Y-m-d H:i:s", time());
                $i++;
            }
            //最终的数据录入到数据库中 完成之后跳转到显示页面   storeDistribute
            /**
             * 注意：在addAll 方法中，一唯下标要从0开始，否则无法插入
             * 二位数组的下标名称一定都要和数据库字段顺序一直，否则插入的数据会出现问题
             * 插入数据之前先清空表
             */
            $result = array('flag'=>0,'msg'=>'操作失败！');
            M('store_state')->where("type=1")->delete();
            if (!empty($datas)) {
                if (M('store_state') -> addAll($datas)) {
                    $result = array('flag'=>1,'msg'=>'操作成功！');
                } 
            }
            echo json_encode($result);
        }
        /**
        * 陵园地区分布
        * @return void
        */
        public function storeDistribute() {
            $data = M('store_state') ->where('type = 1')-> select();
            $cemetorys = getTree($data, C('CHINA_NUM'));
            $this->assign('cemetorys', $cemetorys);
            $this->display();
        }
        
        /**
     * 各省分布柱状图（默认为陵园）
         * @param $type 类型(如：1为陵园 2为殡仪馆)
         * @param $type 类型名字
     * @return void
     */
        public function storeCharts($type=1,$typeName='陵园') {
            $provinces = array();
            $memberData = array();
            $members = array(
                'name' =>'会员',
                'data' => array()
            );
            $noMembers = array(
                'name'=>'非会员',
                'data' => array()
            );
            $where['pid'] = C('CHINA_NUM');
            $where['type'] = $type;//陵园
            $storeStateData = M('store_state') -> field("region_id, region_name, no_member_total, member_total, closed_total, full_total")->where($where)->select();

            $i = 0;
            if ($storeStateData) {
                foreach ($storeStateData as $storeVal) {
                    $provinces[$i] = $storeVal['region_name'];
                    $members['data'][$i] = (int)$storeVal['member_total'];
                    $noMembers['data'][$i] = (int)$storeVal['no_member_total'];
                    $i++;
                }
            }
            $memberData[] = $members;
            $memberData[] = $noMembers;
            $provincesStr = json_encode($provinces);
            $provinceVal = json_encode($memberData);
            $this->assign("provincesStr", $provincesStr);
            $this->assign("provinceVal", $provinceVal);
            $this->assign('typeName',$typeName);
            $this->display('storeCharts');
        }
         /**
         * 殡仪馆商家分布统计，运行完成之后会跳转到殡仪馆商家分布列表
         * @return void
         */
        public function funeralStoreStat() {
            //获取地区表的数据
            $regionData = M('region')->where('state ='.C('NORMAL_STATUS'))->getField('region_id, region_name, pid');
            //根据地区表的数据进行商家统计(只统计殡仪馆)
            $funeralData = M('store') ->field(' province_id, city_id, status, member_status') -> where('category_id = '.C('CATEGORY_FUNERAL_ID'))-> select();
            //组装数据
            $tmpFuneralData = array();
            foreach($funeralData as $k=> $funeral) {
                $provinceId = trim($funeral['province_id']);
                $cityId = trim($funeral['city_id']);
                
                if(array_key_exists($cityId, $tmpFuneralData)){
                    $tmpFuneralData[$cityId]['total'] += 1;
                    //非会员
                    if($funeral['status'] == 1 && $funeral['member_status'] == 0){
                        $tmpFuneralData[$cityId]['no_member_status'] += 1;
                    }
                    //会员
                    if($funeral['status'] == 1 && $funeral['member_status']>0){
                        $tmpFuneralData[$cityId]['member_status'] += 1;
                    }
                    //关闭
                    if($funeral['status'] == C('DELETE_STATUS')){
                        $tmpFuneralData[$cityId]['closed_status'] += 1;
                    }
                }else{
                    $tmpFuneralData[$cityId]['total'] = 1;
                    $tmpFuneralData[$cityId]['pid'] = $provinceId;
                    //初始化
                    $tmpFuneralData[$cityId]['no_member_status'] = 0;
                    $tmpFuneralData[$cityId]['member_status'] = 0;
                    $tmpFuneralData[$cityId]['closed_status'] = 0;
                    //非会员
                    if($funeral['status'] == 1 && $funeral['member_status'] == 0){
                        $tmpFuneralData[$cityId]['no_member_status'] = 1;
                    }
                    //会员
                    if($funeral['status'] == 1 && $funeral['member_status']>0){
                        $tmpFuneralData[$cityId]['member_status'] = 1;
                    }
                    //关闭
                    if($funeral['status'] == C('DELETE_STATUS')){
                        $tmpFuneralData[$cityId]['closed_status'] = 1;
                    }
                }
                //判断省份
                if(array_key_exists($provinceId,$tmpFuneralData)){
                    $tmpFuneralData[$provinceId]['total'] += 1;
                    //非会员
                    if($funeral['status'] == 1 && $funeral['member_status'] == 0){
                        $tmpFuneralData[$provinceId]['no_member_status'] += 1;
                    }
                    //会员
                    if($funeral['status'] == 1 && $funeral['member_status']>0){
                        $tmpFuneralData[$provinceId]['member_status'] += 1;
                    }
                    //关闭
                    if($funeral['status'] == C('DELETE_STATUS')){
                        $tmpFuneralData[$provinceId]['closed_status'] += 1;
                    }
                }else{
                    $tmpFuneralData[$provinceId]['total'] = 1;
                    $tmpFuneralData[$provinceId]['pid'] = C('CHINA_NUM');
                    //初始化
                    $tmpFuneralData[$provinceId]['no_member_status'] = 0;
                    $tmpFuneralData[$provinceId]['member_status'] = 0;
                    $tmpFuneralData[$provinceId]['closed_status'] = 0;
                    //非会员
                    if($funeral['status'] == 1 && $funeral['member_status'] == 0){
                        $tmpFuneralData[$provinceId]['no_member_status'] = 1;
                    }
                    //会员
                    if($funeral['status'] == 1 && $funeral['member_status']>0){
                        $tmpFuneralData[$provinceId]['member_status'] = 1;
                    }
                    //关闭
                    if($funeral['status'] == C('DELETE_STATUS')){
                        $tmpFuneralData[$provinceId]['closed_status'] = 1;
                    }
                }
            }//end foreach $funeralData
            $funeraldatas = array();
            //组装地区名称
            $i = 0;
            foreach ($regionData as $rId => $rData) {
                if ($rId == C('CHINA_NUM')) {
                    continue;
                }
                //殡仪馆
                if(array_key_exists($rId,$tmpFuneralData)){
                    $funeralDatas[$i]['region_id'] = $rId;
                    $funeralDatas[$i]['region_name'] = $rData['region_name'];
                    $funeralDatas[$i]['type'] = 2;
                    $funeralDatas[$i]['pid'] = $tmpFuneralData[$rId]['pid'];
                    $funeralDatas[$i]['total'] = $tmpFuneralData[$rId]['total'];
                    $funeralDatas[$i]['no_member_total'] =$tmpFuneralData[$rId]['no_member_status'];
                    $funeralDatas[$i]['member_total'] =$tmpFuneralData[$rId]['member_status'];
                    $funeralDatas[$i]['closed_total'] =$tmpFuneralData[$rId]['closed_status'];
                }else{
                    $funeralDatas[$i]['region_id'] = $rId;
                    $funeralDatas[$i]['region_name'] = $rData['region_name'];
                    $funeralDatas[$i]['type'] = 2;
                    $funeralDatas[$i]['pid'] = $rData['pid'];
                    $funeralDatas[$i]['total'] = 0;
                    $funeralDatas[$i]['no_member_total'] =0;
                    $funeralDatas[$i]['member_total'] =0;
                    $funeralDatas[$i]['closed_total'] =0;
                }
                $funeralDatas[$i]['created_time'] = date("Y-m-d H:i:s", time());
                $i++;
            }
            /**
             * 注意：在addAll 方法中，一唯下标要从0开始，否则无法插入
             * 二位数组的下标名称一定都要和数据库字段顺序一直，否则插入的数据会出现问题
             * 插入数据之前先清空表
             */
            $result = array('flag'=>0,'msg'=>'操作失败！');
            M('store_state')->where("type=2")->delete();
            if (!empty($funeralDatas)) {
                if (M('store_state') -> addAll($funeralDatas)) {
                    $result = array('flag'=>1,'msg'=>'操作成功！');
                } 
            }
            echo json_encode($result);
        }
         /**
        * 殡仪馆地区分布
        * @return void
        */
        public function funeralDistribute() {
            $data = M('store_state')->where('type=2')->select();
            //dump($data);die;
            $datas = getTree($data, C('CHINA_NUM'));
            $this->assign('datas', $datas);
            //dump($datas);die;
            $this->display();
        }

        
        /*
         * 殡仪馆柱形状图
         * @return void
         */
        public function funeralCharts(){
            //$this->storeCharts(2,'殡仪馆');
  
            $noMembers = array(
                'name'=>'非会员',
                'data' => array()
            );
            $where['pid'] = C('CHINA_NUM');
            $where['type'] = 2;//殡仪馆
            $storeStateData = M('store_state') -> field("region_id, region_name, no_member_total, member_total, closed_total, full_total")->where($where)->select();
            $i = 0;
            if ($storeStateData) {
                foreach ($storeStateData as $storeVal) {
                    $provinces[$i] = $storeVal['region_name'];
                    $noMembers['data'][$i] = (int)$storeVal['no_member_total'];
                    $i++;
                }
            }
            $memberData[] = $noMembers;
            $provincesStr = json_encode($provinces);
            $provinceVal = json_encode($memberData);
            $this->assign("provincesStr", $provincesStr);
            $this->assign("provinceVal", $provinceVal);
            $this->display();
        }
        
 

    /**
     * 购墓订单统计
     */
    public function tombOrder(){
        // $where['status'] = array('in',array(10,2,3,4,30));
        $where = $this->timeWhere('created_time');
        if(session('email') != C('ADMIN_EMAIL')){
            $where['order_flow_id'] = session('admin_id');
        }
        $orderGrave = M('OrderGrave');
        $fields = 'id,status,province_id,city_id,created_time,order_flow_id,send_finance_status,apply_return_status';
        $orderData = $orderGrave->where($where)->field($fields)->select();
        $orderInfo = array();
        $mouths = array('1','2','3','4','5','6','7','8','9','10','11','12');
        foreach ($orderData as $key => $val) {
            if(array_key_exists($val['order_flow_id'], $orderInfo)){
                $orderInfo[$val['order_flow_id']]['order_total'] += 1;
                if($val['status'] == C('ORDER_STATUS.SUCCESS')|| $val['status'] == C('ORDER_STATUS.STOP')){// 完成订单
                    $orderInfo[$val['order_flow_id']]['order_success_total'] += 1;
                }else if($val['status'] == C('ORDER_STATUS.INTERESTING')){// 有意向订单
                    $orderInfo[$val['order_flow_id']]['order_interesting_total'] += 1;
                }else if($val['status'] == C('ORDER_STATUS.CHECK_SUCCESS') && $val['send_finance'] == C('SEND_TO_FINANCE.SUCCESS')){// 待支付订单
                    $orderInfo[$val['order_flow_id']]['order_sendtofinance_total'] += 1;
                }else if($val['status'] == C('ORDER_STATUS.GET_MONEY') && $val['apply_return'] == C('APPLY_RETURN_STATUS.OK_CHECK_RETURN_STATUS')){// 待返现订单
                    $orderInfo[$val['order_flow_id']]['order_waitbackmoney_total'] += 1;
                }else if($val['status'] == C('ORDER_STATUS.BACK_SUCCESS') ||$val['status'] == C('ORDER_STATUS.ALLOW')){// 退单
                    $orderInfo[$val['order_flow_id']]['order_back_total'] += 1;
                }else if($val['status'] == C('ORDER_STATUS.DEFAULT')){// 默认订单
                    $orderInfo[$val['order_flow_id']]['order_default_total'] += 1;
                }else if($val['status'] == C('ORDER_STATUS.FAIL')){// 删除订单
                    $orderInfo[$val['order_flow_id']]['order_fail_total'] += 1;
                }
            }else{
                $orderInfo[$val['order_flow_id']]['order_total'] = 1;
                $orderInfo[$val['order_flow_id']]['order_success_total'] = 0;
                $orderInfo[$val['order_flow_id']]['order_interesting_total'] = 0;
                $orderInfo[$val['order_flow_id']]['order_sendtofinance_total'] = 0;
                $orderInfo[$val['order_flow_id']]['order_waitbackmoney_total'] = 0;
                $orderInfo[$val['order_flow_id']]['order_back_total'] = 0;
                $orderInfo[$val['order_flow_id']]['order_default_total'] = 0;
                $orderInfo[$val['order_flow_id']]['order_fail_total'] = 0;

                if($val['status'] == C('ORDER_STATUS.SUCCESS')||$val['status'] == C('ORDER_STATUS.STOP')){// 完成订单
                    $orderInfo[$val['order_flow_id']]['order_success_total'] = 1;
                }else if($val['status'] == C('ORDER_STATUS.INTERESTING')){// 意向订单
                    $orderInfo[$val['order_flow_id']]['order_interesting_total'] = 1;
                }else if($val['status'] == C('ORDER_STATUS.CHECK_SUCCESS') && $val['send_finance'] == C('SEND_TO_FINANCE.SUCCESS')){// 待支付订单
                    $orderInfo[$val['order_flow_id']]['order_sendtofinance_total'] = 1;
                }else if($val['status'] == C('ORDER_STATUS.GET_MONEY') && $val['apply_return'] == C('APPLY_RETURN_STATUS.OK_CHECK_RETURN_STATUS')){// 待返现订单
                    $orderInfo[$val['order_flow_id']]['order_waitbackmoney_total'] = 1;
                }else if($val['status'] == C('ORDER_STATUS.BACK_SUCCESS') ||$val['status'] == C('ORDER_STATUS.ALLOW')){// 退单
                    $orderInfo[$val['order_flow_id']]['order_back_total'] = 1;
                }else if($val['status'] == C('ORDER_STATUS.DEFAULT')){// 默认订单
                    $orderInfo[$val['order_flow_id']]['order_default_total'] = 1;
                }else if($val['status'] == C('ORDER_STATUS.FAIL')){// 删除订单
                    $orderInfo[$val['order_flow_id']]['order_fail_total'] = 1;
                }
            }
            // 用于highcharts数据
            $mouthId = date('m',$val['created_time']);
            if(in_array($mouthId,$mouths)){
                $orderTmp[$val['status']][(int)$mouthId] += 1;
            }else{
                $orderTmp[$val['status']][(int)$mouthId] = 0;
            }
        }
        
        foreach ($orderTmp as $k => $v) {
            foreach ($mouths as $a => $b) {
                // 月份
                $categories[$a] = $this->getMouth($b);
                $datas[$k][$b] = $v[$b];
                if($orderTmp[$k][$b] == null){
                    $datas[$k][$b] = 0;
                }
            }
        }
        // foreach ($datas as $x => $y) {
        //     foreach ($y as $ids => $sumData) {
        //         if($sumData != 0){
        //             foreach ($sumData as $uId => $nums) {
        //                $userNums[$x][$ids][$uId] = $admin[$uId].':'.$nums;
        //             }
        //         }
        //         $rets[$ids] = array_sum($sumData);
        //     }
        //     $name = $this->getStatusMsg($x);
        //     $tmp[$x][$ids][$uId] = implode(',',$userNums);
        //     $series[] = array('name'=>$name,'data'=>array_values($y));
        // }

        foreach ($datas as $x => $y) {
            $name = $this->getStatusMsg($x);
            $series[] = array('name'=>$name,'data'=>array_values($y));
        }

        $admin = M('admin')->getField('id,nickname');
        $this->user = $admin;
        $this->orderInfo = $orderInfo;
        $this->series = json_encode($series);
        $this->categories = json_encode($categories);
        $this->display();
    }

    /**
     * 获取月份英文
     * @param  int $num 月份数字
     * @return string|array
     */
    private function getMouth($num){
        $mouthArr = array(
            1  => "Jan",
            2  => "Feb",
            3  => "Mar",
            4  => "Apr",
            5  => "May",
            6  => "Jun",
            7  => "Jul",
            8  => "Aug",
            9  => "Sep",
            10 => "Oct",
            11 => "Nov",
            12 => "Dec"
        );

        return $mouthArr[$num];
    }

    /**
     * 订单状态的中文解释
     * @param  int $status 订单状态
     * @return string|array
     */
    private function getStatusMsg($status){
        $arr = array(
            -1 => '删除',
            0  => '订单生成成功',
            1  => '订单完成',
            2  => '有意向',
            3  => '审核成功待收佣金',
            4  => '收到佣金待返现',
            5  => '返现成功',
            10 => '达成交易',
            11 => '不允许退单',
            21 => '申请退单待审核',
            22 => '申请退单审核通过', 
            30 => '退单完成',
            31 => '购墓成功与平台无关'
        );

        return $arr[$status];
    }

    /**订单在各省分布状况**/
    public function orderBrokerage(){
        $where = $this->timeWhere('created_time');
        //封装搜索地区
        $search_province_id = I('regionData');
        if(!empty($search_province_id)){
            $where['province_id'] = array('in',$search_province_id); 
        }
        $OrderData = M('OrderGrave')->field('province_id,status,apply_return_status,send_finance_status')->where($where)->select();
        //dump($OrderData);die;
        $lastData = array(); 
        foreach($OrderData as $lastDatas){  
            if(array_key_exists($lastDatas['province_id'], $lastData)){
                $lastData[$lastDatas['province_id']]['order_total'] += 1;
                if($lastDatas['status'] == C('ORDER_STATUS.SUCCESS')){//完成
                    $lastData[$lastDatas['province_id']]['order_status_success_total'] +=1; 

                }else if($lastDatas['status'] == C('ORDER_STATUS.INTERESTING')){//有意向
                    $lastData[$lastDatas['province_id']]['order_status_interesting_total'] +=1; 

                

                }else if($lastDatas['status'] == C('ORDER_STATUS.BACK_SUCCESS')){//退单完成
                    $lastData[$lastDatas['province_id']]['order_status_back_total'] +=1;

                }else if($lastDatas['status'] ==C('ORDER_STATUS.CHECK_SUCCESS') && $lastDatas['send_finance_status'] == C('SEND_TO_FINANCE.SUCCESS')){//陵园待支付
                    $lastData[$lastDatas['province_id']]['order_status_sendtofinance_total'] +=1;

                }else if($lastDatas['status'] == C('ORDER_STATUS.GET_MONEY') && $lastDatas['apply_return_status'] == C('APPLY_RETURN_STATUS.OK_CHECK_RETURN_STATUS')){//陵园待返现
                    $lastData[$lastDatas['province_id']]['order_status_waitbackmoney_total'] +=1;
                }

            }else{

                $lastData[$lastDatas['province_id']]['order_total'] = 1;
                $lastData[$lastDatas['province_id']]['order_status_success_total'] =0; 
                $lastData[$lastDatas['province_id']]['order_status_interesting_total'] =0; 
                $lastData[$lastDatas['province_id']]['order_status_fail_total'] =0;
                $lastData[$lastDatas['province_id']]['order_status_back_total'] =0;
                $lastData[$lastDatas['province_id']]['order_status_sendtofinance_total'] =0;
                $lastData[$lastDatas['province_id']]['order_status_waitbackmoney_total'] =0;
                if($lastDatas['status'] == C('ORDER_STATUS.SUCCESS')){//完成
                    $lastData[$lastDatas['province_id']]['order_status_success_total'] =1; 

                }else if($lastDatas['status'] == C('ORDER_STATUS.INTERESTING')){//有意向
                    $lastData[$lastDatas['province_id']]['order_status_interesting_total'] =1; 

                }else if($lastDatas['status'] == C('ORDER_STATUS.FAIL')){//无效订单
                    $lastData[$lastDatas['province_id']]['order_status_fail_total'] =1;

                }else if($lastDatas['status'] == C('ORDER_STATUS.BACK_SUCCESS')){//退单完成
                    $lastData[$lastDatas['province_id']]['order_status_back_total'] =1;

                }else if($lastDatas['status'] ==C('ORDER_STATUS.CHECK_SUCCESS') && $lastDatas['send_finance_status'] == C('SEND_TO_FINANCE.SUCCESS')){//陵园待支付

                    $lastData[$lastDatas['province_id']]['order_status_sendtofinance_total'] =1;

                }else if($lastDatas['status'] ==C('ORDER_STATUS.GET_MONEY') && $lastDatas['apply_return_status'] == C('APPLY_RETURN_STATUS.OK_CHECK_RETURN_STATUS')){//陵园待返现
                    $lastData[$lastDatas['province_id']]['order_status_waitbackmoney_total'] =1;

                }
            }
        }

        //查找地区
        $regionData = $this->getRegionData(array('state'=>C('NORMAL_STATUS'),'level = 1'),array('region_id,region_name'),'',true);

        //组装数据
        foreach($lastData as $k=>$a){
            $infoName[] = $regionData[$k];
            $infoValue['order_total'][] = $a['order_total'];
            $infoValue['order_status_success_total'][] = $a['order_status_success_total'];
            $infoValue['order_status_fail_total'][] = $a['order_status_fail_total'];
            $infoValue['order_status_interesting_total'][] = $a['order_status_interesting_total'];
            $infoValue['order_status_back_total'][] = $a['order_status_back_total'];
            $infoValue['order_status_sendtofinance_total'][] = $a['order_status_sendtofinance_total'];
            $infoValue['order_status_waitbackmoney_total'][] = $a['order_status_waitbackmoney_total'];
        }

        $infoTotal = json_encode(array(array('name'=>'订单总数','data'=>$infoValue['order_total']),array('name'=>'订单成功总数','data'=>$infoValue['order_status_success_total']),array('name'=>'有意向订单总数','data'=>$infoValue['order_status_interesting_total']),array('name'=>'待支付订单','data'=>$infoValue['order_status_sendtofinance_total']),array('name'=>'待返现订单','data'=>$infoValue['order_status_waitbackmoney_total']),array('name'=>'退单数','data'=>$infoValue['order_status_back_total'])));
        $infoName = json_encode($infoName);
        $this->assign('infoName',$infoName);
        $this->assign('infoTotal',$infoTotal);
        $this->assign('search_province_id',$search_province_id);
        $this->assign('regionData',$regionData);
        $this->assign('lastData',$lastData);
        $this->assign('selectAll',I('selectAll'));
        $this->display();

    }



    /**
     * 各省购墓成交额
     */
    public function storeOrderState(){
        $where = $this->timeWhere('created_time');
        //封装搜索地区
        $search_province_id = I('regionData');
        
        if(!empty($search_province_id)){
            $where['province_id'] = array('in',$search_province_id); 
        }
        //$where['status'] = array('in',array(C('ORDER_STATUS.SUCCESS'),C('ORDER_STATUS.STOP'),C('ORDER_STATUS.BACK_SUCCESS')));
        $where['status'] = array('egt',C('ORDER_STATUS.CHECK_SUCCESS'));
        $datas = M('OrderGrave')->field('tomb_price,return_fact_money,paid_in_amount,status,province_id')->where($where)->select();
        
        $lastData = array();
        foreach($datas as $lastDatas){
            if(array_key_exists($lastDatas['province_id'], $lastData)){
                $lastData[$lastDatas['province_id']]['order_total'] +=1;//总量
                if(!empty($lastDatas['paid_in_amount'])){//有收入订单
                    $lastData[$lastDatas['province_id']]['order_status_get_money'] +=1;
                }   
                $lastData[$lastDatas['province_id']]['brokerage_total'] += floatval($lastDatas['paid_in_amount']);
                $lastData[$lastDatas['province_id']]['return_pesent_total'] += floatval($lastDatas['return_fact_money']);
                $lastData[$lastDatas['province_id']]['tomb_price_total'] += floatval($lastDatas['tomb_price']);
            }else{
                $lastData[$lastDatas['province_id']]['order_total'] = 1; //总订单数
                if(!empty($lastDatas['paid_in_amount'])){//有收入订单
                    $lastData[$lastDatas['province_id']]['order_status_get_money'] =1;
                }
                $lastData[$lastDatas['province_id']]['brokerage_total'] = floatval($lastDatas['paid_in_amount']);//总佣金金额
                $lastData[$lastDatas['province_id']]['return_pesent_total'] = floatval($lastDatas['return_fact_money']);//总返现金额
                $lastData[$lastDatas['province_id']]['tomb_price_total'] = floatval($lastDatas['tomb_price']);//总墓价金额   
            }
        }
        
        //查找地区
        $regionData = $this->getRegionData(array('state'=>C('NORMAL_STATUS'),'level = 1'),array('region_id,region_name'),'',true);
        
        //组装highchart数据
        foreach($lastData as $k=>$a){
            $infoName[] = $regionData[$k];
            $infoValue['order_total'][] = $a['order_total'];
            $infoValue['order_status_get_money'][] = $a['order_status_get_money'];
        }
        $infoTotal = json_encode(array(array('name'=>'订单总数','data'=>$infoValue['order_total']),array('name'=>'有收入订单总数','data'=>$infoValue['order_status_get_money'])));
        $infoName = json_encode($infoName);
        $this->assign('infoName',$infoName);
        $this->assign('infoTotal',$infoTotal);
        $this->assign('search_province_id',$search_province_id);
        $this->assign('regionData',$regionData);
        $this->assign('lastData',$lastData);
        $this->assign('selectAll',I('selectAll'));
        $this->display();
    }


    /**
     * 平台购墓收支统计
     */
    public function cemeteryIncomeExpenditure(){
        $list = array();
        $order = M('orderGrave');
        $where = $this->timeWhere('success_time');
        //$where = $this->timeWhere('created_time');
        $where['status'] = array('eq',C('ORDER_STATUS.SUCCESS'));
        $amount_cemetery = $order->where($where)->field('paid_in_amount,return_fact_money,tomb_price')->select();
       
        //初始化数据
        $list['money']['cemetery_income'] = 0;
        $list['money']['cemetery_expenditure'] = 0;
        $list['money']['total_amount_order'] = 0;
        foreach ($amount_cemetery as $key => $value) {
            $list['money']['cemetery_income'] += $value['paid_in_amount']; //佣金总金额
            $list['money']['cemetery_expenditure'] += $value['return_fact_money']; //返现总金额
            $list['money']['total_amount_order'] += $value['tomb_price'];  //订单总金额
        }
        $list['money']['cemetery_surplus'] = $list['money']['cemetery_income'] - $list['money']['cemetery_expenditure'];//购墓盈余
        $list['money']['other_expenditure'] = 0; //其他支出

        //饼状图
        $name = array('total_amount_order'=>'订单总金额','cemetery_income'=>'佣金金额','cemetery_expenditure'=>'返现金额','other_expenditure'=>'其他支出','cemetery_surplus'=>'盈余');
        foreach ($list['money'] as $key => $value) {
            $incomeExpenditure[] = array($name[$key],$value);
        }
        $cemeteryIncome = json_encode($incomeExpenditure);
        
        $this->assign('cemeteryIncome',$cemeteryIncome);
        $this->assign('list',$list);
        $this->display();

    }

    /**
     * 各省购墓订单收支统计
     */
    public function provinceIncomeExpenditure(){
        $order = D('orderGrave');
        $where = $this->timeWhere('success_time');
        $arr = array(C('ORDER_STATUS.SUCCESS'),C('ORDER_STATUS.CHECK_SUCCESS'),C('ORDER_STATUS.GET_MONEY'));
        $where['status'] = array('in',$arr);
        $province = I('province_id');
        if($province){
            $where['province_id'] = array('eq',$province);
        }

        //获取省信息
        $regionData = M('region')->where('pid =2')->getField('region_id, region_name, pid');

        $province_order = $order->where($where)->relation('Analysis_province_name')->field('paid_in_amount,return_fact_money,return_money,tomb_price,province_id,brokerage_money,status')->select();

        foreach ($province_order as $key => $v) {
            if ($v['status'] == C('ORDER_STATUS.CHECK_SUCCESS')){
                $wait_income = $v['brokerage_money'];
            }else{
                $wait_income = 0;
            }
            if ($v['status'] == C('ORDER_STATUS.GET_MONEY')){
                $wait_expenditure = $v['return_money'];
            }else{
                $wait_expenditure = 0;
            }
            if(array_key_exists($v['province_id'],$provinceIncome)){
                $provinceIncome[$v['province_id']] = array(
                    'proname'=>$v['Analysis_province_name']['region_name'],
                    'total_amount_order'=> $provinceIncome[$v['province_id']]['total_amount_order'] + $v['tomb_price'],
                    'province_income'=> $provinceIncome[$v['province_id']]['province_income'] + $v['paid_in_amount'],
                    'province_expenditure'=> $provinceIncome[$v['province_id']]['province_expenditure'] + $v['return_fact_money'],
                    'other_expenditure' => 0,
                    'province_surplus' => ($provinceIncome[$v['province_id']]['province_income']) - ($provinceIncome[$v['province_id']]['province_expenditure']) - $provinceIncome[$v['province_id']]['other_expenditure'],
                    'wait_income'=> $provinceIncome[$v['province_id']]['wait_income'] + $wait_income,
                    'wait_expenditure'=> $provinceIncome[$v['province_id']]['wait_expenditure'] + $wait_expenditure,
                    );

            }else{
                $provinceIncome[$v['province_id']] = array('proname'=>$v['Analysis_province_name']['region_name'],
                    'total_amount_order'=>$v['tomb_price'],
                    'province_income' => $v['paid_in_amount'],
                    'province_expenditure'=>$v['return_fact_money'],
                    'other_expenditure' => 0,
                    'province_surplus' => $v['paid_in_amount'] - $v['return_fact_money'],
                    'wait_income' => $wait_income,
                    'wait_expenditure' => $wait_expenditure
                    );
            }
        }


        //柱状图
        foreach ($provinceIncome as $key => $value) {
            $proName['name'][] = $value['proname'];
            $total_order[] = (float)$value['total_amount_order'];
            $income[] = (float)$value['province_income'];
            $expenditure[] = (float)$value['province_expenditure'];
            $total_expenditure[] = (float)$value['province_expenditure'] + $value['other_expenditure'];
            $total_surplus[] = (float)$value['province_surplus'];
        }
        $provinceData = array(array('name'=>'订单总金额','data'=>$total_order),array('name'=>'总佣金','data'=>$income),
                                array('name'=>'总返现','data'=>$expenditure),array('name'=>'总支出','data'=>$total_expenditure),
                                array('name'=>'总盈利','data'=>$total_surplus)
                                );
        
        $provinceData = json_encode($provinceData);
        $proName = json_encode($proName['name']);

        $this->assign('provinceData',$provinceData);
        $this->assign('proName',$proName);
        $this->assign('provinceIncome',$provinceIncome);
        $this->assign('regionData',$regionData);
        $this->display();
        //dump($provinceIncome);
    }

    /**
     * 平台待返现/待收佣金
     */
    public function waitIncomeExpenditure(){
        $order = D('orderGrave');
        //$where = $this->timeWhere('success_time');
        $province = I('province_id');
        if($province){
            $where['province_id'] = array('eq',$province);
        }
        //获取省信息
        $regionData = M('region')->where('pid =2')->getField('region_id, region_name, pid');

        $arr = array(C('ORDER_STATUS.CHECK_SUCCESS'),C('ORDER_STATUS.GET_MONEY'));
        $where['status'] = array('in',$arr);
        $waitIncomeEx = $order->where($where)->relation('Analysis_province_name')->field('order_grave_sn,buyer,mobile,store_name,tomb_price,brokerage_money,paid_in_amount,return_money,payfor_us_time,success_time,created_time,province_id,status')->select();
       

        //柱状图
        foreach ($waitIncomeEx as $k => $v) {
            if ($v['status'] == C('ORDER_STATUS.CHECK_SUCCESS')){
                $wait_income_number = 1;
            }else{
                $wait_income_number = 0;
            }
            if ($v['status'] == C('ORDER_STATUS.GET_MONEY')){
                $wait_expenditure_number = 1;
            }else{
                $wait_expenditure_number = 0;
            }
            if(array_key_exists($v['province_id'],$list)){
                $list[$v['province_id']] = array(
                    'proname'=>$v['Analysis_province_name']['region_name'],
                    'wait_income_number' =>  $list[$v['province_id']]['wait_income_number'] + $wait_income_number,
                    'wait_expenditure_number' => $list[$v['province_id']]['wait_expenditure_number'] + $wait_expenditure_number
                    );
            }else{
                $list[$v['province_id']] = array(
                    'proname'=>$v['Analysis_province_name']['region_name'],
                    'wait_income_number' => $wait_income_number,
                    'wait_expenditure_number' => $wait_expenditure_number
                );
            }
        }

        foreach ($list as $k => $v) {
            $wait_income[] = $v['wait_income_number'];
            $wait_expenditure[] = $v['wait_expenditure_number'];
            $proName['name'][] = $v['proname'];
        }
        $data = array(array('name'=>'待收佣金','data'=>$wait_income),array('name'=>'待返现','data'=>$wait_expenditure));
        $data = json_encode($data);
        $proName = json_encode($proName['name']);

        $this->assign('data', $data);
        $this->assign('proName', $proName);
        $this->assign('list', $waitIncomeEx);
        $this->display();
    }
    
    /**
     * 导出excel
     * @InputParam $categoryId分类Id   $bool是否为会员 $name名称(如：陵园)
     * return void;
     */
    public function exportExcel(){
        $bool = I('bool');
        $categoryId = I('categoryId');
        $name = I('name');

        $where['status'] = C('NORMAL_STATUS');
        if(!empty($categoryId)){
            $where['category_id'] = $categoryId;
        }
        if($bool == 'true'){
            $where['member_status'] = array('gt',0);
        }

        $storeInfo = D('store')->where($where)->field('store_id,province_id,city_id,store_name,address,member_status,min_price,max_price')->order('province_id asc')->select();
        // 引入PHPExcel
        vendor('PHPExcel.PHPExcel');

        $phpExcel = new \PHPExcel();

        $phpExcel->getProperties()->setCreator('hgy')
            ->setLastModifiedBy('hgy')
            ->setTitle('Office 2007 XLSX Test Document')
            ->setSubject('Office 2007 XLSX Test Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Test result file');

        // 设置行宽度
        $phpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $phpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(23.71);
        $phpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $phpExcel->getActiveSheet()->getColumnDimension('D')->setWidth(62.57);
        $phpExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15.86);
        $phpExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14.71);
        $phpExcel->getActiveSheet()->getColumnDimension('G')->setWidth(14.71);

        // 设置行高度
        $phpExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(22);
        $phpExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);

        // 设置字体
        $styleArray = array(
            'font' => array(
                'bold' => true,
                // 'color' => array('rgb' => 'FF0000'),
                'size' => 15,
                'name' => 'Microsoft YaHei'
            )
        );

        $phpExcel->getActiveSheet()->getCell('A1')->setValue('Some text');
        $phpExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);

        $phpExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);
        $phpExcel->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(true);
        $phpExcel->getActiveSheet()->getStyle('A2:G2')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('A1:G2')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);

        // 设置水平居中
        $phpExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // 合并cell
        $phpExcel->getActiveSheet()->mergeCells('A1:G1');

        // 设置表格标题
        $phpExcel->setActiveSheetIndex(0)
            ->setCellValue('A1',$name.'数据表')
            ->setCellValue('A2','ID')
            ->setCellValue('B2','城市')
            ->setCellValue('C2','名称')
            ->setCellValue('D2','地址')
            ->setCellValue('E2','会员状态')
            ->setCellValue('F2','最低价格(万元)')
            ->setCellValue('G2','最高价格(万元)');

        //获取全国地区
        $regionData = $this->getRegionData('',array('region_id,region_name'),'',true);

        for($i=0;$i<count($storeInfo)-1;$i++){
            $phpExcel->getActiveSheet(0)->setCellValue('A'.($i+3),$storeInfo[$i]['store_id']);
            $phpExcel->getActiveSheet(0)->setCellValue('B'.($i+3),$regionData[$storeInfo[$i]['province_id']].'/'.$regionData[$storeInfo[$i]['city_id']]);
            $phpExcel->getActiveSheet(0)->setCellValue('C'.($i+3),$storeInfo[$i]['store_name']);
            $phpExcel->getActiveSheet(0)->setCellValue('D'.($i+3),$storeInfo[$i]['address']);

            // 判断会员类型
            switch ($storeInfo[$i]['member_status']) {
                case '0':
                    $storeInfo[$i]['member_status'] = "非会员";
                    break;
                // 商家会员
                case C('STOER_MERMBER'):
                    $storeInfo[$i]['member_status'] = C('STOER_MERMBER_MSG');
                    break;
                // 商家会员(无优惠)
                case C('STOER_MERMBER_V'):
                    $storeInfo[$i]['member_status'] = C('STOER_MERMBER_V_MSG');
                    break;
                // 个人会员
                case C('STOER_MERMBER_PERSON'):
                    $storeInfo[$i]['member_status'] = C('STOER_MERMBER_PERSON_MSG');
                    break;
                // 广告会员
                case C('STOER_MERMBER_AD'):
                    $storeInfo[$i]['member_status'] = C('STOER_MERMBER_AD_MSG');
                    break;
                default:
                    break;
            }

            $phpExcel->getActiveSheet(0)->setCellValue('E'.($i+3),$storeInfo[$i]['member_status']);
            $phpExcel->getActiveSheet(0)->setCellValue('F'.($i+3),$storeInfo[$i]['min_price']);
            $phpExcel->getActiveSheet(0)->setCellValue('G'.($i+3),$storeInfo[$i]['max_price']);
            $phpExcel->getActiveSheet()->getStyle('A'.($i+3).':G'.($i+3))->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $phpExcel->getActiveSheet()->getStyle('A'.($i+3).':G'.($i+3))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $phpExcel->getActiveSheet()->getRowDimension($i+3)->setRowHeight(16);
        }

        // sheet命名
        $phpExcel->getActiveSheet()->setTitle($name.'数据表');
        $phpExcel->setActiveSheetIndex(0);

        // excel头参数
        header('Content-Type: application/vnd.ms-excel'); // 生成xls/xlsx文件
        // header('Content-Type: text/csv'); // 生成csv文件

        header('Content-Disposition: attachment;filename="'.$name.'数据('.date('Y-m-d H_i_s').').xls"'); // 后缀名:xls/xlsx/csv

        header('Cache-Control: max-age=0');
        $phpWriter = \PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5'); // Excel5:xls; Excel2007:xlsx; CSV:csv;
        $phpWriter->save('php://output');
    }
    
    /*
     * 商品订单统计分析
     * return viod;
     */
    public function goodsOrderAnalysis(){
        $this->display();
    }
}


