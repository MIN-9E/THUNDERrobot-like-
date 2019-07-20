<?php 

class goodsController extends Controller
{

	private $model;
	private $page2;
	private $page3;
	private $page5;
	function __construct()
	{
		// echo ' goodsController页面链接成功 ';
		parent::__construct();
		$this->model=new goodsModel;
		$this->page2=new Page2;
		$this->page3=new Page3;
		$this->page5=new Page5;
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
			$like="name like '%{$_GET['search']}%'";
		}
		// var_dump($like);die;
		// 分页

		// 计算总行数 	 	
		$count=$this->model->getCount($like);
		// var_dump($count);
		$li= $this->page2->limit($count);

		// var_dump($_GET);die;
		$data=$this->model->getgoods($like,$li);
		// var_dump($data);
		include './View/goods/index.html';
	}

	function add()
	{
		// echo ' add页面链接成功 ';

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



		include './View/goods/add.html';
	}

	function doAdd()
	{
		// echo 'doAdd页面链接成功';
		var_dump($_GET);
		// 添加goods表
		$result=$this->model->addcategory();
		// var_dump($result);die;
		$rows=$this->model->addgoods($result);

		$row=$this->model->addGoodsImg($rows);


		if ($row) {
			// echo 'chenggong ';
			notice('添加成功','index.php?c=goods');
		}
		notice('添加失败');
		// echo '添加失败';

		// 添加分类

	}

	function del()
	{
		// echo 'del页面链接成功';
		$rows=$this->model->delete();
		if ($rows) {
			notice('删除成功','index.php?c=goods');
		}
		notice('删除失败');
	}

	function edit()
	{
		// echo 'edit 页面链接成功';
		$data=$this->model->getOne();
		// var_dump($data);die;
		include './View/goods/edit.html';
	}
	function doEdit()
	{
		// echo 'doEdit页面链接成功';
		$rows=$this->model->updategoods();
		if ($rows) {
			notice('编辑成功','index.php?c=goods');

		}
		notice('编辑失败');
	}

	function doUp()
	{
		$x='up';
		$data=$this->model->changeStatus($x);
		if ($data) {
			header('location:index.php?c=goods&a=detail');die;
		}

	}

	function doHot()
	{
		$x='hot';
		$data=$this->model->changeStatus($x);
		if ($data) {
			header('location:index.php?c=goods&a=detail');die;
		}

	}
	function detail()
	{
		// 获取单个商品详情
		$data=$this->model->getOne();

		// 获取当前商品的父级分类
		$cid=$data['cid'];
		// 由cid获取pid
		$field='pid';
		$pid=$this->model->getId($cid,$field)['pid'];
		// 由pid,获取父级分类名
		$field='name';
		$name=$this->model->getId($pid,$field)['name'];


		$data['cidName']=$name;
		// var_dump($data);


		include './View/goods/detail.html';
	}

	function manage()
	{
		// 获取当前商品的图片
		$data=$this->model->getPic();
		// var_dump($data);
		include './View/goods/files.html';
	}

	function delImg()
	{
		$gid=$_GET['gid'];
		// var_dump($_GET);die;
		$rows=$this->model->deleteImg();
		if ($rows) {
			header('location:index.php?c=goods&a=manage&id='.$gid);die;
		}
	}

	function doFace()
	{
		$gid=$_GET['gid'];
		$result=$this->model->changeFace();
		if ($result) {
			header('location:index.php?c=goods&a=manage&id='.$gid);die;
		}notice('更改失败');
	}

	function addPic()
	{
		$id=$_GET['id'];
		include './View/goods/addpic.html';
	}

	function doAddPic()
	{
		// var_dump($_POST);
		$gid=$_POST['id'];
		$rows=$this->model->addPicture();
		if ($rows) {
			header('location:index.php?c=goods&a=manage&id='.$gid);die;
		}
		notice('添加失败');

	}

	function goodsDetails()
	{
		$id=$_GET['id'];
		header("location:http://www.szhang.com/Home/index.php?c=goods&a=detail&id={$id}");
	}

	function evaluate()
	{
		$data=$this->model->manageEvaluate();
		include './View/goods/evaluate.html';
	}

	function doShow()
	{
		$result=$this->model->changeShow();
		
	}

	function delComment()
	{
		// echo 'del页面链接成功';
		$rows=$this->model->deleteComment();
		if ($rows) {
			header("location:".$_SERVER['HTTP_REFERER']);die;
			// notice('删除成功','index.php?c=goods');
		}
		notice('删除失败');
	}

}









