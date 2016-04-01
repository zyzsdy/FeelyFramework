<?php
class View{
	private $templateName;
	private $templatePath;
	private $themeName;
	private $__tempArgs;
	function __construct($_themeName, $_templateName){
		$this->themeName = $_themeName;
		$this->templateName = $_templateName;
	}
	public function set($assign){
		$this->__tempArgs = $assign;
	}
	public function render(){
		$this->templatePath = __PATH__."/Themes/".$this->themeName."/".$this->templateName.".php";
		$__t['title'] = Core::config('default_title');
		$__t = $this->__tempArgs;
		foreach ($this->__tempArgs as $___key => $___value) {
			${$___key} = $___value;
		}
		if(!file_exists($this->templatePath)){
			throw new Exception("无法载入主题：文件不存在——".$this->templatePath);
		}
		include($this->templatePath);
	}
	static public function loadHtml($theme, $name, $__tempArgs){
		$__loadPath = __PATH__."/Themes/".$theme."/".$name.".php";
		foreach ($__tempArgs as $key => $value) {
				${$key} = $value;
		}
		if(!file_exists($__loadPath)){
			throw new Exception("无法载入主题：文件不存在——".$__loadPath);
		}
		include($__loadPath);
	}
	static public function navbar($cond = ""){
		$navConfig = Core::config('navbar');
		foreach ($navConfig as $navTitle => $navValue) {
			if(!isset($navValue['type'])){
				throw new Exception("无法载入navbar配置类型，可能是配置项的格式不正确。请检查config.php");
			}
			switch ($navValue['type']) {
				case 'index':
					echo "<li><a href=\"/\">".$navTitle."</a></li>";
					break;
				case 'category':
					echo "<li><a href=\"/list/".$navValue['value']."\">".$navTitle."</a></li>";
					break;
				case 'page':
					echo "<li><a href=\"/".$navValue['value']."\">".$navTitle."</a></li>";
					break;
				case 'hidden':
					if($cond == $navValue['condition'])
						echo "<li><a href=\"".$navValue['value']."\">".$navTitle."</a></li>";
					break;
				case 'link':
					echo "<li><a href=\"".$navValue['value']."\" target=\"_blank\">".$navTitle."</a></li>";
					break;
				default:
					throw new Exception("navbar配置类型不是一个允许的值，请检查config.php");
					break;
			}
		}
	}
	static public function printLinks(){
		$linksConfig = Core::config('links');
		foreach ($linksConfig as $title => $url) {
			echo "<a href=\"".$url."\" target=\"_blank\">".$title."</a>\n";
		}
	}
}