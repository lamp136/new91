<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;
use Think\Page;
/**
 * 陵园合作申请
 * @author Wang Qiang <[<wangqiang@huigeyuan.com>]>
 */
class CollaborateController extends BaseController
{

	

     /**商务跟踪判断**/
    public function power(){
        if(session('?admin_id')){
          $ret=  M('RoleUser')->where('user_id='.session('admin_id'))->find();

          if($ret['role_id'] == C('BUSINESS_DEPART') && $ret['role_job_id']==C('BEIJING_BUSINESS_DEPART')){
               $where = session('admin_id');
          }
        }
        return $where;
    }

  

	/**
	 * 陵园合作列表
	 */
	public function index(){
		$getCondition = I('get.');
		if(!empty($getCondition['mobile'])){
			$where['mobile'] = $getCondition['mobile'];
		}
		if(!empty($getCondition['flow_man'])){
			$where['flow_man'] = $getCondition['flow_man'];
		}
      
        $ordermen =  $this->power();
        if($ordermen){
            $where['flow_man'] =  $ordermen;
        }
        
		$collaborate = M('collaborate');
		$totalRows = $collaborate->where($where)->count();
		$page = new Page($totalRows,C('PAGE_SIZE'));
		$show = $page->show();
		$list = $collaborate->where($where)->limit($page->firstRow,$page->listRows)->order('id desc')->select();
        $this->page = $show;
        $flow_man = $this->getBusinessMen(true,false);
        $this->flow_man = $flow_man;
        $this->condition = $getCondition;
		$this->list = $list;
		$this->display();
	}

	
	/**
	 * 跟踪人
	 */
	public function editflowMan(){
		if(IS_POST){
			$collaborate = M('Collaborate');
	        $id = I('post.id');
	        $data['flow_man'] = I('post.flow_man');
	        if($collaborate->where('id='.$id)->save($data)){
	            die('修改成功!');
	        }else{
	            die('修改失败!');
	        }  
		}else{
			$flowMan = $this->getBusinessMen(true,false);
			$i=0;
			foreach ($flowMan as $key => $value) {
				$result[$i]['id'] = $key;
				$result[$i]['nickname'] = $value;
				$i++;
			}
			echo json_encode($result);
		}
	}

    /**
     * 修改陵园合作申请中的status和添加备注
     */
    public function edit(){
        $collaborate = M('Collaborate');
        $postVal = I('post.');
        $result = array('flag'=>0,'msg'=>'操作失败');
        
        if($collaborate->data($postVal)->save()){
            $result = array('flag'=>1,'msg'=>'操作成功');
        }
        echo json_encode($result);
    }
}