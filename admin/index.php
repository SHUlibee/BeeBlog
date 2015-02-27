<?php
/**
 * 入口文件
 */

//应用根目录
define('SERVER_ROOT', dirname(__FILE__));
//框架根目录
define('FRAME_ROOT', dirname(SERVER_ROOT).'/bphp/');

//服务器域名
define('SITE_ROOT', 'http://mvc.com');

//开启错误提示
ini_set('display_errors', 1);
//设置报错级别
error_reporting(E_ALL);

//启用session
session_start();

//引入路由
require_once(FRAME_ROOT . 'router.php');