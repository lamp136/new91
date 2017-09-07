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
        <style type="text/css">
            .address{
                position: absolute;
                width: 200px;
                background: #fff;
                border: 1px solid #666;
                z-index: 100;
            }
            .provincecity{
                position: relative;
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
                            <li><a href="javascript:void(0)">合同档案列表</a><span class="divider-last">&nbsp;</span></li>

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
                                    <h4><i class="icon-reorder"></i>陵园档案列表</h4>
                                    <?php if (showHandle('StoreProfiles/add')) { ?>
                                        <span class="tools">
                                            <a href="<?php echo U('StoreProfiles/add');?>" class="icon-plus">添加档案</a>
                                        </span>
                                    <?php } ?>
                                </div>
                                <div class="widget-body">
                                    <form id="quickForm" method="get" class="form-horizontal" autocomplete="off" action='<?php echo U("index");?>'>
                                    <table>
                                        <tr>
                                            <td>搜索：</td>
                                            <td><input type="text" name="show_store_name" value='<?php echo ($choice[show_store_name]); ?>'  placeholder="商家名称"><td/>
                                            <td>
                                                <select name="category_id" class="input-medium">
                                                    <option value="">请选择商家类型</option>
                                                    <?php if(is_array($merchant)): $key = 0; $__LIST__ = $merchant;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$member): $mod = ($key % 2 );++$key;?><option value="<?php echo ($member["cid"]); ?>" <?php if($member[cid] == $choice[category_id]): ?>selected<?php endif; ?>><?php echo ($member["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                </select>
                                            <td/>
                                            <td>
                                                <select class="input-small m-wrap" tabindex="1" name="search_province" id="province">
                                                   <option value="0">选择省</option>
                                                   <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["region_id"]); ?>" <?php if($choice['province'] == $vo['region_id']): ?>selected="selected"<?php endif; ?>><?php echo ($vo["region_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                               </select>
                                             </td>
                                             <td>
                                               <select class="input-small m-wrap" tabindex="1" name="search_city" id="city">
                                                   <option value="0">选择市</option>
                                                   <?php if(is_array($city)): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vi): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vi["region_id"]); ?>"  <?php if($choice['city'] == $vi['region_id']): ?>selected="selected"<?php endif; ?> ><?php echo ($vi["region_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                               </select>
                                            </td>
                                            <td>
                                                <select name='choicetime' class="input-medium">
                                                    <option value="">选择合同过期时间</option>
                                                    <option value="long" <?php if(($choice[time]) == "long"): ?>selected='selected'<?php endif; ?>>已过期一月</option>
                                                    <?php if(is_array(C("CHOICE_TIMES"))): $i = 0; $__LIST__ = C("CHOICE_TIMES");if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($choice[time]) == $key): ?>selected='selected'<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                </select>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary">确定</button>
                                            </td>
                                        </tr>
                                    </table>
                                    </form>
                                    <div class="form-horizontal">
                                        <?php if (showHandle('StoreProfiles/editprofiles')){ ?>
                                            <a class="btn btn-small btn-primary editprofiles" href="javascript:;" ><i class="icon-pencil icon-white"> </i>编辑</a>&nbsp;
                                        <?php } if (showHandle('StoreProfiles/delprofiles')){ ?>  
                                            <a class="btn btn-danger btn-small delprofiles" href="javascript:void(0)"><i class="icon-remove  icon-white"></i>删除</a>&nbsp;
                                        <?php } if (showHandle('StoreProfiles/addProfilesDetail')){ ?>
                                            <a href="javascript:;"  class="btn btn-small btn-primary addProfiles"><i class="icon-remove  icon-plus"></i>添加</a>
                                        <?php } ?>
                                    </div>
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="text-align:center; width:1%;" >选择</th>
                                                <th rowspan="2" style="text-align:center; width:12%;" >商家名称</th>
                                                <th rowspan="2" style="text-align:center; width:7%;">地址</th>
                                                <th rowspan="2" style="text-align:center; width:5%;" >商家分类</th>
                                                <th colspan="10" style="text-align:center; width:75%; " >详细信息</th>
                                            </tr>
                                            <tr>
                                                <th width="9%">合同名称</th>
                                                <th width="4%">商品分类</th>
                                                <th width="4%">会员类型</th>
                                                <th width="5%">佣金</th>
                                                <th width="4%">结算时间</th>
                                                <th width="12%">联系方式</th>
                                                <th width="7%">合同时间</th>
                                                <th width="7%">合同续签</th>
                                                <th width="5%">备注</th>
                                                <th width="18%">操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(!empty($vo["StoreProtilesDetail"])): ?><tr class='tr'>
                                                    <td rowspan="<?php echo ($vo["profiles_detail_num"]); ?>" style="text-align:center;">
                                                        <input name="ID_Dele" type="checkbox" class="checkboxs" id="check" value="<?php echo ($vo["id"]); ?>"/>
                                                    </td>
                                                    <td rowspan="<?php echo ($vo["profiles_detail_num"]); ?>" style="text-align:center;">
                                                        <?php echo ($vo["show_store_name"]); ?> 
                                                        <?php if (showHandle('StoreProfiles/preview')){ ?>
                                                            <span class="preview" data-id = <?php echo ($vo["id"]); ?> style="color:blue;cursor: pointer;">【预览】</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td rowspan="<?php echo ($vo["profiles_detail_num"]); ?>" style="text-align:center;" class="provincecity"><?php echo ($vo["Province"]["region_name"]); ?>/<?php echo ($vo["City"]["region_name"]); ?>
                                                        <div class='hide address'>
                                                            <?php echo ($vo["address"]); ?>
                                                        </div>
                                                    </td>
                                                    <td rowspan="<?php echo ($vo["profiles_detail_num"]); ?>" style="text-align:center;">
                                                        <?php if(is_array($merchant)): $key = 0; $__LIST__ = $merchant;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$member): $mod = ($key % 2 );++$key; if($member[cid] == $vo[category_id]): echo ($member["name"]); endif; endforeach; endif; else: echo "" ;endif; ?>
                                                    </td>
                                                </tr><?php endif; ?>
                                            <?php if(is_array($vo["StoreProtilesDetail"])): $i = 0; $__LIST__ = $vo["StoreProtilesDetail"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;?><tr>
                                                    <td><?php echo ($voo["profile_name"]); ?></td>
                                                    <td>
                                                        <?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i; if($cat[cid] == $voo[category_id]): echo ($cat["name"]); endif; endforeach; endif; else: echo "" ;endif; ?>
                                                    </td>
                                                    <td>
                                                         <?php switch($voo["member_status"]): case "0": ?>否<?php break;?>
                                                             <?php case C("STOER_MERMBER_V"): echo (C("STOER_MERMBER_MSG")); break;?>
                                                             <?php case C("STOER_MERMBER"): echo (C("STOER_MERMBER_MSG")); break;?>
                                                             <?php case C("STOER_MERMBER_PERSON"): echo (C("STOER_MERMBER_PERSON_MSG")); break;?>
                                                             <?php case C("STOER_MERMBER_AD"): echo (C("STOER_MERMBER_AD_MSG")); break; endswitch;?>
                                                     </td>
                                                     <td>
                                                         <?php if($voo["return_amount"] != 0): ?>&nbsp;<?php echo ($voo["return_amount"]); ?>%<?php endif; ?>
                                                     </td>
                                                     <td><?php echo ($voo["settlement_time"]); ?></td>
                                                     <td ><?php echo ($voo["contact_man"]); if(!empty($voo["mobile"])): ?>：<?php echo ($voo["mobile"]); ?><br/><?php endif; if(!empty($voo["telephone"])): ?>：<?php echo ($voo["telephone"]); endif; ?></td>
                                                     <td>
                                                         <?php echo (date('Y-m-d',$voo["start_time"])); ?>至<?php echo (date('Y-m-d',$voo["end_time"])); ?>
                                                     </td>
                                                     <td>
                                                         <?php if(is_array($vo["StoreProfilesRenew"])): $key = 0; $__LIST__ = $vo["StoreProfilesRenew"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vooo): $mod = ($key % 2 );++$key; if($voo[id] == $vooo[store_profiles_detail_id]): ?><span><?php echo ($key); ?>:<?php echo (date('Y-m-d',$vooo["renew_start_time"])); ?>至<?php echo (date('Y-m-d',$vooo["renew_end_time"])); ?> </span><br/>
                                                                <?php if($key == count($vo[StoreProfilesRenew])): if (showHandle('StoreProfiles/delRenewTime')){ ?>
                                                                        <a  href="javascript:;" data-id ="<?php echo ($vooo["id"]); ?>"  class="delRenewTime" >删除</a>
                                                                    <?php } endif; endif; endforeach; endif; else: echo "" ;endif; ?>
                                                     </td>
                                                     <td><?php echo ($voo["remarks"]); ?></td>
                                                     <td>
                                                        <?php if (showHandle('StoreProfiles/edit')){ ?>
                                                            <a class="btn btn-small btn-primary" href="<?php echo U('StoreProfiles/edit', array('id'=>$voo['id'],'np'=>$nowPage));?>"><i class="icon-pencil icon-white"> </i>编辑</a>
                                                        <?php } if (showHandle('StoreProfiles/renew')){ ?>
                                                            <a class="btn btn-success btn-small renew" href="javascript:void(0)" data-id="<?php echo ($voo["id"]); ?>" ><i class="icon-ok  icon-white"> </i>续签</a>
                                                        <?php } if (showHandle('StoreProfiles/giveup')){ ?>
                                                           <a class="btn btn-danger btn-small giveup" href="javascript:void(0)" data-id="<?php echo ($voo["id"]); ?>" data-status="<?php echo (C("DELETE_STATUS")); ?>" ><i class="icon-remove  icon-white"> </i>放弃</a>
                                                        <?php } if (showHandle('StoreProfiles/imageList')){ ?>
                                                           <a href="<?php echo U('StoreProfiles/imageList', array('id'=>$voo['id'],'np'=>$nowPage,'showStoreName'=>$vo[show_store_name]));?>"  class="btn btn-small"><i class="icon-picture"> </i>图片</a>
                                                        <?php } ?>
                                                     </td>
                                                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </tbody>
                                    </table>
                                    <div class="row-fluid">
                                        <div class="span12 center">
                                            <div class="pagination" id="sample_1_info" >
                                                <span style="text-align: left">
                                                    <?php if (showHandle('StoreProfiles/editprofiles')){ ?>
                                                        <a class="btn btn-small btn-primary editprofiles" href="javascript:;" ><i class="icon-pencil icon-white"> </i>编辑</a>&nbsp;
                                                    <?php } if (showHandle('StoreProfiles/delprofiles')){ ?>  
                                                        <a class="btn btn-danger btn-small delprofiles" href="javascript:void(0)"><i class="icon-remove  icon-white"></i>删除</a>&nbsp;
                                                    <?php } if (showHandle('StoreProfiles/addProfilesDetail')){ ?>
                                                        <a href="javascript:;"  class="btn btn-small btn-primary addProfiles"><i class="icon-remove  icon-plus"></i>添加</a>
                                                    <?php } ?>
                                                </span>
                                                <span style="text-align: right">
                                                    <?php echo ($page); ?>
                                                </span>
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

    <!--续签信息开始-->
    <div id="renew" class="modal hide fade in" style='width:650px;'>
        <form id="renewForm" method="post" class="form-horizontal" autocomplete="off">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>续签</h3>
            </div>
            <div class="modal-body">

                <table class="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <td>合同名称：</td>
                            <td class='store_name'></td>
                        </tr>
                        <tr>
                            <td colspan='2'>上次合同结束时间：<span class='last_end_time text-success'></span></td>
                        </tr>
                        <tr>
                            <td>续签开始时间：</td>
                            <td>
                                <input type='text' name='renew_start_time' onClick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" class="Wdate"><span class='text-success'>不选的话默认就是上次合同的结束时间。</span>
                            </td>
                        </tr>
                        <tr>
                            <td>续签结束时间：</td>
                            <td>
                                <input type='text' name='renew_end_time' onClick="WdatePicker({dateFmt: 'yyyy-MM-dd'})" class="Wdate" data-rule='required' />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <input type='hidden' id='store_profiles_id' name='store_profiles_detail_id'></input>
                <input type='hidden'  name='store_profiles_id'></input>
                <button type="submit" class="btn btn-success">提交</button>
                <a href="#" class="btn" data-dismiss="modal">关闭</a>
            </div>
        </form>
    </div>
    <!--续签信息结束-->
    
    <!--模态化弹框添加商家联系人信息-->
    <div id="giveup" class="modal hide fade in" style="display: none; ">
        <form id="giaveUpForm" method="post" class="form-horizontal" autocomplete="off">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>请输入放弃理由</h3>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover">
                    <tbody>
                    <tr>
                        <td>放弃理由：</td>
                        <td>
                            <textarea name="reason" class="input-xlarge reason" row="3" data-rule="required"></textarea>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <input type='hidden' id='id' name='id'></input>
                <input type='hidden' id='status' name='status'></input>
                <button type="submit" class="btn btn-success" id="sub-giveup">提交</button>
                <a href="#" class="btn" data-dismiss="modal">关闭</a>
            </div>
        </form>
    </div>
    
    <!--模态化弹框-预览功能开始-->
    <div id="preview" class="modal hide fade in" style="display: none;width:950px;left:35%;">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3>合同预览</h3>
        </div>
        <div id="previewForm" class="modal-body" style="height:500px;">

        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">关闭</a>
        </div>
    </div>
    <!--模态化弹框-预览功能结束-->
    
    <!--图片放大功能开始-->
    <div id="zoomInImage" class="modal hide fade in" style="display: none;width:950px;left:35%;">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3>电子合同图片</h3>
        </div>
        <div class="modal-body" style="height:500px;">
            <img src="" id="zoomInImageImg" >
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">关闭</a>
        </div>
    </div>
    <!--图片放大功能结束-->
    
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
        //预览功能
        $('.preview').click(function(){
            var store_id = $(this).attr('data-id');
            $.ajax({
                url:"<?php echo U('preview');?>",
                type:'post',
                data:'id='+store_id,
                success:function(d){
                    var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        var data = result.data;
                        var length = data.StoreProfilesDetail.length;
                        var str = '';
                        str = '<table class="table table-bordered table-hover"><tr><th colspan="4" style="text-align:center;font-size:30px;">合同基本信息</th></tr>';
                        str +='<tr><td style="text-align:center;width:200px;">商家名称:</td><td >'+data.show_store_name+'</td><td style="text-align:center;">地&nbsp;区:</td><td >'+data.Province.region_name+'/'+data.City.region_name+'</td></tr>';
                        str +='<tr><td style="text-align:center;">商家地址：</td><td >'+data.address+'</td><td style="text-align:center;">集团所属:</td><td >'+data.category_group_id+'</td></tr>';                      
                        str +='<tr><td style="text-align:center;">商家类型:</td><td >'+data.category_id+'</td><td></td><td></td></tr><tr><th colspan="4">&nbsp;</th></tr></table>';                    
                        for(var i=0;i<length;i++ ){
                            str +='<table class="table table-bordered table-hover"><tr><th style="text-align:center;font-size:30px;">'+data.StoreProfilesDetail[i].category_id+'合同详细信息</th></tr></table>';
                            str +='<table class="table table-bordered table-hover"><tr><td>合同名称:</td><td>'+data.StoreProfilesDetail[i].profile_name+'</td><td>价格区间：</td><td>'+data.StoreProfilesDetail[i].min_price+data.StoreProfilesDetail[i].max_price+'</td></tr>';
                            str +='<tr><td>合同时间：</td><td>'+data.StoreProfilesDetail[i].start_time+'至'+data.StoreProfilesDetail[i].end_time+'</td><td>合同续签详情：</td><td>'+data.StoreProfilesDetail[i].Renew+'</td></tr>';
                            str +='<tr><td>合同负责人：</td><td>'+data.StoreProfilesDetail[i].principal+'</td><td>合同类型:</td><td>'+data.StoreProfilesDetail[i].member_status+'</td></tr>';
                            str +='<tr><td>接收时间：</td><td>'+data.StoreProfilesDetail[i].receive_time+'</td><td>传真</td><td>'+data.StoreProfilesDetail[i].fax+'</td></tr>';
                            str +='<tr><td>佣金：</td><td>'+data.StoreProfilesDetail[i].return_amount+'%</td><td>结算日期：</td><td>'+data.StoreProfilesDetail[i].settlement_time+'</td></tr>';
                            str +='<tr><td>联系方式：</td><td>手机：'+data.StoreProfilesDetail[i].mobile+'<br/>座机：'+data.StoreProfilesDetail[i].telephone+'</td><td>联系人：</td><td>'+data.StoreProfilesDetail[i].contact_man+'</td></tr>'; 
                            str +='<tr><td>开户行：</td><td>'+data.StoreProfilesDetail[i].bank+'</td><td>开户人</td><td>'+data.StoreProfilesDetail[i].bank_member+'</td></tr>';
                            str +='<tr><td>银行账号：</td><td>'+data.StoreProfilesDetail[i].bank_account+'</td><td>商家承诺：</td><td>'+data.StoreProfilesDetail[i].commitment+'</td></tr>';
                            str +='<tr><td>配送区域：</td><td>'+data.StoreProfilesDetail[i].distribution_area+'</td><td>备注：</td><td>'+data.StoreProfilesDetail[i].remarks+'</td></tr>';
                            str +='<tr><td style="color:green;">价格合同：<br/>(点击大图)</td><td colspan="3">'+data.StoreProfilesDetail[i].imagePrice+'</td></tr>';
                            str +='<tr><td style="color:green;">电子合同：<br/>(点击大图)</td><td colspan="3">'+data.StoreProfilesDetail[i].imageElec+'</td></tr></table>';
                        }            
                        $('#previewForm').empty().append(str);
                        $('#preview').modal();
                    } else if(result.flag==0){
                        alert(result.msg);
                    }
                }
            });
        });
        //放大图片
        function zoomInImage(d){
            var src = $(d).attr('data-image');
            $('#zoomInImageImg').attr('src',src);
            $('#zoomInImage').modal();
        }
        
        
        //添加合同档案
        $('.addProfiles').click(function(){
            if($("input[name='ID_Dele']:checked").length == 1){
                var id = $("input[name='ID_Dele']:checked").val();
                var np = <?php echo $nowPage ?>; 
                window.location.href="/system.php/StoreProfiles/addProfilesDetail/id/"+id+'/np/'+np;
            }else{
                alert('请选择一个！');
            }
        });
        //移除所有选中
        $("input[name='ID_Dele']").each(function(){
            $(this).attr("checked",false);
        });
        //编辑合同档案
        $('.editprofiles').click(function(){
            if($("input[name='ID_Dele']:checked").length == 1){
                var id = $("input[name='ID_Dele']:checked").val();
                var np = <?php echo $nowPage ?>; 
                //alert(np);
                window.location.href="/system.php/StoreProfiles/editprofiles/id/"+id+'/np/'+np;
            }else{
                alert('请选择一个！');
            }
        });
        //删除档案 
        $('.delprofiles').click(function(){
            var str = '';
            $("input[name='ID_Dele']:checked").each(function(){
                str += ($(this).val()+',');
            });
            if(str.length==0){
                alert('未选中信息！');
                return false;
            }else {
                if(!window.confirm('确定要删除？')){
                    event.preventDefault();
                }else{
                    $.ajax({
                        url:"<?php echo U('delprofiles');?>",
                        type:'post',
                        data:'id='+str,
                        success:function(d){
                            var result = eval("(" + d + ")");
                            if (result.flag == 1) {
                                alert(result.msg);
                                window.location.reload();//刷新当前页面.
                            } else if(result.flag==0){
                                alert(result.msg);
                            }
                        }
                    });
                }
            }
        });
        //时间格式化
        function formatDate(unix) {
            var now = new Date(parseInt(unix) * 1000);
            var year=now.getFullYear();
            var month=now.getMonth()+1;
            var date=now.getDate();
            var hour=now.getHours();
            var minute=now.getMinutes();
            var second=now.getSeconds();
            var time = year+"-"+month+"-"+date;
            return  time.replace(/\b(\w)\b/g, '0$1');
        } 
        
        //续签
        $('.renew').click(function(){
            var id = $(this).attr('data-id');
            $.ajax({
                url: "/system.php/StoreProfiles/renew/id/"+id,
                success: function (d) {
                    var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        var data = result.data;
                        $('#renewForm input[name="store_profiles_detail_id"]').val(data.id);
                        $('#renewForm input[name="store_profiles_id"]').val(data.profiles_id);
                        $('.store_name').text(data.profile_name);
                        var unix = data.end_time;
                        var datetime = formatDate(unix);
                        $('.last_end_time').text(datetime);
                        $('#renew').modal();
                    } else {
                        alert('操作有误');
                    }
                }
            });
        });
        
        function checkEndTime(){  
            var startTime=$('.last_end_time').text();  
            var start=new Date(startTime.replace("-", "/").replace("-", "/"));
            var reStarTime = $('#renewForm input[name="renew_start_time"]').val(); 
            var reStart = new Date(reStarTime.replace("-", "/").replace("-", "/"));  
            var endTime=$('#renewForm input[name="renew_end_time"]').val();  
            var end=new Date(endTime.replace("-", "/").replace("-", "/")); 
            if(reStart<start){  
                alert('请检查续签开始时间是否正确！');
                return false;  
            }else if(end<reStart){
                alert('请检查续签结束时间是否正确！');
                return false;
            }else if(end<start){
                alert('请检查续签结束时间是否正确！');
                return false;
            }  
            return true;  
        }
        //提交续签form 表单
        $('#renewForm').bind('valid.form', function () {
            if(!checkEndTime()){
                return false;  
            }
            $('#renew').modal('hide');
            $.ajax({
                url: "<?php echo U('StoreProfiles/renew');?>",
                type: 'POST',
                data: $(this).serialize(),
                success: function (d) {
                    var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        alert('续签成功');
                        window.location.reload();//刷新当前页面.
                    } else {
                        alert(result.msg);
                    }
                }
            });
        });
       
        //放弃
        $('.giveup').click(function(){
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            $.ajax({
                url: "/system.php/StoreProfiles/giveup/id/"+id,
                success: function (d) {
                    var result = eval("(" + d + ")");
                    $('.reason').text(result.msg);
                }
            });
            $('#status').val(status);
            $('#id').val(id);
            $('#giveup').modal();
        });
        $('#giaveUpForm').bind('valid.form', function () {
            $.ajax({
                url: "<?php echo U('giveup');?>",
                type: 'POST',
                data: $(this).serialize(),
                success: function (d) {
                    var result = eval("(" + d + ")");
                    if (result.flag == 1) {
                        alert(result.msg);
                        window.location.reload();//刷新当前页面.
                    } else if(result.flag==0){
                    	alert(result.msg);
                    }
                }
            });
        });
       
        //省份切换，返回对应的城市
        $('#province').change(function () {
            var province_id = $(this).val();
            if (province_id == 0) {
                $('#city').empty();
                var str = "<option value='0'>选择市</option>";
                $('#city').html(str);
            } else {
                $.ajax({
                    url: "<?php echo U('getCity');?>",
                    type: 'POST',
                    data: 'province_id=' + province_id,
                    success: function (d) {
                        var result = eval("(" + d + ")");
                        var data = result.data;
                        var str = "<option value='0'>选择市</option>";
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
        //地址移入移出
        $('.provincecity').hover(function(){
           $(this).children('div').show(); 
        },
        function(){
            $(this).children('div').hide(); 
        });
        
        //删除续签时间
        $('.delRenewTime').click(function(){
            var id = $(this).attr('data-id');
            $.ajax({
                url: "<?php echo U('delRenewTime');?>",
                type: 'POST',
                data: 'id=' + id,
                success:function(d){
                    var result = eval("(" + d + ")");
                    if(result.flag == 1){
                        alert(result.msg);
                        window.location.reload();//刷新当前页面.
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