<?php

	class userController
	{
		protected $model;
		public function __construct()
		{
			$this->model = new userModel;
		}

 
		// 加载用户列表页
		public function index()
		{
			$data = $this->model->getUser();

			include 'View/user/index.html';
		}


		// 加载 新增用户界面
		public function add()
		{
			include 'View/user/add.html';
		}

		// 执行 新增用户
		public function doAdd()
		{
			$data = $this->model->doAdd();

			if ($data) {
				notice('成功添加用户', 'index.php?c=user');
			}
			notice('添加用户失败, 请重新添加');

		}



	}

