<?php
return array(
    //'配置项'=>'配置值'
    'LOAD_EXT_CONFIG'   => 'db',
    //分页相关
    'DEFAULT_PAGE_SIZE' => 10,
    'PAGE_SIZE'         => 10,
    'PAGE_DEFAULT'      => 1, //默认第一页

    'H_PREFIX'          => 's91m',   //前端密码前缀
    'H_SUFFIX'          => 'hgysm',  //前端密码后缀

    'A_PREFIX'          => 'sm91',   //后端密码前缀
    'A_SUFFIX'          => 'hgy',    //后端密码后缀

    'ABOUT_IMAGE'       => 'about',//关于我们图片路径
    'CONTACT_IMAGE'     => 'contact',//联系我们图片路径
    'FINANCE_IMAGE'     => 'Finance', //融资上传图片路径
    'STORE_IMAGE'       => 'Store', //商家上传图片的路径
    'NEWS_IMAGE'        => 'News', //商家新闻上传图片的路径
    'GOODS_IMAGE'       => 'Goods', //商品上传图片的路径
    'TOPICS_IMAGE'      => 'Topics', //专题图片上传路径
    'AD_IMAGES'         => 'Banner', //广告图片文件夹
    'CELEBRITY_IMAGE'   => 'CelebrityCemetery',  //名人墓地图片上传路径
    'ORDER_BILL_IMAGE'  => 'Bill', //订单票据的路径
    'OPEX_EXCEL'        => 'Opex', //运营推广Excel文件上传路径
    'DEFAULT_FILTER'    => 'trim,removeXSS',  //用于I函数过滤
    'SERVICE_GOODS_IMAGE' => 'ServiceGoods',   //商品基础信息图片
    /************ 图片相关的配置 *********************/
    'ROOT_PATH'  =>  './Uploads/',
    'MAX_SIZE'   =>  '3M',
    'EXTS'       =>  array('jpg', 'jpeg', 'pjpeg', 'gif', 'png', 'bmp'),
    'IMG_HOST'   =>  '/Uploads/',

    //陵园殡仪馆分类ID
    'CATEGORY_CEMETERY_ID' => 37,  //陵园分类ID
    'CATEGORY_FUNERAL_ID'  => 38,  //殡仪馆分类ID
    'CATEGORY_GROUP_ID'    => 71,  //集团分类ID
    'CATEGORY_STORE_ID'    => 27,  //店铺分类ID

     //数据状态
    'NORMAL_STATUS'       => 1,  //正常状态
    'DEFAULT_STATUS'      => 0,  //默认状态
    'DELETE_STATUS'       => -1, //删除数据
    'RECOMMEND_STATUS'    => 1,  //推荐数据状态（新闻）
    'HOTNEWS_STATUS'      => 1,  //热门新闻的状态（新闻）
    'HOT_FOCUS_STATUS'    => 1,  //热点聚焦数据状态(新闻)
    'TOP_NEWS_STATUS'     => 1,  //置顶新闻数据状态（新闻）
    'SHARE_STATUS'        => 1,  //广告位分享标识
    'MSG_SEND_STATUS'     => 1,  //短信发送成功的标识，写入短息记录中

    //商家推荐
    'STORE_RECOMMEND' => array(
        'WEIXIN_CEMETERY' => 1,   //微信陵园
        'WEIXIN_FUNERAL'  => 11,  //微信殡仪馆
        'GEOMANCY'        => 2,   //风水推荐标识
        'ENVIRONMENT'     => 3,   //环境推荐标识
        'TRANSPORT'       => 4,   //交通推荐
    ),
    //商家会员标识
    'STOER_MERMBER'            => 20, //商家会员优惠
    'STOER_MERMBER_V'          => 19, //商家会员无优惠只显示会员V
    'STOER_MERMBER_PERSON'     => 16, //个人会员
    'STOER_MERMBER_AD'         => 14, //广告会员
    'STOER_MERMBER_MSG'        => '商家会员',
    'STOER_MERMBER_V_MSG'      => '会员V',
    'STOER_MERMBER_PERSON_MSG' => '个人会员',
    'STOER_MERMBER_AD_MSG'     => '广告会员',
    //会员注册类型
    'MEMBER_FRONT_REGISTER'    => 1,      //前台注册
    //订单类型
    'ORDER_TYPE_FRONT'         => 1,    //前台流程，后台的在后台？？？？
    //订单状态
    'ORDER_STATUS' => array(
        'FAIL'          => -1, //删除
        'DEFAULT'       => 0,  //订单生成成功
        'OK'            => 1,  //订单完成
        'INTERESTING'   => 2,  //有意向
        'CHECK_SUCCESS' => 3,  //审核成功待收佣金
        'GET_MONEY'     => 4,  //收到佣金待返现
        'RETURN_SUCCESS'=> 5,  //返现成功
        'SUCCESS'       => 10, //达成交易
        'STOP'          => 11, //不允许退单
        'NOTVIP'        => 12, //非会员订单
        'APPLY_BACK'    => 21, //申请退单待审核
        'ALLOW'         => 22, //申请退单审核通过
        'BACK_SUCCESS'  => 30, //退单完成
        'NO_RELATION'   => 31, //购墓成功与平台无关
    ),
    //地区相关
    'CHINA_NUM'  => 2,
    'CHINA_MSG'  => '全国',
    'CHINA_ABBR' => 'ALL',

    //新闻类型
    'NEWS_CATEGORY_ID'                   => 1,  //新闻分类的ID
    'CATEGORY_INDUSTRY_INFORMATION'      => 78, //业界资讯
    'CATEGOTY_INDUSTRY_DYNAMIC'          => 3,  //行业新闻
    'CATEGOTY_LAWS_REGULATIONS'          => 57, //政策法规
    'CATEGOTY_STORE_DYNAMIC'             => 68, //陵园动态
    'CATEGOTY_COM_CULTURE'               => 67, //企业软文

    'CATEGORY_CEMETERY_AMOROUS_FEELINGS' => 61, //陵园风情  一级分类
    'CATEGOTY_LIFE_GNOSIS'               => 66, //人生感悟  二级
    'CATEGOTY_CEMETRY_STORY'             => 62, //陵园故事  二级
    'CATEGOTY_LUCKY_CELEBRITY'           => 63, //福地名人  二级

    'CATEGORY_SACRIFICE_CUSTOM'          => 80, //祭祀习俗  一级分类
    'CATEGOTY_BURIAL_CUSTOM'             => 58, //丧葬习俗  二级
    'CATEGOTY_SACRIFICE_RITES'           => 59, //祭祀活动  二级
    'CATEGOTY_COMPANY_DYNAMIC'           => 2,  //公司动态
    'CATEGOTY_SENSE'                     => 13, //白事常识
    'CATEGOTY_BURIED_TYPE'               => 65, //葬式墓型
    'CATEGORY_TRADITIONAL_FESTIVAL'      => 14, //传统节日
    'CATEGOEY_FENGSHUI_CULTURE'          => 79, //风水文化  一级分类
    'CATEGOTY_FUNERAL_CULTURE'           => 55, //殡葬文化  二级
    'CATEGOTY_FS_FORTUNES'               => 52, //风水运势  二级
    'CATEGORY_FUNERAL_SCIENCE'           => 81, //殡葬科学  一级分类
    'CATEGOTY_COUPE_KNOWLEDGE'           => 64, //科普知识  二级
    'CATEGOTY_KG_CULTURE'                => 60, //考古文化  二级
    'CATEGORY_FINANCE_PLATFORM'          => 88, //平台融资  二级
    'CATEGORY_TRADE_FINANCING'           => 89, //行业融资  二级

    //订单中的返现状态
    'APPLY_RETURN_STATUS' => array(
        'DEFAULT_STATUS'         => 0, //0默认不需要，
        'NEED_RETURN_STATUS'     => 1, //1需要申请
        'OK_CHECK_RETURN_STATUS' => 2, //2审核通过
        'SOTP'                   => 6, //审核不通过
    ),
    //前台订单状态
    'APPOINT_STATUS' =>array(
        'WAITING' => 0,  //待处理
        'ON_LOAD' => 1,  //处理中
        'REFUSE'  => 2,  //拒绝
        'SUCCESS' => 5,  //成功
        'DEL'     => -1, //删除
    ),
     //票据状态
    'AUDIT_STATUS' => array(
        'DEFAULT'    => 0,  //默认状态
        'WAIT_CHECK' => 20, //待审核
        'SUCCESS'    => 21, //成功
        'FAIL'       => 22, //失败
    ),

    // 发送给商家的状态
    'SEND_TO_STORE' =>array(
        'DEFAULT' => 0,//未推送
        'SUCCESS' => 1,//已推送
    ),

    //财务票据类型
    'BILL_TYPE' => array(
        'BROKERAGE' => 1,//佣金   
        'CASH'      => 2,//返现
        'BACK'      => 3,//退单
        '1'         =>'佣金票据',
        '2'         =>'返现票据',
        '3'         =>'退单票据',
    ),
    //返现状态
    'RETURN_PESENT_STATUS' => array(
        'DEFAULT'  => 0,
        'WAITING'  => 31, //待返现
        'SUCCESS'  => 32, //返现成功
        'NOT_NEED' => 35, //不需要返现
    ),
    //SEO 类型
    'SEO_TYPE' =>array(
        'CEMETERY_HOME' => 1, //陵园首页
        'CEMETERY_LIST' => 2, //陵园列表页
        'NEWS_HOME'     => 4, //新闻首页
        'NEWS_CLASS'    => 5, //新闻分类
        'FUNERAL_LIST'  => 8, //殡仪馆列表
    ),
    //专题类型
    'TOPICS_TYPE' => array(
        'CEMETERY' => 1,  //陵园专题
        'FESTIVAL' => 2,  //节日专题
        'CAROUSEL' => 3,  //轮播图
    ),

    'STORE_IMG_GATEHOUSE'     => 1,   //门楼
    'STORE_IMG_SCENERY'       => 2,   //景观
    'STORE_IMG_FACILITY'      => 3,   //设施
    'STORE_IMG_TOMB'          => 4,   //墓位
    'STORE_IMG_QUALIFICATION' => 5,   //资质

    //搜索词来源地方
    'SEARCH_TOP'          => 1,
    'SEARCH_TOP_MSG'      => '顶部',
    'SEARCH_CEMETERY'     => 2,
    'SEARCH_CEMETERY_MSG' => '陵园',
    'SEARCH_FUNERAL'      => 3,
    'SEARCH_FUNERAL_MSG'  => '殡仪馆',
    'SEARCH_NEWS'         => 4,
    'SEARCH_NEWS_MSG'     => '新闻',

    //殡仪馆等级
    'FUNERAL_LEVEL' =>array(
        1 => '一级',
        2 => '二级',
        3 => '三级',
        4 => '四级',
        5 => '五级',
        6 => '六级'
    ),
    /**************配置缓存****************/
   // 缓存持续周期  1个小时
   'DATA_CACHE_TIME'   => 3600,
   // 缓存前缀
   'DATA_CACHE_PREFIX' => 'fs_',
   // 缓存类型
   'DATA_CACHE_TYPE'   => 'file',
   // 缓存路径
   'DATA_CACHE_PATH'   => './Cache/Runtime/SCache/',
   
   // F缓存key
   'F_CACHE_KEY'       => 'fs_cache_key',
   // S缓存key
   'S_CACHE_KEY'       => '52',
   //全国缓存时间
   'CHINA_CACHE_TIME'  => 3600*24*2,
   
   'HOME_CACHE_PREFIX' =>'home_',//首页缓存前缀
   'HOME_CACHE_TIME'   =>3600*24*2,//首页缓存时间

    // 支付相关
    'PAY_TYPES' => array(
        1 => '网银',
        2 => '信用卡',
        3 => '微信',
        4 => '支付宝',
    ),

    // 支付方式
    'PAY_TYPE' => array(
        '1'  =>'工商银行',
        '2'  =>'农业银行',
        '3'  =>'中国银行',
        '4'  =>'建设银行',
        '5'  =>'交通银行',
        '6'  =>'邮政储蓄银行',
        '7'  =>'中信银行',
        '8'  =>'光大银行',
        '9'  =>'华夏银行',
        '10' =>'民生银行',
        '11' =>'广发银行',
        '12' =>'深圳发展银行',
        '13' =>'招商银行',
        '14' =>'兴业银行',
        '15' =>'浦发银行',
        '16' =>'平安银行',
        '17' =>'恒丰银行',
        '18' =>'渤海银行',
        '19' =>'浙商银行',
        '20' =>'北京银行',
        '21' =>'上海银行',
        '22' =>'支付宝',
        '23' =>'微信钱包',
    ),
    
    // 邮箱配置
    'MAIL_SMTP'     => TRUE, 
    'MAIL_HOST'     => 'smtp.exmail.qq.com',//smtp服务器的名称
    'MAIL_SMTPAUTH' => TRUE, //启用smtp认证
    'MAIL_USERNAME' => 'Notice@huigeyuan.com', //发件人邮箱名
    'MAIL_PASSWORD' => 'Hgy123',//发件人邮箱密码
    'MAIL_SECURE'   => 'tls',
    'MAIL_CHARSET'  => 'utf-8',//设置邮件编码
    'MAIL_ISHTML'   => TRUE, // 是否HTML格式邮件
    'MAIL_FROMNAME' => '卉格苑(北京)科技有限公司',//发件人姓名

    //email标记信息
    'EMAIL_MSG' =>array(
        '1' => '91乐融留言',
        '2' => '陵园合作申请',
        '3' => '预约看墓',
    ),
    //陵园推广人员
    'FROM_TYPE_WORKER'  => 10,

     //服务订单状态
    'SERVICE_ORDER_STATUS' => array(
        'FAIL'          => -1, //后台删除
        'DEFAULT'       => 0,  //待支付
        'OK'            => 1,  //成功支付
        'WAITSENT'      => 5,  //待发货
        'SUCCESS'       => 10, //订单完成
        'STOP'          => 11, //不允许退单
        'DELETE_FORWARD'=> 20, //前台删除
        'APPLY_BACK'    => 21, //申请退单待审核
        'ALLOW'         => 22, //申请退单审核通过
        'BACK_SUCCESS'  => 30, //退单完成
        'NO_RELATION'   => 31, //购墓成功与平台无关
    ),


    //商品基础图片表图片分类
    'GOODS_IMAGE_DETAIL' => 1, //详情图片
    'GOODS_IMAGE_SMALL'  => 2,  //轮播小图
);