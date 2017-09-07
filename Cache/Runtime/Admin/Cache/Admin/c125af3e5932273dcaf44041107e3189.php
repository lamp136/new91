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
        <style type='text/css'>
            .noboder{
                border: none;
            }
            .noboder td{
                border: none;
            }
            .noboder a{
                margin-left: 8px;
            }
        </style>
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
                            <li><a href="javascript:void(0)">菜单列表</a><span class="divider-last">&nbsp;</span></li>

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
                                    <h4><i class="icon-reorder"></i>菜单列表</h4>
                                    <span class="tools">
                                        <?php if (showHandle('Privilege/addprivilege')) { ?>
                                            <a href="javascript:void(0);" class="icon-plus add" >添加菜单</a>
                                        <?php } ?>
                                    </span>
                                </div>
                                <div class="widget-body">
                                    <div class="space10"></div>
                                    <div style="float: left;width:120px; padding-left: 20px;">
                                        <ul class='unstyled'>
                                            <?php if(is_array($privilegeMenu)): $i = 0; $__LIST__ = $privilegeMenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('index',array('id'=>$vo['id']));?>"><i class=" icon-book"></i> <?php echo ($vo["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </ul>
                                    </div>
                                    <div class="span10">
                                        <table  class='table table-striped table-bordered table-hover'>
                                            <thead>
                                                <tr><th colspan="2" style='text-align:center;'><?php echo ($currentPrivilege["title"]); ?>-功能列表</th></tr>
                                                <tr>
                                                    <th width="15%">功能块</th>
                                                    <th><span>菜单</span> <span style="margin-left: 20%;">操作方法</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(is_array($first)): $i = 0; $__LIST__ = $first;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$firstVal): $mod = ($i % 2 );++$i;?><tr>
                                                        <td>
                                                            <a href="javascript:void(0);"   class="btn btn-small edit" data-id='<?php echo ($firstVal["id"]); ?>'><?php echo ($firstVal["title"]); ?></a>
                                                            <?php if (showHandle('Privilege/delprivilege')) { ?>
                                                                <span class="btn btn-danger btn-small del" data-id='<?php echo ($firstVal["id"]); ?>'><i class="icon-remove  icon-white"></i></span>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <table width="100%" class='noboder'>
                                                                <?php if(is_array($two[$firstVal['id']])): $i = 0; $__LIST__ = $two[$firstVal['id']];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$twoVal): $mod = ($i % 2 );++$i;?><tr>
                                                                    <td height='35' width='20%'>
                                                                        <a href="javascript:void(0);"  class="btn btn-small edit" data-id='<?php echo ($twoVal["id"]); ?>'><?php echo ($twoVal["title"]); ?></a>
                                                                        <?php if (showHandle('Privilege/delprivilege')) { ?>
                                                                            <span class="btn btn-danger btn-small del" data-id='<?php echo ($twoVal["id"]); ?>'><i class="icon-remove  icon-white"></i></span>
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td width='80%'>
                                                                        <?php if(is_array($three[$twoVal['id']])): $i = 0; $__LIST__ = $three[$twoVal['id']];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$threeVal): $mod = ($i % 2 );++$i;?><a href="javascript:void(0)"  class="btn btn-small edit" data-id='<?php echo ($threeVal["id"]); ?>'><?php echo ($threeVal["title"]); ?></a>
                                                                            <?php if (showHandle('Privilege/delprivilege')) { ?>
                                                                                <span class="btn btn-danger btn-small del" data-id='<?php echo ($threeVal["id"]); ?>'><i class="icon-remove  icon-white"></i></span>
                                                                            <?php } endforeach; endif; else: echo "" ;endif; ?>
                                                                    </td>
                                                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                                            </table>
                                                        </td>
                                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class='space10'></div>
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


    <!--添加菜单开始-->
    <div id="add" class="modal hide fade in">
        <form id="defaultForm" method="post" class="form-horizontal" autocomplete="off">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>添加菜单</h3>
            </div>
            <div class="modal-body">

                <table class="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <td>上级权限：</td>
                            <td>
                                <select  name="Privilege[pid]" id="privilege_pid"  data-rule="required">

                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>权限名称：</td>
                            <td>
                                <input name="Privilege[title]"  type="text" data-rule='required'>  
                            </td>
                        </tr>
                        <tr>
                            <td>权限地址：</td>
                            <td>
                                <input name="Privilege[name]"  type="text" >控制器/方法
                            </td>
                        </tr>
                        <tr>
                            <td>地址类型：</td>
                            <td>
                                <input type='radio' name='Privilege[type]' value='0' checked />菜单&nbsp;&nbsp;
                                <input type='radio' name='Privilege[type]' value='1' />方法
                                <span class="alert alert-info form-inline">菜单：用于显示，方法：不显示。</span>
                            </td>
                        </tr>
                        <tr>
                            <td>是否启用：</td>
                            <td>
                                <input type='radio' name='Privilege[status]' value='1' checked />启用&nbsp;&nbsp;
                                <input type='radio' name='Privilege[status]' value='-1' />禁用
                            </td>
                        </tr>
                        <tr>
                            <td>排序：</td>
                            <td>
                                <input name="Privilege[sort]"  type="text" value='1' data-rule='required'>越大越靠前
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">提交</button>
                <a href="#" class="btn" data-dismiss="modal">关闭</a>
            </div>
        </form>
    </div>
    <!--添加菜单结束-->

    <!--编辑菜单开始-->
    <div id="edit" class="modal hide fade in">
        <form id="editForm" method="post" class="form-horizontal" autocomplete="off">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>编辑职位</h3>
            </div>
            <div class="modal-body">

                <table class="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <td>上级权限：</td>
                            <td>
                                <select  name="editPrivilege[pid]" id="edit_privilege_pid"  data-rule="required">

                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>权限名称：</td>
                            <td>
                                <input name="editPrivilege[title]" id="edit_privilege_title"  type="text" data-rule='required'>  
                            </td>
                        </tr>
                        <tr>
                            <td>权限地址：</td>
                            <td>
                                <input name="editPrivilege[name]"  id="edit_privilege_name" type="text" >控制器/方法
                            </td>
                        </tr>
                        <tr>
                            <td>地址类型：</td>
                            <td>
                                <input type='radio' name='editPrivilege[type]'  value='0' checked />菜单&nbsp;&nbsp;
                                <input type='radio' name='editPrivilege[type]' value='1' />方法
                                <span class="alert alert-info form-inline">菜单：用于显示，方法：不显示。</span>
                            </td>
                        </tr>
                        <tr>
                            <td>是否启用：</td>
                            <td>
                                <input type='radio' name='editPrivilege[status]' value='1' />启用&nbsp;&nbsp;
                                <input type='radio' name='editPrivilege[status]' value='-1' />禁用
                            </td>
                        </tr>
                        <tr>
                            <td>排序：</td>
                            <td>
                                <input name="editPrivilege[sort]" id="edit_privilege_sort"  type="text" data-rule='required'>越大越靠前
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <input name="editPrivilege[id]"  type="hidden" id='edit_privilege_id' data-rule='required'>
                <button type="submit"  class="btn btn-success">提交</button>
                <a href="#" class="btn" data-dismiss="modal">关闭</a>
            </div>
        </form>
    </div>
    <!--编辑菜单结束-->



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
    <script>

        //点击添加职位，弹出添加职位表单
        $('.add').click(function () {
            $.ajax({
                url: "<?php echo U('getprivilege');?>",
                type: "get",
                success: function (d) {
                    var result = eval("(" + d + ")");
                    var str = '';
                    if (result.flag == 1) {
                        var data = result.data;
                        str += '<option value="">--请选择--</option>';
                        str += '<option  value="0">顶级</option>';
                        for (i in data) {
                            if (data[i].level == 0) {
                                str += '<option value="' + data[i].id + '">|--' + data[i].title + '</option>';
                            } else if (data[i].level == 1) {
                                str += '<option value="' + data[i].id + '">&nbsp;&nbsp;|--' + data[i].title + '</option>';
                            } else if (data[i].level == 2) {
                                str += '<option value="' + data[i].id + '">&nbsp;&nbsp;&nbsp;&nbsp;|--' + data[i].title + '</option>';
                            }
                        }

                    } else {
                        str += '<option value="">--请选择--</option>';
                        str += '<option  value="0">顶级</option>';
                    }
                    $('#privilege_pid').html(str);
                    $('#add').modal();
                }
            });

        });

        //提交添加菜单的form 表单
        $('#defaultForm').bind('valid.form', function () {
            $('#add').modal('hide');
            $.ajax({
                url: "<?php echo U('addprivilege');?>",
                type: 'POST',
                data: $(this).serialize(),
                success: function (d) {
                    var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        alert('添加成功');
                        window.location.reload();
                    } else {
                        alert('添加失败');
                    }
                }
            });
        });

        //点击编辑菜单，弹出编辑菜单表单
        $('.edit').click(function () {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "/system.php/Privilege/editprivilege/id/" + id,
                type: 'GET',
                success: function (d) {
                    var result = eval("(" + d + ")");
                    var str ='';
                    if (result.flag == 1) {
                        $("input[name='editPrivilege[status]']").removeAttr("checked"); 
                        $("input[name='editPrivilege[type]']").removeAttr("checked"); 
                        var currentprivilege = result.currentprivilege;
                        var privilegeTree = result.privilegeTree;
                        str += '<option value="">--请选择--</option>';
                        str += '<option  value="0">顶级</option>';
                        for (i in privilegeTree) {
                            if (privilegeTree[i].level == 0) {
                                if(privilegeTree[i].id==currentprivilege.pid){
                                    str += '<option value="' + privilegeTree[i].id + '" selected>|--' + privilegeTree[i].title + '</option>';
                                }else{
                                    str += '<option value="' + privilegeTree[i].id + '">|--' + privilegeTree[i].title + '</option>';
                                }
                            } else if (privilegeTree[i].level == 1) {
                                if(privilegeTree[i].id==currentprivilege.pid){
                                    str += '<option value="' + privilegeTree[i].id + '" selected>&nbsp;&nbsp;|--' + privilegeTree[i].title + '</option>';
                                }else{
                                    str += '<option value="' + privilegeTree[i].id + '">&nbsp;&nbsp;|--' + privilegeTree[i].title + '</option>';
                                }
                            } else if (privilegeTree[i].level == 2) {
                                if(privilegeTree[i].id==currentprivilege.pid){
                                    str += '<option value="' + privilegeTree[i].id + '" selected>&nbsp;&nbsp;&nbsp;&nbsp;|--' + privilegeTree[i].title + '</option>';
                                }else{
                                    str += '<option value="' + privilegeTree[i].id + '">&nbsp;&nbsp;&nbsp;&nbsp;|--' + privilegeTree[i].title + '</option>';
                                }
                            }
                        }
                        $('#edit_privilege_pid').html(str);
                        $('#edit_privilege_title').val(currentprivilege.title);
                        $('#edit_privilege_name').val(currentprivilege.name);
                        $('#edit_privilege_sort').val(currentprivilege.sort);
                        $('#edit_privilege_id').val(currentprivilege.id);
                        $("input[name='editPrivilege[status]'][value="+currentprivilege.status+"]").attr("checked",true); 
                        $("input[name='editPrivilege[type]'][value="+currentprivilege.type+"]").attr("checked",true); 
                        $('#edit').modal();
                    }
                }
            });
        });

        //提交编辑菜单form 表单
        $('#editForm').bind('valid.form', function () {
            $('#edit').modal('hide');
            $.ajax({
                url: "<?php echo U('editprivilege');?>",
                type: 'POST',
                data: $(this).serialize(),
                success: function (d) {
                    var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        alert('修改成功');
                        window.location.reload();
                    } else {
                        alert(result.msg);
                    }
                }
            });
        });
        //删除菜单
        $('.del').click(function(){
            var id = $(this).attr('data-id');
            if(confirm("你确认要删除么？")){
                $.ajax({
                    url: "<?php echo U('delprivilege');?>",
                    type: 'POST',
                    data: {'id':id},
                    success:function(d){
                        var result = eval("(" + d + ")");
                        if (result.flag == 1) {
                            alert(result.msg);
                            window.location.reload();
                        } else {
                            alert(result.msg);
                        }
                    },
                });
            }
        });
    </script>
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>