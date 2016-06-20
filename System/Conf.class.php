<?php
namespace System;
use System\Core;
class Conf{
    
    static public $attr;
    
    public function __construct() {
        //加载指定模块的配置文件 如果有的话
        if(is_file(APP_PATH.DS.Core::$app.DS.'Conf'.DS.'conf.php')){
            self::$attr = require_once APP_PATH.DS.Core::$app.DS.'Conf'.DS.'Conf.php';
        }else{
            self::$attr  = require_once COMMON.DS.'Conf'.DS.'Conf.php';
        }
    }
    
    public function __set( $name, $value ){
        return $this->attrs[$name] = $value;
    }

    public function __get( $name ){
        return $this->attrs[$name];
    }
}
