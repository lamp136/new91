<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link rel="icon" href="/Public/soumu.ico" type="image/x-icon" />
    <title><?php echo ($seoInfo["seo_title"]); ?>_<?php echo (C("SITE_NAME")); ?></title>
    <meta name="keywords" content="<?php echo ($seoInfo["seo_keywords"]); ?>" />
    <meta name="description" content="<?php echo ($seoInfo["seo_description"]); ?>" />
    <link href="<?php echo (CSS_URL); ?>screen.css" media="screen, projection" rel="stylesheet" type="text/css"/>
    <!-- 轮播图样式slide.css -->
    <link rel="stylesheet" type="text/css" href="<?php echo (CSS_URL); ?>slide.css"/>
    
    <script type="text/javascript" src="<?php echo (JS_URL); ?>wap.js"></script>
    <script type="text/javascript">
        var url = window.location.pathname;
        var newurl = "<?php echo (C("WAP_STIE_DOMAIN")); ?>"+url;
        browserRedirect(newurl);
    </script>
</head>
<body>
    <!-- 顶部 -->
    <div class="navbar_top">
        <div class="contain">
            <div class="greet">
                <?php if(empty($_SESSION['member_name'])): if(getHomeUrl() != "/"): ?><span>您好! 欢迎来到91搜墓网&nbsp;<a href="<?php echo U('/'.strtolower(C('CHINA_ABBR')));?>" title="返回首页">返回首页</a></span>
                    <?php else: ?>
                        <span>您好! 欢迎来到91搜墓网首页</span><?php endif; ?>
                    <a class="login" href="<?php echo U('/login');?>" title="登陆">登录</a>
                    <a href="<?php echo U('/register');?>" title”注册“>注册</a>
                <?php else: ?>
                    <?php if(getHomeUrl() != "/"): ?><span><?php echo (session('member_name')); ?>您好! 欢迎来到91搜墓网&nbsp;<a href="<?php echo U('/'.strtolower(C('CHINA_ABBR')));?>" title="返回首页">返回首页</a></span>
                    <?php else: ?>
                        <span><?php echo (session('member_name')); ?>您好! 欢迎来到91搜墓网首页</span><?php endif; ?>
                    <a href="<?php echo U('/logout');?>" rel="nofollow" title="推出登陆">退出登录</a><?php endif; ?>
            </div>
            <div class="nav_top">
                <ul>
                    <li class="scan">
                        <img src="<?php echo (IMG_URL); ?>saomwei.gif" alt="91搜墓网微信公众号二维码"/>扫描微信<i></i>
                        <span class="toolbar-layer"></span>
                    </li>
                <li><a target="_blank" href="<?php echo U('/personal');?>" rel="nofollow">用户中心</a></li>
                <li><a target="_blank" href="<?php echo U('/help/issue/xmjq');?>">帮助中心</a></li>
                <li><a target="_blank" href="<?php echo U('/intro/sitemap');?>">网站地图</a></li>
                <!--<li class="last"><a href="<?php echo U('/Storecenter/login');?>" rel="nofollow">商家后台</a></li>-->
                </ul>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div><!-- 顶部结束navbar_top -->
    <!-- 头部header -->
    <div class="header">
        <div class="contain">
            <!-- LOGO -->
            <div class="logo clearfix">
                <a href="<?php echo getHomeUrl(); ?>">
                    <img src="<?php echo (IMG_URL); ?>logo.png" alt="91搜墓网_<?php echo ($regionName); ?>站"/>
                    <img src="<?php echo (IMG_URL); ?>logo_left.gif" alt="陵园，墓地-91搜墓网">
                </a>
            </div>
            <!-- 选择城市+搜索 -->
            <div class="search">
                <!-- 选择城市 -->
                <div class="city">
                    <span class="sele c_down"><?php echo ($regionName); ?><i class="sele_bg"></i></span>
                    <!-- 展开城市列表 -->
                    <div class="city_list search_city">
                        <div class="ci_title">
                            <ul id="city_nav">
                                <li><a href="javascript:void(0)" tab="tabCity1" rel="nofollow">省份</a></li>
                            </ul>
                            <span class="c_close search_close"></span>
                        </div>
                        <!-- 展开的城市 -->
                        <ul class="list_box">
                            <!-- 热门城市 -->
                            <li id="tabCity1" class="city_box">
                                <ul class="clearfix">
                                <?php if(is_array($region)): $i = 0; $__LIST__ = $region;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                        <a href="<?php echo U('/'.strtolower($vo['abbreviate']));?>"  title="<?php echo (C("SITE_NAME")); ?>_<?php echo ($vo["region_name"]); ?>站"><?php echo ($vo["region_name"]); ?></a>
                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                            </li>
                        </ul><!-- list_box展开的城市结束 -->
                    </div><!-- city_list展开城市列表结束 -->
                </div><!-- city选择城市结束 -->
                <form id='seacth_top_form' action='/search' method='get' onsubmit="return search_top()">
                    <input class="tex" type="text" data-id="kwd" name='wd' autocomplete="off" placeholder="请输入搜索的陵园名称" />
                    <button class="btn"></button>
                    <div class="search_box" style="text-align: left; font: 15px 'Microsoft Yahei'; position:absolute; z-index: 100; margin:31px 90px; background:white; border: 1px solid #FBB784; display: none; width: 245px;"></div>
                </form>
            </div><!-- search选择城市+搜索结束 -->
            <!-- 热线 -->
            <div class="header_phone clearfix">
                <img src="<?php echo (IMG_URL); ?>header_phone_img.png" alt="热线电话:4008010344"/>
            </div>
            <!-- 查找陵园+查找殡仪馆tab -->
            <div class="seek">
                <!-- tab标题 -->
                <div class="seek_title clearfix">
                    <ul id="seek_nav">
                        <li class="seek_lia"><a href="javascript:void(0)" tab="tabA" rel="nofollow"  rel="nofollow">查找陵园</a></li>
                        <li><a href="javascript:void(0)" tab="tabB" rel="nofollow">查找殡仪馆</a></li>
                    </ul>
                </div>
                <!-- 搜索内容 -->
                <ul class="seek_list">
                    <!-- 查找陵园 -->
                    <li id="tabA" class="seek_box">
                        <form id='search_cemetery_form' onsubmit="return search_cemetery()" action="/c-search"  method="get">
                        <ul>
                            <li class="seek_city">
                                <span>地区</span><input class="seek_tex seek_down cemetery-province" type="text" placeholder="请选择地区"  value="<?php echo (session('ip_region_name')); ?>"/>
                                <input type="hidden" value="<?php echo ($regionId); ?>" class="cemetery-provinceid" name="province">
                                <!-- 展开城市列表 -->
                                <div class="city_list see_city">
	                                <div class="ci_title">
	                                    <ul id="cityB_nav">
	                                        <li><a href="jascription:void(0)" tab="tabCity7" rel="nofollow">热门城市</a></li>
	                                    </ul>
	                                    <span class="c_close seek_close"></span>
	                                </div>
	                                <!-- 展开的城市 -->
	                                <ul class="list_box">
	                                    <!-- 热门城市 -->
	                                    <li id="tabCity7" class="cityB_box">
	                                        <ul class="clearfix">
	                                            <?php if(is_array($region)): $i = 0; $__LIST__ = $region;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
	                                                    <a class="region_provice" href="javascript:void(0)" data-val="<?php echo ($vo["region_id"]); ?>" rel="nofollow"><?php echo ($vo["region_name"]); ?></a>
	                                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
	                                        </ul>
	                                    </li>  
	                                </ul><!-- list_box展开的城市结束 -->
	                            </div><!-- city_list展开城市列表结束 -->
                            </li>
                            <li class="name">
                                <span>陵园名称</span><input class="seek_tex" type="text" placeholder="（选填）陵园名称" name="wd"/>
                            </li>
                            </ul>
                            <button class="seek_btn">立即搜索</button>
                        </form>
                        <p><span>温馨提示：</span>在平台预约会员陵园，并成功购墓者，可享平台返现优惠！</p>
                    </li>
                    <!--查找殡仪馆-->             
                    <li id="tabB" class="seek_box seek_bin">
                        <form id='search_funeral_form' onsubmit="return search_funeral()" action="/f-search"  method="get">
                            <ul>
                                <li class="city_bin">地<span>区</span><input class="seek_tex byg_down funeral-province" type="text" placeholder="请选择地区" value="<?php echo (session('ip_region_name')); ?>" />
                                    <input type="hidden" value="<?php echo ($regionId); ?>" class="funeral-provinceid" name="province">
                                    <div class="city_list byg_city">
                                        <div class="ci_title">
                                            <ul id="cityC_nav">
                                                <li><a href="javascript:;" rel="nofollow" tab="tabCity13">热门城市</a></li>
                                            </ul>
                                            <span class="c_close byg_close"></span>
                                        </div>
                                        <!-- 展开的城市 -->
                                        <ul class="list_box">
                                            <!-- 热门城市 -->
                                            <li id="tabCity13" class="cityC_box">
                                                <ul class="clearfix">
                                                    <?php if(is_array($region)): $i = 0; $__LIST__ = $region;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                                        <a class="funeral_provice" href="javascript:void(0)" data-val="<?php echo ($vo["region_id"]); ?>"><?php echo ($vo["region_name"]); ?></a>
                                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                                </ul>
                                            </li>
                                        </ul><!-- list_box展开的城市结束 -->
                                </div><!-- city_list展开城市列表结束 -->
                                </li>
                                <li class="name_bin">
                                    <span>殡仪馆名称</span><input class="seek_tex" type="text" placeholder="（选填）殡仪馆名称" name="wd"/>
                                </li>
                            </ul>
                            <button class="seek_btn">立即搜索</button>
                        </form>
                        <p><span>温馨提示：</span>在平台预约会员陵园，并成功购墓者，可享平台返现优惠！</p>
                    </li>
                </ul>
            </div><!-- seek查找陵园+查找殡仪馆tab结束 -->
        </div><!-- contain -->
    </div><!-- 头部header结束 -->
    <!-- 导航 -->
    <div class="nav">
        <div class="contain">
            <ul class="nav_list clearfix">
                <li class="lineheight"><a href="<?php echo getHomeUrl(); ?>" >首页</a></li>
                <li><a href="<?php echo getHomeUrl('cemetery'); ?>" >陵园</a></li>
                <li><a href="<?php echo (C("LR_URL")); ?>" target="_blank">91乐融</a></li>
                <li><a href="<?php echo U('/service');?>">祭扫服务</a></li>
                <li><a href="<?php echo getHomeUrl('funeral'); ?>" >殡仪馆</a></li>
                <li><a href="<?php echo U('/news');?>" >资讯</a></li>
                <li><a href="<?php echo U('/specialtopics');?>" >会员专栏</a></li>
                <!--<li><a href="jascription:void(0)">传统节日</a></li>-->
                <li class="last"><a href="<?php echo U('/fengshui');?>" >殡葬风水</a></li>
            </ul>
        </div>
    </div><!-- nav导航结束 -->
    <!--banner部分-->
    <div class="main_visual">
        <div class="flicking_con">
            <div class="flicking_inner">
            <?php if(is_array($ads)): $i = 0; $__LIST__ = $ads;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ad): $mod = ($i % 2 );++$i;?><a href="jascription:void(0)"></a><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
        <div class="main_image clearfix">
            <ul>
                <?php if(is_array($ads)): $i = 0; $__LIST__ = $ads;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ad): $mod = ($i % 2 );++$i;?><li>
                        <?php if(($ad["banner_link"]) == "/"): ?><a href="javascript:void(0)" title="<?php echo ($ad["banner_name"]); ?>" target="_blank">
                        <?php else: ?>
                        <a href="<?php echo ($ad["banner_link"]); ?>" title="<?php echo ($ad["banner_name"]); ?>"  target="_blank"><?php endif; ?>
                        <span style="background: url('<?php echo (C("IMG_HOST")); echo ($ad["banner_url"]); ?>') center top no-repeat;"></span></a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <a href="javascript:;" id="btn_prev"></a>
        <a href="javascript:;" id="btn_next"></a>
    </div><!-- banner部分结束 -->
    <!-- 中间内容部分 -->
    <div class="main">
        <div class="contain">
            <!-- 最新陵园 -->
            <div class="cemetery clearfix">
                <!-- 左侧内容 -->
                <div class="cemetery_left">
                    <h1><span class="cemetery_title"></span>最新陵园</h1>
                    <ul>
                        <?php if(is_array($newstore)): $k = 0; $__LIST__ = $newstore;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li <?php if($k%3== '0'): ?>class='last'<?php endif; ?>>
                            <a href="<?php echo U('cemetery/detail/'.$vo['store_id']);?>" target="_blank" title="<?php echo ($vo["store_name"]); ?>">
                                <?php if(empty($vo["store_banner"])): ?><img src="<?php echo (IMG_URL); ?>cemetery_img1.jpg" alt="<?php echo ($vo["store_name"]); ?>" />
                                <?php else: ?>
                                    <img src="<?php echo ($vo["store_banner"]); ?>" alt="<?php echo ($vo["store_name"]); ?>" /><?php endif; ?>
                            </a>
                            <?php if(in_array(($vo["member_status"]), is_array($storeMembersYH)?$storeMembersYH:explode(',',$storeMembersYH))): ?><span class="coupon"></span><?php endif; ?>
                                <div class="describe">
                                    <h2>
                                        <a target="_blank" href="<?php echo U('cemetery/detail/'.$vo['store_id']);?>" title="<?php echo ($vo["store_name"]); ?>">
                                        <?php if(in_array(($vo["member_status"]), is_array($storeMembersVip)?$storeMembersVip:explode(',',$storeMembersVip))): ?><img class="vip" src="<?php echo (IMG_URL); ?>vip.png" alt="平台会员"/><?php endif; ?>
                                        <?php echo (msubstr($vo["store_name"],0,15)); ?>
                                        </a>
                                    </h2>
                                    <p>特色：<?php echo (msubstr($vo["feature"],0,12)); ?></p>
                                    <p>简介：<?php echo (msubstr($vo["summary"],0,15)); ?></p>
                                    <h3>参考价：<?php if(($vo["min_price"]) > "0"): ?><span>￥ <?php echo ($vo['min_price']); ?></span>万起<?php else: ?>--<?php endif; ?></h3>
                                </div>
                            
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                         <li class="last">
                            <a target="_blank" href="<?php echo U('intro/joinus');?>" title="加盟合作">
                                <img src="<?php echo (IMG_URL); ?>cemetery_jmhz.jpg" alt="加盟合作"/>
                            </a>
                            <div class="describe">
                                 <h2><a target="_blank" href="<?php echo U('intro/joinus');?>" title="加盟合作">91搜墓网期待您的加盟</a></h2>
                                 <p>中国殡葬协会会员单位 </p>
                                 <p>中国殡葬协会青年工作委员会主任单位</p>
                            </div>
                        </li>
                    </ul>
                </div><!-- cemetery_left左侧内容结束 -->
                <!-- 右侧内容 -->
                <div class="cemetery_right">
                    <!-- 最新预约 -->
                    <h1>最新预约<img src="<?php echo (IMG_URL); ?>new.gif" alt="陵园最新预约"/></h1>
                    <table class="table_list" cellspacing="0">
                        <thead class="table_thd">
                            <tr>
                                <th>地区</th>
                                <th>陵园</th>
                                <th>手机</th>
                                <th>预约时间</th>
                            </tr>
                        </thead>
                        <tbody class="table_tbd">
                            <?php if(is_array($appointInfo)): $i = 0; $__LIST__ = $appointInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr <?php if(($mod) == "0"): ?>class="odd"<?php else: ?>class="even"<?php endif; ?>>
                                    <td><a href="<?php echo U('/'.strtolower($vo['abbreviate']));?>" title="<?php echo ($vo["province"]); ?>"><?php echo ($vo["province"]); ?></a></td>
                                    <td><a target="_blank" href="<?php echo U('cemetery/detail/'.$vo['store_id']);?>" title="<?php echo ($vo["store_name"]); ?>"><?php echo (msubstr($vo["store_name"],0,10)); ?></a></td>
                                    <td><?php echo (substr_replace($vo["mobile"],'****',3,4)); ?></td>
                                    <td><?php echo (date('Y-m-d',$vo["appoint_time"])); ?></td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            
                        </tbody>
                    </table><!-- table_list最新预约结束 -->
                    <!-- 广告图 -->
                    <div class="ad1">
                        <?php if(empty($firstAd)): ?><a href="javascript:void(0)">
                            <img src="<?php echo (IMG_URL); ?>index_ad_img1.jpg" alt="91搜墓网"/>
                            </a>
                        <?php else: ?>
                            <a target="_blank" href="<?php echo ($firstAd["banner_link"]); ?>"  title="<?php echo ($firstAd["banner_name"]); ?>">
                            <img src="<?php echo (C("IMG_HOST")); echo ($firstAd["banner_url"]); ?>" alt="<?php echo ($firstAd["banner_name"]); ?>">
                            </a><?php endif; ?>                   
                    </div><!-- ad1广告图结束 -->
                </div><!-- cemetery_right右侧内容结束 -->
            </div><!-- cemetery最新陵园结束 -->
            <!-- 风水推荐 -->
            <div class="cemetery clearfix">
                <!-- 左侧内容 -->
                <div class="cemetery_left geomancy_left">
                    <h1><span class="geomancy_title"></span>风水推荐</h1>
                    <ul>
                        <?php if(is_array($fstj)): $k = 0; $__LIST__ = $fstj;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li <?php if($k%3== '0'): ?>class='last'<?php endif; ?>>
                            <a href="<?php echo U('cemetery/detail/'.$vo['store_id']);?>" target="_blank" title="<?php echo ($vo["store_name"]); ?>">
                                <?php if(empty($vo["store_banner"])): ?><img src="<?php echo (IMG_URL); ?>cemetery_img1.jpg" alt="<?php echo ($vo["store_name"]); ?>" />
                                <?php else: ?>
                                    <img src="<?php echo ($vo["store_banner"]); ?>" alt="<?php echo ($vo["store_name"]); ?>" /><?php endif; ?>
                            </a>
                                <!--判断是否优惠(上海除外)-->
                                <?php if(($vo["province_id"]) != "41"): if(in_array(($vo["member_status"]), is_array($storeMembersYH)?$storeMembersYH:explode(',',$storeMembersYH))): ?><span class="coupon"></span><?php endif; endif; ?>
                                <div class="describe">
                                    <h2>
                                        <a target="_blank" href="<?php echo U('cemetery/detail/'.$vo['store_id']);?>" title="<?php echo ($vo["store_name"]); ?>">
                                        <?php if(in_array(($vo["member_status"]), is_array($storeMembersVip)?$storeMembersVip:explode(',',$storeMembersVip))): ?><img class="vip" src="<?php echo (IMG_URL); ?>vip.png" alt="平台会员"/><?php endif; ?>
                                        <!--判断上海个人会员显示V-->
                                        <?php if(($vo["member_status"] == 16) AND ($vo["province_id"] == 41)): ?><img class="vip" src="<?php echo (IMG_URL); ?>vip.png" alt="平台会员"/><?php endif; ?>
                                        <?php echo (msubstr($vo["store_name"],0,15)); ?>
                                        </a>
                                    </h2>
                                    <p>特色：<?php echo (msubstr($vo["feature"],0,12)); ?></p>
                                    <p>简介：<?php echo (msubstr($vo["summary"],0,15)); ?></p>
                                    <h3>参考价：<?php if(($vo["min_price"]) > "0"): ?><span>￥ <?php echo ($vo['min_price']); ?></span>万起<?php else: ?>--<?php endif; ?></h3>
                                </div>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div><!-- cemetery_left左侧内容结束 -->
                <!-- 右侧内容 -->
                <div class="cemetery_right geomancy_right">
                    <!-- 公司动态 -->
                    <h1>公司动态</h1>
                    <div id="marquee4">
                        <ul>
                            <?php if(is_array($gsdt)): $i = 0; $__LIST__ = $gsdt;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                <a href="<?php echo U('news/detail/'.$vo['id']);?>" title="<?php echo ($vo["title"]); ?>" target="_blank"><?php echo (msubstr($vo["title"],0,28)); ?></a>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                    <!-- 广告图 -->
                    <div class="ad1">
                        <?php if(empty($secAd)): ?><a href="javascript:void(0)">
                                <img src="<?php echo (IMG_URL); ?>index_ad_img1.jpg" alt="91搜墓网平台"/>
                            </a>
                        <?php else: ?>
                            <a target="_blank" href="<?php echo ($secAd["banner_link"]); ?>" title="<?php echo ($secAd["banner_name"]); ?>">
                                <img src="<?php echo (C("IMG_HOST")); echo ($secAd["banner_url"]); ?>" alt="<?php echo ($secAd["banner_name"]); ?>" />
                            </a><?php endif; ?>             
                    </div><!-- ad1广告图结束 -->
                </div><!-- cemetery_right右侧内容结束 -->
            </div><!-- cemetery风水推荐结束 -->
            <!-- 广告图 -->
            <div class="ad2">
            <?php if(empty($hengfuAd)): ?><a href="javascript:void(0)">
                    <img src="<?php echo (IMG_URL); ?>index_ad_img2.jpg" alt="91搜墓网平台优势"/>
		</a>
                <?php else: ?>
                    <a target="_blank" href="<?php echo ($hengfuAd["banner_link"]); ?>" title="<?php echo ($hengfuAd["banner_name"]); ?>">
                    <img src="<?php echo (C("IMG_HOST")); echo ($hengfuAd["banner_url"]); ?>" alt="<?php echo ($hengfuAd["banner_name"]); ?>" />
                    </a><?php endif; ?>
            </div>
            <!-- 环境推荐 -->
            <div class="cemetery clearfix">
                <!-- 左侧内容 -->
                <div class="cemetery_left setting_left">
                    <h1><span class="setting_title"></span>环境推荐</h1>
                    <ul>
                        <?php if(is_array($hjtj)): $k = 0; $__LIST__ = $hjtj;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li <?php if($k%3== '0'): ?>class='last'<?php endif; ?>>
                                <?php if(empty($vo["store_banner"])): ?><a href="<?php echo U('cemetery/detail/'.$vo['store_id']);?>" target="_blank" title="<?php echo ($vo["store_name"]); ?>">
                                        <img src="<?php echo (IMG_URL); ?>cemetery_img1.jpg" alt="<?php echo ($vo["store_name"]); ?>" />
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo U('cemetery/detail/'.$vo['store_id']);?>" target="_blank" title="<?php echo ($vo["store_name"]); ?>">
                                        <img src="<?php echo ($vo["store_banner"]); ?>" alt="<?php echo ($vo["store_name"]); ?>" />
                                    </a><?php endif; ?>
                                <!--判断是否优惠(上海除外)-->
                                <?php if(($vo["province_id"]) != "41"): if(in_array(($vo["member_status"]), is_array($storeMembersYH)?$storeMembersYH:explode(',',$storeMembersYH))): ?><span class="coupon"></span><?php endif; endif; ?>
                                <div class="describe">
                                    <h2>
                                        <a href="<?php echo U('cemetery/detail/'.$vo['store_id']);?>" title="<?php echo ($vo["store_name"]); ?>" target="_blank">
                                        <?php if(in_array(($vo["member_status"]), is_array($storeMembersVip)?$storeMembersVip:explode(',',$storeMembersVip))): ?><img class="vip" src="<?php echo (IMG_URL); ?>vip.png" alt="平台会员"/><?php endif; ?>
                                        <!--判断上海个人会员显示V-->
                                        <?php if(($vo["member_status"] == 16) AND ($vo["province_id"] == 41)): ?><img class="vip" src="<?php echo (IMG_URL); ?>vip.png" alt="平台会员"/><?php endif; ?>
                                        <?php echo (msubstr($vo["store_name"],0,15)); ?>
                                        </a>
                                    </h2>
                                    <p>特色：<?php echo (msubstr($vo["feature"],0,12)); ?></p>
                                    <p>简介：<?php echo (msubstr($vo["summary"],0,15)); ?></p>
                                    <h3>参考价：<?php if(($vo["min_price"]) > "0"): ?><span>￥<?php echo ($vo['min_price']); ?></span>万起<?php else: ?>--<?php endif; ?></h3>
                                </div>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div><!-- cemetery_left左侧内容结束 -->
                <!-- 右侧内容 -->
                <div class="cemetery_right setting_right">
                    <!-- 风水文化 -->
                    <h1>风水文化</h1>
                    <ul class="geomantic">
                        <li class="geomantic_first clearfix">
                            <a href="<?php echo U('news/detail/'.$fswhtj['id']);?>" target="_blank">
                                <?php if(empty($fswhtj["Img"])): ?><img src="<?php echo (IMG_URL); ?>news_default.jpg" alt="<?php echo ($fswhtj["title"]); ?>" />
                                <?php else: ?>
                                    <img src="<?php echo ($fswhtj["Img"]["thumbnail"]); ?>" alt="<?php echo ($fswhtj["title"]); ?>" /><?php endif; ?>
                                <p><?php echo ($fswhtj["title"]); ?></p>
                            </a>
                        </li>
                        <?php if(is_array($fswh)): $i = 0; $__LIST__ = $fswh;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                <a href="<?php echo U('news/detail/'.$vo['id']);?>" title="<?php echo ($vo["title"]); ?>"><?php echo (msubstr($vo["title"],0,25)); ?></a>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                    <!-- 广告图 -->
                    <div class="ad1">
                        <?php if(empty($thirdAd)): ?><a href="javascript:void(0)">
                            <img src="<?php echo (IMG_URL); ?>index_ad_img1.jpg" alt="91搜墓网"/>
                            </a>
                        <?php else: ?>
                            <a target="_blank" href="<?php echo ($thirdAd["banner_link"]); ?>" title="<?php echo ($thirdAd["banner_name"]); ?>">
                            <img src="<?php echo (C("IMG_HOST")); echo ($thirdAd["banner_url"]); ?>" alt="<?php echo ($thirdAd["banner_name"]); ?>" />
                            </a><?php endif; ?>             
                    </div><!-- ad1广告图结束 -->
                </div><!-- cemetery_right右侧内容结束 -->
            </div><!-- cemetery环境推荐结束 -->
            <!-- 交通推荐 -->
            <div class="cemetery clearfix">
                <!-- 左侧内容 -->
                <div class="cemetery_left traffic_left">
                    <h1><span class="traffic_title"></span>交通推荐</h1>
                    <ul>
                        <?php if(is_array($jttj)): $k = 0; $__LIST__ = $jttj;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li <?php if($k%3== '0'): ?>class='last'<?php endif; ?>>
                            <a href="<?php echo U('cemetery/detail/'.$vo['store_id']);?>" target="_blank" title="<?php echo ($vo["store_name"]); ?>">
                                <?php if(empty($vo["store_banner"])): ?><img src="<?php echo (IMG_URL); ?>cemetery_img1.jpg" alt="<?php echo ($vo["store_name"]); ?>" />
                                <?php else: ?>
                                    <img src="<?php echo ($vo["store_banner"]); ?>" alt="<?php echo ($vo["store_name"]); ?>" /><?php endif; ?>
                            </a>
                                <!--判断是否优惠(上海除外)-->
                                <?php if(($vo["province_id"]) != "41"): if(in_array(($vo["member_status"]), is_array($storeMembersYH)?$storeMembersYH:explode(',',$storeMembersYH))): ?><span class="coupon"></span><?php endif; endif; ?>
                                <div class="describe">
                                    <h2>
                                        <a href="<?php echo U('cemetery/detail/'.$vo['store_id']);?>" title="<?php echo ($vo["store_name"]); ?>" target="_blank">
                                        <?php if(in_array(($vo["member_status"]), is_array($storeMembersVip)?$storeMembersVip:explode(',',$storeMembersVip))): ?><img class="vip" src="<?php echo (IMG_URL); ?>vip.png" alt="平台会员"/><?php endif; ?>
                                        <!--判断上海个人会员显示V-->
                                        <?php if(($vo["member_status"] == 16) AND ($vo["province_id"] == 41)): ?><img class="vip" src="<?php echo (IMG_URL); ?>vip.png" alt="平台会员"/><?php endif; ?>
                                        <?php echo (msubstr($vo["store_name"],0,15)); ?>
                                        </a>
                                    </h2>
                                    <p>特色：<?php echo (msubstr($vo["feature"],0,12)); ?></p>
                                    <p>简介：<?php echo (msubstr($vo["summary"],0,15)); ?></p>
                                    <h3>参考价：<?php if(($vo["min_price"]) > "0"): ?><span>￥ <?php echo ($vo['min_price']); ?></span>万起<?php else: ?>--<?php endif; ?></h3>
                                </div>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div><!-- cemetery_left左侧内容结束 -->
                <!-- 右侧内容 -->
                <div class="cemetery_right traffic_right">
                    <!-- 常见问题 -->
                    <h1>常见问题</h1>
                    <ul class="faq">
                        <?php if(is_array($cjwt)): $k = 0; $__LIST__ = $cjwt;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li>
                                <a href="<?php echo U('news/detail/'.$vo['id']);?>" title="<?php echo ($vo["title"]); ?>" target="_blank">
                                    <span <?php if(($k) <= "3"): ?>class="faq_led"<?php endif; ?>><?php echo ($k); ?></span><?php echo (msubstr($vo["title"],0,20)); ?>
                                </a>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                    <!-- 广告图 -->
                    <div class="ad1">
                        <?php if(empty($forthAd)): ?><a href="javascript:void(0)">
                            <img src="<?php echo (IMG_URL); ?>index_ad_img1.jpg" alt="91搜墓网"/>
                            </a>
                        <?php else: ?>
                            <a target="_blank" href="<?php echo ($forthAd["banner_link"]); ?>" title="<?php echo ($forthAd["banner_name"]); ?>">
                            <img src="<?php echo (C("IMG_HOST")); echo ($forthAd["banner_url"]); ?>" alt="<?php echo ($forthAd["banner_name"]); ?>" />
                            </a><?php endif; ?>       
                    </div><!-- ad1广告图结束 -->
                </div><!-- cemetery_right右侧内容结束 -->
            </div><!-- cemetery交通推荐结束 -->
            <!-- 最新资讯 -->
            <div class="cemetery clearfix">
                <!-- 最新资讯 -->
                <div class="new_message">
                    <h1><span class="message_title"></span>最新资讯</h1>
                    <!-- 左侧 -->
                    <div class="message">
                        <ul class='clearfix'>
                            <?php if(is_array($latestnews)): $i = 0; $__LIST__ = $latestnews;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                    <a href="<?php echo U('news/detail/'.$vo['id']);?>" title="<?php echo ($vo["title"]); ?>" target="_blank"><?php echo (msubstr($vo["title"],0,24)); ?></a>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                    <!-- 右侧 -->
                    <div class="message_right">
                        <!-- tab切换标题 -->
                        <div class="message_tab clearfix">
                            <ul id="message_nav">
                                <li class='mess_led'>
                                    <a href="javascript:void(0)" tab="tabC">企业软文</a>
                                </li>
                                <li><a href="<?php echo U('/news');?>" tab="tabD">查看往期</a></li>
                            </ul>
                        </div>
                        <!-- tab列表 -->
                        <ul class="message_list">
                            <li class="message_box">
                                <ul>
                                    <?php if(is_array($qyrw)): $i = 0; $__LIST__ = $qyrw;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                            <a href="<?php echo U('news/detail/'.$vo['id']);?>" title="<?php echo ($vo["title"]); ?>" target="_blank"><?php echo (msubstr($vo["title"],0,19)); ?></a>
                                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                            </li>
                        </ul>
                    </div><!-- message_right右侧结束 -->
                </div><!--new_message结束 -->
            </div><!-- cemetery最新资讯结束 -->
            <!-- 优势 -->
            <div class="advantage clearfix">
                <ul>
                    <li>
                        <span class="photo-value"></span>
                        <h1>超值优惠</h1>
                        <p>优惠信息100%真实</p>
                    </li>
                    <li>
                        <span class="photo-major"></span>
                        <h1>专业团队</h1>
                        <p>资深的企业，专业的咨询团队</p>
                    </li>
                    <li>
                        <span class="photo-message"></span>
                        <h1>信息全面</h1>
                        <p>涵盖全国上千家公墓信息</p>
                    </li>
                    <li>
                        <span class="photo-capacity"></span>
                        <h1>智能服务</h1>
                        <p>多种线上咨询、预约服务</p>
                    </li>
                    <li class="last">
                        <span class="photo-integrity"></span>
                        <h1>诚信保障</h1>
                        <p>交易透明，诚信商家，安全保障</p>
                    </li>
                </ul>
            </div><!-- advantage优势结束 -->
        </div><!-- contain -->
    </div><!-- main中间内容部分结束 -->
    <!-- 底部footer部分 -->
    
    <!-- 底部footer部分 -->
<div class="footer clearfix">
    <div class="contain">
        <!-- 底部导航+联系我们 -->
        <div class="footer_main clearfix">
            <!-- 底部导航 -->
            <div class="footer_nav clearfix">
                <ul>
                    <h1>购墓指南</h1>
                    <li><a target="_blank" href="<?php echo U('/help/guide/gmlc');?>" title="购墓流程">购墓流程</a></li>
                    <li><a target="_blank" href="<?php echo U('/help/guide/lyxz');?>" title="陵园选择">陵园选择</a></li>
                    <li><a target="_blank" href="<?php echo U('/help/guide/mdxz');?>" title="墓地选择">墓地选择</a></li>
                    <li><a target="_blank" href="<?php echo U('/help/guide/yysh');?>" tilte="预约商户">预约商户</a></li>
                </ul>
                <ul>
                    <h1>订单保障</h1>
                    <li><a target="_blank" href="<?php echo U('/help/security/wzys');?>" title="网站优惠">网站优势</a></li>
                    <li><a target="_blank" href="<?php echo U('/help/security/hyqy');?>" title="会员权限">会员权益</a></li>
                    <li><a target="_blank" href="<?php echo U('/help/security/yhxy');?>" title="用户协议">用户协议</a></li>
                    <li><a target="_blank" href="<?php echo U('/help/security/yszc');?>" title="隐私政策">隐私政策</a></li>
                </ul>
                <ul>
                    <h1>常见问题</h1>
                    <li><a target="_blank" href="<?php echo U('/help/issue/xmjq');?>" title="选墓技巧">选墓技巧</a></li>
                    <li><a target="_blank" href="<?php echo U('/help/issue/gmxz');?>" title="购墓须知">购墓须知</a></li>
                    <li><a target="_blank" href="<?php echo U('/help/issue/shfw');?>" title="售后服务">售后服务</a></li>
                    <li><a target="_blank" href="<?php echo U('/help/issue/lqfx');?>" title="领取返现">领取返现</a></li>
                </ul>
                <ul>
                    <h1>殡葬文化</h1>
                    <li><a target="_blank" href="<?php echo U('/help/common/bzjr');?>" title="殡葬吉日">殡葬吉日</a></li>
                    <li><a target="_blank" href="<?php echo U('/help/common/bzfw');?>" title="殡葬服务">殡葬服务</a></li>
                    <li><a target="_blank" href="<?php echo U('/help/common/jsxs');?>" title="祭祀习俗">祭祀习俗</a></li>
                    <li><a target="_blank" href="<?php echo U('/help/common/fsxd');?>" title="风水选定">风水选定</a></li>
                </ul>
                <ul>
                    <h1>91搜墓网</h1>
                    <li><a target="_blank" href="<?php echo U('/intro/aboutus');?>" title="关于91搜墓网">关于91搜墓网</a></li>
                    <li><a target="_blank" href="<?php echo U('/intro/contactus');?>" title="联系我们">联系我们</a></li>
                    <li><a target="_blank" href="<?php echo U('/intro/sitemap');?>" title="网站地图">网站地图</a></li>
                    <li><a target="_blank" href="<?php echo U('/intro/joinus');?>" title="加盟合作">加盟合作</a></li>
                </ul>
            </div><!-- footer_nav底部导航结束 -->
            <!-- 联系我们 -->
            <div class="contact clearfix">
                <h2>400-8010-344</h2>
                <div class="cont">
                    <div class="sina">
                        <span></span><a href="http://weibo.com/u/5186364473" target="_blank"  title="91搜墓网-sina新浪微博">立即关注</a>
                    </div>
                    <div class="tencent">
                        <span></span><a href="http://t.qq.com/soumu91" target="_blank"  title="91搜墓网-腾讯微博">立即关注</a>
                    </div>
                </div>
                <img class="wechat" src="<?php echo (IMG_URL); ?>wechat.png" alt="91搜墓网微信公众号"/>
            </div><!-- contact联系我们结束 -->
        </div><!-- footer_main底部导航+联系我们结束 -->
        <!-- 友情链接 -->
        <div class="blogroll clearfix">
            <h3>友情链接：</h3>
            <?php if(is_array($friendlinks)): $i = 0; $__LIST__ = $friendlinks;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo ($vo["url"]); ?>" target="_blank" title="<?php echo ($vo["name"]); ?>"><?php echo ($vo["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
        </div><!-- blogroll友情链接结束 -->
    </div><!-- contain -->
</div><!-- footer底部footer部分结束 -->
<!-- 版权 -->
<div class="copyright">
    <ul>
        <li><?php echo (C("BEIAN_HAO")); ?></li>
        <li>服务热线:400-8010-344</li>
        <li><?php echo (C("SITE_NAME")); ?> 版权所有</li>
    </ul>
    <p> CopyRight (C)2009-<?php echo date("Y");?> <?php echo (C("BEIAN_COPY")); ?></p>
</div><!-- copyright版权结束 -->
<!--回到顶部-->
<!-- 返回顶部工具条 -->
<div class="toolbar">
    <a href="javascript:;" class="toolbar-item toolbar-item-phone">
        <span class="toolbar-layer"></span>
    </a>
    <a href="javascript:;" class="toolbar-item toolbar-item-weixin">
        <span class="toolbar-layer"></span>
    </a>
    <a id="backTop" href="javascript:;" class="toolbar-item toolbar-item-top"></a>
</div><!-- toolbar返回顶部工具条结束 -->
<!-- 返回顶部JS -->



    <script type="text/javascript" src="<?php echo (JS_URL); ?>jquery-1.9.1.min.js"></script>
    <!-- 轮播jquery.touchSlider.js -->
    <script type="text/javascript" src="<?php echo (JS_URL); ?>jquery.touchSlider.js"></script>
    <!-- 公司动态无缝滚动jquery.kxbdMarquee.js -->
    <script type="text/javascript" src="<?php echo (JS_URL); ?>jquery.kxbdmarquee.js"></script>
    <!-- 公共JS -->
    <script type="text/javascript" src="<?php echo (JS_URL); ?>home/commonb.js"></script>
    <!--私有JS -->
    <script type="text/javascript" src="<?php echo (JS_URL); ?>home/index.js"></script>
    <script type="text/javascript">
        $('input[data-id="kwd"]').keyup(function() {
            var store_name = $(this).val();
            $.ajax({
                url:"<?php echo U('searchAutoHint');?>",
                type:'post',
                data:{
                    store_name:store_name,
                },
                success:function(d){
                    var data = eval("("+d+")");
                    var result = data['data'];
                    var aTag = '';
                    if(data['flag'] == 1){
                        $('.search_box').show();
                        $('.city_list').hide();
                        for (var i = 0; i < result.length; i++) {
                            aTag += '<a data-name="click_name" href="javascript:void(0)">'+result[i]+'</a>';
                        }
                    }else{
                        $('.search_box').hide();
                    }
                    $('.search_box').empty().append(aTag);
                    
                    $('a[data-name="click_name"]').css('display','block');
                    // 鼠标滑过样式
                    $('a[data-name="click_name"]').hover(function(){
                        $('input[data-id="kwd"]').val($(this).text());
                        $(this).css({
                            'background-color':'#FBB784',
                            'color':'white'
                        });
                    },function(){
                        $(this).css({
                            'background-color':'white',
                            'color':'black'
                        });
                    });
                    // 点击给搜索框赋值
                    $('a[data-name="click_name"]').click(function(){
                        $('input[data-id="kwd"]').val($(this).text());
                        $('.search_box').hide();
                    });
                }
            });
        });
    </script>
</body>
</html>