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
        <style type="text/css">
            .widget-tabs .nav-tabs > li{
                float: left;
            }
            .noborder{
                border: none;
            }
            .noborder td{
                border: none;
            }
            .noborder a{
                margin-left: 8px;
            }
        </style>
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
                            <li>
                                <a href="<?php echo U('index');?>">部门管理</a> <span class="divider">&nbsp;</span>
                            </li>
                            <li><a href="javascript:void(0)"><?php echo ($rolename); ?>——职位权限分配</a><span class="divider-last">&nbsp;</span></li>

                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <div id="page">
                    <div class="row-fluid ">
                        <div class="span12">
                            <!-- BEGIN TAB PORTLET-->   
                            <div class="widget widget-tabs">
                                <div class="widget-title">

                                </div>
                                <form id="defaultForm" action='/system.php/Position/privilegeset/id/13.html' method="post" class="form-horizontal" autocomplete="off">
                                    <input name="id" type="hidden" value="<?php echo ($_GET['id']); ?>">
                                    <div class="widget-body">
                                        <div class="tabbable portlet-tabs">
                                            <ul class="nav nav-tabs" style='float: left;'>
                                                <?php if(is_array($first_privilege)): $k = 0; $__LIST__ = $first_privilege;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li <?php if($k == 1): ?>class="active"<?php endif; ?>><a href="#node-<?php echo ($vo["id"]); ?>" data-toggle="tab"><?php echo ($vo["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </ul>
                                            <div class='clearfix'></div>
                                            <div class="tab-content">
                                                <?php if(is_array($privilegeTree)): $k = 0; $__LIST__ = $privilegeTree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><div class='tab-pane <?php if($k == 1): ?>active<?php endif; ?>' id="node-<?php echo ($v["id"]); ?>">
                                                        <table class="table table-condensed table-hover table-bordered" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th width="15%"><input type="checkbox" name="rules[]" value="<?= $v['id'] ?>"  class="rule-chkall" <?php if(in_array($v['id'], $role)):?> checked="checked" <?php endif;?> /><?php echo ($v[title]); ?></th>
                                                                    <th><span>菜单</span> <span style="margin-left: 20%;">操作</span></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($v['child'] as $one): ?>
                                                                <tr>
                                                                    <td class="one-<?php echo ($v['id']); ?>">
                                                                        <input type="checkbox" name="rules[]" class="level1" data-node="<?= $v['id']?>" value="<?= $one['id'] ?>" <?php if(in_array($one['id'], $role)):?> checked="checked" <?php endif;?>> <?php echo ($one["title"]); ?>
                                                                    </td>
                                                                    <td>
                                                                        <table width="100%" class="noborder child-<?php echo ($one['id']); ?>">
                                                                            <?php if(is_array($one['child'])): $i = 0; $__LIST__ = $one['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$two): $mod = ($i % 2 );++$i;?><tr>
                                                                                    <td height=30 width="20%" class="two-<?php echo ($one['id']); ?>">
                                                                                        <input type="checkbox" name="rules[]" data-pid="<?php echo ($one['id']); ?>"  data-node="<?php echo ($v['id']); ?>" class="level2"  value="<?php echo ($two['id']); ?>" <?php if(in_array($two['id'], $role)):?> checked="checked" <?php endif;?>> <?php echo ($two["title"]); ?>
                                                                                    </td>
                                                                                    <td class="three-<?php echo ($two['id']); ?>">
                                                                                <?php if(is_array($two['child'])): $i = 0; $__LIST__ = $two['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$three): $mod = ($i % 2 );++$i;?><input type="checkbox" name="rules[]" data-pid="<?php echo ($two['id']); ?>" data-ppid="<?php echo ($one['id']); ?>"  data-node="<?php echo ($v['id']); ?>" class="level3" value="<?php echo ($three['id']); ?>" <?php if(in_array($three['id'], $role)):?> checked="checked" <?php endif;?>> <?php echo ($three["title"]); endforeach; endif; else: echo "" ;endif; ?>
                                                                                </td>
                                                                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">提交</button>
                            </div>
                            </form>
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


    <script src="<?php echo (JS_URL); ?>scripts.js"></script>
    <script>
        $(function () {
            //(顶级)一级菜单 
            $('.rule-chkall').die().bind('click', function (e) {
                if (!$(this).is(':checked')) {
                    $('#node-' + $(this).val() + ' input[type="checkbox"]').attr('checked', false);
                } else {
                    $('#node-' + $(this).val() + ' input[type="checkbox"]').attr("checked", true);
                }
            });
            //二级菜单
            $('.level1').die().bind('click', function (e) {
                var id = $(this).val();
                var node = $(this).attr('data-node');
                if ($(this).is(':checked')) {
                    $('.child-' + id + ' input[type="checkbox"]').attr('checked', true);
                    $('#node-' + node + ' input[value="' + node + '"]').attr('checked', true);
                } else {
                    $('.child-' + id + ' input[type="checkbox"]').attr('checked', false);
                    if (isChecked('one-' + node)) {
                        $('#node-' + node + ' input[value="' + node + '"]').attr('checked', false);
                    }
                }
            });
            //二级菜单
            $('.level2').die().bind('click', function (e) {
                var id = $(this).val();
                var node = $(this).attr('data-node');
                var pid = $(this).attr('data-pid');
                if ($(this).is(':checked')) {
                    $('input[data-pid="' + id + '"]').attr('checked', true);
                    $('input[value="' + node + '"]').attr('checked', true);
                    $('input[value="' + pid + '"]').attr('checked', true);
                } else {
                    $('input[data-pid="' + id + '"]').attr('checked', false);
                    if (isChecked('two-' + pid)) {
                        $('input[value="' + pid + '"]').attr('checked', false);
                        if (isChecked('one-' + node)) {
                            $('input[value="' + node + '"]').attr('checked', false);
                        }
                    }
                }
            });

            $('.level3').die().bind('click', function (e) {
                var node = $(this).attr('data-node');
                var pid = $(this).attr('data-pid');
                var ppid = $(this).attr('data-ppid');
                if ($(this).is(':checked')) {
                    $('input[value="' + ppid + '"]').attr('checked', true);
                    $('input[value="' + node + '"]').attr('checked', true);
                    $('input[value="' + pid + '"]').attr('checked', true);
                } 
                
            });

            function isChecked(cla) {
                var list = $('.' + cla + ' input[type="checkbox"]');
                var len = list.length;
                if (len > 0) {
                    for (var i = 0; i < len; i++) {
                        if ($(list[i]).is(':checked')) {
                            return false;
                        }
                    }
                }
                return true;
            }
        });
    </script>
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>