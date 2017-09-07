<?php 
namespace Admin\Controller;
use Admin\Controller\BaseController;

/**
 * 仓库管理
 */
class StorageController extends BaseController
{
    /*
     * 通过选择省份改变市ajax获取省份ID
     */
    public function getCityList(){
        if (IS_POST) {
            $province_id = I('province_id');
            $regionObj = M("region");
            $data = $regionObj->where("level=2 and pid=" . $province_id)->select();
            $this->ajaxReturn($data, 'JSON');
        }else{
            $this->error('省份ID不存在');
        }
    }

    //仓库列表
    public function index(){
        $storage = D('Storage');
        //获取省信息
        $province = M('region')->field('region_id,region_name,level,pid')->where('level=1')->select();
        //接收搜索表单传过来的省市ID和项目名称
        $info = I('get.');
        /*$storage_name = empty($info['storage_name']) ? '' : $info['storage_name'];
        $province_id = empty($info['province_id']) ? '' : $info['province_id'];
        $city_id = empty($info['city_id']) ? '' : $info['city_id'];*/
        //构造查询条件
        if(!empty($info['storage_name'])){
                $map['storage_name'] = array('like','%'.$info['storage_name'].'%');
        }
        if(!empty($info['province_id'])){
                $map['province_id'] = array('eq',$info['province_id']);
        }
        if(!empty($info['city_id'])){
                $map['city_id'] = array('eq',$info['city_id']);
        }

        //项目总数量
        $count = $storage->where($map)->count();
        //接收分页的的参数,如果没有默认为1
        $p= I('p');
        $nowPage = empty($p) ? C('PAGE_DEFAULT'):$p;
        $Page = new \Think\Page($count,C('PAGE_SIZE'));
        $show = $Page->show();

        //分页数据查询
        $list = $storage->where($map)->relation(array('Province','City'))->order('created_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $citys = array();
        if(!empty($info['province_id'])){
                $citys = M('region')->where('pid='.$info['province_id'])->select();
        }
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->assign('province',$province);
        $this->assign('city',$citys);
        $this->assign('nowPage',$nowPage);
        $this->display();
    }

    //添加仓库
    public function addStorage(){
        $province = $this->getRegionData('level=1','region_id,region_name,level,pid','',false);
        $this->assign('province',$province);
        $this->display();
    }

    //修改仓库
    public function editStorage(){
        $storage = M('storage');
        $id = I('get.id');
        $nowPage = I('get.p');
        if($id){
            $result = $storage->where('id='.$id)->find();
            $province = M('region')->field('region_id,region_name,level,pid')->where('level=1')->select();
            $city = array();
            if(!empty($result['province_id'])){
                $city = M('region')->where("pid=".$result['province_id'])->select();
            }
            $this->assign('nowPage',$nowPage);
            $this->assign('province',$province);
            $this->assign('city',$city);
            $this->assign('result',$result);
            $this->display();
        }
    }

    //保持添加修改仓库
    public function saveStorage(){
        $storage = M('storage');
        $act = I('post.act');
        if($act=='add'){
            $info = I('post.info');
            $info['created_time'] = time();
            $info['updated_time'] = time();
            $res = $storage->add($info);
            if($res){
                    $this->success('添加仓库成功',U('Storage/index'));
            }else{
                    $this->error('添加仓库失败');
            }
        }if($act=='edit'){
            $info = I('post.info');
            $id = I('post.id');
            $nowPage = I('post.nowPage');
            $res = $storage->where('id='.$id)->save($info);
            if($res){
                $this->success('修改仓库成功',U('Storage/index',array('p'=>$nowPage)));
            }else{
                $this->error('修改仓库失败');
            }
        }
    }

    //删除开启仓库
    public function delStorage(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $data['id'] = I('post.id');
        $data['status'] = I('post.status');
        if(!empty($data['id'])){
            if(M('Storage')->save($data)){
                $result['flag'] = 1;
                $result['msg'] = '操作成功！';
            }
        }
        echo json_encode($result);
    }
    
    /*
     * 仓库申请列表
     * returu void;
     */
    public function apply(){
        $service_goods_name = I('get.service_goods_name');
        if(!empty($service_goods_name)){
            $where['service_goods_name'] = array('like','%'.$service_goods_name.'%');
        }
        $applicationModel = M('Application');
        
        $count = $applicationModel->where($where)->count();
        //接收分页的的参数,如果没有默认为1
        $p= I('p');
        $nowPage = empty($p) ? C('PAGE_DEFAULT'):$p;
        $Page = new \Think\Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $applicationModel->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('id desc')->select();
        //dump($list);die;
        $this->assign('page',$show);
        $this->assign('nowPage',$nowPage);
        $this->assign('list',$list);
        $this->display();
    }
     /*
     * 编辑申请单
     * return void;
     */
    public function editApply(){
        $id = I('get.id');
        if(IS_POST){
            $info = I('post.info');
            $nowPage = I('post.nowPage');
            $serviceGoods = M('ServiceGoods')->field('skuid,name')->where('id ='.$info['service_goods_id'])->find();
            $info['skuid'] = $serviceGoods['skuid'];
            $info['service_goods_name'] = $serviceGoods['name'];
            $info['supplier_name'] = C('SUPPLIER.'.$info["supplier_id"]);
            $storage = M('storage')->field('storage_name')->where('id = '.$info['storage_id'])->find();
            $info['storage_name'] = $storage['storage_name'];
            $res = M('Application')->save($info);
            if(!is_bool($res)){
                $this->success('编辑成功！',U('Storage/apply',array('p'=>$nowPage)));
            }
        }else if(!empty($id)){
            $nowPage = I('get.p');
            $data = M('Application')->where('id = '.$id)->find();
            $serviceGoods = M('ServiceGoods')->select();
            $storage = M('storage')->field('id,storage_name')->where('status = '.C('NORMAL_STATUS'))->select();
            $this->assign('storage',$storage);
            $this->assign('serviceGoods',$serviceGoods);
            $this->assign('data',$data);
            $this->assign('nowPage',$nowPage);
            $this->display();
        }else{
            $this->error('操作失败！');
        }
    }
    /*
     * 删除申请单
     * return json|string;
     */
    public function delApply(){
        $result = array('flag'=>'0','msg'=>'操作失败！');
        $id = I('post.id');
        if(!empty($id)){
            if(M('Application')->where('id = '.$id)->delete()){
                $result['flag'] = 1;
                $result['msg'] = '操作成功！';
            }
        }
        echo json_encode($result);
    }
    /*
     * 审核申请单
     * return json|string;
     */
    public function checkApply(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $action = I('post.action');
        if($action == 'select'){
            $id = I('post.id');
            $data = M('Application')->where('id = '.$id)->find();
            $result['flag'] = 1;
            $result['msg'] = '操作成功！';
            $result['data'] = $data; 
        }else if($action == 'submit'){
            $model = new \Think\Model();
            $model->startTrans();
            
            $applicationModel = M('Application');
            $info = I("post.info");
            if($info['status'] == 1){
                //向财务插入数据
                $dataApp = $applicationModel->where('id ='.$info["id"])->find();
                $financial['application_sn'] = $dataApp['application_sn'];
                $financial['skuid'] = $dataApp['skuid'];
                $financial['service_goods_name'] = $dataApp['service_goods_name'];
                $financial['total_price'] = $info['replay_total_price'];
                $financial['payable'] = $info['replay_total_price'];
                $financial['arrears'] = $info['replay_total_price'];
                $financial['status'] = C('DEFAULT_STATUS');
                $financial['created_time'] = time();
                $financial['updated_time'] = time();
                if(!(M('Financial')->add($financial))){
                    echo json_encode($result);die;
                }
                unset($info['reason']);
            }else if($info['status'] == 2){
                $info['status'] = 2;
                unset($info['reply_number']);
                unset($info['replay_total_price']);
            }
            $name = M('admin')->field('nickname')->where('id = '.session('admin_id'))->find();
            $info['reviewed'] = $name['nickname'];
            $info['reviewed_id'] = session('admin_id');
            $info['reviewed_time'] = time();
            $resApp = $applicationModel->where('id ='.$info["id"])->save($info);
            if(!is_bool($resApp)){
                $model->commit();
                $result['flag'] = 1;
                $result['msg'] = '操作成功！';
            }else{
                $model->rollback();
            }
        }
        echo json_encode($result);
    }
    
    /*
     * (申请单)入库
     * return json|string;
     */
    public function addInventory(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $id = I('post.id');
        if(!empty($id)){
            $data = M('Application')->where('id = '.$id)->find();
            if(!empty($data)){
                $model = new \Think\Model();
                $model->startTrans();
                $map['status'] = 3;
                $res = M('Application')->where('id = '.$id)->save($map);
                if($res){
                    $data['number'] = $data['reply_number'];
                    $data['admin_id'] = session('admin_id');
                    $data['add_time'] = time();
                    $data['updated_time'] = time();
                    $addInventory = M('Inventory')->add($data);
                    //库存表中添加数据 
                    $inventoryMainModel = M('InventoryMain');
                    $findData = $inventoryMainModel->where('skuid = '.$data['skuid'].' and storage_id = '.$data['storage_id'])->find();
                    if(empty($findData)){
                        $info['skuid'] = $data['skuid'];
                        $info['service_goods_name'] = $data['service_goods_name'];
                        $info['inventory'] = $data['reply_number'];
                        $info['purchase'] = $data['reply_number'];
                        $info['storage_id'] = $data['storage_id'];
                        $info['storage_name'] = $data['storage_name'];
                        $addInventoryMain = $inventoryMainModel->add($info);
                    }else{
                        $info['inventory'] = $data['reply_number']+$findData['inventory'];
                        $info['purchase'] = $data['reply_number']+$findData['purchase'];
                        $addInventoryMain = $inventoryMainModel->where('id = '.$findData['id'])->save($info);
                    }
                   
                    if($addInventory && $addInventoryMain){
                        $model->commit();
                        $result['flag'] = 1;
                        $result['msg'] = '操作成功！';
                    }else{
                        $model->rollback();
                    }
                }
            }
        }
        echo json_encode($result);
    }
    /*
     * 入库单(信息)
     * return void;
     */
    public function inputInventory(){
        $service_goods_name = I('get.service_goods_name');
        $storage_name = I('get.storage_name');
        if(!empty($storage_name)){
            $where['storage_id'] = array('like','%'.$storage_name.'%');
        }
        if(!empty($service_goods_name)){
            $where['service_goods_name'] = array('like','%'.$service_goods_name.'%');
        }
        $inventoryModel = D('Inventory');
        $count = $inventoryModel->where($where)->count();
        $Page = new \Think\Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $inventoryModel->relation('Admin')->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('id desc')->select();
        //dump($list);die;
        $storage = M('Storage')->field('id,storage_name')->where('status = '.C('NORMAL_STATUS'))->select();
        $this->assign('storage',$storage);
        $this->assign('page',$show);
        $this->assign('list',$list);
        $this->display();
    }
    
    /*
     * 库存列表
     * return void;
     */
    public function inventory(){
        $service_goods_name = I('get.service_goods_name');
        $storage_name = I('get.storage_name');
        if(!empty($storage_name)){
            $where['storage_id'] = array('like','%'.$storage_name.'%');
        }
        if(!empty($service_goods_name)){
            $where['service_goods_name'] = array('like','%'.$service_goods_name.'%');
        }
        $inventoryModel = M('InventoryMain');
        $count = $inventoryModel->where($where)->count();
        $Page = new \Think\Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $inventoryModel->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('id desc')->select();
        //dump($list);die;
        $storage = M('Storage')->field('id,storage_name')->where('status = '.C('NORMAL_STATUS'))->select();
        $this->assign('storage',$storage);
        $this->assign('page',$show);
        $this->assign('list',$list);
        $this->display();
    }
    
    /*
     * 出库 (暂不使用)
     * return json|string;
     */
    public function outputInventory(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $action = I('post.action');
        $id = I('post.id');
        $inventoryMainModel = M('InventoryMain');
        if($action == 'select'){
            $data = $inventoryMainModel->where('id = '.$id)->find();
            $result['flag'] = 1;
            $result['msg'] = '操作成功！';
            $result['data'] = $data;
        }else if($action == 'submit'){
            $info = I('post.info');
            $data = $inventoryMainModel->where('id = '.$info['id'])->find();
            $datas['inventory'] = $data['inventory'] - $info['number'];
            $datas['shipping'] = $data['shipping'] + $info['number'];
            $res = $inventoryMainModel->where('id = '.$info['id'])->save($datas);
            
            dump($info);die;
            $result['flag'] = 1;
            $result['msg'] = '操作成功！';
        }
        echo json_encode($result);
    }
    
    /*
     * 出货列表
     * return void;
     */
    public function outputGoods(){
        $order_main_sn = I('get.order_main_sn');
        $storage_name = I('get.storage_name');
        if(!empty($storage_name)){
            $where['storage_id'] = array('like','%'.$storage_name.'%');
        }
        if(!empty($order_main_sn)){
            $where['order_main_sn'] = array('like','%'.$order_main_sn.'%');
        }
        $dispatchModel = M('Dispatch');
        $count = $dispatchModel->where($where)->count();
        $Page = new \Think\Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        $list = $dispatchModel->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('id desc')->select();
        $storage = M('Storage')->getField('id,storage_name');
        $serviceGoods = M('ServiceGoods')->getField('skuid,name');
        $this->assign('serviceGoods',$serviceGoods);
        $this->assign('storage',$storage);
        $this->assign('page',$show);
        $this->assign('list',$list);
        $this->display();
    }
    /*
     * (订单)出货
     * return json|string;
     */
    public function outputOrder(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $id = I('post.id');
        $action = I('post.action');
        if($action == 'select'){
            $data = M('Dispatch')->field('id,number')->where('id = '.$id)->find();
            if(!empty($data)){
                $result = array('flag'=>1,'msg'=>'OK!','data'=>$data);
            }
        }else if($action == 'submit'){
            $info = I('post.info');
            $info['delivery_time'] = time();
            $name = M('admin')->field('nickname')->where('id = '.session('admin_id'))->find();
            $info['delivery_man'] = $name['nickname'];
            $info['take_stock_time'] = time();
            $info['status'] = 2;
            $info['updated_time'] = time();
            if(M('Dispatch')->save($info)){
                $result = array('flag'=>1,'msg'=>'操作成功！');
            }
        }
        echo json_encode($result);
    }
    
}


 