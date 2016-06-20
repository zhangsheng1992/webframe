<?php
return array(
        'BASE'  =>  array(
                    'SERVER_NAME'   => 'www.my.com',
                    'SERVER_TYPE'   =>  'HTTP',
                    'DEFAUTL_APP'   => 'Home',
                    'DEFAULT_CHARSET' => 'utf-8',
                    /** 设置php脚本执行方式 可以不框架会自行判断并针对的优化以提高执行效率
                     * 'SERVER' =>'apache//nginx', 
                     * 'SERVER_TYPE'=>'cgi//fast-cgi//commond-line//modoules'
                     */
                ),
        'MYSQL' =>  array(
                    'MYSQL_CONNECT_HOST'  =>  '',
                    'MYSQL_PORT'  =>  '',
                    'MYSQL_SELECT_DB' => '',
                    'MYSQL_USER'  =>  '',
                    'MYSQL_PWD'   =>  '',
                    'TABLE_PREFIX'  => ''
                    //这里可以设置下查询缓存啦什么的
                ),
        /*
        'MONGODB'   => array(
                    'MONGODB_CONNECT_HOST',
        ),*/
        'VIEW'  =>  array(
                    /** 如果你需要开启模版缓存 请打开并修改此处配置文件  
                    'OPEN_VIEW_CACHE' => 'on',//是否开启模版缓存
                    'VIEW_CACHE_TIEM' => '300',//模版缓存时间
                    'VIEW_CACHE_DIR' => 'default',//模版缓存路径 默认为各个模块下的Cache目录 此处设置目录相对于index.php
                    'VIEW_CACHE_PREFIX' => 'cache_',//缓存文件的前缀
                     **/
                    'VIEW_POSTFIX' => '.php'//模版文件的后缀
        ),
        /*如果你需要缓存服务,请打开下列配置项 目前仅支持单memcache 分布式的处理还没想好*/
        'MEMCACHED'  =>  array(
                'MEMCACHED_HOST'=>'',//连接地址
                'MEMCACHED_POST'=>11211,//链接端口 默认11211
                'DEFATUL_CACHE_TIME'=>60,//缓存时间 默认为60秒 0为不过期 缓存尽量小于2592000秒(30天)
                'ALLOW_TRAVERSA'=>'0',//是否允许遍历 默认为不允许
                'OPEN_MEMCACHE_COMPRESSED'=>'0'//是否启用压缩 默认关闭 开启减小数据传输量 但会影响速度 建议在网络带宽较小的情况下开启
        ),
        /*'REDIS'   =>  array(),*/
    );
