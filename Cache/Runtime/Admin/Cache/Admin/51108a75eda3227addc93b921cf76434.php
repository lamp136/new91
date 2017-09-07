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

<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div id="container" class="row-fluid sidebar-closed" style="margin-top: 0px">
    <!-- BEGIN SIDEBAR -->  
    <!-- END SIDEBAR -->
    <!-- BEGIN PAGE -->
    <div id="main-content" style="margin-left: 0px">
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
                                <h4><i class="icon-reorder"></i>订单详情</h4>
                            </div>
                            <div class="widget-body">
                                <table class="table table-hover" id="sample_1" style="border:0px">
                                    <thead>
                                    <tr>
                                        <th class="hidden-phone">订单号</th>
                                        <th class="hidden-phone">商家名称</th>
                                        <th class="hidden-phone">总价</th>
                                        <th class="hidden-phone">优惠金额</th>
                                        <th class="hidden-phone">收货人信息</th>
                                        <th class="hidden-phone">提货人信息</th>
                                        <th class="hidden-phone">下单时间</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php if(is_array($detail)): $i = 0; $__LIST__ = $detail;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                            <td><?php echo ($vo["order_son_sn"]); ?></td>
                                            <td><?php echo ($vo["store_name"]); ?></td>
                                            <td ><?php echo ($vo["total_price"]); ?></td>
                                            <td ><?php echo ($vo["coupon_price"]); ?></td>
                                            <td ><?php echo ($vo["consignee"]); ?><br/><?php echo ($vo["shipping_address"]); ?><br/><?php echo ($vo["consignee_mobile"]); ?></td>
                                            <td ><?php echo ($vo["take_stock_people"]); ?><br/><?php echo ($vo["take_stock_mobile"]); ?><br/><?php echo ($vo["actual_stock_time"]); ?></td>
                                            <td ><?php echo (date("Y-m-d",$vo["order_service_time"])); ?></td>
                                           
                                        </tr>
                                        <tbody>
                                            <tr >
                                                <th></th>
                                                <th></th>
                                                <th>图片</th>
                                                <th>商品名称</th>
                                                <th>单价</th>
                                                <th>数量</th>
                                                <th>总价</th>
                                            </tr>
                                            <?php if(is_array($vo['child'])): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vs): $mod = ($i % 2 );++$i;?><tr>
                                                        <td style="border:0px"></td>
                                                        <td style="border:0px"></td>
                                                        <td style="border:0px"><img src="<?php echo ($vs["thumb_url"]); ?>" width='40px'/></td>
                                                        <td style="border:0px"><?php echo ($vs["goods_name"]); ?></td>
                                                        <td style="border:0px"><?php echo ($vs["price"]); ?></td>
                                                        <td style="border:0px"><?php echo ($vs["number"]); ?></td>
                                                        <td style="border:0px"><?php echo ($vs["total_price"]); ?></td>
                                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </tbody><?php endforeach; endif; else: echo "" ;endif; ?>
            
                                    </tbody>
                                </table>
                                <div class="row-fluid">
                                    <div class="span12 center">
                                        <div class="pagination" id="sample_1_info" style="text-align: center">
                                          
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
<!-- BEGIN FOOTER -->

<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS -->
<!-- Load javascripts at bottom, this will reduce page load time -->
<script src="<?php echo (JS_URL); ?>jquery-1.8.3.min.js"></script>
<script src="<?php echo (ASSETS_URL); ?>bootstrap/js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo (JS_URL); ?>My97DatePicker/WdatePicker.js"></script>
<script src="<?php echo (JS_URL); ?>jquery.validator.js"></script>
<script src="<?php echo (JS_URL); ?>scripts.js"></script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>