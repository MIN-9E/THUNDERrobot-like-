<?php 

class indexController extends Controller
{

	private $indexModel;
	function __construct()
	{
		parent::__construct();
		$this->indexModel=new indexModel;
	}

	function index()
	{
		// echo 'index方/法链接完成';
		$data=$this->indexModel->getHot();

		$data1=$this->indexModel->getFirst(1);

		$data2=$this->indexModel->getFirst(4);

		$data3=$this->indexModel->getFirst(5);

		$data4=$this->indexModel->getHotComment();



		include './View/index/index.html';
	}



}
















