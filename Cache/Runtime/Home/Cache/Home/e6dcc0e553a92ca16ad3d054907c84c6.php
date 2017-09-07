<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>购物车</title>
    <link href="<?php echo (CSS_URL); ?>screen.css" media="screen, projection" rel="stylesheet" type="text/css"/>
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

<!-- 中间内容部分 -->
<div class="main">
    <div class="contain shopping">
        <h2>全部商品 <?php echo ($total_number); ?></h2>
        <!-- 全选 -->
        <div class="shopping_title">
            <ul class="clearfix">
                <li class="qx">
                    <input class="inpche" type="checkbox"/>
                    <label>全选</label>
                </li>
                <li class="spxx">商品信息</li>
                <li class="dj">单价（元）</li>
                <li class="num">数量</li>
                <li class="price">价格（元）</li>
                <li class="cz">操作</li>
            </ul>
        </div><!-- shopping_title 全选 End -->
        <!-- 商品内容 -->
        <form action="<?php echo U('orderConfirm');?>" method="post">
        <div class="shopping_main" id="shopcart">
            <!-- 商家名称 -->
            <?php if(is_array($shopCar)): $i = 0; $__LIST__ = $shopCar;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="shopping_main_title">
                    <input class="main_inpche" type="checkbox"/>
                    <label><?php echo ($vo["store_name"]); ?></label>
                    <span>领取方式：到陵园指定处领取</span>
                </div>
                <!-- 商品购买内容 -->
                <?php if(is_array($vo["sn"])): $i = 0; $__LIST__ = $vo["sn"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$res): $mod = ($i % 2 );++$i;?><div class="shopping_main_nr shopping_main_nrled">
                        <!-- 商品1 -->
                        <ul class="clearfix">
                            <?php if(C("DELETE_STATUS")== $res[goods_status]): ?><li class="licheck">
                                    <img src="<?php echo (IMG_URL); ?>shopping_inpche_xj.png">
                                    <p>已下架</p>
                                </li>
                            <?php else: ?>
                                <!-- 选择 -->
                                <li class="licheck"><input class="inpche" name="goods[]" value="<?php echo ($res["store_goods_sn"]); ?>" type="checkbox"/></li><?php endif; ?>
                            <!-- 图片 -->
                            <li class="liimg">
                                <a href="#"><img src="<?php echo ($res["thumb_url"]); ?>"/></a>
                            </li>
                            <!-- 描述 -->
                            <li class="litext">
                                <h3><a href="#"><?php echo ($res["goods_name"]); ?></a></h3>
                                <?php if(!empty($res[Single])): ?><span style="font-size:5px">该套餐包含<span>
                                    <?php if(is_array($res[Single])): $i = 0; $__LIST__ = $res[Single];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$si): $mod = ($i % 2 );++$i;?><span style="font-size:5px"><?php echo ($si["service_goods_name"]); echo ($si["number"]); echo ($unit[$si['skuid']]); ?>,</span><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                                <p>颜色：黄色<span>枝数：11枝</span></p>
                            </li>
                            <!-- 单价 -->
                            <li class="lipric"><span>¥ </span><span class="price" style="font-size:20px"><?php echo ($res["price"]); ?></span></li>
                            <!-- 数量加减 -->
                            <li class="lishopnumb" goodsSn="<?php echo ($res["store_goods_sn"]); ?>">
                                <div class="shop_numb" id="shop_numb">
                                    <input type="button" value="-" />
                                    <input type="text" value="<?php echo ($res["num"]); ?>"/>
                                    <input type="button" value="+" />
                                </div>
                            </li>
                            <!-- 价格 -->
                            <li class="liprice"  name='a'>¥ <span class="totalPrice"><?php echo ($res["total_price"]); ?></span></li>
                            <!-- 删除 收藏 -->
                            <li class="libtn">
                                <a href="#">删除</a>
                                <a href="#">收藏</a>
                            </li>
                        </ul>
                    </div><!-- shopping_main_nr 商品购买内容 End --><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
            
            <!-- 去结算 -->
            <div class="shopping_settlement clearfix">
                <ul>
                    <li class="licheck">
                        <input class="inpche" type="checkbox"/>
                        <label>全选</label>
                    </li>
                    <li><a href="#">删除选中商品</a></li>
                    <li><a href="#">清除下架商品</a></li>
                    <li><a href="#">移动到我的收藏</a></li>
                    <li class="liyxsp">已选商品<span> 4 </span>件</li>
                    <li class="lijg">价格合计：<span>¥</span><span class ='allGoodsPrice'><?php echo ($allGoodsPrice); ?></span></li>
                    <button><li class="settlement_btn"><a>去结算</a></li></button>
                </ul>
            </div><!-- shopping_settlement 去结算 End -->
        </div><!-- shopping_main 商品内容 End -->
        </form>
        <!-- 猜您想看的 -->
        <div class="shopping_look">
            <h5>猜您想看的</h5>
            <ul class="clearfix">
                <?php if(is_array($recommend)): $i = 0; $__LIST__ = $recommend;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($key == 3): ?><li class="last">
                            <a href="<?php echo U('service/detail/'.$vo['store_goods_sn']);?>"><img src="<?php echo ($vo["thumb_url"]); ?>"/></a>
                            <h3><a href="<?php echo U('service/detail/'.$vo['store_goods_sn']);?>"><?php echo ($vo["service_goods_name"]); ?></a></h3>
                            <p><?php echo ($vo["moral"]); ?></p>
                            <p class="ls">隶属：<?php echo ($vo["store_name"]); ?></p>
                            <p class="price"><span><?php echo ($vo["sales_price"]); ?></span>元</p>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="<?php echo U('service/detail/'.$vo['store_goods_sn']);?>"><img src="<?php echo ($vo["thumb_url"]); ?>"/></a>
                            <h3><a href="<?php echo U('service/detail/'.$vo['store_goods_sn']);?>"><?php echo ($vo["service_goods_name"]); ?></a></h3>
                            <p><?php echo ($vo["moral"]); ?></p>
                            <p class="ls">隶属：<?php echo ($vo["store_name"]); ?></p>
                            <p class="price"><span><?php echo ($vo["sales_price"]); ?></span>元</p>
                        </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div><!-- shopping_look 猜您想看的 End -->
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
    });

function getByClass(clsName,parent){
    var oParent = parent?document.getElementById(parent):document,
        eles = [],
        aElements = oParent.getElementsByTagName("*");
    for(var i=0; i<aElements.length; i++){
        if(aElements[i].className == clsName){
            eles.push(aElements[i]);
        }
    }
    return eles;
}

window.onload = function(){
    var aNum = getByClass("shop_numb","shopcart");
    
    // 数量加减
    for(var i=0; i<aNum.length; i++){
        fn1(aNum[i]);
    }
}
// 数量加减
function fn1(oNum){
    // 数量加减
    var oSubtract = oNum.getElementsByTagName("input")[0], // -号
        oNumber = oNum.getElementsByTagName("input")[1], // 数量
        oAdd = oNum.getElementsByTagName("input")[2],
        n1 = Number(oNumber.value); // +号
    
    // 点击 -号
    oSubtract.onclick = function(){
        n1--;
        if(oNumber.value <= 1){
            n1 = 1;
        }else{
            oNumber.value = n1;
             //改变数量修改数据库
            var objTotalPrice = $(this).parents('.lishopnumb').siblings('.liprice').find('.totalPrice');
            var goodsSn =  $(this).parents('.lishopnumb').attr('goodsSn');
            updateShoppingCar(n1,goodsSn,objTotalPrice);
        }    
    }
    // 点击 +号
    oAdd.onclick = function(){
        n1 = Number(oNumber.value);
        n1++;
       
        var maxNumber = "<?php echo (C("MAX_NUMBER")); ?>"
        if(n1>maxNumber){
            alert('商品数量不能大于'+maxNumber);
            oNumber.value = maxNumber;
        }else{
            oNumber.value = n1;
            //改变数量修改数据库
            var objTotalPrice = $(this).parents('.lishopnumb').siblings('.liprice').find('.totalPrice');
            var goodsSn =  $(this).parents('.lishopnumb').attr('goodsSn');
            updateShoppingCar(n1,goodsSn,objTotalPrice);
        };
    }

    oNumber.onblur = function(){
        var number = oNumber.value;
        if(number > "<?php echo (C("MAX_NUMBER")); ?>"){
            alert('商品数量不能大于'+"<?php echo (C("MAX_NUMBER")); ?>");
            oNumber.value = n1;

        }else if(number <= 0){
            alert('商品数量不能小于0');
            oNumber.value = n1;
        }else{
            //改变数量修改数据库
            var objTotalPrice = $(this).parents('.lishopnumb').siblings('.liprice').find('.totalPrice');
            var goodsSn =  $(this).parents('.lishopnumb').attr('goodsSn');
            updateShoppingCar(number,goodsSn,objTotalPrice);
        }
    }
}

//改变数量修改购物车表数据
function updateShoppingCar(num,goodsSn,objTotalPrice){
    $.ajax({
        url:"<?php echo U('saveCar');?>",
        data:{num:num,goodsSn:goodsSn},
        type:'post',
        dataType:'json',
        success:function(d){
            if(d.msg==1){
                $(objTotalPrice).html(d.total_price);
                $('.allGoodsPrice').html(d.allGoodsPrice);
            }
        }
    })
}
</script>
</body>
</html>