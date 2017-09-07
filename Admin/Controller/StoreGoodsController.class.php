<?php 
namespace Admin\Controller;
use Admin\Controller\BaseController;

/**
 * 商家商品
 */
class StoreGoodsController extends BaseController
{

	/**
     * 通过选择省份改变市ajax获取省份ID
     */
    public function getCityList(){
        if (IS_POST) {
            $province_id = I('province_id');
            $regionObj = M("region");
            $data = $regionObj->where("level=2 and pid=" . $province_id)->select();
            $this->ajaxReturn($data, 'JSON');
        }else{
            $this->error('省份ID不存在');
        }
    }

    //改变省市获取商家
    public function getStoreList(){
    	$value = I('get.');
        if(!empty($value['province'])){
            $where['province_id'] = $value['province'];
            if(!empty($value['city'])){
                $where['city_id'] = $value['city'];
            }
            
            $where['status'] = C('NORMAL_STATUS');
            //从合同详情表获取合同分类
            $profiles = M('StoreProfilesDetail')->where('category_id=40')->field('profiles_id')->select();
            foreach ($profiles as $key => $value) {
            	$profiles_id[] = $value['profiles_id'];
            }

            $where['store_profiles_id'] = array('in',$profiles_id);
            $store_name = M('Store')->where($where)->field('store_id,store_name')->select();
        }else{
            $store_name = '';
        }

        echo json_encode($store_name);
    }

    //查询商品分类
	public function getCategoryList(){
		$result = array('flg'=>0,'res'=>'');
		$category_pid = I('post.categoryPid');
		
		$list = M('category')->where('pid='.$category_pid)->field('cid,name')->select();
		if($list){
			$result['flg'] = 'list';
			$result['res'] = $list;
		}else{
			$goods = M('serviceGoods')->where('category_pid='.$category_pid)->field('id,name')->select();
			if($goods){
				$result['flg'] = 'goods';
				$result['res'] = $goods;
			}
		}	
		echo json_encode($result);		
	}

	//通过分类获取商品列表
	public function getGoodsList(){
		$category_id = I('post.categoryId');
		$goodsList = M('serviceGoods')->where('category_id='.$category_id)->field('id,name')->select();
		if($goodsList){
			echo json_encode($goodsList);
		}else{
			echo json_encode(0);
		}
	}

	//选择商品获取商品信息
	public function getGoodsDetail(){
		$goods_id = I('post.goodsId');
		$list = M('serviceGoods')->where('id='.$goods_id)->find();
		//查看库存
		$where['skuid'] = $list['skuid'];
		$where['storage_id'] = $list['storage_id'];
		$inventory = M('inventoryMain')->where($where)->field('inventory')->find();
		$list['inventory'] = $inventory['inventory'];
		if($list){
			echo json_encode($list);
		}
	}

	/**
	 * 选择仓库获取库存
	 */
	public function getInventory(){
		$goodsId = I('goodsId');
		$storageId = I('storageId');
		$skuid = M('serviceGoods')->where('id='.$goodsId)->field('skuid')->find();
		$where['skuid'] = $skuid['skuid'];
		$where['storage_id'] = $storageId;
		$inventory = M('inventoryMain')->where($where)->field('inventory')->find();
		echo json_encode($inventory);
	}

	/**
	 * 商家商品列表
	 */
	public function index(){
		$StoreGoods = D('StoreGoods');
		
		//获取分类信息
		$category = M('category')->where('pid='.C('SACRIFICE_GOODS'))->field('cid,pid,name')->select();
		
		//接收搜索表单传过来的分类ID和名称
		$info = I('get.');
		$name = empty($info['name']) ? '' : $info['name'];
		$store_name = empty($info['store_name']) ? '' : $info['store_name'];
		$category_pid = $info['category_pid']== "-1" ? '' : $info['category_pid'];
		$category_id = empty($info['category_id']) ? '' : $info['category_id'];
		
		//构造查询条件
		if(!empty($name)){
			$map['name'] = array('like','%'.$name.'%');
		}
		if(!empty($category_id)){
			$map['category_id'] = $category_id;
		}
		if(!empty($category_pid)){
			$map['category_pid'] = $category_pid;
			$categoryList = M('category')->where('pid='.$category_pid)->select();
		}
		if(!empty($store_name)){
			$map['store_name'] = array('like','%'.$store_name.'%');
		}

		//项目总数量
		$count = $StoreGoods->where($map)->count();
		
		//接收分页的的参数,如果没有默认为1
		$p= I('p');
		$nowPage = empty($p) ? C('PAGE_DEFAULT'):$p;
		$Page = new \Think\Page($count,C('PAGE_SIZE'));
		$show = $Page->show();
		
		//分页数据查询
		$list = $StoreGoods->where($map)->relation('Category')->order('created_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('category_pid',$category_pid);
		$this->assign('category_id',$category_id);
		$this->assign('categoryList',$categoryList);

		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->assign('category',$category);
		$this->assign('nowPage',$nowPage);
		$this->display();
	}

	/**
	 * 添加商家商品信息
	 */
	public function addStoreGoods(){
		$category = M('category')->where('pid='.C('SACRIFICE_GOODS'))->field('cid,pid,name')->select();
		$storage = M('storage')->where('status='.C('NORMAL_STATUS'))->field('id,storage_name')->select();
		$province = $this->getRegionData('level=1','region_id,region_name,level,pid','',false);
		$this->assign('province',$province);
		$this->assign('category',$category);
		$this->assign('storage',$storage);
		$this->display();
	}

	/**
	 * 编辑商家商品信息
	 */
	public function editStoreGoods(){
		$storeGoodsId = I('storeGoodsId');
		$result = M('storeGoods')->where('id='.$storeGoodsId)->find();
		//商品分类
		$category = M('category')->where('pid='.C('SACRIFICE_GOODS'))->field('cid,pid,name')->select();
		$categoryList = M('category')->where('pid='.$result['category_pid'])->field('cid,pid,name')->select();

		//获取分类下所有商品
		$allGoods = M('serviceGoods')->where('category_id='.$result['category_id'])->select();
		
		//仓库
		$storage = M('storage')->where('status='.C('NORMAL_STATUS'))->field('id,storage_name')->select();
		//获取省市
		$province = $this->getRegionData('level=1','region_id,region_name,level,pid','',false);
		
		//获取商家所在省份
		$store_province = M('store')->where('store_id='.$result['store_id'])->field('province_id,city_id')->find();

		$city = array();
		if(!empty($store_province['province_id'])){
			$city = M('region')->where("pid=".$store_province['province_id'])->select();
		}

		//获取商家列表
		if(!empty($store_province['province_id'])){
            $where['province_id'] = $store_province['province_id'];
            if(!empty($store_province['city_id'])){
                $where['city_id'] = $store_province['city_id'];
            }
            $where['status'] = C('NORMAL_STATUS');
            //从合同详情表获取合同分类
            $profiles = M('StoreProfilesDetail')->where('category_id=40')->field('profiles_id')->select();
            foreach ($profiles as $key => $value) {
            	$profiles_id[] = $value['profiles_id'];
            }
            $where['store_profiles_id'] = array('in',$profiles_id);
        	$storeList = M('Store')->where($where)->field('store_id,store_name')->select();
        }
        

        $this->assign('categoryList',$categoryList);
        $this->assign('allGoods',$allGoods);
        $this->assign('storeList',$storeList);
		$this->assign('store_province',$store_province);
		$this->assign('province',$province);
		$this->assign('category',$category);
		$this->assign('storage',$storage);
		$this->assign('city',$city);
		$this->assign('result',$result);
		$this->display();
	}

	/**
	 * 保存添加修改商家商品信息
	 */
	public function saveStoreGoods(){
		$storeGodos = M('storeGoods');
		$storeGoods_id = I('post.storeGoodsId');
		$serviceGoodsID = I('post.goods_id');
		if(!$storeGoods_id){
			$info = I('post.info');

			//获取商品基础表的商品信息
			$serviceGoodsList = M('serviceGoods')->where('id='.$serviceGoodsID)->field('skuid,image_url,thumb_url')->find();
			//获取商家sn
			$store = M('store')->where('store_id='.$info['store_id'])->field('store_sn,store_name')->find();
			//商品sn
			$info['store_goods_sn'] = getGoodsSn();
			$info['skuid'] = $serviceGoodsList['skuid'];
			$info['store_sn'] = $store['store_sn'];
			$info['store_name'] = $store['store_name'];
			$info['created_time'] = time();
			$info['updated_time'] = time();

			if($_FILES['image_url']['error']==0 && !empty($_FILES['image_url']['tmp_name'])){
				//上传图片
				$thumb = array(array('478','478',1));
				$ret = uploadOne('image_url',C('SERVICE_GOODS_IMAGE'),$thumb);
				if($ret['ok']==0){
					$this->error = $ret['error'];
					return false;
				}else{
					$info['image_url'] = C('IMG_HOST').$ret['images'][0];
					$info['thumb_url'] = C('IMG_HOST').$ret['images'][1];
				}
			}else{
				$info['image_url'] =  $serviceGoodsList['image_url'];
				$info['thumb_url'] =  $serviceGoodsList['thumb_url'];
			}
			//执行添加操作
			$res = $storeGodos->add($info);
			if($res){
				//添加商家商品图片表从商品图片表冗余
				$where['service_goods_id'] = $serviceGoodsID;
				$where['status'] = C('NORMAL_STATUS');
				$serviceGoodsImage = M('serviceGoodsImage')->where($where)->field('type,image_url,thumb_url,status,title,created_time,updated_time')->select();
				if($serviceGoodsImage){
					foreach ($serviceGoodsImage as $key => $value) {
						$serviceGoodsImage[$key]['store_goods_id'] = $res;
					}
					$result = M('storeGoodsImage')->addall($serviceGoodsImage);
				}
				$this->success('添加商品成功',U('StoreGoods/index'));
			}else{
				$this->error('添加商品失败');
			}

		}else{
			$info = I('post.info');

			//获取商品基础表的商品信息
			$serviceGoodsList = M('serviceGoods')->where('id='.$serviceGoodsID)->field('skuid,image_url,thumb_url')->find();
			//获取商家sn
			$store = M('store')->where('store_id='.$info['store_id'])->field('store_sn,store_name')->find();
			$info['skuid'] = $serviceGoodsList['skuid'];
			$info['store_sn'] = $store['store_sn'];
			$info['store_name'] = $store['store_name'];
			$info['updated_time'] = time();

			if($_FILES['image_url']['error']==0 && !empty($_FILES['image_url']['tmp_name'])){
				//上传图片
				$thumb = array(array('478','478',1));
				$ret = uploadOne('image_url',C('SERVICE_GOODS_IMAGE'),$thumb);
				if($ret['ok']==0){
					$this->error = $ret['error'];
					return false;
				}else{
					$info['image_url'] = C('IMG_HOST').$ret['images'][0];
					$info['thumb_url'] = C('IMG_HOST').$ret['images'][1];
				}
			}

			$res = $storeGodos->where('id='.$storeGoods_id)->save($info);
			if($res){
				$this->success('编辑商品成功',U('StoreGoods/index'));
			}else{
				$this->error('编辑商品失败');
			}

		}
	}

	//删除开启商家商品信息
	public function delStoreGoods(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $data['id'] = I('post.id');
        $data['status'] = I('post.status');
        if(!empty($data['id'])){
            if(M('storeGoods')->save($data)){
                $result['flag'] = 1;
                $result['msg'] = '操作成功！';
            }
        }
        echo json_encode($result);
    }

	//商品相册列表
	public function goodsImage(){
		$name = I('get.name');
		$p = I('get.nowPage');
		$goodsId = I('get.id');
        $image = M('storeGoodsImage');
        $where['store_goods_id'] = $goodsId;
        $count = $image->where($where)->count();
        $page = new \Think\Page($count,C('PAGE_SIZE'));
        $show = $page->show();
        $list = $image->where($where)->limit($page->firstRow.','.$page->listRows)->select();
        
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->assign('p',$p);
        $this->assign('name',$name);
        $this->assign('goodsId',$goodsId);
        $this->display();
	}

	//图片添加(编辑)保存
	public function saveGoodsImage(){
		if(IS_POST){
            $goodsImage = M('storeGoodsImage');
            $result = array('flag'=>0,'msg'=>'操作失败');
            $data = I('post.info');
            $image_id = I('imageId');
            if(!$image_id){
                //商品相册添加操作
                $thumb = array(array('478','478',1));
                $imagesRet = upload('img_url',C('SERVICE_GOODS_IMAGE'), $thumb);
                if($imagesRet['ok']==0){
                    $this->error($imagesRet['error']);
                }else{
                    foreach($imagesRet['images'] as $k=>$v){
                        $data['image_url'] = C('IMG_HOST').$v;
                        foreach($imagesRet['thumb'][$k] as $key=>$value){
                            $data['thumb_url'] = C('IMG_HOST').$value;
                        }
                        $data['created_time'] = time();
                        $data['updated_time'] = time();
                        $ret = $goodsImage->add($data);
                        if($ret){
                            $result = array('flag'=>1,'msg'=>'添加成功');
                        }
                    }
                }
            }else{
                //商品相册修改操作
                if($_FILES['img_url']['error'] == 0 && !empty($_FILES['img_url']['tmp_name'])){
                	$thumb = array(array('478','478',1));
                    $imagesRet = uploadOne('img_url',C('SERVICE_GOODS_IMAGE'),$thumb);
                    $delImg = $goodsImage->where('id='.$image_id)->field('image_url,thumb_url')->find();
                    if(!empty($delImg)){
                        unlink('.'.$delImg['image_url']);
                        unlink('.'.$delImg['thumb_url']);
                    }
                    if($imagesRet['ok'] == 0){
                        $this->error($imagesRet['error']);
                    }else{
                        //数据写到数据库中
                        $data['image_url'] = C('IMG_HOST').$imagesRet['images'][0];
                        $data['thumb_url'] = C('IMG_HOST').$imagesRet['images'][1];
                    }
                }
                $data['updated_time'] = time();
                $ret = $goodsImage->where('id='.$image_id)->save($data);
                if(!is_bool($ret)){
                    $result = array('flag'=>1,'msg'=>'修改成功');
                }
            }

            echo json_encode($result);
        }
    }

    /**
     * 修改商品相册
     */
    public function editGoodsImage(){
        $id = I('id');
        $goodsImage = M('storeGoodsImage');
        $ret = $goodsImage->where('id='.$id)->find();
        if($ret){
            $result['flag'] = 1;
            $result['data'] = $ret;
        }else{
            $result['flag'] = 0;
        }
        echo json_encode($result);
    }

    /**
     * 删除商家相册
     */
    public function delImage(){
        $imageId = I('id');
        $goodsImage = M('storeGoodsImage');
        $where['id'] = array('in',$imageId);
        $data['status'] = C('DELETE_STATUS');
        if($goodsImage->where($where)->save($data)){
            echo '1';
        }else{
            echo '0';
        }
    }

    /**
     * 启用商家相册
     */
    public function enableImage(){
        $goodsImage = M('storeGoodsImage');
        $id = I('id');
        $data['status'] = C('NORMAL_STATUS');
        if($goodsImage->where('id='.$id)->save($data)){
            $result['flag'] =1;
            $result['msg'] = "操作成功";
        }else{
            $result['flag'] =1;
            $result['msg'] = "操作失败";
        }
        echo json_encode($result);
    }

}