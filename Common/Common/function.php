<?php
/**
 * 后台密码加密
 *
 * @param string $pwd 用户输入的数据
 *
 * @return string
 */
function encryptAdmin($pwd) {
    $prefix = substr(md5(C("A_PREFIX")), 0, 16);
    $suffix = substr(md5(C("A_SUFFIX")), 0, 16);

    $encryptAPwd = md5($prefix.md5($pwd).$suffix);

    return $encryptAPwd;
}
/**
 * 前台密码加密
 *
 * @param string $pwd 用户输入的数据
 *
 * @return string
 */
function encryptHome($pwd) {
    $prefix = substr(md5(C("H_PREFIX")), 0, 16);
    $suffix = substr(md5(C("H_SUFFIX")), 0, 16);

    $encryptHPwd = md5($prefix.md5($pwd).$suffix);

    return $encryptHPwd;
}

/*
 * 生成预约单order_sn  12位数字 年月日+四位随机数
 *
 * @param string $store_name  商家名称 此方法修改之后商家参数不再使用
 *
 * @return string
 */
function makeSn(){
    //$sn = md5($store_name.rand(1000, 9999).time());
    $sn = date(Ymd, time()).rand(1000, 9999);
    return $sn;
}


/**
 * 用于I函数的过滤
 *
 * @param mixed $val    要过过滤的值，当个字符或者是数组，
 * @return mixed        过滤之后的值
 */
function removeXSS($val)
{
    static $obj = null;
    if($obj === null)
    {
        require('./Common/Extend/HTMLPurifier/HTMLPurifier.includes.php');
        $obj = new HTMLPurifier();
    }
    return $obj->purify($val);
}

/**
 * 上传多图片文件
 * @param string    $imgName    form表单中文件域的name值
 * @param string    $dirName    图片保存的文件夹
 * @param array     $thumb       array(
  array('600', '600', 1),
  array('350', '350', 1),
  array('130', '130', 1),
  ))  宽、高、缩略图的处理方式
 * @return array
 */
function upload($imgName,$dirName,$thumb = array()){
    static $upload = null;
    $maxSize = (int) C('MAX_SIZE');
    $rootPath = C('ROOT_PATH');
    $ext = C('EXTS');
    $umf = (int) ini_get('upload_max_filesize');
    $readSize = min($umf, $maxSize);
    if ($upload === null) {
        $upload = new \Think\Upload(array(
            'rootPath' => $rootPath,
            'maxSize' => $readSize * 1024 * 1024,
            'exts' => $ext,
        ));
    }
    $upload->savePath = $dirName . '/'; // 设置附件上传（子）目录
    $info   =   $upload->upload();
    if(!$info) {// 上传错误提示错误信息
        return array(
            'ok' => 0,
            'error' => $upload->getError(),
        );
    }else{// 上传成功 获取上传文件信息
        $ret = array(
            'ok' => 1,
        );
        static $image = null;

        foreach($info as $file){
            $ret['images'][] = $file['savepath'] . $file['savename'];
            if (C('OPEN_WATER')) {
                if ($image === null){
                    $image = new \Think\Image();
                }
                $water_pic = C('WATER_PIC_PATH');
                $image->open($rootPath.$file['savepath'] . $file['savename']);
                $image->water($water_pic,  C('WATER_POSITION'))->save($rootPath.$file['savepath'] . $file['savename']);
            }
        }
        // 是否生成缩略图
        if ($thumb) {
            if ($image === null){
                $image = new \Think\Image();
            }
            foreach($info as $ki=>$file){
                $image->open($rootPath . $file['savepath'] . $file['savename']);
                foreach ($thumb as $k => $v) {
                    $_imgName = $file['savepath'] . 'thumb_' . $v[0] . 'X' . $v[1] . '_' . $file['savename'];
                    // 把这个缩略图的名字放到要返回的图片中
                    $ret['thumb'][$ki][] = $_imgName;
                    $image->thumb($v[0], $v[1], $v[2])->save($rootPath . $_imgName);
                    // if (C('OPEN_WATER')) {
                    //     $image->open($rootPath . $_imgName);
                    //     $image->water($water_pic,  C('WATER_POSITION'))->save($rootPath . $_imgName);
                    // }
                }
            }
        }
        return $ret;
    }
}

/**
 * 上传单个文件
 * @param string    $imgName    form表单中文件域的name值
 * @param string    $dirName    图片保存的文件夹
 * @param array     $thumb       array(
  array('600', '600', 1),
  array('350', '350', 1),
  array('130', '130', 1),
  ))  宽、高、缩略图的处理方式
 * @return array
 */
function uploadOne($imgName, $dirName, $thumb = array(),$water = TRUE) {
    static $upload = null;
    $maxSize = (int) C('MAX_SIZE');
    $rootPath = C('ROOT_PATH');
    $ext = C('EXTS');
    $umf = (int) ini_get('upload_max_filesize');
    $readSize = min($umf, $maxSize);
    if ($upload === null) {
        $upload = new \Think\Upload(array(
            'rootPath' => $rootPath,
            'maxSize' => $readSize * 1024 * 1024,
            'exts' => $ext,
        ));
    }
    $upload->savePath = $dirName . '/'; // 设置附件上传（子）目录
    // 上传文件
    $info = $upload->upload(array($imgName => $_FILES[$imgName]));
    if (!$info) {
        return array(
            'ok' => 0,
            'error' => $upload->getError(),
        );
    } else {
        $ret = array(
            'ok' => 1,
            'images' => array($info[$imgName]['savepath'] . $info[$imgName]['savename']),

        );
        static $image = null;

        if (C('OPEN_WATER') && $water) {
            if ($image === null){
                $image = new \Think\Image();
            }
            $water_pic = C('WATER_PIC_PATH');
            $image->open($rootPath . $ret['images'][0]);
            $image->water($water_pic,  C('WATER_POSITION'))->save($rootPath . $ret['images'][0]);
        }
        // 是否生成缩略图
        if ($thumb) {
            if ($image === null){
                $image = new \Think\Image();
            }
            $image->open($rootPath . $ret['images'][0]);
            foreach ($thumb as $k => $v) {
                $_imgName = $info[$imgName]['savepath'] . 'thumb_' . $v[0] . 'X' . $v[1] . '_' . $info[$imgName]['savename'];
                // 把这个缩略图的名字放到要返回的图片中
                $ret['images'][] = $_imgName;
                $image->thumb($v[0], $v[1], $v[2])->save($rootPath . $_imgName);
                // if (C('OPEN_WATER') && $water) {
                //     $image->open($rootPath . $_imgName);
                //     $image->water($water_pic,  C('WATER_POSITION'))->save($rootPath . $_imgName);
                // }
            }
        }
        return $ret;
    }
}


/**
* 字符串截取，支持中文和其他编码
* @static
* @access public
* @param string $str 需要转换的字符串
* @param int      $start 开始位置
* @param int      $length 截取长度
* @param string $charset 编码格式
* @param string $suffix 截断显示字符
*
* @return string
*/
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=false) {
   if(function_exists("mb_substr"))
       $slice = mb_substr($str, $start, $length, $charset);
   elseif(function_exists('iconv_substr')) {
       $slice = iconv_substr($str,$start,$length,$charset);
   }else{
       $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
       $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
       $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
       $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
       preg_match_all($re[$charset], $str, $match);
       $slice = join("",array_slice($match[0], $start, $length));
   }
   return $suffix ? $slice.'...' : $slice;
}
/**
 * 获取商家会员信息
 *
 * @param bool $keyVal 判断获取的数据格式，默认是 true ,返回值：array('20'=>'商家会员'),如果是： false，返回值： array(20)
 * @param string $type 获取商家会员是显示优惠 还是现实V，商家会员20 和 个人会员是 优惠，特殊指定的商家会员是 V以及广告会员
 *
 * @return array
 */
function getStoreMember($keyFlag=true, $dataFlag = '') {
	if ($keyFlag) {
		switch ($dataFlag) {
			case 'simple_business'://只获取三种会员，V会员除外  慎用
				$storeMembers = array(
    				C('STOER_MERMBER') => C('STOER_MERMBER_MSG'),
    				C('STOER_MERMBER_PERSON') => C('STOER_MERMBER_PERSON_MSG'),
    				C('STOER_MERMBER_AD') => C('STOER_MERMBER_AD_MSG'),
				);
                break;
			case 'business'://获取所有的会员 V属于商家，一般只是适用于列表显示
				$storeMembers = array(
    				C('STOER_MERMBER') => C('STOER_MERMBER_MSG'),
    				C('STOER_MERMBER_V') => C('STOER_MERMBER_MSG'),
    				C('STOER_MERMBER_PERSON') => C('STOER_MERMBER_PERSON_MSG'),
    				C('STOER_MERMBER_AD') => C('STOER_MERMBER_AD_MSG')
				);
                break;
			case 'ad'://只获取广告
				$storeMembers = array(
				    C('STOER_MERMBER_AD') => C('STOER_MERMBER_AD_MSG')
				);
                break;
			case 'all'://所有会员
			default:
				$storeMembers = array(
    				C('STOER_MERMBER') => C('STOER_MERMBER_MSG'),
    				C('STOER_MERMBER_V') => C('STOER_MERMBER_V_MSG'),
    				C('STOER_MERMBER_PERSON') => C('STOER_MERMBER_PERSON_MSG'),
    				C('STOER_MERMBER_AD') => C('STOER_MERMBER_AD_MSG'),
				);
		}
	} else {
		switch ($dataFlag){
			case 'hy'://除去会员V的情况
				$storeMembers = array(
    				C('STOER_MERMBER'),
    				C('STOER_MERMBER_PERSON'),
    				C('STOER_MERMBER_AD')
				);
                break;
			case 'business'://商家会员包含V的
				$storeMembers = array(
    				C('STOER_MERMBER'),
    				C('STOER_MERMBER_V'),
    				C('STOER_MERMBER_PERSON')
				);
                break;
			case 'vip'://商家会员中的V会员
				$storeMembers = array(
						C('STOER_MERMBER_V'),
						C('STOER_MERMBER_AD'),
				);
                break;

			case 'ad'://广告会员
				$storeMembers = array(
				    C('STOER_MERMBER_AD')
				);
                break;
                	case 'yh'://个人会员和商家会员
				$storeMembers = array(
					C('STOER_MERMBER'),
					C('STOER_MERMBER_PERSON'),
				);
                break;
			case 'all'://所有会员
			default:
				$storeMembers = array(
    				C('STOER_MERMBER'),
    				C('STOER_MERMBER_PERSON'),
    				C('STOER_MERMBER_V'),
    				C('STOER_MERMBER_AD')
				);
		}
	}

	return $storeMembers;
}
/**
 * 主要用于首页和导航的URL拼接
 *
 * @param string $prefix
 *
 * @return String
 */
function getHomeUrl($prefix='') {
    $abbr = strtolower(session('ip_region_abbr'));
    $qgAbbr = strtolower(C('CHINA_ABBR'));
    if (empty($abbr) || $abbr == $qgAbbr) {
        if ($prefix) {
            $url = '/'.$prefix;
        } else {
            $url = '/';
        }

    } else {
        if ($prefix) {
            $url = '/'.$prefix.'/'.$abbr;
        } else {
            $url = '/'.$abbr;
        }
    }

    return U($url);
}

function getBreadUrl($provinceId) {
    $sessionRegionId = session('ip_region_id');
    $abbr = strtolower(session('ip_region_abbr'));
    $qgAbbr = strtolower(C('CHINA_ABBR'));
    $provinceId = (int)$provinceId;

    if ($sessionRegionId == C('CHINA_NUM')) {
        return U('/cemetery').'?province='.$provinceId;
    } else {
        if ($sessionRegionId == $provinceId) {
            return U('/cemetery/'.$abbr);
        } else {
            return U('/cemetery/'.$abbr).'?province='.$provinceId;
        }
    }

}

/**
 * 获取客户端浏览器类型
 * @return string|array 传递连接符则连接浏览器类型和版本号返回字符串否则直接返回数组
 */
function get_client_browser(){
    if (empty($_SERVER['HTTP_USER_AGENT'])){
        return '';
    }

    $agent       = $_SERVER['HTTP_USER_AGENT'];
    $browser     = '';
    $browser_ver = '';

    if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)){
        $browser     = 'IE';
        $browser_ver = $regs[1];
    }elseif (preg_match('/.*(Firefox)\/([\w.]+).*/', $agent, $regs)){
        $browser     = 'FireFox';
        $browser_ver = $regs[2];
    }elseif (preg_match('/Maxthon/i', $agent, $regs)){
        $browser     = '(Internet Explorer ' .$browser_ver. ') Maxthon';
        $browser_ver = '';
    }elseif (preg_match('/OPR[\s|\/]([^\s]+)/i', $agent, $regs)){
        $browser     = 'Opera';
        $browser_ver = $regs[1];
    }elseif (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $agent, $regs)){
        $browser     = 'OmniWeb';
        $browser_ver = $regs[2];
    }elseif (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $agent, $regs)){
        $browser     = 'Netscape';
        $browser_ver = $regs[2];
    }elseif (preg_match('/.*(Chrome)\/([\w.]+).*/', $agent, $regs)){
        $browser     = 'Chrome';
        $browser_ver = $regs[2];
    }elseif (preg_match('/safari\/([^\s]+)/', $agent, $regs)){
        $browser     = 'Safari';
        $browser_ver = $regs[1];
    }elseif (preg_match('/NetCaptor\s([^\s|;]+)/i', $agent, $regs)){
        $browser     = '(Internet Explorer ' .$browser_ver. ') NetCaptor';
        $browser_ver = $regs[1];
    }elseif (preg_match('/Lynx\/([^\s]+)/i', $agent, $regs)){
        $browser     = 'Lynx';
        $browser_ver = $regs[1];
    }

    if (!empty($browser)){
        return addslashes($browser . ' ' . $browser_ver);
    }else{
        return 'Unknow browser';
    }
}
/*
 * 邮件发送函数
 * @input $to|邮箱地址（群发为数组）;
 * @input $subject|邮件标题;
 * @input $content|邮件内容;
 * @return boolean;
 */

function sendMail($to, $subject, $content) {
    Vendor('PHPMailer.classphpmailer');
    $mail = new PHPMailer();
    // 装配邮件服务器
    if (C('MAIL_SMTP')) {
        $mail->IsSMTP();
    }
    $mail->Host = C('MAIL_HOST');
    $mail->SMTPAuth = C('MAIL_SMTPAUTH');
    $mail->Username = C('MAIL_USERNAME');
    $mail->Password = C('MAIL_PASSWORD');
    $mail->CharSet = C('MAIL_CHARSET');
    // 装配邮件头信息
    $mail->From = C('MAIL_USERNAME');
        //判断是否为群以邮件
        if(is_array($to)){
            $to_num = count($to);
            for($i=0;$i<$to_num;$i++){
                $mail->AddAddress($to[$i]);
            }
        }else{
            $mail->AddAddress($to);
        }
    $mail->FromName = C('MAIL_FROMNAME');
    $mail->IsHTML(C('MAIL_ISHTML'));
    // 装配邮件正文信息
    $mail->Subject = $subject;
    $mail->Body = $content;
    // 发送邮件
    if (!$mail->Send()) {
        return false;
    } else {
        return true;
    }
}
    /**
     * 获取商家SN 商家分类+7位置数字
     *
     * @param int $type 商家分类1陵园，2殡仪馆，3服务，4一条龙，5石材
     *
     * @return String
     */
    function getStoreSn($type) {
    	$key = 'store_sn_'.$type;
    	$storeNumber =  F($key);
    	$dbData = array();
    	$dbData['name'] = $key;
    	$id = 0;
    	if ($storeNumber) {
			$storeNumber +=1;
    	} else {
    		//不存在的情况下需要获取数据库的数据
    		$dbSystemData = M('system_code')->field('id, max_value')->where('name="'.$key.'"')->find();
    		if ($dbSystemData['id']) {
    			$id = $dbSystemData['id'];
    			$dbData['id'] = $id;
				$storeNumber = $dbSystemData['max_value'] + 1;
    		} else {
    			$number = rand(1000000,1009999);
    			$storeNumber = $type.$number;
    		}
    	}
    	$dbData['max_value'] = $storeNumber;
		//写入文件缓存，并且写入数据库
    	F($key, $storeNumber, $tmp_path);
    	if ($id>0) {
    		$ret = M('system_code')->save($dbData);
    	} else {
    		$ret = M('system_code')->add($dbData);
    	}

		return $storeNumber;
    }
    /**
     *
     */
    /**
     * 获取商品SN
     *
     * @param Int $storeType 商家分类   1陵园，2殡仪馆，3服务，4一条龙，5石材
     * @param Int $goodsType 商品分类   1墓地 ，2祭祀商品，3祭祀服务
     *
     * @return number
     */
    function getGoodsSn($storeType, $goodsType) {
    	$key = 'goods_sn_'.$storeType.'_'.$goodsType;
    	$goodsNumber = F($key);
    	$dbData = array();
    	$dbData['name'] = $key;
    	$id = 0;
    	if ($goodsNumber) {
    		$goodsNumber +=1;
    	} else {
    		//不存在的情况下需要获取数据库的数据
    		$dbSystemData = M('system_code')->field('id, max_value')->where('name="'.$key.'"')->find();
    		if ($dbSystemData['id']) {
    			$id = $dbSystemData['id'];
    			$dbData['id'] = $id;
    			$goodsNumber = $dbSystemData['max_value'] + 1;
    		} else {
    			$number = rand(10000000,10009999);
    			$goodsNumber = $storeType.$goodsType.$number;
    		}
    	}
    	$dbData['max_value'] = $goodsNumber;
    	//写入文件缓存，并且写入数据库
    	F($key, $goodsNumber, $tmp_path);
    	if ($id>0) {
    		$ret = M('system_code')->save($dbData);
    	} else {
    		$ret = M('system_code')->add($dbData);
    	}

    	return $goodsNumber;
    }
    /**
     *获取商品SKUID
	 *商品入库的时候产生的SUIID，主要用来做数据关联处理的
	 *商品SKUID为6位数第一位是产品分类，1祭祀用品，2服务，3石材
	 *
     * @param Int $type 商品分类 1祭祀用品，2服务，3石材
     *
     * @return Number
     */
    function getSkuId($type) {
    	$key = 'skuid_'.$type;
    	$skuid = F($key);
    	$dbData = array();
    	$dbData['name'] = $key;
    	$id = 0;
    	if ($skuid) {
    		$skuid +=1;
    	} else {
    		//不存在的情况下需要获取数据库的数据
    		$dbSystemData = M('system_code')->field('id, max_value')->where('name="'.$key.'"')->find();
    		if ($dbSystemData['id']) {
    			$id = $dbSystemData['id'];
    			$dbData['id'] = $id;
    			$skuid = $dbSystemData['max_value'] + 1;
    		} else {
    			$number = rand(10000,10999);
    			$skuid = $type.$number;
    		}
    	}
    	$dbData['max_value'] = $skuid;
    	//写入文件缓存，并且写入数据库
    	F($key, $skuid, $tmp_path);
    	if ($id>0) {
    		$ret = M('system_code')->save($dbData);
    	} else {
    		$ret = M('system_code')->add($dbData);
    	}

    	return $skuid;
    }
    /**
     * 获取主订单Sn
     *
     * 主订单使用年月日（6位）+3位递增数字（后期可以更改为多位）
     *
     * @return string
     *
     */
    function getMainOrderSn() {
    	$timeStr = date('ymd', NOW_TIME);
		$key = 'main_order_sn_'.$timeStr;
		$mainOrderSn = S($key);
		if ($mainOrderSn) {
			$mainOrderSn +=1;
		} else {
			$num = rand(100, 500);
			$mainOrderSn = $timeStr.$num;
		}

		S($key, $mainOrderSn, 3600*24*2);//缓存2天
		return $mainOrderSn;
    }
    /**
     * 获取子订单SN 11位，同一秒钟获取最大99单 2048-09-29以后会出现重复订单
     * 时间戳 （9位）+2位数字
     *
     * @return string
     */
    function getChildOrderSn() {
		$now = NOW_TIME;
		$str = substr($now, 1);
		$key = 'childordersn_'.$str;
		$childOrderSn = S($key);
		if ($childOrderSn) {
			$childOrderSn +=1;
		} else {
			$num = rand(1, 50);
			if ($num < 10) {
				$num = '0'.$num;
			}
			$childOrderSn = $str.$num;
		}
		S($key, $childOrderSn, 10);//缓存10秒

		return $childOrderSn;
    }
    /**
     * 单流水号,有效时间24小时
     * 前缀+年月日+2位数
     *
     * @param $prefix String 流水号前缀，默认是空
     *
     * @return string
     *
     */
    function getSerialNumber($prefix='') {
    	$timeStr = date('Ymd', NOW_TIME);
    	if ($prefix) {
    		$key = $prefix.'_serial_number_'.$timeStr;
    	} else {
    		$key = 'serial_number_'.$timeStr;
    	}

		$serialNumber = S($key);
		if ($serialNumber) {
			if ($prefix) {
				$tmpArr = explode($prefix, $serialNumber);
				$serialNumber = $prefix.($tmpArr[1]+1);
			} else {
				$serialNumber +=1;
			}
		} else {
			$randNum = rand(1,50);
			if ($randNum < 10) {
				$randNum = '0'.$randNum;
			}

			$serialNumber = $prefix.$timeStr.$randNum;
		}
		S($key, $serialNumber, 3600*24);
		return $serialNumber;
    }
    /**
     * 申请单流水号,有效时间24小时
     * 前缀+年月日+2位数,前缀使用 A
     *
     * @return string
     *
     */
    function getApplySerialNum() {
    	return getSerialNumber('A');
    }
    /**
     * 出库单流水号,有效时间24小时
     * 前缀+年月日+2位数，前缀默认使用 D
     *
     * @return string
     *
     */
    function getDeliverySerialNum() {
    	return getSerialNumber('D');
    }
	/**
	 *合同编号
	 *年月日+2位数
	 *
	 *@return String
	 */
	function getContractNum() {
		return getSerialNumber();
	}
