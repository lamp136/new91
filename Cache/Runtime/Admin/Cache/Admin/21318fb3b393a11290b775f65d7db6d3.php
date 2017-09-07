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


<!--模态化弹框添加商家相册-->
<div id="updateContact" class="modal hide fade in" style="display: none; ">
    <form  id="data-form" method="post" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" >
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3>添加/编辑图片</h3>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-hover">
                <tbody>
                
                <tr>
                    <td>
                        相册类型:
                    </td>
                    <td>
                        <input type="radio" name="info[type]" value="<?php echo (C("GOODS_IMAGE_DETAIL")); ?>" checked>
                        详情图片
                        <input type="radio" name="info[type]" value="<?php echo (C("GOODS_IMAGE_SMALL")); ?>">
                        轮播小图
                    </td>
                </tr>
                <tr>
                    <td>
                        名　称:
                    </td>
                    <td>
                        <input type="text" name="info[title]" placeholder="名称" class="input-xlarge" value="" id="data-title" />
                    </td>
                </tr>
                <tr data-name="trTag" class="hide">
                    <td>
                        图片
                    </td>
                    <td>
                        <img name="imageUrl" style="width:50px;" src="" alt=""/>
                    </td>
                </tr>
                <tr>
                    <td>
                        上传图片:
                    </td>
                    <td>
                        <div>
                            <a href='javascript:void(0)' class="hide" data-name="add_plus" onclick='addli(this)'>[+]</a><input type="file" class="default" data-id="img_url">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        状态:
                    </td>
                    <td>
                        <input type="radio" name="info[status]" value='1' checked >正常
                        <input type="radio" name="info[status]" value='-1'>删除
                    </td>
                </tr>
                <tr>
                    <td>
                        排　序:
                    </td>
                    <td>
                        <input type="text" name="info[sort]" class="input-xlarge" value="0" />
                    </td>
                </tr>
                <input type="hidden" name="imageId" value="">
                <input type="hidden" name="p" value="<?php echo ($p); ?>"/>
                <input type="hidden" name="info[store_goods_id]" value="<?php echo ($goodsId); ?>">
                <input type="hidden" name="name" value="<?php echo ($name); ?>"/>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-success">提交</button>
            <a href="#" class="btn" data-dismiss="modal">关闭</a>
        </div>
    </form>
</div>
<!--模态框结束添加商家相册-->


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
                            <a href="<?php echo (C("ADMIN_HOME_URL")); ?>"><i class="icon-home"></i>91搜墓网后台</a> <span class="divider">&nbsp;</span>
                        </li>
                         <li><a href="<?php echo U('ServiceGoods/index',array('p'=>$p));?>">商品基础信息</a><span class="divider">&nbsp;</span></li>
                        <li><a href="javascript:viod(0);"><?php echo ($name); ?>     相册列表</a><span class="divider-last">&nbsp;</span></li>

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
                                <h4><i class="icon-reorder"></i>相册列表</h4>
                                <span class="tools">
                                    <a href="javascript:;" class="icon-plus">添加相册</a>
                                </span>
                            </div>

                            <div class="widget-body">
                                <table class="table table-striped table-bordered" id="sample_1">
                                    <thead>
                                    <tr>
                                        <th>
                                            <a href="javascript:;" id="all">全选</a>&nbsp;
                                            <a href="javascript:;" id="delAll">取消</a>&nbsp;
                                            <a href="javascript:;" id="antiAll">反选</a>&nbsp;
                                            <input type="button" id="batchDel" value="删除" style="cursor:pointer;" class="del"/>
                                        </th>
                                        <th class="hidden-phone">图片名称</th>
                                        <th class="hidden-phone">图片类型</th>
                                        <th class="hidden-phone">状态</th>
                                        <th class="hidden-phone">排序</th>
                                        <th class="hidden-phone">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="odd gradeX">
                                            <td align="center">
                                                <?php if(($vo[state]) != "-1"): ?><input name="ID_Dele" type="checkbox" id="check" value="<?php echo ($vo["id"]); ?>"/>&nbsp;
                                                <?php else: ?>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;<?php endif; ?>
                                                <img src="<?php echo ($vo["thumb_url"]); ?>" style="width:50px;" />
                                                <img width="23px" title="放大" src="/Public/Admin/Img/zoomIn.png" class="zoomIn"   data-image="<?php echo ($vo["image_url"]); ?>">
                                            </td>
                                            <td><?php echo ($vo["title"]); ?></td>
                                            <td>
                                                <?php if(C("GOODS_IMAGE_DETAIL")== $vo[type]): ?>详情图片
                                                    <?php elseif(C("GOODS_IMAGE_SMALL")== $vo[type] ): ?>轮播小图<?php endif; ?>
                                            </td>
                                            <td><?php if($vo["status"] == 1): ?>正常<?php else: ?><span style="color:red">已删除</span><?php endif; ?></td>
                                            <td><?php echo ($vo["sort"]); ?></td>
                                            <td id="w">
                                                <a href="javascript:;" data-imgId="<?php echo ($vo['id']); ?>"  data-np="<?php echo ($p); ?>" data-sname="<?php echo ($name); ?>"  class="btn btn-small btn-primary opCat data-pic">
                                                    <i class="icon-pencil icon-white"> </i> 编辑
                                                </a>
                                                <?php if($vo['status'] == 1): ?><button type="button" class="btn btn-danger btn-small del" onclick="deleteImage(<?php echo ($vo["id"]); ?>)">
                                                        <i class="icon-remove  icon-white"> </i>删除
                                                    </button>
                                                <?php else: ?>
                                                    <a href="javascript:void(0)" class="btn btn-success btn-small enable" data-imageId="<?php echo ($vo["id"]); ?>">
                                                        <i class="icon-ok  icon-white"> </i>启用
                                                    </a><?php endif; ?>
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

<!--放大图片信息开始-->
<div id="zoomIn" class="modal hide fade in">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>放大图片</h3>
    </div>
    <div class="modal-body">
        <img id="zoomInImage" src=""/>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">关闭</a>
    </div>
</div>
<!--放大图片信息结束-->


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
<!-- ie8 fixes -->
<!--[if lt IE 9]>
<script src="js/excanvas.js"></script>
<script src="js/respond.js"></script>
<![endif]-->



<!--地图封装接口 以及一些初始化的数据 -->
<script src="<?php echo (JS_URL); ?>scripts.js"></script>
<script>
    //添加图片摸态框
     $('.icon-plus').click(function(){
        $('#data-form')[0].reset();
        $('input[data-id="img_url"]').attr('name','img_url[]');
        $('a[data-name="add_plus"]').show();
        $('tr[data-name="trTag"]').hide();
        $('#updateContact').modal(); 
    });

    //表单提交事件
    $('#data-form').bind('valid.form',function(){
        var dataFrom = new FormData(document.getElementById("data-form"));
        $.ajax({
            url:"<?php echo U('saveGoodsImage');?>",
            type:'POST',
            data:dataFrom,
            processData: false,
            contentType: false,
            dataType:'json',
            success:function(d){
                if(d.flag == 1) {
                    $('#data-form').modal('hide');
                    alert(d.msg);
                    window.location.reload();
                }else{
                    alert(d.msg);
                }
            }
        });
    });

    //修改相册信息
    $('.data-pic').click(function(){
        $('#data-form')[0].reset();
        $('tr[data-name="trTag"]').show();
        $('a[data-name="add_plus"]').hide();
        $('input[data-id="img_url"]').attr('name','img_url');
        var id = $(this).attr('data-imgId');
        $.ajax({
            url:"<?php echo U('editGoodsImage');?>",
            type:'get',
            data:{id:id},
            dataType:'json',
            success:function(d){
                var data = d.data;
                if(d.flag==1){
                    $('input').removeAttr('checked');
                    $('img[name="imageUrl"]').attr({'src':data.thumb_url,'alt':data.title});
                    $("input[name='info[type]'][value="+data.type+"]").attr('checked',true);
                    $("input[name='info[title]']").val(data.title);
                    $("input[name='info[status]'][value="+data.status+"]").attr('checked',true);
                    $("input[name='info[sort]']").val(data.sort);
                    $("input[name='imageId']").val(data.id);
                    $('#updateContact').modal();
                }
            }
        })
    });

    //全选
    $('#all').click(function(){
        $("input[name='ID_Dele']").each(function(){
            $(this).attr('checked',true);
        }); 
    })
    //取消全选
    $("#delAll").click(function(){  
        $("input[name='ID_Dele']").each(function(){
            $(this).attr("checked",false);
        });  
    });
    //反选
    $("#antiAll").click(function(){
        $("input[name='ID_Dele']").each(function(){
            this.checked=!this.checked;              
        });
    })
    
    $("#batchDel").click(function(){
         if(!window.confirm('确定要删除？')){
            event.preventDefault();
        }else{
            var str = '';
            $("input[name='ID_Dele']:checked").each(function(){
                str += ($(this).val()+',');
            });
            str=str.substring(0,str.lastIndexOf(','));
            if(str==''){
                alert('没有选择删除的图片');return;
            }
            deleteImage(str);
        }
    });

    function deleteImage(id){
        if(!window.confirm('确定要删除？')){
            return false;
        }else{
            $.ajax({
                url:'<?php echo U("delImage");?>',
                type:'post',
                data:{'id':id},
                success : function(e){
                    if(e ==1){
                        window.location.reload();//刷新当前页面.
                    }else{
                        alert('删除失败');
                    }
                }
            });
        }
    }
    //启用
    $('.enable').click(function(){
        var id = $(this).attr('data-imageId');
        $.ajax({
            url: "<?php echo U('enableImage');?>",
            type: 'post',
            data: 'id='+id,
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

    function addli(a){
        var li = $(a).parent();
        if($(a).html()=="[+]"){
            var newli = li.clone();
            $(newli).find('a').html("[-]");
            $(newli).find('input').val("");
            li.after(newli);
        }else{
            li.remove();
        }
    }

    //放大图片
    $('.zoomIn').click(function(){
        var src = $(this).attr('data-image');
        $('#zoomInImage').attr('src',src);
        $('#zoomIn').modal();
    });

</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>