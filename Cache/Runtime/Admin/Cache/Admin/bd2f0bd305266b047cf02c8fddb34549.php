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
                            <li><a href="javascript:void(0)">广告位列表</a><span class="divider-last">&nbsp;</span></li>

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
                                    <h4><i class="icon-reorder"></i>推广支出记录列表</h4>
                                    <span class="tools">
                                    <?php if(showHandle('Opex/addDisburse')) { ?>
                                        <a href="javascript:void(0);" class="icon-plus add" >添加记录</a>
                                    <?php } ?>
                                    </span>
                                    <span class="tools">
                                    <?php if(showHandle('Opex/importDisburse')) { ?>
                                        <a href="javascript:void(0);" class="icon-cog import" >导入数据</a>
                                    <?php } if(showHandle('Opex/exportExcel')){ ?>
                                        <a class="icon-cog" href="<?php echo U('exportExcel');?>">导出数据</a>
                                    <?php } ?>
                                    </span>                               
                                </div>
                                <div class="widget-body">
                                    <form id="quickForm" method="get" class="form-horizontal" autocomplete="off" action='<?php echo U("Opex/disburse");?>'>
                                        <table>
                                            <tr>
                                                <td>搜索：&nbsp;</td>
                                                <td>
                                                    时间：<input type="text" name="start_time" class="input-medium Wdate" onClick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" <?php if(!empty($_GET['start_time'])): ?>value="<?php echo ($_GET['start_time']); ?>"<?php else: endif; ?>/>-
                                                    <input type="text" name="end_time" class="input-medium Wdate" onClick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" <?php if(!empty($_GET['end_time'])): ?>value="<?php echo ($_GET['end_time']); ?>" <?php else: endif; ?>/>
                                                </td>
                                                <td>
                                                    <select class="input-small m-wrap" tabindex="1" name="province_id" id="region">
                                                        <option value="0">选择省</option>
                                                        <?php if(is_array($region)): $i = 0; $__LIST__ = $region;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($_GET['province_id']) == $key): ?>selected="selected"<?php endif; ?> ><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="hidden" name='type' value=''>
                                                    <input type="hidden" name='order' value=''>
                                                    <button class="btn btn-primary">确定</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr class='head'>
                                                <th>用途</th>
                                                <th>时间</th>
                                                <th>省份</th>
                                                <th>
                                                    <a href="javascript:;" type='consume'>花费总额
                                                        <?php if($_GET['type']== consume): ?><img src="<?php echo (IMG_URL); ?>order-top.png" width="18px" name='top' <?php if($_GET['order']!= asc): ?>hidden<?php endif; ?>>
                                                            <img src="<?php echo (IMG_URL); ?>order-button.png" width="18px" name='button' <?php if($_GET['order']!= desc): ?>hidden<?php endif; ?>><?php endif; ?>
                                                    </a>
                                                </th>
                                                <th>展现量</th>
                                                <th>平均点击价格</th>
                                                <th>点击量</th>
                                                <th>点击率</th>
                                                <th>
                                                    <a href="javascript:;" type='reservation'>预约量
                                                        <?php if($_GET['type']== reservation): ?><img src="<?php echo (IMG_URL); ?>order-top.png" width="18px" name='top' <?php if($_GET['order']!= asc): ?>hidden<?php endif; ?>>
                                                            <img src="<?php echo (IMG_URL); ?>order-button.png" width="18px" name='button' <?php if($_GET['order']!= desc): ?>hidden<?php endif; ?>><?php endif; ?>
                                                    </a>
                                                </th>
                                                <th>平均成本</th>
                                                <th>
                                                    <a href="javascript:;" type='deal'>成交量
                                                        <?php if($_GET['type']== deal): ?><img src="<?php echo (IMG_URL); ?>order-top.png" width="18px" name='top' <?php if($_GET['order']!= asc): ?>hidden<?php endif; ?>>
                                                            <img src="<?php echo (IMG_URL); ?>order-button.png" width="18px" name='button' <?php if($_GET['order']!= desc): ?>hidden<?php endif; ?>><?php endif; ?>
                                                    </a>
                                                </th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="odd gradeX">
                                                <td>
                                                    <?php if(is_array($moneyUser)): $i = 0; $__LIST__ = $moneyUser;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mu): $mod = ($i % 2 );++$i; if($key == $vo["category_id"]): echo ($mu); endif; endforeach; endif; else: echo "" ;endif; ?>
                                                </td>
                                                <td><?php echo (date("Y-m-d",$vo["start_time"])); ?>至<?php echo (date("Y-m-d",$vo["end_time"])); ?></td>
                                                <td><?php echo ($region[$vo[province_id]]); ?></td>
                                                <td><?php echo ($vo["consume"]); ?></td>
                                                <td><?php echo ($vo["show"]); ?></td>
                                                <td><?php echo ($vo["average_click_price"]); ?></td>
                                                <td><?php echo ($vo["hit"]); ?></td>
                                                <td><?php echo ($vo["click_rate"]); ?></td>
                                                <td><?php echo ($vo["reservation"]); ?></td>
                                                <td><?php echo ($vo["cost"]); ?></td>
                                                <td><?php echo ($vo["deal"]); ?></td>
                                                <td>
                                                <?php if (showHandle('Opex/editDisbures')) { ?>
                                                    <a class="btn btn-small btn-primary edit"  href="javascript:void(0)" data-id="<?php echo ($vo["id"]); ?>"><i class="icon-pencil icon-white"> </i>编辑</a>
                                                <?php } if (showHandle('Opex/delDisburse')) { ?>
                                                    <?php if(($vo["status"]) == "1"): ?><a class="btn btn-danger btn-small del" href="javascript:void(0)" data-delId="<?php echo ($vo["id"]); ?>" >
                                                            <i class="icon-remove  icon-white"> </i>删除
                                                        </a>
                                                    <?php else: ?>
                                                        <a class="btn btn-success btn-small enable" href="javascript:void(0)" data-delId="<?php echo ($vo["id"]); ?>" >
                                                            <i class="icon-ok  icon-white"> </i>启用
                                                        </a><?php endif; ?>
                                                <?php } ?>                           
                                                </td>
                                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </tbody>
                                    </table>
                                    <div class="row-fluid">
                                        <div class="span12 center">
                                            <div class="pagination" id="sample_1_info" style="text-align: center">
                                                <?php echo ($page); ?>
                                            </div>
                                        </div>
                                    </div>
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

    <!--添加广告位开始-->
    <div id="add" class="modal hide fade in">
        <form id="addForm" method="post" class="form-horizontal" autocomplete="off">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>添加支出记录</h3>
            </div>
            <div class="modal-body" >

                <table class="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <td>时间：</td>
                            <td>
                                <input class="input-small Wdate add-time" onClick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" value="<?php echo date('Y-m-d');?>" name="start_time" type="text" data-rule="required" >
                                至
                                <input class="input-small Wdate add-time" onClick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" value="<?php echo date('Y-m-d');?>" name="end_time" type="text" data-rule="required" >
                            </td>
                        </tr>
                        <tr>
                            <td>用途：</td>
                            <td>
                                <select name="category_id" id="categoryChang" data-rule="required" >
                                    <option value="0">--请选择--</option>
                                    <?php if(is_array($moneyUser)): $i = 0; $__LIST__ = $moneyUser;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mu): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($mu); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>省份</td>
                            <td>
                                <select class="input-medium m-wrap time" name="province_id">
                                    <option value="">--选择省份--</option>
                                    <?php if(is_array($region)): $i = 0; $__LIST__ = $region;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($v); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>消费：</td>
                            <td><input class="input add-price"  name="consume" type="text" data-rule="required" >
                            </td>
                        </tr>
                        <tr>
                            <td>点击量：</td>
                            <td><input class="input add-price"  name="hit" type="text" data-rule="required" >
                            </td>
                        </tr>
                        <tr>
                            <td>展现量：</td>
                            <td><input class="input add-price" name="show" type="text" data-rule="required" >
                            </td>
                        </tr>
                        <tr>
                            <td>点击价格：</td>
                            <td><input class="input"  name="average_click_price" type="text" readonly="readonly">
                            </td>
                        </tr>
                        <tr>
                            <td>点击率：</td>
                            <td><input class="input"  name="click_rate" type="text" readonly="readonly" >
                            </td>
                        </tr>
                        <tr>
                            <td>预约量：</td>
                            <td><input class="input add-price"  name="reservation" type="text" data-rule="required" >
                            </td>
                        </tr>
                        <tr>
                            <td>平均成本</td>
                            <td><input class="input"  name="cost" type="text" readonly="readonly">
                            </td>
                        </tr>
                        <tr>
                            <td>成交量</td>
                            <td><input class="input"  name="deal" type="text" data-rule="required" >
                            </td>
                        </tr>
                        <tr>
                            <td>状态：</td>
                            <td>
                                <input type="radio" name="status" value="<?php echo (C("NORMAL_STATUS")); ?>" checked>正常
                                <input type="radio" name="status" value="<?php echo (C("DELETE_STATUS")); ?>">删除
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="submit"  class="btn btn-success">提交</button>
                <a href="javascript:void(0)" class="btn" data-dismiss="modal">关闭</a>
            </div>
        </form>
    </div>
    <!--添加广告位结束-->

    <!--编辑广告位开始-->
    <div id="edit" class="modal hide fade in">
        <form id="editForm" method="post"  class="form-horizontal" autocomplete="off">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>编辑信息</h3>
            </div>
            <div class="modal-body" >
                <table class="table table-bordered table-hover">
                    <tbody>
                       <tr>
                            <td>时间：</td>
                            <td>
                                <input class="input-small Wdate edit-time" onClick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" name="start_time" type="text" data-rule="required" >
                                至
                                <input class="input-small Wdate edit-time" onClick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" name="end_time" type="text" data-rule="required" >
                            </td>
                        </tr>
                        <tr>
                            <td>用途：</td>
                            <td>
                                <select name="category_id" id="categoryChang" data-rule="required">
                                    <option value="0">--请选择--</option>
                                    <?php if(is_array($moneyUser)): $i = 0; $__LIST__ = $moneyUser;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mu): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($mu); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>省份</td>
                            <td>
                                <select class="input-medium m-wrap" name="province_id">
                                    <option value="">--选择省份--</option>
                                    <?php if(is_array($region)): $i = 0; $__LIST__ = $region;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($v); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>消费：</td>
                            <td><input class="input edit-blur" name="consume" type="text" data-rule="required" >
                            </td>
                        </tr>
                        <tr>
                            <td>点击量：</td>
                            <td><input class="input edit-blur"  name="hit" type="text" data-rule="required" >
                            </td>
                        </tr>
                        <tr>
                            <td>展现量：</td>
                            <td><input class="input edit-blur" name="show" type="text" data-rule="required" >
                            </td>
                        </tr>
                        <tr>
                            <td>点击价格：</td>
                            <td><input class="input"  name="average_click_price" type="text" readonly="readonly">
                            </td>
                        </tr>
                        <tr>
                            <td>点击率：</td>
                            <td><input class="input"  name="click_rate" type="text" readonly="readonly" >
                            </td>
                        </tr>
                        <tr>
                            <td>预约量：</td>
                            <td><input class="input edit-blur"  name="reservation" type="text" data-rule="required" >
                            </td>
                        </tr>
                        <tr>
                            <td>平均成本</td>
                            <td><input class="input"  name="cost" type="text" readonly="readonly">
                            </td>
                        </tr>
                        <tr>
                            <td>成交量</td>
                            <td><input class="input"  name="deal" type="text" data-rule="required" >
                            </td>
                        </tr>
                        <tr>
                            <td>状态：</td>
                            <td>
                                <input type="radio" name="status" value="<?php echo (C("NORMAL_STATUS")); ?>" checked>正常
                                <input type="radio" name="status" value="<?php echo (C("DELETE_STATUS")); ?>">删除
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <input type="hidden" name='id' /> 
                <button type="submit"  class="btn btn-success">提交</button>
                <a href="#" class="btn" data-dismiss="modal">关闭</a>
            </div>
        </form>
    </div>
    <div id="import" class="modal hide fade in">
        <form id="importForm" method="post" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>导入excel数据</h3>
            </div>
            <div class="modal-body" >
                <table class="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <td>
                                用途：
                                <select name="category_id" id="categoryChang" data-rule="required">
                                    <option value="0">--请选择--</option>
                                    <?php if(is_array($moneyUser)): $i = 0; $__LIST__ = $moneyUser;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mu): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($mu); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="file" name="excel_file" data-rule="required">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="submit"  class="btn btn-success">提交</button>
                <a href="javascript:void(0)" class="btn" data-dismiss="modal">关闭</a>
            </div>
        </form>
    </div>
    <!--编辑专题信息结束-->

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

    <script src="<?php echo (JS_URL); ?>jquery.validator.js"></script>
    <script src="<?php echo (JS_URL); ?>zh-CN.js"></script>
    <script src="<?php echo (JS_URL); ?>scripts.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo (JS_URL); ?>My97DatePicker/WdatePicker.js"></script>
    <script>
        // 导入excel
        $('.import').click(function(){
            $('#import').modal();
        })

        // 提交导入excel
        $('#importForm').bind('valid.form',function(){
            $('#import').modal('hide');
            var importData = new FormData(document.getElementById('importForm'));
            $.ajax({
                url:"<?php echo U('importDisburse');?>",
                type:'post',
                data:importData,
                processData: false,
                contentType: false,
                success:function(d){
                    var result = eval("("+d+")");
                    if(result['flag'] == 1){
                        alert(result['msg']);
                        window.location.reload();
                    }else{
                        alert(result['msg']);
                    }
                }
            })
        })

        //排序
        $('.head a').click(function(){
            var type= $(this).attr('type');
            var order ='<?php echo ($_GET['order']); ?>';
            var get_type = '<?php echo ($_GET['type']); ?>';
            if(order=='' || type != get_type){
                order ='asc';
            }else if(order=='asc' && type==get_type){
                order ='desc';
            }else if(order=='desc' && type==get_type){
                order ='asc';
            }
            $('#quickForm input[name="type"]').val(type);
            $('#quickForm input[name="order"]').val(order);
            $('#quickForm').submit();
        });


        //添加推广支出 
        $('.add').click(function () {
            document.getElementById('addForm').reset();//清空表单
            $('#add').modal();
        });

        //提交添加推广支出 表单
        $('#addForm').bind('valid.form', function () {
            $('#add').modal('hide');
            $.ajax({
        		url: "<?php echo U('addDisburse');?>",
        		type: "POST",
        		data: $(this).serialize(),
        		success: function(d) {
                    var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        alert(result.msg);
                        window.location.reload();//刷新当前页面.
                    } else {
                        alert(result.msg);
                    }
                }
            });
        });

        //添加操作时间失去焦点事件
        $('.add-time').blur(function(){
            var addtime = $('#addForm')
            getOrderNum(addtime);
        });
        //添加操作省份改变事件
        $('#addForm select[name="province_id"]').change(function(){
            var addtime = $('#addForm')
            getOrderNum(addtime);
        });

        //修改操作时间失去焦点事件
        $('.edit-time').blur(function(){
            var edittime = $('#editForm')
            getOrderNum(edittime);
            
        });
        //修改操作省份改变事件
        $('#editForm select[name="province_id"]').change(function(){
            var editPro = $('#editForm')
            getOrderNum(editPro);
            
        });
        //失去焦点获取预约量和成交量
        function getOrderNum(pro){
            var start_time = pro.find('input[name="start_time"]').val();
            var end_time = pro.find('input[name="end_time"]').val();
            var region = pro.find('select[name="province_id"] option:selected').val();
            if(region>0){
                $.ajax({
                    url:"<?php echo U(getOrderNum);?>",
                    type:"post",
                    dataType:'json',
                    //async:false,
                    data:{start_time:start_time,end_time:end_time,region:region},
                    success:function(d){
                        pro.find('input[name="reservation"]').val(d.default);
                        pro.find('input[name="deal"]').val(d.success);
                        blur(pro);
                    }
                })
            }
        }

        //添加失去焦点事件
        $('.add-price').blur(function(){
            var addPro = $('#addForm');
            blur(addPro);
        });

        //修改时失去焦点事件
        $('.edit-blur').blur(function(){
            var editPro = $('#editForm');
            blur(editPro);
        });

        //失去焦点计算的公共方法
        function blur(pro){
            var consume = pro.find('input[name="consume"]').val();
            var hit = pro.find('input[name="hit"]').val();
            var show = pro.find('input[name="show"]').val();
            var reservation = pro.find('input[name="reservation"]').val();
            //点击价格(消费/点击量)
            if(consume.length>0 && hit.length>0){
                if(consume==0 || hit==0){
                    pro.find('input[name="average_click_price"]').val(0);
                }else{
                    var average_click_price = consume / hit;
                    average_click_price = average_click_price.toFixed(2);//四舍五入保留两位小数
                    pro.find('input[name="average_click_price"]').val(average_click_price);
                }
            }else{
                pro.find('input[name="average_click_price"]').val('');
            }

            //点击率(点击量/展现量)
            if(show.length>0 && hit.length>0){
                if(show==0 || hit==0){
                    pro.find('input[name="click_rate"]').val(0);
                }else{
                    var click_rate = hit / show;
                    click_rate = click_rate.toFixed(4);
                    pro.find('input[name="click_rate"]').val(click_rate);
                }
            }else{
                pro.find('input[name="click_rate"]').val('');
            }

            //平均成本
            if(reservation.length>0 && consume.length>0){
                if(reservation==0 || consume==0){
                    pro.find('input[name="cost"]').val(0);
                }else{
                    var cost = consume / reservation;
                    cost = cost.toFixed(2);
                    pro.find('input[name="cost"]').val(cost);
                }
            }else{
                pro.find('input[name="cost"]').val('');
            }
        }

        //修改推广支出信息
        $('.edit').click(function () {
            var id = $(this).attr('data-id');
            var status = $('#editForm input[name="status"]');
            $.ajax({
                url: "<?php echo U('editDisbures');?>",
                type: 'get',
                data:{
                    id:id,
                },
                success: function (d) {
                    var result = eval("(" + d + ")");
                    var data = result.data;
                    if (result.flag == 1) {
                        $('#editForm select[name="category_id"] option[value="'+data.category_id+'"]').attr("selected","selected");
                        $('#editForm input[name="start_time"]').val(data.start_time);
                        $('#editForm input[name="end_time"]').val(data.end_time);
                        $('#editForm select[name="province_id"]').val(data.province_id);
                        $('#editForm input[name="consume"]').val(data.consume);
                        $('#editForm input[name="show"]').val(data.show);
                        $('#editForm input[name="average_click_price"]').val(data.average_click_price);
                        $('#editForm input[name="hit"]').val(data.hit);
                        $('#editForm input[name="click_rate"]').val(data.click_rate);
                        $('#editForm input[name="reservation"]').val(data.reservation);
                        $('#editForm input[name="cost"]').val(data.cost);
                        $('#editForm input[name="deal"]').val(data.deal);

                        for (var i = 0; i < status.length; i++) {
                            if(status[i].value == data['status']){
                                status[i].checked = true;
                                break;
                            }
                        }

                        $('#editForm input[name="id"]').val(data.id);
                        $('#edit').modal();
                    } else {
                        alert('操作失败');
                    }
                }
            });
        });

        //提交修改推广支出的表单
        $('#editForm').bind('valid.form', function () {
            $('#edit').modal('hide');
            $.ajax({
                url: "<?php echo U('editDisbures');?>",
                type: "POST",
                data: $(this).serialize(),
                success: function (d) {
                    var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        alert('修改成功');
                        window.location.reload();//刷新当前页面.
                    } else {
                        alert('修改失败');
                    }
                }
            });
        });

        //禁用
        $('.del').click(function () {
            var id = $(this).attr('data-delId');
            var act = 'del';
            $.ajax({
                url: "<?php echo U('delDisburse');?>",
                type: 'post',
                data: {
                    id:id,
                    act:act
                },
                success: function (d) {
                    var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        alert(result.msg);
                        window.location.reload();
                    } else {
                        alert(result.msg);
                    }
                }
            });
        });

        //启用
        $('.enable').click(function () {
            var id = $(this).attr('data-delId');
            var act = 'enable';
            $.ajax({
                url: "<?php echo U('delDisburse');?>",
                type: 'post',
                data: {
                    id:id,
                    act:act
                },
                success: function (d) {
                    var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        alert(result.msg);
                        window.location.reload();
                    } else {
                        alert(result.msg);
                    }
                }
            });
        });

    </script>
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>