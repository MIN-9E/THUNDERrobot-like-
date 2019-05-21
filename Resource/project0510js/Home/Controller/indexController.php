<?php

	class indexController extends Controller
	{
		protected $model;
		public function __construct()
		{
			// 加载Model
			parent::__construct();

			$this->index = new indexModel;
		}

		public function index()
		{
			$data = $this->index->getHot();

			// 加载首页
			include 'View/index/index.html';
		}

	

	}


