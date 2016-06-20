<?php
namespace System;
class Model{
    /**
     * Mysql数据库model
     */
    
    /**
     * 本类及子类句柄
     */
    protected $handle;
    
    /**
     * 表前缀
     */
    protected $fix;
    
    /*
     * 库名
     */
    protected $database;
    
    /**
     * 表名
     */
    private $table;
    
    /**
     * 查询条件
     */
    private $where = array();
    
    /**
     * 分组条件
     */
    private $group;
    
    /**
     * 排序条件
     */
    private $order;
    
    /**
     * 表重命名
     */
    private $alias;
    
    /**
     * 查询字断
     */
    private $cloumn;
    
    /**
     * 连接条件
     */
    private $join;
    
    /**
     * 数据集限制
     */
    private $limit = array();
    
    /**
     * 实例化参数
     */
    private $param = array();
    
    /**
     * 私有 上条执行的参数化语句
     * 通过getLastSql()获取
     */
    private $lastsql;
    
    /**
     * 静态子类对象
     * 通过 getSonModel获取
     * 防止重复new对象
     */
    public static $object = array();
    
    /**
     * 构造函数 获取数据库连接句柄
     */
    public function __construct() {
        $msyql = Core::getDb();
        $this->handle = $msyql::$connectionhandle;
    }
    
    /**
     * 取子类对象
     * 
     * @param string $namespace 子类命名空间
     * @return object|bool
     */
    static public function getSonModel($namespace){
        if(isset(self::$object[$namespace])){
            return self::$object[$namespace];
        }
        return false;
    }
    
    /**
     * 设置子类对象
     * 
     * @param string $namespace 子类命名空间
     * @return none
     */
    static public function setSonModel($namespace,$modelname){
        self::$object[$namespace] = $modelname;
    }
    
    /**
     * 设置model操作表名
     */
    public function setTable($tablename,$fix){
        $this->table = $tablename;
        $this->fix = $fix;
    }
    
    /**
     * 绑定查询条件
     */
    public function where($condition){
        if(!is_array($condition) && !is_string($condition)){
            exit('where参数必须是数组或字符串');
        }
        if(is_string($condition) && '' != $condition){
            $map = array();
            $map[] = $condition;
            $condition = $map;
        }        
        if(isset($this->where)){
            $this->where = array_merge($this->where,$condition);
        }else{
            $this->where = $condition;
        }
        return $this;
    }
    
    /**
     * 单条查询
     */
    public function find(){
        $this->limit['start']= 1;
        $this->prepare('find');
    }
    
    /**
     * 多条查询
     */
    public function select(){
        return $this->prepare('select');
    }
    
    /**
     * 指定查询集
     */
    public function limit($start,$end = Null){
        if(is_int($start)){
            $this->limit['start'] = $start;
        }
        if(is_int($end) && !is_null($end)){
            $this->limit['end'] = $end;
        }
        return $this;
    }
    
    /**
     * 指定查询字断
     */
    public function cloumn($field){
        $this->cloumn = $field;
        return $this;
    }
     
    /**
     * 指定分组查询
     */
    public function group($str){
        if(!is_null($str) && is_string($str)){
            $this->group = $str;
        }
        return $this;
    }
    
    /**
     * 链接查询方法
     * @final
     * @param string|array $str 查询条件
     */
    public function join($str){
        if(is_string($str)){
            $map = array();
            $map[] = $str;
            $this->join = $map;
        }else if(is_array($str)){
            $this->join = $str;
        }
        return $this;
    }
    
    /**
     * 排序方法
     */
    public function order($string){
        if(!is_null($string) && is_string($string)){
            $this->order = $string;
        }
        return $this;
    }
    
    /**
     * 表重命名
     */
    public function alias($name){
        $this->alias = $name;
        return $this;
    }
    
    /**
     * 
     */
//    public function execute($sql){
//        $this->handle->query($sql);
//    }
    
    /**
     * 
     */
    public function query(){
//        $PDOStatement = $this->handle->query('select * from vn_admin');
//        return $this->fetch($PDOStatement);
    }
    
    /**
     * 取结果集
     */
    public function fetch($PDOStatement){
        $PDOStatement->setFetchMode(\PDO::FETCH_ASSOC);
        return $PDOStatement->fetchAll();
    }
    
    /**
     * 预执行 组装sql 拼接参数
     */
    public function prepare($type){
        header('content-type:text/html;charset=utf-8');
        return $this->selectQuery(); 
    }
    
    /**
     * 设置 取上一条sql 参数化sql语句
     */
    public function getLastsql($sql = ''){
        if(!empty($sql)){
            $this->lastsql = vsprintf(str_replace('?', '%s', $sql), $this->param);
        }
        return $this->lastsql;
    }
        
    

    
    /**
     * 查询预处理
     */
    public function selectQuery(){
        $sql = ' select ';
        if(isset($this->cloumn)){
            $sql .= $this->cloumn;
        }else{
            $sql .= '*';
        }
        $sql .= ' from ';
        if(isset($this->fix)){
            $sql .= $this->fix;
        }
        $sql .= $this->table;
        if(isset($this->alias)){
            $sql .= ' as '.$this->alias.' ';
        }
        if(isset($this->join)){
            foreach($this->join as $val){
                $sql .= $val.' ';
            }
        }
        if(!empty($this->where)){
            $sql = $this->getWhere($sql);
        }
        if(isset($this->group)){
            $sql .= ' group by '.$this->group;
        }
        if(isset($this->order)){
            $sql .= ' order by '.$this->order;
        }
        if(!empty($this->limit)){
            $sql .= ' limit '.$this->limit[0].isset($this->limit[1])?','.$this->limit[1]:'';
        }
        //设置上条执行过的sql供查询使用
        $this->getLastsql($sql);
        $stm = $this->handle->prepare($sql);
        if(!empty($this->param)){
            foreach($this->param as $key=>$val){
                $stm->bindParam($key+1,$val);
            }
        }
        $stm->execute();
        $this->cleanQueryOption();
        return $stm->fetchAll();
    }
    
    
    /**
     * 格式化语句参数
     * 
     * @final
     * @return string 预处理的参数语句
     */
    public function getWhere($sql){
        $sql .= ' where ';
        foreach($this->where as $key=>$val){
            if(is_int($key) && !is_array($val)){
                $sql .= $val.' and ';
                continue;
            }
            if(is_array($val) && is_string($key)){ 
                $sql .= $key .' = ? and ';
                //$this->param[] = $this->switchWhere($val);
                //如果是关键字查询的化还要将param数组中的那一个数组项转化为字符串
                continue;
            }
            if(is_string($key) && is_string($val)){
                $sql .= $key.' = ? and ';
                $this->param[] = $val;
            }
        }
        $sql = substr($sql,0,strrpos($sql,'and'));
        return $sql;
    }
    
    
    
    /**
     * 格式化关键字查询
     * 
     * @final
     * @param string $where 关键字查询数组
     * @reutrn string 关键字
     */
    public function switchWhere($where){
        // < > >= <= != between like in not in 
        //这边细点 各个关键字各个处理
//        $num = count($where);
//        if($num == 2){
//            return $where[0].' '.$where[1];
//        }else if($num == 3){
//            return $where[0].' '.$where[1].' and '.$where[2];
//        }else{
//            exit('查询关键字错误');
//        }
    }
    
    /**
     * 清理查询参数 方便下条语句执行
     * 
     * @final
     */
    public function cleanQueryOption(){
        $this->where = array();
        $this->group = NULL;
        $this->order = NULL;
        $this->alias = NULL;
        $this->cloumn = NULL;
        $this->join = NULL;
        $this->limit = array();
    }
    
    /**
     * 删除方法
     */
    public function delete(){
        
    }
    
    /**
     * 修改方法
     */
    public function update(){
        
    }
    
    /**
     * 执行事务
     */
    public function begin(){
        
    }
    
    /**
     * 提交事务
     */
    public function commit(){
        
    }
    
    /**
     * 回滚
     */
    public function rollback(){
        
    }
    
    /**
     * 子查询
     */
    public function subquery(){
        
    }
}

