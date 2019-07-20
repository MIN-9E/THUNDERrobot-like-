<?php 

class lController
{
	function __construct()
	{

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
}
