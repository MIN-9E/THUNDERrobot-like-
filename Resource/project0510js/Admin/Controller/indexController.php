<?php

	class indexController extends Controller
	{
		protected $model;
		public function __construct()
		{
			parent::__construct();

			// 加载Model
			$this->model = new indexModel;

		}


		public function index()
		{
			// 加载首页
			include 'View/index/index.html';
		}


		public function top()
		{
			include 'View/index/top.html';
		}

		public function left()
		{
			include 'View/index/left.html';
		}

		public function main()
		{
			include 'View/index/main.html';
		}

		public function swich()
		{
			include 'View/index/swich.html';
		}

		public function bottom()
		{
			include 'View/index/bottom.html';
		}


	}


