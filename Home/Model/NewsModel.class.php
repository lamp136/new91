<?php
namespace Home\Model;

use Think\Model\RelationModel;
/**
 * Description of NewsModel
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class NewsModel extends RelationModel{

    protected $_link = array(
        'Img' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'NewsImages',
            'foreign_key' => 'news_id',
            'mapping_key' => 'id',
            'mapping_fields' => 'thumbnail,image_url',
            'condition' => 'status = 1',
        ),
        'Pic' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'NewsImages',
            'foreign_key' => 'news_id',
            'mapping_key' => 'id',
            'mapping_fields' => 'image_url',
            'condition' => 'status = 1',
        ),
        'BuriedImg' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'NewsImages',
            'foreign_key' => 'news_id',
            'mapping_key' => 'id',
            'mapping_fields' => 'thumbnail,image_url',
            'condition' => 'status = 1',
        ),
        'Category' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'Category',
            'foreign_key' => 'cid',
            'mapping_key' => 'category_id',
            'mapping_fields' => 'name',
        ),
        'CategoryParent' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'Category',
            'foreign_key' => 'cid',
            'mapping_key' => 'category_pid',
            'mapping_fields' => 'name',
        ),
        'Store' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name' => 'Store',
            'foreign_key' => 'store_id',
            'mapping_key' => 'store_id',
            'mapping_fields' => 'store_name,member_status,store_banner,feature',
        ),
    );



    /**
     * 获取某个类别下的指定条数的文章
     *
     * @param  int   $categoryid  新闻类别
     * @param  int   $num         条数
     *
     * @return array              结果
     */
    public function getNewsByCategory($categoryid,$num){
        $where['category_id'] = $categoryid;
        $where['status'] = C('NORMAL_STATUS');
        $where['published_time'] = array('elt', time());
        $defaultFields = 'title,id';
        if (empty($num)) {
            $data = $this->where($where)->field($defaultFields)->order('created_time desc')->select();
        } else {
            $data = $this->where($where)->limit($num)->field($defaultFields)->order('created_time desc')->select();
        }
        return $data;
    }

    /**
     * 通过添加获取新闻
     * @param   array $where    条件
     * @param   int   $num      条数
     * @param  bool $summaryField  是否需要描述字段，默认 false 是不需要的
     * @return  array           结果
     */
    public function getNewsByCondition($where,$num, $summaryField=false){
        $defaultFields = 'title,id';
        if ($summaryField) {
            $defaultFields = 'title,id,summary';
        }
        if (!is_array($where) || !array_key_exists('status', $where)) {
            $where['status'] = array('eq', C('NORMAL_STATUS'));
        }
        if (!is_array($where) || !array_key_exists('published_time', $where)) {
            $where['published_time'] = array('elt', time());
        }
        $data = $this->where($where)->field($defaultFields)->limit($num)->order('created_time desc')->select();
        return $data;
    }

}
