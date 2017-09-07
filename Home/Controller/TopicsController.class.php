<?php
namespace Home\Controller;

use Home\Controller\BaseController;
/**
 * Description of TopicController
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class TopicsController extends BaseController{

    /**
     * 山陵文化专题
     *
     * @return void
     */
    public function slwh(){
        $pid = 73;
        $storeModel = D('Store');
        $where['category_pid'] = $pid;
        $where['status'] = array('egt',C('DELETE_STATUS'));
        $storeData = $storeModel->relation('StoreImg')->where($where)->field('store_id,store_name')->select();
        $this->storeData = $storeData;
        $this->display();
    }

    /**
     * 上海青浦福寿园
     */
    public function shqpfsy() {
        $store_id= 118;
        $store = D("store");
        $new = M('News');
        $storeNews = $new->join('hgy91_news_images ON hgy91_news.id = hgy91_news_images.news_id')->where("hgy91_news.store_id=".$store_id.' and published_time<='.  time().' and recommend='.C('NORMAL_STATUS'))->field('hgy91_news.id,hgy91_news.title,hgy91_news_images.image_url')->order('hgy91_news.published_time desc')->limit('6')->select();
        //获取墓位
        $goods = D('Goods')->relation('Img')->where('store_id='.$store_id.' and status='.C('NORMAL_STATUS').' and store_show='.C('NORMAL_STATUS'))->field('id,goods_name,store_id')->limit(8)->select();
        //名人墓位
        $mrmdCond['store_id'] = $store_id;
        $mrmdCond['recommended'] = C('NORMAL_STATUS');
        $mrmd = M('CelebrityCemetery')->where($mrmdCond)->field('id,name,summary,image_url')->order('sort desc,id desc')->limit(4)->select();

        $this->mrmd = $mrmd;
        $this->goods = $goods;
        $this->storeNews = $storeNews;
        $this->store_id = $store_id;
        $this->display();
    }

    /**
     * 寒衣节专题
     */
    public function hanyijie(){
        $this->display();
    }

    /**
     * 中元节专题
     */
    public function zhongyuanjie(){
        $this->display();
    }
    /**
     * 重阳节专题
     */
    public function chongyangjie(){
        $this->display();
    }

    /**
     * 福百顺礼仪
     */
    public function fbs(){
        $this->display();
    }
    /*
     * 河北(赤城)凤凰山
     * @return void
     */
    public function hbfhs(){
        $store_id= 456;
        //墓型
        $goods = D('Goods')->relation('Img')->where('store_id='.$store_id.' and status='.C('NORMAL_STATUS').' and store_show='.C('NORMAL_STATUS'))->field('id,goods_name,store_id')->limit(8)->select();
        //资质
        $where['store_id'] = $store_id;
        $where['album_id'] = C('STORE_IMG_QUALIFICATION');
        $where['state'] = array('in',array(C('NORMAL_STATUS'),C('DEFAULT_STATUS')));
        $zizhi = M('StoreImages')->where($where)->field('image_url,title')->order('sort desc')->select();
        $this->assign('zizhi',$zizhi);
        $this->assign('store_id',$store_id);
        $this->assign('goods',$goods);
        $this->display();
    }
    
    /**
     * 安徽淮北方山陵园
     */
    public function hbfs() {
        $store_id= 142;
        //墓型
        $goods = D('Goods')->relation('Img')->where('store_id='.$store_id.' and status='.C('NORMAL_STATUS').' and store_show='.C('NORMAL_STATUS'))->field('id,goods_name,store_id')->limit(8)->select();
        //资质
        $where['store_id'] = $store_id;
        $where['album_id'] = C('STORE_IMG_QUALIFICATION');
        $where['state'] = C('NORMAL_STATUS');
        $zizhi = M('StoreImages')->where($where)->field('image_url,title')->order('sort desc')->select();
        $this->zizhi = $zizhi;
        $this->goods = $goods;
        $this->store_id = $store_id;
        $this->display();
    }
    /**
     * 新年专题
     */
    public function newyear() {
		$currentYear = date('Y', time());
		$this->display('Topics:'.$currentYear.'_newyear');
    }
    /**
     * 清明专题
     */
    public function qingming(){
        $this->display();
    }
    /**
     * 中秋专题
     */
    public function zhongqiu(){
        $this->display();
    }
}
