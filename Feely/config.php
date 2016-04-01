<?php
return array(
	//基本配置
	'sitename' => "FeelyBlog",
	'default_title' => 'Feelyblog',
	'copyright' => '',
	'is_hsts' => true, //是否使用HTTPS严格传输安全
	//数据库配置
	'db_type' => 'mysql',
	'db_host' => 'localhost',
	'db_port' => '3306',
	'db_user' => MYSQL_USERNAME,
	'db_pass' => MYSQL_PASSWORD,
	'db_database' => MYSQL_DATABASE,
	//站点设置
	'AdminTheme' => 'Admin', //管理界面主题
	'Theme' => 'simwhite', //前台主题
);