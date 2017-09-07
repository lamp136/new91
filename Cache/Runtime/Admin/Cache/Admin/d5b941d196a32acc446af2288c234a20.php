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
                        <li><a href="javascript:void(0)">修改融资信息</a><span class="divider-last">&nbsp;</span></li>

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
                                <h4><i class="icon-reorder"></i>修改融资信息</h4>
                            </div>
                            <div class="widget-body form">
                                <!-- BEGIN FORM-->
                                <form id="defaultForm" method="post"  autocomplete="off" action="<?php echo U('Financing/updateFina');?>" enctype="multipart/form-data">
                                    <div class="">
                                        <table class="table table-bordered table-hover">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>项目名称:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="项目名称" class="input-large" name="info[pro_name]" data-rule='required' value="<?php echo ($finance["pro_name"]); ?>">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <label class="control-label">项目别名:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="项目别名" class="input-large" name="info[alias]" value="<?php echo ($finance["alias"]); ?>">
                                                        </div>
                                                    </div>
                                                </td>  
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>陵园类型:</label>
                                                </td>
                                                <td>
                                                    <select class="input-medium m-wrap" tabindex="1" name="info[type]" id='data-type'>
                                                        <option value="">---请选择---</option>
                                                        <option value="1" <?php if($finance["type"] == 1): ?>selected="selected"<?php endif; ?>>公益性</option>
                                                        <option value="2" <?php if($finance["type"] == 2): ?>selected="selected"<?php endif; ?>>经营性</option>  
                                                    </select>
                                                </td>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>公司现状:</label>
                                                </td>
                                                <td>
                                                    <select class="input-medium m-wrap" tabindex="1" name="info[business_actuality]" id='data-business'>
                                                        <option value="">---请选择---</option>
                                                        <?php if(is_array(C("FINANCE_BUSINESS_ACTUALITY"))): $ctk = 0; $__LIST__ = C("FINANCE_BUSINESS_ACTUALITY");if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($ctk % 2 );++$ctk;?><option value="<?php echo ($ctk); ?>" <?php if($finance["business_actuality"] == $ctk): ?>selected="selected"<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">占地情况:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="占地情况" class="input-large" name="info[cover]" value="<?php echo ($finance["cover"]); ?>">
                                                        </div>
                                                    </div>
                                                </td> 
                                                <td>
                                                    <label class="control-label">所在省份:</label>
                                                </td>
                                                <td>
                                                    <select class="input-small m-wrap" tabindex="1" name="info[province_id]" id="province">
                                                        <option value="0">--请选择--</option>
                                                        <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pro): $mod = ($i % 2 );++$i; if($pro[region_id] == $finance[province_id]): ?><option value="<?php echo ($pro["region_id"]); ?>" selected="selected"><?php echo ($pro["region_name"]); ?></option>
                                                            <?php else: ?>
                                                                <option value="<?php echo ($pro["region_id"]); ?>"><?php echo ($pro["region_name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                                    </select>省
                                                    <select class="input-small m-wrap" tabindex="1" name="info[city_id]" id="city">
                                                        <option value="0">--请选择-- </option>
                                                        <?php if(is_array($city)): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cit): $mod = ($i % 2 );++$i; if($cit['region_id'] == $finance['city_id']): ?><option value="<?php echo ($cit["region_id"]); ?>" selected><?php echo ($cit["region_name"]); ?></option>
                                                            <?php else: ?>
                                                                <option value="<?php echo ($cit["region_id"]); ?>"><?php echo ($cit["region_name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                                    </select>市/区
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="radio">手续是否完备:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                    <input type="radio" name="info[paperwork]" value="1" <?php if($finance["paperwork"] == 1): ?>checked='checked'<?php endif; ?> >
                                                    是
                                                    <input type="radio" name="info[paperwork]" value="2" <?php if($finance["paperwork"] == 2): ?>checked='checked'<?php endif; ?>>
                                                    不是
                                                    </div>
                                                </td>
                                                <td>
                                                    <label class="radio">是否推荐:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                        <input type="radio" name="info[recommend]" value="0" <?php if($finance["recommend"] == 0): ?>checked="checked"<?php endif; ?>>
                                                        不推荐
                                                        <input type="radio" name="info[recommend]" value="1" <?php if($finance["recommend"] == 1): ?>checked="checked"<?php endif; ?>>
                                                        推荐
                                                        <input type="radio" name="info[recommend]" value="2" <?php if($finance["recommend"] == 2): ?>checked="checked"<?php endif; ?>>
                                                        最新推荐
                                                        <span style="color:red">首页只显示推荐和最新推荐项目</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label"><span style="color:red">*</span>客户联系人:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="客户联系人" class="input-large" name="info[contracts]" data-rule='required' value="<?php echo ($finance["contracts"]); ?>" id='data-contracts'>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <label class="control-label">首页和列表页图片:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                        <input type="file" class="default" name="url" >
                                                    </div>
                                                </td>
                                                 
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">联系人手机号:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="联系人手机号" class="input-large" name="info[mobile]" id="mobiles" value="<?php echo ($finance["mobile"]); ?>">
                                                            <span id="style" style="color: red"></span>
                                                        </div>
                                                    </div>
                                                </td> 
                                                <td>
                                                    <label class="control-label">固定电话:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="固定电话" class="input-large" name="info[tel]" value="<?php echo ($finance["tel"]); ?>" id='tel'>
                                                            <span id="style" style="color: red"></span>
                                                        </div>
                                                    </div>
                                                </td>
                                               
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">简介:</label>
                                                </td>
                                                <td colspan="3">
                                                    <div class="controls">
                                                        <textarea class="span10 " rows="3"  name="info[introduction]" style="margin-top: 0px; margin-bottom: 10px; height: 123px;"><?php echo ($finance["introduction"]); ?></textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                             <tr>
                                                <td>
                                                    <label class="control-label">估价:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="估价" class="input-large" name="info[appraisal]" value="<?php echo ($finance["appraisal"]); ?>">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <label class="control-label">年销售额(年):</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="年销售额" class="input-large" name="info[profit]" value="<?php echo ($finance["profit"]); ?>">
                                                        </div>
                                                    </div>
                                                </td>  
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="radio">项目状态:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                        <input type="radio" name="info[status]" value="0" <?php if($finance["status"] == 0): ?>checked="checked"<?php endif; ?>>
                                                        待审核
                                                        <input type="radio" name="info[status]" value="1" <?php if($finance["status"] == 1): ?>checked="checked"<?php endif; ?>>
                                                        发布
                                                        <input type="radio" name="info[status]" value="2" <?php if($finance["status"] == 2): ?>checked="checked"<?php endif; ?>>
                                                        已完成
                                                        <input type="radio" name="info[status]" value="-1" <?php if($finance["status"] == -1): ?>checked="checked"<?php endif; ?>>
                                                        已删除
                                                    </div>
                                                </td>
                                                <td>
                                                    <label class="control-label">融资方式:</label>
                                                </td>
                                                <td>
                                                    <select class="input-medium m-wrap" tabindex="1" name="info[finance_type]">
                                                        <option value="">---请选择---</option>
                                                    <?php if(is_array($type)): $ctk = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($ctk % 2 );++$ctk;?><option value="<?php echo ($ctk); ?>" <?php if($finance["finance_type"] == $ctk): ?>selected="selected"<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>    
                                                    </select>
                                                </td>
                                            </tr>
                                           
                                            <tr>
                                                <td>
                                                    <label class="control-label">项目对接人:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="项目对接人" class="input-large" name="info[butt_man]" value="<?php echo ($finance["butt_man"]); ?>">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <label class="control-label">项目对接人电话:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="项目对接人电话" class="input-large" name="info[butt_man_mobile]" value="<?php echo ($finance["butt_man_mobile"]); ?>">
                                                        </div>
                                                    </div>
                                                </td>  
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">成交额:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="成交额" class="input-large" name="info[turnover]" value="<?php echo ($finance["turnover"]); ?>">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <label class="control-label">佣金:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="佣金" class="input-large" name="info[commission]" value="<?php echo ($finance["commission"]); ?>">%
                                                        </div>
                                                    </div>
                                                </td>  
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">公司地址:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="地址" class="input-large" name="info[address]" value="<?php echo ($finance["address"]); ?>">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <label class="control-label">排序:</label>
                                                </td>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="排序" class="input-large" name="info[sort]" value="<?php echo ($finance["sort"]); ?>">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">91平台责任义务:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                        <textarea class="span9 " rows="3"  name="info[91_duty]" style="margin-top: 0px; margin-bottom: 10px; height: 90px;"><?php echo ($finance["91_duty"]); ?></textarea>
                                                    </div>
                                                </td>
                                                 <td>
                                                    <label class="control-label">周边市场容量:</label>
                                                </td>
                                                <td>
                                                    <div class="controls">
                                                        <textarea class="span7 " rows="3"  name="info[market_capacity]" style="margin-top: 0px; margin-bottom: 10px; height: 90px;" ><?php echo ($finance["market_capacity"]); ?></textarea> 
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">SEO标题:</label>
                                                </td>
                                                <td td colspan="3">
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="SEO标题" class="span10" name="info[seo_title]" value="<?php echo ($finance["seo_title"]); ?>" >
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td>
                                                    <label class="control-label">SEO关键字:</label>
                                                </td>
                                                <td td colspan="3">
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" placeholder="SEO关键字" class="span10" name="info[seo_keywords]" value="<?php echo ($finance["seo_keywords"]); ?>" >
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">SEO描述:</label>
                                                </td>
                                                <td colspan="3">
                                                    <div class="controls">
                                                        <textarea class="span10" rows="3"  name="info[seo_description]" style="margin-top: 0px; margin-bottom: 10px; height: 60px;"><?php echo ($finance["seo_description"]); ?></textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label">备注:</label>
                                                </td>
                                                <td colspan="3">
                                                    <div class="controls">
                                                        <textarea class="span10 " rows="3"  name="info[remark]" style="margin-top: 0px; margin-bottom: 10px; height: 123px;"><?php echo ($finance["remark"]); ?></textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                          
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-actions">
                                        <input type="hidden" name='id' value="<?php echo ($finance["id"]); ?>">
                                        <input type="hidden" name='nowPage' value="<?php echo ($nowPage); ?>">
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
<!-- ie8 fixes -->
<!--[if lt IE 9]>
<script src="js/excanvas.js"></script>
<script src="js/respond.js"></script>
<![endif]-->


<script>
    var PHONE = false;
    var TEL   = false;
    //验证联系人手机号
    $('#mobiles').blur(function(){
        if($(this).val()){
            var mobile = $('#mobiles').val();
            var reg = /^(1[3|4|5|7|8]\d{9})$/;
            if(!reg.test(mobile)){
                $("#style").text("手机号不正确");
                PHONE = false;
            }else{
                $("#style").text("");
                PHONE = true;
            }
        }else{
            PHONE = false;
        }
    })

    //检测固话内是否有值
    $('#tel').blur(function(){
        if($(this).val()){
            TEL = true;
        }else{
            TEL = false;
        }
    })

    //表单验证
    $('#defaultForm').submit(function(){
        //脚本中触发元素的丧失焦点事件
        $('input').trigger('blur');

        if(!$('#data-type').val()){
            alert('陵园类型不能为空');
            return false;
        }
        if(!$('#data-business').val()){
            alert('公司现状不能为空');
            return false;
        }
        if(!$('#data-contracts').val()){
            alert('联系人不能为空');
            return false;
        }
        if(!(PHONE || TEL)){
            alert('请填写联系人电话');
            return false;
        }  
    })

    //设置省市下拉列表
    $(function() {
        $("#province").change(function() {
            var provinceId = $('#province').val();
            getLevel2City('#city', provinceId);
        });
        //获取二级地区列表
        function getLevel2City(selectId, provinceId) {
            $.post('/system.php/Financing/getCityList',
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

</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>