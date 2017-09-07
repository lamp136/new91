<?php 
namespace Home\Controller;

use Home\Controller\BaseController;
use Think\Page;
/**
 *购物车
 */
class CartController extends BaseController{
	/**
	 * 购物车首页
	 */
	public function index(){
		$shoppingCar = M('shoppingCar');
		$member_id = session('member_id');
		if(!$member_id){
			$this->redirect('/login');
		}
		$where['member_id'] = $member_id;
		$where['status'] = C('NORMAL');
		$result = $shoppingCar->where($where)->select();
		if($result){
			foreach ($result as $key => $value) {
				$storeGoods = D('storeGoods')->relation('Single')->where('store_id='.$value['store_id'].' AND '.'store_goods_sn='.$value['store_goods_sn'])->field('service_goods_name,store_name,sales_price,thumb_url,status,store_goods_sn,skuid')->find();
				$result[$key]['thumb_url'] = $storeGoods['thumb_url'];
				$result[$key]['price'] = $storeGoods['sales_price'];
				$result[$key]['Single'] = $storeGoods['Single'];
				$result[$key]['total_price'] = $storeGoods['sales_price'] * $value['num'];
				$result[$key]['goods_status'] = $storeGoods['status'];
				$total_number += $value['num'];
				$allGoodsPrice += $value['total_price'];
			}
			foreach ($result as $key => $value) {
				$data[$value['store_id']]['sn'][] = $value;	
				$data[$value['store_id']]['store_name'] = $value['store_name'];
			}

			 //获取商品单位
	        $serviceGoods = M('serviceGoods')->where('status='.C('NORMAL_STATUS'))->getfield('skuid,unit');
		}

		//猜您想看
		$recommend = M('storeGoods')->where('status='.C('NORMAL_STATUS'))->limit(4)->select();

		$this->assign('recommend',$recommend);
        $this->assign('unit',$serviceGoods);
		$this->assign('allGoodsPrice',$allGoodsPrice);
		$this->assign('total_number',$total_number);
		$this->assign('shopCar',$data);
		$this->display();
	}

	//接收数量修改购物车表
	public function saveCar(){
		$num = I('num');
		$StoreGoodsSn = I('goodsSn');
		$shoppingCar = M('shoppingCar');
		$member_id = session('member_id');
		$res = $shoppingCar->where('member_id='.$member_id.' AND store_goods_sn='.$StoreGoodsSn)->find();
		$sales_price = M('storeGoods')->where('store_goods_sn='.$StoreGoodsSn)->field('sales_price')->find();
		if($res){
			$data['num'] = $num;
			$data['total_price'] = $sales_price['sales_price'] * $num;
			$result = $shoppingCar->where('member_id='.$member_id.' AND store_goods_sn='.$StoreGoodsSn)->save($data);
			if($result){
				$allGoodsPrice = $shoppingCar->where('member_id='.$member_id)->sum('total_price');
				$arr = array('msg'=>1,'total_price'=>$data['total_price'],'allGoodsPrice'=>$allGoodsPrice);
				echo json_encode($arr);
			}
		}
	}

	//订单确认页面
	public function orderConfirm(){
		$shoppingCar = M('shoppingCar');
		$member_id = session('member_id');
		if(!$member_id){
			$this->redirect('/login');
		}
		$storeGoodsSn = I('post.goods');
		$where['store_goods_sn'] = array('in',$storeGoodsSn);
		$where['member_id'] = $member_id;
		$result = $shoppingCar->where($where)->select();
		if($result){
			foreach ($result as $key => $value) {
				$storeGoods = D('storeGoods')->relation('Single')->where('store_id='.$value['store_id'].' AND '.'store_goods_sn='.$value['store_goods_sn'])->field('service_goods_name,store_name,sales_price,thumb_url,status,store_goods_sn,skuid')->find();
				$result[$key]['thumb_url'] = $storeGoods['thumb_url'];
				$result[$key]['price'] = $storeGoods['sales_price'];
				$result[$key]['Single'] = $storeGoods['Single'];
				$result[$key]['total_price'] = $storeGoods['sales_price'] * $value['num'];
				$result[$key]['goods_status'] = $storeGoods['status'];
				$total_number += $value['num'];          //总数量
				$allGoodsPrice += $value['total_price']; //订单总价
			}

			foreach ($result as $key => $value) {
				$data[$value['store_id']]['sn'][] = $value;	
				$data[$value['store_id']]['store_name'] = $value['store_name'];
				
				//计算各商家下商品总价
				if(array_key_exists($value['store_id'], $store_id)){
					$store_id[$value['store_id']] = $store_id[$value['store_id']] + $value['total_price'];
					$data[$value['store_id']]['storePrice'] = $store_id[$value['store_id']];
				}else{
					$store_id[$value['store_id']] = $value['total_price'];
					$data[$value['store_id']]['storePrice'] = $store_id[$value['store_id']];
				}

			}

			 //获取商品单位
	        $serviceGoods = M('serviceGoods')->where('status='.C('NORMAL_STATUS'))->getfield('skuid,unit');
		}
		// dump($data[116]);die;
		$this->assign('allGoodsPrice',$allGoodsPrice);
		$this->assign('total_number',$total_number);
		$this->assign('list',$data);
		$this->display();
	}
}