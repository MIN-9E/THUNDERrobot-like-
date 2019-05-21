<?php 

class userController extends Controller
{

	private $useruserModel;
	// private $page;
	function __construct()
	{
		parent::__construct();
		// echo ' userController页面链接成功 ';
		
		$this->userModel=new userModel;
		// $this->page=new Page;
		// $_GET['search']=empty($_GET['search'])?'':$_GET['search'];
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
		// echo ' index页面链接成功 ';

		// 接收当前用户name
		$name=$_SESSION['nickname'];

		// 查询当前用户信息
		$data=$this->userModel->getUser($name);
		// var_dump($data);die;
		// 加载index页面
		include './View/user/index.html';

	}

	function address()
	{
		// echo 'address页面链接成功 ';
		// 接收当前用户name
		$name=$_SESSION['nickname'];

		// 查询当前用户信息
		$result=$this->userModel->getUser($name);
		$id=$result['id'];
		
		// 查询当前用户地址
		$data=$this->userModel->getAddress($id);

		// 加载页面
		include './View/user/address.html';

	}

	function updateAddress()
	{
		// echo 'update界面链接 ';
		$rows=$this->userModel->update();

		if ($rows) {
			header('location:index.php?c=user&a=address');die;
			
		}
		notice('更改失败');
	}

	function del()
	{
		// echo 'del方法链接 ';
		$rows=$this->userModel->delete();

		if ($rows) {
			header('location:index.php?c=user&a=address');die;
			
		}
		notice('删除失败');
	}

	function addAddress()
	{
		// echo 'addAddress页面链接成功 ';

		$name=$_SESSION['nickname'];

		// 查询当前用户信息
		$result=$this->userModel->getUser($name);
		$id=$result['id'];

		$rows=$this->userModel->add($id);

		if ($rows) {
			header('location:index.php?c=user&a=address');die;
			
		}
		notice('新增失败');
	}

	function change()
	{
		// echo 'change 页面链接成功 ';

		// 查询当前用户信息
		$name=$_SESSION['nickname'];

		$result=$this->userModel->getUser($name);
		// var_dump($result);die;
		$uid=$result['id'];

		// 执行状态更改操作
		$rows=$this->userModel->changeStatus($uid);
		// var_dump($rows);die;
		
		// 判断是否成功
		if ($rows[0]&&$rows[1]) {
			header('location:index.php?c=user&a=address');die;
		}
		notice('状态变更失败');

	}

	function personal()
	{
		// echo 'personal界面链接完成 ';
		// 查询当前用户信息
		$name=$_SESSION['nickname'];

		$result=$this->userModel->getUser($name);
		// var_dump($result);die;
		$data=$result;
		// var_dump($data);

		include './View/user/personal.html';
	}

	function edit()
	{
		// echo 'personal界面链接完成 ';
		// 查询当前用户信息
		$name=$_SESSION['nickname'];

		$result=$this->userModel->getUser($name);
		// var_dump($result);die;
		$data=$result;
		// var_dump($data);

		include './View/user/edit.html';
	}

	function editUser()
	{
		// echo 'addIcon界面链接完成 ';
		// 查询当前用户信息
		$name=$_SESSION['nickname'];

		$result=$this->userModel->getUser($name);
		// var_dump($result);die;
		$id=$result['id'];

		$data=$this->userModel->addUser($id);

		if ($data) {
			notice('修改成功','index.php?c=user');
		}
		notice('修改失败');
	}



}









