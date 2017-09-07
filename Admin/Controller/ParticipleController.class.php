<?php
namespace Admin\Controller;
use Think\Model\RelationModel;
use Admin\Controller\BaseController;
use Think\Page;
 /**
  * 这是搜索分词控制器
  * @author Wang Dong <wangdong@huigeyuan.com>
  * @version 1.0
  * @table('search_engine')
  */
 class ParticipleController extends  BaseController 
 {
 	/**
 	 * 这是搜索分词列表页
 	 */
 	public function index() {
 		//获取前台传输的别名和商家类型
        $getVal = I('get.'); 
 		$where = array();
 		if(!empty($getVal['store_nick_name'])){
            $where['store_nick_name'] = array('like','%'.$getVal['store_nick_name'].'%');
        }
        if(!empty($getVal['store_style'])){
            $where['store_style'] = $getVal['store_style'];
        }
        $arr = array(C('NORMAL_STATUS'),C('DEFAULT_STATUS'));
        $where['status'] = array('in',$arr);
        $participleModel = M('SearchEngine');
        $totalRows = $participleModel->where($where)->count();
        $result = $participleModel->where($where)->select();
        // dump($result);exit;
        //数据总条数
        //接收分页的参数，如果没有值就默认为1
        $p = I('p');  
        $nowPage = empty($p) ? C('PAGE_DEFAULT') : $p;
        $page = new Page($totalRows,C('PAGE_SIZE'));
        $pagelist = $page->show();
        $list = $participleModel->where($where)->limit($Page->firstRow.','.$Page->listRows)->order("`created_time` DESC")->select();//relation(true)
        $this->assign('nowPage',$nowPage);
        $this->assign('page',$pagelist);
        $this->assign('list',$list);
        $this->assign('result',$result);
	    $this->display();
 	}


 	public function add() {
 		if(IS_POST){
 			 $data = I('post.');
             $where['store_name'] = $data['store_name'];
             $where['store_style'] = $data['store_style'];

             $storedata['store_name'] = $data['store_name'];
             $storedata['store_style'] = $data['store_style'];
             $storedata['ruby'] = $data['ruby'];
             $storedata['member_status'] = $data['member_status'];
             $storedata['status'] = '1';
             $storedata['store_main_name'] = $data['store_main_name'];
             $storedata['admin_id'] = session('admin_id'); 
 			 $storedata['updated_time'] = date('Y-m-d H:i:s',time());
             $storedata['created_time'] = time();
             $storedata['store_nick_name'] = $data['store_nick_name']; 
             // $storedata['store_nick_name'] = explode(',',$store);   
        	 $participleModel = M('SearchEngine');
        	 $participle = $participleModel->where($where)->find();
        	 if(!empty($participle)) {
        	 	$this->error('添加失败，该商家已存在');
        	 }
        	 $info = $participleModel->add($storedata);
        	 if($info) {
        	 	$this->assign('store',$store);
        	 	$this->success('添加商家搜索分词成功',U('Participle/index'));
        	 }else{
        	 	$this->error('添加失败');
        	 }
 		}else{
 			 //地区处理
	        $region = M('region');
	        $provinceWhere['state'] = C('NORMAL_STATUS');
	        $cityRegion = array();
	        if(!empty($choice['province'])){
	            $provinceWhere['pid'] = array('in',array($choice['province'],C('CHINA_NUM')));
	            $seachRegionAll = $region->where($provinceWhere)->select();
	            foreach($seachRegionAll as $key=>$val){
	                if($val['pid'] == C('CHINA_NUM')){
	                    $provinceRegion[] =  $seachRegionAll[$key];
	                }else{
	                    $cityRegion[] = $seachRegionAll[$key];
	                }
	            }
	        }else{
	            $provinceWhere['pid'] = C('CHINA_NUM');
	            $provinceRegion = $region->where($provinceWhere)->select();
	        }
        	 $this->assign('province',$provinceRegion);
        	 $this->assign('city',$cityRegion);
             $this->assign("regions", $regions);
	   		 $this->display();
 		}
 	}


 	public function edit($id) {
 		$part = M('SearchEngine');
 		if(IS_POST){
 			 $data = I('post.');
 			 $data['updated_time'] = date('Y-m-d H:i:s',time());
        	 $data['admin_id'] = session('admin_id');

        	 $participleModel = M('SearchEngine');
        	 $where['id'] = array('neq',$data['id']);
        	 $where['store_name'] = $data['store_name'];
        	 $participle = $participleModel->where($where)->find();
        	 if(!empty($participle)) {
        	 	$this->error('修改失败，该商家已存在');
        	 }
        	 $info = $participleModel->data($data)->save();
        	 if($info) {
        	 	$this->success('修改成功',U('Participle/index'));
        	 }else{
        	 	$this->error('修改失败');
        	 }
 		}else{
 			$where['id'] = I('get.id');
 			$data = $part->where($where)->find();
 			$this->assign('data',$data);
 			$this->display();
 		}
 	}


 	public function delete() {
	  if(IS_POST){
            $postInfo = I('post.');
            $participleModel = M('SearchEngine');
            $result = array('flag'=>0,'msg'=>'操作失败');
            if($postInfo['act']=='del'){
                $data['id'] = $postInfo['id'];
                $data['status'] = C('DELETE_STATUS');
                // 状态改为-1
                if($participleModel->create($data) && $participleModel->save()) {
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }
            }else if($postInfo['act']=='enable') {
                $data['id'] = $postInfo['id'];
                $data['status'] = C('NORMAL_STATUS');
                // 状态改为1
                if($participleModel->create($data) && $participleModel->save()) {
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }
            }
            echo json_encode($result);
        }
 	}

   
 	
	/**
     * 通过选择省份改变市ajax获取省份ID
     */
    public function getCityList() {
        if (IS_POST) {
            $province_id = I('province_id');
            $regionObj = M("region");
            $data = $regionObj->where("level=2 and pid=" . $province_id)->select();
            $this->ajaxReturn($data, 'JSON');
        }else{
            $this->error('省份ID不存在');
        }
    }

    /**
	 * 通过ajax传输的市ID查找商家名称
	 */
	public function getStoreList() {
		if(IS_POST){
			$where['city_id'] = I('city_id');
            $store_style = I('store_style');

            if(!empty($store_style)){
                $where['category_id'] = $store_style;
            }
			//暂时借用合同信息表
			$storeObj = M('Store');
			$data = $storeObj->where($where)->field('store_id,store_name,city_id')->select();
			$this->ajaxReturn($data, 'JSON');
		}else{
			$this->error('城市不存在');
		}
	}

	/**
	 * 通过AJAX传输的陵园名查找会员状态
	 */
	public function getMemberStatus() {
		if(IS_POST) {
			$store_id = I('post.store_id');
			$storeObj = M('Store');
			$data = $storeObj->where("store_id=".$store_id)->field('member_status')->find();//'member_status'=>'20'
            $member_status = C('MEMBER_STATUS');
            $data['member_status'] = $member_status[$data['member_status']];
			$this->ajaxReturn($data['member_status'],'JSON');
		}else{
			$this->error('会员状态不存在');
		}
	}



 } 