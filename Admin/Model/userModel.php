<?php 

class userModel
{

	private $db;
	private $check;
	function __construct()
	{
		// echo 'userModel链接成功';
		$this->db=new DB;
		$this->check=new checking;

	}

	function getUser($like,$li)
	{
		$data=$this->db
					->field()
					->table('user')
					->where($like)
					->order('id asc')
					->limit($li)
				   	->select();
		// var_dump($this->db->sql);die;
		return $data;
	}

		function getCount($like)
	{
		$data=$this->db
					->table('user')
					->field('count(id) as count')
					->where($like)
					->select();
		// var_dump($this->db->sql);die;
					// var_dump($data);die;
		return $data[0]['count'];
	}


	function addUser()
	{
		// echo ' addUser方法链接成功 ';
		$data=$_POST;

		$data=$this->check->striptags($data);
		$data=$this->check->entities($data);

		// var_dump($data);die;
		// 检测电话格式是否符合条件
		$a=$this->check->tel($data['tel']);
		if (!$a) {
			notice(' 手机号码不正确 ');
		}

		//检查密码格式是否正确 
		$b=$this->check->pwd($data['pwd']);
		if (!$b) {
			notice(' 密码格式不正确 ');
		}

		// 检测邮箱格式
		$c=$this->check->email($data['email']);
		// var_dump($c);die;
		if (!$c) {
			notice('邮箱不存在');
		}

		// 检查两次密码是否一致
		if ($data['pwd']!=$data['repwd']) {
			notice('两次密码输入不一致');
		}
		unset($data['repwd']);
		$data['pwd']=md5($data['pwd']);
		// 设置生日默认值
		if (empty($data['birthday'])) {
			$data['birthday']='19900101';
		}
		// 执行上传文件操作
		// var_dump($_FILES);die;
		if (!is_file_empty()) {
			$d=upLoad();
			if (is_string($d)) {
				notice($d);
			}
			$data['icon']=$d[0];
		}


		// var_dump($data);die;
		$rows=$this->db->table('user')->insert($data);
		// var_dump($this->db->sql);
		return $rows;
	}

	function delete()
	{
		// echo ' del方法链接成功 ';
		$data=$_GET;
		// var_dump($_GET);die;
		$rows=$this->db
				->table('user')
				->where("id={$data['id']}")
				->delete();
		// var_dump($this->db->sql);die;
		return $rows;
	}

	function getOne()
	{
		// echo ' getOne方法链接成功 ';
		$id=$_GET['id'];
		$data=$this->db->table('user')
						->field()
						->where("id={$id}")
						->find();
		return $data;
	}


	function updateUser()
	{
		// echo ' updateUser方法链接成功 ';
		// var_dump($_GET);
		$data=$_POST;
		$data=$this->check->striptags($data);
		$data=$this->check->entities($data);
		$id=$_GET['id'];

		// 如果电话不为空,检测电话格式
		if (!empty($data['tel'])) {
			$a=$this->check->tel($data['tel']);
			if (!$a) {
				notice(' 手机号码不正确 ');
			}
		}else{
			unset($data['tel']);
		}

		if (empty($data['pwd'])) {
			unset($data['pwd']);
			unset($data['repwd']);
		}else{
			//检查密码格式是否正确 
			$b=$this->check->pwd($data['pwd']);
			if (!$b) {
				notice(' 密码格式不正确 ');
			}
			// 检测两次输入密码是否一致
			$id=$_GET['id'];
			if ($data['pwd']!=$data['repwd']) {
				notice('两次密码输入不同');
			}
			unset($data['repwd']);	
			$data['pwd']=md5($data['pwd']);
			
		}


		if (empty($data['email'])){
			unset($data['email']);
		}else{
			// 检测邮箱格式
			$c=$this->check->email($data['email']);
			// var_dump($c);die;
			if (!$c) {
				notice('邮箱不存在');
			}
		}
		


		
		// 设置生日默认值
		if (empty($data['birthday'])) {
			unset($data['birthday']);
		}

		// var_dump($_FILES);
		if (!is_file_empty()) {
			$d=upLoad();
			if (is_string($d)) {
				notice($d);
			}
			$data['icon']=$d[0];
			// var_dump($id);
			// var_dump($data);die;
		}


		$rows=$this->db->table('user')
					->where('id='.$id)
					->update($data);
		// var_dump($this->db->sql);die;
		return $rows;
	}

	function changeStatus()
	{
		$id=$_GET['id'];
		// var_dump($_GET);die;
		$data=$this->getOne();
		$new['status']=$data['status']==1?2:1;
		// var_dump($new);die;
		$result=$this->db
					 ->table('user')
					 ->where('id='.$id)
					 ->update($new);
		// var_dump($this->db->sql);die;
		header("location:".$_SERVER['HTTP_REFERER']);die;
		return $result;
	}



}












