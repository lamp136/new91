<?php
namespace Admin\Model;

use Think\Model;

/**
 * Description of CategoryModel
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class CategoryModel extends Model {

    /**
     * 将数组组合成一个有规律的数组，将其下面的分类放在父类的child元素中
     * @param arrray $data
     * @param int $pid
     * @return array
     */
    public function categoryChlidTree($data,$pid=0){
        $result = array();
        foreach ($data as $v){
            if($v['pid']==$pid){
                $v['child'] = $this->categoryChlidTree($data,$v['cid']);
                $result[] = $v;
            }
            
        }
        return $result;
    }
    
    
    /**
     * 格式化分类
     * 
     * @param array $data
     * @param int $pid
     * @param int $level
     * @return array
     */
    public function categoryTree($data,$pid=0,$level=0){
        static $result = array();
        foreach($data as $v){
            if($v['pid']==$pid){
                $v['level'] = $level;
                $result[] = $v;
                $this->categoryTree($data,$v['cid'], $level+1);//递归调用
            }
        }
        return $result;
    }
    
    public function getChildCat($pid){
        static $result = array();
        $where['pid'] = array('in',$pid);
        $data = $this->where($where)->select();
        foreach($data as $v){
            $pids[] = $v['cid'];
            $result[] = $v['cid'];
        }
        if(!empty($pids)){
            $this->getChildCat($pids);    //递归调用
        }
        return $result;
    }
    
}
