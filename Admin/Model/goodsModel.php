<?php 

class goodsModel
{

	private $db;
	private $check;
	function __construct()
	{
		// echo 'goodsModel链接成功';
		$this->db=new DB;
		$this->check=new checking;

	}

	function getgoods($like,$li)
	{
		$data=$this->db
					->field()
					->table('goods as g,goodsimg as i')
					->where('g.id=i.gid and face=1')
					->order('g.id desc')
					->having($like)
					->limit($li)
				   	->select();
		// var_dump($this->db->sql);die;
		// var_dump($data);
		return $data;
	}

	function getCount($like)
	{
		$data=$this->db
					->table('goods')
					->field('count(id) as count')
					->where($like)
					->select();
		// var_dump($this->db->sql);die;
					// var_dump($data);die;
		return $data[0]['count'];
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
	
	function addcategory()
	{
		// echo ' addcategory方法链接成功 ';
		$data=$_POST;
		$data=$this->check->striptags($data);
		$data=$this->check->entities($data);
		// var_dump($data);
		// 添加后停留在添加页面,将id当做pid搜索页面
		$id=empty($_GET['id'])?null:$_GET['id'];
		// var_dump($data);
		
		// 凑category表path
		if ($data['pid']==0) {
			$result['path']='0,';
		}else{

			// 查询选择分类的path
			$parent=$this->getOneCa($data['pid']);
			$result['path']=$parent['path'].$parent['id'].',';
		}
		$result['name']=$data['name'];
		$result['pid']=$data['pid'];

		// var_dump($result);die;
		$rows=$this->db->table('category')->insert($result);
		// var_dump($this->db->sql);
		return $rows;
	}


	function getOneCa($id)
	{
		// echo ' getOneCa方法链接成功 ';
		// $id=$_GET['id'];
		$data=$this->db->table('category')
						->field()
						->where("id={$id}")
						->find();
		// var_dump($this->db->sql);die;
		return $data;
	}


	function addgoods($cid)
	{
		// echo ' addgoods方法链接成功 ';
		
		$data=$_POST;
		$data=$this->check->striptags($data);
		$data=$this->check->entities($data);

		// 执行上传文件操作
		
		// var_dump($_FILES);

		// 将数组格式转化
		// $_FILES=getFiles($_FILES);





		if (!empty($data['uptime'])) {
			strtotime($data['uptime']);
		}
		$data['cid']=$cid;
		unset($data['pid']);
		// var_dump($data);die;
		$rows=$this->db->table('goods')->insert($data);
		// var_dump($this->db->sql);die;
		return $rows;
	}

	function addGoodsImg($gid)
	{
				// 执行上传文件操作
		// var_dump($_FILES);die;
		if (!is_file_empty()) {
			$d=upLoad();
			if (is_string($d)) {
				notice($d);
			}
			$data['icon']=$d[0];
			$data['gid']=$gid;
			$data['face']=1;
		}
		// var_dump($data);die;
		$rows=$this->db->table('goodsimg')->insert($data);
		return $rows;

	}



	function delete()
	{
		// echo ' del方法链接成功 ';
		$data=$_GET;
		// var_dump($_GET);die;
		$rows=$this->db
				->table('goods')
				->where("id={$data['id']}")
				->delete();
		// var_dump($this->db->sql);die;
		return $rows;
	}

	function getOne()
	{
		// echo ' getOne方法链接成功 ';
		$id=$_GET['id'];
		$data=$this->db->table('goods')
						->field()
						->where("id={$id}")
						->find();
		return $data;
	}


	function updategoods()
	{
		// echo ' updategoods方法链接成功 ';
		// var_dump($_GET);
		$data=$_POST;
		$data=$this->check->striptags($data);
		$data=$this->check->entities($data);
		$id=$_GET['id'];


		$rows=$this->db->table('goods')
					->where('id='.$id)
					->update($data);
		// var_dump($this->db->sql);die;
		// var_dump($rows);die;
		return $rows;
	}

	function changeStatus($x)
	{

		// 接收修改目标id
		$id=empty($_GET['id'])?null:$_GET['id'];
		// var_dump($_GET);die;
		
		//引用本类中的getone方法,获取当前id数据 
		$data=$this->getOne();
		// var_dump($data);die;
		
		// 修改数据中对应条目数据
		$new[$x]=$data[$x]==1?2:1;
		// var_dump($new);die;
		
		// 重新更新数据库对应数据
		$result=$this->db
					 ->table('goods')
					 ->where('id='.$id)
					 ->update($new);
		// var_dump($this->db->sql);die;
		
		// 回到上一级页面,即当前页面
		header("location:".$_SERVER['HTTP_REFERER']);die;
		return $result;
	}

	function getId($id,$field)
	{
		$data=$this->db->table('category')
						->field("$field")
						->where("id={$id}")
						->find();
		// var_dump($this->db->sql);die;
		return $data;
	}
	function getCidName($id)
	{
		$data=$this->db->table('category')
						->field('name')
						->where("id={$id}")
						->find();
		var_dump($this->db->sql);die;
		return $data;
	}

	function getPic()
	{

		$id=$_GET['id'];

		$data=$this->db
					->field()
					->table('goodsimg')
					->where("gid='{$id}'")
					->select();
		// var_dump($this->db->sql);die;

		return $data;
	}

	function deleteImg()
	{
		$id=$_GET['id'];
		$rows=$this->db
					->table('goodsimg')
					->where("id='{$id}'")
					->delete();
		return $rows;
	}

	function changeFace()
	{
		$gid=$_GET['gid'];
		$id=$_GET['id'];
		$rows=$this->db
					->table('goodsimg')
					->where("gid='{$gid}'")
					->update('face=2');
		// var_dump($this->db->sql);

		$result=$this->db
					->table('goodsimg')
					->where("id='{$id}'")
					->update('face=1');
		// var_dump($this->db->sql);

		return $result;

	}

	function addPicture()
	{
		$data=$_POST;
		$data=$this->check->striptags($data);
		$data=$this->check->entities($data);
		
		if (!is_file_empty()) {
			$d=upLoad();
			if (is_string($d)) {
				notice($d);
			}
			$file['icon']=$d[0];
		}

		$file['gid']=$data['id'];

		$rows=$this->db->table('goodsimg')->insert($file);
		// var_dump($this->db->sql);
		return $rows;
	}

	function manageEvaluate()
	{
		// var_dump($_GET);
		$id=$_GET['id'];
		// echo 'manageEvaluate链接';
		$data=$this->db
					->field('c.*,u.nickname,u.icon')
					->table('comment as c,user as u')
					->where('c.uid=u.id and gid='.$id)
					->select();
		// var_dump($data);
		return $data;

	}


	function changeShow()
	{

		// 接收修改目标id
		$id=empty($_GET['cid'])?null:$_GET['cid'];
		// var_dump($_GET);die;
		
		//引用本类中的getone方法,获取当前id数据 
		$data=$this->getCom($id);
		// var_dump($data);die;
		
		// 修改数据中对应条目数据
		$new['isShow']=$data['isShow']==1?2:1;
		// var_dump($new);die;
		
		// 重新更新数据库对应数据
		$result=$this->db
					 ->table('comment')
					 ->where('id='.$id)
					 ->update($new);
		// var_dump($this->db->sql);die;
		
		// 回到上一级页面,即当前页面
		if ($result) {
			header("location:".$_SERVER['HTTP_REFERER']);die;
		}notice('更改失败');
	}

	function getCom($id)
	{
		// echo ' getOne方法链接成功 ';
		$data=$this->db->table('comment')
						->field()
						->where("id={$id}")
						->find();
		return $data;
	}

	function deleteComment()
	{
		// echo ' del方法链接成功 ';
		$data=$_GET;
		// var_dump($_GET);die;
		$rows=$this->db
				->table('comment')
				->where("id={$data['cid']}")
				->delete();
		// var_dump($this->db->sql);die;
		return $rows;
	}


}












