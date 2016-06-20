<?php
namespace System\Library\Memcached;
use System\Library\Memcached\Init;
/**
 * memchache操作类
 * 定义有关的所有memcache操作
 * @author zhangsheng
 */
class Memcached extends Init{
    
    /**
     * memcache连接句柄
     */
    protected $handle;

    /**
     * 构造方法 获取memcache连接句柄
     */
    public function __construct() {
        $memcahce = Init::init();
        $this->handle = $memcahce::$handle;
    }
    
    
    public function setValue(){
        
    }
    
    public function getValue(){
        
    }
    
    public function deleteValue(){
        
    }
    
    public function replaceValue(){
        
    }
    
    
}
/*
 * memcache函数所有的方法列表如下：
Memcache::add – 添加一个值，如果已经存在，则返回false
Memcache::addServer – 添加一个可供使用的服务器地址
Memcache::close – 关闭一个Memcache对象
Memcache::connect – 创建一个Memcache对象
memcache_debug – 控制调试功能
Memcache::decrement – 对保存的某个key中的值进行减法操作
Memcache::delete – 删除一个key值
Memcache::flush – 清除所有缓存的数据
Memcache::get – 获取一个key值
Memcache::getExtendedStats – 获取进程池中所有进程的运行系统统计
Memcache::getServerStatus – 获取运行服务器的参数
Memcache::getStats – 返回服务器的一些运行统计信息
Memcache::getVersion – 返回运行的Memcache的版本信息
Memcache::increment – 对保存的某个key中的值进行加法操作
Memcache::pconnect – 创建一个Memcache的持久连接对象
Memcache::replace -对一个已有的key进行覆写操作
Memcache::set – 添加一个值，如果已经存在，则覆写
Memcache::setCompressThreshold – 对大于某一大小的数据进行压缩
Memcache::setServerParams – 在运行时修改服务器的参数 
 *  */