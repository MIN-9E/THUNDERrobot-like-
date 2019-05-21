<?php 

class ordersController extends Controller
{

	private $model;
	private $page3;
	function __construct()
	{
		// echo ' ordersController页面链接成功 ';
		parent::__construct();
		$this->model=new ordersModel;
		$this->page3=new Page3;
		$this->page4=new Page4;
		$_GET['search']=empty($_GET['search'])?'':$_GET['search'];
		$_GET['pag3']=empty($_GET['pag3'])?'':$_GET['pag3'];
	}


	function index()
	{
		// echo ' index页面链接成功 ';


		// 搜索
		// var_dump($_GET);
		if (empty($_GET['search'])) {
			$like=null;
		}else{
			$like=" and orderNum like '%{$_GET['search']}%'";
		}
		if (empty($_GET['pag3'])) {
			$pag3=null;
		}else{
			$pag3=" and pag3='{$_GET['pag3']}'";
		}
		// var_dump($like);die;
		// 分页

		// 计算总行数 	 	
		$count=$this->model->getCount($like,$pag3);
		$li= $this->page3->limit($count);

		// var_dump($_GET);die;
		$data=$this->model->getorders($like,$li,$pag3);
		// var_dump($data);
		include './View/orders/index.html';
	}

	// function add()
	// {
	// 	echo ' add页面链接成功 ';
	// 	include './View/orders/add.html';
	// }

	// function doAdd()
	// {
	// 	echo 'doAdd页面链接成功';
	// 	$rows=$this->model->addorders();
	// 	if ($rows) {
	// 		notice('添加成功','index.php?c=orders');
	// 	}
	// 	notice('添加失败');
	// }

	function del()
	{
		// echo 'del页面链接成功';
		$pag3=empty($_GET['pag3'])?'':$_GET['pag3'];
		$search=empty($_GET['search'])?'':$_GET['search'];
		$rows=$this->model->delete();
		if ($rows) {
			header("location:index.php?c=orders&search={$search}&page3={$pag3}");die;
		}
		notice('删除失败');
	}
	function delp()
	{
		// echo 'del页面链接成功';
		$pag3=empty($_GET['pag3'])?'':$_GET['pag3'];
		$search=empty($_GET['search'])?'':$_GET['search'];
		$rows=$this->model->delete();
		if ($rows) {
			header("location:index.php?c=orders&a=process&search={$search}&page3={$pag3}");die;
		}
		notice('删除失败');
	}

	// function edit()
	// {
	// 	echo 'edit 页面链接成功';
	// 	$data=$this->model->getOne();
	// 	// var_dump($data);die;
	// 	include './View/orders/edit.html';
	// }
	// function doEdit()
	// {
	// 	echo 'doEdit页面链接成功';
	// 	$rows=$this->model->updateorders();
	// 	if ($rows) {
	// 		notice('编辑成功','index.php?c=orders');

	// 	}
	// 	notice('编辑失败');
	// }

	function doStatus()
	{	
		// var_dump($_GET);die;
		$pag3=empty($_GET['pag3'])?'':$_GET['pag3'];
		$search=empty($_GET['search'])?'':$_GET['search'];
		// var_dump($search);
		// var_dump($pag3);die;
		$data=$this->model->changeStatus();
		if ($data) {
			header("location:index.php?c=orders&search={$search}&page3={$pag3}");die;
		}

	}
	function detail()
	{
		$data=$this->model->getOrdersDetail();
		// var_dump($data);
		$id=$data[0]['id'];
		$result=$this->model->getOrderGoods($id);
		// var_dump($result);
		include './View/orders/detail.html';
	}

	function process()
	{
		// echo ' process页面链接成功 ';


		// 搜索
		// var_dump($_GET);
		if (empty($_GET['search'])) {
			$like=null;
		}else{
			$like=" and orderNum like '%{$_GET['search']}%'";
		}
		// var_dump($like);die;
		// 分页

		// 计算总行数 	 	
		$count=$this->model->getProcessCount($like);
		$li= $this->page4->limit4($count);

		// var_dump($li);var_dump($count);
		// var_dump($_GET);die;
		$data=$this->model->getProcessOrders($like,$li);
		// var_dump($data);
		include './View/orders/process.html';
	}

}









