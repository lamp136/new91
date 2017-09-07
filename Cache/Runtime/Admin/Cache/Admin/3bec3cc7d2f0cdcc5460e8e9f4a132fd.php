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
                                <a href="<?php echo ('Index/index');?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span>
                            </li>
                            <li>
                                <a href="<?php echo ('Index/index');?>">91搜墓网后台</a> <span class="divider">&nbsp;</span>
                            </li>
                            <li><a href="javascript:void(0)">分类管理</a><span class="divider-last">&nbsp;</span></li>

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
                                    <h4><i class="icon-reorder"></i>分类管理</h4>
                                </div>
                                <div class="widget-body">
                                    <?php if (showHandle('Category/saveCateggory')){ ?>
                                        <form id="quickForm" method="post" class="form-horizontal" autocomplete="off">
                                            添加分类：<input type="hidden" value="add" name="act">
                                            <select name='pid'>
                                                <option value="0">--顶级分类--</option>
                                                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["cid"]); ?>"><?php if(($vo["level"]) != "0"): echo (str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$vo["level"])); ?>├<?php echo ($vo["name"]); else: echo ($vo["name"]); endif; ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                            <input type="text" value="" name="name" class="input" id="newName" placeholder="你要添加的分类名称">
                                            <button class="btn btn-primary add">确定添加</button>
                                        </form>
                                    <?php } ?>

                                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th style="width:4%">原分类CID</th>
                                                <th style="width:22%">名称</th>
                                                <th style="width:15%">操作方法</th>
                                                <th style="width:15%">新分类</th>
                                                <th style="width:15%">修改后的名称</th>
                                                <th style="width:9%">排序</th>
                                                <th style="width:20%">操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(!empty($list)): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="<?php echo ($vo["pid"]); ?>"  status='off'  <?php if($vo["pid"] > 0): ?>style='display:none;'<?php endif; ?>>
                                                    <td><?php echo ($vo["cid"]); ?></td>
                                                    <td class='onOff' data-cid='<?php echo ($vo["cid"]); ?>'><?php echo (str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$vo["level"])); ?><span style="color:green;">►</span><span name="name" style="color:green;"><?php echo ($vo["name"]); ?></span></td>
                                                    <td>
                                                        <select class="act" name="act" style="width:150px;">
                                                            <option value="edit" selected="selected">修改该分类</option>
                                                            <option value="add">在该分类中添加子类</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name='pid'  style="width:150px;">
                                                            <option value="0">顶级分类</option>
                                                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v1["cid"]); ?>" <?php if(($v1["cid"]) == $vo["cid"]): ?>selected<?php endif; ?>><?php if(($v1["level"]) != "0"): echo (str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$v1["level"])); ?>├<?php echo ($v1["name"]); else: echo ($v1["name"]); endif; ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                    </td>
                                                    <td><input style="width:150px;" type="text" placeholder="你要修改分类的新名称" class="input" name="name" value=""></td>
                                                    <td><input type="text" style="width:40px;" name="sort" value="<?php echo ($vo["sort"]); ?>"/></td>
                                                    <td>
                                                        <?php if (showHandle('Category/saveCateggory')){ ?>
                                                            <a class="btn btn-small btn-primary opCat"  href="javascript:void(0)" data-cid="<?php echo ($vo["cid"]); ?>"><i class="icon-pencil icon-white"> </i> 确定</a>
                                                            <?php if(($vo["is_show"]) == C("NORMAL_STATUS")): ?><a class="btn btn-danger btn-small del" href="javascript:void(0)" data-cid="<?php echo ($vo["cid"]); ?>" ><i class="icon-remove  icon-white"> </i>删除</a>
                                                            <?php else: ?>
                                                            <a class="btn btn-success btn-small enable" href="javascript:void(0)" data-cid="<?php echo ($vo["cid"]); ?>" data-pid="<?php echo ($vo["pid"]); ?>"><i class="icon-ok  icon-white"> </i>启用</a><?php endif; ?>
                                                        <?php } ?>
                                                    </td>
                                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                            <?php else: ?>
                                            <tr class="odd gradeX"><td colspan="3">没有记录</td></tr><?php endif; ?>
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

    <script src="<?php echo (JS_URL); ?>scripts.js"></script>
    <script>
        //地区展开和收起开始
        $('.onOff').click(function(){
            var status = $(this).parent().attr('status');
            var id = $(this).attr('data-cid');
            if(status == 'off'){
                $(this).html($(this).html().replace('►','▼'));
                $('.'+id).css('display','');
                $(this).parent().attr('status','on');
            }else if(status == 'on'){
                limit(id);
                $(this).html($(this).html().replace('▼','►'));
                $('.'+id).css('display','none');
                $(this).parent().attr('status','off');
            }
        });
        function limit(id){
            $('.'+id).each(function(){
                if($(this).attr('status')=='on'){
                    var tmp = $(this).children("td").html();//获取cid(第一个td中的内容)
                    limit(tmp);
                    $(this).find('.onOff').trigger('click');
                }
            });
        }
        //地区展开和收起结束
        
        
        $('#quickForm').submit(function () {
            var newName = $('#newName').val();
            if (newName == '') {
                alert('分类名称不能为空');
                return false;
            }
            $.ajax({
                url: "<?php echo U('saveCateggory');?>",
                type: 'post',
                data: $('#quickForm').serialize(),
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
            return false;
        });
        
        $('.opCat').click(function(){
            var obj = $(this).parent().parent();
            var name = (obj.find('input[name="name"]')).val();
            var act = (obj.find('select[name="act"]')).val();
            var pid = (obj.find('select[name="pid"]')).val();
            var sort = (obj.find('input[name="sort"]')).val();
            var cid = $(this).attr('data-cid');
            if(name == ''){
                name = (obj.find('span[name="name"]')).html();
            }
            if(name=='' && act=='add'){
                alert('分类名称不能为空！');
                return false;
            }
            if(sort.length == 0){
                alert('排序不能这空！');
                return false;
            }
            $.ajax({
                url: "<?php echo U('saveCateggory');?>",
                type: 'post',
                data: 'name='+name+'&act='+act+'&pid='+pid+'&cid='+cid+'&sort='+sort,
                success: function (d) {
                    var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        $('input[name="name"]').val('');
                        alert(result.msg);
                        window.location.reload();
                    } else {
                        alert(result.msg);
                    }
                }
            });
        });
        
        //删除
        $('.del').click(function(){
            var cid = $(this).attr('data-cid');
            var act = 'del';
            $.ajax({
                url: "<?php echo U('saveCateggory');?>",
                type: 'post',
                data: 'cid='+cid+'&act='+act,
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
            var cid = $(this).attr('data-cid');
            var pid = $(this).attr('data-pid');
            var act = 'enable';
            $.ajax({
                url: "<?php echo U('saveCateggory');?>",
                type: 'post',
                data: 'cid='+cid+'&act='+act+'&pid='+pid,
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




    </script>
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>