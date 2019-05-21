<?php 

class goodsController extends Controller
{
	function __construct()
	{
		parent::__construct();
		$this->goodsModel=new goodsModel;
	}

	function index()
	{
		// echo 'goods页面加载完毕';
		

		// 计算总行数 	 	
		$count=$this->goodsModel->getCou();
		// var_dump($count);
		$li= $this->goodsModel->lim($count);
		// var_dump($li);
		// var_dump($_GET);die;
		// $data=$this->model->getgoods($like,$li);

		// 获取子分类列表数据
		$goodsType=$this->goodsModel->getType($li);
		// var_dump($goodsType);die;
		
		// 如果数据不为空(送id过来查询),正常显示
		if (empty($goodsType)) {
			header('location:./View/error/404.html');
		}
		include './View/goods/index.html';

	}



	function detail()
	{
		// echo 'detail页面加载完毕';


		// 查询id代表的商品
		$goods=$this->goodsModel->getGoodsInfo();

		// 查询id代表的图片
		$imgs=$this->goodsModel->getGoodsImg();

		// 查询id代表的评论
		$comment=$this->goodsModel->getComment();

		// 查询id代表的评论图片
		$commentImg=$this->goodsModel->getCommentImg();
		$number=count($comment);

		// 查询path,输出nav分类路径
		$path=$this->goodsModel->getPath();
		
		// var_dump($goods);
		// var_dump($imgs);
		// var_dump($comment);
		// var_dump($commentImg);

		// die;
		// 加载详情页
		include './View/goods/detail.html';
	}


/*	function doface()
	{
		$x='face';
		$data=$this->model->changeStatus($x);
		if ($data) {
			header('location:index.php?c=goods');die;
		}

	}*/

}




