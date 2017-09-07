<?php  
namespace Admin\Controller;
use Admin\Controller\BaseController;
/**
 * 新闻文章类
 * @author xds
 */
class NewsController extends BaseController
{
	/**
	 * 行业新闻
	 */
	public function inNews(){
		$categoryId = C('CATEGOTY_INDUSTRY_DYNAMIC');
		$this->assign('name','inNews');
		$this->assign('categoryId',$categoryId);
		$this->_publicCore($categoryId);
	}

	/**
	 * 政策法规
	 */
	public function policyLaws(){
		$categoryId = C('CATEGOTY_LAWS_REGULATIONS');
		$this->assign('name','policyLaws');
		$this->assign('categoryId',$categoryId);
		$this->_publicCore($categoryId);
	}

	/**
	 * 陵园动态
	 */
	public function storeDynamic(){
		$categoryId = C('CATEGOTY_STORE_DYNAMIC');
		$this->assign('name','storeDynamic');
		$this->assign('categoryId',$categoryId);
		$this->_publicCore($categoryId);
	}

	/**
	 * 企业软文
	 */
	public function comCulture(){
		$categoryId = C('CATEGOTY_COM_CULTURE');
		$this->assign('name','comCulture');
		$this->assign('categoryId',$categoryId);
		$this->_publicCore($categoryId);
	}

	/**
	 * 人生感悟
	 */
	public function lifeFeel(){
		$categoryId = C('CATEGOTY_LIFE_GNOSIS');
		$this->assign('name','lifeFeel');
		$this->assign('categoryId',$categoryId);
		$this->_publicCore($categoryId);
	}

	/**
	 * 陵园故事
	 */
	public function cemeteryStory(){
		$categoryId = C('CATEGOTY_CEMETRY_STORY');
		$this->assign('name','cemeteryStory');
		$this->assign('categoryId',$categoryId);
		$this->_publicCore($categoryId);
	}

	/**
	 * 福地名人
	 */
	public function luckyCelebrity(){
		$categoryId = C('CATEGOTY_LUCKY_CELEBRITY');
		$this->assign('name','luckyCelebrity');
		$this->assign('categoryId',$categoryId);
		$this->_publicCore($categoryId);
	}

	/**
	 * 殡葬文化
	 */
	public function funCulture(){
		$categoryId = C('CATEGOTY_FUNERAL_CULTURE');
		$this->assign('name','funCulture');
		$this->assign('categoryId',$categoryId);
		$this->_publicCore($categoryId);
	}

	/**
	 * 风水运势
	 */
	public function fortunes(){
		$categoryId = C('CATEGOTY_FS_FORTUNES');
		$this->assign('name','fortunes');
		$this->assign('categoryId',$categoryId);
		$this->_publicCore($categoryId);
	}

	/**
	 * 丧葬习俗
	 */
	public function funeralCustom(){
		$categoryId = C('CATEGOTY_BURIAL_CUSTOM');
		$this->assign('name','funeralCustom');
		$this->assign('categoryId',$categoryId);
		$this->_publicCore($categoryId);
	}

	/**
	 * 祭祀活动
	 */
	public function feteActive(){
		$categoryId = C('CATEGOTY_SACRIFICE_RITES');
		$this->assign('name','feteActive');
		$this->assign('categoryId',$categoryId);
		$this->_publicCore($categoryId);
	}

	/**
	 * 科普知识
	 */
	public function copKnowledge(){
		$categoryId = C('CATEGOTY_COUPE_KNOWLEDGE');
		$this->assign('name','copKnowledge');
		$this->assign('categoryId',$categoryId);
		$this->_publicCore($categoryId);
	}

	/**
	 * 考古文化
	 */
	public function kgCulture(){
		$categoryId = C('CATEGOTY_KG_CULTURE');
		$this->assign('name','kgCulture');
		$this->assign('categoryId',$categoryId);
		$this->_publicCore($categoryId);
	}

	/**
	 * 公司动态
	 */
	public function ceverts(){
		$categoryId = C('CATEGOTY_COMPANY_DYNAMIC');
		$this->assign('name','ceverts');
		$this->assign('categoryId',$categoryId);
		$this->_publicCore($categoryId);
	}

	/**
	 * 白事常识
	 */
	public function funeral(){
		$categoryId = C('CATEGOTY_SENSE');
		$this->assign('name','funeral');
		$this->assign('categoryId',$categoryId);
		$this->_publicCore($categoryId);
	}

	/**
	 * 葬式墓型
	 */
	public function burial(){
		$categoryId = C('CATEGOTY_BURIED_TYPE');
		$this->assign('name','burial');
		$this->assign('categoryId',$categoryId);
		$this->_publicCore($categoryId);
	}

	/**
	 * 传统节日
	 */
	public function traditionalFestival(){
		$categoryId = C('CATEGORY_TRADITIONAL_FESTIVAL');
		$this->assign('name','traditionalFestival');
		$this->assign('categoryId',$categoryId);
		$this->_publicCore($categoryId);
	}

	/**
	 * 平台融资
	 */
	public function financePlatform(){
		$categoryId = C('CATEGORY_FINANCE_PLATFORM');
		$this->assign('name','financePlatform');
		$this->assign('categoryId',$categoryId);
		$this->_publicCore($categoryId);
	}

	/**
	 * 行业融资
	 */
	public function tradeFinancing(){
		$categoryId = C('CATEGORY_TRADE_FINANCING');
		$this->assign('name','tradeFinancing');
		$this->assign('categoryId',$categoryId);
		$this->_publicCore($categoryId);
	}

	/**
	 * 列表的核心方法
	 * @param Int $cid
	 * @return void
	 */
	private function _publicCore($cid){
		$news = D('News');
		
		//如果是传统节日查询父类和所有子类
		if($cid==C('CATEGORY_TRADITIONAL_FESTIVAL')){
			$where['category_pid|category_id'] = $cid;
		}else{
			$where['category_id'] = $cid;
		}

		$title = I('get.title');
		if(!empty($title)){
			$where['title'] = array('like','%'.$title.'%');		
		}
		$count = $news->where($where)->count();

		//接收分页的的参数,如果没有默认为1
		$p= I('p');
		$nowPage = empty($p) ? C('PAGE_DEFAULT'):$p;
		$Page = new \Think\Page($count,C('PAGE_SIZE'));
		$show = $Page->show();
		$list = $news->where($where)->relation(array('name','nickName'))->order("created_time desc")->limit($Page->firstRow.','.$Page->listRows)->select();

		//通过分类ID查询分类名以及父类名
		$category = M('category')->where('cid='.$cid)->field('pid,name')->find();
		$pidName = M('category')->where('cid='.$category['pid'])->field('name')->find();
		if($category['pid']!=1){
			$this->assign('firstCategory',$pidName['name']);
			$this->assign('secondCategory',$category['name']);
		}else{
			$this->assign('firstCategory',$category['name']);
		}
			
		//截取标题为15个字节
		foreach($list as $k=>$v){
			$list[$k]['titles'] = msubstr($v['title'],0,15,'utf-8',true);
		}

		$this->assign('page',$show);
		$this->assign('list',$list);
		$this->assign('nowPage',$nowPage);
		$this->display('News/news');
	}

	/**
	 * 添加新闻页
	 */
	public function addNews(){
		$info = I('get.');
		$region = M('region');
		$province = $region->where('pid='.C('CHINA_NUM').' and state='.C('NORMAL_STATUS'))->select();
		$list = M('category')->select();
		$categoryModel = D('category');
		$categoryList = $categoryModel->categoryTree($list,$pid=1);
		
		//判断分类下是否有子类,如果有子类不能再该类上添加新闻
		foreach($list as $k=>$v){
			$cid[]=$v['pid'];
		}
		foreach($categoryList as $k=>$v){
			if(in_array($v['cid'],$cid)){
				$categoryList[$k]['last'] = 1;
			}
		}
		
		$this->assign('province',$province);
		$this->assign('cate',$categoryList);
		$this->assign('firstCategory',$info['firstCategory']);
		$this->assign('secondCategory',$info['secondCategory']);
		$this->assign('cateId',$info['categoryId']);
		$this->assign('name',$info['name']);
		$this->display();
	}

	/**
	 * 通过ajax传过来的省份查找商家名称
	 */
	public function getStore(){
		if(IS_POST){
			$province_id = I('province_id');
			$storeObj = M('store');
			$data = $storeObj->where("province_id=".$province_id)->field('store_id,store_name,province_id')->select();
			echo json_encode($data);
		}else{
			$this->error('省份不存在');
		}
	}

	/**
	 * 添加新闻的公共方法
	 */
	public function saveNews(){
		// var_dump(I('post.'));
		if(IS_POST){
			$data = I('post.info');
			$name = I('post.name');
			$cateObj = M('category')->where('cid='.$data['category_id'])->find();
			$data['category_pid'] = $cateObj['pid'];

			if(isset($data['published_time']) && !empty($data['published_time'])){
				$data['published_time'] = strtotime($data['published_time']);
			}
			
			$news = M('news');
			$data['created_time'] = time();
			$data['updated_time'] = time();
			$data['admin_id'] = $_SESSION['admin_id'];
			
			if($news->add($data)){
				// 清除缓存
                F(C('F_CACHE_KEY'),null,C('DATA_CACHE_PATH'));
                S(C('S_CACHE_KEY'),null);
				$this->success('添加文章成功',U('News/'.$name));
			}else{
				$this->error('添加失败');
			}
		}
	}

	/**
	 * 新闻修改页
	 */
	public function editNews(){
		$data = I('get.');
		$newsModel = M('news');
		$news = $newsModel->where('id='.$data['newsId'])->find();
    	
    	//获取地区信息
    	$region = M('region');
    	$province = $region->where('pid='.C('CHINA_NUM'))->select();
    	//获取分类信息
    	$list = M('category')->select();
    	$categoryModel = D('category');
    	$categoryList = $categoryModel->categoryTree($list,$pid=1);
    	//根据文章的province_id查找商家名称
    	$storeName = array();
    	if(!empty($news['province_id'])){
    		$store = M('store');
    		$storeName = $store->field('store_id,store_name,province_id')->where('status!=-1 and province_id='.$news['province_id'])->select();
    	}
    	$this->assign('province',$province);
    	$this->assign('cateId',$data['categoryId']);
    	$this->assign('cate',$categoryList);
    	$this->assign('news',$news);
    	$this->assign('storeName',$storeName);
    	$this->assign('nowPage',$data['nowPage']);
    	$this->assign('firstCategory',$data['firstCategory']);
    	$this->assign('secondCategory',$data['secondCategory']);
    	$this->assign('name',$data['name']);
    	$this->display();

	}

	/**
	 * 保存新闻修改
	 */
	public function updatedNews(){
		if(IS_POST){
			$data = I('post.info','','htmlspecialchars_decode');
			$newsId = I('post.news_id');
			$name = I('post.name');
			$nowPage = I('post.nowPage');

			$findOne = M('category')->where('cid='.$data['category_id'])->find();
			$data['category_pid'] = $findOne['pid'];
			//更新发布时间
			if(isset($data['published_time']) && !empty($data['published_time'])){
				$data['published_time'] = strtotime($data['published_time']);
			}
			$news = M('news');
			$data['updated_time'] = time();
			if($news->where('id='.$newsId)->save($data)){
				// 清除缓存
                F(C('F_CACHE_KEY'),null,C('DATA_CACHE_PATH'));
                S(C('S_CACHE_KEY'),null);
				$this->success('修改文章成功',U('News/'.$name,array('p'=>$nowPage)));
			}else{
				$this->error('修改失败');
			}
		}
	}

	/**
	 * 删除新闻
	 */
	public function deleteNews(){
		$newsId = I('post.newsId');
		$data['status'] = C('DELETE_STATUS');
		$newsObj = M('news');
		if($newsObj->where('id='.$newsId)->save($data)){
			$result['flag'] = 1;
		}else{
			$result['flag'] = 0;
		}
		echo json_encode($result);
	}

	/**
	 * 启用新闻
	 */
	public function enableNew(){
		$id = I('post.id');
		$data['status'] = C('DEFAULT_STATUS');
		$newsObj = M('news');
		if($newsObj->where('id='.$id)->save($data)){
			$result['flag'] = 1;
			$result['msg'] = '启用成功';
		}else{
			$result['flag'] = 0;
			$result['msg'] = '启用失败';
		}
		echo json_encode($result);
	}

	/**
	 * 新闻图片列表页
	 */
	public function newsImage(){
		$info = I('get.');
		$where['status'] = C('NORMAL_STATUS');
		$where['news_id'] = $info['news_id'];

		$image = M('newsImages');
		$count = $image->where($where)->count();
		$Page = new \Think\Page($count,C('PAGE_SIZE'));
		$show = $Page->show();
		$list = $image->where($where)->order('sort DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
		//文章标题
		$newsInfo = M('news')->field('title')->where('id='.$info['news_id'])->find();

		$this->assign('list',$list);
		$this->assign('show',$show);
		$this->assign('newsInfo',$newsInfo);
		$this->assign('newsId',$info['news_id']);
		$this->assign('name',$info['name']);
		$this->assign('firstCategory',$info['firstCategory']);
		$this->assign('secondCategory',$info['secondCategory']);
		$this->display();

	}

	/**
	 * 添加新闻图片页
	 */
	public function addNewsImage(){
		$info = I('get.');
		$this->assign('info',$info);
		$this->display();
	}

	/**
	 * 保存新闻图片
	 */
	public function saveNewsImage(){
		if(IS_POST){
			$data = I('post.info');
			$name = I('name');
			$firstCategory = I('firstCategory');
			$secondCategory = I('secondCategory');

			if($_FILES['image_url']['error']==0 && !empty($_FILES['image_url']['tmp_name'])){
				//上传图片
				$thumb = array(array(130,130,1));
				$ret = uploadOne('image_url',C('NEWS_IMAGE'),$thumb,false);
				if($ret['ok'] ==0){
					$this->error = $ret['error'];
					return FALSE;
				}else{
					$data['image_url'] = C('IMG_HOST').$ret['images'][0];
					$data['thumbnail'] = C('IMG_HOST').$ret['images'][1];
				}
			}

			$res = M('newsImages')->add($data);
			if($res){
				$this->success('添加成功',U('News/newsImage',array('name'=>$name,'firstCategory'=>$firstCategory,'secondCategory'=>$secondCategory,'news_id'=>$data['news_id'])));
			}else{
				$this->error('添加失败');
			}
		}
	}

	/**
	 * 删除新闻图片
	 */
	public function delImage(){
		$imageId = I('post.imageId');
		$newsImgModel = M('newsImages');
		$data = $newsImgModel->where('id='.$imageId)->field('image_url,thumbnail')->find();
		@unlink('.'.$data['image_url']);
        @unlink('.'.$data['thumbnail']);

		$image = M('newsImages')->where('id='.$imageId)->delete();
		if($image){
			$result['flag'] = 1;
		}else{
			$result['flag'] = 0;
		}
		echo json_encode($result);
	}
}

