<?php
namespace Home\Controller;
use Home\Controller\BaseController;

class SpecialTopicsController extends BaseController
{
	public function index(){

		// 会员陵园
		$where['type'] = C('TOPICS_TYPE.CEMETERY');
		$this->_list($where);

		// 节日专题
		$where['type'] = C('TOPICS_TYPE.FESTIVAL');
		$this->_list($where);

		//banner图
		$where['type'] = C('TOPICS_TYPE.CAROUSEL');
		$this->_list($where);

		$this->display();
	}

	/**
	 * 核心列表方法
	 * @param  array $where 查询条件
	 */
	private function _list($where){
		$topicsModel = M('topics');

		$where['status'] = C('NORMAL_STATUS');
		$topicsList = $topicsModel->where($where)->order('sort desc')->select();

		if(!empty($where)){

			switch ($where['type']) {
				case C('TOPICS_TYPE.CEMETERY'):
					$this->assign('cemeterylist',$topicsList);
					break;

				case C('TOPICS_TYPE.FESTIVAL'):
					$this->assign('festivallist',$topicsList);
					break;

				case C('TOPICS_TYPE.CAROUSEL'):
					$this->assign('carousellist',$topicsList);
					break;

				default:
					# code...
					break;
			}
		}
	}
}