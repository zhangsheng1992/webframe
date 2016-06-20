<?php
namespace System\Library\Memcached;
use System\Conf;
/**
 * memchache初始化类
 * 
 * 单例模式
 * 通过静态方法init获取对象
 *
 * @author zhangsheng
 */
class Init {
    
    /**
     * memcache对象
     */
    static public $memcacheConnect;

    /**
     * 连接句柄 
     */
    static public $handle;
    
    /**
     * 初始化链接
     */
    static public function init($class = __CLASS__){
        if(NULL == self::$cacheconnect){
            self::$cacheconnect= new $class;		
        }
        return self::$cacheconnect;
    }
    
    /**
     * 私有构造方法
     * 执行连接操作返回句柄
     */
    private function __construct() {
        if(isset(Conf::$attr['MEMCACHED'])){
                self::$memcacheConnect = new \Memcache();
                self::$handle = self::$memcacheConnect
                        ->connect(
                                Conf::$attr['MEMCACHED_HOST'], 
                                Conf::$attr['MEMCACHED_POST']?Conf::$attr['MEMCACHED_POST']:'11211'
                            );
                return self::$memcacheConnect;
        }else{
            exit('config file config.php not set memcahce message!');
        }
    }
    
    /**
     * 私有构造 禁止类外复制对象
     */
    private function __clone(){
        eixt('object not allow to cloned');
    }
    
}
