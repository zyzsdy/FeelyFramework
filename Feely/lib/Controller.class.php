<?php
class Controller{
	protected $isAdmin;
	function __construct($_isadmin = false){
		$this->isAdmin = $_isadmin;
		session_start();
		if(preg_match('/gzip/',$_SERVER['HTTP_ACCEPT_ENCODING'])){
			ob_start('ob_gzhandler');
		}else{
			ob_start();
		}
		header("X-Powered-By: FeelyFramework/2.0", true);
		if(Core::config('is_hsts')){
			header("Strict-Transport-Security: max-age=2592000; includeSubdomains; preload", true);
		}
	}
	protected function display($assign, $viewName){
		if($this->isAdmin){
			$themeName = Core::config('AdminTheme');
		}else{
			$themeName = Core::config('Theme');
		}
		$view = new View($themeName, $viewName);
		$view->set($assign);
		$view->render();
		ob_flush();
	}
}