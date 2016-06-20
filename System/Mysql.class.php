<?php
namespace System;
use System\Conf;
class Mysql{
    
    /**
     * 设置模式 单例模式
     * 通过 connectInit方法获得创建对象
     * 静态属connect保存类对象
     * 静态属性connectionhandle保存数据库连接句柄 
     */
    
    /**
     * 类对象
     */
    static public $connect;
    
    /**
     * 连接句柄
     */
    static public $connectionhandle;
    
    /**
     * 初始化数据库连接
     * @final
     * @prama string $class 类名  default __CLASS__
     * @return 数据库对象  
     */
    static public function connectInit($class = __CLASS__){
        if(NULL == self::$connect){
            self::$connect= new $class;		
        }
        return self::$connect;
    }
    
    /**
     * 私有化构造 执行数据库连接 生成连接句柄
     * @final
     */
    private function __construct(){
        self::$connectionhandle = new \PDO(
                'mysql:host='.Conf::$attr['MYSQL']['MYSQL_CONNECT_HOST'].';'.
                'dbname='.Conf::$attr['MYSQL']['MYSQL_SELECT_DB'],
                Conf::$attr['MYSQL']['MYSQL_USER'],
                Conf::$attr['MYSQL']['MYSQL_PWD']
            );
        self::$connectionhandle->query('set names'.Conf::$attr['MYSQL']['CHARSETS']);
    }
    
    /**
     * 私有克隆
     */
    private function __clone(){
        exit('该类不允许复制');
    }
}

