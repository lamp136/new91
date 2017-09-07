<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件
ini_set('date.timezone', 'Asia/Shanghai');
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',true);
define('BIND_MODULE','Admin');

// 定义应用目录
define('APP_NAME','Admin');
define('APP_PATH','./');

define('CSS_URL','/Public/Admin/Css/');
define('IMG_URL','/Public/Admin/Img/');
define('ASSETS_URL','/Public/Admin/Assets/');
define('JS_URL','/Public/Admin/Js/');

define("WEB_ROOT", dirname(__FILE__) . "/");
define('WEB_CACHE_PATH', WEB_ROOT."Cache/");//网站当前缓存路径
define("DatabaseBackDir", WEB_ROOT . "Databases/"); //系统备份数据库文件存放目录
define("RUNTIME_PATH", WEB_ROOT . "Cache/Runtime/Admin/");

header('cache-control:private,must_revalidate');

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单