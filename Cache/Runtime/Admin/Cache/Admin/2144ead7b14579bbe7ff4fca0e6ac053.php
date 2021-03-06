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
                       
                        <li>
                            <a href="javasript:void(0)">未付款列表</a><span class="divider-last">&nbsp;</span>
                        </li>
                     
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
                                <h4><i class="icon-reorder"></i>未付款列表</h4>
                            </div>
                            <div class="widget-body">
                                <form id="quickForm" method="get" class="form-horizontal" autocomplete="off" action="/system.php/Financial/nonPayment.html">搜索：
                                    <input type="text" name="application_sn" class="input-large" placeholder="申请单号" value="<?php echo ($_GET['application_sn']); ?>"/>
                                    <input type="text" name="service_goods_name" class="input-large" placeholder="商品名称" value="<?php echo ($_GET['service_goods_name']); ?>"/>
                                    <button class="btn btn-primary">确定</button>
                                </form>
                                <table class="table table-striped table-bordered" id="sample_1">
                                    <thead>
                                    <tr>
                                        <th class="hidden-phone">申请单号</th>
                                        <th class="hidden-phone">商品编号</th>
                                        <th class="hidden-phone">商品名称</th>
                                        <th class="hidden-phone">总金额</th>
                                        <th class="hidden-phone">应付金额</th>
                                        <th class="hidden-phone">已付金额</th>
                                        <th class="hidden-phone">欠款金额</th>
                                        <th class="hidden-phone">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($nonPayList)): $i = 0; $__LIST__ = $nonPayList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="odd gradeX">
                                            <td><?php echo ($vo["application_sn"]); ?></td>
                                            <td><?php echo ($vo["skuid"]); ?></td>
                                            <td><?php echo ($vo["service_goods_name"]); ?></td>
                                            <td><?php echo ($vo["total_price"]); ?></td>
                                            <td><?php echo ($vo["payable"]); ?></td>
                                            <td><?php echo ($vo["payment_been"]); ?></td>
                                            <td><?php echo ($vo["arrears"]); ?></td>
                                            <td>
                                                <button  class="btn btn-small btn-primary opCat fukuan" data-id='<?php echo ($vo["id"]); ?>'>
                                                    <i class=""> </i>付款
                                                </button>
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
<!--模态化弹框支付金额-->
<div id="updateContact" class="modal hide fade in" style="display: none; ">
    <form  id="data-form" method="post" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" >
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3>支付金额</h3>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-hover">
                <tbody>   
                <tr>
                    <td>申请单:</td>
                    <td>
                        <input type="text" class="input-xlarge" name="info[application_sn]" value="" readonly="readonly">
                    </td>
                </tr>
                <tr>
                    <td>商品名称:</td>
                    <td>
                        <input type="text" name="info[service_goods_name]" placeholder="商品名称" class="input-xlarge" value="" readonly="readonly"/>
                    </td>
                </tr>
                <tr>
                    <td> 总金额:</td>
                    <td>
                        <input type="text" name="info[total_price]" placeholder="总金额" class="input-xlarge" value="" readonly="readonly"/>
                    </td>
                </tr>
                <tr>
                    <td>应付金额:</td>
                    <td>
                        <input type="text" name="info[payable]" placeholder="应付金额" class="input-xlarge" value="" readonly="readonly"/>
                    </td>
                </tr>
                <tr>
                    <td>已付金额:</td>
                    <td>
                        <input type="text" name="info[payment_been]"  class="input-xlarge" value="" readonly="readonly"/>
                    </td>
                </tr>
                <tr>
                    <td>欠款金额:</td>
                    <td>
                        <input type="text" name="info[arrears]" class="input-xlarge" value="" readonly="readonly"/>
                    </td>
                </tr>
                <tr>
                    <td>本次实付:</td>
                    <td>
                        <input type="text" name="info[payment]" placeholder="本次实付" class="input-xlarge" value="" data-rule='required'/>
                    </td>
                </tr>
                <tr>
                    <td>付款时间:</td>
                    <td>
                        <input size="16" type="text" name="info[pay_time]" value="<?php echo date('Y-m-d H:i:s');?>"  onClick="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss'})" class="Wdate input-medium"> 
                    </td>
                </tr>
                <tr>
                    <td>收款方:</td>
                    <td>
                        <input type="text" name="info[recipient]" placeholder="收款方" class="input-xlarge" value="" data-rule='required'/>
                    </td>
                </tr>
                <tr>
                    <td>状态:</td>
                    <td>
                        <select class="input-medium m-wrap" tabindex="1" name="info[status]" data-rule='required'>
                            <option value="">---请选择---</option>
                            <?php if(is_array(C("FINANCIAL_STATUS"))): $i = 0; $__LIST__ = C("FINANCIAL_STATUS");if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?> 
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>备注:</td>
                    <td>
                        <textarea class="span3" rows="2"  name="info[remark]" style="margin-top: 0px; margin-bottom: 10px; height: 100px;"></textarea>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
        <input type='hidden' name='financialId' value=''>
        <button type="submit" class="btn btn-success">提交</button>
            <a href="#" class="btn" data-dismiss="modal">关闭</a>
        </div>
    </form>
<!-- BEGIN FOOTER -->

<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS -->
<!-- Load javascripts at bottom, this will reduce page load time -->
<script src="<?php echo (JS_URL); ?>jquery-1.8.3.min.js"></script>
<script src="<?php echo (ASSETS_URL); ?>bootstrap/js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo (JS_URL); ?>My97DatePicker/WdatePicker.js"></script>
<script src="<?php echo (JS_URL); ?>jquery.validator.js"></script>
<script src="<?php echo (JS_URL); ?>scripts.js"></script>
<script>
    //点击付款弹出摸态框
    $('.fukuan').click(function(){
        var id = $(this).attr('data-id');
        $.ajax({
            url:"<?php echo U(checkFinancial);?>",
            type:'post',
            data:{id:id},
            dataType:'json',
            success:function(e){
                if(e){
                    $('input[name="info[application_sn]"]').val(e['application_sn']);
                    $('input[name="info[service_goods_name]"]').val(e['service_goods_name']);
                    $('input[name="info[total_price]"]').val(e['total_price']);
                    $('input[name="info[payable]"]').val(e['payable']);
                    $('input[name="info[payment_been]"]').val(e['payment_been']);
                    $('input[name="info[arrears]"]').val(e['arrears']);
                    $('input[name="financialId"]').val(id);
                    $('input[name="recipient"]').val(e['recipient']);
                    $('#updateContact').modal();  
                }
            }
        })
    });

    //表单提交
    $('#data-form').bind('valid.form',function(){
        $.ajax({
            url:"<?php echo U(addFinancial);?>",
            type:'post',
            data:$(this).serialize(),
            dataType:'json',
            success:function(e){
                if(e.flag){
                    alert(e.msg);
                    window.location.reload();//刷新当前页面.
                }else{
                    alert(e.msg);
                }
            }
        })
    });


</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>