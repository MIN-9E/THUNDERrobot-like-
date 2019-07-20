<?php 

class cartController extends Controller
{
	function __construct()
	{
		parent::__construct();
		$this->cartModel=new cartModel;
		if (empty($_COOKIE['nickname'])) {
			if (empty($_SESSION['nickname'])) {
				header('location:index.php?c=login');die;
			}

		}else{
			if (empty($_SESSION['nickname'])) {
				header('location:index.php?c=login&a=doCookie');die;
			}
		}
	}

	function index()
	{
		// echo 'cartIndex页面加载成功 ';

		// 计算购物车页面所有商品的总价
		// var_dump($_SESSION);
		if (!empty($_SESSION['cart'])) {
			
			$sum=0;
			$idNumber=null;
			foreach ($_SESSION['cart'] as $k => $v) {
				// 小计
				$total=$v['price']*$v['count'];
				// 总计
				$sum+=$total;
				// 统计当前购物车中物品id
				$idNumber.=$k.',';
			}
			$idNumber=rtrim($idNumber,',');
			// var_dump($idNumber);
			// var_dump($_SESSION);die;


		}


		// var_dump($sum);die;

		include './View/cart/index.html';
	}

	function add()
	{
		// echo 'add成功';
		$result=$this->cartModel->doAdd();
		if ($result) {
			header('location:index.php?c=cart');
			die;
			
		}else{
			notice('添加失败');
		}
		// header('location:index.php?c=cart');
	}

	function del()
	{
		// echo 'del链接成功 ';
		$id=$_GET['id'];

		// 删除session中的指定id数组
		unset($_SESSION['cart'][$id]);
		header('location:index.php?c=cart');die;

	}

	function dec()
	{
		// echo 'dec链接成功 ';
		$data=$this->cartModel->doDec();
		header('location:index.php?c=cart');die;
	}

	function inc()
	{
		// echo 'increse链接成功 ';
		$data=$this->cartModel->doInc();
		header('location:index.php?c=cart');die;
	}

	function cart()
	{
		// 通过商品id获取商品信息
		$data=$this->cartModel->doCart();

		// 通过用户id获取收货信息
		$uid=$_SESSION['nickname'];
		// var_dump($_SESSION['nickname']);
		$address=$this->cartModel->getAddress($uid);
		// var_dump($address);


		include './View/cart/submit.html';
	}

	function cartAll()
	{
		
		$sum=0;
		foreach ($_SESSION['cart'] as $k => $v) {
			// 小计
			$total=$v['price']*$v['count'];
			// 总计
			$sum+=$total;
			// 统计当前购物车中物品id
		}
		// 通过用户id获取收货信息
		$uid=$_SESSION['nickname'];
		// var_dump($_SESSION['nickname']);
		$address=$this->cartModel->getAddress($uid);

		// var_dump($address);
		
		include './View/cart/submitall.html';
	}





}




