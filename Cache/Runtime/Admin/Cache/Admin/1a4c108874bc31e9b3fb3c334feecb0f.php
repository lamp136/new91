<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!--
Template Name: Admin Lab Dashboard build with Bootstrap v2.3.1
Template Version: 1.2
Author: Mosaddek Hossain
Website: http://thevectorlab.net/
-->

<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link rel="icon" href="/Public/soumu.ico" type="image/x-icon" />
    <title>91搜墓后台登录</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="<?php echo (ASSETS_URL); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo (ASSETS_URL); ?>font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo (CSS_URL); ?>common.css">
    <link href="<?php echo (CSS_URL); ?>style.css" rel="stylesheet" />
    <link href="<?php echo (CSS_URL); ?>style_responsive.css" rel="stylesheet" />
    <link href="<?php echo (CSS_URL); ?>style_default.css" rel="stylesheet" id="style_color" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body id="login-body">
<!-- BEGIN LOGIN -->
<div id="login">
    <!-- BEGIN LOGIN FORM -->
    <form id="loginform" class="form-vertical no-padding no-margin" action="" method="post">
        <div class="lock">
            <i class="icon-lock"></i>
        </div>
        <div class="control-wrap">
            <h4>91搜墓网后台登录</h4>
            <div style="margin-top:-30px;height:30px;" id="msg">

            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        <input class="clear"  id="input-username" type="text" placeholder="Username"  name="email"/>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-key"></i>
                        </span><input class="clear" id="input-password" type="password" placeholder="Password" name="password"/>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="input-prepend" id="captcha-container">
                        <span class="add-on"><i class="icon-barcode"></i></span>
                        <input class="clear" id="input-codename" type="text" placeholder="Code" name="code"/>
                        <img class="codeimg" src="<?php echo U('Admin/Login/getVerifyCode',array());?>" title="点击刷新"/>
                    </div>
                </div>
            </div>
        </div>
        <a id="login-btn" class="btn btn-block login-btn" style="display:block;" href="javascript:void(0)">Login</a>
    </form>
    <!-- END LOGIN FORM -->
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form id="forgotform" class="form-vertical no-padding no-margin hide" action="index.html">
        <p class="center">Enter your e-mail address below to reset your password.</p>
        <div class="control-group">
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on">
                        <i class="icon-envelope"></i>
                    </span>
                    <input id="input-email" type="text" placeholder="Email"  />
                </div>
            </div>
            <div class="space20"></div>
        </div>
        <input type="button" id="forget-btn" class="btn btn-block login-btn" value="Submit" />
    </form>
    <!-- END FORGOT PASSWORD FORM -->
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div id="login-copyright">
    2015 &copy;  Huigeyuan Technology Allrights
</div>
<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS -->
<script src="<?php echo (JS_URL); ?>jquery-1.8.3.min.js"></script>
<!--<script src="<?php echo (JS_URL); ?>jquery.blockui.js"></script>-->
<script src="<?php echo (JS_URL); ?>scripts.js"></script>
<script>
    //清楚提示信息
    $('.clear').focusin(function(){
        $('#msg').html(' ');
    });
    // 验证码生成
    var captcha_img = $('.codeimg');
    var verifyimg = captcha_img.attr("src");
    captcha_img.attr('title', '点击刷新');
    captcha_img.click(function(){
        if( verifyimg.indexOf('?')>0){
            $(this).attr("src", verifyimg+'&random='+Math.random());
        }else{
            $(this).attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
        }
    });
    

    document.onkeydown = function (e) {
        if (!e)
            e = window.event;//火狐中是 window.event
        if ((e.keyCode || e.which) == 13) {
            $('#login-btn').click();
        }
    }

    $(function(){
        $("#login-btn").click(function(){
        	var ret = true;
            $("#op_type").val("1");
            if($("#input-username").val()=='' && $("#input-password").val()==''){
                // alert("填写完整方可登陆");
                $('#msg').html('<font style="line-height:28px;color:red;font-size:20px;font-family:黑体;">请输入用户名和密码</font>');
                ret = false;
            } else if($('#input-username').val()==''){
                $('#msg').html('<font style="line-height:28px;color:red;font-size:20px;font-family:黑体;">请输入用户名</font>');
                ret = false;
            } else if($('#input-password').val()==''){
                $('#msg').html('<font style="line-height:28px;color:red;font-size:20px;font-family:黑体;">请输入密码</font>');
                ret = false;
            } else if($('#input-codename').val()==''){
                $('#msg').html('<font style="line-height:28px;color:red;font-size:20px;font-family:黑体;">验证码不能为空</font>');
                ret = false;
            }
            if (!ret) {
            	return false;
            }
            $.ajax({
                url: '<?php echo U("Login/login");?>',
                type: 'POST',
                data: $('#loginform').serialize(),
                success:function(d){
                    var result = eval("(" + d + ")");
                    if (result.flag == 3) {
                    	window.location.href="<?php echo U('Index/index');?>";
                    } else {
                    	if(result.flag == 1){
                            $('#msg').html('<font style="line-height:28px;color:red;font-size:20px;font-family:黑体;">'+result.msg+'</font>');
                        }else if(result.flag == 2){
                            $('#msg').html('<font style="line-height:28px;color:red;font-size:20px;font-family:黑体;">'+result.msg+'</font>');
                        }else if(result.flag == 4){
                            $('#msg').html('<font style="line-height:28px;color:red;font-size:20px;font-family:黑体;">'+result.msg+'</font>');
                        }
                    	
                    	if( verifyimg.indexOf('?')>0){
                    		$('.codeimg').attr("src", verifyimg+'&random='+Math.random());
                        }else{
                        	$('.codeimg').attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
                        }
                    }
                    
                }
            });
            return false;
            commonAjaxSubmit();
        });
    });
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>