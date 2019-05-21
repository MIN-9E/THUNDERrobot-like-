<?php 

class cartModel
{
	protected $db;
	function __construct()
	{
		// echo 'cartModel链接成功';
		$this->db=new DB;

	}

	function doAdd()
	{
		// echo 'doAdd方法加载成功 ';
		// var_dump($_GET);
		// 通过gid查询商品详情
		$id=$_GET['id'];
		$data=$this->getGoods($id);

		// 将购买件数加入商品信息
		$data['count']=$_GET['count'];
		// var_dump($data);

		// 遍历session中的购物车详情,
		// 如果商品id在seession中存在,
		// 将商品数量增加
		// 
		foreach ($_SESSION['cart'] as $key => $value) {
			if ($data['id']==$key) {
				// 判断是否超出库存,小于库存则++
				if ($value['count']<$value['stock']) {
					$data['count']+=$value['count'];
				// 大于等于库存则等于库存
				}else{
					$data['count']=$value['count'];
				}
			}
		}
		// var_dump($data);
		if ($data) {
			// $data['count']=$_GET['count'];
			$_SESSION['cart'][$data['id']]=$data;
		// var_dump($_SESSION);die;

			return true;
		}
		return false;
		// var_dump($data);
		// return $data;
	}

	function getGoods($id)
	{

		$result=$this->db
		 	->field('g.id,g.name,g.desc,g.price,icon,stock')
		 	->table('goods as g,goodsimg as i')
		 	->where('g.id=i.gid and face=1 and up=1 and g.id='.$id)
		 	->find();

		return $result;
	}

	function doDec()
	{
		$id=$_GET['id'];
		$data=$this->getGoods($id);
		// var_dump($data);
		// var_dump($data);
		// var_dump($_SESSION);die;
		if ($_SESSION['cart'][$id]['count']>1) {
			$_SESSION['cart'][$id]['count']--;
		}else{
			$_SESSION['cart'][$id]['count']=1;
		}
	}

	function doInc()
	{
		$id=$_GET['id'];
		$data=$this->getGoods($id);
		if ($_SESSION['cart'][$id]['count']<$data['stock']) {
			$_SESSION['cart'][$id]['count']++;
		}else{
			$_SESSION['cart'][$id]['count']=$data['stock'];
		}
	}

	function doCart()
	{
		$data=$_GET;
		// var_dump($data);
		$result=$this->getGoods($data['id']);
		// var_dump($result);
		return $result;
	}

	function getAddress($user)
	{
		$data=$this->db
				   ->field('a.*,u.tel,u.nickname as n')
				   ->table('user as u,address as a')
				   ->where("u.id=a.uid and u.nickname='{$user}'")
				   ->select();
		// var_dump($this->db->sql);die;
		return $data;

	}

}




