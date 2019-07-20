<?php

	// 基类 
	class Controller
	{
		public function __construct()
		{
			// 检测是否登陆过
			if ( empty($_COOKIE['tel'] )) {
				if( empty($_SESSION['tel']) ){
					# 没cookie, 没session
					header('location: index.php?c=login'); die;
				}
			}else{
				if( empty($_SESSION['tel']) ){
					# 有cookie, 没session  (免登陆)
					header('location: index.php?c=login&a=doCookie'); die;
				}

			}
		}

	}



