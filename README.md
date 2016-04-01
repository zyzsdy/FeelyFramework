# FeelyFramework 2.0

这是一个为了方便我的PHP博客开发而做的一个十分简单的PHP框架。

## 文件结构与说明

```
Public/            前端公共资源文件
Feely/             主程序位置
Feely/main.php     主程序（一般不要修改）
Feely/route.php    设置URL到Controller的路由
Feely/config.php   配置项设置
Feely/lib/         存放核心程序（一般不要修改）
Feely/Themes/      存放主题模板
Feely/Controller/  存放Controller（接收浏览器数据的控制器）
Feely/Model/       存放Model（和数据库交换的数据模型）
```

## MVC架构

### Model

存放在`Feely/Model`目录。

一个文件里存放一个类。类名命名为首字母大写XxxxModel。

这个类存放的文件名为XxxxModel.class.php

每个类都需要继承Model类。然后写一个构造函数，在构造函数里调用其基类的构造函数，参数值为数据表名。

方法：

#### F()

参数：String

返回值： String

这个函数会对传入字符串中影响SQL执行的特殊字符进行转义。

#### sql()

参数：String, Mixed...

返回值：Model对象

这个函数可以接收1至任意个参数。

第一个参数是要执行的SQL语句。语句中可以用半角问号`?`，作为SQL中参数的占位符。接下来可以将这些参数通过函数传入。

语句中的问号数量必须和之后跟着的参数个数相等。

#### select()

参数：无

返回值：结果集数组

执行SQL并返回结果集。必须在调用过sql()方法后才能调用，不然会出错。

#### execute()

参数：无

返回值：无

执行一个无需返回结果集的SQL。必须在调用过sql()方法后才能调用，不然会出错。

下面是一个典型的Model的例子：
```php
<?php
class BilirokuModel extends Model{
	function __construct(){
		parent::__construct("biliroku");
	}
	public function add($version, $os, $roomid, $ua){
		$version = $this->F($version);
		$os = $this->F($os);
		$roomid = $this->F($roomid);
		$ua = $this->F($ua);

		$this->sql("INSERT INTO `biliroku`(`ver`, `os`, `roomid`, `ua`) VALUES(?, ?, ?, ?)", $version, $os, $roomid, $ua)->execute();
	}
    public function addvod($version, $ua){
        $version = $this->F($version);
        $ua = $this->F($ua);
        
        $this->sql("INSERT INTO `bilivod`(`version`, `ua`) VALUES(?, ?)", $version, $ua)->execute();
    }
}
```

### Controller

存放在`Feely/Controller`目录。

一个文件里存放一个类。类名命名为首字母大写XxxxController。

这个类存放的文件名为XxxxController.class.php

每个类都需要继承Controller类。

方法：

#### __construct()

基类的构造函数，不强制调用。参数：布尔值

不在自己写的派生类中调用基类构造函数时，默认为false。

当参数为true时，使用的是`Themes`中的`AdminTheme`主题，否则为默认主题。这两个主题对应的目录可以在`config.php`中设置。

#### display()

参数：Array 模板内的变量数组, String 模板名称

渲染模板并输出。

下面是一个典型的Controller类：

```php
<?php
class IndexController extends Controller{
	public function index($page=1){
		$assign['title'] = ($page==1?"":("第".$page."页 - "))."首页";
		$this->display($assign, 'index');	
	}
}
```

### View

你不能也无需自己手工控制View。

## Theme

本框架采用php本身作为模板语言。

比如输出一个变量为a的值的时候。一般使用`<?=$a?>`

可在模板中使用的全局函数

### loadHtml("模板名", $__t)

导入其他的模板。

参数：String 模板名, 第二个参数固定为$__t（同时请不要在模板中其他地方使用这个名字，以免造成冲突）

### loadHtml("主题名", "模板名", $__t)

导入其他主题的模板。

参数：String 主题名, String 模板名, 第三个参数固定为$__t（同时请不要在模板中其他地方使用这个名字，以免造成冲突）

### SR()

获得静态资源路径。

### U()

在不将本框架安装在根目录的情况，需要在模板中使用此函数来获得文件的相对路径。

### config

读取配置：

全局函数 getConfig()

参数：设置key

返回值：设置值

### route

设置一行一个的路由模型

路由模型的键为正则表达式。正则匹配成功一个地址后，就会将取到的结果传给这个地址对应的处理方法。

例，下面这段代码将匹配到aaa地址的页面请求发送给IndexController下的aaa方法。

如果正则表达式含有捕获。那么捕获到的值将会作为参数顺次传递给方法。

```php
return array(
    'aaa' => 'Index/aaa'
);
```