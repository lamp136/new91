<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>祭祀服务详情</title>
	<link href="<?php echo (CSS_URL); ?>screen.css" media="screen, projection" rel="stylesheet" type="text/css"/>
	<!-- 加入购物车 -->
	<link href="<?php echo (CSS_URL); ?>select.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo (JS_URL); ?>jquery-1.9.1.min.js"></script>
</head>
<body>
	<!-- 头部加导航 -->
	<!-- 顶部 -->
<div class="navbar_top">
    <div class="contain">
        <div class="greet">
            <?php if(empty($_SESSION['member_name'])): ?><span>您好! 欢迎来到91搜墓网&nbsp;<a href="<?php echo U('/'.strtolower(C('CHINA_ABBR')));?>" title="返回首页">返回首页</a></span>
            <a class="login" href="<?php echo U('/login');?>" >登录</a>
            <a href="<?php echo U('/register');?>">注册</a>
            <?php else: ?>
            <span><?php echo (session('member_name')); ?>您好! 欢迎来到91搜墓网&nbsp;<a href="<?php echo U('/'.strtolower(C('CHINA_ABBR')));?>" title="返回首页">返回首页</a></span>
            <a href="<?php echo U('/logout');?>" rel="nofollow">退出登录</a><?php endif; ?>
        </div>
        <div class="nav_top">
            <ul>
                <li class="scan">
                    <img src="<?php echo (IMG_URL); ?>saomwei.gif" alt="91搜墓网微信公众号二维码"/>扫描微信<i></i>
                    <span class="toolbar-layer"></span>
                </li>
                <li class="gwc">
                    <div class="J-shoping">
                        <a href="<?php echo U('/cart');?>" class="J-go">
                            <img src="<?php echo (IMG_URL); ?>top_gwc.png"/>购物车<span class="J-shoping-num"><?php echo ($number); ?></span>件
                        </a>
                    </div>
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
                <img src="<?php echo (IMG_URL); ?>logo_left.gif" alt="搜墓，陵园，墓地-91搜墓网">
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
                            <li><a href="javascript:void(0)" tab="tabCity1">省份</a></li>
                        </ul>
                        <span class="c_close search_close"></span>
                    </div>
                    <!-- 展开的城市 -->
                    <ul class="list_box">
                        <!-- 热门城市 -->
                        <li id="tabCity1" class="city_box">
                            <ul class="clearfix">
                                <?php if(is_array($region)): $i = 0; $__LIST__ = $region;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                        <a href="<?php echo U('/'.strtolower($vo['abbreviate']));?>" title="<?php echo (C("SITE_NAME")); ?>_<?php echo ($vo["region_name"]); ?>站"><?php echo ($vo["region_name"]); ?></a>
                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        </li>
                    </ul><!-- list_box展开的城市结束 -->
                </div><!-- city_list展开城市列表结束 -->
            </div><!-- city选择城市结束 -->
            <form id='seacth_top_form' action="/search" method="get" onsubmit="return search_top()">
                <input class="tex" type="text" name="wd" value= "<?php if(!empty($wd)): echo ($wd); endif; ?>" placeholder="请输入搜索的陵园名称" />
                <button class="btn"></button>
            </form>
        </div><!-- search选择城市+搜索结束 -->
       <!-- 热线 -->
        <div class="header_phone clearfix">
            <img src="<?php echo (IMG_URL); ?>header_phone_img.png"  alt="客服热线:400-8010-344"/>
        </div>
    </div><!-- contain -->
</div><!-- 头部header结束 -->
<!-- 导航 -->
<div class="nav">
    <div class="contain">
        <ul class="nav_list clearfix">
            <li><a href="<?php echo getHomeUrl(); ?>" title="91搜墓网_<?php echo ($regionName); ?>站">首页</a></li>
            <li <?php if(($controllerName) == C("CEMETERY")): ?>class="lineheight"<?php endif; ?>><a href="<?php echo getHomeUrl('cemetery'); ?>" title="<?php echo ($regionName); ?>陵园">陵园</a></li>
            <li <?php if(($controllerName) == C("FIANACING")): ?>class="lineheight"<?php endif; ?>><a href="<?php echo (C("LR_URL")); ?>" target="_blank" title="91乐融">91乐融</a></li>
            <li <?php if(($controllerName) == C("SERVICE")): ?>class="lineheight"<?php endif; ?>><a href="<?php echo U('/service');?>" title="祭扫服务">祭扫服务</a></li>
            <li <?php if(($controllerName) == C("FUNERAL")): ?>class="lineheight"<?php endif; ?>><a href="<?php echo getHomeUrl('funeral'); ?>" title="殡仪馆">殡仪馆</a></li>
            <li><a href="<?php echo U('/news');?>" title="资讯">资讯</a></li>
            <li <?php if(($controllerName) == C("SPECIALTOPICS")): ?>class="lineheight"<?php endif; ?>><a href="<?php echo U('/specialtopics');?>" title="会员专栏">会员专栏</a></li>
            <!--<li <?php if(($controllerName) == C("FESTIVALS")): ?>class="lineheight"<?php endif; ?>><a href="javascript:void(0)">传统节日</a></li>-->
            <li <?php if(($controllerName) == C("NEWS")): ?>class="last lineheight" <?php else: ?>class="last"<?php endif; ?>><a href="<?php echo U('/fengshui');?>" title="殡葬风水">殡葬风水</a></li>
        </ul>
    </div>
</div><!-- nav导航结束 -->
<!-- 中间内容部分 -->
<div class="main">
	<div class="contain">
		<!-- 面包屑导航 -->
		<div class="breadcrumb">
			<ul>
				<li><a href="index.html">首页</a></li>
				<li>></li>
				<li><a href="<?php echo U('/service');?>">服务列表</a></li>
				<li>></li>
				<li><?php echo ($details["service_goods_name"]); ?></li>
			</ul>
		</div><!-- breadcrumb面包屑导航结束 -->
		<!-- 陵园详情 -->
		<div class="details clearfix">
			<!-- 服务信息 -->
			<div class="service_info">
				<!-- 服务信息展示图片 -->
				<div id="imgList">
					<img src="<?php echo ($details["thumb_url"]); ?>" width="469" height="293" />
					<div id="thumb">
					    <ul>
					    	<?php if(is_array($details["IMAGE"])): $i = 0; $__LIST__ = $details["IMAGE"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo["type"] == 1): ?><li><a class="cur" href="javascript:void(0)"><img src="<?php echo ($vo["thumb_url"]); ?>" rel="<?php echo ($vo["thumb_url"]); ?>"  width="59" height="59"/></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
					    </ul>
					</div>
				</div><!-- imgList服务信息展示图片结束 -->
				<!-- 服务的具体信息 -->
				<div class="service_details_info">
					<h1><?php echo ($details["service_goods_name"]); ?></h1>
					<p><?php echo ($details["summary"]); ?></p>
					<!-- 价格 销量 评价 -->
					<div class="price clearfix">
						<ul>
							<li class="rmb">套餐价格：<span><?php echo ($details["sales_price"]); ?></span><strong>元</strong></li>
							<li class="num">销量：<span>666666</span>套</li>
							<li class="pj">评价：已有<span>888</span>人评价</li>
						</ul>
					</div>
					<p class="ms"><span class="title">领取地点：</span><?php echo ($details["store_name"]); ?></p>
					<p class="ms"><span class="title">领取方式：</span>根据您收到的信息提示，到陵园指定处领取即可 </p>
					<!-- 枝数 -->
					<div class="number clearfix">
						<span class="title">枝<span class="jg"></span>数：</span>
						<ul class="clearfix">
							<li class="currter"><a href="#">9枝</a></li>
							<li><a href="#">11枝</a></li>
							<li><a href="#">13枝</a></li>
						</ul>
					</div>
					<!-- 颜色 -->
					<div class="hue clearfix">
						<span class="title">颜<span class="jg"></span>色：</span>
						<ul class="clearfix">
							<li class="currter"><a href="#"><img src="<?php echo (IMG_URL); ?>service_details_hueimg1.jpg" /></a></li>
							<li><a href="#"><img src="<?php echo (IMG_URL); ?>service_details_hueimg1.jpg" /></a></li>
							<li><a href="#"><img src="<?php echo (IMG_URL); ?>service_details_hueimg1.jpg" /></a></li>
							<li><a href="#"><img src="<?php echo (IMG_URL); ?>service_details_hueimg1.jpg" /></a></li>
							<li><a href="#"><img src="<?php echo (IMG_URL); ?>service_details_hueimg1.jpg" /></a></li>
							<li><a href="#"><img src="<?php echo (IMG_URL); ?>service_details_hueimg1.jpg" /></a></li>
							<li><a href="#"><img src="<?php echo (IMG_URL); ?>service_details_hueimg1.jpg" /></a></li>
						</ul>
					</div>
					<!-- 购买数量 -->
					<div class="quantity clearfix">
						<span class="title">购买数量：</span>
						<div class="quantity_numb" id="quantity_numb">
							<input type="button" value="-" />
							<input type="text" value="1" />
							<input type="button" value="+" />
						</div>
					</div>
					<!-- 加入购物车 -->
					<div class="purchase_btn">
						<a id="buy-s-1" class="baseBg Q-buy-btn addcar" href="javascript:void(0)" goodsSn="<?php echo ($details["store_goods_sn"]); ?>" store_id="<?php echo ($details["store_id"]); ?>">加入购物车</a>
						<a class="buy" href="#">立即购买</a>
					</div>
				</div><!-- service_details_info服务的具体信息结束 -->
				<div class="clear"></div>
			</div><!-- service_info服务信息结束 -->
			<!-- 祭祀服务详情左侧 -->
			<div class="det_left service_details_left">
				<!-- 定位导航头部 -->
				<div class="service_details_title" id="service_details_title">
					<ul>
						<li class="led"><a href="#" tab="tabser1">商品详情</a><span></span></li>
						<li><a href="#" tab="tabser2">用户评价</a><span></span></li>
						<div class="clear"></div>
					</ul>
				</div>
				<!-- 祭祀服务详情 -->
				<ul>
					<!-- 商品详情 -->
					<li class="service_details_box" id="tabser1">
						<div class="service_details_goodsdetails">
							<?php if(is_array($details["IMAGE"])): $i = 0; $__LIST__ = $details["IMAGE"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo["type"] == 2): ?><img src="<?php echo ($vo["thumb_url"]); ?>" alt="商品详情"/><?php endif; endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</li>
					<!-- 用户评价 -->
					<li class="service_details_box" id="tabser2">
						<!-- 评价 -->
						<div class="service_details_evaluate">
							<!-- 综合评价+星星 -->
							<div class="det_star clearfix">
								<div class="coincide">
									<p>综合评价</p>
									<h2>5</h2>
								</div>
								<ul>
									<li>质量：<img src="<?php echo (IMG_URL); ?>star_img5.jpg"/>5分</li>
									<li class="last">价格：<img src="<?php echo (IMG_URL); ?>star_img5.jpg"/>5分</li>
									<li>信用：<img src="<?php echo (IMG_URL); ?>star_img5.jpg"/>5分</li>
									<li class="last">服务：<img src="<?php echo (IMG_URL); ?>star_img5.jpg"/>5分</li>
								</ul>
							</div>
							<!-- 评价数量 -->
							<div class="service_details_evaluate_title clearfix">
								<ul>
									<li class="led"><img src="<?php echo (IMG_URL); ?>evaluate_title1.png"/>全部 888</li>
									<li><img src="<?php echo (IMG_URL); ?>evaluate_title.png"/>追加 66</li>
									<li><img src="<?php echo (IMG_URL); ?>evaluate_title.png"/>晒图 88</li>
								</ul>
							</div>
							<!-- 评价内容 -->
							<div class="service_details_evaluate_main">
								<!-- 用户 -->
								<div class="evaluate_main_yh">
									131****0029
								</div>
								<!-- 评价 -->
								<div class="evaluate_main_pj">
									<p>非常满意的一次服务，下次有需要还会再来的，好评哦，希望你们越来越好!非常满意的一次服务，下次有需要还会再来的，好评哦，希望你们越来越好!非常满意的一次服务，下次有需要还会再来的，好评哦，希望你们越来越好!</p>
									<ul>
										<li><img src="<?php echo (IMG_URL); ?>service_details_hueimg1.jpg"></li>
										<li><img src="<?php echo (IMG_URL); ?>service_details_hueimg1.jpg"></li>
										<li><img src="<?php echo (IMG_URL); ?>service_details_hueimg1.jpg"></li>
										<li><img src="<?php echo (IMG_URL); ?>service_details_hueimg1.jpg"></li>
									</ul>
								</div>
								<!-- 星星 -->
								<div class="evaluate_main_xing">
									<img src="<?php echo (IMG_URL); ?>star_img5.jpg"/>
									<p>2016 - 12- 28  16:26</p>
								</div>
								<div class="clear"></div>
								<!-- 追加 -->
								<div class="evaluate_main_zj">
									<h6>追加：</h6>
									<p>非常满意的一次服务，下次有需要还会再来的，好评哦，希望你们越来越好!非常满意的一次服务。</p>
								</div>
							</div><!-- service_details_evaluate_main 评价内容 End -->
							
						</div><!-- service_details_evaluate 评价 End -->
						<!-- 分页 -->
						<div class="pagination"> 
							<div>
								<span class="rows">共 476 条记录</span> 
								<ul> 
									<li class="prev"><a href="#" class="prev">上一页</a></li> 
									<li><a href="#" class="num">1</a></li>
									<li class="active"><span class="current">2</span></li>
									<li></li>
									<li><a href="#" class="num">3</a></li>
									<li><a href="#" class="num">4</a></li>
									<li><a href="#" class="num">5</a></li>
									<li><a href="#" class="num">6</a></li>
									<li><a href="#" class="num">7</a></li>
									<li><a href="#" class="num">8</a></li>
									<li><a href="#" class="num">9</a></li>
									<li><a href="#" class="num">10</a></li>
									<li><a href="#" class="num">11</a></li> 
									<li><a href="#" class="next">下一页</a></li> 
									<li><a href="#" class="end">48</a></li>
								</ul>
							</div> 
						</div><!-- pagination分页结束 -->
					</li>
				</ul>
			</div><!-- det_left陵园详情左侧结束 -->
			<!-- 服务右侧 -->
			<div class="cem_right service_list_right">
				<!-- 相关推荐 -->
				<div class="service_details_xgtj">
					<h2>相关推荐</h2>
					<ul>
						<?php if(is_array($recommend)): $i = 0; $__LIST__ = $recommend;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="clearfix">
								<a href="<?php echo U('service/detail/'.$vo['store_goods_sn']);?>"><img src="<?php echo ($vo["thumb_url"]); ?>"/></a>
								<div class="xgtj_main">
									<h3><a href="<?php echo U('service/detail/'.$vo['store_goods_sn']);?>"><?php echo ($vo["service_goods_name"]); ?></a></h3>
									<p><?php echo (msubstr($vo["summary"],0, 20)); ?></p>
									<p class="price"><span><?php echo ($vo["sales_price"]); ?></span>元</p>
								</div>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
				<!-- 习俗 -->
				<div class="xisu">
					<img src="<?php echo (IMG_URL); ?>service_list_xisu.jpg"/>
				</div><!-- 习俗 -->
				<!-- 广告banner -->
				<div class="cem_ad">
					<img src="<?php echo (IMG_URL); ?>service_list_ad1.jpg"/>
				</div><!-- cem_ad广告banner结束 -->
				<!-- 风水文化 -->
				<div class="fs">
					<h1>风水文化</h1>
					<ul class="geomantic">
						<?php if(is_array($fswh)): $i = 0; $__LIST__ = $fswh;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
	                            <a href="<?php echo U('news/detail/'.$vo['id']);?>" title="<?php echo ($vo["title"]); ?>"><?php echo (msubstr($vo["title"],0,16)); ?></a>
	                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
				<!-- 广告banner -->
				<div class="cem_ad">
					<img src="<?php echo (IMG_URL); ?>service_list_ad2.jpg"/>
				</div><!-- cem_ad广告banner结束 -->
			</div><!-- cem_right服务右侧结束 -->
		</div><!-- details陵园详情结束 -->
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
    </div><!-- contain -->
</div><!-- footer底部footer部分结束 -->
<!-- 版权 -->
<div class="copyright">
    <ul>
        <li><?php echo (C("BEIAN_HAO")); ?></li>
        <li>服务热线:400-8010-344</li>
        <li><?php echo (C("SITE_NAME")); ?> 版权所有</li>
    </ul>
    <p>CopyRight (C)2009-<?php echo date("Y");?> <?php echo (C("BEIAN_COPY")); ?></p>
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



<!-- 搜索提示 -->
<script type="text/javascript" src="<?php echo (JS_URL); ?>hit.js"></script>
<!-- 返回顶部JS -->
<script src="<?php echo (JS_URL); ?>backtop.js"></script>
<!-- 加入购物车 -->
<script type="text/javascript" src="<?php echo (JS_URL); ?>jquery.min.js"></script>
<script type="text/javascript" src="<?php echo (JS_URL); ?>jQuery-shopping.js"></script>

<script type="text/javascript">
	
	$(document).ready(function(){

		//选择城市
		$(document).ready(function(){
			//头部地址
			$(".c_down").click(function(){
				$(".search_city").css("display","block");
			})
			//选择城市关闭
			$(".search_close,.city_box ul li").click(function(){
				$(".search_city").hide();
			})
		});

		//tab切换
		jQuery.jqtab = function(tabtit,tabcon) {
		        $(tabcon).hide();
		        $(tabtit+" li:first").addClass("thistab").show();
		        $(tabcon+":first").show();
		    
		        $(tabtit+" li").click(function() {
		            $(tabtit+" li").removeClass("thistab");
		            $(this).addClass("thistab");
		            $(tabcon).hide();
		            var activeTab = $(this).find("a").attr("tab");
		            $("#"+activeTab).fadeIn();
		            return false;
		        });
		        
		    };
		    /*调用方法如下：*/
		    $.jqtab("#city_nav",".city_box");
		    $.jqtab("#service_details_title",".service_details_box");

		// 服务展示图片
		$("#thumb li a").click(function(){
			var imgUrl = $(this).find("img").attr("rel");
			$("#imgList img:eq(0)").attr("src",imgUrl);
			$("#thumb li a").removeClass();
			$(this).addClass("cur");		
		});

		// 加入购物车
		$(function(){
	   		$('.Q-buy-btn').shoping(); //调用shoping函数
		});
	});

	

	// 数量加减
	var oNum = document.getElementById("quantity_numb");
	var oSubtract = oNum.getElementsByTagName("input")[0], // -号
		oNumber = oNum.getElementsByTagName("input")[1], // 数量
		oAdd = oNum.getElementsByTagName("input")[2],
		n1 = Number(oNumber.value); // +号
	
	// 点击 -号
	oSubtract.onclick = function(){
		n1--;
		if(oNumber.value <= 1){
			n1 = 1;
		}
		oNumber.value = n1;
	}
	// 点击 +号
	oAdd.onclick = function(){
		n1 = Number(oNumber.value);
		n1++;
		if(n1>"<?php echo (C("MAX_NUMBER")); ?>"){
			alert('商品数量不能大于'+"<?php echo (C("MAX_NUMBER")); ?>");
			oNumber.value = "<?php echo (C("MAX_NUMBER")); ?>";
		}else{
			oNumber.value = n1;
		};		
	}

	oNumber.onblur = function(){
		var number = oNumber.value;
		if(number > "<?php echo (C("MAX_NUMBER")); ?>"){
			alert('商品数量不能大于'+"<?php echo (C("MAX_NUMBER")); ?>");
			oNumber.value = n1;
		}
		if(number <= 0){
			alert('商品数量不能小于0');
			oNumber.value = n1;
		}
	}

	$('.Q-buy-btn').click(function(){
		var store_goods_sn = $(this).attr('goodsSn');
		var store_id = $(this).attr('store_id');
		var number = oNumber.value;
		$.ajax({
			url:"<?php echo U('addCar');?>",
        	type:'post',
        	data:{number:number,store_goods_sn:store_goods_sn,store_id:store_id},
        	dataType:'json',
            success:function(d){
            	if(d==0){
            		window.location.href="<?php echo U('/login');?>";
            	}else{
            		
            	}
	        }
		});	
	});

	//导航
    var mt = 0;
    window.onload = function () {
        var mydiv = document.getElementById("service_details_title");
        var mt = mydiv.offsetTop; //当前对象到距离上方或上层控件的位置
        var tt = document.documentElement.scrollTop || document.body.scrollTop;
        if (tt > mt) {
            mydiv.style.position = "fixed";
            mydiv.style.margin = "0";
            mydiv.style.top = "0";
        }
        window.onscroll = function () {
            var t = document.documentElement.scrollTop || document.body.scrollTop;
            if (t > mt) {
                mydiv.style.position = "fixed";
                mydiv.style.margin = "0";
                mydiv.style.top = "0";
            }
            else {
                mydiv.style.position = "static";
            }
        }
    }
</script>
</body>
</html>