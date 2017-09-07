<?php
namespace Home\Controller;

use Home\Controller\BaseController;
use Think\Page;
/**
 * 新闻文章类控制器
 * 包括首页、列表页、详情页
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class NewsController extends BaseController{

    public function index() {
        //热点聚焦
        $where['hot_focus'] = C('HOT_FOCUS_STATUS');
        $where['status'] = C('NORMAL_STATUS');
        $rdjjtj =D('News')->relation('Img')->where($where)->field('id,title')->order('created_time desc')->find();

        $rdjjcond['hot_focus'] = C('HOT_FOCUS_STATUS');
        $rdjjcond['id'] = array('not in', $rdjjtj['id']);
        $rdjj = D('News')->getNewsByCondition($rdjjcond, 6, true);
        //公司动态
        $gsdt = D('News')->getNewsByCategory(C('CATEGOTY_COMPANY_DYNAMIC'), 0);
        //业界资讯
        $this->_yjzx(16);
        //风水文化
        $this->_fswh(16);
        //葬式墓型
        $this->_zsmx();
        //陵园风情
        $this->_lyfq(16);
        //殡葬科学
        $this->_bzkx(16);
        //祭祀习俗
        $this->_jsxs(16);
        //白事常识
        $this->_bscs(8);
        //传统节日
        $this->_ctjr(8);

        //广告
        $this->getAdBanner(C('NEWS_HOME_PAGE'), 0, 3);
        //SEO信息
        $seoInfo = M('Seo')->where('type='.C('SEO_TYPE.NEWS_HOME').' and status='.C('NORMAL_STATUS'))->find();

        $this->seoInfo = $seoInfo;
        $this->assign('gsdt', $gsdt);
        $this->assign('rdjjtj', $rdjjtj);
        $this->assign('rdjj', $rdjj);
        $this->display();
    }

    /**
     * 风水文化
     * 获取推荐的新闻，推荐的新闻后台添加的时候必须带图片
     *
     * @param  int $num 获取的数量，如果是0 则是使用新闻默认的数量
     *
     * @return
     */
    public function _fswh($num) {
        if (empty($num)) {
            $num = C('DEFAULT_SIZE');
        } else {
            $num = (int)$num;
        }
        //风水文化
        //获取一条推荐的新闻，推荐的新闻后台添加的时候必须带图片
        $where['category_pid'] = C('CATEGOEY_FENGSHUI_CULTURE');
        $where['recommend'] = C('RECOMMEND_STATUS');
        $where['status'] = C('NORMAL_STATUS');
        $fswhtj =D('News')->relation('Img')->where($where)->field('id,title')->order('created_time desc')->limit(5)->select();
        $fswhcond['category_pid'] = C('CATEGOEY_FENGSHUI_CULTURE');
        if (!empty($fswhtj)) {
            foreach($fswhtj as $v){
                $tjids[] = $v['id'];
            }
            $fswhcond['id'] = array('not in',$tjids);
        }
        $fswh = D('News')->getNewsByCondition($fswhcond,$num);
        $this->assign('fswhtj', $fswhtj);
        $this->assign('fswh', $fswh);
    }

    /**
     * 业界资讯
     * 获取一条推荐的新闻，推荐的新闻后台添加的时候必须带图片
     *
     * @param  int $num 获取的数量，如果是0 则是使用新闻默认的数量
     *
     * @return
     */
    private function _yjzx($num) {
        if (empty($num)) {
            $num = C('DEFAULT_SIZE');
        } else {
            $num = (int)$num;
        }
        //业界资讯
        //获取一条推荐的新闻，推荐的新闻后台添加的时候必须带图片
        $where['category_pid'] = C('CATEGORY_INDUSTRY_INFORMATION');
        $where['recommend'] = C('RECOMMEND_STATUS');
        $where['status'] = C('NORMAL_STATUS');
        $yjzxtj =D('News')->relation('Img')->where($where)->field('id,title')->limit(5)->order('created_time desc')->select();
        $yjzxcond['category_pid'] = C('CATEGORY_INDUSTRY_INFORMATION');
        if(!empty($yjzxtj)){
            foreach($yjzxtj as $v){
                $tjids[] = $v['id'];
            }
        }
        $yjzxcond['id'] = array('not in',$tjids);
        $yjzx = D('News')->getNewsByCondition($yjzxcond, $num);

        $this->assign('yjzxtj', $yjzxtj);
        $this->assign('yjzx', $yjzx);
    }
    /**
     * 殡葬科学
     * 获取一条推荐的新闻，推荐的新闻后台添加的时候必须带图片
     *
     * @param  int $num 获取的数量，如果是0 则是使用新闻默认的数量
     *
     * @return void
     */
    private function _bzkx($num) {
        if (empty($num)) {
            $num = C('DEFAULT_SIZE');
        } else {
            $num = (int)$num;
        }
        // 殡葬科学
        //获取一条推荐的新闻，推荐的新闻后台添加的时候必须带图片
        $where['category_pid'] = C('CATEGORY_FUNERAL_SCIENCE');
        $where['recommend'] = C('RECOMMEND_STATUS');
        $where['status'] = C('NORMAL_STATUS');
        $bzkxtj =D('News')->relation('Img')->where($where)->field('id,title')->order('created_time desc')->limit(5)->select();
        $bzkxcond['category_pid'] = C('CATEGORY_FUNERAL_SCIENCE');
        if(!empty($bzkxtj)){
            foreach($bzkxtj as $v){
                $tjids[] = $v['id'];
            }
            $bzkxcond['id'] = array('not in',$tjids);
        }
        $bzkx = D('News')->getNewsByCondition($bzkxcond, $num);

        $this->assign('bzkxtj', $bzkxtj);
        $this->assign('bzkx', $bzkx);
    }
    /**
     * 祭祀习俗
     * 获取一条推荐的新闻，推荐的新闻后台添加的时候必须带图片
     *
     * @param  int $num 获取的数量，如果是0 则是使用新闻默认的数量
     *
     * @return
     */
    private function _jsxs($num) {
        if (empty($num)) {
            $num = C('DEFAULT_SIZE');
        } else {
            $num = (int)$num;
        }
        // 祭祀习俗
        //获取一条推荐的新闻，推荐的新闻后台添加的时候必须带图片
        $where['category_pid'] = C('CATEGORY_SACRIFICE_CUSTOM');
        $where['recommend'] = C('RECOMMEND_STATUS');
        $where['status'] = C('NORMAL_STATUS');
        $jsxstj =D('News')->relation('Img')->where($where)->field('id,title')->order('created_time desc')->limit(5)->select();
        $jsxscond['category_pid'] = C('CATEGORY_SACRIFICE_CUSTOM');
        if(!empty($jsxstj)){
            foreach($jsxstj as $v){
                $tjids[] = $v['id'];
            }
            $jsxscond['id'] = array('not in',$tjids);
        }
        $jsxs = D('News')->getNewsByCondition($jsxscond, $num);

        $this->assign('jsxstj', $jsxstj);
        $this->assign('jsxs', $jsxs);
    }
    /**
     * 陵园风情
     * 获取一条推荐的新闻，推荐的新闻后台添加的时候必须带图片
     *
     * @param  int $num 获取的数量，如果是0 则是使用新闻默认的数量
     *
     * @return
     */
    private function _lyfq($num) {
        if (empty($num)) {
            $num = C('DEFAULT_SIZE');
        } else {
            $num = (int)$num;
        }
        // 陵园风情
        //获取一条推荐的新闻，推荐的新闻后台添加的时候必须带图片
        $where['category_pid'] = C('CATEGORY_CEMETERY_AMOROUS_FEELINGS');
        $where['recommend'] = C('RECOMMEND_STATUS');
        $where['status'] = C('NORMAL_STATUS');
        $lyfqtj =D('News')->relation('Img')->where($where)->field('id,title')->order('created_time desc')->limit(5)->select();
        $lyfqcond['category_pid'] = C('CATEGORY_CEMETERY_AMOROUS_FEELINGS');
        if(!empty($lyfqtj)){
            foreach($lyfqtj as $v){
                $tjids[] = $v['id'];
            }
            $lyfqcond['id'] = array('not in',$tjids);
        }
        $lyfq = D('News')->getNewsByCondition($lyfqcond, $num);
        $this->assign('lyfqtj', $lyfqtj);
        $this->assign('lyfq', $lyfq);
    }
    /**
     * 白事常识
     * 获取一条推荐的新闻，推荐的新闻后台添加的时候必须带图片
     *
     * @param  int $num 获取的数量，如果是0 则是使用新闻默认的数量
     * @param bool $bool 是否回去推荐数据， 默认true 获取
     * @return
     */
    private function _bscs($num, $bool=true) {
        if (empty($num)) {
            $num = C('DEFAULT_SIZE');
        } else {
            $num = (int)$num;
        }
        // 白事常识
        //获取一条推荐的新闻，推荐的新闻后台添加的时候必须带图片
        if ($bool) {
            $where['category_id'] = C('CATEGOTY_SENSE');
            $where['recommend'] = C('RECOMMEND_STATUS');
            $where['status'] = C('NORMAL_STATUS');
            $bscstj = D('News')->relation('Img')->where($where)->field('id,title')->order('created_time desc')->find();
            if ($bscstj) {
                $bscscond['id'] = array('not in',$bscstj['id']);
            }
            $this->assign('bscstj', $bscstj);
        }

        $bscscond['category_id'] = C('CATEGOTY_SENSE');
        $bscs = D('News')->getNewsByCondition($bscscond, $num);

        $this->assign('bscs', $bscs);
    }
    /**
     * 传统节日
     * 获取一条推荐的新闻，推荐的新闻后台添加的时候必须带图片
     *
     * @param  int $num 获取的数量，如果是0 则是使用新闻默认的数量
     *
     * @return
     */
    private function _ctjr($num) {
        if (empty($num)) {
            $num = C('DEFAULT_SIZE');
        } else {
            $num = (int)$num;
        }
        // 传统节日
        //获取一条推荐的新闻，推荐的新闻后台添加的时候必须带图片
        $where['category_id'] = C('CATEGORY_TRADITIONAL_FESTIVAL');
        $where['recommend'] = C('RECOMMEND_STATUS');
        $where['status'] = C('NORMAL_STATUS');
        $ctjrtj = D('News')->relation('Img')->where($where)->field('id,title')->order('created_time desc')->limit(2)->select();
        $ctjrcond['category_id'] = C('CATEGORY_TRADITIONAL_FESTIVAL');
        if(!empty($ctjrtj)){
            foreach($ctjrtj as $v){
                $tjids[] = $v['id'];
            }
            $ctjrcond['id'] = array('not in',$tjids);
        }
        $ctjr = D('News')->getNewsByCondition($ctjrcond, $num);

        $this->assign('ctjrtj', $ctjrtj);
        $this->assign('ctjr', $ctjr);
    }
    /**
     * 葬式墓型
     * 以及获取第一条的图片
     *
     * @return void
     */
    private function _zsmx() {
        $where['category_id'] = C('CATEGOTY_BURIED_TYPE');
        $where['recommend'] = C('RECOMMEND_STATUS');
        $where['status'] = C('NORMAL_STATUS');
        $zsmx = D('News')->where($where)->field('id,title')->order('sort desc')->select();
        $news_id = $zsmx[0]['id'];
        $zsmxImg = M('NewsImages')->where('news_id='.$news_id.' and status='.C('NORMAL_STATUS'))->field('news_id,image_url,title')->order('sort desc')->limit(4)->select();

        $this->zsmxImg = $zsmxImg;
        $this->assign('zsmx', $zsmx);
    }

    /**
     * 葬式墓型
     * 一条新闻对应多张图片
     *
     * @return void
     */
    public function getzsmxinfo($id) {
        $where['id'] = $id;
        $zsmx = D('News')->relation('BuriedImg')->where($where)->field('id,title')->find();

        echo json_encode($zsmx);
    }

    /**
     * 新闻详情
     *
     * @return void
     */
    public function detail(){
        $id = I('get.id');
        if(empty($id)){
            echo '参数错误';die;
        }
        $newsInfo = D('news')->relation(array('Category','CategoryParent'))->find($id);
        if(empty($newsInfo)){
            echo '信息不存在';die;
        }
        //更新点击量
        M('News')->where('id='.$id)->setInc('hits',1);
        //处理导航选中的问题
        if($newsInfo['category_pid']==C('NEWS_CATEGORY_ID')){
            $this->menuId = $newsInfo['category_id'];
        }else{
            $this->menuId = $newsInfo['category_pid'];
        }

        // 风水推荐
        $key = C('S_CACHE_KEY');
        $randNews = $this->_getRandNews($key,C('CATEGOTY_FS_FORTUNES'));
        $this->fsNews = $randNews;

        //广告
        $this->getAdBanner(C('NEWS_DETAIL_PAGE'), 0, 1);

        //上一篇下一篇
        $where['category_id'] = $newsInfo['category_id'];
        $where['status'] = C('NORMAL_STATUS');
        //上一篇
        $where['published_time'] = array('gt',$newsInfo['published_time']);
        $up = M('News')->where($where)->order('published_time asc')->field('title,id')->find();
        //下一篇
        $where['published_time'] = array('lt',$newsInfo['published_time']);
        $next = M('News')->where($where)->order('published_time desc')->field('title,id')->find();
        $newsType = array(C('CATEGOTY_COM_CULTURE'),C('CATEGOTY_FS_FORTUNES'));
        $this->assign('newsType',$newsType);
        $this->assign('up',$up);
        $this->assign('next',$next);
        $this->_lastestNews();
        $this->_hotNews();
        $this->newsInfo = $newsInfo;
        $this->display();
    }

    /**
     * 随机获取风水推荐新闻
     *
     * @param  string  $cacheKey   缓存Key
     * @param  int     $categoryId 对应新闻类型的分类ID
     * @param  integer $num        获取条数，默认 4
     *
     * @return array
     */
    public function _getRandNews($cacheKey,$categoryId,$num = 4){
    	$randCacheData = array();
        $randCacheData = S($cacheKey);
        if(empty($randCacheData)){
            $allFsCache = F(C('F_CACHE_KEY'),'',C('DATA_CACHE_PATH'));
            if(empty($allFsCache)){
                $where = array(
                    'category_id' => $categoryId,
                    'status' => C('NORMAL_STATUS'),
                );
                $allFsCache = M('news')->field('id,title,summary')->where($where)->select();
                F(C('F_CACHE_KEY'),$allFsCache,C('DATA_CACHE_PATH'));
            }
            $randKey = array_rand($allFsCache,$num);
            foreach ($randKey as $k => $v) {
                $randCacheData[$v] = $allFsCache[$v];
            }
            S($cacheKey,$randCacheData);
        }

        return $randCacheData;
    }

    /**
     * 最新新闻，全部类别下的
     *
     * @return void
     */
    private function _lastestNews() {
        //最新资讯（全部分类下的）
        $where['published_time'] = array('elt',  time());
        $where['status'] = array('eq', C('NORMAL_STATUS'));
        $lastestNews = D('News')->relation('Img')->where($where)->field('id,title')->limit(5)->order('created_time desc')->select();
        $this->lastestNews = $lastestNews;
    }

    /**
     * 热门新闻
     *
     * @return void
     */
    private function _hotNews() {
        $where['published_time'] = array('elt',  time());
        $where['is_hot'] = C('HOTNEWS_STATUS');
        $where['status'] = array('eq', C('NORMAL_STATUS'));
        $hotnews = M('News')->where($where)->field('id,title')->limit(5)->order('created_time desc')->select();
        $this->hotnews = $hotnews;
    }

    /**
     * 导航栏中  殡葬文化 数据列表
     *包含顶部的置顶数据和风水文化的列表
     *
     * @return
     */
     public function fengshui(){
        $categoryPid = C('CATEGOEY_FENGSHUI_CULTURE');
        $this->_newsCategorySeo($categoryPid);
        $where['category_pid'] = $categoryPid;
        $where['status'] = C('NORMAL_STATUS');
        $where['published_time'] = array('ELT', time());
        //置顶数据
        $topWhere = $where;
        $topWhere['top'] = C('TOP_NEWS_STATUS');
        $toplists = M('News')->field('id, title, summary')->where($topWhere)->order('sort DESC, published_time DESC')->limit(4)->select();

        $total = M('News')->where($where)->count();

        $pages = new Page($total, C('DEFAULT_PAGE_SIZE'));
        $show = $pages->frontshow();
        $fields = 'id, title, summary, published_time, source';
        $lists = D('News')->relation('Img')->field($fields)->where($where)->order('published_time DESC')->limit($pages->firstRow, $pages->listRows)->select();
        //置顶数据旁边的广告位

        //白事常识
        $this->_bscs(10, false);
        //风水推荐
        $sessionIpRegionId = session('ip_region_id');
        $fstj = D('Store')->getStoreRecommend(C('STORE_RECOMMEND.GEOMANCY'),$sessionIpRegionId);
        //广告
        $this->getAdBanner(C('FENGSHUI_PAGE'), 0, 2);
        //获取商家会员
        $this->assign('page', $show);
        $this->assign('lists', $lists);
        $this->assign('toplists', $toplists);
        $this->assign('fstj', $fstj);
        $this->display();
     }

    /**
     * 新闻列表页
     *
     * @return void
     */
    public function lists(){
        $pid = I('get.pid');

        $cid = I('get.cid');
        $categoryPInfo = M('Category')->field('name,cid,pid')->find($pid);
        //判断该父分类是否有子分类
        $childCategorys = M('Category')->field('cid')->where('pid='.$pid)->select();
        if(empty($childCategorys)){
            $where['category_id'] = $pid;

        }else{
            $where['category_pid'] = $pid;
        }
        $this->menuId = $pid;
        $this->categoryPInfo = $categoryPInfo;
        if(!empty($cid)){
            $where['category_id'] = $cid;
            $categoryInfo = M('Category')->field('name,cid')->find($cid);
            $this->categoryInfo = $categoryInfo;
            //SEO相关信息
            $this->_newsCategorySeo($cid);
        }else{
            $this->_newsCategorySeo($pid);
        }

        $where['status'] = C('NORMAL_STATUS');
        $where['published_time'] = array('elt',  time());
        $newsModel = D('News');
        $totalRows = $newsModel->where($where)->count();
        $page = new Page($totalRows,C('DEFAULT_SIZE'));
        $pageshow = $page->frontshow();
        $lists = $newsModel->relation('Img')->where($where)->limit($page->firstRow,$page->listRows)->order('sort desc,published_time desc')->select();
        //最新新闻
        $this->_lastestNews();
        //热门新闻
        $this->_hotNews();
        //获取SEO相关信息

        $this->lists = $lists;
        $this->pageshow = $pageshow;
        $this->display();
    }

    /**
     * 通过分类id获取新闻列表页的SEO信息
     *
     * @return void
     */
    private function _newsCategorySeo($cid){
        $seoCond['category_id'] = $cid;
        $seoCond['status'] = C('NORMAL_STATUS');
        $seoCond['type'] = C('SEO_TYPE.NEWS_CLASS');
        $seoInfo = M('Seo')->where($seoCond)->field('seo_title,seo_keywords,seo_description')->find();
        $this->seoInfo = $seoInfo;
    }
}
