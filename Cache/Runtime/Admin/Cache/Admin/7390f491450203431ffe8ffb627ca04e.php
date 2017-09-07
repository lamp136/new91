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
                            <li><a href="javascript:void(0)">购墓退单列表</a><span class="divider-last">&nbsp;</span></li>

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
                                    <h4><i class="icon-reorder"></i>购墓退单列表</h4>
                                </div>
                                <div class="widget-body">
                                    <form id="quickForm" method="post" class="form-horizontal" autocomplete="off" action='<?php echo U("singleBackList");?>'>
                                        <table>
                                            <tr>
                                                <td>搜索：</td>
                                                <td>
                                                    <select name='SearchStore' >
                                                        <option value="">所有退单商家</option>
                                                        <?php if(is_array($Searchlist)): $i = 0; $__LIST__ = $Searchlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($key); ?>'<?php if($key == $search[SearchStore]): ?>selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="mobile" class="input-medium" placeholder="订单人手机" value="<?php echo ($search[mobile]); ?>"/>
                                                    <button class="btn btn-primary">确定</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                    
                                    <table class="table table-striped table-bordered" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th width="8%" class="hidden-phone">手机号</th>
                                                <th width="6%" class="hidden-phone">姓名</th>
                                                <th width="17%" class="hidden-phone">商家名称</th>
                                                <th width="6%" class="hidden-phone">墓位价格</th>
                                                <th width="8%" class="hidden-phone">佣金实收金额</th>
                                                <th width="6%" class="hidden-phone">退单金额</th>
                                                <th width="6%" class="hidden-phone">返现金额</th>
                                                <th width="6%" class="hidden-phone">佣金支<br/>付时间</th>
                                                <th width="9%" class="hidden-phone">申请退<br/>单时间</th>
                                                <th width="16%" class="hidden-phone">退单原因</th>
                                                <th width="12%" class="hidden-phone">操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="odd gradeX">
                                                    <td><?php echo ($vo["mobile"]); ?></td>
                                                    <td><?php echo ($vo["buyer"]); ?></td>
                                                    <td><?php echo ($vo["store_name"]); ?>
                                                    <?php if(($vo["store_status"]) == "14"): ?><img width="28px" src="<?php echo (IMG_URL); ?>guang.png" title="广告会员"><?php endif; ?>
                                                <?php if(($vo["store_status"]) == "16"): ?><img width="28px" src="<?php echo (IMG_URL); ?>ge.png" title="个人会员"><?php endif; ?>
                                                <?php if(($vo["store_status"]) == "19"): ?><img width="28px" src="<?php echo (IMG_URL); ?>ge.png" title="个人会员"><?php endif; ?>
                                                <?php if(($vo["store_status"]) == "20"): ?><img width="28px" src="<?php echo (IMG_URL); ?>shang.png" title="商家会员"><?php endif; ?></td>
                                                    <td><?php echo ($vo["tomb_price"]); ?></td>
                                                    <td><?php echo ($vo["paid_in_amount"]); ?></td>
                                                    <td><?php echo ($vo["back_fact_money"]); ?></td>
                                                    <td><?php echo ($vo["return_money"]); ?></td>
                                                    <td>
                                                        <?php if(!empty($vo["payfor_us_time"])): echo (date('Y-m-d',$vo["payfor_us_time"])); endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if(!empty($vo["back_apply_time"])): echo (date('Y-m-d',$vo["back_apply_time"])); endif; ?>
                                                    </td>
                                                    <td><?php echo ($vo["back_reason"]); ?></td>
                                                    <td>
                                                        <?php if(C("ORDER_STATUS.ALLOW") == $vo[status]): if(showHandle('Money/paymoney')){ ?>
                                                                <a class="btn btn-success btn-small paymoney"  href="javascript:void(0)" data-id="<?php echo ($vo["id"]); ?>">确认退单</a><br/>
                                                            <?php } if(showHandle('Money/bankMsg')){ ?>
                                                                <a class="btn btn-primary btn-small bankMsg"  href="javascript:void(0)" data-id="<?php echo ($vo["store_id"]); ?>">查看银行信息</a>
                                                            <?php } ?>
                                                        <?php else: ?>
                                                            <?php if(showHandle('Money/bankMsg')){ ?>
                                                                <a class="btn btn-primary btn-small bankMsg"  href="javascript:void(0)" data-id="<?php echo ($vo["store_id"]); ?>">查看银行信息</a>
                                                            <?php } endif; ?>   
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
        <form id="backorderFrom" method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
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
                            <td>应退陵园金额:</td>
                            <td><input  type="text" name="back_money" disabled></td>
                        </tr>
                        <tr>
                            <td>实际退还<br/>陵园金额:</td>
                            <td><input  type="text" name="back_fact_money">应退金额：<span class="back_money"><span></td>
                        </tr>
                        <tr>
                            <td>上传支付凭证：</td>
                            <td>
                                <input  name="image" type="file"/>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="action" value="post"/></input>
                <input type='hidden' name='id'></input>
                <button type="submit" class="btn btn-success">提交</button>
                <a href="#" class="btn" data-dismiss="modal">关闭</a>
            </div>
        </form>
    </div>
    <!--填写退单信息结束-->
    
    
    <!--查看银行信息开始-->
    <div id="bankMsg" class="modal hide fade in">
        <form id="bankMsgFrom"  class="form-horizontal"  autocomplete="off">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>退单银行信息</h3>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <td>开户行:</td>
                            <td>
                                <select name="bank" disabled>
                                    <option value="0">--请选择-- </option>
                                    <?php if(is_array(C("PAY_TYPE"))): $i = 0; $__LIST__ = C("PAY_TYPE");if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$banks): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($banks); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>开户人:</td>
                            <td><input  type="text" name="bank_member" disabled></td>
                        </tr>
                        <tr>
                            <td>银行账号:</td>
                            <td><input  type="text" name="bank_account" disabled></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">关闭</a>
            </div>
        </form>
    </div>
    <!--查看银行信息结束-->
    
    
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
    <script>
        //上传支付凭证和财务退款
        $('.paymoney').click(function(){
            var orderId = $(this).attr('data-id');
            var ret = confirm("你确认支付过了么？");
            var action = 'get';
            if(ret) {
                $.ajax({
                    url: "<?php echo U('paymoney');?>",
                    type:'post',
                    data:{'id':orderId,'action':action},
                    success:function(msg){
                        console.log(msg);
                        var result = eval("(" + msg + ")");
                        if(result.flag == 1 ){
                            var data = result.data;
                            $('#backorderFrom input[name="brokerage_percent"]').val(data['brokerage_percent']+'%');
                            $('#backorderFrom input[name="brokerage_money"]').val(data['brokerage_money']);
                            $('#backorderFrom input[name="paid_in_amount"]').val(data['paid_in_amount']);
                            $('#backorderFrom input[name="return_money"]').val(data['return_money']);
                            $('#backorderFrom input[name="back_money"]').val(data['back_money']);
                            $('#backorderFrom input[name="back_fact_money"]').val(data['back_money']);
                            $('.back_money').html(data['back_money']);
                            $('#backorderFrom input[name="id"]').val(orderId);
                            $('#backorder').modal();
                        }else{
                            alert(result.msg);
                            window.location.reload();//刷新当前页面.
                        }
                    }
                });
            }
        });
        $('#backorderFrom').bind('valid.form', function () {
            var backorderFrom = new FormData(document.getElementById("backorderFrom"));
            var back_money = $('#backorderFrom input[name="back_money"]').val();
            var back_fact_money = $('#backorderFrom input[name="back_fact_money"]').val();
            if(back_fact_money>back_money){
                alert('请检查退款金额！');
                return false;
            }
            
            $.ajax({
                url: "<?php echo U('paymoney');?>",
                type: 'POST',
                data:backorderFrom,
                processData: false,
                contentType: false,
                success: function (d) {
                    var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        $('#backorder').modal('hide');
                        alert(result.msg);
                        window.location.reload();//刷新当前页面.
                    } else {
                        alert(result.msg);
                    }
                }
            });
        });
        //查看银行信息
        $('.bankMsg').click(function(){
            var storeId = $(this).attr('data-id');
            $.ajax({
                url: "<?php echo U('bankMsg');?>",
                type:'post',
                data:{'id':storeId},
                success:function(msg){
                    var result = eval("(" + msg + ")");
                    if(result.flag == 1 ){
                        var data = result.data;
                        $('#bankMsgFrom input[name="bank_account"]').val(data['bank_account']);
                        $('#bankMsgFrom input[name="bank_member"]').val(data['bank_member']);
                        $('#bankMsgFrom select[name="bank"]').find('option[value='+data['bank']+']').attr("selected",true);
                        $('#bankMsg').modal();
                    }else{
                        alert(result.msg);
                        window.location.reload();//刷新当前页面.
                    }
                }
            });
        });
    </script>
</body>
<!-- END BODY -->
</html>