<?php
class Route {
    //路由解析，根据路由文件解析出URI请求的类，方法以及参数
    //返回格式：Array ( "class" => 类名, "method" => 方法名, "args" => Array 参数列表 )
    static public function start($parapath){
        $__route = require_once(__PATH__."/route.php"); //载入路由列表

        $args = array(); //空数组，用于存储捕获。
        $class = "_empty";
        $method = "_empty";
        foreach ($__route as $pat => $dest) {
            $pat = addcslashes($pat, '/');
            $pattern = "/".$pat."/";
            if(preg_match($pattern, $parapath, $args)){
                $destArray = explode("/", $dest);
                $class = $destArray[0];
                $method = $destArray[1];
                return array(
                    "class" => $class,
                    "method" => $method,
                    "args" => $args,
                );
            }
        }
        throw new Exception("无法找到和请求匹配的路由模式：".$parapath);
    }
}