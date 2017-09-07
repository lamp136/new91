<?php 
namespace Admin\Controller;
use Admin\Controller\BaseController;

/**
 * 进销存财务管理
 */
class FinancialController extends BaseController
{
	/**
	 * 未付款列表
	 */
	public function nonPayment(){
		$financial = M('financial');
		//接收搜索表单传过来的商品名称和申请单号
		$info = I('get.');
		$service_goods_name = empty($info['service_goods_name']) ? '' : $info['service_goods_name'];
		$application_sn = empty($info['application_sn']) ? '' : $info['application_sn'];
		
		//构造查询条件
		if(!empty($service_goods_name)){
			$map['service_goods_name'] = array('like','%'.$service_goods_name.'%');
		}
		if(!empty($application_sn)){
			$map['application_sn'] = $application_sn;
		}
		$map['status'] = C('WAITPAYMENT');
		//项目总数量
		$count = $financial->where($map)->count();
		
		//接收分页的的参数,如果没有默认为1
		$p= I('p');
		$nowPage = empty($p) ? C('PAGE_DEFAULT'):$p;
		$Page = new \Think\Page($count,C('PAGE_SIZE'));
		$show = $Page->show();
		
		//分页数据查询
		$nonPayList = $financial->where($map)->order('created_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('nonPayList',$nonPayList);
		$this->display();
	}

	/**
	 * 添加打款记录
	 */
	public function addFinancial(){
		$info = I('post.info');
		$financialId = I('post.financialId');
		$result = array('flag'=>0,'msg'=>'添加失败');
		//添加子表数据
		$info['financial_id'] = $financialId;
		$info['operator'] = session('admin_id');
		$info['pay_time'] = strtotime($info['pay_time']);
		$res = M('financialSon')->add($info);
		//反写主表中已付金额和欠款
		if($res){
			$countPayment = M('financialSon')->where('financial_id='.$financialId)->sum('payment');
			$main['arrears'] = $info['arrears'] - $info['payment'];
			$main['payment_been'] = $countPayment;
			$main['status'] = $info['status'];
			//如果状态为付完全款欠款就设为0
			if($info['status']==2){
				$main['arrears'] = 0;
			}
			$re = M('financial')->where('id='.$financialId)->save($main);
			if($re){
				$result = array('flag'=>1,'msg'=>'添加成功');
			}
		}

		echo json_encode($result);
	}

	/**
	 * 付款摸态框数据查询
	 */
	public function checkFinancial(){
		$id = I('id');
		$Financial = M('financial')->where('id='.$id)->find();
		$recipient = M('financialSon')->where('financial_id='.$id)->field('recipient')->order('pay_time desc')->find();
		if($recipient){
			$Financial['recipient'] = $recipient['recipient'];
		}
		echo json_encode($Financial);
	}
	
	/**
	 * 已付部分款列表
	 */
	public function littlePayment(){
		$financial = M('financial');
		//接收搜索表单传过来的商品名称和申请单号
		$info = I('get.');
		$service_goods_name = empty($info['service_goods_name']) ? '' : $info['service_goods_name'];
		$application_sn = empty($info['application_sn']) ? '' : $info['application_sn'];
		
		//构造查询条件
		if(!empty($service_goods_name)){
			$map['service_goods_name'] = array('like','%'.$service_goods_name.'%');
		}
		if(!empty($application_sn)){
			$map['application_sn'] = $application_sn;
		}

		$map['status'] = 1;
		//项目总数量
		$count = $financial->where($map)->count();
		
		//接收分页的的参数,如果没有默认为1
		$p= I('p');
		$nowPage = empty($p) ? C('PAGE_DEFAULT'):$p;
		$Page = new \Think\Page($count,C('PAGE_SIZE'));
		$show = $Page->show();
		
		//分页数据查询
		$littlePayList = $financial->where($map)->order('created_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('littlePayList',$littlePayList);
		$this->display();
	}

	/**
	 * 查看打款记录
	 */
	public function checkRecording(){
		$id = I('id');
		$res = array('flag'=>0,'msg'=>'没有记录');
		$list = M('financialSon')->where('financial_id='.$id)->select();
		$admin = M('admin')->getfield('id,nickname');
		foreach ($list as $key => $value) {
			$list[$key]['pay_time'] = date('Y-m-d H:i:s',$value['pay_time']);
			$list[$key]['operator'] = $admin[$value['operator']];

		}

		if($list){
			$res = array('flag'=>1,'msg'=>$list);
		}
		echo json_encode($res);
	}

	/**
	 * 已付全部款列表
	 */
	public function finishPayment(){
		$financial = M('financial');
		//接收搜索表单传过来的商品名称和申请单号
		$info = I('get.');
		$service_goods_name = empty($info['service_goods_name']) ? '' : $info['service_goods_name'];
		$application_sn = empty($info['application_sn']) ? '' : $info['application_sn'];
		
		//构造查询条件
		if(!empty($service_goods_name)){
			$map['service_goods_name'] = array('like','%'.$service_goods_name.'%');
		}
		if(!empty($application_sn)){
			$map['application_sn'] = $application_sn;
		}
		$map['status'] = 2;
		//项目总数量
		$count = $financial->where($map)->count();
		
		//接收分页的的参数,如果没有默认为1
		$p= I('p');
		$nowPage = empty($p) ? C('PAGE_DEFAULT'):$p;
		$Page = new \Think\Page($count,C('PAGE_SIZE'));
		$show = $Page->show();
		
		//分页数据查询
		$finishPayList = $financial->where($map)->order('created_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('finishPayList',$finishPayList);
		$this->display();
	}

}