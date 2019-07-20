<?php 

class categoryModel
{

	private $db;
	private $check;
	function __construct()
	{
		echo 'categoryModel链接成功';
		$this->db=new DB;
		$this->check=new checking;

	}

	function getcategory()
	{
		if (!empty($_GET['path'])) {
			$word=$_GET['path']=='0,'?'0': strrev(strtok(ltrim(strstr(strrev(rtrim($_GET['path'],',')),','),','),','));
			// var_dump($word);die;
		}elseif (!empty($_GET['id'])) {
			$word=$_GET['id'];
		}else{
			$word=0;
		}

			// $word=empty($_GET['id'])?0:$_GET['id'];

		$data=$this->db
					->field()
					->table('category')
					->order('id asc')
					->where('pid='.$word)
				   	->select();
		// var_dump($this->db->sql);die;
		return $data;
	}


	function addcategory()
	{
		// echo ' addcategory方法链接成功 ';
		$data=$_POST;
		$data=$this->check->striptags($data);
		$data=$this->check->entities($data);
		// var_dump($data);die;
		$rows=$this->db->table('category')->insert($data);
		return $rows;
	}

	function delete()
	{
		// echo ' del方法链接成功 ';
		$data=$_GET;
		// var_dump($_GET);die;
		$rows=$this->db
				->table('category')
				->where("id={$data['id']}")
				->delete();
		// var_dump($this->db->sql);die;
		return $rows;
	}

	function getOne()
	{
		// echo ' getOne方法链接成功 ';
		$id=$_GET['id'];
		$data=$this->db->table('category')
						->field()
						->where("id={$id}")
						->find();
		// var_dump($this->db->sql);die;
		return $data;
	}


	function updatecategory()
	{
		// echo ' updatecategory方法链接成功 ';
		// var_dump($_GET);
		$data=$_POST;
		$id=$_GET['id'];
		$data=$this->check->striptags($data);
		$data=$this->check->entities($data);

		$rows=$this->db->table('category')
					->where('id='.$id)
					->update($data);
		// var_dump($this->db->sql);die;
		return $rows;
	}

	function changeStatus()
	{
		$id=$_GET['id'];
		$data=$this->getOne();
		$new['display']=$data['display']==1?2:1;
		// var_dump($new);die;
		$result=$this->db
					 ->table('category')
					 ->where('id='.$id)
					 ->update($new);
		// var_dump($this->db->sql);die;
		return $result;
	}

	function getOrderCate()
	{
		$data=$this->db
				   ->field('name,id,path')
				   ->table('category')
				   ->order('concat(path,id,",")')
				   ->select();
		// var_dump($data);die;
		return $data;
	}



}












