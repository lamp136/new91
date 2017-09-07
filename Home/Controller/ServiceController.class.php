<?php 
namespace Home\Controller;

use Home\Controller\BaseController;
use Think\Page;
/**
 *祭扫服务
 *
 */
class ServiceController extends BaseController{
	/**
	 * 祭扫服务列表页
	 */
	public function index(){
		$storeGodos = D('StoreGoods');
		$newsModel = D('News');
		//风水文化
		$this->fswh();

		//最新资讯
		$latestnewscond['category_id'] = array('not in',array(C('CATEGOTY_COMPANY_DYNAMIC'),C('CATEGOTY_SENSE'),C('CATEGOTY_FUNERAL_CULTURE'),C('CATEGOTY_FS_FORTUNES'),C('CATEGOTY_COM_CULTURE')));
        $latestnewscond['status'] = C('NORMAL_STATUS');
        $latestnews = $newsModel->getNewsByCondition($latestnewscond,10);

        //热点聚焦
        $rdjjcond['hot_focus'] = C('HOT_FOCUS_STATUS');
        $rdjj = D('News')->getNewsByCondition($rdjjcond, 6, true);
        
        //商家名称
        $storeName = $storeGodos->where('status='.C('NORMAL_STATUS'))->getfield('store_id,store_name');

        //过滤条件
        $info = I('get.');
        $storeId = empty($info['storeId']) ? '' : $info['storeId'];
        $money = empty($info['money']) ? '' : $info['money'];
        $arrMoney = explode('-',$money);

        //构造查询条件
        if(!empty($storeId)){
            $map['store_id'] = $storeId;
        }

        if(!empty($money)){
            if($arrMoney[1]){
                $map['sales_price'] = array('between',$arrMoney);
            }else{
                $map['sales_price'] = array('egt',$arrMoney[0]);
            }
        }

        //项目总数量
        $count = $storeGodos->where($map)->count();
        
        //接收分页的的参数,如果没有默认为1
        $p= I('p');
        $nowPage = empty($p) ? C('PAGE_DEFAULT'):$p;
        $Page = new \Think\Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        
        //分页数据查询
        $list = $storeGodos->where($map)->relation('Single')->order('created_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        
        //获取商品单位
        $serviceGoods = M('serviceGoods')->where('status='.C('NORMAL_STATUS'))->getfield('skuid,unit');

        $this->assign('unit',$serviceGoods);       
        $this->assign('money',$money);
        $this->assign('storeId',$storeId);
        $this->assign('total',$count);
        $this->assign('storeName',$storeName);
        $this->assign('list',$list);
        $this->assign('rdjj',$rdjj);
        $this->assign('latestnews',$latestnews);
        $this->assign('page',$show);
		$this->display();
	}

    /**
     * 祭扫服务详情页
     */
    public function detail(){
        // dump(session('shop_car'));die;
        $storeGoods = D('storeGoods');
        $goods_sn = I('get.store_goods_sn');
        $details = $storeGoods->where('store_goods_sn='.$goods_sn)->relation('IMAGE')->find();
        
        //相关推荐商品
        $where['store_id'] = $details['store_id'];
        $where['status'] = C('NORMAL_STATUS');
        $recommend = $storeGoods->where($where)->limit(4)->select();

        //风水文化
        $this->fswh();
        $this->assign('recommend',$recommend);
        $this->assign('details',$details);
        $this->display();
    }

    /**
     * 加入购物车
     */
    public function addCar(){
        $store_goods_sn = I('post.store_goods_sn');
        $store_id = I('post.store_id');
        $number = I('number');
        $member_id = session('member_id');

        //判断用户是否登录,
        if(empty($member_id)){
            echo json_encode(0);

            //如果用户没有登录写进session
        //     $shopCar = session('shop_car');
        //     if(empty($shopCar)){
        //         session('shop_car',array());
        //     }else{
        //         $shop_car = session('shop_car');
        //     }
        //     //判断购物车内是否存在该商家
        //     if(array_key_exists($store_id,$shop_car)){
        //         //判断同商家下是否存在该商品
        //         if(array_key_exists($store_goods_sn,$shop_car[$store_id])){

        //             $shop_car[$store_id][$store_goods_sn]['number'] += $number;
        //         }else{
        //             $arr0 = array($store_goods_sn => array('store_goods_sn' => $store_goods_sn, 'number' => $number));

        //             foreach ($arr0 as $key => $value) {
        //                 $shop_car[$store_id][$key] = $value;
        //             }
        //         }
        //     }else{
        //         $arr0 = array($store_id =>array($store_goods_sn => array('store_goods_sn' => $store_goods_sn, 'number' => $number)));
                
        //         foreach ($arr0 as $key => $value) {
        //             $shop_car[$key] = $value;
        //         }
    
        //     }
        //     session('shop_car',$shop_car);
        // }
            
        }else{
            //用户登录写进购物车表
            $shoppingCar = M('shoppingCar');
            $cartGoods = $shoppingCar->where('store_goods_sn='.$store_goods_sn)->find();
            $storeGoods = M('storeGoods')->where('store_goods_sn='.$store_goods_sn)->find();
            //如果购物车内存在该商品则增加数量
            if($cartGoods){
                $data['num'] = $cartGoods['num']+$number;
                $data['total_price'] = $data['num'] * $storeGoods['sales_price'];
                $shoppingCar->where('store_goods_sn='.$store_goods_sn)->save($data);
            }else{  
                $info['member_id'] = $member_id;
                $info['store_goods_sn'] = $store_goods_sn;
                $info['goods_name'] = $storeGoods['service_goods_name'];
                $info['store_id'] = $store_id;
                $info['store_name'] = $storeGoods['store_name'];
                $info['skuid'] = $storeGoods['skuid'];
                $info['num'] = $number;
                $info['price'] = $storeGoods['sales_price'];
                $info['total_price'] = round($number * $info['price'],2);
                $info['status'] = 0;
                $info['created_time'] = time();
                $res = $shoppingCar->add($info);
            }
            echo json_encode(1);
        }  
    }
}
