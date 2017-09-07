<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link rel="icon" href="/Public/soumu.ico" type="image/x-icon" />
    <title>会员登录_<?php echo (C("SITE_NAME")); ?>网</title>
    <link href="<?php echo (CSS_URL); ?>screen.css" media="screen, projection" rel="stylesheet" type="text/css"/>
    
    <script type="text/javascript" src="<?php echo (JS_URL); ?>wap.js"></script>
    <script type="text/javascript">
        var url = window.location.pathname;
        var newurl = "<?php echo (C("WAP_STIE_DOMAIN")); ?>"+url;
        browserRedirect(newurl);
    </script>
</head>
<body>
    <!-- 头部header -->
    <div class="header">
        <div class="contain">
            <!-- LOGO -->
            <div class="logo clearfix">
                <a href="/" title="91搜墓网"><img src="<?php echo (IMG_URL); ?>logo.png" alt="91搜墓网"/></a>
            </div>
            <h1>欢迎登录</h1>
        </div><!-- contain -->
    </div><!-- 头部header结束 -->
    <!-- 中间内容部分 -->
    <div class="login_main">
        <div class="contain clearfix">
            <!-- 登录banner -->
            <div class="logbanner">
                <img src="<?php echo (IMG_URL); ?>login_banner.jpg"/>
            </div>
            <!-- 登录内容 -->
            <div class="login">
                <h1><a href="#">账号登录</a></h1>
                <form name="loginForm" id="loginForm" method="post" action="">
                    <ul>
                        <li>
                            <input class="login_tex" type="text" placeholder="请输入手机号" name="mobile" value="<?php echo ($mobile); ?>" />
                        </li>
                        <li>
                            <input class="login_tex" type="password" placeholder="请输入密码" name="password" value="<?php echo ($password); ?>" />
                        </li>
                        <li class="clearfix">
                            <p class="log_check"><input class="check" type="checkbox" name="loginState" value="1" <?php if($loginState == 1){ echo 'checked' ;} ?>/>记住密码</p>
                           <!--<p class="log_forget"><a href="#">忘记密码？</a></p>-->
                        </li>
                        <li>
                            <input  type="hidden"  name="url" value="<?php echo ($_GET['url']); ?>" />
                            <a class="login_btn" href="javascript:void(0)">立即登录</a>
                        </li>
                        <li class="log_register"><a href="/register.html">免费注册</a></li>
                    </ul>
                </form>
                <div class="log_validate" style="display: none">
                    <i></i>请输入手机号或密码
                </div>
            </div><!-- login登录内容结束 -->
        </div><!-- contain -->
    </div><!-- main中间内容部分结束 -->
</div><!-- contain -->
<div class="log_footer">
    <div class="contain">
        <a target="_blank" href="<?php echo U('/intro/aboutus');?>" title="关于我们">关于我们</a>|
        <a target="_blank" href="<?php echo U('/intro/contactus');?>" title="联系我们">联系我们</a>|
        <a target="_blank" href="<?php echo U('/intro/contactus');?>" title="客服中心">客服中心</a>|
        <a target="_blank" href="<?php echo U('/intro/joinus');?>" title="加入我们">加入我们</a>
        <p><?php echo (BEIAN_HAO); ?> CopyRight (C)2009-<?php echo date("Y");?> <?php echo (BEIAN_COPY); ?></p>
    </div>
</div><!-- log_footer end -->
<script type="text/javascript" src="<?php echo (JS_URL); ?>jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo (JS_URL); ?>home/login.js"></script>
</body>
</html>