<?php
	
	class goodsController extends Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->goods = new goodsModel;
		}

		public function index()
		{
			// 根据分类来查询商品
			$data = $this->goods->getGoods();

			include 'View/goods/index.html';
		}

		public function detail()
		{
			// 根据当前商品的id 查询相关信息
			$goods = $this->goods->getGoodsInfo(); 
			$imgs = $this->goods->getImgs();
			
			// 查询当前商品的 所有评论


			include 'View/goods/detail.html';
			
		}


		public function __call($x, $y)
		{
			notice('您访问的页面不存在', 'index.php');
		}



	}


