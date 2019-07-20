<?php 

	// 前台的中心控制

	// 加载配置
	require_once '../public/config.php';


	// 自动加载
	function __autoload($class)
	{
		if ( file_exists("Controller/{$class}.php")  ) {
			include "Controller/{$class}.php";
		}elseif ( file_exists("Model/{$class}.php")  ) {
			include "Model/{$class}.php";
		}elseif ( file_exists("../Public/{$class}.php")  ) {
			include "../Public/{$class}.php";
		}else{
			echo "404"; die;
		}
	}


	// 接收参数c 代表类名
	$c = empty($_GET['c'])?'index':$_GET['c'];
	$c .= 'Controller';
	$obj = new $c;

	// 接收参数a 代表方法名
	$a = empty($_GET['a'])?'index':$_GET['a'];
	$obj->$a();
 








