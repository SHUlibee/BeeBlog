﻿<?php
/**
 * 入口文件
 */

//应用名称（文件夹名）
define('APP_NAME', 'front');
//应用根目录
define('SERVER_ROOT', dirname(__FILE__));
//框架根目录
define('FRAME_ROOT', dirname(SERVER_ROOT).'/bphp/');

//生产环境，相当于config中.ini文件的文件名
define('ENVIRONMENT', 'dev');

//开启错误提示
ini_set('display_errors', 1);
//设置报错级别
error_reporting(E_ALL);

//启用session
session_start();

//引入路由
require_once(FRAME_ROOT . 'router.php');