<?php 

class categoryController extends Controller
{

	private $model;
	function __construct()
	{
		// echo ' categoryController页面链接成功 ';
		parent::__construct();
		$this->model=new categoryModel;
	}


	function index()
	{
		// echo ' index页面链接成功 ';

		$data=$this->model->getcategory();
		include './View/category/index.html';
	}

	function add()
	{
		// 查询所有子分类
		$data=$this->model->getOrderCate();
		// var_dump($_GET);

		foreach ($data as $k => $v) {
			// 统计所有分类的逗号
			$num=substr_count($v['path'],',');

			// 重复空格
			$space=str_repeat('&nbsp;',$num*4);

			// 添加回$data
			$data[$k]['space']=$space;
		}

		// var_dump($data);
		$pid=empty($_GET['id'])?'0':$_GET['id'];
		$newpath=empty($_GET['path'])?'0,':$_GET['path'].$pid.',';


		// echo ' add页面链接成功 ';
		include './View/category/add.html';
	}

	function doAdd()
	{
		// echo 'doAdd页面链接成功';
		
		$rows=$this->model->addcategory();
		if ($rows) {
			header('location:index.php?c=category&id='.$id);
		}
		notice('添加失败');
	}

	function del()
	{
		$p=$_GET['pid'];
		// var_dump($_GET);die;
		// echo 'del页面链接成功';
		$rows=$this->model->delete();
		if ($rows) {
			header('location:index.php?c=category&id='.$p);die;
		}
		notice('删除失败');
	}

	function edit()
	{
		// echo 'edit 页面链接成功';
		$data=$this->model->getOne();
		// var_dump($data);die;
		include './View/category/edit.html';
	}
	function doEdit()
	{	
		// var_dump($_GET);die;
		// echo 'doEdit页面链接成功';
		$rows=$this->model->updatecategory();
		if ($rows) {
			notice('编辑成功','index.php?c=category&id='.$_GET['pid']);

		}
		notice('编辑失败');
	}

	function doStatus()
	{
		$p=$_GET['pid'];
		// var_dump($p);die;
		$data=$this->model->changeStatus();
		if ($data) {
			header('location:index.php?c=category&id='.$p);die;
		}

	}
	function detail()
	{

		$data=$this->model->getOne();
		include './View/category/detail.html';
	}
/*	function back()
	{
		$url=$_SERVER['HTTP_REFERER'];
		header("location:$url");die;
		// echo "<meta http-equiv='refresh' content='0; url={$url}'>";
	}*/

}









