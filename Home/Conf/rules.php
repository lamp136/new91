<?php
return array(
    'URL_MODEL' => 2,
    'URL_ROUTER_ON'         =>  true,
    'URL_ROUTE_RULES'=>array(
        '/^service\/(\w+)$/' => 'Service/index?storeId=:1',   //祭扫服务商家首页
        '/^service$/' => 'Service/index',//祭扫服务首页
        '/^service\/detail\/(\d+)$/' => 'Service/detail?store_goods_sn=:1', //服务详情页
        '/^cart$/' => 'Cart/index', //购物车首页
        '/^cemetery$/' => 'Cemetery/index',     //全国陵园首页
        '/^cemetery\/submitappoint$/' => 'Cemetery/submitappoint', //提交域名的表单
        '/^cemetery\/famous$/' => 'Cemetery/lists',     //所有名人墓地列表
        '/^cemetery\/collect$/' => 'Cemetery/collect',    //添加收藏
        '/^cemetery\/sendmessage$/' => 'Cemetery/sendmessage',    //预约发送短信验证码

        '/^cemetery\/(\w+)$/' => 'Cemetery/index?region=:1',    //地区陵园列表页
        '/^cemetery\/detail\/(\d+)$/' => 'Cemetery/detail?store_id=:1',     //陵园详情页
        '/^cemetery\/tomb-(\d+)$/' => 'Cemetery/tomb?store_id=:1',       //墓型列表
        '/^cemetery\/famous-(\d+)/' => 'Cemetery/famous?store_id=:1',    //名人墓地列表
        '/^cemetery\/famous-d-(\d+)$/' => 'Cemetery/famousdetail?id=:1',    //名人墓地详情


        '/^order\/(\d+)$/' => 'Cemetery/appoint?store_id=:1',      //陵园预约
        '/^search$/' => 'Search/searchd',                 //搜索相关路由
        '/^c-search$/' => 'Search/cemetery',
    	'/^f-search$/' => 'Search/funeral',
        '/^book$/' => 'Cemetery/book',//预约看墓
        '/^collaborate$/' => 'Intro/collaborate', //陵园合作申请

        '/^searchkeywords$/' => 'Search/searchKeywords',    //搜索词记录的记录
    	'/^searchcemetery$/' => 'Search/searchCemetery',    //搜索词记录的记录
    	'/^searchfuneral$/' => 'Search/searchFuneral',    //搜索词记录的记录

        '/^funeral$/' => 'Funeral/lists',    //全国殡仪馆列表页
        '/^funeral\/(\w+)$/' => 'Funeral/lists?region=:1',    //殡仪馆列表页
        '/^funeral\/detail\/(\d+)$/' => 'Funeral/detail?store_id=:1',    //殡仪馆详情页

        '/^personal$/' => 'UserCenter/personal',    //个人资料
        '/^changepassword$/' => 'UserCenter/changepassword',    //密码修改
        '/^myorder$/' => 'UserCenter/myorder',  //我的订单
        '/^cashback$/' =>'UserCenter/cashback', //领取返现
        '/^evaluate$/' =>'UserCenter/evaluate', //我的评价
        '/^collect$/'  =>'UserCenter/collect',  //我的收藏
        '/^uploadbill\/(\d+)$/' => 'UserCenter/uploadbill?order_id=:1',  //上传票据

        '/^news$/' => 'News/index',     //新闻首页
        '/^news\/detail\/(\d+)$/' => 'News/detail?id=:1', //新闻详情
        '/^news\/(\d+)$/' => 'News/lists?pid=:1', //一级分类
        '/^news\/(\d+)-(\d+)$/' => 'News/lists?pid=:1&cid=:2', //二级分类
        '/^fengshui$/' => 'News/fengshui',    //殡葬风水

    	'/^specialtopics$/' => 'SpecialTopics/index',  //会员专栏
    	'/^login$/' => 'Member/login',      //用户登陆
    	'/^register$/' => 'Member/register', //用户注册
      	'/^logout$/' => 'Member/logout',     //用户退出登录
		'/^api$/' => 'Api',
    	':area$' => 'Index/changeArea', //地区首页

	    '/^help\/guide\/(\w+)$/' => 'Help/guide?tpl=:1',   //购墓指南
    	'/^help\/security\/(\w+)$/' => 'Help/security?tpl=:1',   //订单保障
    	'/^help\/issue\/(\w+)$/' => 'Help/issue?tpl=:1',    //常见问题
    	'/^help\/common\/(\w+)$/' => 'Help/common?tpl=:1',    //殡葬常识

    	//301跳转
    	'/^area\/(\w+)$/' => '/:1.html',

    	'/^Store\/store\/store_id\/293\/' => '/cemetery/hunan.html',
    	'/^Store\/store\/store_id\/525\/' => '/cemetery/detail/369.html',
    	'/^Store\/store\/store_id\/94\/' => '/cemetery/shanxi.html',

    	'/^Store\/store\/store_id\/(\d+)$/' => '/cemetery/detail/:1.html',
    	'/^Store\/goodslist\/store_id\/(\d+)$/' => '/cemetery/tomb-:1.html',
    	'/^Store\/details\/store_id\/(\d+)\/goods_id\/(\d+)$/' => '/cemetery/tomb-:1.html',
    	'/^Store\/merchartList$/' => '/cemetery.html',
    	'/^Orders\/makeAppointment\/store_id\/(\d+)$/' => '/order/:1.html',
    	'/^Orders\/makeAppointment\/store_id\/(\d+)\/goods_id\/(\d+)$/' => '/order/:1.html',
    	'/^Information\/index$/' => '/news.html',

    	'/^Information\/celebrityCemeterysList$/'=> '/cemetery/famous.html',
    	'/^Information\/celebrityCemeterysDetails\/id\/(\d+)$/' => '/cemetery/famous-d-:1.html',

    		'/^Information\/informationList\/cid\/2$/' => '/news/2.html',
    		'/^Information\/informationList\/cid\/4$/' => '/news/4.html',
    		'/^Information\/informationList\/cid\/13$/' => '/news/13.html',
    		'/^Information\/informationList\/cid\/65$/' => '/news/65.html',
    		'/^Information\/informationList\/cid\/55$/' => '/news/79-55.html',
    		'/^Information\/informationList\/cid\/52$/' => '/news/79-52.html',
    		'/^Information\/informationList\/cid\/67$/' => '/news/78-67.html',
    		'/^Information\/informationList\/cid\/68$/' => '/news/78-68.html',
    		'/^Information\/informationList\/cid\/3$/'  => '/news/78-3.html',
    		'/^Information\/informationList\/cid\/57$/' => '/news/78-57.html',
    		'/^Information\/informationList\/cid\/59$/' => '/news/80-59.html',
    		'/^Information\/informationList\/cid\/58$/' => '/news/80-58.html',
    		'/^Information\/informationList\/cid\/60$/' => '/news/81-60.html',
    		'/^Information\/informationList\/cid\/64$/' => '/news/81-64.html',
    		'/^Information\/informationList\/cid\/62$/' => '/news/61-63.html',
    		'/^Information\/informationList\/cid\/63$/' => '/news/61-63.html',
    		'/^Information\/informationList\/cid\/66$/' => '/news/61-66.html',


        '/^Information\/informationDetails\/cid\/(\d+)\/id\/(\d+)$/' => '/news/detail/:2.html',   //301跳转，以http开头或者是/开头
    	'/^Fengshui\/index$/' => '/fengshui.html',
    	'/^Fengshui\/fengShuiDetails\/cid\/(\d+)\/id\/(\d+)$/' => '/news/detail/:2.html',
    	'/^Ask\/index$/' => '/news/13.html',
        '/^Ask\/askDetails\/cid\/(\d+)\/id\/(\d+)$/' => '/news/detail/:2.html',

    	'/^Login\/login$/' => '/login.html',
    	'/^Regist\/regist$/' => '/register.html',

    	'/^Soumu\/about$/' => '/intro/aboutus.html',
        '/^Soumu\/contact$/' => '/intro/contactus.html',
    	'/^Soumu\/sitemap$/' => '/intro/sitemap.html',
    	'/^Soumu\/(\w+)$/'=> '/',

    	'/^Topics\/hyj$/' => '/topics/hanyijie.html',
    	'/^Topics\/99cyj$/' => '/topics/chongyangjie.html',
    	'/^Topics\/ghostfestival$/' => '/topics/zhongyuanjie.html',
    	'/^Topics\/fangshan$/' => '/topics/hbfs.html',
        
    ),

);