<?php
namespace Admin\Model;
use Think\Model;

/**
 * Description of RegionModel
 *
 * @author  hqy
 *
 */
class RegionModel extends Model
{
    /**
     * 将地区数组重组
     *
     * @param   array $data
     * @param   int   $pid
     * @return  array
     */
    public function RegionTree($data,$pid=0){
        static $result = array();
        foreach ($data as $key => $v){
            if($v['pid']==$pid){
                $result[] = $v;
                unset($data[$key]);
                $this->RegionTree($data, $v['region_id']);
            }
        }
        return $result;
    }

    /**
     * 获取每个地区下所有的子地区
     *
     * @param array $data
     * @param int $region_id
     * @return array
     */
    public function getChildRegionIs($data,$region_id){
        static $result = array();
        foreach($data  as $key => $v){
            if($v['pid']==$region_id){
                $result[] = $v['region_id'];
                unset($data[$key]);
                $this->getChildRegionIs($data, $v['region_id']);
            }
        }
        return $result;
    }
    /**
     * 获取全国和省份的信息
     *
     * @return array
     */
    /**
     * 获取省份
     *
     * @param boolean $bool 默认false,不需要获取全国，如果是true需要获取全国
     *
     * @return array
     */
    public function getProvince($bool=false){
    	$where['pid'] = C('CHINA_NUM');
    	if ($bool) {
			$where['pid'] = array(C('CHINA_NUM'), 0);
    	}
        return $this->where($where)->field('region_id,region_name')->select();
    }
}
