<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
<title>91搜墓网后台</title>
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<meta content="91搜墓网后台" name="description" />
<meta content="91搜墓网" name="author" />
<link href="<?php echo (ASSETS_URL); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo (ASSETS_URL); ?>bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link href="<?php echo (ASSETS_URL); ?>font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="<?php echo (CSS_URL); ?>style.css" rel="stylesheet" />
<link href="<?php echo (CSS_URL); ?>style_responsive.css" rel="stylesheet" />
<link href="<?php echo (CSS_URL); ?>style_default.css" rel="stylesheet" id="style_color" />
<link href="<?php echo (CSS_URL); ?>common.css" rel="stylesheet" type="text/css">
<link href="<?php echo (CSS_URL); ?>jquery.validator.css" rel="stylesheet" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
<!-- BEGIN HEADER -->
<div id="header" class="navbar navbar-inverse navbar-fixed-top">
    <!-- BEGIN TOP NAVIGATION BAR -->
    <div class="navbar-inner">
        <div class="container-fluid">
            <!-- BEGIN LOGO -->
            <a class="brand" href="<?php echo U('Index/index');?>">
                <img src="<?php echo (IMG_URL); ?>logo.png" alt="Admin Lab" />
            </a>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a class="btn btn-navbar collapsed" id="main_menu_trigger" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="arrow"></span>
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <div id="top_menu" class="nav notify-row">
                <!-- BEGIN NOTIFICATION -->
                <ul class="nav top-menu">
                    <!-- BEGIN SETTINGS -->
                    <!-- END SETTINGS -->
                    <!-- BEGIN INBOX DROPDOWN -->
                    <!-- END INBOX DROPDOWN -->
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <li class="dropdown" id="header_notification_bar">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                            <i class="icon-bell-alt"></i>
                            <span class="badge badge-warning">7</span>
                        </a>
                        <ul class="dropdown-menu extended notification">
                            <li>
                                <p>You have 7 new notifications</p>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-important"><i class="icon-bolt"></i></span>
                                    Server #3 overloaded.
                                    <span class="small italic">34 mins</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-warning"><i class="icon-bell"></i></span>
                                    Server #10 not respoding.
                                    <span class="small italic">1 Hours</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-important"><i class="icon-bolt"></i></span>
                                    Database overloaded 24%.
                                    <span class="small italic">4 hrs</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-success"><i class="icon-plus"></i></span>
                                    New user registered.
                                    <span class="small italic">Just now</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-info"><i class="icon-bullhorn"></i></span>
                                    Application error.
                                    <span class="small italic">10 mins</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">See all notifications</a>
                            </li>
                        </ul>
                    </li>
                    <!-- END NOTIFICATION DROPDOWN -->
                    <?php if(is_array($menuData)): $i = 0; $__LIST__ = $menuData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                        <a href="javascript:void(0)" class='topmemu' data-menuid='<?php echo ($vo["id"]); ?>'>
                            <span class="tnav_i">
                                <i class="icon-home"></i>
                            </span>
                        <?php echo ($vo["title"]); ?></a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
            <!-- END  NOTIFICATION -->
            <div class="top-nav ">
                <ul class="nav pull-right top-menu" >
                    <!-- BEGIN SUPPORT -->

                    <!-- END SUPPORT -->
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo (IMG_URL); ?>avatar1_small.jpg" alt="">
                            <span class="username"><?php echo (session('email')); ?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo U('Index/index');?>"><i class="icon-user"></i>个人中心</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo U('Login/logout');?>"><i class="icon-key"></i>退出登陆</a></li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
                <!-- END TOP NAVIGATION MENU -->
            </div>
        </div>
    </div>
    <!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div id="container" class="row-fluid">
    <!-- BEGIN SIDEBAR -->
    
<div id="sidebar" class="nav-collapse collapse">
    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
    <div class="sidebar-toggler hidden-phone"></div>
    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->

    <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
    <div class="navbar-inverse">
        <form class="navbar-search visible-phone">
            <input type="text" class="search-query" placeholder="Search" />
        </form>
    </div>
    <!-- END RESPONSIVE QUICK SEARCH FORM -->
    <!-- BEGIN SIDEBAR MENU -->
    <ul class="sidebar-menu">
        <?php if(is_array($menuData)): $i = 0; $__LIST__ = $menuData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(is_array($vo["child"])): $m = 0; $__LIST__ = $vo["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($m % 2 );++$m;?><li class="has-sub  <?php if(($vo["id"]) != $currentpriId): ?>hide<?php endif; ?> child-menu<?php echo ($vo["id"]); ?>">
	            <a href="javascript:;" class="">
	                <span class="icon-box">
	                    <i class="icon-dashboard"></i>
	                </span> 
	                <?php echo ($v1["title"]); ?>
	                <span class="arrow"></span>
	            </a>
	            <ul class="sub" <?php if(($memuId) == $v1["id"]): ?>style="display: block;"<?php endif; ?>>
	                <?php if(is_array($v1["child"])): $i = 0; $__LIST__ = $v1["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v2): $mod = ($i % 2 );++$i;?><li <?php if(($path) == $v2["name"]): ?>class="active"<?php endif; ?>>
	                    <a  href="<?php echo U($v2['name']);?>">
	                        <i class="icon-home"></i>
	                        <?php echo ($v2["title"]); ?>
	                    </a>
	                </li><?php endforeach; endif; else: echo "" ;endif; ?>
	            </ul>
	        </li><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>

        
    </ul>
    <!-- END SIDEBAR MENU -->
</div>
    <!-- END SIDEBAR -->
    <!-- BEGIN PAGE -->
    <div id="main-content">
        <!-- BEGIN PAGE CONTAINER-->
        <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN THEME CUSTOMIZER-->
                    <div id="theme-change" class="hidden-phone">
                        <i class="icon-cogs"></i>
                            <span class="settings">
                                <span class="text">Theme:</span>
                                <span class="colors">
                                    <span class="color-default" data-style="default"></span>
                                    <span class="color-gray" data-style="gray"></span>
                                    <span class="color-purple" data-style="purple"></span>
                                    <span class="color-navy-blue" data-style="navy-blue"></span>
                                </span>
                            </span>
                    </div>
                    <!-- END THEME CUSTOMIZER-->
                    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                    <ul class="breadcrumb">
                        <li>
                            <a href="<?php echo U('Index/index');?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span>
                        </li>
                        <li>
                            <a href="<?php echo U('Index/index');?>">91搜墓网后台</a> <span class="divider">&nbsp;</span>
                        </li>
                        <li><a href="<?php echo U('StoreGoods/index');?>">商家商品列表</a><span class="divider">&nbsp;</span></li>
                        <li><a href="javascript:viod(0);">添加商家商品信息</a><span class="divider-last">&nbsp;</span></li>
                    </ul>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div id="page" class="dashboard">
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN RECENT ORDERS PORTLET-->
                        <div class="widget">
                            <div class="widget-title">
                                <h4><i class="icon-reorder"></i>添加商家商品信息</h4>
                            </div>
                            <div class="widget-body form">
                                <!-- BEGIN FORM-->
                                <form id="defaultForm" method="post"  autocomplete="off" action="<?php echo U('StoreGoods/saveStoreGoods');?>" enctype="multipart/form-data">
                                    <div class="">
                                        <table class="table table-bordered table-hover">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>选择地区:</label>
                                                </td>
                                                <td>
                                                    <select class="input-small m-wrap" tabindex="1" name="info[province_id]" id="province">
                                                        <option value="0">--请选择--</option>
                                                        <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><option value="<?php echo ($p["region_id"]); ?>"><?php echo ($p["region_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                    </select>省
                                                    <select class="input-small m-wrap" tabindex="1" name="info[city_id]" id="city">
                                                        <option value="0">--请选择-- </option>
                                                    </select>市/区
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span style="color:red">*</span>选择商家：</td>
                                                <td>
                                                    <select class='chosen' name='info[store_id]' data-id="store_name" data-placeholder="选择商家" data-rule='required' >
                                                        <option value="">--选择商家--</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>选择商品:</label>
                                                </td>
                                                <td>
                                                    <select class="input-medium m-wrap" tabindex="1" name="info[category_pid]" id="category_pid" data-rule='required'>
                                                        <option value="-1">--请选择--</option>
                                                        <?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cat["cid"]); ?>"><?php echo ($cat["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                    </select>
                                                    <select class="input-medium m-wrap" tabindex="1" name="info[category_id]" id="category_id" style="display:none">
                                                        
                                                    </select>
                                                     <select class="input-medium m-wrap" tabindex="1" name="goods_id" id="goods_id" data-rule='required' style="display:none">
                                                        
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>商品名称:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                        <input type="text" placeholder="商品名称" id='goodsName' class="input-xxlarge" name="info[service_goods_name]" data-rule='required'>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>市场价:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                        <input type="text" placeholder="市场价" class="input-xxlarge" name="info[market_price]" data-rule='required' >
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>销售价:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                        <input type="text" placeholder="销售价" class="input-xxlarge" name="info[sales_price]" data-rule='required' >
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr style="display:none" id='number'>
                                                <td>
                                                    <label class="control-label">数量:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                        <input type="text" placeholder="数量" class="input-xxlarge" name="info[number]">
                                                        <span style="color:red">鲜花的支数</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">选择仓库:</label>
                                                </td>
                                                <td>
                                                    <select class="input-medium m-wrap" tabindex="1" id='storage' name="info[storage_id]">
                                                        <option value="0">--请选择--</option>
                                                        <?php if(is_array($storage)): $i = 0; $__LIST__ = $storage;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sto): $mod = ($i % 2 );++$i;?><option value="<?php echo ($sto["id"]); ?>"><?php echo ($sto["storage_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">库存:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                        <input type="text" placeholder="库存" class="input-xxlarge" name="info[inventory]" readonly="readonly">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr style="display:none" id='images'>
                                                <td>
                                                    <label class="control-label">商品图片:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                        <img src="" width="80px" height="80px" id='img'>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>更改商品图片:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                        <input type="file" class="default" name="image_url" >
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">SEO标题:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="用于SEO的title" class="input-xxlarge" name="info[seo_title]"> 
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>关键字:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="用于SEO的keywords" class="input-xxlarge" name="info[seo_keywords]" data-rule='required'> 
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>描述:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                        <textarea class="span6 " rows="3"  name="info[seo_description]" style="margin-top: 0px; margin-bottom: 10px; height: 123px;" data-rule='required' placeholder="用于SEO的description"></textarea>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                          
                                            <tr>
                                                <td>
                                                    <label class="control-label">摘要:</label>
                                                </td>
                                                <td  colspan="3">
                                                    <div class="controls">
                                                        <textarea class="span7 " rows="3"  name="info[summary]" style="margin-top: 0px; margin-bottom: 10px; height: 123px;"></textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">寓意:</label>
                                                </td>
                                                <td  colspan="3">
                                                    <div class="controls">
                                                        <textarea class="span7 " rows="3"  name="info[moral]" style="margin-top: 0px; margin-bottom: 10px; height: 123px;"></textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>简介:</label>
                                                </td>
                                                <td>
                                                    <div>
                                                        <textarea name="info[introduction]" class="input" id="content" style="width:750px;height: 400px;" data-rule='required'></textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>能否使用优惠券:</label>
                                                </td>
                                                <td>
                                                    <div>
                                                        <input type="radio" name='info[coupon]' value='1'>能
                                                        <input type="radio" name='info[coupon]' value='2' checked="ture">不能
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>状态:</label>
                                                </td>
                                                <td>
                                                    <select class="input-medium m-wrap" tabindex="1" name="info[status]" data-rule='required'>
                                                        <option value="">---请选择---</option>
                                                        <?php if(is_array(C("SERVICEGOODS_STATUS"))): $i = 0; $__LIST__ = C("SERVICEGOODS_STATUS");if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?> 
                                                    </select>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success" id='sub'>提交</button>
                                    </div>
                                </form>
                                <!-- END FORM-->
                            </div>
                        </div>
                        <!-- END RECENT ORDERS PORTLET-->
                    </div>
                </div>

            </div>
            <!-- END PAGE CONTENT-->
        </div>
        <!-- END PAGE CONTAINER-->
    </div>
    <!-- END PAGE -->
</div>
<!-- END CONTAINER -->

<!-- BEGIN FOOTER -->
<div id="footer">
    2009 &copy; Huigeyuan Technology Allrights.
    <div class="span pull-right">
        <span class="go-top"><i class="icon-arrow-up"></i></span>
    </div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS -->
<!-- Load javascripts at bottom, this will reduce page load time -->
<script src="<?php echo (JS_URL); ?>jquery-1.8.3.min.js"></script>
<script src="<?php echo (ASSETS_URL); ?>bootstrap/js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo (JS_URL); ?>My97DatePicker/WdatePicker.js"></script>

<script type="text/javascript" src="/Public/Admin/kindeditor/kindeditor.js"></script><script type="text/javascript" src="/Public/Admin/kindeditor/lang/zh_CN.js"></script>

<script src="<?php echo (JS_URL); ?>jquery.validator.js"></script>
<script src="<?php echo (JS_URL); ?>scripts.js"></script>
<script src="<?php echo (JS_URL); ?>zh-CN.js"></script>

<script>
    //调用KindEditor内容样式
    var content;
    KindEditor.ready(function(K) {
        content = K.create('#content');
    });

    //获取商品分类
    $(function() {
        $("#category_pid").change(function() {
            $('#number').hide();//隐藏数量输入框
            
            var categoryPid = $('#category_pid').val();
            getCategory('#category_id', categoryPid);
            //分类为鲜花时显示数量输入框
            if(categoryPid=="<?php echo (C("FLOWER")); ?>"){
                $('#number').show();
            }
            $('#images').hide(); //隐藏图片
        });

        
        //获取商品子分类和套餐商品
        function getCategory(selectId, categoryPid) {
            $.post("<?php echo U('getCategoryList');?>",
                {categoryPid: categoryPid},
                function(data) {
                    if (data.flg=='list') {
                        var str = "<option value='0'>--请选择--</option>";
                        for (var i = 0; i < data.res.length; i++) {
                            str += "<option value='" + data['res'][i]['cid'] + "'>" + data['res'][i]['name'] + "</option>";
                        }
                        $(selectId).empty().append(str);
                        $('#goods_id').empty().hide();
                        $(selectId).show();

                    }else if(data.flg=='goods'){
                        var str = "<option value='"+categoryPid+"'>--请选择--</option>";
                        $(selectId).empty().append(str);
                        $(selectId).hide();
                        //显示套餐商品
                        var str = "<option value=''>--请选择--</option>";
                        for (var i = 0; i < data.res.length; i++) {
                            str += "<option value='" + data['res'][i]['id'] + "'>" + data['res'][i]['name'] + "</option>";
                        }
                        $('#goods_id').empty().append(str);
                        $('#goods_id').show();
                    }else{
                        $(selectId).empty().hide();
                        $('#goods_id').empty().hide();
                    }
                }, 'json');
        }
    });

    //获取商品列表
    $("#category_id").change(function() {
        var categoryId = $('#category_id').val();
        $('#images').hide(); //隐藏图片
        $.post("<?php echo U('getGoodsList');?>",
            {categoryId: categoryId},
            function(data) {
                if (data) {
                    var str = "<option value=''>--请选择--</option>";
                    for (var i = 0; i < data.length; i++) {
                        str += "<option value='" + data[i]['id'] + "'>" + data[i]['name'] + "</option>";
                    }
                    $('#goods_id').empty().append(str);
                    $('#goods_id').show();
                }else{
                    $('#goods_id').empty().hide();
                }
            }, 'json');
        
    });

    //选择商品获取商品信息
    $('#goods_id').change(function(){
        var goodsId = $('#goods_id').val();
        $.post("<?php echo U('getGoodsDetail');?>",
            {goodsId: goodsId},
            function(data) {
                if (data) {
                    $("input[name='info[service_goods_name]']").val(data.name);
                    $("select[name='info[storage_id]']").val(data.storage_id);
                    $("input[name='info[inventory]']").val(data.inventory);
                    $("#img").attr('src',data.image_url);
                    $("textarea[name='info[summary]']").html(data.summary);
                    $("textarea[name='info[moral]']").html(data.moral);
                    $("select[name='info[status]']").val(data.status);
                    content.text(data.introduction);
                    $('#images').show();
                    if(!data.inventory){
                        $("input[name='info[inventory]']").css('border','1px solid red');
                        $("input[name='info[inventory]']").val(0);
                    }else{
                        $("input[name='info[inventory]']").css('border','');
                    }
                }
            }, 'json');
    });

    //省市下拉框联动
    $(function() {
        $("#province").change(function() {
            var provinceId = $('#province').val();
            getLevel2City('#city', provinceId);
        });

        /**
         * 获取二级地区列表
         * @param {type} province_id
         * @returns {undefined}
         */
        function getLevel2City(selectId, provinceId) {
            $.post("<?php echo U('getCityList');?>",
                {province_id: provinceId},
                function(data) {
                    if (data.length > 0) {
                        var str = "<option value='0'>--请选择--</option>";
                        for (var i = 0; i < data.length; i++) {
                            str += "<option value='" + data[i]['region_id'] + "'>" + data[i]['region_name'] + "</option>";
                        }
                        $(selectId).empty().append(str);
                    }
                }, 'json');
        }
    });

    /**
     * 按省份筛选
     */
    $("#province").change(function(){
        var province = $('select[id="province"] > option:selected').val();
        var data = {'province':province};
        getStoreList('select[data-id="store_name"]',data);
    })

    /*
     *按市区筛选
     */
    $('#city').change(function(){
        var province = $('select[id="province"] > option:selected').val();
        var city = $('select[id="city"] > option:selected').val();
        var data = {'province':province,'city':city};
        getStoreList('select[data-id="store_name"]',data);
    })

    function getStoreList(selectId,info){
        $.ajax({
            url:"<?php echo U('getStoreList');?>",
            type:'get',
            data:info,
            success:function(v){
                var store = eval("("+v+")");
                var count = store.length;
                var str = "<option value=''>--选择商家--</option>";
                if(count > 0){
                    for (var i = 0; i < count; i++) {
                        str += "<option value='"+store[i]['store_id']+"'>"+store[i]['store_name']+"</option>";
                    }
                    $(selectId).empty().append(str);
                }else{
                    $(selectId).empty();
                }
            }
        })
    }

    //查询库存
    $('#storage').change(function(){
        var storageId = $('#storage').val();
        var goodsId = $('#goods_id').val();
        if(goodsId && storageId){
            $.ajax({
                url:'<?php echo U("getInventory");?>',
                type:'post',
                data:{'storageId':storageId,'goodsId':goodsId},
                dataType:'json',
                success:function(e){
                    if(e){
                        $("input[name='info[inventory]']").val(e.inventory);
                    }else{
                        $("input[name='info[inventory]']").val('');
                    }
                }
            })
        }
    });
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>