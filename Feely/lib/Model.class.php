<?php
class Model{
	static private $model_conn;
	private $sql;

	function __construct($table_name){
		$this->table_name = $table_name;
		$this->sql = "";
		$this->connect();
	}
	function __destruct(){
		//由于使用PDO代替传统的mysqllib连接方式，这里原本的关闭连接暂时弃用。
	}
	
	private function connect(){
		if(is_null(self::$model_conn)){
			try{
				$dsn = Core::config('db_type').":host=".Core::config('db_host').";port=".Core::config('db_port').";dbname=".Core::config('db_database');
				$PDO_ATTR = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'");
				self::$model_conn = new PDO($dsn, Core::config('db_user'), Core::config('db_pass'), $PDO_ATTR);
			}catch(Exception $e){
				Core::showError("数据库连接错误：".$e);
			}
		}
		return self::$model_conn;
	}
	
	protected function sql(){
		$db = self::$model_conn;
		$this->sql = $db->prepare(func_get_arg(0));
		$arg_length = func_num_args();
		try{
			for($i = 1; $i < $arg_length; $i++){
				$this->sql->bindValue($i, func_get_arg($i));
			}
		}catch(Exception $e){
			Core::showError("数据库参数绑定错误：".$e);
		}
		return $this;
	}
	
	protected function select(){
		try{
			$this->sql->execute();
			$res = $this->sql->fetchAll();
			return $res;
		}catch(Exception $e){
			Core::showError("在数据库查询过程中出现异常：".$e);
		}
	}
	
	protected function execute(){
		try{
			return $this->sql->execute();
		}catch(Exception $e){
			Core::showError("在数据库执行过程中出现异常：".$e);
		}
	}
	
	protected function F($text){
		return addslashes($text);
	}
}