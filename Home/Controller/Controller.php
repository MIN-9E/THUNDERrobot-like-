<?php 

class Controller
{

	private $model;
	function __construct()
	{
		// echo 'Controller应用成功';
		$this->model=new Model;


	}

	// 加载顶部页面
	function top()
	{
		$data=$this->model->getCate();
		/*
		print_r('<pre>');
		print_r($data);
		print_r('<pre>');*/
		// var_dump($data[0]);
		if (!empty($_SESSION['cart'])) {
			
			$result=$_SESSION['cart'];
			foreach ($result as $key => $value) {
			}
			$result=$result[$key];
			// var_dump($data);die;
		}

		// echo 'top方法链接完成';
		include './View/index/top.html';
	}


	// 加载顶部页面(有下拉框)
	function header()
	{	
		$data=$this->model->getCate();
		if (!empty($_SESSION['cart'])) {
			
			$result=$_SESSION['cart'];
			foreach ($result as $key => $value) {
			}
			$result=$result[$key];
			// var_dump($data);die;
		}

		// echo 'top方法链接完成';
		include './View/index/header.html';
	}

	// 加载尾部页面
	function footer()
	{
		// echo 'footer方法链接完成';
		include './View/index/footer.html';
	}

	public function __call($x,$y)
	{
		// echo '__call页面链接';
		header('location:./View/error/404.html');
	}

	public function __get($x)
	{
		// echo '__call页面链接';
		header('location:./View/error/404.html');die;
	}






}






