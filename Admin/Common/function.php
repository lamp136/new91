<?php
/**
 * 递归调用，将权限节点，子节点放在父节点的一个数组中
 * @staticvar array $result 存放排序后的数组
 * @param array $data
 * @param int $pid
 * @return array
 */
function getTree($data,$pid=0){
    $result = array();
    foreach ($data as $key => $v){
        //找当前分类的子分类，默认从顶级开始找
        if ($v['pid'] == $pid){
            //找到了，继续以找到的分类为当前分类，找它的后代节点,并将结果放到当前元素的下标为child的元素中
            unset($data[$key]);
            $v['child'] = getTree($data,$v['region_id']);
            //然后将$v 保存到$list中
            $result[] = $v;
        }
    }
    return $result;
}
/**
 * 是否显示菜单
 * 传递类名和方法名称来进行判断
 * 如果是Admin，直接返回true
 *
 * @param String $handleString 类名/方法名称
 *
 * @return boolean
 */
function showHandle($handleString) {
    $email = $_SESSION['email'];
    if ($email == C('ADMIN_EMAIL')) {
        return true;
    }
    if (empty($handleString)) {
        return false;
    }
    $privileges = $_SESSION['privilegeData'];
    if (in_array($handleString, $privileges)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 批量更新数据，必须是二位数组
 *
 * @param array $data 需要跟新的数据
 * 比如：$data['字段名称']['主键ID']=>'value'
 *
 * @return boolean
 */
function saveAllData($data, $dbname, $primaryKey='id') {
	if (empty($data)) {
		return false;
	}
	$dbnames = explode("/", $dbname);
	$totalDbnames = count($dbnames);
	if ($totalDbnames == 2) {
		$sql = "UPDATE hgy91_".$dbnames[1]." SET ";
	} else {
		$sql = "UPDATE hgy91_".$dbname." SET ";
	}
	$total = count($data);
	$i = 1;
	$idsArr = array();
	foreach ($data as $field => $val) {
		$sql .= " $field = CASE $primaryKey ";
		foreach ($val as $id => $v) {
			$sql .= sprintf(" WHEN %d THEN '%s' ", $id, addslashes($v));
			if (!in_array($id, $idsArr)) {
				$idsArr[] = $id;
			}
		}

		if ($i == $total) {
			$sql .=" END ";
		} else {
			$sql .=" END, ";
		}
		$i++;
	}
	$ids = implode(',', $idsArr);
	$sql .= " WHERE $primaryKey IN ($ids)";

	$ret = D($dbname)->execute($sql);
	if ($ret === false) {
		return false;
	} else {
		return true;
	}
}

    /**
    * @param String $string 需要加密的字串
    * @param String $skey 加密EKY
    * @return String
    */
   function _encode($string = '', $skey = '') {
       $skey  = C('OPEX_WEB_PWD');
       $strArr = str_split(base64_encode($string));
       $strCount = count($strArr);
       foreach (str_split($skey) as $key => $value)
           $key < $strCount && $strArr[$key].=$value;
       return str_replace(array('=', '+', '/'), array('OoooO', 'o0o0o', '0o0o0'), join('', $strArr));
   }
   /**
    * @param String $string 需要解密的字串
    * @param String $skey 解密KEY
    * @return String
    */
   function _decode($string = '', $skey = '') {
       $skey  = C('OPEX_WEB_PWD');
       $strArr = str_split(str_replace(array('OoooO', 'o0o0o', '0o0o0'), array('=', '+', '/'), $string), 2);
       $strCount = count($strArr);
       foreach (str_split($skey) as $key => $value)
           $key <= $strCount  && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
       return base64_decode(join('', $strArr));
   }
   
   /**
    * 搜索词的来源
    * 
    * @return array
    */
   function getSearchSource(){
       $searchSource = array(
           C('SEARCH_TOP') => C('SEARCH_TOP_MSG'),
           C('SEARCH_CEMETERY') => C('SEARCH_CEMETERY_MSG'),
           C('SEARCH_FUNERAL') => C('SEARCH_FUNERAL_MSG'),
           C('SEARCH_NEWS') => C('SEARCH_NEWS_MSG'),
       );
       return $searchSource;
   }

  /**
   * 商品skuid
   */
  function getGoodsSkuid(){
    return time();
  }

  /*
   * 申请单SN
   * return sting;
   */
  function getApplicationSn(){
      return time();
  }