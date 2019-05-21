<?php 

class indexModel
{

	private $db;
	function __construct()
	{
		// echo 'indexModel链接成功';
		$this->db=new DB;

	}

	function getHot()
	{
		// echo 'getHot方法链接成功';
		$data=$this->db->field()
				 ->table('goods as g, goodsimg as i')
				 ->where('g.id=i.gid and hot=1 and up =1 and face=1')
				 ->select();
		// var_dump($this->db->sql);die;
		// var_dump($data);die;
		return $data;
	}

	function getFirst($x)
	{
		$data=$this->db->field('g.id as gid,g.name,g.desc,g.price,i.icon,o.comment,u.nickname,count(comment) as cnumb')
				 ->table('goods as g, goodsimg as i,category as c,comment as o,user as u')
				 ->where('g.id=i.gid and g.cid=c.id and g.id=o.gid and o.uid=u.id and up =1 and face=1 and c.pid='.$x)
				 ->group('g.id')
				 ->select();
		// var_dump($this->db->sql);
		// var_dump($data);
		return $data;
	}

	function getHotComment()
	{
		$data=$this->db->field('g.id as gid,g.name,g.desc,g.price,i.icon,o.comment,u.nickname,count(comment) as cnumb')
				 ->table('goods as g, goodsimg as i,category as c,comment as o,user as u')
				 ->where('g.id=i.gid and g.cid=c.id and g.id=o.gid and o.uid=u.id and up =1 and face=1')
				 ->group('g.id')
				 ->order('cnumb desc')
				 ->limit('0,4')
				 ->select();
		// var_dump($this->db->sql);
		// var_dump($data);
		return $data;
	}




}












