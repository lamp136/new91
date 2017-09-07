<?php
return array(
	//'配置项'             =>'配置值'
	'ADMIN_EMAIL'          => 'admin', //超级管理员的账号
	'URL_CASE_INSENSITIVE' =>  false,  //url区分大小写

	'DEPARTMENT_TYPE'      => 0, //role表中部门的标识
	'ROLE_TYPE'            => 1, //role表中角色（职位）的标识
    'OPERATE_ID'           => array(19), //运营部门ID
	/**
	* 商家相册缩略图的宽度、高度、处理方式
	* 处理方式
	* 1 等比例缩放类型
	* 2 缩放后填充类型
	* 3 居中裁剪类型
	* 4 左上角裁剪类型
	* 5 右下角裁剪类型
	* 6 固定尺寸缩放类型
	*/
	'STORE_THUMB' => array(
        array('265', '225', 6),
	),
	//水印
	'OPEN_WATER'      => 1, //是否开启水印,1为开启，0为关闭
	'WATER_POSITION'  => 9, //水印的位置
	'WATER_PIC_PATH'  => './Public/water_logo_small_n.png', //水印图片
	/**
	* 1左上      2上居中   3右上位置
	* 4左居中    5居中     6右居中
	* 7左下      8下居中   9右下
	*
	*/
	'STORE_THUMB'    => array(
        array('265', '225', 6),
	),
	'CAROUSEL_THUMB' => array(
        array('230', '55', 6),
	),
	'TOPICS_THUMB'   => array(
        array('150','84',6),
	),

    'CATEGORY_STORE_ID'    => 18,        //商品分类ID
    'CATEGORY_GROUP_ID'    => 71,        //集团分类ID
    'CATEGORY_MERCHANT_ID' => 27,        //商家分类ID

    //陵园档案中选择(合同过期时间)条件，(数组中的键值要对应哦！)
   'CHOICE_TIMES' => array(
       '-31' => '已过期一月内',
       '-8'  => '已过期一周内',
       '-3'  => '已过期三天内',
       '1'   => '今天',
       '3'   => '三天内过期',
       '8'   => '一周内过期',
       '31'  => '一月内过期',
    ),

    'PRINCIPAL'              => array(16),//档案负责人选择范围数组val为部门ID？？？？
    'BUSINESS_DEPART'        => 16, //商务部ID
    'BEIJING_BUSINESS_DEPART'=> 29, //北京商务部ID
    'SAVE_LOG_OPEN'          => 1, //开启后台日志记录
    'MONEY_USER_CATEGORY_ID' => 90, //资金用途分类ID

    //电子合同档案图片类型
    'PROFILES_IMAGE_TYPE' => array(
        1 => '电子合同',
        2 => '价格图片',
    ),

    //咨询的问题(key必须是连续递增的,从1开始)
    'CONSULT_QUESTIONS' => array(
        '1' => '咨询价格',
        '2' => '联系方式',
        '3' => '咨询陵园',
        '4' => '地址路线',
        '5' => '班车问题',
        '6' => '咨询返现',
        '7' => '其他'
    ),

    //搜索会员状态
    'MEMBER_STATUS' => array(
        '20' => '商家会员',
        '19' => '商家会员V',
        '16' => '个人会员',
        '14' => '广告会员',
        '0'  => '非会员',
    ),

    //订单生成方式
   'ORDER_TYPE_BACK'      => 2, //后台手动添加
   'ORDER_TYPE_QIAN'      => 1, //前台手动添加

    //会员验证
    'CHECK_MOBILE_FINISH' => 1, //已经验证
    'NOT_CHECK_MOBILE'    => 0, //没有验证

    //平台短信类型（注册、预约、发送给平台的配置在前台）
    'MSG_CUSTOMER'        => 1, //订单短信发送给客户的短信
    'MSG_CEMETERY'        => 2, //订单发给给陵园的短信
    'MSG_RETURN_SUCCESS'  => 5, //返现成功发送给客户的短信
    'MSG_SEND_STATUS'     => 1, //短信发送成功的标识，写入短息记录中

     //订单中发送给财务的状态
    'SEND_TO_FINANCE'=>array(
        'DEFAULT'         => 0, //默认状态
        'SUCCESS'         => 1, //发送给财务
        'SUCCESS_FINANCE' => 2, //完成订单后后期申请返现推送给财务状态
    ),
    
     //后期申请返现的状态
    'APPOINT_RETURN' => array(
        'DEFAULT'         => 0, //默认值
        'APPOINTED'       => 1, //已申请
        'SEND_TO_FINANCE' => 2, //推送给财务，前台是待返现
        'SUCCESS'         => 5, //返现完成
    ),

    //推送给财务状态
    'SEND_FINANCE_STATUS' => array(
        'DEFAULT'         => 0, //默认推送给财务
        'SEND_FINANCE'    => 1, //推送给财务
        'SUCCESS_FINANCE' => 2, //完成订单后后期申请返现推送给财务状态
    ),

    'PAY_ACTIVE_TIME' => 86400, //陵园支付有效时间段(退单用到)

    //运营网站加密使用(注：请忽随意修改，修改前请把所有运营网站原密码做好备份)
    'OPEX_WEB_PWD'    =>'soumu',

    //属性添加时候读取的分类id
    'ATTRIBUTE_CATEGORY' => array(37, 38, 39, 40),

    // 评论状态
    'COMMENT_STATUS' => array(
        'UNPASS' => -1,
        'PASS'   => 1,
    ),

    //融资洽谈信息状态
    'CHAT_STATUS' => array(
        1  => '面谈',
        2  => '签协议',
        3  => '有意向',
        4  => '无意向',
        -1 => '删除',
    ),
    'FINANCE_SEO' =>array(
        10 => '首页',
        11 => '找项目',
    ),
    //融资方式
    'FINANCE_TYPE'=>array(
        '1'=>'全资收购',
        '2'=>'股权融资',
        '3'=>'债权融资',
        '4'=>'其他',
    ),

    //融资项目状态
    'FINANCE_STATUS' =>array(
        'AUDIT'  => 0,           //待审核
        'SALE'   => 1,           //发布
        'FINISH' => 2,           //完成
    ),


    //商务数据跟踪意向类型
    'INTENTION_TYPE' => array(
        1 => '有意向',
        2 => '有需求',
        3 => '不靠谱',
        4 => '已有',
    ),
    // 系统情况
    'IS_SYSTEM' => array(
        1 => '没有',
        2 => '有',
        3 => '不确定',
    ),

    //Highcharts显示搜索词数量
    'ANALYSIS_KEYWORD_NUM' => 10,

    //乐融留言信息状态
    'FINANCE_MESSAGE_STATUS' =>array(
        '-1' => '删除',
        '1'  => '正常',
        '2'  => '跟踪',
        '3'  => '完成',
    ),

    /***********商务数据跟踪配置项************/
    //公司现状
    'FINANCE_BUSINESS_ACTUALITY'=>array(
        '1'=>'新批未建',
        '2'=>'新批在建',
        '3'=>'新建开园',
        '4'=>'成熟陵园',
    ),

    //关键词转化 来源类型
    'SOURCE_TYPE' => array(
        '1' => '电脑端',
        '2' => '移动端',
        '3' => 'ipad端',
    ),

    // 商家类型
    'BUSINESS_TYPE' => array(
        37 => '陵园',
        38 => '殡仪馆',
    ),

    'TRACK_EXCEL' => 'BTrack',//商务数据导入跟踪

    //仓库管理状态
    'STORAGE_STATUS'=>array(
        '1'=>'正常',
        '-1'=>'弃用',
    ),

    //基础商品状态
    'SERVICEGOODS_STATUS'=>array(
        '1'=>'在售',
        '-1'=>'下架',
    ),

    //祭祀商品分类
    'SACRIFICE_GOODS' => 94,



     //客户资金结算状态
    'CMONEY_STATUS' => array(
        'DEFAULT' => 0,   //尚未结算
        'SUCCESS' => 1,   //已经结算
    ),

    //陵园工作人员推荐客户--单位佣金
    'CMONEY_OF_SENDER'=>array(
        'COSTOMER'=>10,//10元
    ),

    //供应商
    'SUPPLIER' =>array(
        '1' => '北京卉格苑',
        '2' => '卉格苑',
    ),
    //祭祀商品套餐分类id
    'PACKAGE' => 101,

    //祭祀商品鲜花分类ID
    'FLOWER' => 95,
    
    //进销存财务管理状态
    //待付款
    'WAITPAYMENT' => 0,
    'FINANCIAL_STATUS' => array(
        '1' => '付部分款',
        '2' => '完成付款',
    ),

);