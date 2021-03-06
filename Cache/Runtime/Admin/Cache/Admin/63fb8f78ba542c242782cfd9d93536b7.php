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
                            <a href="#"><i class="icon-home"></i></a><span class="divider">&nbsp;</span>
                        </li>
                        <li>
                            <a href="#">91搜墓网后台</a> <span class="divider">&nbsp;</span>
                        </li>
                        <li><a href="#">编辑商家档案</a><span class="divider-last">&nbsp;</span></li>

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
                                <h4><i class="icon-reorder"></i>编辑商家档案</h4>
                            </div>
                            <div class="widget-body form">
                                <!-- BEGIN FORM-->
                                <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><form id="defaultForm" method="post"  autocomplete="off" action="<?php echo U('StoreProfiles/edit');?>" onsubmit="return submitCheck();" enctype="multipart/form-data">
                                        <div class="">
                                            <table class="table table-bordered table-hover">
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <label class="control-label"><span style="color:red">*</span>合同名称:</label>
                                                    </td>
                                                    <td>
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                <input type="text"  name="profile_name" value="<?php echo ($vo["profile_name"]); ?>" data-rule='required'/>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label class="control-label"><span style="color:red">*</span>分类名称:</label>
                                                    </td>
                                                    <td>
                                                        <select  name="category_id" id='province' class="input-medium m-wrap" tabindex="1"  data-rule='required'/>
                                                            <option value="0">--请选择--</option>
                                                            <?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i; if($cat[cid] == $vo[category_id]): ?><option value="<?php echo ($cat["cid"]); ?>"  selected="selected"><?php echo ($cat["name"]); ?></option>
                                                                    <?php else: ?>
                                                                    <option value="<?php echo ($cat["cid"]); ?>"><?php echo ($cat["name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <label class="control-label"><span style="color:red">*</span>联系人:</label>
                                                    </td>
                                                    <td>
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                <input type="text" placeholder="联系人" class="input-large" name="contact_man" value="<?php echo ($vo["contact_man"]); ?>" data-rule='required'/>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label class="control-label"><span style="color:red">*</span>手机号:</label>
                                                    </td>
                                                    <td>
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                <input type="text" placeholder="手机号" class="input-large mobile" name="mobile" value="<?php echo ($vo["mobile"]); ?>" data-rule='required'/>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="control-label">传真:</label>
                                                    </td>
                                                    <td>
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                <input type="text" placeholder="传真" class="input-large" name="fax" value="<?php echo ($vo["fax"]); ?>">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span style="color:red">*</span>合同时间：</td>
                                                    <td>
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                <input type="text" size="30" name="start_time" data-rule='开始日期:required' onClick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" value="<?php echo (date('Y-m-d',$vo["start_time"])); ?>" class="Wdate input-small"/>---
                                                                <input type="text" size="30" name="end_time" data-rule='开始日期:required' onClick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" value="<?php echo (date('Y-m-d',$vo["end_time"])); ?>" class="Wdate input-small"/>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>合同负责人：</td>
                                                    <td>
                                                        <select name="principal_id">
                                                            <option value="<?php echo ($vo["principal_id"]); ?>"><?php echo ($vo["principal"]); ?></option>
                                                            <?php if(is_array($principal)): $i = 0; $__LIST__ = $principal;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pri): $mod = ($i % 2 );++$i; if(($key) != $vo[principal_id]): ?><option value="<?php echo ($key); ?>"><?php echo ($pri); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                                        </select>
                                                    </td>
                                                    <td>接收时间：</td>
                                                    <td>
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                <input type="text" size="30" name="receive_time"  onClick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" value="<?php echo (date('Y-m-d',$vo["receive_time"])); ?>" class="Wdate"/>合同接收时间
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                               
                                                <tr>
                                                    <td>
                                                        <label class="radio">会 员:</label>
                                                    </td>
                                                    <td>
                                                        <div class="controls">
                                                            <?php if(is_array($memberStatus)): $i = 0; $__LIST__ = $memberStatus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><input type='radio' name='member_status' value="<?php echo ($key); ?>" <?php if(($vo["member_status"]) == $key): ?>checked="checked"<?php endif; ?>><?php echo ($value); endforeach; endif; else: echo "" ;endif; ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label class="control-label"><span style="color:red">*</span>佣 金:</label>
                                                    </td>
                                                    <td>
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                <input type="text" placeholder="佣金" class="input-large" name="return_amount" value="<?php echo ($vo["return_amount"]); ?>" data-rule='required'/>佣金区间，比如：5-10
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="control-label"><span style="color:red">*</span>结算日期:</label>
                                                    </td>
                                                    <td>
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                <input type="text" placeholder="结算日期" class="input-large" name="settlement_time" value="<?php echo ($vo["settlement_time"]); ?>" data-rule='required'/>如：每月的15-20号结算
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label class="control-label"><span style="color:red">*</span>价格区间:</label>
                                                    </td>
                                                    <td>
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                <input type="text" placeholder="最低价格"class="input-small m-wrap" tabindex="1" name="min_price" value="<?php echo ($vo["min_price"]); ?>" data-rule='required'/>万~
                                                                <input type="text" placeholder="最高价格"class="input-small m-wrap" tabindex="1" name="max_price" value="<?php echo ($vo["max_price"]); ?>" data-rule='required'/>万
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="control-label">开户银行:</label>
                                                    </td>
                                                    <td>
                                                        <select name="bank">
                                                            <option value="0">--请选择-- </option>
                                                            <?php if(is_array(C("PAY_TYPE"))): $i = 0; $__LIST__ = C("PAY_TYPE");if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$banks): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $vo['bank']): ?>selected<?php endif; ?>><?php echo ($banks); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <label class="control-label">开户人:</label>
                                                    </td>
                                                    <td>
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                <input type="text" placeholder="开户人" class="input-large" name="bank_member"  value="<?php echo ($vo["bank_member"]); ?>">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="control-label">银行帐号:</label>
                                                    </td>
                                                    <td>
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                <input type="text" placeholder="银行帐号" class="input-large" name="bank_account"  value="<?php echo ($vo["bank_account"]); ?>">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label class="control-label">商家承诺：</label>
                                                    </td>
                                                    <td>
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                 <textarea name='commitment'><?php echo ($vo["commitment"]); ?></textarea>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="control-label">配送区域：</label>
                                                    </td>
                                                    <td>
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                 <textarea name='distribution_area'><?php echo ($vo["distribution_area"]); ?></textarea>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label class="control-label">备注：</label>
                                                    </td>
                                                    <td>
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                 <textarea name='remarks'><?php echo ($vo["remarks"]); ?></textarea>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="form-actions">
                                            <input type='hidden' name='nowpage' value='<?php echo ($nowpage); ?>'>
                                            <input type="hidden" name="id" value="<?php echo ($vo["id"]); ?>"/>
                                            <input type="hidden" id="onOff" value=""/>
                                            <button type="submit" class="btn btn-success">提交</button>
                                        </div>
                                    </form><?php endforeach; endif; else: echo "" ;endif; ?>
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
<script src="<?php echo (JS_URL); ?>jquery.validator.js"></script>
<script src="<?php echo (JS_URL); ?>zh-CN.js"></script>
<script src="<?php echo (JS_URL); ?>scripts.js"></script>
<!-- ie8 fixes -->
<!--[if lt IE 9]>
<script src="js/excanvas.js"></script>
<script src="js/respond.js"></script>
<![endif]-->
<script type='text/javascript'>
    //省份切换，返回对应的城市
        $('#province').change(function () {
            var province = $(this).val();
            if (province == 0) {
                $('#city').empty();
                var str = "<option value='0'>请选择</option>";
                $('#city').html(str);
            } else {
                $.ajax({
                    url: "<?php echo U('getCity');?>",
                    type: 'POST',
                    data: 'province_id=' + province,
                    success: function (d) {
                        var result = eval("(" + d + ")");
                        var data = result.data;
                        var str = "<option value='0'>请选择</option>";
                        if (result.flag == 1) {
                            for(var i in data){
                                str += "<option value="+data[i].region_id+">"+data[i].region_name+"</option>";
                            }
                            $('#city').html(str);
                        }
                    }
                });
            }
        });
        
        function submitCheck(){
            //合同时间是否合理
            var startTime=$('input[name="start_time"]').val();
            var start=new Date(startTime.replace("-", "/").replace("-", "/"));  
            var endTime=$('input[name="end_time"]').val();  
            var end=new Date(endTime.replace("-", "/").replace("-", "/"));  
            if(end<start){
                alert('请检查合同时间！');
                return false;  
            }
            if($('#onOff').val()=='false'){
                alert('手机号错误！');
                return false;
            }
        }
        
        $('.mobile').blur(function(){
            var mobile = $(this).val();
            var reg = /^(1[3|4|5|7|8]\d{9})$/;
            if(!reg.test(mobile)){
                alert('手机号错误！');
                $('#onOff').val('false');
            }else{
                $('#onOff').val('');
            }
        });
</script>    
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>