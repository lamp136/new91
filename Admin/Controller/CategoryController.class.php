<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;

/**
 * 分类管理控制器
 *
 * @author  hqy
 * 
 */
class CategoryController extends BaseController {

    /**
     * 分类列表
     */
    public function index(){
        $list = M('category')->select();
        $categoryModel = D('category');
        $categoryList = $categoryModel->categoryTree($list);
        $this->assign('list',$categoryList);
        $this->display();
    }
    
    public function saveCateggory(){
        $result = array('flag'=>0,'msg'=>'操作失败');
        if(IS_POST){
            $categoryModel = D('category');
            $action = I('post.act');
            $postInfo = I('post.');
            if($action=='add'){
                $data['name'] = $postInfo['name'];
                $data['pid'] = $postInfo['pid'];
                
                $where['cid'] = $postInfo['pid'];
                $res = $categoryModel->where($where)->find();
                $check = $categoryModel->where('pid ='.$data['pid'].' and name ="'.$data['name'].'"')->count();
                if($res['is_show']== C('DELETE_STATUS')){
                    $result['flag'] = 0;
                    $result['msg'] = '请检查上级分类是否开启！';
                }else if($check>0){
                    $result['flag'] = 0;
                    $result['msg'] = '该分类已经存在！';
                }else{
                    $data['is_show'] = C('NORMAL_STATUS');
                    $data['admin_id'] = session('admin_id');
                    $categoryModel->create($data);
                    if($categoryModel->add()){
                        $result['flag'] = 1;
                        $result['msg'] = '操作成功';
                    }
                }
            }else if($action=='edit'){
                $cid = $postInfo['cid'];
                $pid = $postInfo['pid'];
                if($cid==$pid){
                    //不修改pid
                    if($postInfo['name']==''){
                        $result['flag'] = 0;
                        $result['msg'] = '名称不能为空';
                    }else{
                        $data['cid'] = $postInfo['cid'];
                        $data['name'] = $postInfo['name'];
                        $data['sort'] = $postInfo['sort'];
                        $data['admin_id'] = session('admin_id');
                        if($categoryModel->save($data)){
                            $result['flag'] = 1;
                            $result['msg'] = '修改成功';
                        }else{
                            $result['flag'] = 0;
                            $result['msg'] = '修改保存失败';
                        }
                    }
                }else{
                    //修改父类id
                    //获取该分类下的所有子类
                    if(!empty($cid)){
                        $childpids = $categoryModel->getChildCat(array($cid));
                        if(in_array($pid, $childpids)){
                            $result['flag'] = 0;
                            $result['msg'] = '父类不能移动到子类下';
                        }else{
                            $data['cid'] = $postInfo['cid'];
                            if($postInfo['name']!=''){
                                 $data['name'] = $postInfo['name'];
                            }
                            $data['pid'] = $postInfo['pid'];
                            $data['admin_id'] = session('admin_id');
                            if($categoryModel->save($data)){
                                $result['flag'] = 1;
                                $result['msg'] = '修改成功';
                            }else{
                                $result['flag'] = 0;
                                $result['msg'] = '修改保存失败';
                            }
                        }
                    }else{
                        $result['flag'] = 0;
                        $result['msg'] = '操作失败';
                    }
                }
            }else if($action=='del'){
                $data['cid'] = $postInfo['cid'];
                $where['is_show'] =C('NORMAL_STATUS');
                $where['pid'] = $data['cid'];
                $res = $categoryModel->where($where)->find();
                if($res){
                    $result['flag'] = 0;
                    $result['msg'] = '存在子类！';
                }else{
                    $data['is_show'] = C('DELETE_STATUS');
                    $data['admin_id'] = session('admin_id');
                    if($categoryModel->save($data)){
                        $result['flag'] = 1;
                        $result['msg'] = '删除成功';
                    }else{
                        $result['flag'] = 0;
                        $result['msg'] = '删除失败';
                    }
                }
                
            }else if($action=='enable'){
                $data['cid'] = $postInfo['cid'];
                $where['cid'] = $postInfo['pid'];
                $res = $categoryModel->where($where)->find();
                if($res['is_show']== C('DELETE_STATUS')){
                    $result['flag'] = 0;
                    $result['msg'] = '请检查上级分类是否开启！';
                }else{
                    $data['is_show'] = C('NORMAL_STATUS');
                    $data['admin_id'] = session('admin_id');
                    if($categoryModel->save($data)){
                        $result['flag'] = 1;
                        $result['msg'] = '操作成功';
                    }else{
                        $result['flag'] = 0;
                        $result['msg'] = '操作失败!';
                    }
                }
            }
            echo json_encode($result);
        }
    }
}
