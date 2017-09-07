<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
use Think\Page;
/**
 * 商家合同档案
 *
 * @author hqy
 * @version 1.0
 * datetime 2016/7/21
 */
class StoreProfilesController extends BaseController{
    /*
    * 合同档案列表
    *
    */
    public function index(){
        $choice['time'] = I('get.choicetime');
        $choice['show_store_name'] = I('get.show_store_name');
        $choice['category_id'] = I('get.category_id');
        $choice['province'] = I('get.search_province');
        $choice['city'] = I('get.search_city');
        $where = array();
        if(!empty($choice['province'])){
            $where['province_id'] = $choice['province'];
        }
        if(!empty($choice['city'])){
            $where['city_id'] = $choice['city'];
        }
        if(!empty($choice['time'])){
            $today = time();
            if($choice['time'] == 'long'){
                $profilesDetailWhere['end_time'] = array(array('lt',$today-2678400));//过期一个月外的查询条件
            }else if($choice['time']<0){
                $second = abs($choice['time'])*3600*24;
                $profilesDetailWhere['end_time'] = array(array('lt',$today),array('gt',$today-$second));
            }else{
                $second = $choice['time']*3600*24;
                $profilesDetailWhere['end_time'] = array(array('gt',$today),array('lt',$today+$second));
            }
        }

        if(!empty($choice['show_store_name'])){
            $where['show_store_name'] = array('like','%'.$choice['show_store_name'].'%');
        }
        if(!empty($choice['category_id'])){
            $where['category_id'] = $choice['category_id'];
        }

        //地区处理
        $provinceWhere['state'] = C('NORMAL_STATUS');
        $cityRegion = array();
        if(!empty($choice['province'])){
            $provinceWhere['pid'] = array('in',array($choice['province'],C('CHINA_NUM')));
            $seachRegionAll = $this->getRegionData($provinceWhere);
            foreach($seachRegionAll as $key=>$val){
                if($val['pid'] == C('CHINA_NUM')){
                    $provinceRegion[] =  $seachRegionAll[$key];
                }else{
                    $cityRegion[] = $seachRegionAll[$key];
                }
            }
        }else{
            $provinceWhere['pid'] = C('CHINA_NUM');
            $provinceRegion = $this->getRegionData($provinceWhere);
        }
        $where['status'] = C('NORMAL_STATUS');
        $StoreProfilesModel = D('StoreProfiles');
        $totalRows = $StoreProfilesModel->where($where)->count();
        //接收分页的参数，如果没有值就默认为1
        $p = I('p');

        $nowPage = empty($p) ? C('PAGE_DEFAULT') : $p;
        $page = new Page($totalRows,C('PAGE_SIZE'));
        $pagelist = $page->show();
        $where['status'] = C('NORMAL_STATUS');
        $profilesDetailWhere['status'] = C('NORMAL_STATUS');
        ///$profilesDetailData = D('StoreProfilesDetail')->relation(array('StoreProfilesRenew'))->where($profilesDetailWhere)->select();
        $profilesDetailData = M('StoreProfilesDetail')->where($profilesDetailWhere)->select();
        $list = $StoreProfilesModel->relation(array('Province','City','StoreProfilesRenew'))->where($where)->limit($page->firstRow,$page->listRows)->order('id desc')->select();
        foreach($list as $k=>$v){
            $i = 1;
            $list[$k]['profiles_detail_num'] = count($v['StoreProtilesDetail'])+1;
            foreach($profilesDetailData as $key=>$value){
                if($v['id'] == $value["profiles_id"]){
                    $list[$k]["StoreProtilesDetail"][] = $value;
                    $list[$k]['profiles_detail_num'] = ++$i;
                }
            }
        }
       //dump($list);die;
            
        //分类
        $where['is_show'] = C("NORMAL_STATUS");
        $where['pid'] = array('in',array(C('CATEGORY_STORE_ID'),C('CATEGORY_MERCHANT_ID')));
        $category = M('category')->field('cid,pid,name')->where($where)->select();
        foreach($category as $key=>$val){
            if($val['pid'] == C('CATEGORY_MERCHANT_ID')){
                $merchant[] = $category[$key];
            }else{
                $cate[] = $category[$key];
            }
        }
        if(empty($choice['time'])){
            $this->assign('page',$pagelist);
        }
        $this->assign('category',$cate);
        $this->assign('merchant',$merchant);
        $this->assign('province',$provinceRegion);
        $this->assign('city',$cityRegion);
        $this->assign('nowPage',$nowPage);
        $this->assign('list',$list);
        $this->assign('choice',$choice);
        $this->display();
    }
    /*
     * 添加合同档案
     */
    public function add(){
        if(IS_POST){
            $info = I('post.');
            $model = new \Think\Model();
            $model->startTrans();
            $StoreBaseprofilesModel = M('StoreProfiles');
            $storeprofiles = $StoreBaseprofilesModel->where('show_store_name="'.$info['show_store_name'].'"')->find();
            if(!empty($storeprofiles)){
                $this->error('添加失败,该商家已经存在!');
            }

            $info['admin_id'] = session('admin_id');
            $info['created_time'] = time();
            $info['updated_time'] = time();
            $info['status'] = C('NORMAL_STATUS');
            $res = $StoreBaseprofilesModel->add($info);
            if(!$res){
                $this->error('添加失败');
            }

            $principal = $this->getMen(C('PRINCIPAL'));

            $StoreDetailprofilesModel = M('StoreProfilesDetail');
            $count = count($info['end_time']);
            for($i=0;$i<$count;$i++){
                $data['profiles_id'] = $res;
                $data['bank'] = $info['bank'][$i];
                $data['bank_member'] = $info['bank_member'][$i];
                $data['bank_account'] = $info['bank_account'][$i];
                $data['min_price'] = $info['min_price'][$i];
                $data['max_price'] = $info['max_price'][$i];
                $data['profile_name'] = $info['profile_name'][$i];
                $data['category_id'] = $info['category_goods_id'][$i];
                $data['contact_man'] = $info['contact_man'][$i];
                $data['telephone'] = $info['telephone'][$i];
                $data['mobile'] = $info['mobile'][$i];
                $data['fax'] = $info['fax'][$i];
                $data['member_status'] = $info['member_status'][$i];
                $data['start_time'] = strtotime($info['start_time'][$i]);
                $data['end_time'] = strtotime($info['end_time'][$i]);
                $data['receive_time'] = strtotime($info['receive_time'][$i]);
                $data['status'] = C("NORMAL_STATUS");
                $data['principal_id'] = $info['principal'][$i];
                $data['principal'] = $principal[$info['principal'][$i]];
                $data['return_amount'] = $info['return_amount'][$i];
                $data['settlement_time'] = $info['settlement_time'][$i];
                $data['distribution_area'] = $info['distribution_area'][$i];
                $data['commitment'] = $info['commitment'][$i];
                $data['remarks'] = $info['remarks'][$i];
                $data['commitment'] = $info['commitment'][$i];
                $data['updated_time'] = time();
                $data['created_time'] = time();
                
                $result = $StoreDetailprofilesModel->add($data);
                if(!$result){
                    $model->rollback();
                    $this->error('添加失败');
                }
            }
            $model->commit();
            $this->success('添加成功',U('index'));
        }else{
            //获取所有省份
            $where['pid'] = C('CHINA_NUM');
            $fields = array('region_id,region_name');
            $regions = $this->getRegionData($where,$fields);
            //合同分类
            $where['is_show'] = C("NORMAL_STATUS");
            $where['pid'] = array('in',array(C('CATEGORY_STORE_ID'),C('CATEGORY_GROUP_ID'),C('CATEGORY_MERCHANT_ID')));
            $category = M('category')->field('cid,pid,name')->order('sort DESC')->where($where)->select();
            foreach($category as $key=>$val){
                if($val['pid'] == C('CATEGORY_STORE_ID')){
                    $cateStore[] = $category[$key];
                }else if($val['pid'] == C('CATEGORY_MERCHANT_ID')){
                    $merchant[] = $category[$key];
                }else{
                    $cateGroup[] = $category[$key];
                }
            }
            $memberStatus=getStoreMember();//会员状态 eg:个人会员 商家会员
            $this->assign('memberStatus',$memberStatus);
            $this->assign('principal', $this->getBusinessMen());
            $this->assign('category',$cateStore);
            $this->assign('merchant',$merchant);
            $this->assign('categoryGroup',$cateGroup);
            $this->assign("regions", $regions);
            $this->display();
        }
    }
    /**
     * 通过省份id获取城市信息
     */
    public function getCity(){
        if(IS_POST){
            $result = array('flag'=>0,'data'=>array());
            $province_id = I('post.province_id');
            $regoin = M('region')->field('region_id,region_name')->where('pid='.$province_id.' and state='.C('NORMAL_STATUS'))->select();
            if(!empty($regoin)){
                $result['flag'] = 1;
                $result['data'] = $regoin;
            }
            echo json_encode($result);
        }
    }
    /**
     * 放弃(不续签)
     */
    public function giveup() {
        $result = array('flag'=>0,'msg'=>'操作失败');
        $storeProfilesDetailModel = D('StoreProfilesDetail');
        if(IS_POST){
            $id = I('post.id');
            $status = I('post.status');
            $reason = I('post.reason');
            if(!empty($id)){
                $data = $storeProfilesDetailModel->field('id')->find($id);
                if(!empty($data)){
                    $update['id'] = $id;
                    $update['status'] = $status;
                    $update['remarks'] = $reason;
                    $updata['updated_time'] = time();
                    $res =$storeProfilesDetailModel->save($update);
                    if($res){
                        $result['flag'] = 1;
                        $result['msg'] = '操作成功！';
                    }else{
                        $result['flag'] = 0;
                        $result['msg'] = '操作失败！';
                    }
                }
            }
        }else{
            $id = I('get.id');
            if(!empty($id)){
                $data = $storeProfilesDetailModel->field('id,remarks')->find($id);
                if(!empty($data)){
                    $result['flag'] = 1;
                    $result['msg'] = $data['remarks'];
                }
            }
        }
        echo json_encode($result);
    }

    /**
     * 续签合同
     */
    public function renew() {
        $storeProfilesModel = D('StoreProfilesDetail');
        if(IS_POST){
            $result = array('flag'=>0,'msg'=>'操作失败');
            $model = new \Think\Model();
            $model->startTrans();
            $storeProfilesid = I('post.store_profiles_detail_id');
            $storeProfilesInfo = $storeProfilesModel->field('id')->find($storeProfilesid);
            if(!empty($storeProfilesInfo)){
                $storeProfilesRenewModel = D('StoreProfilesRenew');
                if($storeProfilesRenewModel->create() && $storeProfilesRenewModel->add()){
                    $end_time = strtotime(I('post.renew_end_time'));
                    $updateresult = $storeProfilesModel->where('id='.$storeProfilesid)->setField(array('end_time'=>$end_time,'status'=>C('NORMAL_STATUS')));
                    if($updateresult){
                        $result['flag'] = 1;
                        $result['msg'] = '操作成功';
                        $model->commit();
                    }else{
                        $model->rollback();
                    }
                }else{
                    $model->rollback();
                }
            }
            echo json_encode($result);
        }else{
            $id = I('get.id');
            $storeProfilesInfo = $storeProfilesModel->find($id);
            $result = array('flag'=>0,'data'=>array());
            if(!empty($storeProfilesInfo)){
                $result['flag'] = 1;
                $result['data'] = $storeProfilesInfo;
            }
            echo json_encode($result);
        }

    }

     /*
     * 编辑详细合同档案
     */
    public function edit(){
        $storeProfileDetail = M('StoreProfilesDetail');
        if(IS_POST){
            $data = I('post.');
            $principal = $this->getMen(C('PRINCIPAL'));
            $data['principal'] = $principal[$data['principal_id']];
            $data['receive_time'] = strtotime($data['receive_time']);
            $data['start_time'] = strtotime($data['start_time']);
            $data['end_time'] = strtotime($data['end_time']);
            $data['updated_time'] = time();
            //对时间进行编辑
            $renewModel = M('StoreProfilesRenew');
            $info=$renewModel->where('store_profiles_detail_id='.$data['id'])->select();
            if(!empty($info)){
                $num = count($info)-1;
                if($info[$num]['renew_start_time']>$data['end_time']){
                    $this->error('请检查编辑时间发生冲突！');
                }else{
                    if($data['end_time'] != $info[$num]['renew_end_time']){
                        $datatime['renew_end_time'] = (int)$data['end_time'];
                        $resdata = $renewModel->where('id='.$info[$num]['id'])->save($datatime);
                        if(!$resdata){
                            $this->error('编辑失败！');
                        }
                    }
                }
            }
            
            if($storeProfileDetail->save($data)){
                $this->success('编辑成功', U('StoreProfiles/index',array('p'=>$data['nowpage'])));
            }else{
                $this->error('编辑失败！');
            }
        }else{
            $data = $storeProfileDetail->where("id=".I('get.id'))->select();
            //合同分类
            $where['is_show'] = C("NORMAL_STATUS");
            $where['pid'] = array('in',array(C('CATEGORY_STORE_ID'),));
            $category = M('category')->field('cid,pid,name')->where($where)->select();
            //dump($data);die;
            $this->assign('principal', $this->getBusinessMen());
            $this->assign('category',$category);
            $this->assign('memberStatus',getStoreMember());//会员类型
            $this->assign('data',$data);
            $this->assign('nowpage',I('get.np'));
            $this->display();
        }
    }
     /*
     * 删除续签时间
     */
    public function delRenewTime(){
        $id = I('post.id');
        $result = array('flag'=>0,'msg'=>'删除失败！');
        if(!empty($id)){
            $model = new \Think\Model();
            $model->startTrans();
            
            $storeProfilesRenew = M('StoreProfilesRenew');
            $info = $storeProfilesRenew->where('id = '.$id)->find();
            $data['end_time']=$info['up_end_time'];
            $res = M('StoreProfilesDetail')->data($data)->where('id='.$info['store_profiles_detail_id'])->save();
            //dump($res);die;
            $res_renew = $storeProfilesRenew->where('id = '.$id)->delete(); 
            if($res && $res_renew){
                $model->commit();
                $result = array('flag'=>1,'msg'=>'删除成功！');
            }else{
                $model->rollback();
            }
        }
        echo json_encode($result);
    }
    /*
     * 删除档案
     */
    public function delprofiles(){
        $id = I('POST.id');
        $idArray = explode(',',$id);
        $result = array('flag'=>0,'msg'=>'操作失败！');
        if(!empty($idArray[0])){
            $datas['status'] = C('DELETE_STATUS');
            $where['profiles_id'] =array('in',$idArray);
            $res = M('StoreProfilesDetail')->where($where)->save($datas);
            if($res){
                $result['flag'] = 1;
                $result['msg'] = '操作成功！';
            }
        }
        echo json_encode($result);
    }
     /*
     * 编辑档案
     */
    public function editprofiles(){
        if(IS_POST){
            $info = I('post.');
            $storeprofilesModel = M('StoreProfiles');
            $ret =  $storeprofilesModel->save($info);
            if(!is_bool($ret)){
                $this->success('编辑成功！',U('StoreProfiles/index',array('p'=>$info['nowpage'])));
            }else{
                $this->error('操作失败，请重新操作！');
            }
        }else{
            $condition['id'] = I('get.id');
            if(empty($condition['id'])){
                $this->error('操作失败，请重新操作！');
            }
            $condition['status'] = C("NORMAL_STATUS");
            $data = M('StoreProfiles')->where($condition)->select();
            //获取所有省份
            $fields = array('region_id,region_name,pid');
            $regionAll = $this->getRegionData('',$fields);
            foreach($regionAll as $v){
                if($v['pid'] == C('CHINA_NUM')){
                    $regions[] = $v;
                }
                if($v['pid'] == $data[0]['province_id']){
                    $cityRegion[] = $v;
                }
            }

            $where['is_show'] = C("NORMAL_STATUS");
            $where['pid'] = array('in',array(C('CATEGORY_GROUP_ID'),C('CATEGORY_MERCHANT_ID')));
            $category = M('category')->field('cid,pid,name')->where($where)->select();
            foreach($category as $key=>$val){
                if($val['pid'] == C('CATEGORY_MERCHANT_ID')){
                    $merchant[] = $category[$key];
                }else{
                    $cateGroup[] = $category[$key];
                }
            }
           
            $this->assign('merchant',$merchant);
            $this->assign('cateGroup',$cateGroup);
            $this->assign('province',$regions);
            $this->assign('citys',$cityRegion);
            $this->assign('np',I('get.np'));
            $this->assign('data',$data);
            $this->display();
        }
    }


    /*
     * 档案图片列表
     */
    public function imageList(){
        $id = I('get.id');
        if(empty($id)){
            $this->error('操作失败，请重新操作！');
        }
        $list = M('StoreProfilesImage')->where('profiles_detail_id='.$id)->select();
        $this->assign('list',$list);
        $this->assign('showStoreName',I('showStoreName'));
        $this->assign('np',I('np'));
        $this->assign('id',$id);
        $this->display();
    }
    /*
     * 添加电子档案图片
     */
    public function imageAdd(){
        if(IS_POST){
            $info = I('post.info');
            $images = upload('image',C('PROFILES_IMAGE_PATH'),array(array('100','100',1)));
            if(!$images){
                    $this->error($images['error']);
            }else{
                //插入数据表
                $StoreProfilesImage = M('StoreProfilesImage');
                foreach($images['images'] as $k=>$v){
                    $info['image'] = C('IMG_HOST').$v;
                    foreach($images['thumb'][$k] as $key=>$value){
                        $info['thumb_image'] = C('IMG_HOST').$value;
                    }
                    $res = $StoreProfilesImage->add($info);
                    if(!$res){
                        $this->error('操作失败，请重新操作！');
                    }
                }
                $this->success('添加成功',U('StoreProfiles/imageList',array('id'=>$info['profiles_detail_id'])));
            }
        }else{
            $id = I('get.id');
            if(empty($id)){
                $this->error('操作失败，请重新操作！');
            }
            $this->assign('id',$id);
            $this->display();
        }
    }
    
    /*
     * 删除电子档案图片
     */
    public function imageSmallDel(){
        if(IS_POST){
            $result = array('flag'=>0,'msg'=>'操作失败！');
            $id = explode(',',I('post.id'));
            $where['id'] = array('in',$id);
            $StoreProfilesImage = M('StoreProfilesImage');
            $data = $StoreProfilesImage->where($where)->select();
            $count = count($data);
            for($i=0;$i<$count;$i++){
                unlink('.'.$data[$i]['image']);
                unlink('.'.$data[$i]['thumb_image']);
            }
            $res = $StoreProfilesImage->where($where)->delete();
            if($res){
                $result = array('flag'=>1,'msg'=>'操作成功！');
            }
            echo json_encode($result);
        }
    }
    /*
     * 编辑电子合同
     */
    public function imageEdit(){
        if(IS_POST){
            $info = I('post.info');
            $StoreProfilesImage = M('StoreProfilesImage');
            $data = $StoreProfilesImage->where('id='.$info['id'])->find();
            if($_FILES['image']['tmp_name']){
                $images = upload('image',C('PROFILES_IMAGE_PATH'),array(array('100','100',1)));
                $info['image'] = C('IMG_HOST').$images['images'][0];
                $info['thumb_image'] = C('IMG_HOST').$images['thumb']['image'][0];
                unlink('.'.$data['image']);
                unlink('.'.$data['thumb_image']);
            }
            $res = $StoreProfilesImage->save($info);
            if(!is_bool($res)){
                $this->success('编辑成功',U('StoreProfiles/imageList',array('id'=>$data['profiles_detail_id'])));
            }else{
                $this->error('删除失败，请重新删除！');
            }

        }else{
            $id = I('get.id');
            if(empty($id)){
                $this->error('操作失败，请重新操作！');
            }
            $data = M('StoreProfilesImage')->where('id='.$id)->find();
            $this->assign('data',$data);
            $this->display();
        }
    }

    /*
     * 添加详情合同档案
     */
    public function addProfilesDetail(){
        if(IS_POST){
            //dump(I('post.'));die;
            $info = I('post.');
            $info['start_time'] = strtotime($info['start_time']);
            $info['end_time'] = strtotime($info['end_time']);
            $info['receive_time'] = strtotime($info['receive_time']);
            $info['status'] = C('NORMAL_STATUS');
            $info['updated_time'] = time();
            $principal = $this->getMen(C('PRINCIPAL'));
            $info['principal'] = $principal[$info['principal_id']];
            $res = M('StoreProfilesDetail')->add($info);
            if($res){
                $this->success('添加成功',U('StoreProfiles/index'));
            }else{
                $this->error('操作失败，请重新操作！');
            }
        }else{
            $profiles_id = I('get.id');
            if(empty($profiles_id)){
                $this->error('操作失败，请重新操作！');
            }

            $where['is_show'] = C("NORMAL_STATUS");
            $where['pid'] = array('in',array(18));
            $category = M('category')->field('cid,pid,name')->where($where)->select();
            //dump($category);
            $memberStatus=getStoreMember();//会员状态 eg:个人会员 商家会员
            $this->assign('memberStatus',$memberStatus);
            $this->assign('principal', $this->getBusinessMen());
            
            $this->assign('category',$category);
            $this->assign('profiles_id',$profiles_id);
            $this->assign('nowpage',I('get.np'));
            $this->display();
        }
    }

    /*
     *已删除商家
     *
     */
    public function deleteStoreList(){
        $condition = I('get.');
        if(!empty($condition['show_store_name'])){
            $where['show_store_name'] = array('like','%'.$condition['show_store_name'].'%');
        }
        if(!empty($condition['province_id'])){
            $where['province_id'] = $condition['province_id'];
        }

        
        $storeProtilesDetailId = M('StoreProfilesDetail')->field('profiles_id')->where('status = '.C('DELETE_STATUS'))->select();
        foreach($storeProtilesDetailId as $v){
            $tmpDataId[] = $v['profiles_id'];
        }
        if(empty($tmpDataId)){
            $where['id'] = 0;
        }else{
            $where['id'] = array('in',array_unique($tmpDataId));
        }
        
        $StoreProfilesModel = D('StoreProfiles');
        $totalRows = $StoreProfilesModel->where($where)->count();
        //接收分页的参数，如果没有值就默认为1
        $p = I('p');
        $nowPage = empty($p) ? C('PAGE_DEFAULT') : $p;
        $page = new Page($totalRows,C('PAGE_SIZE'));
        $pagelist = $page->show();
        $list = $StoreProfilesModel->relation(array('Province','City','DelStoreProtilesDetail'))->where($where)->limit($page->firstRow,$page->listRows)->order('id desc')->select();
        foreach($list as $k=>$v){
            $list[$k]['profiles_detail_num'] = count($v['DelStoreProtilesDetail'])+1;
        }
        //地区信息
        $regionWhere['pid'] = C('CHINA_NUM');
        $regionFields = array('region_id,region_name');
        $province = $this->getRegionData($regionWhere,$regionFields,'',true);
       
        //分类信息
        $categoryFields = array('cid,name');
        $category = $this->getCategoryData('',$categoryFields);
        //dump($list);die;
        $this->assign('condition',$condition);
        $this->assign('province',$province);
        $this->assign('category',$category);
        $this->assign('nowPage',$nowPage);
        $this->assign('page',$pagelist);
        $this->assign('list',$list);
        $this->display();
    }
    /*
     * 开启已删除商家
     */
    public function enable(){
        $data['id'] = I('post.id');
        if(empty($data['id'])){
            $this->error('操作失败，请重新操作！');
        }
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $data['status'] = C('NORMAL_STATUS');
        $res = M('StoreProfilesDetail')->save($data);
        if($res){
            $result['flag'] = 1;
            $result['msg'] = '操作成功！';
        }
        echo json_encode($result);
    }
    
    /*
     * 合同预览
     */
    public function preview(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $id = I('post.id');
        if(!empty($id)){
            $list = D('StoreProfiles')->relation(array('StoreProfilesDetail','StoreProfilesRenew','Province','City'))->where('id='.$id)->find();
            $category = $this->getCategoryData('',array('cid','name'),'',true);//获取分类
            $memberStatus = getStoreMember();//会员状态 eg:个人会员 商家会员
            $list['category_id'] = $category[$list['category_id']];
            $list['category_group_id'] = empty($category[$list['category_group_id']])?'':$category[$list['category_group_id']];
            $storeProfilesImageModel = M('StoreProfilesImage'); 
            $payBanks = C('PAY_BANKS');
            foreach($list['StoreProfilesDetail'] as $k=>$v){
                $list['StoreProfilesDetail'][$k]['Renew'] = '';
                $list['StoreProfilesDetail'][$k]['max_price'] =($v['max_price'] == 0)?'':$v['max_price'].'万';
                $list['StoreProfilesDetail'][$k]['min_price'] = ($v['min_price'] == 0)?'':$v['min_price'].'万~';
                $list['StoreProfilesDetail'][$k]['distribution_area'] = empty($v['distribution_area'])?'':$v['distribution_area'];
                $list['StoreProfilesDetail'][$k]['category_id'] = $category[$v['category_id']];
                $list['StoreProfilesDetail'][$k]['member_status'] =$memberStatus[$v['member_status']];
                $list['StoreProfilesDetail'][$k]['start_time'] = empty($v['start_time'])?'':date("Y-m-d",$v['start_time']); 
                $list['StoreProfilesDetail'][$k]['end_time'] = empty($v['end_time'])?'':date("Y-m-d",$v['end_time']);
                $list['StoreProfilesDetail'][$k]['receive_time'] =empty($v['receive_time'])?'':date("Y-m-d",$v['receive_time']); 
                $list['StoreProfilesDetail'][$k]['principal'] =empty($v['principal'])?'':$v['principal']; 
                $list['StoreProfilesDetail'][$k]['bank'] = empty($payBanks[$v['bank']])?'':$payBanks[$v['bank']];
                $list['StoreProfilesDetail'][$k]['bank_member'] =empty($v['bank_member'])?'':$v['bank_member'];
                $list['StoreProfilesDetail'][$k]['bank_account'] =empty($v['bank_account'])?'':$v['bank_account'];
                $renewStr = '';
                foreach($list['StoreProfilesRenew'] as $key=>$value){
                    if($v['id']==$value[store_profiles_detail_id]){
                        $renewStr .= (date("Y-m-d",$value['renew_start_time']).'至'.date("Y-m-d",$value['renew_end_time']).'<br/>');
                    }
                }
                $list['StoreProfilesDetail'][$k]['Renew'] = $renewStr;
                //电子合同图片
                $imageStrOne = '';
                $imageStrTwo = '';
                $imageData = $storeProfilesImageModel->where('profiles_detail_id = '.$list['StoreProfilesDetail'][$k]['id'])->select();
                foreach($imageData as $image){
                    if($image['type'] == 1){
                        $imageStrOne .= '<img onclick="zoomInImage(this);" data-image='.$image['image'].' src='.$image['thumb_image'].' title='.$image['image_name'].'>&nbsp;';
                    }else if($image['type'] == 2){
                        $imageStrTwo .= '<img onclick="zoomInImage(this);" data-image='.$image['image'].' src='.$image['thumb_image'].' title='.$image['image_name'].'>&nbsp;';
                    }
                }
                $list['StoreProfilesDetail'][$k]['imagePrice'] = $imageStrTwo;//价格图片
                $list['StoreProfilesDetail'][$k]['imageElec'] = $imageStrOne;//电子合同图片
            }
            $result=array('flag'=>1,'data'=>$list);
        }
        echo json_encode($result);
    }
}