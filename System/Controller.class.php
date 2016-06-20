<?php
namespace System;
use System\Core;
use System\View;
/**
 * 控制器基类
 *
 * @author zhangsheng
 */
class Controller{
    
    /**
     * 模版对象
     */
    static public $view;
        
    /**
     * 初始化用户函数
     */
    static public function init(){
        //加载用户公共函数
        if(is_file(APP_PATH.DS.'Common'.DS.'Functions'.DS.'Functions.php')){
            include_once APP_PATH.DS.'Common'.DS.'Functions'.DS.'Functions.php';
        }
        //加载访问模块自定义函数
        if(is_file(APP_PATH.DS.Core::$app.'Functions'.DS.'Functions.php')){
            include_once APP_PATH.DS.'Common'.DS.'Functions'.DS.'Functions.php';
        }
    }
        
    /**
     * 向模版发送数据
     * 
     * @final
     * @param string $key 参数名
     * @param array|string|int $value 参数值
     */
    public function assign($key,$value){
        if(!isset(self::$view)){
            self::$view = new View();
        }
        self::$view->bindParam($key,$value);
    }
    
    /**
     * 加载指定模版 
     * 
     * @message 当未设置模版控制器名时 默认加载归属当前控制器下的模版
     *          当未设置模版文件名时 默认加载当前方法同名模版
     * @final
     * @param string $view 模版文件名称
     * @param string $ctl 控制器名称 
     */
    public function render($view = '',$ctl = ''){
        if('' === $view){
            $view = Core::$act;
        }
        if('' === $ctl){
            $ctl = Core::$ctl;
        }
        if(!isset(self::$view)){
            self::$view = new View();
        }     
        self::$view->showView($view, $ctl);
    }
    
    /**
     * 强制跳转
     * 
     * @param string $ctl控制器名
     * @param stirng $act方法名
     */
    public function redirect($ctl, $act, $params, $app, $code = 302){
        header("Location:" . url($ctl, $act, $params, $app), true, $code);
        exit;
    }
}
