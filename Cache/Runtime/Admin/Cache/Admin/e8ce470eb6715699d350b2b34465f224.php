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
                            <li><a href="javascript:void(0)">职位管理</a><span class="divider-last">&nbsp;</span></li>

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
                                    <h4><i class="icon-reorder"></i>职位管理</h4>
                                    <span class="tools">
                                        <?php if (showHandle('Position/getdepartment')) { ?>
                                        <a href="javascript:;" class="icon-plus add" >添加职位</a>
                                        <?php } ?>
                                    </span>
                                </div>
                                <div class="widget-body">
                                    <table class="table table-striped table-bordered" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th>名称</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(!empty($list)): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="odd gradeX">
                                                    <td><?php echo (str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$vo["level"])); echo ($vo["title"]); ?></td>
                                                    <td>
                                                        <?php if($vo["level"] > 0): if (showHandle('Position/editposition')) { ?>
                                                            <a class="btn btn-small btn-primary edit"  href="javascript:void(0)" data-id="<?php echo ($vo["id"]); ?>"><i class="icon-pencil icon-white"> </i> 编辑</a>
                                                            <?php } if (showHandle('Position/delposition')) { ?>
                                                            <?php if(C("NORMAL_STATUS")== $vo[status]): ?><a class="btn btn-danger btn-small del" href="javascript:void(0)" data-id="<?php echo ($vo["id"]); ?>" data-status="<?php echo (C("DELETE_STATUS")); ?>"><i class="icon-remove  icon-white"> </i>删除</a>
                                                            <?php else: ?>
                                                                <a class="btn btn-primary btn-small del" href="javascript:void(0)" data-id="<?php echo ($vo["id"]); ?>" data-status="<?php echo (C("NORMAL_STATUS")); ?>"><i class="icon-pencil icon-white"> </i>开启</a><?php endif; ?>
                                                            <?php } if (showHandle('Position/adduser')) { ?>
                                                            <a class="btn btn-warning btn-small addperson" href="javascript:void(0)" data-id="<?php echo ($vo["id"]); ?>"><i class="icon-plus  icon-white"> </i>添加人员</a>
                                                            <?php } if (showHandle('Position/positionuser')) { ?>
                                                            <a class="btn btn-primary btn-small personlist" href="javascript:void(0)" data-id="<?php echo ($vo["id"]); ?>"><i class="icon-eye-open  icon-white"> </i>查看人员</a>
                                                            <?php } if (showHandle('Position/privilegeset')) { ?>
                                                            <a class="btn btn-success btn-small privilege" href="<?php echo U('privilegeset',array('id'=>$vo['id']));?>" ><i class="icon-ok  icon-white"> </i>权限分配</a>
                                                            <?php } endif; ?>
                                                    </td>
                                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                            <?php else: ?>
                                            <tr class="odd gradeX"><td colspan="2">没有记录</td></tr><?php endif; ?>
                                        </tbody>
                                    </table>
                                    
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


    <!--添加职位开始-->
    <div id="add" class="modal hide fade in">
        <form id="defaultForm" method="post" class="form-horizontal" autocomplete="off">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>添加职位</h3>
            </div>
            <div class="modal-body">

                <table class="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <td>部门：</td>
                            <td>
                                <select  name="info[pid]" id="role_pid"  data-rule="required">
                                <option value="">--请选择部门--</option>
                                
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>职位名称：</td>
                            <td>
                                <input name="info[title]"  type="text" data-rule='required'>  
                            </td>
                        </tr>
                        <tr>
                            <td>排序：</td>
                            <td>
                                <input name="info[sort]"  type="text" value='1' data-rule='required'>越大越靠前
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="submit" id='tijiao' class="btn btn-success">提交</button>
                <a href="#" class="btn" data-dismiss="modal">关闭</a>
            </div>
        </form>
    </div>
    <!--添加职位结束-->
    
    <!--编辑职位开始-->
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
                            <td>部门：</td>
                            <td>
                                <select  name="editinfo[pid]" id="e_role_pid"  data-rule="required">
                                <option value="">--请选择部门--</option>
                                
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>职位名称：</td>
                            <td>
                                <input name="editinfo[title]" id='edittitle'  type="text" data-rule='required' >  
                            </td>
                        </tr>
                        <tr>
                            <td>排序：</td>
                            <td>
                                <input name="editinfo[sort]" id='editsort' type="text" data-rule='required'>越大越靠前
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <input name="editinfo[id]"  type="hidden" id='editid' data-rule='required'>
                <button type="submit"  class="btn btn-success">提交</button>
                <a href="#" class="btn" data-dismiss="modal">关闭</a>
            </div>
        </form>
    </div>
    <!--编辑职位结束-->
    
    <!--添加职位下的人员开始-->
    <div id="addperson" class="modal hide fade in ">
        <form id="addpersonForm" method="post" class="form-horizontal" autocomplete="off">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>添加人员</h3>
            </div>
            <div class="modal-body">

                <table  class='table table-bordered table-hover tablefixed' id="dep-addUser">
                    <thead>
                        <tr>
                            <th align="center">编号</th>
                            <th align="center">姓名</th>
                            <th align="center">邮箱</th>
                            <th align="center"><input type="checkbox" id="dep-user-chkall"/>全选</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <input type="hidden" name="position_id" id="position_id">
                <button type="submit"  class="btn btn-success">提交</button>
                <a href="#" class="btn" data-dismiss="modal">关闭</a>
            </div>
        </form>
    </div>
    <!--添加职位下的人员结束-->
    
    <!--职位人员列表开始-->
    <div id="personlist" class="modal hide fade in ">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>人员列表</h3>
            </div>
            <div class="modal-body">

                <table  class='table table-bordered table-hover tablefixed' id="dep-addUser">
                    <thead>
                        <tr>
                            <th align="center">姓名</th>
                            <th align="center">邮箱</th>
                            <th align="center">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">关闭</a>
            </div>
    </div>
    <!--职位人员列表结束-->
    
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
               url:"<?php echo U('getdepartment');?>",
               type:"post",
               success:function(d){
                   var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        var data = result.data;
                        var str = '';
                        str += '<option value="">--请选择部门--</option>';
                        for(i in data){
                            str += '<option value="'+data[i].id+'">'+data[i].title+'</option>'
                        }
                        $('#role_pid').html(str);
                        $('#add').modal();
                    } else {
                        alert(result.msg);
                    }
                    
               }
            });
            
        });

        //提交添加职位form 表单
        $('#defaultForm').bind('valid.form', function () {
            $('#add').modal('hide');
            $.ajax({
                url: "<?php echo U('addposition');?>",
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
        
        //点击编辑职位，弹出编辑职位表单
        $('.edit').click(function () {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "/system.php/Position/editposition/id/"+id,
                type: 'GET',
                success: function (d) {
                    var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        var data = result.data;
                        var department = result.department;
                        var str = '';
                        str += '<option value="">--请选择部门--</option>';
                        for(i in department){
                            if(department[i].id==data.pid){
                                str += '<option value="'+department[i].id+'" selected>'+department[i].title+'</option>';
                            }else{
                                str += '<option value="'+department[i].id+'">'+department[i].title+'</option>';
                            }
                        }
                        $('#e_role_pid').html(str);
                        $('#edittitle').val(data.title);
                        $('#editsort').val(data.sort);
                        $('#editid').val(data.id);
                        $('#edit').modal();
                    }
                }
            });
        });

        //提交编辑职位form 表单
        $('#editForm').bind('valid.form', function () {
            $('#edit').modal('hide');
            $.ajax({
                url: "<?php echo U('editposition');?>",
                type: 'POST',
                data: $(this).serialize(),
                success: function (d) {
                    var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        alert('修改成功');
                        window.location.reload();
                    } else {
                        alert('修改失败');
                    }
                }
            });
        });
        
        //删除职位
        $('.del').click(function(){
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            $.ajax({
                url: "<?php echo U('delposition');?>",
                type: 'POST',
                data: {'id':id,'status':status},
                //data: 'id='+id,
                success: function (d) {
                    var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        alert(result.msg);
                        window.location.reload();
                    } else {
                        alert('删除失败');
                    }
                }
            });
        });
        
        //弹出添加人员表单
        $('.addperson').click(function(){
            var id = $(this).attr('data-id');
            $.ajax({
                url: "/system.php/Position/adduser/id/"+id,
                type: 'GET',
                success:function(d){
                    var result = eval("("+d+")");
                    if(result.flag==0){
                        alert('请先添加管理员');
                    }else{
                        var str = '';
                        var admindata = result.admindata
                        var roleuser = result.roleuser;
                        for(i in admindata){
                            str +='<tr>';
                            str +='<td align="right">'+admindata[i].id+'</td>';
                            str +='<td align="right">'+admindata[i].nickname+'</td>';
                            str +='<td align="right">'+admindata[i].email+'</td>';
                            str +='<td align="center">';
                            if($.inArray(admindata[i].id,roleuser)>=0){
                                str +='<input type="checkbox" name="uid[]" class="depUserId" value="'+admindata[i].id+'" checked="checked" disabled="disabled">';
                            }else{
                                str +='<input type="checkbox" name="uid[]" class="depUserId" value="'+admindata[i].id+'">';
                            }
                            str +='</td></tr>';
                        }
                        $('#dep-addUser tbody').html(str);
                        $('#position_id').val(id);
                        $('#addperson').modal();
                    }
                }
            });
        });
        
        //提交添加人员表单
        $('#addpersonForm').bind('valid.form', function () {
            $('#addperson').modal('hide');
            $.ajax({
                url: "<?php echo U('adduser');?>",
                type: 'POST',
                data: $(this).serialize(),
                success: function (d) {
                    var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        alert('新增成功');
                        window.location.reload();
                    } else {
                        alert(result.msg);
                    }
                }
            });
        });
        
        //查看人员
        $('.personlist').click(function(){
            var positionId = $(this).attr('data-id');
            $.ajax({
                url: "<?php echo U('positionuser');?>",
                type: 'POST',
                data: 'id='+positionId,
                success: function (d) {
                    var result = eval("(" + d + ")");
                    var str = '';
                    if (result.flag == 1) {
                        var data = result.data;
                        for(i in data){
                            str +='<tr>';
                            str +='<td align="right">'+data[i].Admin.nickname+'</td>';
                            str +='<td align="right">'+data[i].Admin.email+'</td>';
                            str +='<td align="center">';
                            str +='<a class="btn btn-danger btn-small delperson" href="javascript:void(0)" data-user-id="'+data[i].user_id+'" data-position-id="'+data[i].role_job_id+'" ><i class="icon-remove  icon-white"> </i>删除</a>';
                            str +='</td></tr>';
                        }
                    } else {
                        str += '<tr><td colspan=3>暂无人员记录</td></tr>';
                    }
                    $('#dep-addUser tbody').html(str);
                    $('#personlist').modal();
                }
            });
        });
        
        
        //删除职位下的人员
        $('.delperson').live('click',function(){
            var positionId = $(this).attr('data-position-id');
            var userId = $(this).attr('data-user-id');
            var that = $(this);
            $.ajax({
                url: "<?php echo U('delpositionuser');?>",
                type: 'POST',
                data: 'userId='+userId+'&positionId='+positionId,
                success: function (d) {
                    var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        that.parents('tr').remove();
                    } else {
                        alert(result.msg);
                    }
                }
            });
        });
        
        
        //全选/取消
        $('#dep-user-chkall').die().live('click', function (e) {
            if (!$(this).is(':checked')) {
                $('.depUserId').attr('checked',false);
            } else {
                
               $('.depUserId').attr('checked',true);;
            }
         });
    </script>
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>