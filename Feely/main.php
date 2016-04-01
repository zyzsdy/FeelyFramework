<?php
// FeelyBlog 2.0 核心框架

//取得当前目录，并定义给__PATH__
define("__PATH__",str_replace("\\", "/", dirname(__FILE__)));
//载入核心
require_once(__PATH__."/lib/Core.class.php");
require_once(__PATH__."/lib/Route.class.php");
//载入Controller、Model、View
require_once(__PATH__."/lib/Controller.class.php");
require_once(__PATH__."/lib/Model.class.php");
require_once(__PATH__."/lib/View.class.php");
//载入全局函数
require_once(__PATH__."/lib/function.php");
//注册自动载入
if(function_exists('spl_autoload_register')){
	spl_autoload_register(array('Core', 'autoload'));
}else{
	function __autoload($class){
		return Core::autoload($class);
	}
}

//启动核心
Core::run();