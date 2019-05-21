<?php 


class loginController
{	
	private $model;
	function __construct()
	{
		// echo ' loginController页面链接成功 ';
		$this->model=new loginModel;
	}


	function index()
	{
		// echo ' index页面链接成功 ';
		include './View/login/index.html';
	}


	function doLogin()
	{	
		// var_dump($_POST);die;
/*		try {
			if (empty($_POST)) {
				throw  new Exception('异常');
			}
		} catch (Exception $e) {
			include './View/error/error.html';
			die;
		}*/
		
		// echo 'doLogin方法链接成功';
		// var_dump($_POST);die;
		// if (empty($_POST['send'])) {
		// 	// 验证密码登录页面
			$result=$this->model->check(); 
			if ($result) {
				notice('登录成功','index.php?c=index');
			}else{
				notice('登陆失败');
			}
			
	/*	}else{
			$end=$this->model->send();
			if (!$end) {
				notice('短信发送失败');
			}else{
				header('location:index.php?c=login');die;
			}
		}*/

		
		
	}

	function doCookie()
	{
		$result=$this->model->cookie();
		// var_dump($result);die;
		if ($result) {
			header('location:index.php?c=index&a=index');
			die;
		}else{
			header('location:index.php?c=login');
			die;
		}
	}

	function loginOut()
	{
		// echo 'loginOut链接成功';
		$result=$this->model->quite();
		header('location:index.php?c=login');
	}


}












