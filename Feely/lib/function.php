<?php
// 本文件中放置全局函数
// 注：本文件中只可以出现function定义

//获取配置
function getConfig($key){
	return Core::config($key);
}

//载入其他模板文件
function loadHtml($name, $__tempArgs){
	View::loadHtml(Core::config('Theme'), $name, $__tempArgs);
}
function loadTheme($theme, $name, $__tempArgs){
	View::loadHtml($theme, $name, $__tempArgs);
}

//【前端】载入静态资源文件
function SR($name){
	return __ROOT__."/Public/".$name;
}

//【前端】根据安装目录获得正确相对地址
function U($path){
	return __ROOT__.$path;
}

//URL安全的Base64编码
function urlsafe_base64_encode($str){
    $find = array('+', '/');
    $replace = array('-', '_');
    return str_replace($find, $replace, base64_encode($str));
}