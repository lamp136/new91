<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;
use Think\Page;
/**
 * 商家信息控制器
 * Class BusinessStoreController
 * @author heqingyu
 * @date 2016/8/12
 * @version 1.0
 */
class BusinessStoreController extends BaseController{
     /**
     * 商务商家列表
     */
    public function storeList(){
        $store = D('store');
        //搜索条件
        $condition = array();
        $storeName = I('search_store_name');
        $province = I('search_province');
        $city = I('search_city');
        $memberStatus = I('search_member_status');
        if(!empty($storeName)){
            $condition['store_name'] = array('like','%'.$storeName.'%');
        }
        if(!empty($province)){
            $condition['province_id'] = $province;
        }
        if(!empty($city)){
            $condition['city_id'] = $city;
        }
        if(!empty($memberStatus)){
            $condition['member_status'] = $memberStatus;
        }
        $condition['category_id'] = C('CATEGORY_CEMETERY_ID');
        //$condition['category_id'] = array('in',array(C('CATEGORY_CEMETERY_ID'),C('CATEGORY_FUNERAL_ID')));
        $condition['status'] = array('in',array('1','2'));
        //商家数量
        $count = $store->where($condition)->count();
        //接收分页的参数，如果没有值就默认为1
        $p = I('p');
        $nowPage = empty($p) ? C('PAGE_DEFAULT') : $p;
        $Page = new \Think\Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $store->relation(array('Province','City','StoreProtilesDetail'))->where($condition)->limit($Page->firstRow,$Page->listRows)->order('store_id desc')->select();
        
        //获取所有省份
        $fields = array('region_id,region_name,pid');
        $regions = $this->getRegionData( '',$fields);
        foreach($regions as $value){
            if($value['pid'] == C('CHINA_NUM')){
                $provinceRegion[] = $value;
            }else if($value['pid'] == $condition['province_id']){
                $cityRegion[] = $value;
            }
        }          
        $this->assign('province',$provinceRegion);
        $this->assign('city',$cityRegion);
        $this->assign('list',$list);
        $this->assign("condition", $condition);
        $this->assign("filterProvince", $condition['province_id']);
        $this->assign("filterCity", $condition['city_id']);
        $this->assign("filterStorename", $storeName);
        $this->assign('nowPage',$nowPage);
        $this->assign('page',$show);
        $this->assign('memberStatusArr', getStoreMember());
        $this->display();
    }
    
    /**
     * 通过选择省份改变市ajax获取省份ID
     */
    public function getCityList(){
        if (IS_POST) {
            $where['pid'] = I('province_id');
            $fields = array('region_id,region_name');
            $data = $this->getRegionData( $where,$fields);
            $this->ajaxReturn($data, 'JSON');
        }else{
            $this->error('省份ID不存在');
        }
    }
    /**
     * 删除商家联系人
     */
    public function delContact(){
        $result = array('flag'=>0,'msg'=>'删除失败！');
        $contactId = I('post.id');
        if(!empty($contactId)){
            $data['status'] =C('DELETE_STATUS');
            if(M('store_contact')->where('id='.$contactId)->save($data)){
                $result['flag'] = 1;
                $result['msg'] = '成功删除！';
            }
        }
        echo json_encode($result);
    }
    /*
     * 编辑商家联系人信息
     */
    public function editContact(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        if(IS_POST){
            $data = I('post.');
            if(!empty($data['id'])){
                $storeContactModel = M('StoreContact');
                $contactInfo = $storeContactModel->field('id')->where('id='.$data['id'])->find();
                if($contactInfo){
                    $data['admin_id'] = $_SESSION['admin_id'];
                    $data['updated_time'] = time();
                    if($storeContactModel->save($data)){
                        $result['flag'] = 1;
                        $result['msg'] = '修改成功!';
                    }
                }else{
                    $result['flag'] = 0;
                    $result['msg'] = '信息不存在!';
                }
            }
        }else{
            $contactId = I('get.id');
            if(!empty($contactId)){
                $infoContact = M('store_contact')->where('id='.$contactId)->find();
                $infoStore = M('store')->field('store_name')->where('store_id='.$infoContact['store_id'])->find();
                $result = array_merge($infoContact,$infoStore);
                $result['flag'] = 1;
            }
        }
        echo json_encode($result);
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
            if (!empty($data['store_id'])) {
                $where['store_id'] = $data['store_id'];
            }
            if (!empty($data['tel'])) {
                $where['tel'] = $data['tel'];
            }
            $contactInfo = $storeContactModel->field('mobile,tel')->where($where)->find();
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
    /**
     * 编辑页面
     */
    public function edit(){
        if(IS_POST){
            $data = I('post.');
            if(empty($data['store_id'])){
                $this->error('操作失败，请重新操作！');
            }
            $nowPage = $data['nowPage'];
            //开启事务
            $model = new \Think\Model();
            $model->startTrans();

            $filterStorename = $data['search_store_name'];
            $filterProvince = $data['search_province'];
            $search_city = $data['search_city'];
            $data['updated_time'] = time();
            if (M('store')->save($data)){
                $profilesData['id'] = $data['store_profiles_id'];
                $profilesData['updated_time'] = time();
                $profilesData['min_price'] = $data['min_price'];
                $profilesData['max_price'] = $data['max_price'];
                $profilesData['commitment'] = $data['pick_up_address']; 
                if(M('StoreProfilesDetail')->save($profilesData)){
                    $model->commit();
                    $this->success('修改成功', U('BusinessStore/storeList', array('p'=>$nowPage, 'search_store_name'=> $filterStorename, 'search_province'=>$filterProvince, 'search_city'=> $search_city)));
                }else{
                    $model->rollback(); 
                    $this->error('操作失败!');  
                }
            }else{
                $model->rollback(); 
                $this->error('操作失败!');
            }
        }else{
            $storeId = I('store_id');
            if(empty($storeId)){
                $this->error('操作失败，请重新操作！');
            }
            $store = D('store')->relation(array('Province','City'))->where('store_id='.$storeId)->find();

            $memberStatus=getStoreMember();
            $this->assign('memberStatus',$memberStatus);
            $this->assign('store',$store);
            $this->assign('nowPage',I('nowPage'));
            $this->assign('search_store_name',I('search_store_name'));
            $this->assign('search_province',I('search_province'));
            $this->assign('search_city',I('search_city'));
            $this->display();
        }
    }
    
    /*
     * 查看电子合同
     * return string(json);
     */
    public function viewStoreProfiles(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $storeProfilesId = I('storeProfilesId');
        if(!empty($storeProfilesId)){
            $imageData = M('StoreProfilesImage')->field('image,type')->where('profiles_detail_id = '.$storeProfilesId)->select();
            $tmpData = array();
            $newData = array();
            //1为电子合同 2为价格合同
            foreach($imageData as $val){
                if($val['type'] == 2){
                    $tmpData[2][] = $val['image'];
                }else if($val['type'] == 1){
                    $tmpData[1][] = $val['image'];
                }
            }
            $newData = array_merge($tmpData[2],$tmpData[1]);
            if(empty($newData)){
                $result = array('flag'=>0,'msg'=>'暂无电子合同图片');
            }else{
                $result = array('flag'=>1,'data'=>$newData);
            }
        }
        echo json_encode($result);
    }
}