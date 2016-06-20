<?php
define('APP_PATH','Application');
//加载核心类
require_once 'System/Core.class.php';
//web入口
\System\Core::run();