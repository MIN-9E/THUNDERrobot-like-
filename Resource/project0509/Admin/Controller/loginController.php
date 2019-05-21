<?php


	// 登陆模块
	class LoginController
	{
		private $model;

		public function __construct()
		{
			$this->model = new loginModel;
		}

		public function index()
		{
			include 'View/login/index.html';
		}

		public function doLogin()
		{
			// 检测是否有send(发送短信)
			if ( empty($_POST['send']) ) {
				// 检测 登陆信息是否正确
				$data = $this->model->check();

				if ($data) {
					notice('登陆成功', 'index.php?c=index');
				}
				notice('登陆失败');
			}else{
				// 发送短信
				$data = $this->model->sendSMS();

			}

			
		}

		public function doCookie()
		{
			// 检测cookie中的数据是否正确
			$data = $this->model->cookie();

			if ($data) {
				// 免登陆成功, 首页
				header('location: index.php'); die;
			}else{
				// 免登陆失败, 登录页
				header('location: index.php?c=login'); die;
			}

		}


	}


