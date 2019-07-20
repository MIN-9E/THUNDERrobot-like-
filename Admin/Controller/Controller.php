<?php 

class Controller
{
	function __construct()
	{
		// echo 'cotroller 链接成功 ';
		if (empty($_COOKIE['name'])) {
			if (empty($_SESSION['name'])) {
				header('location:index.php?c=login');die;
			}

		}else{
			if (empty($_SESSION['name'])) {
				header('location:index.php?c=login&a=doCookie');die;
			}
		}
	}

	function __get($x)
	{
		// echo '__get已连接';
		header('location:./View/error/404.html');die;
	}

	function __call($x,$y)
	{
		// echo '__call已连接';
		header('location:./View/error/404.html');die;
	}


}






