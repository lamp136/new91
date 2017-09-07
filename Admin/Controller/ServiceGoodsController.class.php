<?php 
namespace Admin\Controller;
use Admin\Controller\BaseController;

/**
 * 商品基础信息
 */
class ServiceGoodsController extends BaseController
{
    public function index(){
        $serviceGoodsModel = D('serviceGoods');
        
        //获取分类信息
        $category = M('category')->where('pid='.C('SACRIFICE_GOODS'))->field('cid,pid,name')->select();
        
        //接收搜索表单传过来的分类ID和名称
        $info = I('get.');
        $name = empty($info['name']) ? '' : $info['name'];
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

        //项目总数量
        $count = $serviceGoodsModel->where($map)->count();
        
        //接收分页的的参数,如果没有默认为1
        $p= I('p');
        $nowPage = empty($p) ? C('PAGE_DEFAULT'):$p;
        $Page = new \Think\Page($count,C('PAGE_SIZE'));
        $show = $Page->show();
        
        //分页数据查询
        $list = $serviceGoodsModel->where($map)->relation('Category')->order('created_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
                
        //添加申购信息       
        $serviceGoods = $serviceGoodsModel->select();
        $storage = M('storage')->field('id,storage_name')->where('status = '.C('NORMAL_STATUS'))->select();

        $this->assign('storage',$storage);
        $this->assign('serviceGoods',$serviceGoods);
        
        $this->assign('category_pid',$category_pid);
        $this->assign('category_id',$category_id);
        $this->assign('categoryList',$categoryList);

        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->assign('category',$category);
        $this->assign('nowPage',$nowPage);
        $this->display();
    }

    //查询商品分类
    public function getCategoryList(){
        $category_pid = I('post.categoryPid');
        $list = M('category')->where('pid='.$category_pid)->field('cid,name')->select();
        if($list){
            echo json_encode($list);
        }else{
            echo json_encode(0);
        }
        
    }
    //获取除套餐外所有商品
    public function getGoods(){
        $category_pid = I('post.categoryPid');
        $allGoods = M('serviceGoods')->where('category_pid !='.$category_pid)->field('skuid,name,id')->select();
        echo json_encode($allGoods);
    }

    //添加商品信息
    public function addGoods(){
        $category = M('category')->where('pid='.C('SACRIFICE_GOODS'))->field('cid,pid,name')->select();
        $storage = M('storage')->where('status='.C('NORMAL_STATUS'))->field('id,storage_name')->select();
        $this->assign('category',$category);
        $this->assign('storage',$storage);
        $this->display();
    }

    //编辑商品信息
    public function editGoods(){
        $id = I('id');
        $list = M('serviceGoods')->where('id='.$id)->find();
        $category = M('category')->where('pid='.C('SACRIFICE_GOODS'))->field('cid,pid,name')->select();
        $categoryList = M('category')->where('pid='.$list['category_pid'])->field('cid,pid,name')->select();
        $storage = M('storage')->where('status='.C('NORMAL_STATUS'))->field('id,storage_name')->select();
        
        //如果是套餐查询单品表
        if($list['category_id']==C('PACKAGE')){
            $product = M('single_product')->where('service_goods_id='.$id)->select();
            $allGoods = M('serviceGoods')->where('category_id !='.C('PACKAGE'))->field('skuid,id,name')->select();
            foreach ($product as $key => $value) {
                $array['skuid'][] = $value['skuid'];
                $array['number'][$value['skuid']] = $value['number']; 
            }
            // dump($array);die;
            $this->assign('array',$array);
            $this->assign('product',$product);
            $this->assign('allGoods',$allGoods);
        }

        $this->assign('list',$list);
        $this->assign('category',$category);
        $this->assign('categoryList',$categoryList);
        $this->assign('storage',$storage);
        $this->assign('p',I('p'));
        $this->display();

    }

    //保存添加修改商品
    public function saveGoods(){
        $serviceGoods = M('serviceGoods');
        $goodsId = I('post.goodsId');
        $skuid = I('skuid');//单品skuid数组
        $number = I('number');//单品数量
        if(!$goodsId){
            $info = I('post.info');
            
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
                
                //仓库名称
                $storage_name = M('storage')->where('id='.$info['storage_id'])->field('storage_name')->find();
                $info['storage_name'] = $storage_name['storage_name'];

                //录入人id
                $info['admin_id'] = session('admin_id');
                $info['created_time'] = time();
                $info['updated_time'] = time();
                
                //商品skuid
                $info['skuid'] = getGoodsSkuid();

                $res = $serviceGoods->add($info);

                //添加单品表
                if($info['category_pid'] == C('PACKAGE')){
                    $single_product = M('singleProduct');
                    $where['skuid'] = array('in',$skuid);
                    $goods_name = $serviceGoods->where($where)->field('name')->select();
            
                    foreach ($goods_name as $key => $value) {
                        $goods_name[$key]['service_goods_name'] = $value['name'];
                        $goods_name[$key]['package_skuid'] = $info['skuid'];
                        $goods_name[$key]['skuid'] = $skuid[$key];
                        $goods_name[$key]['number'] = $number[$key];
                        $goods_name[$key]['service_goods_id'] = $res;
                    }
                    $res = $single_product->addall($goods_name);
                }

                if($res){
                    $this->success('添加商品成功',U('ServiceGoods/index'));
                }else{
                    $this->error('添加商品失败');
                }
            }
        }else{
            //原图地址
            $image_url = I('post.image_url');
            $thumb_url = I('post.thumb_url');
            $p = I('post.p');
            $info = I('post.info');

            if($_FILES['image_url']['error']==0 && !empty($_FILES['image_url']['tmp_name'])){
                //上传图片
                $thumb = array(array('478','478',1));
                $ret = uploadOne('image_url',C('SERVICE_GOODS_IMAGE'),$thumb);
                if($ret['ok']==0){
                    $this->error = $ret['error'];
                    return false;
                }else{
                    //删除原图
                    unlink('.'.$image_url);
                    unlink('.'.$thumb_url);
                    $info['image_url'] = C('IMG_HOST').$ret['images'][0];
                    $info['thumb_url'] = C('IMG_HOST').$ret['images'][1];
                }
            }
            //仓库名称
            $storage_name = M('storage')->where('id='.$info['storage_id'])->field('storage_name')->find();
            $info['storage_name'] = $storage_name['storage_name'];
            $info['updated_time'] = time();

            $res = $serviceGoods->where('id='.$goodsId)->save($info);

            //添加单品表
            if($info['category_pid'] == C('PACKAGE')){
                $single_product = M('singleProduct');

                //删除原数据从新添加
                $result = $single_product->where('service_goods_id='.$goodsId)->delete();
                if($result){
                    $where['skuid'] = array('in',$skuid);
                    $goods_name = $serviceGoods->where($where)->field('name')->select();
        
                    foreach ($goods_name as $key => $value) {
                        $goods_name[$key]['service_goods_name'] = $value['name'];
                        $goods_name[$key]['skuid'] = $skuid[$key];
                        $goods_name[$key]['number'] = $number[$key];
                        $goods_name[$key]['service_goods_id'] = $goodsId;
                    }
                    $res = $single_product->addall($goods_name);
                }   
            }

            if($res){
                $this->success('编辑商品成功',U('ServiceGoods/index',array('p'=>$p)));
            }else{
                $this->error('编辑商品失败');
            }
        }
    }

    //删除开启商品信息
    public function delGoods(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $data['id'] = I('post.id');
        $data['status'] = I('post.status');
        if(!empty($data['id'])){
            if(M('serviceGoods')->save($data)){
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
        $image = M('serviceGoodsImage');
        $where['service_goods_id'] = $goodsId;
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
            $goodsImage = M('serviceGoodsImage');
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
        $goodsImage = M('serviceGoodsImage');
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
        $goodsImage = M('serviceGoodsImage');
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
        $goodsImage = M('serviceGoodsImage');
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
     /*
     * 添加申请单
     * return void;
     */
    public function addApply(){
        $result = array('flag'=>0,'msg'=>'申请失败！');
        if(IS_POST){
            $info = I('post.info');
            $info['application_sn'] = getApplicationSn();//申请单SN
            $serviceGoods = M('ServiceGoods')->field('skuid,name')->where('id ='.$info['service_goods_id'])->find();
            $info['skuid'] = $serviceGoods['skuid'];
            $info['service_goods_name'] = $serviceGoods['name'];
            $info['supplier_name'] = C('SUPPLIER.'.$info["supplier_id"]);
            $name = M('admin')->field('nickname')->where('id = '.session('admin_id'))->find();
            $info['applicant'] = $name['nickname'];
            $info['applicant_id'] = $name['nickname'];
            $info['application_time'] =time();
            $storage = M('storage')->field('storage_name')->where('id = '.$info['storage_id'])->find();
            $info['storage_name'] = $storage['storage_name'];
            $info['created_time'] = time();
            $info['status'] = C('DEFAULT_STATUS'); 
            if(M('Application')->add($info)){
                $result = array('flag'=>1,"msg"=>'申请成功！' ); 
            }
        }
        echo json_encode($result);
    }
    
}
 