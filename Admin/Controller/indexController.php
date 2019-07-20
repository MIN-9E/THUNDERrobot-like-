<?php 

class indexController extends Controller
{


	private $indexModel;
	function __construct()
	{
		// echo 'indexController链接完成';
		parent::__construct();
		$this->indexModel=new indexModel;

	}

	function index()
	{

		$goods=$this->indexModel->goods();
		$users=$this->indexModel->users();
		$orders=$this->indexModel->orders();
		$comments=$this->indexModel->comments();
		$amount=$this->indexModel->amount();


		// echo 'index方法链接完成';
		include './View/index/index.html';
	}


}
















