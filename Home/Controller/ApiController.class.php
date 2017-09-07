<?php
namespace Home\Controller;

use Think\Controller\JsonRpcController;
/**
 * 对外提供的数据接口
 * 新闻部分数据有四类：行业新闻、企业软文、政策法规
 *array('total'=>100, data=>array());
 *
 * @author hgy
 *
 */
class ApiController extends JsonRpcController
{
	/**
	 * 获取行业新闻数据
	 *
	 * @param number $page     当前页数，默认0，即为第一页
	 * @param number $pagesize 每页数据的条数，默认0， 即为：10
	 *
	 * @return json string
	 */
	public function hyxw($page=0, $pagesize=0) {
		$currentPage = (int)$page;
		$pageSize = (int)$pagesize;
		if (empty($currentPage)) {
			$currentPage = 1;
		}
		if (empty($pageSize)) {
			$pageSize = C('DEFAULT_PAGE_SIZE');
		}
		$category = C('CATEGOTY_INDUSTRY_DYNAMIC');

		$ret = $this->_getNews($category,$currentPage, $pageSize);

		return json_encode($ret);
	}

	/**
	 * 获取企业软文数据
	 *
	 * @param number $page     当前页数，默认0，即为第一页
	 * @param number $pagesize 每页数据的条数，默认0， 即为：10
	 *
	 * @return json string
	 */
	public function qyrw($page=0, $pagesize=0) {
		$currentPage = (int)$page;
		$pageSize = (int)$pagesize;
		if (empty($currentPage)) {
			$currentPage = 1;
		}
		if (empty($pageSize)) {
			$pageSize = C('DEFAULT_PAGE_SIZE');
		}
		$category = C('CATEGOTY_COM_CULTURE');

		$ret = $this->_getNews($category,$currentPage, $pageSize);

		return json_encode($ret);
	}

	/**
	 * 获取政策法规数据
	 *
	 * @param number $page     当前页数，默认0，即为第一页
	 * @param number $pagesize 每页数据的条数，默认0， 即为：10
	 *
	 * @return json string
	 */
	public function zcfg($page=0, $pagesize=0) {
		$currentPage = (int)$page;
		$pageSize = (int)$pagesize;
		if (empty($currentPage)) {
			$currentPage = 1;
		}
		if (empty($pageSize)) {
			$pageSize = C('DEFAULT_PAGE_SIZE');
		}
		$category = C('CATEGOTY_LAWS_REGULATIONS');

		$ret = $this->_getNews($category,$currentPage, $pageSize);

		return json_encode($ret);
	}

	/**
	 * wap站获取风水推荐方法
	 * @return json
	 */
	public function getWapNews(){
		$newsAction = A('News');
		$key = C('S_CACHE_KEY');
        $randNews = $newsAction->_getRandNews($key,C('CATEGOTY_FS_FORTUNES'));

		return json_encode($randNews);
	}

	/**
	 * 根据新闻的ID获取具体的新闻数据
	 *
	 * @param int $id
	 *
	 * @return string
	 */
	public function getById($id) {
		$id = (int)$id;
		$ret['total'] = 0;
		$ret['data'] = '';
		if ($id) {
			$where['status'] = C('NORMAL_STATUS');
			$where['id'] = $id;
			$fields = 'id, title, summary, seo_description, published_time, content,  source';
			$newsInfo = M('news')->field($fields)->where($where)->find();
			if ($newsInfo) {
				$ret['total'] = 1;
				$ret['data'] = $newsInfo;
			}
		}

		return json_encode($ret);
	}

	/**
	 * 新闻数据获取的核心方法
	 *
	 * @param int $category    分类ID
	 * @param int $currentPage 当前页数
	 * @param int $pageSize    每页的数据条数
	 *
	 * @return  array
	 */
	private function _getNews($category, $currentPage, $pageSize) {
		$where['category_id'] = $category;
		$where['status'] = C('NORMAL_STATUS');
		$where['published_time'] = array('ELT', time());
		//获取新闻数量
		$total = M('News')->where($where)->count();
		$lists = array();
		if ($total > 0) {
			//分页数据
			$start = ($currentPage-1)*$pageSize;
			$fields = 'id, title, summary, published_time, source';
			$lists = D('News')->relation('Img')->field($fields)->where($where)->order('published_time DESC')->limit($start, $pageSize)->select();
		}

		$result = array('total'=>$total, 'data' => $lists);
		return $result;
	}
}