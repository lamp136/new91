<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;
use Think\Page;
/**
 * 广告管理
 * @author Wang Qiang <[<wangqiang@huigeyuan.com>]>
 */
class AdBannerController extends BaseController
{
	/**
	 * 广告列表
	 */
	public function index(){
		$getSearch = I('get.');
        //封装搜索条件
        if(!empty($getSearch['advertising_position_id'])){
            $map['ad_position_id'] = array('eq',$getSearch['advertising_position_id']);
        }
        if(!empty($getSearch['province_id'])){
            $map['province_id'] = array('eq',$getSearch['province_id']);
        }
        
        $adbannerModel = D('AdvertisingBanner');
        $totalRows = $adbannerModel->where($map)->count();
        $page = new Page($totalRows,C('PAGE_SIZE'));
        $pageshow = $page->show();
        $list = $adbannerModel->relation(array('Adpos','Province'))->limit($page->firstRow, $page->listRows)->where($map)->order('banner_id desc')->select();
        // dump($list);exit;
        $regionWhere['pid'] =  array('in', array(C('CHINA_NUM'), 0));
        $regionWhere['state'] = C('NORMAL_STATUS');
        //查询省份(搜索中的)
        $region = $this->getRegionData($regionWhere,array('region_id,region_name'),'',false);
        //查询广告位(搜索中的)
        $this->getAdpos();
        
        $this->getSearch = $getSearch;
        $this->province = $region;//遍历省份(搜索中的)
        $this->page = $pageshow;
        $this->list = $list;
        $this->display();
	}

	/**
	 * 添加广告
	 */
	public function add(){
		$adBannerModel = D('AdvertisingBanner');
		$adPositionModel = D('AdvertisingPosition');
		if(IS_POST){
			$result = array('flag'=>0,'msg'=>'操作失败');
			if($adBannerModel->create() && $adBannerModel->add()){
                $this->success('操作成功',U('index'));
            }else{
                $this->error('添加失败');
            }
		}else{
			$this->getAdpos();
            $regionWhere['pid'] =  array('in', array(C('CHINA_NUM'), 0));
            $regionWhere['state'] = C('NORMAL_STATUS');
            $region = $this->getRegionData($regionWhere,array('region_id,region_name'),'');
            $this->bannerType = C('BANNER_TYPE');
            $this->provinces = $region;
			$this->display();
		}
	}

	/**
	 * 编辑广告
	 */
	public function edit($id,$p=''){
		if(IS_POST){
            if(empty($p)){
                $p=1;
            }
            $adbannerModel = D('AdvertisingBanner');
            if($adbannerModel->create() && $adbannerModel->save()){
                $this->success('编辑成功',U('index',array('p'=>$p)));
            }else{
                $this->error('编辑失败');
            }
        }else{
            // 获取广告位
            $this->getAdpos();
            $fields = array('banner_id,banner_name,banner_type,banner_link,province_id,start_time,end_time,ad_position_id,status,share,sort');
            $adbanner = M('AdvertisingBanner')->field($fields)->find($id);
            // dump($adbanner);exit;
            $regionWhere['pid'] = array('in', array(C('CHINA_NUM'), 0));
            $regionWhere['state'] = C('NORMAL_STATUS');
            $region = $this->getRegionData($regionWhere,array('region_id,region_name'),'');
            $this->bannerType = C('BANNER_TYPE');
            $this->provinces = $region;
            $this->adbanner = $adbanner;
            $this->display();
        }
	}

	public function getAdpos(){
		$AdPositionModel = M('AdvertisingPosition');
		$fields = array('id,position_name,advertising_width,advertising_height');
        $adpos = $AdPositionModel->field($fields)->select();
        $this->adpos = $adpos;
	}

	/**
	 * 删除广告
	 */
	public function delete(){
		if(IS_POST){
            $postInfo = I('post.');
            $adbannerModel = M('AdvertisingBanner');
            $result = array('flag'=>0,'msg'=>'操作失败');
            if($postInfo['act'] == 'del'){
                $data['banner_id'] = $postInfo['id'];
                $data['status'] = C('DELETE_STATUS');
                $data['admin_id'] = session('admin_id');
                $data['updated_time'] = time();
                if($adbannerModel->create($data) && $adbannerModel->save()){
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }
            }else if($postInfo['act'] == 'enable'){
                $data['banner_id'] = $postInfo['id'];
                $data['status'] = C('NORMAL_STATUS');
                $data['admin_id'] = session('admin_id');
                $data['updated_time'] = time();
                if($adbannerModel->create($data) && $adbannerModel->save()){
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }
            }
            echo json_encode($result);
        }
	}
}