<?php 
namespace Admin\Controller;
use Admin\Controller\BaseController;
/*
 * 评论
 * @author  Heqingyu
 * @date：2016年3月14日 上午10:38:27
 * 
 */
class CommentController extends BaseController{
    /*
     * 评论列表
     * 
     */
    public function index(){
        $getMap = I('get.');
        if(isset($getMap['comment_status']) && $getMap['comment_status'] != 0){
            $where['comment_status'] = $getMap['comment_status'];
        }else{
            $where['comment_status'] = array('egt',C('COMMENT_STATUS.UNPASS'));
        }
        $count = D('Comment')->where($where)->relation(array('Store','Member'))->count();
        $page = new \Think\Page($count,C('PAGE_SIZE'));
        $pageshow = $page->show();
        $comment = D('Comment')->where($where)->relation(array('Store','Member'))->limit($page->firstRow,$page->listRows)->order('id desc')->select();
        $this->getMap = $getMap['comment_status'];
        $this->assign('page',$pageshow);
        $this->assign('comment',$comment);
        $this->display();
    }

    public function editStatus(){
        $commentModel = M('comment');
        if(IS_POST){
            $info = I('post.');
            $res = $commentModel->data($info)->save();
            if($res){
                $result['flag'] = 1;
                $result['msg'] = '操作成功！';
            }else{
                $result['flag'] = 0;
                $result['msg'] = '操作失败！';
            }
        }else{
            $getInfo = I('get.');
            if(!empty($getInfo['id'])){
                $data = $commentModel->where('id='.$getInfo['id'])->field('comment_status')->find();
                if(!empty($data)){
                    $result['flag'] = 1;
                    $result['data'] = $data;
                }
            }
        }
        echo json_encode($result);
    }
}