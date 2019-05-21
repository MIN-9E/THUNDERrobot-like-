<?php 

class indexModel
{


	private $db;
	function __construct()
	{
		// echo 'goodsModel链接成功';
		$this->db=new DB;

	}

	function goods()
	{
		$data=$this->db
					->field('count(id) as count')
					->table('goods')
					->select();
		// var_dump($data);
		return $data;
	}


	function users()
	{
		$data=$this->db
					->field('count(id) as count')
					->table('user')
					->select();
		// var_dump($data);
		return $data;
	}

	function orders()
	{
		$data=$this->db
					->field('count(id) as count')
					->table('orders')
					->where('isPay=1 and status=3')
					->select();
		// var_dump($data);
		return $data;
	}

	function comments()
	{
		$data=$this->db
					->field('count(id) as count')
					->table('comment')
					->select();
		// var_dump($data);
		return $data;
	}

	function amount()
	{
		$data=$this->db
					->field()
					->table('orders')
					->where('isPay=1 and status=3')
					->select();
		// var_dump($data);
		$amount=0;
		foreach ($data as $k => $v) {
			$amount+=$v['amount'];
		}
		$amount=$amount/10000;
		// var_dump($amount);
		return $amount;
	}

}



