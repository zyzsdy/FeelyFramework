<?php
// 框架核心类
class Core{
	static $__config;
	//主执行逻辑
	static public function run(){
		$patha = $_SERVER['PHP_SELF'];
		$seppos = strpos($patha, "index.php"); //index.php分隔位置
		$dirname = substr($patha, 0, $seppos - 1); //路径名
		define('__ROOT__', $dirname); //定义根目录路径。
		$parapath = substr($patha, $seppos + 10); //URI PATHINFO
		
		try{
			//根据PATHINFO进行路由
			$routeResult = Route::start($parapath);
			$className = $routeResult['class']."Controller";
			$methodName = $routeResult['method'];
			$args = $routeResult['args'];
			array_shift($args);

			//产生控制器对象
			$destController = self::objectFactory($className);
			//调用控制器
			call_user_func_array(array($destController, $methodName), $args);
		}catch(Exception $e){
			Core::showError($e);
		}
	}

	//按照传入的key获取设置
	static public function config($key){
		if(!isset(self::$__config)){
			self::$__config = require_once(__PATH__."/config.php");
		}
		return self::$__config[$key];
	}

	//自动载入
	static public function autoload($class){
		$path = __PATH__;

		try{
			if(strpos($class, "Model")){
				$path .= "/Model/";
			}else if(strpos($class, "Controller")){
				$path .= "/Controller/";
			}else{
				throw new Exception("无效类名。");
			}

			$fileName = $path.$class.".class.php";
			if(!file_exists($fileName)){
				throw new Exception("无法载入类：文件不存在——".$fileName);
			}
			require_once($path.$class.".class.php");
		}catch(Exception $e){
			Core::showError($e);
		}
	}

	//对象工厂
	static public function objectFactory($class){
		try{
			return new $class;
		}catch(Exception $e){
			Core::showError($e);
		}
	}

	//错误处理
	static public function showError($e){
		header('HTTP/1.1 404 Not Found');
		header('Status: 404 Not Found');
		echo '<html><head><title>发生了错误</title><style>body{font-family: "微软雅黑";}</style></head><body><h2>Error:</h2><h3>'.$e->getMessage().'</h3>
			<p>错误位置：<b>'.$e->getFile().'</b> on Line <b>'.$e->getLine().'</b></p>
			<p>&nbsp;</p><p><b>Trace:</b></p><p>'.nl2br($e->getTraceAsString()).'</p>
			<hr><p>FeelyBlog 2.0 Framework</p></body></html>';
		exit();
	}
}