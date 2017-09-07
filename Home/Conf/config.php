<?php
return array(
    //'配置项'=>'配置值'
    'LOAD_EXT_CONFIG' => 'rules', //加载路由
    'SITE_NAME'       => '91搜墓网', //网站名称，用于网站title 的最后
    'KEFU_TEL'        => '400-8010-344',

    'SEARCH_SERVER'  => '114.80.200.252', //'139.224.17.221',   //搜索引擎服务
    
    'HOME_LIFETIME'             => 3600*24*7,  //cookie保存周期
    'MEMBER_FRONT_REGISTER'     => 1,      //前台注册(会员注册类型)

     //是否使用IP定位系统
    'IP_LOCATION'               => true,
    'EVERYDAY_SEND_MESSAGE_NUM' => 10, //每天前台允许发给每个用户的短信条数
    'BOOK_EVERY_IP_NUM'         => 3,  //前台每个IP允许的预约次数（陵园首页页面的预约）

    //验证码类型
    'MSGCODE_TYPE' =>array(
        'REGISTER' => 11,
        'APPOINT'  => 12,
        'FINANCE'  => 9,
    ),
    //平台短信类型
    'PLATFORM_NUM'     => 6, //短信标识发送给平台人员
    'MSG_LOG_REGISTER' => 3, //注册时发送的短信标识
    'MSG_LOG_APPOINT'  => 4, //预约时修改手机号

    //短信验证码的状态
    'MESSAGE_CODE_AVAILABLE' => 0,  //可用
    'MESSAGE_CODE_USED'      => 1,  //已用
    'MESSAGE_CODE_INVALID'   => 2,  //失效

    //商家搜索条件过滤
    'DISTANCE_1_10'  => '1-10',
    'DISTANCE_10_20' => '10-20',
    'DISTANCE_20_30' => '20-30',
    'DISTANCE_30_40' => '30-40',
    'DISTANCE_40_50' => '40-50',
    'DISTANCE_50_80' => '50-80',
    'DISTANCE_80'    => '80',
    
    //其他页面新闻模块获取数据条数
    'DEFAULT_SIZE' => 10,
    'BZWH_SIZE'    => 9,
    //导航菜单
    'CEMETERY'      => 'cemetery',
    'FUNERAL'       => 'funeral',
    'TOPICS'        => 'topics',
    'SPECIALTOPICS' => 'specialtopics',
    'FESTIVALS'     => 'festivals',
    'NEWS'          => 'news',
    'CAROUSEL'      => 'carousel',
    'FINANCING'     => 'financing',
    'SERVICE'       => 'service',

     //广告位
    'HOME_BANNER_NUM'       => 8, //首页轮播图数量
    'HOME_BANNER'           => 4, //首页轮播图的位置标识
    'HOME_NEW_APPIONT_DOWN' => 5, //最新预约下的广告位
    'HOME_COMPANY_NEWS_DOWN'=> 6, //公司动态下的广告位
    'HOME_FVLON'            => 7, //首页横幅广告位
    'HOME_FENGSHUI_DOWN'    => 8, //风水文化下的广告位
    'HOME_QUESTION_DOWN'    => 9, //最新预约下的广告位
    'CEMETERY_HUIMIN_DOWN'  => 10,//陵园列表页，包含搜索列表页
    'NEWS_HOME_PAGE'        => 11,//新闻首页
    'FENGSHUI_PAGE'         => 14,//新闻首页
    'NEWS_DETAIL_PAGE'      => 13,//新闻详情页
    'CEMETERY_DETAIL_PAGE'  => 16,//陵园详情页

    //商务部手机号
    //'BUSINESS_SERVICER_MOBILE'=>  '13366153502,13910894003,13611111573,15553128999',
    'BUSINESS_SERVICER_MOBILE'  =>  '13366153502',
    //专题类型
    'TOPICS_TYPE' => array(
        'CEMETERY' => 1,   //陵园专题
        'FESTIVAL' => 2,   //节日专题
        'CAROUSEL' => 3,   //轮播图
    ),

    //备案相关
    'BEIAN_HAO'       =>"京ICP备12005803号-4",
    'BEIAN_COPY'      =>' Huigeyuan Technology. All Rights',
    
    'WAP_STIE_DOMAIN' =>'http://91wap.99qingliu.net',//WAP端域名(用于对应WAP端)
    
    'LR_URL'          =>'http://91lr.99qingliu.net',
    
    // 陵园殡仪馆浏览量控制（true为开启,false为关闭）
    'HITS_TURN_ON'    =>  true,
    'HITS_CACHE_FILE' =>  './Cache/Runtime/randHits/',//浏览量缓存路径

    //祭祀服务价格过滤
    'SERVICE_MONEY' => array(
        '99-299' => '99元-299元',
        '300-599' => '300元-599元',
        '600-899' => '600元-899元',
        '900' => '900以上',
    ),

    //祭祀商品购买最大数量
    'MAX_NUMBER' => 50,

    //购物车状态
    'NORMAL' => 0; //正常状态
    'CONVERSION' => 1;  //转化为订单
);