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
    <link rel="stylesheet" type="text/css" href="<?php echo (ASSETS_URL); ?>chosen-bootstrap/chosen/chosen.css" />
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
                        <li><a href="javascript:void(0)">添加陵园基础信息</a><span class="divider-last">&nbsp;</span></li>

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
                                <h4><i class="icon-reorder"></i>添加陵园基础信息</h4>
                            </div>
                            <div class="widget-body form">
                                <!-- BEGIN FORM-->
                                <form id="defaultForm" method="post"  autocomplete="off" action="/system.php/BaseStore/addCemetery.html" enctype="multipart/form-data">
                                    <div>
                                        <table class="table table-bordered table-hover">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>选择地区:</label>
                                                </td>
                                                <td>
                                                    <select class="input-small m-wrap" tabindex="1" name="info[province_id]" data-id="province_id">
                                                        <option value="0">--请选择--</option>
                                                        <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><option value="<?php echo ($p["region_id"]); ?>"><?php echo ($p["region_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                    </select>省
                                                    <select class="input-small m-wrap" tabindex="1" name="info[city_id]" data-id="city_id">
                                                        <option value="0">--请选择-- </option>
                                                    </select>市/区
                                                </td>
                                            </tr>
                                            <tr data-id="choice_profiles" class="hide">
                                                <td><span style="color:red">*</span>选择合同：</td>
                                                <td>
                                                    <select class='chosen' data-id="profiles_name" data-placeholder="选择档案">
                                                        <option value="0">--选择档案--</option>
                                                    </select>
                                                    <span data-id="profiles" class="hide">
                                                        <select data-name="profiles_detail_name" class="chosen" name="info[store_profiles_id]" data-placeholder="选择合同">
                                                            <option value="0">--选择合同--</option>
                                                        </select>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span style="color:red">*</span>商家名称：</td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="陵园名称:" class="input-medium" data-name="store_name" name="info[store_name]" data-rule='required' id="check_name" onblur="return checkStoreName()">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class='hide'>
                                                <td>
                                                    <label class="control-label">
                                                        <span style="color:red">*</span>陵园类型:
                                                    </label>
                                                </td>
                                                <td>
                                                    <input id='category_id' name='info[category_id]' value='<?php echo (C("CATEGORY_CEMETERY_ID")); ?>' />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">集团所属:</label>
                                                </td>
                                                <td>
                                                    <select class="input-medium m-wrap" tabindex="1" data-name="category_pid" name="info[category_pid]">
                                                        <option value="">---请选择---</option>
                                                        <?php if(is_array($categoryGroup)): $i = 0; $__LIST__ = $categoryGroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cate["cid"]); ?>"><?php echo ($cate["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                           <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>陵园图片:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                        列表图标：<input type="file" class="default" name="store_banner" data-rule='required'/>
                                                        <!-- 陵园横幅：<input type="file" class="default" name="store_banner"/> -->
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">陵园特色:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="陵园特色" class="input-xxlarge" name="info[feature]">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">风水描述:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="风水描述" class="input-xxlarge" name="info[geomantic]">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">环境描述:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="环境描述" class="input-xxlarge" name="info[environment]">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">联系人:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            姓名：<input type="text" data-name="contact_name" value="" placeholder="姓名" class="input-large" name="contact[contact_name]">
                                                            手机：<input type="text" placeholder="联系人手机号" class="input-large" name="contact[mobile]" data-name="mobiles">
                                                            <span id="style" style="color: red"></span>
                                                            座机：<span style="color:red">*</span><input type="text" placeholder="填写座机号" class="input-large" data-rule='required' data-name="tels" name="contact[tel]">
                                                            <input type="hidden" name="contact[status]" value="1"/>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">地址:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="地址" data-name="address" class="input-xxlarge" name="info[address]">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>陵园seo标题:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="用于SEO的title" class="input-xxlarge" data-rule='required' name="info[seo_title]">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>陵园seo关键字:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="用于SEO的keywords" class="input-xxlarge" data-rule='required' name="info[seo_keywords]"/>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>陵园seo描述:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                        <textarea class="span6" rows="3"  name="info[seo_description]" data-rule='required' placeholder="用于SEO的description" style="height:123px;width:544px;"></textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">陵园摘要:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                        <textarea class="span6" rows="3"  name="info[summary]" style="height:123px;width:544px;"></textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>陵园简介:</label>
                                                </td>
                                                <td>
                                                    <div>
                                                        <textarea name="info[content]" class="input" id="content" style="width:800px;height: 400px;"  data-rule='required'></textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">陵园备注:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                        <textarea class="span6" style="width:800px;" rows="3"  name="info[remarks]" data-name="remarks"></textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>经营性质:</label>
                                                </td>
                                                <td>
                                                    <select class="input-small m-wrap" tabindex="1" name="info[business_type]">
                                                        <option value="1">公益性</option>
                                                        <option value="2">经营性</option>
                                                        </volist>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">陵园评论:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            环境：<input type="text" placeholder="" class="input-mini" name="info[review_ambient]" value="3">
                                                            价格：<input type="text" placeholder="" class="input-mini" name="info[review_price]" value="3">
                                                            交通：<input type="text" placeholder="" class="input-mini" name="info[review_traffic]" value="3">
                                                            服务：<input type="text" placeholder="" class="input-mini" name="info[review_service]" value="3">
                                                           <span style="color:red;">(评论级别为1-5)</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="radio"><span style="color:red">*</span>是否是会员:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                        <?php if(is_array($memberStatus)): $i = 0; $__LIST__ = $memberStatus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input type='radio' data-name="member_status" name='info[member_status]' value="<?php echo ($key); ?>"><?php echo ($vo); endforeach; endif; else: echo "" ;endif; ?>    
                                                        <input type="radio" data-name="member_status" name="info[member_status]" value="0">
                                                            否
                                                        <span style="color:red;">会员V前台是不会显示优惠的</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">经纬度:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            经度：<input type="text" placeholder="经度" class="input-large" name="info[longitude]" value="0">
                                                            纬度：<input type="text" placeholder="纬度" class="input-large" name="info[latitude]" value="0">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>                                       
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>价格区间:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="最小值" data-name="min_price" class="input-mini" name="info[min_price]">--
                                                            <input type="text" placeholder="最大值" data-name="max_price" class="input-mini" name="info[max_price]" data-rule='required'>万
                                                        </div>
                                                        <span style="color:red;">只需要填写数字或者区间即可：0.85 或者 0.8-10万</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">陵园车接送:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <textarea class="span6 " rows="3" data-name="pick_up_address" name="info[pick_up_address]" style="margin-top: 0px; margin-bottom: 10px; height: 123px;" ></textarea>
                                                            *填写的车接送时候写完整的地址为一行
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">距离市区的距离:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="" class="input-large" name="info[distance]">公里
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="radio">陵园状态:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                        <input type="radio" data-name="status" name="info[status]" value="1">
                                                        开启
                                                        <input type="radio" name="info[status]" value="0" checked="checked">
                                                        审核
                                                        <input type="radio" data-name="status" name="info[status]" value="-1">
                                                        关闭
                                                        <input type="radio" data-name="status" name="info[status]" value="2">
                                                        墓位已满
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">关闭说明:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                        <textarea class="span6 " rows="3"  name="info[close_reason]" style="margin-top: 0px; margin-bottom: 10px; height: 123px;" ></textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">排序:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="排序" class="input-large" name="info[sort]" value="0">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-actions">
                                        <input type="reset" name="reset" style="display: none;" />
                                        <button type="submit" class="btn btn-success" id="sub">提交</button>
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
<script type="text/javascript" src="<?php echo (ASSETS_URL); ?>chosen-bootstrap/chosen/chosen.jquery.min.js"></script>

<script type="text/javascript" src="/Public/Admin/kindeditor/kindeditor.js"></script><script type="text/javascript" src="/Public/Admin/kindeditor/lang/zh_CN.js"></script>

<script src="<?php echo (JS_URL); ?>jquery.validator.js"></script>
<script src="<?php echo (JS_URL); ?>scripts.js"></script>
<script src="<?php echo (JS_URL); ?>zh-CN.js"></script>
<!-- ie8 fixes -->
<!--[if lt IE 9]>
<script src="js/excanvas.js"></script>
<script src="js/respond.js"></script>
<![endif]-->
<!--地图封装接口 以及一些初始化的数据 -->
<script>
    //提交表单的时候验证手机号是否正确
    $("#sub").bind("click",function(event){
        var province = $('select[data-id="province_id"]').val();
        var city = $('select[data-id="city_id"]').val();
        if(province == 0 && city == 0){
            event.preventDefault();
        }
    })
    
    $('input[data-name="mobiles"]').blur(function(){
        var mobile = $('input[data-name="mobiles"]').val();
        var reg = /^(1[3|4|5|7|8]\d{9})$/;
        if(mobile!=''){
            if(!reg.test(mobile)){
                $("#style").text("手机号不正确");  //提示信息
                $('input[data-name="mobiles"]').val('');
            }else{
                $("#style").text('');
            }
        }
    })

    /**
     * 按省份筛选
     */
    $('select[data-id="province_id"]').change(function(){
        $('span[data-id="profiles"]').hide();
        $('span[data-id="profiles"] option').remove();
        setEmpty();
        setNull();
        var provinceId = $('select[data-id="province_id"] > option:selected').val();
        // var categoryId = <?php echo (C("CATEGORY_CEMETERY_ID")); ?>;
        var data = {'province':provinceId};
        getProfilesList('select[data-id="profiles_name"]',data);
    })

    /*
     *按市区筛选
     */
    $('select[data-id="city_id"]').change(function(){
        $('span[data-id="profiles"]').hide();
        $('span[data-id="profiles"] option').remove();
        setEmpty();
        setNull();
        var provinceId = $('select[data-id="province_id"] > option:selected').val();
        var cityId = $('select[data-id="city_id"] > option:selected').val();
        // var categoryId = <?php echo (C("CATEGORY_CEMETERY_ID")); ?>;
        var data = {'province':provinceId,'city':cityId};
        getProfilesList('select[data-id="profiles_name"]',data);
    })

    function getProfilesList(selectId,info){
        $.ajax({
            url:"<?php echo U('getProfiles');?>",
            type:'get',
            data:info,
            success:function(v){
                var store = eval("("+v+")");
                var count = store.length;
                var str = "<option value='0'>--选择档案--</option>";
                if(count > 0){
                    $('tr[data-id="choice_profiles"]').show();
                    for (var i = 0; i < count; i++) {
                        str += "<option value='"+store[i]['id']+"'>"+store[i]['show_store_name']+"</option>";
                    }
                }else{
                    setPriceReadOnly(false);
                    $('tr[data-id="choice_profiles"]').hide();
                }
                $(selectId).empty().append(str);
                // bootstrap下拉框赋值
                $(selectId).trigger("liszt:updated");
                $(selectId).chosen();
            }
        })
    }

    // 档案列表change触发筛选合同列表
    $('select[data-id="profiles_name"]').change(function(){
        setNull();
        var storeId = $('select[data-id="profiles_name"] > option:selected');
        var member = $('input[data-name="member_status"]');
        var status = $('input[data-name="status"]');
        $.ajax({
            url : "<?php echo U('getProfilesDetail');?>",
            type : 'GET',
            data : {'store_id':storeId.val(),},
            success : function(d){
                var result = eval("(" + d + ")");
                $('input[data-name="store_name"]').val(result['show_store_name']);
                $('select[data-name="category_pid"]').val(result['category_group_id']);
                $('input[data-name="address"]').val(result['address']);
                var profilesOption = "<option value='0'>--选择合同--</option>";
                if(result['flag'] == 1){
                    // setPriceReadOnly(true);
                    var storeProfilesDetail = result['StoreProfilesDetail'];

                    var count = storeProfilesDetail.length;
                    $('span[data-id="profiles"]').show();
                    for (var i = 0; i < count; i++) {
                        profilesOption += "<option value='"+storeProfilesDetail[i]['id']+"'>"+storeProfilesDetail[i]['profile_name']+"</option>";
                    }
                }else if(result['flag'] == 2 || result['flag'] == 0){
                    setNull();
                    $('span[data-id="profiles"]').hide();
                }
                $('select[data-name="profiles_detail_name"]').empty().append(profilesOption);
                // bootstrap下拉框赋值
                $('select[data-name="profiles_detail_name"]').trigger("liszt:updated");
                $('select[data-name="profiles_detail_name"]').chosen();

                // 合同列表change触发赋值
                $('select[data-name="profiles_detail_name"]').change(function(){
                    var profilesId = $('select[data-name="profiles_detail_name"] > option:selected');
                    setNull();
                    for(x in storeProfilesDetail){
                        if(profilesId.val() == storeProfilesDetail[x]['id']){
                            $('input[data-name="contact_name"]').val(storeProfilesDetail[x]['contact_man']);
                            $('input[data-name="mobiles"]').val(storeProfilesDetail[x]['mobile']);
                            $('input[data-name="tels"]').val(storeProfilesDetail[x]['telephone']);
                            $('textarea[data-name="remarks"]').text(storeProfilesDetail[x]['remarks']);
                            $('input[data-name="min_price"]').val(storeProfilesDetail[x]['min_price']);
                            $('input[data-name="max_price"]').val(storeProfilesDetail[x]['max_price']);
                            $('textarea[data-name="pick_up_address"]').text(storeProfilesDetail[x]['commitment']);

                            // 会员状态动态选中
                            for (var i = 0; i < member.length; i++) {
                                if(member[i].value == storeProfilesDetail[x]['member_status']){
                                    member[i].checked = true;
                                    break;
                                }
                            }
                        }
                    }
                })
            }
        })
    })

    // 设置文本框只读
    function setPriceReadOnly(ret){
        $('input[data-name="min_price"]').attr('readonly',ret);
        $('input[data-name="max_price"]').attr('readonly',ret);
    }

    function setEmpty(){
        $('input[data-name="store_name"]').val('');
        $('select[data-name="pid"]').val('');
        $('input[data-name="address"]').val('');
    }

    function setNull(){
        $('input[data-name="contact_name"]').val('');
        $('input[data-name="mobiles"]').val('');
        $('input[data-name="tels"]').val('');
        $('textarea[data-name="remarks"]').text('');
        $('input[data-name="min_price"]').val('');
        $('input[data-name="max_price"]').val('');
        $('textarea[data-name="pick_up_address"]').text('');
        $('input[data-name="member_status"]').removeAttr('checked');
    }

    //验证陵园名称和分类唯一性
    function checkStoreName(){
        var store_name = $('#check_name').val();
        var category_id = $('#category_id').val();
        $.ajax({
            url : "<?php echo U('checkStoreName');?>",
            type : 'POST',
            data : {'store_name':store_name,'category_id':category_id},
            success : function(e) {
                var result = eval("(" + e + ")");
                if(result.flag == 1){
                    alert('该陵园已存在');
                    $("input[type=reset]").trigger("click");
                }
            }
        });
    }

    $(function() {
        $("select[data-id='province_id']").change(function() {
            var provinceId = $("select[data-id='province_id']").val();
            getLevel2City("select[data-id='city_id']", provinceId);
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
                    var str = "<option value='0'>--请选择--</option>";
                    if (data.length > 0) {
                        for (var i = 0; i < data.length; i++) {
                            str += "<option value='" + data[i]['region_id'] + "'>" + data[i]['region_name'] + "</option>";
                        }
                    }
                    $(selectId).empty().append(str);
                }, 'json');
        }

        var content;
        KindEditor.ready(function(K) {
            content = K.create('#content');
        });
    });

</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>