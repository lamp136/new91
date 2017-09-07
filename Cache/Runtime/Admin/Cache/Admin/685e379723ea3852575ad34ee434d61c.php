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
                                <a href="<?php echo U('index');?>">合同档案</a> <span class="divider">&nbsp;</span>
                            </li>
                            <li><a href="javascript:void(0)">添加档案</a><span class="divider-last">&nbsp;</span></li>

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
                                <div class="widget-body">
                                    <form action="/system.php/StoreProfiles/add.html " method="post" id="myform"   onsubmit="return submitCheck();" >
                                        <table class="table table-bordered table-hover">
                                            <tr>
                                                <th colspan="2" style="text-align:center;font-size:30px;">合同基本信息</th>
                                            </tr>
                                            <tr>
                                                <td width="100"><span style="color:red">*</span>商家名称:</td>
                                                <td><input type="text" class="input" size="30" name="show_store_name" placeholder="用来显示的商家名称" data-rule='required' /></td>
                                            </tr>
                                            <tr>
                                                <td> <span style="color:red">*</span> 地区：</td>
                                                <td>
                                                    <select  class="input-medium m-wrap" name='province_id' id="province_id">
                                                        <option value=''>请选择</option>
                                                        <?php if(is_array($regions)): $i = 0; $__LIST__ = $regions;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$region): $mod = ($i % 2 );++$i;?><option value="<?php echo ($region["region_id"]); ?>"><?php echo ($region["region_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                    </select>
                                                    <select class="input-medium m-wrap" tabindex="1" name="city_id" id="city_id" data-rule='required'>
                                                        <option value="0">--请选择-- </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> <span style="color:red">*</span>商家地址：</td>
                                                <td><input type="text" class="input-xlarge" name="address" data-rule='required'/></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                     <label class="control-label">集团所属:</label>
                                                 </td>
                                                 <td>
                                                     <select class="input-medium m-wrap" tabindex="1" name="category_group_id">
                                                         <option value="0">---请选择---</option>
                                                         <?php if(is_array($categoryGroup)): $i = 0; $__LIST__ = $categoryGroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cate["cid"]); ?>"><?php echo ($cate["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                     </select>
                                                 </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                     <label class="control-label">商家类型:</label>
                                                 </td>
                                                <td>
                                                    <?php if(is_array($merchant)): $i = 0; $__LIST__ = $merchant;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input type='radio' name='category_id' value="<?php echo ($vo["cid"]); ?>" data-rule='required' <?php if(($vo[cid]) == C("CATEGORY_CEMETERY_ID")): ?>checked<?php endif; ?> ><?php echo ($vo["name"]); ?> &nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th colspan="2">&nbsp;</th>
                                            </tr>
                                        </table> 
                                        
                                        <table class="table table-bordered table-hover">  
                                            <tr>
                                                <th  style="text-align:center;font-size:30px;">合同详细信息</th>
                                            </tr>
                                            <tr>
                                                <th  style="text-align:center;font-size:15px;">
                                                    <?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input type="checkbox"  value="<?php echo ($vo["cid"]); ?>" class="catename" catename ="<?php echo ($vo["name"]); ?>"><?php echo ($vo["name"]); ?>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
                                                </th>
                                            </tr>
                                        </table> 
                                        
                                        <div class="insert">
                                        </div>
                                        
                                        <table class="table table-bordered table-hover">
                                            <tr>
                                                <td style="text-align:center;">
                                                    <input type="hidden" id="onOff" val="">
                                                    <input type="submit" class="btn submit " value="提交">
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                    
                                    <div class="details" style="display:none;">
                                            <table class="table table-bordered table-hover" >
                                                <input type="hidden" name="category_goods_id[]" />
                                                <tr>
                                                   <th rowspan="10" style="text-align:center;font-size:20px;" class="profilesname">&nbsp;</th>
                                                </tr>
                                                <tr>
                                                    <td width="100"><span style="color:red">*</span>合同名称:</td>
                                                    <td><input type="text" class="input" size="30" name="profile_name[]" data-rule='required' /></td>
                                                    <td>价格区间：</td>
                                                    <td>
                                                        <input type="text" class="input-small m-wrap" tabindex="1" size="30" name="min_price[]" placeholder="最低价(万)" value="  "/>最低价(万)~
                                                        <input type="text" class="input-small m-wrap" tabindex="1" size="30" name="max_price[]" placeholder="最高价(万)" value="  "/>最高价(万)
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span style="color:red">*</span>合同开始时间：</td>
                                                    <td>
                                                        <input type="text" size="30" name="start_time[]" data-rule='开始日期:required' onClick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" class="Wdate" />
                                                    </td>
                                                    <td><span style="color:red">*</span>合同结束时间：</td>
                                                    <td>
                                                        <input type="text" size="30" name="end_time[]" data-rule='结束时间:required;match[gt, start_time, date]' onClick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" class="Wdate"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span style="color:red">*</span>佣金：</td>
                                                    <td><input type="text" class="input" size="30" name="return_amount[]" data-rule='required'/> 佣金区间,如:5-10</td>
                                                    <td>
                                                        <label class="control-label"><span style="color:red">*</span>合同类型:</label>
                                                    </td>
                                                    <td>
                                                        <select name="member_status[]" id="member_status"/>
                                                            <?php if(is_array($memberStatus)): $i = 0; $__LIST__ = $memberStatus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" ><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span style="color:red">*</span> 联系人：</td>
                                                    <td><input type="text" class="input" size="30" name="contact_man[]" data-rule='required'/></td>
                                                    <td>传真</td>
                                                    <td><input type="text"  size="30" name="fax[]" value="  " placeholder="传真" onblur="isEmpty(this);"/> </td>
                                                </tr>
                                                <tr>
                                                    <td><span style="color:red">*</span> 联系方式：</td>
                                                    <td>
                                                        <input type="text" class="input mobile" size="30" name="mobile[]" value="  " placeholder="手机号" />请填写手机号<br/> 
                                                        <input type="text" class="input telephone" size="30" name="telephone[]" value="  " placeholder="固话" />请填写座机号
                                                    </td>
                                                    <td><span style="color:red">*</span>结算日期：</td>
                                                    <td><input type="text" class="input" size="30" name="settlement_time[]" data-rule='required'/> 如：每月15-20号结算</td>
                                                </tr>
                                                <tr>
                                                    <td>开户行：</td>
                                                    <td>
                                                        <select name="bank[]">
                                                            <option value="0">--请选择-- </option>
                                                            <?php if(is_array(C("PAY_TYPE"))): $i = 0; $__LIST__ = C("PAY_TYPE");if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$banks): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($banks); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                        </select>
                                                    </td>
                                                    <td>开户人：</td>
                                                    <td><input type="text" class="input" size="30" name="bank_member[]" value="  " onblur="isEmpty(this);"/></td>
                                                </tr>
                                                <tr>
                                                    <td>开户帐号：</td>
                                                    <td><input type="text" class="input" size="30" name="bank_account[]" value="  " onblur="isEmpty(this);"/></td>
                                                    <td>接收时间：</td>
                                                    <td>
                                                        <input type="text" size="30" name="receive_time[]" value="<?php echo date('Y-m-d');?>" onClick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" class="Wdate"/>合同接收时间
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>合同负责人：</td>
                                                    <td>
                                                        <select name="principal[]">
                                                            <option value="0">--请选择-- </option>
                                                            <?php if(is_array($principal)): $i = 0; $__LIST__ = $principal;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" ><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                        </select>
                                                    </td>
                                                    <td>商家承诺：</td>
                                                    <td><textarea name='commitment[]' value=" "  onblur="isEmpty(this);"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td>配送区域：</td>
                                                    <td><textarea name='distribution_area[]' value=" " onblur="isEmpty(this);" ></textarea></td>
                                                    <td>备注：</td>
                                                    <td><textarea name='remarks[]' value=" " onblur="isEmpty(this);" ></textarea></td>
                                                </tr>
                                            </table> 
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
    <script src="<?php echo (ASSETS_URL); ?>bootstrap/js/bootstrap.min.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo (JS_URL); ?>My97DatePicker/WdatePicker.js"></script>
    <script src="<?php echo (JS_URL); ?>jquery.validator.js"></script>
    <script src="<?php echo (JS_URL); ?>zh-CN.js"></script>
    <script src="<?php echo (JS_URL); ?>scripts.js"></script>
    <script>
        //克隆
        $('.catename').click(function(){
            var catename = $(this).attr('catename');
            var catenameLength = catename.length;
            var catenameStr = '';
            for(var i=0;i<catenameLength;i++){
                catenameStr += catename[i]+'<br/><br/>';
            }
            var category_id = $(this).val();
            if($(this).is(':checked')){
                var deleteHTML=$('.details').children('table').clone();
                var spanHTML=deleteHTML.find('.profilesname').html(catenameStr);
                var spanHTML=deleteHTML.find('input[type="hidden"]').addClass(category_id);
                var spanHTML=deleteHTML.find('input[name="start_time[]"]').addClass('block');
                var spanHTML=deleteHTML.find('input[type="hidden"]').val(category_id);
                $('.insert').prepend(deleteHTML);
            }else{
                $('.'+category_id).parent().remove();
            }
        });
        //省份切换，返回对应的城市
        $('#province_id').change(function () {
            var province_id = $(this).val();
            if (province_id == 0) {
                $('#city_id').empty();
                var str = "<option value='0'>请选择</option>";
                $('#city_id').html(str);
            } else {
                $.ajax({
                    url: "<?php echo U('getCity');?>",
                    type: 'POST',
                    data: 'province_id=' + province_id,
                    success: function (d) {
                        var result = eval("(" + d + ")");
                        var data = result.data;
                        var str = "<option value='0'>请选择</option>";
                        if (result.flag == 1) {
                            for(var i in data){
                                str += "<option value="+data[i].region_id+">"+data[i].region_name+"</option>";
                            }
                            $('#city_id').html(str);
                        }
                    }
                });
            }
        });
        //提交验证
        function submitCheck(){
            $('.block').each(function(){
                var startTime=$(this).val();
                var start=new Date(startTime.replace("-", "/").replace("-", "/"));  
                var endTime=$(this).parent().parent().find('input[name="end_time[]"]').val();  
                var end=new Date(endTime.replace("-", "/").replace("-", "/"));
                var reg = /^(1[3|4|5|7|8]\d{9})$/;
                if(end<start){
                    alert('请检查合同时间！');
                    $('#onOff').val('false'); 
                }else{
                    var mobile=$(this).parent().parent().parent().find('input[name="mobile[]"]').val().replace(/(^\s*)|(\s*$)/g, "");
                    var telephone=$(this).parent().parent().parent().find('input[name="telephone[]"]').val();
                    if(mobile.length == 1 && telephone.length == 1 ){
                        alert('手机号和固话必须填写一个!');
                        $('#onOff').val('false');
                    }else if(mobile.length == 0 || telephone.length == 0 ){
                        alert('手机号和固话不能为空(可以填0)!');
                        $('#onOff').val('false');
                    }else if(!reg.test(mobile)){
                        alert('手机号错误！');
                        $('#onOff').val('false');
                    }else{
                        $('#onOff').val('');
                    }
                }
            });
            
            $('#member_status').each(function(){
                var member_status = $(this).val();
                if(member_status == 0){
                    alert('请选择合同类型！');
                    $('#onOff').val('false');
                }else{
                    $('#onOff').val('');
                }
            });
            
            //判断是否有合同名称，没有测不能提交
            var catename = $('.catename').attr("checked")
            if(catename){
                $('#onOff').val('');
            }else{
                alert('请填写详细合同！');
                $('#onOff').val('false'); 
            }
            
            if($('#onOff').val() == 'false'){
                return false;
            }else{
                return true;
            }
        }
        //取消选中
        $('.catename').attr("checked",false);
        
        //提示不能为空
        function isEmpty(d){
            var val = $(d).val();
            if(val.length == 0){
                alert('不能为空,当为空时可以输入空格！');
            }
        }
        
    </script>
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>