<?php
namespace Home\Model;

use Think\Model;
/**
 * Description of RegionModel
 *
 * @author Fan jianwen <fanjianwen@huigeyuan.com>
 * @version 1.0
 */
class RegionModel extends Model{

    /**
     * 获取省份信息
     */
    public function getProvinces($bool=true){
        if ($bool) {
            return $this->where("state=".C('NORMAL_STATUS')." and pid=".C('CHINA_NUM'))->field('region_id, abbreviate,region_name')->order('sort ASC')->select();
        } else {
            return $this->where("state=".C('NORMAL_STATUS')." and (pid= 0 or pid=".C('CHINA_NUM').")")->field('region_id, abbreviate,region_name')->order('sort ASC')->select();
        }
    }
    /**
     *
     * @param unknown $ids
     * @return multitype:|\Think\mixed
     *
     * @return
     */
    public function getByIds($ids) {
        if (empty($ids)) {
            return array();
        }

        $where['region_id'] = array('in', $ids);
        $where['state'] = C('NORMAL_STATUS');

        return $ret = $this->where($where)->getField("region_id, region_name");
    }

    public function getByAbbreviate($abbr) {
        if (empty($abbr)) {
            $abbr = strtoupper('ZG');
        } else {
            $abbr = strtoupper($abbr);
        }
        $where['abbreviate'] = $abbr;
        return $ret = $this->where($where)->field("region_id, region_name,abbreviate")->find();
    }
}
