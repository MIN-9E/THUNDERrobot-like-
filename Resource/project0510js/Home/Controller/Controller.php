<?php

	class Controller
	{
		protected $model;
		
		public function __construct()
		{
			$this->model = new Model;
		}

		public function header()
		{
			// 页面最顶部
			include 'View/index/header.html';
		}

		public function logo_cart()
		{
			// 查询所有的可显示的一级分类
			$cate = $this->model->getCate();

			// logo, 购物车, 导航栏
			include 'View/index/logo_cart.html';
		}

		public function footer()
		{
			// 页面最底部
			include 'View/index/footer.html';
		}

	}






