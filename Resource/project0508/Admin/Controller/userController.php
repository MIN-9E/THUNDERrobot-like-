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
			$page = new Page;

			$limit = $page->limit(  $this->model->getCount()   );

			if (empty($_GET['search'])) {
				// 无 搜索选项
				$like = null;
			}else{
				// 有 搜索选项
				$like = " nickname like '%{$_GET['search']}%' ";
			}


			$data = $this->model->getUser($like, $limit);
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

		// 加载 编辑用户界面
		public function edit()
		{
			$id = $_GET['id'];
			$data = $this->model->getFind($id);

			include 'View/user/edit.html';
		}

		// 执行 编辑用户
		public function doEdit()
		{
			$data = $this->model->doEdit();

			if ($data) {
				notice('成功编辑用户', 'index.php?c=user');
			}
			notice('编辑用户失败, 请重新添加');
		}

		// 执行 删除用户
		public function doDel()
		{
			$data = $this->model->doDel();

			if ($data) {
				# 删除成功
				header('location: index.php?c=user');die;
			}

			notice('删除失败');
		}

		// 执行 修改用户状态
		public function doStatus()
		{
			$data = $this->model->doStatus();

			if ($data) {
				# 状态修改成功
				header('location: index.php?c=user');die;
			}

			notice('状态修改失败');
		}

	}

