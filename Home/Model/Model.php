<?php 

class Model
{
	protected $db;
	function __construct()
	{
		// echo ' model模块应用成功 ';
		$this->db=new DB;
	}

	function getCate()
	{
		// 查询顶级分类
		$data=$this->db->field()
					->table('category')
					->where('pid=0 and display=1')
					->select();
		// var_dump($data);
		// $data=array_reverse($data,true);
		
		// 在顶级分类查询每个下级分类
		foreach ($data as $k => $v) {
			$id=$v['id'];
			$result[]=$this->db
								->field('c.id as cid,g.id as gid,g.name,g.price,i.icon')
								->table('`category` as c,`goods` as g,`goodsimg` as i')
								->where('c.id=g.cid and g.id=i.gid and face=1 and display=1 and up=1 and c.pid='.$id)
								->select();
			// var_dump($this->db->sql);
		}
		// var_dump($result);die;
		// $data2=$this->db->field()
		// 			->table('category')
		// 			->where('pid!=0')
		// 			->select();
		// var_dump([$data,$data2]);die;
		return [$data,$result];
	}



}



