<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;
use Think\Page;
/**
 * 友情链接控制器
 * @author Wang Qiang <wangqiang@huigeyuan.com>
 */
class FriendlinkController extends BaseController
{
	/**
	 * 友情链接列表
	 */
	public function index(){
            $friendlinkModel = D('friendlink');
            $totalRows = $friendlinkModel->count();
            $page = new Page($totalRows,C('PAGE_SIZE'));
            $pageshow = $page->show();
            $list = $friendlinkModel->field('id,name,province_id,city_id,status,url')->limit($page->firstRow, $page->listRows)->order('created_time desc')->select();
            $where['pid'] = array('in',"0,".C('CHINA_NUM'));
            $where['state'] = C('NORMAL_STATUS');
            $province = $this->getRegionData($where,array('region_id,region_name'),'',true);
            //获取省名称
            foreach ($list as $key => $value) {
                $province_name='';
                $province_id = explode(',',$value['province_id']);
                foreach ($province_id as $k => $v) {
                    $province_name.=$province[$v].',';
                    $list[$key]['province_id'] =rtrim($province_name,','); 
                }
            }
            $this->page = $pageshow;
            $this->list = $list;
            $this->display();
	}

	/**
	 * 添加友情链接
	 */
	public function add(){
        $result = array('flag'=>0,'msg'=>'操作失败');
		if(IS_POST){
            $postData = I('post.');
            $postData['province_id'] = rtrim(implode(',',$postData['province_id']),',');
            $postData['admin_id'] = session('admin_id');
            $postData['created_time'] = time();
            $friendlinkModel = M('Friendlink');
            if($friendlinkModel->create($postData) && $friendlinkModel->add()){
                $result = array('flag'=>1,'msg'=>'添加成功');
            }
        }else{
            $regionWhere['pid'] = array('in',"0,".C('CHINA_NUM'));
            $regionWhere['state'] = C('NORMAL_STATUS');
            $regionData = $this->getRegionData($regionWhere,array('region_id,region_name'));
            if(!empty($regionData)){
                $result['flag'] = 1;
                $result['province'] = $regionData;
            }
        }
        echo json_encode($result);
	}

	/**
	 * 编辑友情链接
	 */
	public function edit($id){
		$friendlinkModel = M('friendlink');
        $result = array('flag'=>0,'msg'=>'操作失败');
		if(IS_POST){
            $postData = I('post.'); 
            $page = $postData['page']==''?1:$postData['page'];
            $postData['admin_id'] = session('admin_id');
            $postData['updated_time'] = time();
            $postData['province_id'] = rtrim(implode(',',$postData['province_id']),',');
            if($friendlinkModel->create($postData) && $friendlinkModel->save()){
                $result['flag'] = 1;
                $result['msg'] = '修改成功';
            }
        }else{
            $provWhere['pid'] = array('in',"0,".C('CHINA_NUM'));
            $provWhere['state'] = C('NORMAL_STATUS');
            $province = $this->getRegionData($provWhere,array('region_id,region_name'));
            $data = $friendlinkModel->where('id='.$id)->field('id,name,province_id,city_id,sort,status,url')->find();
            $result['flag'] = 1;
            $result['province'] = $province;
            $result['data'] = $data;
        }
        echo json_encode($result);
	}

	/**
	 * 删除友情链接
	 */
	public function delete(){
		if(IS_POST){
            $result = array('flag'=>0,'msg'=>'操作失败');
            $postData = I('post.');
            $friendlinkModel = M('friendlink');
            if($postData['act'] == 'del'){
                $data['id'] = $postData['id'];
                $data['status'] = C('DELETE_STATUS');
                if($friendlinkModel->create($data) && $friendlinkModel->save()){
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }
            }else if($postData['act'] == 'enable'){
                $data['id'] = $postData['id'];
                $data['status'] = C('NORMAL_STATUS');
                if($friendlinkModel->create($data) && $friendlinkModel->save()){
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }
            }
            echo json_encode($result);
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
}