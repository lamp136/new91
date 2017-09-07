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
                            <li><a href="javascript:void(0)">广告管理</a><span class="divider-last">&nbsp;</span></li>

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
                                    <h4><i class="icon-reorder"></i>广告管理</h4>
                                    <?php if(showHandle('AdBanner/add')){ ?>
                                        <span class="tools">
                                            <a href="<?php echo U('add');?>" class="icon-plus" >添加广告</a>
                                        </span>
                                    <?php } ?>
                                </div>
                                <div class="widget-body">
                                    <div class="control-group">
                                        <div class="controls">
                                            <form action="<?php echo U('/AdBanner/index');?>" method="get" class="form-horizontal">
                                                <select class="input-medium" tabindex="1" name="advertising_position_id">
                                                    <option value="0">请选择</option>
                                                    <?php if(is_array($adpos)): $i = 0; $__LIST__ = $adpos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($getSearch['advertising_position_id'] == $vo['id']): ?><option value="<?php echo ($vo["id"]); ?>" selected="selected"><?php echo ($vo["position_name"]); ?></option>
                                                        <?php else: ?>
                                                            <option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["position_name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                                </select>
                                                <select class="input-small m-wrap" tabindex="1" name="province_id">
                                                    <option value="0">请选择</option>
                                                    <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($getSearch['province_id'] == $vo['region_id']): ?><option value="<?php echo ($vo["region_id"]); ?>" selected="selected"><?php echo ($vo["region_name"]); ?></option>
                                                        <?php else: ?>
                                                            <option value="<?php echo ($vo["region_id"]); ?>"><?php echo ($vo["region_name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                                </select>
                                                <button class="btn btn-primary"><i class="icon-pencil icon-white"></i> 搜索</button> 
                                            </form>
                                        </div>
                                    </div>

                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>省份</th>
                                                <th>广告位置</th>
                                                <th>广告名称</th>
                                                <th>图片</th>
                                                <th>链接地址</th>
                                                <th>开始时间</th>
                                                <th>结束时间</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="odd gradeX">
                                                <td><?php echo ($vo["Province"]["region_name"]); ?></td>
                                                <td><?php echo ($vo["Adpos"]["position_name"]); ?></td>
                                                <td><?php echo ($vo["banner_name"]); ?></td>
                                                <td><img src="/<?php echo (C("ROOT_PATH")); echo ($vo["banner_url"]); ?>" width="130" /></td>
                                                <td><?php echo ($vo["banner_link"]); ?></td>
                                                <td><?php if(($vo["start_time"]) != "0"): echo (date('Y-m-d',$vo["start_time"])); endif; ?></td>
                                                <td><?php if(($vo["end_time"]) != "0"): echo (date('Y-m-d',$vo["end_time"])); endif; ?></td>
                                                <td>
                                                    <?php if(showHandle('AdBanner/edit')){ ?>
                                                        <a class="btn btn-small"  href="<?php echo U('edit',array('id'=>$vo['banner_id'],'p'=>I('get.p')));?>" ><i class="icon-pencil icon-white"> </i>编辑信息</a>
                                                    <?php } if(showHandle('AdBanner/delete')){ ?>
                                                        <?php if(($vo["status"]) == C("NORMAL_STATUS")): ?><a class="btn btn-danger btn-small del" href="javascript:void(0)" data-id="<?php echo ($vo["banner_id"]); ?>" ><i class="icon-remove  icon-white"> </i>下线</a>
                                                        <?php else: ?>
                                                            <a class="btn btn-success btn-small enable" href="javascript:void(0)" data-id="<?php echo ($vo["banner_id"]); ?>" ><i class="icon-ok  icon-white"> </i>上线</a><?php endif; ?>
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
    <script src="<?php echo (ASSETS_URL); ?>jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="<?php echo (ASSETS_URL); ?>bootstrap/js/bootstrap.min.js"></script>

    <script src="<?php echo (JS_URL); ?>scripts.js"></script>
    <script>
        //启用
        $('.enable').click(function () {
            var id = $(this).attr('data-id');
            var act = 'enable';
            $.ajax({
                url: "<?php echo U('delete');?>",
                type: 'post',
                data: 'id=' + id + '&act=' + act,
                success: function (d) {
                    var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        // alert(result.msg);
                        window.location.reload();
                    }/* else {
                        alert(result.msg);
                    }*/
                }
            });
        });
        
        //下线
        $('.del').click(function () {
            var id = $(this).attr('data-id');
            var act = 'del';
            $.ajax({
                url: "<?php echo U('delete');?>",
                type: 'post',
                data: 'id=' + id + '&act=' + act,
                success: function (d) {
                    var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        // alert(result.msg);
                        window.location.reload();
                    }/* else {
                        alert(result.msg);
                    }*/
                }
            });
        });

     
    </script>
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>