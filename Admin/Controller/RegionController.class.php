<?php

namespace Admin\Controller;

use Admin\Controller\BaseController;

/**
 * Description of RegionController
 *
 * @author hqy
 */
class RegionController extends BaseController {

    /**
     * 地区列表
     */
    public function index() {
        $regionModel = D('region');
        $regionData = $regionModel->order('region_id asc,sort desc')->select();
        $list = $regionModel->RegionTree($regionData, 0);
        $this->assign('region', $list);
        $this->display();
    }
    /**
     * 地区添加
     */
    public function add() {
        if (IS_POST) {
            $result = array('flag' => 0, 'msg' => '操作失败');
            $postData = I('post.');
            $regionModel = M('region');
            if ($postData['pid'] == 0) {
                $postData['level'] = 0;
            } else {
                $topData = $regionModel->where('region_id=' . $postData['pid'])->field('level')->find();
                if (!empty($topData)) {
                    $postData['level'] = $topData['level'] + 1;
                } else {
                    $postData['level'] = 0;
                }
            }
            if ($regionModel->create($postData) && $regionModel->add()) {
                $result['flag'] = 1;
                $result['msg'] = '添加成功';
            }
            echo json_encode($result);
        }
    }

    /**
     * 编辑地区
     */
    public function edit() {
        if (IS_POST) {
            $postData = I('post.');
            //获取每个类别下的所有子id
            $regionModel = D('region');
            $regionData = $regionModel->order('sort desc,region_id asc')->select();
            $childRegion = $regionModel->getChildRegionIs($regionData, $postData['region_id']);
            $data = M('region')->where('region_id=' . $postData['region_id'])->find();
            if (!empty($data)) {
                $pid = $postData['pid'];
                if (!in_array($pid, $childRegion)) {
                    if($data['pid']!=$postData['pid']){
                        $topData = $regionModel->where('region_id=' . $postData['pid'])->field('level')->find();
                        if (!empty($topData)) {
                            $postData['level'] = $topData['level'] + 1;
                        } else {
                            $postData['level'] = 0;
                        }
                    }
                    if ($regionModel->create($postData) && $regionModel->save()) {
                        $result['flag'] = 1;
                        $result['msg'] = '操作成功';
                    }else{
                        $result['flag'] = 0;
                        $result['msg'] = '操作失败';
                    }
                } else {
                    $result['flag'] = 0;
                    $result['msg'] = '不能移动到其子类下';
                }
            } else {
                $result['flag'] = 0;
                $result['msg'] = '没有找到该数据';
            }
            echo json_encode($result);
        } else {
            $region_id = I('get.region_id');
            $data = M('region')->where('region_id=' . $region_id)->find();
            if (!empty($data)) {
                $result['flag'] = 1;
                $result['data'] = $data;
            } else {
                $result['flag'] = 0;
                $result['data'] = '';
            }
            echo json_encode($result);
        }
    }

    /**
     * 删除启用地区
     */
    public function delete() {
        if(IS_POST){
            $result = array('flag'=>0,'msg'=>'操作失败');
            $postData = I('post.');
            $regionModel = M('region');
            if($postData['act'] == 'del'){
                $data['region_id'] = $postData['region_id'];
                $data['state'] = C('DELETE_STATUS');
                if($regionModel->create($data) && $regionModel->save()){
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }
            }else if($postData['act'] == 'enable'){
                $data['region_id'] = $postData['region_id'];
                $data['state'] = C('NORMAL_STATUS');
                if($regionModel->create($data) && $regionModel->save()){
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }
            }
            echo json_encode($result);
        }
    }

}
