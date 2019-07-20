<?php 

class ordersModel
{

	private $db;
	private $check;
	function __construct()
	{
		// echo 'ordersModel链接成功';
		$this->db=new DB;
		$this->check=new checking;

	}

	function getorders($like,$li,$pag3)
	{
		$data=$this->db
					->field()
					->table('orders')
					->where('status!=3'.$like.$pag3)
					->order('id desc')
					// ->having()
					->limit($li)
				   	->select();
		// var_dump($this->db->sql);
		return $data;
	}

	function getCount($like,$pag3)
	{
		$data=$this->db
					->field('count(id) as count')
					->table('orders')
					->where('status!=3'.$like.$pag3)
					// ->order('id')
					// ->having()/
					->select();
		// var_dump($this->db->sql);
					// var_dump($data);die;
		return $data[0]['count'];
	}



	function delete()
	{
		// echo ' del方法链接成功 ';
		$data=$_GET;
		// var_dump($_GET);die;
		$rows=$this->db
				->table('orders')
				->where("id={$data['id']}")
				->delete();
		// var_dump($this->db->sql);die;
		return $rows;
	}

	function getOne()
	{
		// echo ' getOne方法链接成功 ';
		$id=$_GET['id'];
		$data=$this->db->table('orders')
						->field()
						->where("id={$id}")
						->find();
		return $data;
	}



	function changeStatus()
	{
		$id=$_GET['id'];
		// var_dump($_GET);die;
		$data=$this->getOne();
		$new['status']=$data['status']==1?2:1;
		// var_dump($new);die;
		$result=$this->db
					 ->table('orders')
					 ->where('id='.$id)
					 ->update($new);
		// var_dump($this->db->sql);die;
		// header("location:".$_SERVER['HTTP_REFERER']);die;
		return $result;
	}

	function getOrdersDetail()
	{
		$id=$_GET['id'];
		$data=$this->db
			 ->field('u.nickname,o.orderNum,o.time,o.amount,o.status,o.isPay,o.cancel,o.id')
			 ->table('`orders` as o,user as u')
			 ->where("o.uid=u.id and o.id='{$id}'")
			 ->select();
		// var_dump($this->db->sql);
		return $data;
	}

	function getOrderGoods($id)
	{
		$data[]=$this->db
			 ->field('g.name,i.icon,g.desc,d.price,d.count,g.id as gid')
			 ->table('`ordersgood` as d,`goods` as g,`goodsimg` as i')
			 ->where("d.gid=g.id and i.gid=g.id and i.face=1 and d.oid=$id")
			 ->select();
		// var_dump($this->db->sql);
			 return $data;
	}

	function getProcessOrders($like,$li)
	{
		$data=$this->db
					->field()
					->table('orders')
					->where('status=3'.$like)
					->order('id desc')
					// ->having()
					->limit($li)
				   	->select();
		// var_dump($this->db->sql);
					// var_dump($data);
		return $data;
	}

		function getProcessCount($like)
	{
		$data=$this->db
					->field('count(id) as count')
					->table('orders')
					->where('status=3'.$like)
					// ->order('id')
					// ->having()/
					->select();
		// var_dump($this->db->sql);
					// var_dump($data);
		return $data[0]['count'];
	}


}












