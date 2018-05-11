<?php
/*|--------MyPHP---------------|
 *|---Created by whlphper------|
 *|--- Date: 2018/5/10 0010----|
 *|------- Time:  11:38--------|
 *|------- 761243073@qq.com----|
 *|-------框架入口文件-----------|
 */

$baseDir = __DIR__;
define('MY_VERSION', '1.0.0');
define('MY_START_TIME', microtime(true));
define('MY_START_MEM', memory_get_usage());
define('EXT', '.php');
define('DS', DIRECTORY_SEPARATOR);
// 框架目录
defined('MY_PATH') or define('MY_PATH',$baseDir . DS);
defined('CORE_PATH') or define('CORE_PATH',MY_PATH.'study'.DS);
// 自动加载类
include CORE_PATH . 'Loader.php';
\study\Loader::register();

