<?php

	class categoryController extends Controller
	{
		protected $model;
		public function __construct()
		{
			parent::__construct();
			$this->model = new categoryModel;
		}


		// 加载分类列表页
		public function index()
		{

			$data = $this->model->getCategory();
			include 'View/category/index.html';
		}

		// 加载 新增分类界面
		public function add()
		{
			// 查询所有的子分类
			$cateInfo = $this->model->getOrderCate();

			foreach ($cateInfo as $k => $v) {
				# 统计每个分类的 逗号
				$num = substr_count($v['path'], ',');

				# 重复空格
				$nbsp = str_repeat('-', ($num-1)*5);

				# 添加回 $cateInfo
				$cateInfo[$k]['nbsp'] = $nbsp;
			}

			$pid = empty($_GET['id'])?0:$_GET['id'];
			$path = empty($_GET['path'])?'0,': $_GET['path'].$pid.',';

			include 'View/category/add.html';
		}

		// 执行 新增分类
		public function doAdd()
		{
			$data = $this->model->doAdd();

			if ($data) {
				notice('成功添加分类', 'index.php?c=category');
			}
			notice('添加分类失败, 请重新添加');
		}

		// 加载 编辑分类界面
		public function edit()
		{
			$id = $_GET['id'];
			$data = $this->model->getFind($id);

			include 'View/category/edit.html';
		}

		// 执行 编辑分类
		public function doEdit()
		{
			$data = $this->model->doEdit();

			if ($data) {
				notice('成功编辑分类', 'index.php?c=category');
			}
			notice('编辑分类失败, 请重新添加');
		}

		// 执行 删除分类
		public function doDel()
		{
			$data = $this->model->doDel();

			if ($data) {
				# 删除成功
				header('location: index.php?c=category');die;
			}

			notice('删除失败');
		}

		// 执行 修改分类状态
		public function doStatus()
		{
			$data = $this->model->doStatus();

			if ($data) {
				# 状态修改成功
				header('location: index.php?c=category');die;
			}

			notice('状态修改失败');
		}

	}

