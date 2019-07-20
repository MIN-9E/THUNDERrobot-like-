<?php 

class userController extends Controller
{

	private $model;
	private $page;
	function __construct()
	{
		// echo ' userController页面链接成功 ';
		parent::__construct();
		$this->model=new userModel;
		$this->page=new Page;
		$_GET['search']=empty($_GET['search'])?'':$_GET['search'];
	}


	function index()
	{
		// echo ' index页面链接成功 ';


		// 搜索
		// var_dump($_GET);
		if (empty($_GET['search'])) {
			$like=null;
		}else{
			$like="nickname like '%{$_GET['search']}%'";
		}
		// var_dump($like);die;
		// 分页

		// 计算总行数 	 	
		$count=$this->model->getCount($like);
		$li= $this->page->limit($count);

		// var_dump($_GET);die;
		$data=$this->model->getUser($like,$li);
		include './View/user/index.html';
	}

	function add()
	{
		// echo ' add页面链接成功 ';
		include './View/user/add.html';
	}

	function doAdd()
	{
		// echo 'doAdd页面链接成功';
		$rows=$this->model->addUser();
		if ($rows) {
			notice('添加成功','index.php?c=user');
		}
		notice('添加失败');
	}

	function del()
	{
		// echo 'del页面链接成功';
		$rows=$this->model->delete();
		if ($rows) {
			notice('删除成功','index.php?c=user');
		}
		notice('删除失败');
	}

	function edit()
	{
		// echo 'edit 页面链接成功';
		$data=$this->model->getOne();
		// var_dump($data);die;
		include './View/user/edit.html';
	}
	function doEdit()
	{
		// echo 'doEdit页面链接成功';
		$rows=$this->model->updateUser();
		if ($rows) {
			notice('编辑成功','index.php?c=user');

		}
		notice('编辑失败');
	}

	function doStatus()
	{

		$data=$this->model->changeStatus();
		if ($data) {
			header('location:index.php?c=user');die;
		}

	}
	function detail()
	{

		$data=$this->model->getOne();
		include './View/user/detail.html';
	}

}









