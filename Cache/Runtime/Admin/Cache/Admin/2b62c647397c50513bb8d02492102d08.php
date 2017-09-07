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
                            <li><a href="javascript:void(0)">陵园支付列表</a><span class="divider-last">&nbsp;</span></li>

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
                                    <h4><i class="icon-reorder"></i>陵园支付列表</h4>
                                </div>
                                <div class="widget-body">
                                    <form id="quickForm" method="get" class="form-horizontal" autocomplete="off" action='<?php echo U("storepaylist");?>'>
                                    <table>
                                         <tr>
                                            <td>搜索：</td>
                                            <td>
                                                <select name='store_id' class='chosen' tabindex="100" data-placeholder="选择商家">
                                                    <option value=""></option><option value="">所有商家</option>
                                                    <?php if(is_array($store_name)): $i = 0; $__LIST__ = $store_name;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($key); ?>' <?php if(($key) == $_GET['store_id']): ?>selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="mobile" class="input-medium" placeholder="预约人手机号" value="<?php echo ($_GET['mobile']); ?>"/>
                                               
                                                <button class="btn btn-primary">确定</button>
                                            </td>
                                        </tr>
                                    </table>
                                    </form>
                                    <table class="table table-striped table-bordered" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th class="hidden-phone">手机号</th>
                                                <th class="hidden-phone">姓名</th>
                                                <th class="hidden-phone">预约时间</th>
                                                <th class="hidden-phone">商家名称</th>
                                                <th class="hidden-phone">下单时间</th>
                                                <th class="hidden-phone">佣金金额</th>
                                                <th class="hidden-phone">跟踪人</th>
                                                <th class="hidden-phone">跟踪信息</th>
                                                <th class="hidden-phone">操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="odd gradeX">
                                                <td><?php echo ($vo["mobile"]); ?></td>
                                                <td><?php echo ($vo["buyer"]); ?></td>
                                                <td><?php echo (date('Y-m-d',$vo["appoint_time"])); ?></td>
                                                <td><?php echo ($vo["store_name"]); ?>.
                                                    <?php if(($vo["store_status"]) == "14"): ?><img width="28px" src="<?php echo (IMG_URL); ?>guang.png" title="广告会员"><?php endif; ?>
                                                <?php if(($vo["store_status"]) == "16"): ?><img width="28px" src="<?php echo (IMG_URL); ?>ge.png" title="个人会员"><?php endif; ?>
                                                <?php if(($vo["store_status"]) == "19"): ?><img width="28px" src="<?php echo (IMG_URL); ?>ge.png" title="个人会员"><?php endif; ?>
                                                <?php if(($vo["store_status"]) == "20"): ?><img width="28px" src="<?php echo (IMG_URL); ?>shang.png" title="商家会员"><?php endif; ?>
                                                </td>
                                               
                                            <td><?php echo (date('Y-m-d',$vo["created_time"])); ?></td>
                                            <td><?php echo ($vo["brokerage_money"]); ?></td>
                                             <td>
                                                     <?php if(is_array($order_flow)): $i = 0; $__LIST__ = $order_flow;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$flowmans): $mod = ($i % 2 );++$i; if($key == $vo["order_flow_id"] ): echo ($flowmans); endif; endforeach; endif; else: echo "" ;endif; ?>
                                                </td>
                                                  <td>
                                                      <?php if (showHandle('OrderGrave/ordersfollow')) { ?>
                                                    <a class="btn btn-small ordersfollow" href="javascript:void(0)"
                                                  data-orderId="<?php echo ($vo["id"]); ?>">查看信息</a>
                                                  <?php } ?>
                                                </td>
                                            <td>
                                             <?php if (showHandle('OrderGrave/orderbillinfo')) { ?>
                                                 <a class="btn btn-small btn-success viewBill"  href="javascript:;" data-id="<?php echo ($vo["id"]); ?>" ><i class="icon-eye-open icon-white"> </i>查看票据</a><?php } ?>

                                                 <?php if (showHandle('OrderGrave/addorderfollow')) { ?>
                                                <a class="btn btn-small addorderfollow"  href="javascript:void(0)"  data-orderId="<?php echo ($vo["id"]); ?>" data-memberId="<?php echo ($vo["member_id"]); ?>" data-ordersn="<?php echo ($vo["order_sn"]); ?>"><i class="icon-plus icon-white"> </i>添加跟踪信息</a><?php } ?>

                                                 <?php if (showHandle('Money/payforsuccess')) { ?>
                                                <a class="btn btn-success btn-small payforsuccess" href="javascript:void(0)" data-orderId="<?php echo ($vo["id"]); ?>"   data-money="<?php echo ($vo["brokerage_money"]); ?>"><i class="icon-ok icon-white"> </i>支付完成</a>
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

        <!--查看票据开始-->
    <div id="viewBill" class="modal hide fade in">
        <form id="viewBillForm" class="form-horizontal" autocomplete="off">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>查看票据信息</h3>
            </div>
            <div id="billTitle"  style="text-align:center;"></div>
            <div class="modal-body" id="viewBillBody">
            </div>
            <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">关闭</a>
            </div>
        </form>
    </div>
    <!--查看票据结束-->
      <!--支付成功开始-->
    <div id="payforsuccess" class="modal hide fade in">
        <form id="payforsuccessForm" method="post" class="form-horizontal" autocomplete="off">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>支付成功确认</h3>
            </div>
            <div class="modal-body">

                <table class="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <td>
                                实收佣金:<input type="text" name="paid_in_amount" value="" data-rule="checked" class="brokerage_money">
                                <span style="color:red;">应收佣金:<span class="should" value=""></span></span>
                            </td>

                        </tr>
                         <tr class="billimage">
                           
                            <td>
                                <!-- <span style="color:red">*票据:</span><input class="default" id="image" name="image[]"  type="file"> -->
                                <span>票据:</span><input  id="image" name="image[]"  type="file">
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <input type='hidden' data-id='orderid' name='orderid'></input>
                <button type="submit" id='payforsuccess_tijiao' class="btn btn-success">提交</button>
                <a href="#" class="btn" data-dismiss="modal">关闭</a>
            </div>
        </form>
    </div>
    <!--购墓成功结束-->
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
            //查看票据
    $('.viewBill').click(function(){
        var orderId = $(this).attr('data-id');
        $.ajax({
            url: "<?php echo U('orderbillinfo');?>",
            type: 'POST',
            data: {'orderId':orderId},
            success:function(d){
                var result = eval("(" + d + ")");
                if(result.flag==1){
                    var str = '<center><h4>'+result.msg+'</h4></center>';
                    $('#viewBillBody').empty().append(str);
                    $('#billTitle').empty();
                    $('#viewBill').modal();
                }else if(result.flag==2){
                    //票据类型
                    var typeStr = '';
                    var types = result.types;
                    for(var i in types){
                        typeStr += '<span class="btn btn-primary typesColor" onclick="dataType('+i+')" dataType = '+i+' >'+types[i]+'</span>&nbsp;&nbsp';
                    }
                    $('#billTitle').empty().append(typeStr);
                    //票据
                    var data = result.data;
                    var str = '<table class="table table-striped table-bordered"><tbody>'; 
                    var length = data.length;
                    for(var i=0;i<length;i++){
                        str += '<tr class="'+data[i].type+' allType"><td style="text-align:center;"><a href='+data[i].bill_image+' target="_blank"><img src='+data[i].bill_image+' width="300" /></a></td></tr>';
                    }
                    str += '</tbody></table>';
                    $('#viewBillBody').empty().append(str);
                    $('#viewBill').modal();
                }else {
                    alert(result.msg);
                }
            }
        });
    });
   //显示选择类型的票据
   function dataType(d){
       $('.typesColor').css('color','');
       $('.typesColor[dataType='+d+']').css('color','green');
       $('#viewBillBody .allType').css('display','none');
       $('.'+d).css('display','');
   }
    

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


        //点击支付完成按钮,完成支付  //缺少一个实收金额
        $('.payforsuccess').click(function(){
            var money = $(this).attr('data-money');
            var orderId = $(this).attr("data-orderId");
            $('#payforsuccessForm input[name="orderid"]').val(orderId);
            $('.brokerage_money').val(money);
            $('.should').html(money);
            $('#payforsuccess').modal();
        });

        //点击支付完成按钮form表单
        $('#payforsuccessForm').bind('valid.form', function () {
            $('#payforsuccess').modal('hide');
            var fd = new FormData(document.getElementById("payforsuccessForm"));
            var paid =   $('#payforsuccessForm input[name="paid_in_amount"]').attr('value');
            $.ajax({
        		url:"<?php echo U('payforsuccess');?>",
        		type:'POST',
        		data: fd,
                processData: false,
                contentType: false,
        		success:function(d){
        			var result = eval("("+ d +")");

        			if(result.flag == 1) {
        				alert('支付成功');
                        window.location.reload();
        			}else{
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