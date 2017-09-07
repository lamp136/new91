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
                            <a href="javasript:void(0)">平台会员</a><span class="divider-last">&nbsp;</span>
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
                                <h4><i class="icon-reorder"></i>平台会员</h4>
                            </div>
                            <div class="widget-body">
                                <form id="quickForm" method="get" class="form-horizontal" autocomplete="off" action="/system.php/Member/index.html">搜索：
                                    <input type="text" name="mobile" class="input-large" placeholder="请输入手机号或名字" value="<?php echo ($_GET['mobile']); ?>"/>
                                    <button class="btn btn-primary">确定</button>
                                </form>
                                <table class="table table-striped table-bordered" id="sample_1">
                                    <thead>
                                    <tr>
                                        <th width="10%">姓名</th>
                                        <th width="10%">手机号</th>
                                        <th width="8%">注册类型</th>
                                        <th width="8%">手机验证</th>
                                        <th width="8%">银行信息</th>
                                        <th width="15%">注册时间</th>
                                        <th width="41%">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($members)): $i = 0; $__LIST__ = $members;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="odd gradeX">
                                            <td><?php echo ($vo["name"]); ?></td>
                                            <!-- <?php if($categoryId == 14): ?><td><?php echo ($vo["name"]["name"]); ?></td><?php endif; ?> -->
                                            <td><?php echo ($vo["mobile"]); ?></td>
                                            <td>
                                                <?php if (array_key_exists($vo['member_type'], $Think.config.MEMBER_TYPES)){ echo C('MEMBER_TYPES')[$vo['member_type']]; } else { echo "未知"; } ?>
                                            </td>
                                            <td>
                                               <?php if($vo["check_mobile"] == 1): ?><span>已验证</span>
                                               <?php else: ?>
                                                   <span>未验证</span><?php endif; ?>
                                            </td>
                                            <td>
                                                <?php $count = count($vo['MebmerBank']); if ($count > 0) { echo "有"; } else { echo "无"; } ?>
                                            </td>
                                            <td><?php echo ($vo["created_time"]); ?></td>
                                            <td>
                                            <?php if (showHandle('Member/editMemberBank')) { ?>
                                                <a class="btn btn-small edit"  href="javascript:void(0)" data-id="<?php echo ($vo["id"]); ?>" data-name="<?php echo ($vo["name"]); ?>" data-mobile="<?php echo ($vo["mobile"]); ?>"><i class="icon-pencil icon-white"> </i>修改银行卡信息</a>
                                             <?php } if (showHandle('Member/resetpwd')) { ?>
                                                <a class="btn btn-small resetpwd"  href="javascript:void(0)" data-id="<?php echo ($vo["id"]); ?>"><i class="icon-refresh icon-white"> </i>重置密码</a>
                                                <?php } if (showHandle('Member/delete')) { ?> 
                                                <?php if(($vo["status"]) == C("NORMAL_STATUS")): ?><a class="btn btn-danger btn-small del" href="javascript:void(0)" data-id="<?php echo ($vo["id"]); ?>" ><i class="icon-remove  icon-white"> </i>禁用</a>
                                                <?php else: ?>
                                                <a class="btn btn-success btn-small enable" href="javascript:void(0)" data-id="<?php echo ($vo["id"]); ?>" ><i class="icon-ok  icon-white"> </i>启用</a><?php endif; ?>
                                                <?php } ?>
                                            </td>
                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                    </tbody>
                                </table>
                                <div class="row-fluid">
                                    <div class="span12 center">
                                        <div class="pagination" id="sample_1_info" style="text-align: center">
                                            <?php echo ($pages); ?>
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

<!--修改银行卡信息开始-->
    <div id="edit" class="modal hide fade in">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3>银行卡信息</h3>
        </div>
        <table class="table table-striped table-bordered">
            <tr class="memberBank">
                <th>开户行</th>
                <th>开户人</th>
                <th>银行账号</th>
                <th>默认卡</th>
                <th>操作</th>
            </tr>
  
        </table>
        <form id="editForm" method="post" class="form-horizontal" autocomplete="off">
            <div class="modal-body" >

                <table class="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <td>会员基本信息：</td>
                            <td id='memberInfo'></td>
                        </tr>
                        <tr>
                            <td>支付类型：</td>
                            <td>
                                <select name='bank_type' data-rule='required'>
                                    <option value=0>请选择</option>
                                        <?php if(is_array(C("PAY_TYPES"))): $paytypeKey = 0; $__LIST__ = C("PAY_TYPES");if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$payType): $mod = ($paytypeKey % 2 );++$paytypeKey;?><option value=<?php echo ($paytypeKey); ?>><?php echo ($payType); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>开户行：</td>
                            <td>
                                <select name='bank' data-rule='required'>
                                    <option value=0>请选择</option>
                                        <?php if(is_array(C("PAY_TYPE"))): $payBankKey = 0; $__LIST__ = C("PAY_TYPE");if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$payBank): $mod = ($payBankKey % 2 );++$payBankKey;?><option value=<?php echo ($payBankKey); ?>><?php echo ($payBank); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>银行卡号：</td>
                            <td>
                                <input type="text" name='bank_account' data-rule='required' /> 
                            </td>
                        </tr>
                        <tr>
                            <td>开户人：</td>
                            <td>
                                <input type="text"  name='bank_member' data-rule='required' /> 
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <input type="hidden" name='id' /> 
                <input type="hidden" name='member_id' /> 
                <button type="submit"  class="btn btn-success">提交</button>
                <a href="#" class="btn" data-dismiss="modal">关闭</a>
            </div>
        </form>
    </div>
    <!--修改银行卡信息结束-->

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
<script src="<?php echo (JS_URL); ?>scripts.js"></script>
 <script>
//重置密码
$('.resetpwd').click(function(){
    var id = $(this).attr('data-id');
    $.ajax({
        url: "<?php echo U('resetpwd');?>",
        type: 'post',
        data: 'id='+id,
        success: function (d) {
            var result = eval("(" + d + ")");
            alert(result.msg);
        }
    });
});

//禁用
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
                alert(result.msg);
                window.location.reload();
            } else {
                alert(result.msg);
            }
        }
    });
});

//启用
$('.enable').click(function(){
    var id = $(this).attr('data-id');
    var act = 'enable';
    $.ajax({
        url: "<?php echo U('delete');?>",
        type: 'post',
        data: 'id='+id+'&act='+act,
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
//修改银行卡信息
$('.edit').click(function () {
    var mid = $(this).attr('data-id');
    var name = $(this).attr('data-name');
    var mobile = $(this).attr('data-mobile')
    $('.afterData').remove();//清空以前的数据
    $('#memberInfo').html('');
    $.ajax({
        url: "<?php echo U('memberBankList');?>",
        type: 'post',
        data:'member_id='+mid,
        success: function (msg) {
            var result = eval("(" + msg + ")");
            var data = result.data;
             if (result.flag == 1) {
                 var length = data.length;
                 var str = '';
                 for(var i=0; i<length; i++) {
                	 str += '<tr class="afterData"><td>'+data[i].bank_name+'</td><td>'+data[i].bank_member+'</td><td>'+data[i].bank_account+'</td><td>'+data[i].status+'</td><td><a data-bank_id='+data[i].id+' data-bank='+data[i].bank+' data-bank_member='+data[i].bank_member+' data-bank_account='+data[i].bank_account+' data-bank_type='+data[i].bank_type+' href="javascript:void(0)" class="bankEdit">编辑 </a>| <a data-bank_id='+data[i].id+' href="javascript:void(0)" class="bankDel">删除</a></td></tr>'
                 }
            } else {
            	str += '<tr class="afterData"><td colspan=5>暂无银行卡信息</td></tr>'
            }
             var personInfo = '姓名：'+name+',手机号：'+mobile;
             $('#memberInfo').html(personInfo);
             $('#editForm input[name="member_id"]').val(mid);
             $('.memberBank').after(str);
             $('#edit').modal();
             $('#editForm')[0].reset();  
             bankClick();
        }
    });
});
//提交修改银行卡信息的表单
$('#editForm').bind('valid.form', function () {
	$('#edit').modal('hide');
    $.ajax({
    	url: "<?php echo U('editMemberBank');?>",
        type: 'post',
        data: $(this).serialize(),
        success: function (msg) {
        	 var result = eval("(" + msg + ")");
        	 alert(result.msg);
             if (result.flag == 1) {
                 window.location.reload();//刷新当前页面.
             }
        }
    });
});
		
//银行卡信息修改绑定的方法
function bankClick(){
	$('.bankEdit').click(function(){
		var dataBankId = $(this).attr('data-bank_id');
	    var dataBank = $(this).attr('data-bank');
	    var dataBankMember = $(this).attr('data-bank_member');
	    var dataBankAccount = $(this).attr('data-bank_account');
	    var dataBankType = $(this).attr('data-bank_type');
	    
	    $('#editForm select[name="bank_type"]').val(dataBankType);
        $('#editForm select[name="bank"]').val(dataBank);
        $('#editForm input[name="bank_account"]').val(dataBankAccount);
        $('#editForm input[name="bank_member"]').val(dataBankMember);
        $('#editForm input[name="id"]').val(dataBankId);
	});
	
	$(".bankDel").click(function() {
		var id = $(this).attr('data-bank_id');
		$.ajax({
			url:"<?php echo U('deleteMemberBank');?>",
			type:'post',
			data:'id='+id,
			success:function(msg){
				var result = eval("(" + msg + ")");
	            var data = result.data;
	            alert(result.msg);
	             if (result.flag == 1) {
	            	 //删除成功，刷新当前页面
	                 window.location.reload();
	             } 
			}
		});
	});
}
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>