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
                            <li><a href="javascript:void(0)">完成的订单列表</a><span class="divider-last">&nbsp;</span></li>

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
                                    <h4><i class="icon-reorder"></i>完成的订单列表</h4>
                                </div>
                                <div class="widget-body">
                                    <form id="quickForm" method="get" class="form-horizontal" autocomplete="off" action='<?php echo U("finish");?>'>
                                    <table>
                                         <tr>
                                            <td>搜索：</td>
                                            <td>
                                                <input type="text" name="order_son_sn" class="input-medium" placeholder="子订单号" value="<?php echo ($_GET['order_son_sn']); ?>"/>
                                            </td>
                                             <td>
                                                <input type="text" name="store_name" class="input-medium" placeholder="商家名称" value="<?php echo ($_GET['store_name']); ?>"/>
                                            </td>
                                              <td>
                                                <input type="text" name="take_stock_people" class="input-medium" placeholder="提货人姓名" value="<?php echo ($_GET['take_stock_people']); ?>"/>
                                                
                                            </td>
                                            <td>
                                                <input type="text" name="take_stock_mobile" class="input-medium" placeholder="提货人电话" value="<?php echo ($_GET['take_stock_mobile']); ?>"/>
                                                
                                                <button class="btn btn-primary">确定</button>
                                            </td>
                                        </tr>
                                    </table>
                                    </form>
                                    <table class="table table-striped table-bordered" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th width="8%" class="hidden-phone">主订单号</th>
                                                <th width="8%" class="hidden-phone">子订单号</th>
                                                <th width="13%" class="hidden-phone">订单总额</th>
                                                <th width="8%" class="hidden-phone">优惠总额</th>
                                                <th width="12%" class="hidden-phone">下单人</th>
                                                <th width="12%" class="hidden-phone">下单人电话</th>
                                                <th width="5%" class="hidden-phone">下单时间</th>
                                                <th width="5%" class="hidden-phone">完成时间</th>
                                               
                                                <th width="13%" class="hidden-phone">操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="odd gradeX">
                                                <td class="hidden-phone" width="10%"><?php echo ($vo["order_main_sn"]); ?></td>
                                                <td class="hidden-phone" width="10%"><?php echo ($vo["order_son_sn"]); ?></td>
                                                <td class="hidden-phone" width="8%"><?php echo ($vo["total_price"]); ?></td>
                                                <td class="hidden-phone" width="8%"><?php echo ($vo["coupon_price"]); ?></td>
                                                <td class="hidden-phone" width="8%"><?php echo ($vo["main"]["member_name"]); ?></td>
                                                <td class="hidden-phone" width="8%"><?php echo ($vo["main"]["member_contact"]); ?></td>
                                                <td class="hidden-phone" width="10%"><?php echo (date("Y-m-d",$vo["order_service_time"])); ?></td>
                                                <td class="hidden-phone" width="10%"><?php echo (date("Y-m-d",$vo["actual_stock_time"])); ?></td>
                                                <td class="hidden-phone" width="28%">


                                                     <a class="btn btn-small btn-primary"  href="<?php echo U('details',array('ordersn'=>$vo['order_son_sn']));?>"><i class="icon-success icon-white"> </i> 查看详情</a>


                                                    <?php if($vo['status'] != C('SERVICE_ORDER_STATUS.STOP')): if(($vo["brokerage_money"]) != "0"): ?><a  class="btn btn-danger btn-small backorder" href="javascript:void(0)" data-orderId="<?php echo ($vo["order_son_sn"]); ?>"><i class="icon-remove icon-white"> </i>退单</a><?php endif; endif; ?>
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
    
    <!--填写退单信息开始-->
    <div id="backorder" class="modal hide fade in">
        <form id="backorderFrom" method="post" class="form-horizontal" autocomplete="off">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>退单信息</h3>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <td>佣金比例:</td>
                            <td><input  type="text" name="brokerage_percent" disabled></td> 
                        </tr>
                        <tr>
                            <td>佣金金额:</td>
                            <td><input  type="text" name="brokerage_money" disabled></td>
                        </tr>
                        <tr>
                            <td>实际金额:</td>
                            <td><input  type="text" name="paid_in_amount" disabled></td>
                        </tr>
                        <tr>
                            <td>返现客户金额:</td>
                            <td><input  type="text" name="return_money" disabled></td>
                        </tr>
                        
                        <tr>
                            <td>开户行:</td>
                            <td>
                                <select name="bank">
                                    <option value="0">--请选择-- </option>
                                    <?php if(is_array(C("PAY_TYPE"))): $i = 0; $__LIST__ = C("PAY_TYPE");if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$banks): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($banks); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>开户人:</td>
                            <td><input  type="text" name="bank_member" data-rule="required"></td>
                        </tr>
                        <tr>
                            <td>银行账号:</td>
                            <td><input  type="text" name="bank_account" data-rule="required"></td>
                        </tr>
                        
                        <tr>
                            <td>退还陵园金额:</td>
                            <td><input  type="text" name="back_money" data-rule="required"></td>
                        </tr>
                        <tr>
                            <td>退单原因:</td>
                            <td><textarea rows="3" name="back_reason" data-rule="required"></textarea></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <input type='hidden' name='profilesId'></input>
                <input type='hidden' name='id'></input>
                <button type="submit" class="btn btn-success">提交</button>
                <a href="#" class="btn" data-dismiss="modal">关闭</a>
            </div>
        </form>
    </div>
    <!--填写退单信息结束-->
      <!--模态化弹框 查看审核票据-->
    <div id="details" class="modal hide fade in" style="display: none; ">
        <form id="detailsForm" method="post"  class="form-horizontal form-item" autocomplete="off">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>查看详情</h3>
            </div>
            <div class="modal-body">
                <div class='orderbill-table'></div>
                <table class="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <td>订单号:</td>
                            <td>
                                <input type="text" id="total" name="order_son_sn" value="">
                            </td>
                        </tr>
                        <tr>
                            <td>商家:</td>
                            <td>
                                <input type="text" name="store_name" data-rule="required" value="">
                            </td>
                        </tr>
                        <tr>
                            <td>总金额</td>
                            <td>
                                <input type="text" name="total_price"  id="total_price">
                            </td>
                        </tr>
                         <tr>
                            <td>商品名称</td>
                            <td>
                                <input type="text" name="goods_name" readonly="readonly" value="" id="goods_name" >
                            </td>
                        </tr>
                         

                        <tr>
                            <td>商品单价</td>
                            <td>
                                <input type="text" name="goods_price"  id="goods_price" value="" readonly="readonly"> 
                            </td>
                        </tr>
                        <!-- <tr  id="client_cash"> -->

                    
                        <tr>
                            <td>商品数量</td>
                            <td>
                                <input type="text" id="goods_num"   readonly="readonly"  value=""  name="number"/>
                            </td>
                        </tr>
                        
                        

                        <tr>
                            <td>商品总额</td>
                            <td>
                                <input type="text" name="price" value="">
                            </td>
                        </tr>
                        <tr >
                            <td>提货人:</td>
                            <td>
                                <input type="text" name="take_stock_people" value="">
                            </td>
                        </tr>
                        <tr >
                            <td>提货时间:</td>
                            <td>
                                <input type="text" name="take_stock_time" value="">
                            </td>
                        </tr>
                        <tr >
                            <td>确认人:</td>
                            <td>
                                <input type="text" name="feedback_member_name" value="">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
           
        </form>
    </div>
    <!--模态框结束 查看审核票据-->

 
       
   <!--添加跟踪信息结开始-->
    <div id="addorderfollowform" class="modal hide fade in">
        <form id="defaultForm" method="post" class="form-horizontal" autocomplete="off">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>添加跟踪信息</h3>
            </div>
            <div class="modal-body">

                <table class="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <td>沟通对象:</td>
                            <td><input name="type" value="1" checked="checked" type="radio" class="client"> 客户 
                                <input name="type" value="2" type="radio"> 商家
                            </td>
                        </tr>
                        <tr>
                            <td>沟通问题:</td>
                            <td>
                                <textarea rows="3" id='question'  name="question" class="input-xlarge" data-rule="required"></textarea>
                            </td>
                        </tr>
                     
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <input type='hidden' id='orderid' name='orderid'>
                <input type='hidden' id='member_id' name='member_id'>
                <input type='hidden' id='ordersn' name='ordersn'>
                <button type="submit" id='tijiao' class="btn btn-success">提交</button>
                <a href="#" class="btn" data-dismiss="modal">关闭</a>
            </div>
        </form>
    </div>
    <!--添加跟踪信息结束-->

   <!--查看跟踪信息结开始-->
    <div id="orderfollowform" class="modal hide fade in" style="width:45%;">
        <form id="lookdefaultForm" method="post" class="form-horizontal" autocomplete="off">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>查看跟踪信息</h3>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover">
                     <thead>
                            <tr class="data-message">
                                 <th style=" width:20%;" >时间</th>
                                <th style=" width:10%;" class="hidden-phone">对象</th>
                                <th style=" width:70%;" class="hidden-phone">问题</th>
                            </tr>
                     </thead>
                </table>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">关闭</a>
            </div>
        </form>
    </div>
    <!--查看跟踪信息结束-->
    
 
    
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
    <script type="text/javascript" src="<?php echo (ASSETS_URL); ?>chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
    <script src="<?php echo (JS_URL); ?>jquery.validator.js"></script>
    <script src="<?php echo (JS_URL); ?>zh-CN.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo (JS_URL); ?>My97DatePicker/WdatePicker.js"></script>
    <script src="<?php echo (JS_URL); ?>scripts.js"></script>
    <script type="text/javascript">
     
      
        
        //将申请发送给财务
        $('.sendtofinance').click(function () {
            var r=confirm("确认要将订单推送给财务进行返现吗？");
            if(r==true){
                var orderId = $(this).attr('data-orderId');
                $.ajax({
                    url: "<?php echo U('appointsendtofinance');?>",
                    type: 'POST',
                    data: 'orderId=' + orderId,
                    success: function (d) {
                        var result = eval("(" + d + ")");
                        if (result.flag == 1) {
                            alert(result.msg);
                            window.location.reload();//刷新当前页面.
                        } else {
                            alert(result.msg);
                        }
                    }
                });
            }
        });
        
        //退单操作
        $(".backorder").click(function(){
            var orderId = $(this).attr('data-orderid');
            var ret = confirm("你确认要退单么？");
            if(ret) {
                $.ajax({
                    url:'/system.php/OrderGrave/singleBack/id/' + orderId,
                    type:'get',
                    success:function(msg){
                        var result = eval("(" + msg + ")");
                        if(result.flag == 2 ){
                            var data = result.data;
                            $('#backorderFrom input[name="brokerage_percent"]').val(data['brokerage_percent']+'%');
                            $('#backorderFrom input[name="brokerage_money"]').val(data['brokerage_money']);
                            $('#backorderFrom input[name="paid_in_amount"]').val(data['paid_in_amount']);
                            $('#backorderFrom input[name="return_money"]').val(data['return_money']);
                            $('#backorderFrom textarea[name="back_reason"]').val(data['back_reason']);
                            $('#backorderFrom input[name="id"]').val(orderId);
                            //银行信息
                            $('#backorderFrom input[name="bank_account"]').val(data['bank_account']);
                            $('#backorderFrom input[name="bank_member"]').val(data['bank_member']);
                            $('#backorderFrom select[name="bank"]').find('option[value='+data['bank']+']').attr("selected",true);
                            $('#backorderFrom input[name="profilesId"]').val(data['profilesId']);
                            $('#backorder').modal();
                        }else{
                            alert(result.msg);
                            window.location.reload();//刷新当前页面.
                        }
                    }
                });
            }
        });
        //退单金额判断
        function back(){
            var paid_in_amount = $('#backorderFrom input[name="paid_in_amount"]').val();
            var return_money = $('#backorderFrom input[name="return_money"]').val();
            var back_money = $('#backorderFrom input[name="back_money"]').val();
            if((paid_in_amount - return_money) < back_money){
                return false;
            }else {
                return true;
            }
        }
        //提交退单操作
        $('#backorderFrom').bind('valid.form', function () {
            if(!back()){
                alert('检查退单金额是否正确！');
                return false;
            }
            $.ajax({
                url: "<?php echo U('singleBack');?>",
                type: 'POST',
                data: $(this).serialize(),
                success: function (d) {
                    var result = eval("(" + d + ")");
                    alert(result.msg);
                    if (result.flag == 1) {
                        $('#backorder').modal('hide');
                        window.location.reload();//刷新当前页面.
                    }                
                }
            });
        });
        //强制退单
        $('.forceBack').click(function(){
            var id = $(this).attr('data-id');
            $.ajax({
                url:'<?php echo U("forceBack");?>',
                type:'POST',
                data:{'id':id},
                success:function(d){
                    var result = eval("("+d+")");
                    if(result.flag == 1){
                        var data = result.data;
                        $('#backorderFrom input[name="brokerage_percent"]').val(data['brokerage_percent']+'%');
                        $('#backorderFrom input[name="brokerage_money"]').val(data['brokerage_money']);
                        $('#backorderFrom input[name="paid_in_amount"]').val(data['paid_in_amount']);
                        $('#backorderFrom input[name="return_money"]').val(data['return_money']);
                        $('#backorderFrom textarea[name="back_reason"]').val(data['back_reason']);
                        $('#backorderFrom input[name="id"]').val(id);
                        //银行信息
                        $('#backorderFrom input[name="bank_account"]').val(data['bank_account']);
                        $('#backorderFrom input[name="bank_member"]').val(data['bank_member']);
                        $('#backorderFrom select[name="bank"]').find('option[value='+data['bank']+']').attr("selected",true);
                        $('#backorderFrom input[name="profilesId"]').val(data['profilesId']);
                        $('#backorder').modal();
                    }else{
                        alert(result.msg);
                    }
                }
            });
        });
        
          //点击添加跟踪信息按钮，弹出跟踪信息表单
        $('.addorderfollow').click(function () {
            $('#question').val('');
            $('.client').attr('checked','checked');
            var orderId = $(this).attr("data-orderId");
            var member_id = $(this).attr("data-memberId");
            $('#orderid').val(orderId);
            $('#member_id').val(member_id);
            $('#addorderfollowform').modal();
        });

        //提交跟踪信息form 表单
        $('#defaultForm').bind('valid.form', function () {
            $('#addorderfollowform').modal('hide');
            $.ajax({
                url: "<?php echo U('OrderGrave/addorderfollow');?>",
                type: 'POST',
                data: $(this).serialize(),
                success: function (d) {
                    var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        alert('添加成功');
                    } else {
                        alert('添加失败');
                    }
                }
            });
        });

             //点击查看跟踪信息按钮，弹出查看跟踪信息表单
        $('.ordersfollow').click(function () {
            $('.afterData').remove();//清空以前数据
            var orderId = $(this).attr("data-orderId");
            $.ajax({
                url: "<?php echo U('OrderGrave/ordersfollow');?>",
                type: 'POST',
                data: 'orderId='+orderId,
                success: function (d) {
                    var result = eval("(" + d + ")");
                    var data = result.data;
                    //将得到的跟踪信息插入表格
                    if(result.flag==0){
                       str = "<tr></tr>";
                    }else if(result.flag==1){
                        var str = '';
                        var length = data.length;
                        for(var i=0; i<length; i++){
                            if(data[i].type == '1'){
                                str += "<tr class='afterData'><td>"+data[i].created_time+"</td><td>客户</td><td>"+data[i].question+"</td></tr>";
                            }else{
                                str += "<tr class='afterData'><td>"+data[i].created_time+"</td><td>商家</td><td>"+data[i].question+"</td></tr>";
                            }
                        }
                    }
                    $('.data-message').after(str);
                    $('#orderfollowform').modal();

                }
         });
    });
    
   
    
    </script>
</body>
<!-- END BODY -->
</html>