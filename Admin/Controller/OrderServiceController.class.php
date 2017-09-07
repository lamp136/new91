<?php 
namespace Admin\Controller;
use Admin\Controller\BaseController;
use Think\Model;
use Think\Page;

/**
 * 服务订单控制器
 * 主要包含：待支付订单,支付订单,待发货,已发货,完成,退单
 */
class OrderServiceController extends BaseController
{
	/**
	 * 待支付订单列表
	 */
	public function waitPay(){

		$orderMain = M('orderServiceMain');

		//接收搜索表单传过来的订单号和商家名称
		$info = I('get.');
		$order_main_sn = empty($info['order_main_sn']) ? '' : $info['order_main_sn'];
		$store_name = empty($info['store_name']) ? '' : $info['store_name'];
		
		//构造查询条件
		if(!empty($order_main_sn)){
			$map['order_main_sn'] = array('like','%'.$order_main_sn.'%');
		}
		if(!empty($store_name)){
			$where['store_name'] = array('like','%'.$store_name.'%');
			$orderSon = M('orderServiceSon')->where($where)->getfield('id,order_main_id');
			if($orderSon){
				$map['id'] = array('in',$orderSon);
			}else{
				$map['id'] = 0;
			}
		}

		$map['status'] = C('SERVICE_ORDER_STATUS.DEFAULT');

		//项目总数量
		$count = $orderMain->where($map)->count();
		
		//接收分页的的参数,如果没有默认为1
		$p= I('p');
		$nowPage = empty($p) ? C('PAGE_DEFAULT'):$p;
		$Page = new \Think\Page($count,C('PAGE_SIZE'));
		$show = $Page->show();
		
		//分页数据查询
		$list = $orderMain->where($map)->order('order_service_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);
		$this->display();
	}
   
        /*my*/
        /*
         * 待发货订单
         * @inputparam void;
         * @return void;
         */
        public function waitSentGoods(){
            $where = array();
            $mobile = I('get.take_stock_mobile');
            $ordersn = I('get.order_son_sn');
            $storename = I('store_name');
            $take_stock_people = I('take_stock_people');
            if(!empty($mobile)){
                $where['take_stock_mobile'] = array('like','%'.$mobile.'%');
            }
            if(!empty($ordersn)){
                $where['order_son_sn'] = array('like','%'.$ordersn.'%');
            }
            if(!empty($storename)){
                $where['store_name'] = array('like','%'.$storename.'%');
            }
            if(!empty($take_stock_people)){
                $where['take_stock_people'] = array('like','%'.$take_stock_people.'%');
            }
            $orderServiceSonModel = D('OrderServiceSon');
            $where['status'] = C('SERVICE_ORDER_STATUS.WAITSENT');
            $count = $orderServiceSonModel->where($where)->count();
            //接收分页的的参数,如果没有默认为1
            $p= I('p');
            $nowPage = empty($p) ? C('PAGE_DEFAULT'):$p;
            $Page = new \Think\Page($count,C('PAGE_SIZE'));
            $show = $Page->show();
            $list = $orderServiceSonModel->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('pay_time DESC')->select();
            dump($list);die;
            $this->assign('page',$show);
            $this->assign('nowPage',$nowPage);
            $this->assign('list',$list);
            $this->display();
        }
        /*
         * 查看详情
         * @inputparam  void; 
         * @return      json|string;
         */
        public function viewDetails(){
            $result = array('flag'=>0,'msg'=>'查看失败！');
            $mainId = I('post.id');
            if(!empty($mainId)){
                $orderServiceMainModel = D('OrderServiceMain');
                $data = $orderServiceMainModel->relation(array('OrderServiceSon','OrderServiceGrandchild'))->where('id = '.$mainId)->select();
                if(!empty($data)){
                    $OrderServiceSon = $data['0']['OrderServiceSon'];
                    $sonNumber = count($OrderServiceSon);
                    unset($data['0']['OrderServiceSon']);
                    $OrderServiceGrandchild = $data['0']['OrderServiceGrandchild'];
                    unset($data['0']['OrderServiceGrandchild']);
                    for($i = 0;$i<$sonNumber;$i++){
                        foreach($OrderServiceGrandchild as $child){
                            if($OrderServiceSon[$i]['id'] == $child['order_son_id']){
                                $OrderServiceSon[$i]['child'][] = $child;
                            }
                        }
                    }
                    $datas['main'] = $data['0'];
                    $datas['son'] = $OrderServiceSon;
                    $result['flag'] = 1;
                    $result['datas'] = $datas;
                }
            }
            //dump($datas);die;
            echo json_encode($result);
        }
/*my*/

	/**
	 * 查看订单详情
	 */
	public function orderDetails(){
		$mainID = I('get.id');
		$orderSon = D('orderServiceSon');
		$detail = $orderSon->where('order_main_id='.$mainID)->relation('child')->select();
		$this->assign('detail',$detail);
		$this->display();
	}

	/**
	 * 订单支付完成列表
	 */
	public function finishPay(){
		$orderMain = M('orderServiceMain');

		//接收搜索表单传过来的订单号和商家名称
		$info = I('get.');
		$order_main_sn = empty($info['order_main_sn']) ? '' : $info['order_main_sn'];
		$store_name = empty($info['store_name']) ? '' : $info['store_name'];
		
		//构造查询条件
		if(!empty($order_main_sn)){
			$map['order_main_sn'] = array('like','%'.$order_main_sn.'%');
		}
		if(!empty($store_name)){
			$where['store_name'] = array('like','%'.$store_name.'%');
			$orderSon = M('orderServiceSon')->where($where)->getfield('id,order_main_id');
			if($orderSon){
				$map['id'] = array('in',$orderSon);
			}else{
				$map['id'] = 0;
			}
		}

		$map['status'] = C('SERVICE_ORDER_STATUS.OK');

		//项目总数量
		$count = $orderMain->where($map)->count();
		
		//接收分页的的参数,如果没有默认为1
		$p= I('p');
		$nowPage = empty($p) ? C('PAGE_DEFAULT'):$p;
		$Page = new \Think\Page($count,C('PAGE_SIZE'));
		$show = $Page->show();
		
		//分页数据查询
		$list = $orderMain->where($map)->order('pay_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);
		$this->display();
	}

	/**
	 * 完成订单列表
	 */
	public function finish(){
		$map = array();
		$mobile = I('get.take_stock_mobile');
		$ordersn = I('get.order_son_sn');
		$storename = I('store_name');
		$take_stock_people = I('take_stock_people');
		if(!empty($mobile)){
			$map['take_stock_mobile'] = $mobile;
		}
		if(!empty($ordersn)){
			$map['order_son_sn'] = $ordersn;
		}
		if(!empty($store_name)){
			$map['store_name'] = array('like','%'.$storename.'%');;
		}
		if(!empty($take_stock_people)){
			$map['take_stock_people'] = array('like','%'.$take_stock_people.'%');;
		}
		$map['status'] = C('SERVICE_ORDER_STATUS.SUCCESS');
		$count = D('OrderServiceSon')->where($map)->count();
		$page = new Page($count, C('PAGE_SIZE'));
		$pageShow = $page->show();

		$ordermain = M('OrderServiceSon');
		$info = D('OrderServiceSon')->relation('main')->where($map)->limit($page->firstRow, $page->listRows)->order('actual_stock_time desc')->select();
		$this->info=$info;
		$this->page = $pageShow;
		$this->display();

	}


	/**
	 * 退单操作
	 */
	public function orderback(){
		$order_son_sn = I('get.id');
		$info = D('OrderServiceSon')->relation('orderback')->where('order_son_sn='.$order_son_sn)->find();
		if($info){
			$result['flag'] =2;
			$result['data'] = $info;
		}
		echo json_encode($result);
	}

	/**
	 * 提交退单信息操作
	 */
	public function singleBack(){
		$info = I('post.');
		$id = I('get.id');
		$data['back_money'] = $info['back_money'];
		$data['status'] = C('ORDER_STATUS.APPLY_BACK');
		$order = M('OrderServiceSon');
		$order->create($data);
		$end =$order->where('order_son_sn='.$id)->save();
		if($end){
			$result['flag'] = 1;
			$result['msg'] = '退单信息提交成功';
		}
		echo json_encode($result);

	}

	/**退单审核通过**/
	public function checkpass(){
		$info = I('post.');
		$id = I('get.id');
		$data['back_approval_time'] = time();
		$data['back_money'] = $info['back_money'];
		$data['check_person_id'] = session('admin_id');
		$data['status'] = C('ORDER_STATUS.ALLOW');
		$order = M('OrderServiceSon');
		$order->create($data);
		$end =$order->where('order_son_sn='.$id)->save();
		if($end){
			$result['flag'] = 1;
			$result['msg'] = '退单审核成功';
		}
		echo json_encode($result);

	}


	/**
	 * 服务商品详情页
	 * @return [type] [description]  
	 */
	public function details(){
		$order_son_sn = I('get.ordersn');
		$map['order_son_sn'] = $order_son_sn;
		$info = D('OrderServiceSon')->relation('child')->where($map)->limit($page->firstRow, $page->listRows)->order('actual_stock_time desc')->select();
		$this->info=$info;
		$this->display();
	}



	/**
	 * 服务商品退单列表
	 */
	public function backorder(){
		$map = array();
		$mobile = I('get.take_stock_mobile');
		$ordersn = I('get.order_son_sn');
		$storename = I('store_name');
		$take_stock_people = I('take_stock_people');
		$arr = array(C('SERVICE_ORDER_STATUS.BACK_SUCCESS'),C('SERVICE_ORDER_STATUS.APPLY_BACK'),C('SERVICE_ORDER_STATUS.ALLOW'));
		$map['status'] = array('in',$arr);
		if(!empty($mobile)){
			$map['take_stock_mobile'] = $mobile;
		}
		if(!empty($ordersn)){
			$map['order_son_sn'] = $ordersn;
		}


		if(!empty($store_name)){
			$map['store_name'] = array('like','%'.$storename.'%');
		}
		if(!empty($take_stock_people)){
			$map['take_stock_people'] = array('like','%'.$take_stock_people.'%');
		}
		$count = M('OrderServiceSon')->where($map)->count();
		$page = new Page($count, C('PAGE_SIZE'));
		$pageShow = $page->show();
		$info = D('OrderServiceSon')->relation('main')->where($map)->limit($page->firstRow, $page->listRows)->order('actual_stock_time desc')->select();
		$this->page=$pageShow;
		$this->info=$info;
		$this->display();
	}

}



