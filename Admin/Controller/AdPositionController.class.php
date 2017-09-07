<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;
use Think\Page;
/**
 * 广告位管理
 *
 * @author Wang Qiang <wangqiang@huigeyuan.com>
 * @version 1.0
 */
class AdPositionController extends BaseController
{

    /**
     * 广告位列表
     */
    public function index() {
        $adPosModel = D('AdvertisingPosition');
        $totalRows = $adPosModel->count();
        $page = new Page($totalRows,C('PAGE_SIZE'));
        $pageshow = $page->show();
        $list = $adPosModel->field('id,position_name,advertising_width,advertising_height,position_description')->limit($page->firstRow,$page->listRows)->order('id desc')->select();
        $this->page = $pageshow;
        $this->list = $list;
        $this->display();
    }
    
    /**
     * 添加广告位
     */
    public function add(){
        if(IS_POST){
            $result = array('flag'=>0, 'msg'=>'操作失败');
            $adPosModel = D('AdvertisingPosition');
            if($adPosModel->create() && $adPosModel->add()){
                $result['flag'] =1;
                $result['msg'] ='操作成功';
            }
            echo json_encode($result);
        }
    }
    
    /**
     * 编辑广告位
     */
    public function edit($id){
        $adPosModel = D('AdvertisingPosition');
        if(IS_POST){
            $result = array('flag'=>0,'msg'=>'操作失败');
            if($adPosModel->create() && $adPosModel->save()){
                $result['flag'] = 1;
                $result['msg'] = '操作失败';
            }
            echo json_encode($result);
        }else if(IS_GET){
            $result = array('flag'=>0,'data'=>array());
            if(!empty($id)){
                $data = $adPosModel->field('id,position_name,advertising_width,advertising_height,position_description')->find($id);
                if(!empty($data)){
                    $result['flag'] = 1;
                    $result['data'] = $data;
                }
            }
            echo json_encode($result);
        }
    }
}
