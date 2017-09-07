<?php
namespace Home\Model;

use Think\Model;
use Think\Model\RelationModel;

class TopicsModel extends RelationModel{

	protected $_link = array(
		'News' => array(
			'mapping_type'   => self::HAS_ONE,
			'class_name'     => 'NewsRole',
			'foreign_key'    => 'type',
			'mapping_key'    => 'url_id',
			'mapping_fields' => 'title,news_id',
		),
	);

	/**
	 * 获取专题
	 * @param  int   $type 类型
	 * @return array
	 */
	public function getTopics($type){
		$where = array(
			'type' => $type,
			'status' => C('NORMAL_STATUS'),
		);
		if(!empty($type)){
			$data = $this->where($where)->field('id,name,summary,content,tag_name,image,thumb_image')->order('sort desc')->select();
		}
		return $data;
	}
}
?>