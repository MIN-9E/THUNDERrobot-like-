<?php 

class ordersModel
{
	protected $db;
	private $check;
	function __construct()
	{
		// echo 'ordersModel链接成功';
		$this->db=new DB;
		$this->check=new Checking;

	}

	function addOrder($data)
	{

		// echo 'addOrder链接成功 ';
		

		// 由地址id查询地址详情
		$aid=$data['card'];
		$result=$this->db
					->field('uid,receiver,address,phone')
					->table('address')
					->where('id='.$aid)
					->find();
		// var_dump($this->db->sql);die;
		// var_dump($data);
		// var_dump($result);
		// $result=array_merge($data,$result);
		
		// 拼凑insert格式
		$result['orderNum']=$data['orderNum'];
		$result['amount']=$data['count']*$data['price'];
		$result['time']=time();
		// var_dump($result);die;
		
		// 将数据填入orders表中
		$rows=$this->db
					->table('orders')
					->insert($result);

		// var_dump($this->db->sql);die;
		// var_dump($rows);
		// unset($data);
		return $rows;
	}

	function addOrderGoods($data,$rows)
	{
		$order=$data;
		$order['oid']=$rows;

		unset($order['card']);
		unset($order['orderNum']);

		// var_dump($order);die;
		$result=$this->db
					->table('ordersgood')
					->insert($order);
		// unset($data);
		// unset($rows);
		return $result;
	}

	function getOrders()
	{	
		// echo 'getOrders方法已连接 ';
		// 接收当前session,查询用户id
		$name=$_SESSION['nickname'];
		$result=$this->getUser($name);
		$id=$result['id'];
		// var_dump($id);
		// 通过uid查询order表
		
		$dataOrders=$this->db
						 ->field('id,orderNum,time,amount,status')
						 ->table('orders')
						 ->where('isPay=2 and status!=3 and uid='.$id)
						 ->order('orderNum desc')
						 ->select();
		// var_dump($dataOrders);
		return $dataOrders;
	}

	function getOrderGoods($id)
	{

		$data=$this->db
					 ->field('g.name,i.icon,g.desc,d.price,d.count,g.id as gid')
					 ->table('`ordersgood` as d,`goods` as g,`goodsimg` as i')
					 ->where("d.gid=g.id and i.gid=g.id and i.face=1 and d.oid={$id}")
					 ->select();
		// var_dump($this->db->sql);
		// var_dump($data);
		return $data;
	}

	function getUser($name)
	{
		$data=$this->db
					->field('id')
					->table('user')
					->where("nickname='{$name}'")
					->find();
		// var_dump($this->db->sql);die;
		return $data;
	}

	function deleteOrd($id)
	{

		// 删除order表但数据
		$rows=$this->db
					->table('orders')
					->where("id='{$id}'")
					->delete();

		// var_dump($this->db->sql);die;
		return $rows;
	}

	function deleteGood($id)
	{
		// 删除ordersgoods表但数据
		$rows=$this->db
					->table('ordersgood')
					->where("oid='{$id}'")
					->delete();

		return $rows;
	}

	function addStock($id)
	{
		// 通过送入的oid查询对应商品id及订单数量
		$data=$this->db
				->field()
				->table('orders as o,ordersgood as d')
				->where('o.id=d.oid and o.id='.$id)
				->select();
		// var_dump($this->db->sql);
		// 遍历得到的商品信息
		foreach ($data as $k => $v) {

			// 通过gid查询对应商品的库存
			$gid=$v['gid'];
			$goods=$this->db
						->field('stock')
						->table('goods')
						->where('id='.$gid)
						->find();
			// var_dump($goods);
			// 将订单数量加上库存数量并更新库存数量
			$stock=$v['count']+$goods['stock'];
			$rows=$this->db
						->table('goods')
						->where('id='.$gid)
						->update('stock='.$stock);
			// var_dump($this->db->sql);
		}
			// var_dump($rows);die;
		return true;


	}


	function getRecOrders()
	{	
		// echo 'getOrders方法已连接 ';
		// 接收当前session,查询用户id
		$name=$_SESSION['nickname'];
		$result=$this->getUser($name);
		$id=$result['id'];
		// var_dump($id);
		// 通过uid查询order表
		
		$dataOrders=$this->db
						 ->field('id,orderNum,time,amount,status')
						 ->table('orders')
						 ->where('isPay=1 and status!=3 and cancel=2 and uid='.$id)
						 ->order('orderNum desc')
						 ->select();
		// var_dump($dataOrders);
		// var_dump($this->db->sql);
		return $dataOrders;
	}

	function getEvaOrders()
	{	
		// echo 'getOrders方法已连接 ';
		// 接收当前session,查询用户id
		$name=$_SESSION['nickname'];
		$result=$this->getUser($name);
		$id=$result['id'];
		// var_dump($id);
		// 通过uid查询order两表
		$data=$this->db
					 ->field('o.orderNum,o.time,g.name,i.icon,g.desc,d.price,d.count,o.amount,o.status,o.isPay,o.cancel,o.id,g.id as gid,o.uid as uid,d.id as did')
					 ->table('`orders` as o,`ordersgood` as d,`goods` as g,`goodsimg` as i')
					 ->where("o.id=d.oid and d.gid=g.id and i.gid=g.id and i.face=1 and o.uid='{$id}' and o.isPay=1 and o.cancel=2 and o.status=3 and d.iseva=2")
					 ->order('d.id desc')
					 ->select();
		// var_dump($data);
		return $data;
	}

	function getAftOrders()
	{	
		// echo 'getOrders方法已连接 ';
		// 接收当前session,查询用户id
		$name=$_SESSION['nickname'];
		$result=$this->getUser($name);
		$id=$result['id'];
		// var_dump($id);
		// 通过uid查询order两表
		$data=$this->db
					 ->field('o.orderNum,o.time,g.name,i.icon,g.desc,d.price,d.count,o.amount,o.status,o.isPay,o.cancel,o.id,g.id as gid')
					 ->table('`orders` as o,`ordersgood` as d,`goods` as g,`goodsimg` as i')
					 ->where("o.id=d.oid and d.gid=g.id and i.gid=g.id and i.face=1 and o.uid='{$id}' and o.isPay=1 and o.cancel=2 and o.status=3 and d.iseva=1")
					 ->order('d.id desc')
					 ->select();
		// var_dump($data);
		return $data;
	}



	function getPayOrders()
	{
		$id=$_GET['id'];
		$result=$this->db
		 	->field('o.receiver,o.address,o.id,o.phone,o.amount,i.icon,g.name,s.price,s.count')
		 	->table('orders as o,ordersgood as s,goods as g,goodsimg as i')
		 	->where('o.id=s.oid and s.gid=g.id and i.gid= g.id and face=1 and s.oid='."$id")
		 	->find();
		// var_dump($this->db->sql);
		 // var_dump($result);
		return $result;
	}

	function Pay()
	{
		$id=$_POST['card'];
		$data='isPay=1';
		$rows=$this->db
					->table('orders')
					->where('id='.$id)
					->update($data);
		// var_dump($this->db->sql);die;
		
		// 查询订单内商品,销量加
		$result=$this->db
					->field('d.count,g.sold,g.id')
					->table('ordersgood as d,goods as g')
					->where('d.gid=g.id and oid='.$id)
					->select();

		foreach ($result as $k => $v) {
			$sold=$v['sold']+$v['count'];
			// var_dump($sold);
			$add=$this->db
						->table('goods')
						->where('id='.$v['id'])
						->update('sold='.$sold);
		}
		
		return $rows;
	}

	function confirm()
	{
		// 接收订单id
		$id=$_GET['id'];
		$data='status=3';
		// 修改订单状态为收货
		$rows=$this->db
					->table('orders')
					->where('id='.$id)
					->update($data);
		// var_dump($this->db->sql);die;
		
		// 查询该订单号下的goods信息
		$result=$this->db
						->field()
						->table('ordersgood')
						->where('oid='.$id)
						->select();
		// var_dump($result);
		// 遍历goods
		foreach ($result as $k => $v) {
			$id=$v['gid'];
			// 获取该商品的信息
			$data=$this->db
						->field()
						->table('goods')
						->where('id='.$id)
						->find();
			// var_dump($data);
			// 计算售出后数量
			$sold=$data['sold']+$v['count'];
			// 更新goods中sold数量
			$row=$this->db
						->table('goods')
						->where('id='.$id)
						->update('sold='.$sold);
			// var_dump($this->db->sql);
		}
		return $rows;
	}


	function addEvaluate()
	{
		// var_dump($_POST);
		$data=$_POST;
		$data=$this->check->striptags($data);
		$data=$this->check->entities($data);
		if (empty($data['evaTip'])) {
			$data['tip']='外观时尚,游戏畅爽,运行稳定,开机贼快,视效超棒,快递给力,客服nice,性价比高';
		}else{
			
			$data['tip']=implode(',',$data['evaTip']);
		}	
		unset($data['evaTip']);

		if (empty($data['comment'])) {
			notice('请输入评价');
		}

		// var_dump($data);
		$rows=$this->db
					->table('comment')
					->insert($data);
		// var_dump($this->db->sql);die;
		return $rows;
	}

	function evaluating()
	{
		// var_dump($_GET);die;
		$id=$_GET['id'];
		$data='iseva=1';
		$rows=$this->db
					->table('ordersgood')
					->where('id='.$id)
					->update($data);
		// var_dump($this->db->sql);die;
		return $rows;
	}

	function changeAmount($amount,$rows)
	{
		$rows=$this->db
					->table('orders')
					->where("id='{$rows}'")
					->update("amount='{$amount}'");
		// var_dump($this->db->sql);
		return $rows;
	}

	function changeStock()
	{
		// var_dump($_SESSION);die;
		foreach ($_SESSION['cart'] as $k => $v) {
			$id=$k;
			$data['stock']=$v['stock']-$v['count'];
			// var_dump($data);
			$rows=$this->db
						->table('goods')
						->where('id='.$id)
						->update($data);
			// var_dump($this->db->sql);

		}
		return $rows;
	}

	function cancelOrders()
	{
		var_dump($_GET);
		$id=$_GET['oid'];
		$rows=$this->db
					->table('orders')
					->where('id='.$id)
					->update('cancel=1');
		// var_dump($this->db->sql);
		return $rows;
	}




}





