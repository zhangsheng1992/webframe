<?php
/**
 * 框架核心类
 * 
 * @author zhangsheng <[email]zhangsheng_1992@sohu.com[/email]>
 * @version 1.0
 * @package 
 */
namespace System;
require_once('System/Defined.php');
require_once SYSTEM_DIR.DS.'Functions.php';
class Core{ 
    /**
     * @static 访问模块
     */
    static public $app;
    
    /**
     * @static 访问控制器
     */
    static public $ctl;
    
    /**
     * @static 访问方法 
     */
    static public $act;
    
    /**
     * @static 控制器对象
     */
    static public $controller;
    
    /**
     * @static 框架核心类文件
     */
    static public $system = array(
        'Conf'=>'Conf.class.php',
        'Db'=>'Db.class.php',
        'Mysql'=>'Mysql.class.php',
        'Controller'=>'Controller.class.php',
        'Model'=>'Model.class.php',
        'View'=>'View.class.php',
        'Memcached'=>'Library/Memcached/Memcached.class.php'
    );
    
        
    /**
     * 运行入口 
     */
    static public function run(){
        //加载函数库
//        self::loadFunction();
        //初始化配置项
        new Conf();
        //解析请求url
        self::getRequesetUrl();
        //初始化控制器方法
        self::initialize();
    }    
    
    /**
     * 执行控制器方法
     * 
     * @final
     */
    static public function initialize(){
        new \System\Controller();
        if(!is_file(APP_PATH.DS.self::$app.DS.'Controller'.DS.self::$controller.EXT)){
            throw new Exception('function'.self::$act.'not found in'.self::$controller.'Controller');
        }
        //加载控制器
        $namespace = '\\'.self::$app.'\\'.'Controller'.'\\'.self::$controller;
        $web = new $namespace();
        //执行前钩子方法
        //执行控制器方法
        $actionname = self::$act;
        if(method_exists($web,$actionname)){
            $web->$actionname();
            //执行后钩子方法
        }else{
            throw new Exception('function'.$actionname.'not found in'.self::$controller.'Controller');
        }
    }
    
//    /**
//     * 加载函数库
//     * @final
//     */
//    static function loadFunction(){
//
//        if(is_file(APP_PATH.DS.'Common'.DS.'Functions'.DS.'Functions.php')){
//            require_once APP_PATH.DS.'Common'.DS.'Functions'.DS.'Functions.php';
//        }
//        if(is_file(APP_PATH.DS.self::$app.DS.'Functions'.DS.'Functions.php')){
//            require_once APP_PATH.DS.self::$app.DS.'Functions'.DS.'Functions.php';
//        }
//    }
    
    /**
     * 自动加载
     * @final
     * @param string $class 类名
     */
    static public function autoload($class){
        $file_name = getPostfix($class,'\\');
        if(is_file(str_replace('\\', DS, APP_PATH.DS.$class.EXT))){
            require_once str_replace('\\', DS, APP_PATH.DS.$class.EXT);
        }else if(array_search($file_name, array_flip(self::$system))){
            //检测系统文件是否存在
            if(!is_file(SYSTEM_DIR.DS.$file_name.EXT)){
                throw new \Exception('----System Core----    '.$class.'  not found');
            }else{
                require_once SYSTEM_DIR.DS.$file_name.EXT;
            }
        }
    }
       
    /**
     * 解析请求url
     * @final  
     * @todo 参数过滤
     */
    static public function getRequesetUrl(){
        self::$app = isset($_GET['app']) ? $_GET['app'] : 'Home';
        self::$ctl = isset($_GET['ctl']) ? $_GET['ctl'] : 'Home';
        self::$act = isset($_GET['act']) ? $_GET['act'] : 'index';
        self::$controller = self::$ctl.'Controller';
        defined('ACTIONNAME') or define('ACTIONNAME',self::$act);
        defined('CONTROLLERNAME') or define('CONTROLLERNAME',self::$ctl);
    }
    
    /**
     * Mysql数据库链接
     */
    static public function getDb(){
        return Mysql::connectInit();
    }
    
    /**
     * memcahce链接
     */
    static public function getCache(){
        return Memcached::init();
    }
}
spl_autoload_register(array('\System\Core','autoload'));