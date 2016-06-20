<?php
/**
 * 系统常量
 * 
 * @author zhangsheng <[email]zhangsheng_1992@sohu.com[/email]>
 * @version 1.0
 * @package 
 */
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('DIRECTORY') or define('DIRECTORY',  dirname(__DIR__));
defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']).DS.'Application');
defined('COMMON') or define('COMMON', APP_PATH.DS.'Common');
defined('SYSTEM_DIR') or define('SYSTEM_DIR', DIRECTORY.DS.'System');
defined('EXT') or define('EXT', '.class.php');
defined('IS_SYSTEM') or define('IS_SYSTEM','1');