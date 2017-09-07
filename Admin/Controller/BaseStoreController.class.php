<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;
use Think\Page;
/**
 * 商家控制器
 * @author  Wang Qiang <[<wangqiang@huigeyuan.com>]>
 */
class BaseStoreController extends BaseController
{
    /**
     * 陵园列表
     */
    public function cemeteryList(){
        $type = C('CATEGORY_CEMETERY_ID');
        $this->_baseList($type);
        $this->display();
    }

    /**
     * 殡仪馆列表
     */
    public function funeralList(){
        $type = C('CATEGORY_FUNERAL_ID');
        $this->_baseList($type);
        $this->display();
    }

    /**
     * 通过选择省份改变市ajax获取省份ID
     */
    public function getCityList(){
        if (IS_POST) {
            $province_id = I('province_id');
            $regionObj = M("region");
            $data = $regionObj->where("level=2 and pid=" . $province_id)->select();
            $this->ajaxReturn($data, 'JSON');
        } else {
            $this->error('省份ID不存在');
        }
    }

    /**
     * 商家列表的基础类
     * 
     * @param Int $type 商家分类的ID，目前是陵园和殡仪馆
     * 
     * @return void
     */
    private function _baseList(Int $type) {
        $store = D('store');
        $getInfo = I('get.');
        if(isset($getInfo['sname']) && !empty($getInfo['sname'])){
            $where['store_name'] = array('like','%'.$getInfo['sname'].'%');
        }
        if(isset($getInfo['sprovince']) && !empty($getInfo['sprovince'])){
            $where['province_id'] = $getInfo['sprovince'];
        }
        if(isset($getInfo['scity']) && !empty($getInfo['scity'])){
            $where['city_id'] = $getInfo['scity'];
        }
        if(isset($getInfo['smemberStatus']) && !empty($getInfo['smemberStatus'])){
            $where['member_status'] = $getInfo['smemberStatus'];
        }
        $where['category_id'] = $type;

        //商家数量
        $count = $store->where($where)->count();

        //接收分页的参数，如果没有值就默认为1
        $p = $getInfo['p'];
        $nowPage = empty($p) ? C('PAGE_DEFAULT') : $p;
        $Page = new Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $fields = 'store_id,store_sn,category_id,store_profiles_id,store_name,province_id,city_id,address,member_status,min_price,max_price,pick_up_address,status,created_time';
        $list = $store->where($where)->field($fields)->relation(array('Province','City'))->limit($Page->firstRow,$Page->listRows)->order('created_time desc')->select();
        $regionWhere['pid'] = C('CHINA_NUM');
        $regionWhere['state'] = C('NORMAL_STATUS');
        $provinceRegion = M('region')->where($regionWhere)->select();

        $cityRegion = array();
        if(!empty($getInfo['sprovince'])){
            $cityRegion = M('region')->where('pid='.$getInfo['sprovince'])->select();
        }

        $this->storeMember = getStoreMember(true,'business');
        $this->province = $provinceRegion;
        $this->city = $cityRegion;
        $this->list = $list;
        $this->nowPage = $nowPage;
        $this->getInfo = $getInfo;
        $this->page = $show;
    }

    /**
     * 添加陵园
     */
    public function addCemetery(){
        $category = C('CATEGORY_CEMETERY_ID');
        $this->_add($category);
    }

    /**
     * 添加殡仪馆
     */
    public function addFuneral(){
        $category = C('CATEGORY_FUNERAL_ID');
        $this->_add($category);
    }

    /**
     * 添加陵园
     */
    private function _add($category){
        if(IS_POST){
            $store = M('store');
            $info = I('post.info');
            $contact = I('post.contact');
            
            //商家的创建和修改时间
            $info['created_time'] = $contact['created_time'] = time();
            $info['updated_time'] = $contact['updated_time'] = time();
            //合同开始时间转化为时间戳
            $info['admin_id'] = isset($_SESSION['admin_id'])? $_SESSION['admin_id'] : 0;
            $contact['admin_id'] = isset($_SESSION['admin_id'])? $_SESSION['admin_id'] : 0;
            /**
             * 上传图片
             */
            $imgArr = $this->_uploadImg('','store_banner');
            $info['store_banner'] = $imgArr['store_banner'];
            $info['store_logo'] = $imgArr['store_logo'];
            $result = $store->data($info)->add();
            if($result){
                $contact['store_id'] = $result;
                if($contact['contact_name']!='' || $contact['mobile']!='' || $contact['tel']!=''){
                    $storeContact = M('StoreContact');
                    $storeContact->add($contact);
                }
                // 判断类型
                if(!empty($info['category_id']) && $info['category_id'] == C('CATEGORY_CEMETERY_ID')){
                    $url = 'cemeteryList';
                    //删除首页缓存文件
                    S(array('prefix'=>C('HOME_CACHE_PREFIX'),'expire'=>C('HOME_CACHE_TIME')));
                    S(C('STORE_RECOMMEND.GEOMANCY').$info['province_id'],NULL);
                    S(C('STORE_RECOMMEND.ENVIRONMENT').$info['province_id'],NULL);
                    S(C('STORE_RECOMMEND.TRANSPORT').$info['province_id'],NULL);
                }else if(!empty($info['category_id']) && $info['category_id'] == C('CATEGORY_FUNERAL_ID')){
                    $url = 'funeralList';
                }
                $this->success('添加成功',U($url));
            }else{
                $this->error('添加失败,请刷新页面尝试操作');
            }
        }else{
            $province = $this->getRegionData('level=1','region_id,region_name,level,pid','',false);
            $city = $this->getRegionData('level=2','region_id,region_name,level,pid','',false);
            if($category == C('CATEGORY_FUNERAL_ID')){
                $this->funerallevels = C('FUNERAL_LEVEL');
            }
            $categoryGroup = M('category')->field('cid,pid,name')->where('pid='.C('CATEGORY_GROUP_ID'))->select();
            $this->categoryGroup = $categoryGroup;
            $this->memberStatus = getStoreMember();
            $this->city = $city;
            $this->province = $province;
            $this->storeProfiles = $storeProfiles;
            $this->display();
        }
    }

    /**
     * 获取合同列表
     */
    public function getProfiles(){
        $getValue = I('get.');
        if(!empty($getValue['province'])){
            $where['province_id'] = $getValue['province'];
            if(!empty($getValue['city'])){
                $where['city_id'] = $getValue['city'];
            }
            // $where['category_id'] = $getValue['category'];
            $where['status'] = C('NORMAL_STATUS');
            $storeProfiles = M('StoreProfiles')->where($where)->field('id,show_store_name')->select();
        }else{
            $storeProfiles = '';
        }

        echo json_encode($storeProfiles);
    }

    /**
     * 获取合同详情数据
     * 
     * @param  int $store_id 合同id
     */
    public function getProfilesDetail($store_id){
        $info = D('StoreProfiles')->relation('StoreProfilesDetail')->where('id='.$store_id)->find();
        $data = $info;
        $data['flag'] = 0;
        if(!empty($info)){
            $data['flag'] = 2;
            if(!empty($data['StoreProfilesDetail'])){
                $i=0;
                foreach ($data['StoreProfilesDetail'] as $key => $val) {
                    $data['StoreProfilesDetail'][$i]['start_time'] = date('Y-m-d',$val['start_time']);
                    $data['StoreProfilesDetail'][$i]['end_time'] = date('Y-m-d',$val['end_time']);
                    $i++;
                }
                $data['flag'] = 1;
            }
        }

        echo json_encode($data);
    }

    //验证商家名称和分类的唯一性
    public function checkStoreName(){
        $postCondition = I('post.');
        $where['store_name'] = $postCondition['store_name'];
        $where['category_id'] = $postCondition['category_id'];
        if(!empty($postCondition['id'])){
            $where['store_id'] = array('neq',$postCondition['id']);
        }
        $store = M('store');
        $info = $store->where($where)->find();
        if($info){
            $result['flag'] = 1;
        }else{
            $result['flag'] = 0;
        }
        echo json_encode($result);
    }

    /**
     * 编辑陵园
     */
    public function editCemetery(){
        $getData = I('get.');
        $category = C('CATEGORY_CEMETERY_ID');
        $this->_edit($getData,$category);
    }

    /**
     * 编辑殡仪馆
     */
    public function editFuneral(){
        $getData = I('get.');
        $category = C('CATEGORY_FUNERAL_ID');
        $this->_edit($getData,$category);
    }

    /**
     * 编辑商家的公共方法
     */
    private function _edit($getData,$category){
        $storeModel = M('store');
        if(IS_POST){
            $data = I('post.info');
            $data['updated_time'] = time();
            $data['store_id'] = $getData['sid'];
            //删除缓存
            S(array('prefix'=>C('HOME_CACHE_PREFIX'),'expire'=>C('HOME_CACHE_TIME')));
            S(C('STORE_RECOMMEND.GEOMANCY').$data['province_id'],NULL);
            S(C('STORE_RECOMMEND.ENVIRONMENT').$data['province_id'],NULL);
            S(C('STORE_RECOMMEND.TRANSPORT').$data['province_id'],NULL);
            /**
             * 上传图片传参store_id删除旧图
             */
            $logo = $this->_uploadImg($getData['sid']);
            if(!empty($logo)){
                $data['store_banner'] = $logo['store_banner'];
                $data['store_logo'] = $logo['store_logo'];
            }
            $ret = $storeModel->data($data)->save();
            if($category == C('CATEGORY_FUNERAL_ID')){
                $url = 'funeralList';
            }else if ($category == C('CATEGORY_CEMETERY_ID')) {
                $url = 'cemeteryList';
            }
            if ($ret) {
                $this->success( '编辑成功！',U($url, array('p'=>$getData['np'], 'sname'=> $getData['sname'], 'sprovince'=>$getData['sprovince'])));
            } else {
                $this->error( '编辑失败！');
            }
        }else{
            if($category == C('CATEGORY_CEMETERY_ID')){
                $this->assign('storeMember',getStoreMember());
            }
            $store = $storeModel->where('store_id='.$getData['sid'])->find();
            if(!empty($store['province_id'])){
                $info['province_id'] = $store['province_id'];
                if(!empty($store['city_id'])){
                    $info['city_id'] = $store['city_id'];
                }
                $profilesList = M('StoreProfiles')->where($info)->field('id,show_store_name')->select();
            }
            $profilesDetail = M('StoreProfilesDetail')->where('id='.$store['store_profiles_id'])->field('id,profiles_id,profile_name')->find();
            $this->assign('profileId',$profilesDetail['profiles_id']);
            $this->assign('profileDetailId',$profilesDetail['id']);
            $this->assign('profilesList',$profilesList);
            $regionWhere['pid'] = C('CHINA_NUM');
            $regionWhere['state'] = C('NORMAL_STATUS');
            $regionObj = M('region');
            // 省份id
            $region = $regionObj->where($regionWhere)->select();
            $this->assign('province',$region);
            // 市区id
            $cities = array();
            if (!empty($store['province_id'])) {
                // 省份id作为pid查出所有市区id
                $cities = $regionObj->where('pid='.$store['province_id'])->select();
            }
            $whereGroup['pid'] = C('CATEGORY_GROUP_ID');
            $categoryGroup = M('category')->field('cid,pid,name')->where($whereGroup)->select();
            $this->assign('cities',$cities);
            $this->assign('categoryGroup',$categoryGroup);
            $this->assign('store',$store);
            $this->assign('storename',$store['store_name']);
            $this->getData = $getData;
            if($category == C('CATEGORY_FUNERAL_ID')){
               $this->assign('funerallevels', C('FUNERAL_LEVEL'));
            }
            $this->display();
        }
    }

    /**
     * 上传图片方法
     */
    private function _uploadImg($storeId=null){
        if ($_FILES['store_banner']['error'] == 0 && !empty($_FILES['store_banner']['tmp_name'])) {
            //上传图片
            $ret = uploadOne('store_banner', C('STORE_IMAGE'),C('STORE_THUMB'),false);
            if(!empty($storeId)){
                $initInfo = M('store')->where('store_id = '.$storeId)->find();
                // 删除图片
                if(!empty($initInfo)){
                    unlink('.'.$initInfo['store_banner']);
                    unlink('.'.$initInfo['store_logo']);
                }
            }
            if ($ret['ok'] == 0) {
                $this->error = $ret['error'];
                return FALSE;
            } else {
                $info['store_banner'] = C('IMG_HOST') . $ret['images'][0];
                $info['store_logo'] = C('IMG_HOST').$ret['images'][1];
            }
        }
        return $info;
    }

    /**
     * 删除商家信息
     */
    public function delStore(){
        $storeId = I('storeId');
        if(!empty($storeId)){
            $data['status'] = C('DELETE_STATUS');
            $adminId = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : 0;
            $data['admin_id'] = $adminId;
            
            $store = M('store');
            $where['store_id'] = $storeId;
            $info = $store->where($where)->find();
            //删除缓存
            S(array('prefix'=>C('HOME_CACHE_PREFIX'),'expire'=>C('HOME_CACHE_TIME')));
            S(C('STORE_RECOMMEND.GEOMANCY').$info['province_id'],NULL);
            S(C('STORE_RECOMMEND.ENVIRONMENT').$info['province_id'],NULL);
            S(C('STORE_RECOMMEND.TRANSPORT').$info['province_id'],NULL);
            
            if($store->where('store_id='.$storeId)->save($data)){
                $result['flag'] = 1;
            }else{
                $result['flag'] = 0;
            }
            echo json_encode($result);
        }
    }

    /**
     * 开始商家信息
     */
    public function startStore(){
        $storeId = I('storeId');
        if(!empty($storeId)){
            $data['status'] = C('NORMAL_STATUS');
            $adminId = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : 0;
            $data['admin_id'] = $adminId;

            $store = M('store');
            $where['store_id'] = $storeId;
            $info = $store->where($where)->find();
            //删除缓存
            S(array('prefix'=>C('HOME_CACHE_PREFIX'),'expire'=>C('HOME_CACHE_TIME')));
            S(C('STORE_RECOMMEND.GEOMANCY').$info['province_id'],NULL);
            S(C('STORE_RECOMMEND.ENVIRONMENT').$info['province_id'],NULL);
            S(C('STORE_RECOMMEND.TRANSPORT').$info['province_id'],NULL);
            
            if($store->where('store_id='.$storeId)->save($data)){
                $result['flag'] = 1;
            }else{
                $result['flag'] = 0;
            }
            echo json_encode($result);
        }
    }

    /**
     * 殡仪馆属性列表
     */
    public function attributesFuneral(){
        $tips = '殡仪馆';
        $listFunc = 'funeralList';
        $this->assign('tips',$tips);
        $this->assign('listFunc',$listFunc);
        $cate = C('CATEGORY_FUNERAL_ID');
        $this->_attrbuteList($cate);
    }
    /**
     * 陵园属性列表
     */
    public function attributesCemetiry(){
        $tips = '陵园';
        $listFunc = 'cemeteryList';
        $this->assign('tips',$tips);
        $this->assign('listFunc',$listFunc);
        $cate = C('CATEGORY_CEMETERY_ID');
        $this->_attrbuteList($cate);
    }

    /**
     * 商家属性列表的核心方法
     */
    private function _attrbuteList($cate){
        $storeId = I('sid');
        $store = M('store');
        $storeAttribute = M('StoreAttribute');
        $Attribute = M('attribute');

        $storeObj = $store->field('category_id,store_name')->where('store_id='.$storeId)->find();

        $count = $storeAttribute->where('store_id='.$storeId)->count();
        $Page = new \Think\Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $storeAttribute->where('store_id='.$storeId)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach($list as $key=>$value){
            $attribute = $Attribute->where('id='.$value['attr_id'])->find();
            $list[$key]['attr_name'] = $attribute['attr_name'];
        }
        $this->assign('storeId',$storeId);
        $this->assign('categoryId',$cate);
        $this->assign('storename',$storeObj['store_name']);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display('BaseStore/attributeList');  
        
    }

    /**
     * 殡仪馆添加/编辑属性
     */
    public function addFuneralAttribute(){
        $cid = C('CATEGORY_FUNERAL_ID');
        $this->_addAttribute($cid);
    }

    /**
     * 陵园添加/编辑属性
     */
    public function addCemeteryAttribute(){
        $cid = C('CATEGORY_CEMETERY_ID');
        $this->_addAttribute($cid);
    }

    /**
     * 商家添加属性的核心方法
     *
     * @return void
     */
    private function _addAttribute($cid){
        $categoryId = $cid;
        $getVal = I('get.');
        if($categoryId){
            $attribute = M('attribute')->where('category_id='.$categoryId)->select();
            $result['attr'] = $attribute;
        }
        //编辑页面
        if($getVal['id']){
            $storeAttr = M('StoreAttribute')->where('id='.$getVal['id'])->find();
            $result['storeAttr'] = $storeAttr;
        }
        echo json_encode($result);
    }

    /**
     * 商家属性数据 数据保存
     *
     * @return void
     */
    public function saveAttribute(){
        $data = I('post.info');
        $storeAttribute = M('StoreAttribute');
        if($data['id']){
            //编辑
            $ret = $storeAttribute->save($data);
            if ($ret) {
                $result['flag'] = 1;
                $result['msg'] = '更新成功';
            } else {
                $result['flag'] = 0;
                $result['msg'] = '更新失败';
            }
        }else{
            //新增
            $ret = $storeAttribute->add($data);
            if($ret){
                $result['flag'] = 1;
                $result['msg'] = '添加成功';
            }else{
                $result['flag'] = 0;
                $result['msg'] = '添加失败';
            }
        }
        echo json_encode($result);
    }
 
    /**
     * 删除商家属性
     */
    public function delAttribute(){
        $attrId = I('id');
        if(!$attrId){
            $this->error('属性ID不存在');
        }
        $storeAttribute = M('StoreAttribute');
        $data['is_enabled'] = C('DELETE_STATUS');
        if($storeAttribute->where('id='.$attrId)->save($data)){
            $result['flg'] = 1;
        }else{
            $result['flg'] = 0;
        }
        echo json_encode($result);
    }

    /**
     * 启用商家属性
     */
    public function enableAttribute(){
        $attrId = I('id');
        if(!$attrId){
            $this->error('属性ID不存在');
        }
        $storeAttribute = M('storeAttribute');
        $data['is_enabled'] = C('NORMAL_STATUS');
        if($storeAttribute->where('id='.$attrId)->save($data)){
            $result['flg'] = 1;
            $result['msg'] = '操作成功！';
        }else{
            $result['flg'] = 0;
            $result['msg'] = '操作失败！';
        }
        echo json_encode($result);
    }

    /*
     * 商家联系人列表
     * 
     */
    public function storeContact(){
        $storeId = I("sid");
        if(empty($storeId)){
            $this->error('操作失败，请重新操作！');
        }
        $p = I('np');
        $sname = I('sname');
        $sprovince = I('sprovince');
        $contact = M('store_contact');
        $result = $contact->where('store_id='.$storeId)->select();
        $storeInfo = M('Store')->field('store_id,store_sn,category_id,store_name')->find($storeId);
        $this->assign('storeInfo',$storeInfo);
        $this->assign('list',$result);
        $this->assign('np',$p);
        $this->assign('sname',$sname);
        $this->assign('sprovince',$sprovince);
        $this->display();
    }
    /**
     * 添加商家联系人
     */
    public function addContact(){
        if(IS_POST){
            $data = I('post.');
            $storeContactModel = M('store_contact');
            if (!empty($data['mobile'])) {
                    $where['mobile'] = $data['mobile'];
            }
            if (!empty($data['tel'])) {
                    $where['tel'] = $data['tel'];
            }
            $contactInfo = $storeContactModel->where($where)->find();
            $data['admin_id'] = $_SESSION['admin_id'];
            $data['status'] = C('NORMAL_STATUS');
            $data['created_time'] = time();
            $data['updated_time'] = time();
            if(!empty($contactInfo)){
                $result['flag'] = 0;
                $result['msg'] = '同一个陵园已经有相同的手机号';
            }else{
                if($storeContactModel->add($data)){
                    $result['flag'] = 1;
                    $result['msg'] = '添加成功';
                }else{
                    $result['flag'] = 0;
                    $result['msg'] = '添加失败';
                }
            }
        }
        echo json_encode($result);
    }
    
    /*
     * 删除开启商家联系人
     */
    public function delContact(){
        $data['id'] = I("post.id");
        $data['status'] = I('post.status');
        $adminId = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : 0;
        $data['admin_id'] = $adminId;
        $result = array('flag'=>'0','msg'=>'操作失败！');
        if(!empty($data['id'])){
            $contact = M("store_contact")->where('id='.$data['id'])->save($data);
            if($contact){
                $result['flag'] = 1;
                $result['msg'] = '操作成功！';
            }
        }
        echo json_encode($result);
    }
    
    /**
     * 编辑商家联系人
     */
    public function editContact(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        if(IS_POST){
            $data = I('post.');
            $storeContactModel = M('StoreContact');
            $contactInfo = $storeContactModel->field('id')->where('id='.$data['id'])->find();
            if($contactInfo){
                $data['admin_id'] = $_SESSION['admin_id'];
                $data['updated_time'] = time();
                if($storeContactModel->save($data)){
                    $result['flag'] = 1;
                    $result['msg'] = '修改成功!';
                }else{
                    $result['flag'] = 0;
                    $result['msg'] = '修改失败!';
                }
            }
        }else{
            $contactId = I('id');
            if(!empty($contactId)){
                $infoContact = M('store_contact')->where('id='.$contactId)->find();
                $infoStore = M('store')->field('store_name')->where('store_id='.$infoContact['store_id'])->find();
                $result = array_merge($infoContact,$infoStore);
                $result['flag'] = 1;
            }
        }
        echo json_encode($result);
    }
    
    /*
     * 商家新闻列表
     * 
     */
    public function storeNew(){
        $storeId = I('sid');
        if(empty($storeId)){
            $this->error('操作失败，请重新操作！');
        }
        $p = I('np');
        $sname = I('sname');
        $sprovince = I('sprovince');
        $news = M('news');
        $count = $news->where("store_id=" . $storeId)->count();
        $page = new \Think\Page($count,C('PAGE_SIZE'));
        $show = $page->show();
        $list = $news->where("store_id=" . $storeId)->order('id DESC')->limit($page->firstRow, $page->listRows)->select();
        $categoryAll= $this->getCategoryData('',array('cid','name'));
        foreach ($categoryAll as $k => $v) {
            $cids[$v['cid']] = $v;
        }
        unset($categoryAll);
        foreach($list as  $k=>$v){
            $list[$k]['cateName'] = $cids[$v['category_id']]['name'];
        }
        $storeInfo = M('Store')->field('store_id,store_name,category_id')->find($storeId);
        $this->assign('storeInfo',$storeInfo);
        $this->assign('list', $list);
        $this->assign('page',$show);
        $this->assign('np',$p);
        $this->assign('sname',$sname);
        $this->assign('sprovince',$sprovince);
        $this->assign('storeId',$storeId);
        $this->display();
    }
    /*
     * 添加商家新闻
     * 
     */
    public function addNew(){
        if(IS_POST){
            $data = I('post.info');
            $p = I('np');
            $sname = I('sname');
            $sprovince = I('sprovince');
            $findOne = $this->getCategoryData(array('cid'=>$data['category_id']),array('pid'));
            $data['category_pid'] = $findOne['0']['pid'];
            $news = M("news");
            if (isset($data['published_time']) && !empty($data['published_time'])) {
                $data['published_time'] = strtotime($data['published_time']);
            }
            $data['created_time'] = time();
            $data['updated_time'] = time();
            $adminId = $_SESSION['admin_id'];
            $data['admin_id'] = isset($adminId) ? $adminId : null;
            if($news->add($data)){
                $this->success('添加成功',U('BaseStore/storeNew',array('sid'=>$data['store_id'],'np'=>$p,'sname'=>$sname,'sprovince'=>$sprovince)));
            }else{
                $this->error('添加失败',U('BaseStore/storeNew',array('sid'=>$data['store_id'],'np'=>$p,'sname'=>$sname,'sprovince'=>$sprovince)));
            }
        }else{
            $storeId = I('sid');
            if(empty($storeId)){
                $this->error('操作失败，请重新操作！');
            }
            $storeInfo = M('Store')->field('store_id,store_name,province_id,store_id,category_id')->where('store_id='.$storeId)->find();
            //获取地区
            $province = $this->getRegionData(array('pid'=>2,'state'=>1),array('region_id','region_name'));
            //获取分类
            $categoryModel = D('category');
            $categoryData = $categoryModel->field('cid,name,pid')->where('is_show='.C('NORMAL_STATUS'))->select();
            $categoryList = $categoryModel->categoryTree($categoryData,$pid=1);
            
            $this->assign('province',$province);
            $this->assign('cate',$categoryList);
            $this->assign('storeInfo',$storeInfo);
            $this->assign('np',I('np'));
            $this->assign('sname',I('sname'));
            $this->assign('sprovince',I('sprovince'));
            $this->display();
        }
    }
    /*
     * 删除开启商家新闻
     */
    public function deleteNew(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $newsId = I('post.id');
        if(!empty($newsId)){
            $data['status'] = I('post.status');
            $adminId = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : 0;
            $data['admin_id'] = $adminId;
            if(M('news')->where('id='.$newsId)->save($data)){
                $result['flag'] = 1;
                $result['msg'] = '操作成功';
            }
        }
        echo json_encode($result);
    }
    /*
     * 编辑商家新闻
     */
    public function editNew(){
        $news = M('news');
        $storeId = I('get.sid');
        $newsId = I('get.nid');
        $p = I('np');
        $sname = I('sname');
        $sprovince = I('sprovince');
        if(!empty($storeId) && !empty($newsId)){
            if(IS_POST){
                $data = I('post.info');
                if (isset($data['published_time']) && !empty($data['published_time'])) {
                    $data['published_time'] = strtotime($data['published_time']);
                }
                $adminId = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : 0;
                $data['admin_id'] = $adminId;
                $data['updated_time'] = time();
                if($news->where('id='.$newsId)->save($data)){
                    $this->success('修改成功',U('BaseStore/storeNew',array('sid'=>$storeId,'np'=>$p,'sname'=>$sname,'sprovince'=>$sprovince)));
                }else{
                    $this->error('操作失败，请重新操作！');
                }
            }else{
                $result = $news->where('id='.$newsId)->find();
                //地区和分类数据
                $province = $this->getRegionData(array('pid'=>2,'state'=>1),array('region_id,region_name'));
               
                $categoryModel = D('category');
                $categoryAll = $categoryModel->field('cid,pid,name')->where('is_show ='.C('NORMAL_STATUS'))->select();
                $categoryList = $categoryModel->categoryTree($categoryAll,$pid=1);
                $storeInfo = M('Store')->field('store_name,province_id,store_id,category_id')->where('store_id='.$storeId)->find();

                $this->assign('storeInfo',$storeInfo);
                $this->assign('province',$province);
                $this->assign('cate',$categoryList);
                $this->assign('news',$result);
                $this->assign('storeId',$storeId);
                $this->assign('np',$p);
                $this->assign('sname',$sname);
                $this->assign('sprovince',$sprovince);
                $this->display();
            }
        }else{
            $this->error('参数不正确');
        }
    }
    /*
     * 商家新闻中的相册列表 
     */
    public function newImage(){
        $newsId = I('nid');
        $p = I('np');
        $sname = I('sname');
        $sprovince = I('sprovince');
        $newsImagesModel = M('news_images');
        $count = $newsImagesModel->where("news_id=" . $newsId)->count();
        $page = new \Think\Page($count,C('PAGE_SIZE'));
        $show = $page->show();
        $list = $newsImagesModel->where("news_id=" . $newsId)->order('id DESC')->limit($page->firstRow, $page->listRows)->select();

        $this->assign('list', $list);
        $this->assign('page',$show);
        $storeId = I('sid');
        $storeInfo = M('Store')->field('store_name,province_id,store_id,category_id')->where('store_id='.$storeId)->find();
        $newsInfo = M('News')->field('title,id')->find($newsId);

        $this->assign('newsInfo',$newsInfo);
        $this->assign('storeInfo',$storeInfo);
        $this->assign('newsId',$newsId);
        $this->assign('storeId',$storeId);
        $this->assign('np',$p);
        $this->assign('sname',$sname);
        $this->assign('sprovince',$sprovince);
        $this->display();
    }
    /*
     * 添加新闻图片
     */
    public function addNewImage(){
        $result = array('flag'=>0,'msg'=>'添加失败！');
        $data = I('post.');
        if(!empty($data['news_id'])){
            $data['status'] = C('NORMAL_STATUS');
            //上传图片
            if ($_FILES['image_url']['error'] == 0 && !empty($_FILES['image_url']['tmp_name'])) {
                $thumb = array(array(130, 130, 1));
                $ret = uploadOne('image_url', C('NEWS_IMAGE'), $thumb);
                if ($ret['ok'] == 0) {
                    $this->error = $ret['error'];
                    return FALSE;
                } else {
                    $data['image_url'] = C('IMG_HOST').$ret['images'][0];
                    $data['thumbnail'] = C('IMG_HOST'). $ret['images'][1];
                }
            }
            if(M('news_images')->add($data)){
                $result['flag'] = 1;
                $result['msg'] = '添加成功！';
            }
        }
        echo json_encode($result);
    }
    /*
     * 删除新闻图片（真删）
     */
    public function delNewImage(){
        $result = array('flag'=>0,'msg'=>'删除失败！');
        $id = I('post.id');
        if(!empty($id)){
            $newsImagesModel = M('NewsImages');
            $data = $newsImagesModel->field('image_url,thumbnail')->where('id = '.$id)->find();
            @unlink('.'.$data['image_url']);
            @unlink('.'.$data['thumbnail']);
            if($newsImagesModel->where('id='.$id)->delete()){
                $result['flag'] = 1;
                $result['msg'] = '成功删除！';
            }
        }
        echo json_encode($result);
    }
    
    /*
     * 名人墓地列表
     * 
     */
    public function celebrityList(){
        $storeId = I('sid');
        if(empty($storeId)){
            $this->error('请重新操作！');
        }
        $p = I('np');
        $sname = I('sname');
        $sprovince = I('sprovince');
        $celebrity = M('celebrity_cemetery');
        $count = $celebrity->where('store_id='.$storeId)->count();
        $Page = new \Think\Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $celebrity->order("`sort` DESC")->limit($Page->firstRow , $Page->listRows)->where('store_id='.$storeId)->select();
        $this->assign('storeId',$storeId);
        $this->assign('page',$show);
        $this->assign('list',$list);
        $this->assign('p',$p);
        $this->assign('sname',$sname);
        $this->assign('sprovince',$sprovince);
        $this->display();
    }
    /*
     * 添加名人墓地
     * 
     */
    public function addCelebrity(){
        $model =M('celebrity_cemetery');
        $p = I('np');
        $sname = I('sname');
        $sprovince = I('sprovince');
        if(IS_POST){
            $data = I('post.info');
            $data['updated_time'] = time();
            $data['created_time'] = time();
            if ($_FILES['image_url']['error'] == 0 && !empty($_FILES['image_url']['tmp_name'])) {
                $thumb = array(array(130,130,1));
                $ret = uploadOne('image_url', C('CELEBRITY_IMAGE'),$thumb);
                if ($ret['ok'] == 0) {
                    $this->error = $ret['error'];
                    return FALSE;
                } else {
                    $data['image_url'] = C('IMG_HOST').$ret['images'][0];
                    $data['thumb_image_url'] = C('IMG_HOST').$ret['images'][1];
                }
            }
            if($model->add($data)){
                $this->success('添加成功',U('BaseStore/celebrityList',array('sid'=>$data['store_id'],'np'=>$p,'sname'=>$sname,'sprovince'=>$sprovince)));
            }else{
                $this->error('添加失败');
            }
        }else{
            $storeId = I('sid');
            $this->assign('storeId',$storeId);
            $this->assign('p',$p);
            $this->assign('sname',$sname);
            $this->assign('sprovince',$sprovince);
            $this->display();
        }
    }
    /*
     * 删除开启名人墓地
     * 
     */
    public function delCelebrity(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $data['id'] = I('post.id');
        $data['status'] = I('post.status');
        if(!empty($data['id'])){
            if(M('CelebrityCemetery')->save($data)){
                $result['flag'] = 1;
                $result['msg'] = '操作成功！';
            }
        }
        echo json_encode($result);
    }
    /*
     * 编辑名人墓地
     * 
     */
    public function editCelebrity(){
        $p = I('np');
        $sname = I('sname');
        $sprovince = I('sprovince');
        if (IS_POST) {
            $model = M('celebrity_cemetery');
            $data = I('post.info');
            //dump($data);die;
            $id = I('post.id');
            if(empty($id)){
                $this->error('请重新操作！');
            }
            $storeId = I('post.store_id');
            $data['updated_time'] = time();
            if ($_FILES['image_url']['error'] == 0 && !empty($_FILES['image_url']['tmp_name'])) {
                $thumb = array(array(130, 130, 1));
                $ret = uploadOne('image_url', C('CELEBRITY_IMAGE'), $thumb);
                if ($ret['ok'] == 0) {
                    $this->error = $ret['error'];
                    return FALSE;
                } else {
                    $data['image_url'] = C('IMG_HOST').$ret['images'][0];
                    $data['thumb_image_url'] = C('IMG_HOST').$ret['images'][1];
                }
                $info =  $model->field('image_url,thumb_image_url')->where('id = ' . $id)->find();
                unlink('.'.$info['image_url']);
                unlink('.'.$info['thumb_image_url']);
            }
            $result = $model->where('id = ' . $id)->save($data);
            if ($result) {
                $this->success('修改完成', U('BaseStore/celebrityList',array('sid'=> $storeId,'np'=>$p,'sname'=>$sname,'sprovince'=>$sprovince)));
            } else {
                $this->error('请重新操作！');
            }
        } else {
            $id = I('get.id');
            if(empty($id)){
                $this->error('请重新操作！');
            }
            $result = M('celebrity_cemetery')->where('id = ' . $id)->find();
            $this->result = $result;
            $this->assign('p',$p);
            $this->assign('sname',$sname);
            $this->assign('storeId',I('get.sid'));
            $this->assign('sprovince',$sprovince);
            $this->display();
        }
    }

    /**
     * 陵园相册
     */
    public function albumCeletery(){
        $tips = '陵园';
        $listFunc = 'cemeteryList';
        $nowPage = I('np');
        $this->assign('tips',$tips);
        $this->assign('nowPage',$nowPage);
        $this->assign('listFunc',$listFunc);
        $this->_storeAlbum();
    }

    /**
     * 殡仪馆相册
     */
    public function albumFuneral(){
        $tips = '殡仪馆';
        $listFunc = 'funeralList';
        $nowPage = I('np');
        $this->assign('tips',$tips);
        $this->assign('listFunc',$listFunc);
        $this->assign('nowPage',$nowPage);
        $this->_storeAlbum();
    }

    /**
     * 商家相册列表公共方法
     */
    private function _storeAlbum(){
        $sid = I('sid');
        $sname = I('sname');
        $province = I('province');
        
        $store = M('store')->where('store_id='.$sid)->field('store_id,store_name')->find();
        $image = M('storeImages');

        $where['store_id'] = $sid;
        $count = $image->where($where)->count();
        $page = new \Think\Page($count,C('PAGE_SIZE'));
        $show = $page->show();
        $list = $image->where($where)->limit($page->firstRow.','.$page->listRows)->select();
        
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->assign('storename',$store['store_name']);
        $this->assign('storeId',$sid);
        $this->assign('sname',$sname);
        $this->assign('province',$province);
        $this->display('BaseStore/storeAlbum');
    }

    /**
     * 添加/编辑商家相册公共方法
     */
    public function saveAlbum(){
        if(IS_POST){
            $storeImgModel = M('StoreImages');
            $result = array('flag'=>0,'msg'=>'操作失败');
            $data = I('post.info');
            $id = I('id');
            if(!$id){
                //商家相册添加操作
                $imagesRet = upload('img_url',C('STORE_IMAGE'),C('STORE_THUMB'));
                if($imagesRet['ok']==0){
                    $this->error($imagesRet['error']);
                }else{
                    foreach($imagesRet['images'] as $k=>$v){
                        $data['image_url'] = C('IMG_HOST').$v;
                        foreach($imagesRet['thumb'][$k] as $key=>$value){
                            $data['thumb_image_url'] = C('IMG_HOST').$value;
                        }
                        $ret = $storeImgModel->add($data);
                        if($ret){
                            $result = array('flag'=>1,'msg'=>'添加成功');
                        }
                    }
                }
            }else{
                //商家相册修改操作
                if($_FILES['img_url']['error'] == 0 && !empty($_FILES['img_url']['tmp_name'])){
                    $imagesRet = uploadOne('img_url',C('STORE_IMAGE'),C('STORE_THUMB'));
                    $delImg = $storeImgModel->where('id='.$id)->field('image_url,thumb_image_url')->find();
                    if(!empty($delImg)){
                        unlink('.'.$delImg['image_url']);
                        unlink('.'.$delImg['thumb_image_url']);
                    }
                    if($imagesRet['ok'] == 0){
                        $this->error($imagesRet['error']);
                    }else{
                        //数据写到数据库中
                        $data['image_url'] = C('IMG_HOST').$imagesRet['images'][0];
                        $data['thumb_image_url'] = C('IMG_HOST').$imagesRet['images'][1];
                    }
                }
                $ret = $storeImgModel->where('id='.$id)->save($data);
                if(!is_bool($ret)){
                    $result = array('flag'=>1,'msg'=>'修改成功');
                }
            }

            echo json_encode($result);
        }
    }

    /**
     * 修改商家相册公共方法
     */
    public function editImage(){
        $id = I('id');
        $imagesModel = M('storeImages');
        $ret = $imagesModel->where('id='.$id)->find();
        if($ret){
            $result['flag'] = 1;
            $result['data'] = $ret;
        }else{
            $result['flag'] = 0;
        }
        echo json_encode($result);
    }

    /**
     * 删除商家相册
     */
    public function delImage(){
        $imageId = I('id');
        $M = M('storeImages');
        $where['id'] = array('in',$imageId);
        $data['state'] = C('DELETE_STATUS');
        if($M->where($where)->save($data)){
            echo '1';
        }else{
            echo '0';
        }
    }

    /**
     * 启用商家相册
     */
    public function enableAlbum(){
        $model = M('storeImages');
        $id = I('id');
        $data['state'] = C('NORMAL_STATUS');
        if($model->where('id='.$id)->save($data)){
            $result['flag'] =1;
            $result['msg'] = "操作成功";
        }else{
            $result['flag'] =1;
            $result['msg'] = "操作失败";
        }
        echo json_encode($result);
    }

    private function getStoreName($storeId){
        $data = M('store')->where('store_id='.$storeId)->field('store_name')->find();

        return $data['store_name'];
    }

    /**
     * 墓位商品
     */
    public function storeGoods(){
        $getInfo = I('get.');
        $goodsModel = M('Goods');
        $ret['store_id'] = $getInfo['sid'];
        $count = $goodsModel->where($ret)->count();
        $page = new Page($count,C('PAGE_SIZE'));
        $show = $page->show();
        $goodsType = $this->getCategoryData('pid=18',array('cid,name'),'',true);
        $list = $goodsModel->where($ret)->field('id,store_id,goods_name,goods_type,stock,created_time,store_show,status')->limit($page->firstRow,$page->listRows)->order('updated_time desc')->select();
         foreach($list as $k=>$v){
            $list[$k]['goods_typeName'] = $goodsType[$v['goods_type']];
         }
        $storeName = $this->getStoreName($getInfo['sid']);
       
        $this->p = $getInfo['np'];
        $this->list = $list;
        $this->page = $show;
        $this->storeId = $getInfo['sid'];
        $this->storeName = $storeName;
        $this->display();
    }

    /**
     * 添加商品
     */
    public function addGoods(){
        $goodsInfo = M('Goods');
        if(IS_POST){
            $data = I('post.info');
            $data['created_time'] = $data['updated_time'] = time();
            $data['admin_id'] = session('admin_id');
            if($_FILES['goods_image']['error'] == 0 && !empty($_FILES['goods_image']['tmp_name'])){
                /**
                 * 缩略图
                 */
                $thumb = array(array(130,130,1));
                $ret = uploadOne('goods_image',C('GOODS_IMAGE'),$thumb);
                if($ret['ok'] == 0){
                    $this->error = $ret['error'];
                    return false;
                }else{
                    $data['goods_image'] = C('IMG_HOST').$ret['images'][0];
                    $data['goods_thumb_image'] = C('IMG_HOST').$ret['images'][1];
                }
            }
            if($goodsInfo->data($data)->add()){

                $this->success('添加成功',U('storeGoods',array('sid'=>$data['store_id'])));
            }else{
                $this->error();
            }
        }else{
            $storeInfo = I('get.');
            $goodsType = $this->getCategoryData('pid=18',array('cid,name'),'',false);
            $this->storeId = $storeInfo['storeId'];
            $this->storeName = $this->getStoreName($storeInfo['storeId']);
            $this->goodsType = $goodsType;
            $this->display();
        }
    }

    //获取商品分类下的子类
    public function getCategoryList(){
        if (IS_POST) {
            $catId = I('cateId');
            $cateObj = M("category");
            $data = $cateObj->where("pid=" . $catId)->select();
            $this->ajaxReturn($data, 'JSON');
        }else{
            $this->error('分类ID不存在');
        }
    }

    /**
     * 修改商品
     */
    public function editGoods(){
        $goodsInfo = M('Goods');
        if(IS_POST){
            $postInfo = I('post.info');
            $postInfo['updated_time'] = date('Y-m-d H:i:s');
            if($_FILES['goods_image']['error'] == 0 && !empty($_FILES['goods_image']['tmp_name'])){
                $thumb = array(array(130,130,1));
                $ret = uploadOne('goods_image',C('GOODS_IMAGE'),$thumb);
                $oldImg = $goodsInfo->where('id='.$postInfo['id'])->field('goods_image,goods_thumb_image')->find();
                if(!empty($oldImg)){
                    unlink('.'.$oldImg['goods_image']);
                    unlink('.'.$oldImg['goods_thumb_image']);
                }
                if($ret['ok'] == 0){
                    $this->error = $ret['error'];
                    return false;
                }else{
                    $postInfo['goods_image'] = C('IMG_HOST').$ret['images'][0];
                    $postInfo['goods_thumb_image'] = C('IMG_HOST').$ret['images'][1];
                }
            }
            if($goodsInfo->data($postInfo)->save()){
                $this->success('修改成功',U('storeGoods',array('sid'=>$postInfo['store_id'],'p'=>$postInfo['p'])));
            }else{
                $this->error();
            }
        }else{
            $getInfo = I('get.');
            $goodslist = $goodsInfo->where('id='.$getInfo['goods_id'])->find();
            $category = $this->getCategoryData('pid=18',array('cid,name'),'',false);
            $storeInfo = D('store')->getCemeteryName($getInfo['store_id']);
            $childCategory = $this->getCategoryData('pid='.$goodslist['goods_type']);
            $this->storeInfo = $storeInfo;
            $this->goods = $goodslist;
            $this->category = $category;
            $this->childCategory = $childCategory;
            $this->storeId = $getInfo['store_id'];
            $this->display();
        }
    }

    /**
     * 删除
     */
    public function delGoods(){
        $goodsInfo = M('Goods');
        $this->_del($goodsInfo,'id','status');
    }

    //商品图片
    public function goodsImage(){
        $getData = I('get.');
        $goodsModel = M('GoodsImages');

        $where['goods_id'] = $getData['goods_id'];
        $admin_email = C('ADMIN_EMAIL');
        if(session('email')!=$admin_email){
            $where['status'] = C('NORMAL_STATUS');
        }
        $count = $goodsModel->where($where)->count();
        $Page = new \Think\Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $goodsModel->where($where)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->assign('sid',$getData['sid']);
        $this->assign('storeName',$getData['storeName']);
        $this->assign('goodsName',$getData['goodsName']);
        $this->display();
    }

    //添加商品图片
    public function addGoodsImage(){
        if(IS_POST){
            $data = I('post.info');
            if ($_FILES['image_url']['error'] == 0 && !empty($_FILES['image_url']['tmp_name'])) {
                $thumb = array(array(130, 130, 1));
                $ret = uploadOne('image_url', C('CELEBRITY_IMAGE'), $thumb);
                if ($ret['ok'] == 0) {
                    $this->error = $ret['error'];
                    return FALSE;
                } else {
                    $data['image_url'] = C('IMG_HOST').$ret['images'][0];
                    $data['thumbnail'] = C('IMG_HOST').$ret['images'][1];
                }
            }
            if(M('GoodsImages')->add($data)){
                $result['flag'] = 1;
                $result['msg'] = '添加成功';
            }else{
                $result['flag'] = 0;
                $result['msg'] = '添加失败';
            }
            echo json_encode($result);
        }
    }

    /**
     * 删除
     */
    public function deleteGoodsImage(){
        $goodsInfo = M('GoodsImages');
        $this->_del($goodsInfo,'image_id','status');
    }

    /**
     * 公共删除方法
     * @param  object $table  操作的表名
     * @param  string $keyId  主键id
     * @param  string $status 状态字段
     */
    private function _del($table,$keyId,$status){
        if(IS_POST){
            $postInfo = I('post.');
            $result = array('flag'=>0,'msg'=>'操作失败');
            if($postInfo['act']=='del'){
                $data[$keyId] = $postInfo['id'];
                $data[$status] = C('DELETE_STATUS');
                // 状态改为-1
                if($table->create($data) && $table->save()){
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }
            }else if($postInfo['act']=='enable'){
                $data[$keyId] = $postInfo['id'];
                $data[$status] = C('NORMAL_STATUS');
                // 状态改为1
                if($table->create($data) && $table->save()){
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }
            }
            echo json_encode($result);
        }
    }

    //商品属性
    public function goodsAttribute(){
        $getIds = I('get.');
        $goodsAttr = D('GoodsAttr');
        $where['goods_id'] = $getIds['id'];
        $count = $goodsAttr->where($where)->count();
        $Page = new Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $goodsAttr->relation(array('Goods','Attribute'))->where($where)->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign("categoryId", $getIds['category_id']);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->assign('sid',$getIds['sid']);
        $this->assign('storName',$getIds['storname']);
        $this->assign('goodsName',$getIds['goodsName']);
        $this->display();
    }

    //添加/编辑 商家属性
    public function addGoodsAttribute(){
        $result = array('code'=>0,'msg'=>'');
        $getAttr = I('get.');
        if($getAttr['cate_id']){
            $Attribute = M('attribute');
            $attributes = $Attribute->where('category_id='.$getAttr['cate_id'])->select();
            $result['code'] = 1;
            $result['attr'] = $attributes;
        }
        if($getAttr['id']) {
            $attribute = M('GoodsAttr');
            $goodsAttribute = $attribute->where('id='.$getAttr['id'])->find();
            $result['list'] = $goodsAttribute;
        }
        echo json_encode($result);
    }

    //保存/修改 商家属性数据
    public function saveGoodsAttribute(){
        $data = I('post.info');
        $attribute = M('GoodsAttr');
        if($data['id']) {
            //编辑
            if($attribute->data($data)->save()){
                $result['flag'] = 1;
                $result['msg'] = '更新成功';
            }else{
                $result['flag'] = 0;
                $result['msg'] = '更新失败';
            }
        }else{
            //新增
            if (!$attribute->add($data)) {
                $result['flag'] = 0;
                $result['msg'] = '新增失败';
            }else{
                $result['flag'] = 1;
                $result['msg'] = '新增成功';
            }
        }
        echo json_encode($result);
    }

    /**
     * 删除商品属性
     */
    public function delGoodsAttribute(){
        $goodsAttr = M('GoodsAttr');
        $data = I('post.');
        if(!empty($data['id'])){
            $ret = $goodsAttr->where('id='.$data['id'])->delete();
            if($ret){
                $result['flag'] = 1;
                $result['msg'] = '删除成功';
            }else{
                $result['flag'] = 0;
                $result['msg'] = '删除失败';
            }
        }else{
            $result['flag'] = 1;
            $result['msg'] = 'id为空';
        }
        echo json_encode($result);
    }

    /**
     * 商家积分管理
     * @return [type] [description]
     */
    public function storeScore(){
        $getVal = I('get.');
        if(isset($getVal['sname']) && !empty($getVal['sname'])){
            $where['store_name'] = array('like','%'.$getVal['sname'].'%');
        }
        if(isset($getVal['sprovince']) && !empty($getVal['sprovince'])){
            $where['province_id'] = $getVal['sprovince'];
        }
        if(isset($getVal['scity']) && !empty($getVal['scity'])){
            $where['city_id'] = $getVal['scity'];
        }
        $where['category_id'] = C('CATEGORY_CEMETERY_ID');
        $storeModel = M('store');
        $count = $storeModel->where($where)->count();
        $page = new Page($count,C('PAGE_SIZE'));
        $show = $page->show();
        $storeList = $storeModel->where($where)->field('store_id,store_name,status,member_status,score,score_remark')->order('score desc')->limit($page->firstRow,$page->listRows)->select();
        $regionWhere['pid'] = C('CHINA_NUM');
        $regionWhere['state'] = C('NORMAL_STATUS');
        $provinceRegion = M('region')->where($regionWhere)->select();

        $cityRegion = array();
        if(!empty($getVal['sprovince'])){
            $cityRegion = M('region')->where('pid='.$getVal['sprovince'])->select();
        }
        $this->province = $provinceRegion;
        $this->city = $cityRegion;
        $this->page = $show;
        $this->storeList = $storeList;
        $this->getVal = $getVal;
        $this->display();
    }

    /**
     * 更新积分
     */
    public function refreshScore(){
        $result = array('code' => 0,'msg' => '操作失败');
        if(IS_POST){
            $orderGrave = M('OrderGrave');
            $orderList = $orderGrave->field('id,store_id,store_status,status')->order('province_id asc')->select();
            $vip = 20; // 会员积分
            $noVip = 10; // 非会员积分
            $adVip = 20; // 广告会员积分
            $info = array();
            $data = array();
            if($orderList){
                foreach ($orderList as $val) { 
                    if($val['status'] == C('ORDER_STATUS.DEFAULT')){ // 订单生成成功
                        $info[$val['store_id']]['store_status'] = $val['store_status'];
                        $info[$val['store_id']]['score']        += 1;
                    }
                    if($val['status'] == C('ORDER_STATUS.INTERESTING')){ // 有意向订单
                        $info[$val['store_id']]['store_status'] = $val['store_status'];
                        $info[$val['store_id']]['score']        += 2;
                    }
                    if($val['status'] == C('ORDER_STATUS.GET_MONEY')){// 收到佣金待返现
                        $info[$val['store_id']]['store_status'] = $val['store_status'];
                        $info[$val['store_id']]['score']        += 10;
                    }
                    if($val['status'] == C('ORDER_STATUS.SUCCESS')){ // 达成交易
                        $info[$val['store_id']]['store_status'] = $val['store_status'];
                        $info[$val['store_id']]['score']        += 20;
                    }
                }

                // 加上基础分
                foreach ($info as $k => $v) {
                    switch ($v['store_status']) {
                        case C('STOER_MERMBER'):
                            $data['score'][$k] = $v['score'] + $vip;
                            break;
                        case C('STOER_MERMBER_V'):
                            $data['score'][$k] = $v['score'] + $vip;
                            break;
                        case C('STOER_MERMBER_PERSON'):
                            $data['score'][$k] = $v['score'] + $vip;
                            break;
                        case C('STOER_MERMBER_AD'):
                            $data['score'][$k] = $v['score'] + $adVip;
                            break;
                        case 0:
                            $data['score'][$k] = $v['score'] + $noVip;
                            break;
                        default:
                            # code...
                            break;
                    }
                }

                // 批量更新
                $ret = saveAllData($data,'store','store_id');
                if($ret){
                    $result = array('code' => 1,'msg' => '更新成功');
                }
            }
        }
        echo json_encode($result);
    }

    /**
     * 修改积分
     */
    public function scoreUpdate(){
        $storeTable = M('store');
        $ret = array('code' => 0,'msg' => '操作失败');
        if(IS_POST){
            $scoreData = I('post.');
            $dataInfo['store_id'] = $scoreData['store_id'];
            $dataInfo['score'] = $scoreData['score'];
            if(!empty($scoreData['score_remark'])){
                $dataInfo['score_remark'] = $scoreData['score_remark'];
            }
            if($storeTable->data($dataInfo)->save()){
                $ret = array('code' => 1,'msg' => '修改成功');
            }
        }
        echo json_encode($ret);
    }
}