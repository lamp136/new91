<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>祭祀服务列表</title>
	<link href="<?php echo (CSS_URL); ?>screen.css" media="screen, projection" rel="stylesheet" type="text/css"/>
	<link href="<?php echo (CSS_URL); ?>select.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo (JS_URL); ?>jquery-1.9.1.min.js"></script>
</head>
<body>
<!-- 顶部 -->
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
<!-- 顶部结束navbar_top -->
<!-- 头部header -->
<!-- 中间内容部分 -->
<div class="main">
	<div class="contain clearfix">
		<!-- 服务左侧 -->
		<div class="cem_left">
			<!-- 筛选条件 -->
			<div class="cem_sifting">
				<!-- 筛选条件结果显示 -->
				<div class="criteria">
					<ul>
						<li class="sif">所有分类</li>
						<li>></li>
						<?php if(!empty($_GET['storeId'])): if(is_array($storeName)): $i = 0; $__LIST__ = $storeName;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($_GET['storeId']) == $key): ?><li class="if">
                            			<a rel="nofollow" href="<?php echo getHomeUrl('service'); ?>?money=<?php echo ($money); ?>"><?php echo ($vo); ?><span></span></a>
                            		</li><?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>
						<?php if(!empty($_GET['money'])): if(is_array(C("SERVICE_MONEY"))): $i = 0; $__LIST__ = C("SERVICE_MONEY");if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($_GET['money']) == $key): ?><li class="if">
                            			<a rel="nofollow" href="<?php echo getHomeUrl('service'); ?>?storeId=<?php echo ($storeId); ?>"><?php echo ($vo); ?><span></span></a>
                            		</li><?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>	
						<li class="number">共<span><?php echo ($total); ?></span>结果</li>
					</ul>
				</div>
				<!-- 陵园名称： -->
				<div class="area_main clearfix">
					<div class="area_left" >
						<span class="tiel">陵园名称：</span>
					</div>
					<ul class="filter clearfix">
						<?php if(is_array($storeName)): $i = 0; $__LIST__ = $storeName;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li <?php if(($_GET['storeId']) == $key): ?>class="fil_led"<?php endif; ?>>
								<a href="<?php echo getHomeUrl('service'); ?>?storeId=<?php echo ($key); ?>&money=<?php echo ($money); ?>"><?php echo ($vo); ?></a>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>					
				</div><!-- area_main服务地区结束 -->
				<!-- 距离市区 -->
				<ul class="filter clearfix last">
					<li class="tiel">价格区间：</li>
					<?php if(is_array(C("SERVICE_MONEY"))): $i = 0; $__LIST__ = C("SERVICE_MONEY");if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li <?php if(($_GET['money']) == $key): ?>class="fil_led"<?php endif; ?>>
							<a href="<?php echo getHomeUrl('service'); ?>?storeId=<?php echo ($storeId); ?>&money=<?php echo ($key); ?>"><?php echo ($vo); ?></a>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div><!-- cem_sifting筛选条件结束 -->
			<!-- 服务列表 -->
			<div class="cem_service_list">
				<?php if($total == 0): ?><!-- 提示搜索没有数据 -->
					<div class="search_nodata">
						您搜索的<span>服务</span>没有数据
					</div><?php endif; ?>
				<!-- 1 -->
				<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="service_list_main clearfix">
					<!-- 服务图片 -->
					<a href="<?php echo U('service/detail/'.$vo['store_goods_sn']);?>" class="cem_pho"><img src="<?php echo ($vo["thumb_url"]); ?>"/><span class="newproduct"></span></a>
					<!-- 描述 -->
					<div class="depict clearfix">
						<h1><a href="<?php echo U('service/detail/'.$vo['store_goods_sn']);?>"><?php echo ($vo["service_goods_name"]); ?></a></h1>
						<ul class="feature">
							<li><span>属</span>隶属：<strong><?php echo ($vo["store_name"]); ?></strong></li>
							<li><span class="yu">寓</span>寓意：<?php echo ($vo["moral"]); ?></li>
							<?php if(!empty($vo['Single'])): ?><li><span>含</span>包含：
									<?php if(is_array($vo['Single'])): $i = 0; $__LIST__ = $vo['Single'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$res): $mod = ($i % 2 );++$i; echo ($res["service_goods_name"]); echo ($res["number"]); echo ($unit[$res['skuid']]); ?>&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
								.</li><?php endif; ?>
							<li><span>销</span>销量：已销售1200套</li>
						</ul>
						<div class="pric">
							<p class="p_yuan"><span><?php echo ($vo["sales_price"]); ?></span>元</p>
							<p class="p_pj">已有<span>500</span>人评价</p>
						</div>
						<div class="service_btn">
							<a id="buy-s-1" class="baseBg Q-buy-btn jrgwc" href="javascript:void(0)" goodsSn="<?php echo ($vo["store_goods_sn"]); ?>" store_id="<?php echo ($vo["store_id"]); ?>">加入购物车</a>
							<a class="ljgm" href="#">立即购买</a>
						</div>
					</div>
				</div><!-- depict End --><?php endforeach; endif; else: echo "" ;endif; ?>
			</div><!-- cem_list服务列表结束 -->
			<!-- 分页 -->
			<div class="pagination"> 
				<div>
					<?php echo ($page); ?>
				</div> 
			</div><!-- pagination分页结束 -->
		</div><!-- cem_left服务左侧结束 -->
		<!-- 服务右侧 -->
		<div class="cem_right service_list_right">
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
			<!-- 最新资讯 -->
			<div class="nws_latest">
				<h1><i class="latest_i"></i>最新资讯</h1>
				<ul>
					<?php if(is_array($latestnews)): $i = 0; $__LIST__ = $latestnews;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                            <a href="<?php echo U('news/detail/'.$vo['id']);?>" title="<?php echo ($vo["title"]); ?>"><?php echo (msubstr($vo["title"],0,16)); ?></a>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div><!-- nws_latest最新资讯结束 -->
			<!-- 热门文章 -->
			<div class="nws_article">
				<h1><i class="article_i"></i>热门文章</h1>
				<ul>
					<?php if(is_array($rdjj)): $i = 0; $__LIST__ = $rdjj;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                            <a href="<?php echo U('news/detail/'.$vo['id']);?>" title="<?php echo ($vo["title"]); ?>"><?php echo (msubstr($vo["title"],0,16)); ?></a>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div><!-- nws_article热门文章结束 -->
		</div><!-- cem_right服务右侧结束 -->
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
<!-- 加入购物车 -->
<script type="text/javascript" src="<?php echo (JS_URL); ?>jquery.min.js"></script>
<script type="text/javascript" src="<?php echo (JS_URL); ?>jQuery-shopping.js"></script>
<!-- 返回顶部JS -->
<script src="<?php echo (JS_URL); ?>backtop.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		//陵园地区点击展示更多地区
		$(".more_btn").click(function() {
			 $(".more_main").toggle();
		});

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

		// 加入购物车
		$(function(){
	   		$('.Q-buy-btn').shoping(); //调用shoping函数
		});
	});

	$('.Q-buy-btn').click(function(){
		var store_goods_sn = $(this).attr('goodsSn');
		var store_id = $(this).attr('store_id');
		var number = 1;
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
</script>
</body>
</html>