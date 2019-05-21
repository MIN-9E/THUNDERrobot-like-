<?php 

class ordersController extends Controller
{
	function __construct()
	{
		parent::__construct();
		$this->ordersModel=new ordersModel;
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
		// echo 'orders页面加载完毕';

		$data=$this->ordersModel->getOrders();
		// var_dump($data);
		foreach ($data as $k => $v) {
			$dataGoods[]=$this->ordersModel->getOrderGoods($v['id']);
		}
		// var_dump($dataGoods);
		// var_dump(count($dataGoods));
		$x=0;
		include './View/orders/index.html';

	}

	function addOrders()
	{
		// var_dump($_GET);
		// var_dump($_SESSION);
		// // var_dump($_POST);
		// var_dump($_POST);die;
		// 接收post数据
		$data=$_POST;
		// die;
		// 填orders表
		$rows=$this->ordersModel->addOrder($data);

		// 填ordergoods表
		$result=$this->ordersModel->addOrderGoods($data,$rows);
		$stock=$this->ordersModel->changeStock();

		// var_dump($result);die;
		if ($result) {
			unset($_SESSION['cart'][$data['gid']]);
			// var_dump($_SESSION);
			// notice('提交订单成功');
			header('location:index.php?c=orders');die;
		}
		notice('提交订单失败');
	}

	function del()
	{

		$id=$_GET['oid'];

		// 将订单中的商品添加回库存
		$stock=$this->ordersModel->addStock($id);

		// 删除订单orders表数据
		$rows=$this->ordersModel->deleteOrd($id);

		// 删除订单商品ordersgood表数据
		$row=$this->ordersModel->deleteGood($id);


		if ($row&&$rows) {
			header('location:index.php?c=orders');die;
		}
		notice('删除失败');

	}

	function receiving()
	{
		$data=$this->ordersModel->getRecOrders();

		// var_dump($data);
		foreach ($data as $k => $v) {
			$dataGoods[]=$this->ordersModel->getOrderGoods($v['id']);
		}
		// var_dump($dataGoods);
		// var_dump(count($dataGoods));
		$x=0;
		// var_dump($data);
		include './View/orders/receiving.html';
	}

	function evaluating()
	{
		$data=$this->ordersModel->getEvaOrders();

		// var_dump($data);
		include './View/orders/evaluating.html';
	}

	function after()
	{
		$data=$this->ordersModel->getAftOrders();

		include './View/orders/after.html';
	}

	function payOrders()
	{
		// echo 'pay 页面加载完毕 ';

		// 通过商品id获取订单信息
		$data=$this->ordersModel->getPayOrders();

		// // 通过用户id获取收货信息
		// $uid=$_SESSION['nickname'];
		// // var_dump($_SESSION['nickname']);
		// $address=$this->ordersModel->getAddress($uid);
		// // var_dump($address);

		// $data= $this->ordersModel->pay();

		include './View/orders/pay.html';

	}

	function endPay()
	{
		// echo '结算页面已链接 ';

		// var_dump($_POST);

		$rows=$this->ordersModel->Pay();

		if ($rows) {
			notice('付款成功','index.php?c=orders&a=receiving');
		}
		notice('付款失败');
	}

	function confirm()
	{
		// echo '结算页面已链接 ';

		$status=$_GET['status'];

		if ($status==2) {
			notice('货物还未发货,请耐心等待');
		}

		$rows=$this->ordersModel->confirm();

		if ($rows) {
			notice('确认收货成功','index.php?c=orders&a=evaluating');
		}
		notice('确认收货失败');
	}

	function evaluate()
	{
		// echo '评价页面链接 ';
		$data=$_POST;
		// var_dump($data);
		$rows=$this->ordersModel->addEvaluate();

		$result=$this->ordersModel->evaluating();

		if ($rows&&$result) {
			header("location:index.php?c=orders&a=after");die;
		}
		notice('可惜,评论失败');

	}

	function addMultiple()
	{
		// var_dump($_GET);
		// var_dump($_SESSION);
		
		$data2=$_POST;
		$data=$_POST;
		unset($data['card']);
		// unset($data['orderNum']);
		// var_dump($data);
			// $y=0;
		$amount=0;
		// var_dump($data);die;
		
		foreach ($data as $k => $v) {
			for ($i=0; $i < count($data['price']); $i++) { 
				$result[$i]['card']=$data2['card'];
				$result[$i][$k]=$v[$i];

			}
		}
		// var_dump($amount);
		// var_dump($result);
		// var_dump($_SESSION);

		// 填orders表
		$rows=$this->ordersModel->addOrder($result[0]);
		// var_dump($rows);

		foreach ($result as $key => $value) {
			// 填ordergoods表
			$end=$this->ordersModel->addOrderGoods($value,$rows);
			// var_dump($rows,$end);
			// unset($rows);
			// unset($value);
			// var_dump($end);
		}
		// var_dump($end);
		
		// 计算当前订单总数
		foreach ($result as $key => $value) {
			$amount+=($value['price']*$value['count']);
			// var_dump($amount);
		}

		// 修改orders表的总价格
		if (count($result)!==1) {
			$change=$this->ordersModel->changeAmount($amount,$rows);
			// var_dump($change);
		}
		$stock=$this->ordersModel->changeStock();
		// var_dump($stock);
			// var_dump($_SESSION);die;


		if ($stock) {
			unset($_SESSION['cart']);
			notice('提交订单成功','index.php?c=orders');
		}else{
			// echo 111;
			notice('提交订单失败');
		}




	}

	function cancel()
	{
		$rows=$this->ordersModel->cancelOrders();
		if ($rows) {
			header("location:index.php?c=orders&a=after");die;
		}notice('删除失败');
	}




}




