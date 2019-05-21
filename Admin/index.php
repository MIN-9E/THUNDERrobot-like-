<?php 

	// 后台的中心控制

	// 加载配置
	require_once '../public/config.php';

	// 自动加载
	function __autoload($x)
	{
		if ( file_exists("Controller/{$x}.php")  ) {
			include "Controller/{$x}.php";
		}elseif ( file_exists("Model/{$x}.php")  ) {
			include "Model/{$x}.php";
		}elseif ( file_exists("../Public/{$x}.php")  ) {
			include "../Public/{$x}.php";
		}else{
			// echo "404"; die;
		header('location:./View/error/404.html');die;
		}
	}


	// 接收参数c 代表类名
	$c = empty($_GET['c'])?'index':$_GET['c'];
	$c .= 'Controller';
	// var_dump($c);die;
	// 接收参数a 代表方法名
	$a = empty($_GET['a'])?'index':$_GET['a'];
	$obj=new $c;
	$obj->$a();
 


	function __get($x)
	{
		echo '__get已连接';
		header('location:./View/error/404.html');die;
	}

	function __call($x,$y)
	{
		echo '__call已连接';
		header('location:./View/error/404.html');die;
	}



