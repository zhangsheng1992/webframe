<?php
use System\Core;
use System\Conf;
use System\Model;
    /**
     * 截取字符串后缀 如果是字符串数组 将依次按顺序返回
     * @final
     * @param string||array $string point字符串
     * @param string $flag 分隔符
     * @return string || false
     */
    function getPostfix($string,$flag){
        if(is_array($string)){
            $return = array();
            foreach($string as $val){
                $return[] = substr($val,strrpos($val,$flag)+1);
            }
            return $return;
        }
        return substr($string,strrpos($string,$flag)+1);
    }
    
    /**
     * 初始化model(工厂模式)
     * @final
     * @param string $model model名称 
     * @param string $app 模块名称
     * @message 本方法大小写敏感 不指定为当前模块 
     *          当前模块文件不存在时尝试加载Common模块
     * @update 16-01-11 增加检测要实例化的model是否存在 减少不必要开销 
     */
    function model($model,$app = NULL){
        //默认加载指定模块的
        if(!isset($app)){
            $app = Core::$app;
        }
        if(is_file(APP_PATH.DS.$app.DS.'Model'.DS.$model.'Model'.EXT)){
            $namespace = '\\'.$app.'\\'.'Model'.'\\'.$model.'Model';
        }else{
            if(is_file(APP_PATH.DS.'Common'.DS.'Model'.DS.$model.'Model'.EXT)){
                $namespace = '\\'.'Common'.'\\'.'Model'.'\\'.$model.'Model'; 
            }else{
                throw new \Exception('----'.$model.'Model----  not found');
            }
        }
        //检测子类是否存在 防止重复new对象
        if(Model::getSonModel($namespace) === false){
            $modelname = new $namespace();
            $tablename= $namespace::TABLENAME ? $namespace::TABLENAME : $model;
            $modelname->setTable($tablename,Conf::$attr['MYSQL']['TABLE_PREFIX']);
            Model::setSonModel($namespace,$modelname);
        }else{
            $modelname = Model::getSonModel($namespace);
        }
        return $modelname;
    }

    /**
     * 初始化缓存设置
     */
    function cache($key,$value,$time){
        
        //use System\Library\Memcached\Init;
        //use System\Library\Memcached\Memcached;
        //检测phpinfo存在扩展
        require_once SYSTEM_DIR.DS.'Memcached'.EXT;
        return Core::getCache();
    }
    
    /**
     * 生成统一的URl
     *
     * @param string $ctl 控制器名称
     * @param string $act 控制器方法名称
     * @param array $params url参数
     * @return string
     */
    function url($ctl = Null,$act = Null, $params = array(),$app = Null) {
        $url = isset(Conf::$attr['Base']['SERVER_TYPE']) ? strtolower(Conf::$attr['Base']['SERVER_TYPE']):'http';
        if(isset(Conf::$attr['BASE']['SERVER_NAME'])){
            $url .= ':'.DS.DS.Conf::$attr['BASE']['SERVER_NAME'];
        }else{
            $url .= ':'.DS.DS.$_SERVER['SERVER_NAME'];
        }
        if(!isset($app)){
            $app = Core::$app;
        }
        if(!isset($ctl)){
            $ctl = Core::$ctl;
        }
        if(!isset($act)){
            $act = Core::$act;
        }
        $url .= '?app='.$app.'&ctl='.$ctl.'&act='.$act.mapArray($params);
        return $url;
    }
    
    /**
     * 格式化url参数
     * 
     * @param array $param 参数数组
     */
    function mapArray($param){
        if(!empty($param) && is_array($param)){
            foreach($param as $key=>$val){
                $url .= '&'.$key.'='.$val;
            }
            return $url;
        }else{
            return '';
        }
    }




