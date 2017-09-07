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
                        <li><a href="javascript:void(0)">关键词转化跟踪列表</a><span class="divider-last">&nbsp;</span></li>
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
                                <h4><i class="icon-reorder"></i>关键词转化跟踪</h4>
                                <?php if (showHandle('Opex/addConversion')){ ?>
                                    <span class="tools">
                                        <a href="javascript:void(0);" class="icon-plus add">添加记录</a>
                                    </span>
                                <?php } ?>
                                <span class="tools">
                                <?php if(showHandle('Opex/importConversion')) { ?>
                                    <a href="javascript:void(0);" class="icon-cog import" >导入数据</a>
                                </span>
                                <?php } if(showHandle('Opex/exportConversion')){ ?>
                                <span class="tools">
                                    <a class="icon-cog" href="<?php echo U('exportConversion');?>">导出数据</a>
                                </span> 
                                <?php } ?>
                            </div>
                            <div class="widget-body">
                                <form id="quickForm" method="get" class="form-horizontal" autocomplete="off" action='<?php echo U("Opex/conversion");?>'>
                                    <table>
                                        <tr>
                                            <td>搜索：&nbsp;</td>
                                            <td>
                                                时间：<input type="text" name="start_time" class="input-medium Wdate" onClick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" <?php if(!empty($_GET['start_time'])): ?>value="<?php echo ($_GET['start_time']); ?>"<?php else: endif; ?>/>-
                                                <input type="text" name="end_time" class="input-medium Wdate" onClick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" <?php if(!empty($_GET['end_time'])): ?>value="<?php echo ($_GET['end_time']); ?>" <?php else: endif; ?>/>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary">确定</button>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="8%">时间</th>
                                            <th width="6%">星期</th>
                                            <th width="15%">预约陵园名称</th>
                                            <th width="7%">来源类型</th>
                                            <th width="7%">搜索引擎</th>
                                            <th width="15%">来源</th>
                                            <th width="10%">搜索词</th>
                                            <th width="12%">关键词</th>
                                            <th width="6%">是否同地区</th>
                                            <th width="6%">用户地区</th>
                                            <th width="8%">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="odd gradeX">
                                            <td>
                                                <?php if(!empty($vo["time"])): echo (date("Y-m-d",$vo["time"])); endif; ?>
                                            </td>
                                            <td><?php echo ($vo["week"]); ?></td>
                                            <td><?php echo ($vo["cemetery_name"]); ?></td>
                                            <td>
                                                <?php echo (C("SOURCE_TYPE.$vo[type]")); ?>
                                            </td>
                                            <td><?php echo ($vo["search_engine"]); ?></td>
                                            <td><?php echo ($vo["source"]); ?></td>
                                            <td><?php echo ($vo["search_term"]); ?></td>
                                            <td><?php echo ($vo["keywords"]); ?></td>
                                            <td>
                                                <?php if($vo["user_region_same"] == 1): ?>是
                                                <?php elseif($vo["user_region_same"] == 2): ?>
                                                    否<?php endif; ?>
                                            </td>
                                            <td><?php echo ($vo["user_region"]); ?></td>
                                            <td>
                                            <?php if (showHandle('Opex/editConversion')) { ?>
                                                <a class="btn btn-small btn-primary edit"  href="javascript:void(0)" data-id="<?php echo ($vo["id"]); ?>"><i class="icon-pencil icon-white"> </i>编辑</a>
                                            <?php } if (showHandle('Opex/delConversion')) { ?>
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

<!--添加开始-->
<div id="add" class="modal hide fade in">
    <form id="addForm" method="post" class="form-horizontal" autocomplete="off">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3>添加记录</h3>
        </div>
        <div class="modal-body" >
            <table class="table table-bordered table-hover">
                <tbody>
                    <tr>
                        <td>时间：</td>
                        <td><input class="input Wdate" onClick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" value="<?php echo date('Y-m-d');?>" name="time" type="text" data-rule="required" >
                        </td>
                    </tr>
                    <tr>
                        <td>预约陵园名称：</td>
                        <td><input class="input"  name="cemetery_name" type="text" data-rule="required" class="amount">
                        </td>
                    </tr>
                    <tr>
                        <td>来源类型：</td>
                        <td>
                            <select name="type" id="categoryChang">
                                <option value="0">--请选择--</option>
                                <?php if(is_array(C("SOURCE_TYPE"))): $i = 0; $__LIST__ = C("SOURCE_TYPE");if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mu): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($mu); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>搜索引擎：</td>
                        <td><input class="input"  name="search_engine" type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>来源：</td>
                        <td><input class="input"  name="source" type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>搜索词：</td>
                        <td><input class="input"  name="search_term" type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>关键词：</td>
                        <td><input class="input"  name="keywords" type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>是否同地区：</td>
                        <td>
                            <input type="radio" name="user_region_same" value="1">是
                            <input type="radio" name="user_region_same" value="2" checked>否
                        </td>
                    </tr>
                    <tr>
                        <td>用户所在地区:</td>
                        <td>
                            <select name="user_region" id="categoryChang">
                                <option value="0">--请选择--</option>
                                <?php if(is_array($region)): $i = 0; $__LIST__ = $region;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>状态：</td>
                        <td>
                            <input type="radio" name="status" value="<?php echo (C("NORMAL_STATUS")); ?>" checked>正常
                            <input type="radio" name="status" value="<?php echo (C("DELETE_STATUS")); ?>">删除
                        </td>
                    </tr>
                    <tr>
                        <td>备注：</td>
                        <td><textarea name="remark"></textarea></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="submit"  class="btn btn-success">提交</button>
            <a href="#" class="btn" data-dismiss="modal">关闭</a>
        </div>
    </form>
</div>
<!--添加结束-->

<!--编辑开始-->
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
                        <td><input class="input Wdate" onClick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" value="<?php echo date('Y-m-d');?>" name="time" type="text" data-rule="required" >
                        </td>
                    </tr>
                    <tr>
                        <td>预约陵园名称：</td>
                        <td><input class="input"  name="cemetery_name" type="text" data-rule="required" class="amount">
                        </td>
                    </tr>
                    <tr>
                        <td>来源类型：</td>
                        <td>
                            <select name="type" id="categoryChang">
                                <option value="0">--请选择--</option>
                                <?php if(is_array(C("SOURCE_TYPE"))): $i = 0; $__LIST__ = C("SOURCE_TYPE");if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mu): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($mu); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>搜索引擎：</td>
                        <td><input class="input"  name="search_engine" type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>来源：</td>
                        <td><input class="input"  name="source" type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>搜索词：</td>
                        <td><input class="input"  name="search_term" type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>关键词：</td>
                        <td><input class="input"  name="keywords" type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>是否同地区：</td>
                        <td>
                            <input type="radio" name="user_region_same" value="1">是
                            <input type="radio" name="user_region_same" value="2" checked>否
                        </td>
                    </tr>
                    <tr>
                        <td>用户所在地区:</td>
                        <td>
                            <select name="user_region" id="categoryChang">
                                <option value="0">--请选择--</option>
                                <?php if(is_array($region)): $i = 0; $__LIST__ = $region;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>状态：</td>
                        <td>
                            <input type="radio" name="status" value="<?php echo (C("NORMAL_STATUS")); ?>" checked>正常
                            <input type="radio" name="status" value="<?php echo (C("DELETE_STATUS")); ?>">删除
                        </td>
                    </tr>
                    <tr>
                        <td>备注：</td>
                        <td><textarea name="remark"></textarea></td>
                    </tr>
                </tbody>
            </table>

        </div>
        <div class="modal-footer">
            <input type="hidden" name='id' /> 
            <button type="submit" class="btn btn-success">提交</button>
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
                                <input type="file" name="excel_file">
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
<!--编辑结束-->

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
            url:"<?php echo U('importConversion');?>",
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

    //添加关键字转化 
    $('.add').click(function () {
        document.getElementById('addForm').reset();//清空表单
        $('#add').modal();
        
    });
    
    //提交添加关键词转化 表单
    $('#addForm').bind('valid.form', function () {
        $('#add').modal('hide');
        $.ajax({
            url: "<?php echo U('addConversion');?>",
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

    //修改关键词转化 表单
    $('.edit').click(function () {
        var id = $(this).attr('data-id');
        var same = $('#editForm input[name="user_region_same"]');
        var status = $('#editForm input[name="status"]');
        $.ajax({
            url: "<?php echo U('editConversion');?>",
            type: 'get',
            data:{
                id:id,
            },
            success: function (d) {
                var result = eval("(" + d + ")");
                var data = result.msg;
                if (result.flag == 1) {
                    $('#editForm input[name="time"]').val(data.time);
                    $('#editForm input[name="cemetery_name"]').val(data.cemetery_name);
                    $('#editForm select[name="type"] option[value="'+data.type+'"]').attr("selected","selected");
                    $('#editForm input[name="search_engine"]').val(data.search_engine);
                    $('#editForm input[name="source"]').val(data.source);
                    $('#editForm input[name="search_term"]').val(data.search_term);
                    $('#editForm input[name="keywords"]').val(data.keywords);
                    $('#editForm select[name="user_region"] option[value="'+data.user_region+'"]').attr("selected","selected");
                    $('#editForm input[name="remark"]').val(data.remark);
                    $('#editForm input[name="id"]').val(id);
                    for(var i=0; i<same.length; i++){
                        if(same[i].value == data['user_region_same']){
                            same[i].checked = true;
                            break;
                        }
                    }
                    for (var i = 0; i < status.length; i++) {
                            if(status[i].value == data['status']){
                                status[i].checked = true;
                                break;
                            }
                        }
                    $('#edit').modal();
                } else {
                    alert('操作失败');
                }
            }
        });
    });

    //提交修改专题的表单
    $('#editForm').bind('valid.form', function () {
        $('#edit').modal('hide');
        $.ajax({
            url: "<?php echo U('editConversion');?>",
            type: "POST",
            data: $(this).serialize(),
            success: function (d) {
                var result = eval("(" + d + ")");
                console.log(result);
                if (result.flag == 1) {
                    alert(result.msg);
                    window.location.reload();//刷新当前页面.
                } else {
                    alert(result.msg);
                }
            }
        });
    });

    //禁用
        $('.del').click(function () {
            var id = $(this).attr('data-delId');
            var act = 'del';
            $.ajax({
                url: "<?php echo U('delConversion');?>",
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
                url: "<?php echo U('delConversion');?>",
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