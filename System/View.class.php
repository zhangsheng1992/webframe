<?php
namespace System;
use System\Core;
use System\Conf;
class View{
    public $param = array();
    
    /**
     * 初始化模版
     */
    static public function init(){
        //在这里初始化下得到的conf模版配置信息
    }
    
    
    /**
     * 加载模版文件
     * @param stirng $view 模版名称
     * @param string $ctl 模版位置
     * @param string $app 模块名称
     */
    function showView($view,$ctl,$app = Null){
        !isset($app) && $app = Core::$app;
        ob_start();
        if(isset(Conf::$attr['VIEW']['OPEN_VIEW_CACHE'])){
            $salt = json_encode($this->param).$view.$ctl.$app;
            $this->cacheView($salt,$app,$ctl,$view);
        }
        if(!is_file(APP_PATH.DS.$app.DS.'View'.DS.$ctl.DS.$view.'.php')){
            exit('not found View'.APP_PATH.DS.$app.DS.'View'.DS.$ctl.DS.$view.'.php');
        }
        foreach($this->param as $key=>$val){
                $$key = $val;
        }
        require_once APP_PATH.DS.$app.DS.'View'.DS.$ctl.DS.$view.'.php';
        ob_flush();
    }
    
    /**
     * 绑定参数
     */
    public function bindParam($key,$value){
        $this->param[$key] = $value;
    }
    
    /**
     * 缓存模版文件
     */
    public function cacheView($salt,$app,$ctl,$view){
        $cache_view = APP_PATH.DS.Core::$app.DS.'Cache'.DS.Conf::$attr['VIEW']['VIEW_CACHE_PREFIX'].$salt.'.html';
        //缓存文件存在并且未过失效 加载缓存文件
        if(is_file($cache_view) && filectime($cache_view)+ Conf::$attr['VIEW']['VIEW_CACHE_TIEM'] > time()){
            //原文件在缓存期内没修改过 也就是生成缓存文件后原文件未修改过
            if(filectime(APP_PATH.DS.$app.DS.'View'.DS.$ctl.DS.$view.'.php') < filectime($cache_view)){
                require_once $cache_view;
                ob_flush();exit();
            }
        }
        //缓存文件不存在或者已过时效期
        //解析数据
        foreach($this->param as $key=>$val){
            $$key = $val;
        }
        //生成缓存文件
        require_once APP_PATH.DS.$app.DS.'View'.DS.$ctl.DS.$view.'.php';
        $str = ob_get_contents();
        file_put_contents($cache_view, $str);
        ob_flush();exit();
    }
}
