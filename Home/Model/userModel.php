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

	function getUser($name)
	{
		$data=$this->db
					->field()
					->table('user')
					->where("nickname='{$name}'")
				   	->find();
		// var_dump($this->db->sql);die;
		return $data;
	}

	function getAddress($id)
	{
		$data=$this->db
					->field()
					->table('address')
					->where("uid='{$id}'")
					->order('is_default')
					->select();
		// var_dump($data);die;
		return $data;
	}

	function update()
	{
		// 接收送入的修改地址id
		$id=$_GET['id'];

		
		$data=$_POST;
		$data=$this->check->striptags($data);
		$data=$this->check->entities($data);
		// var_dump($data);
		// var_dump($data);die;
		// 验证手机号码是否正确
		$result=$this->check->tel($data['phone']);
		if (!$result) {
			notice('手机号格式错误');
		}

		// 修改更新address
		$rows=$this->db
					->table('address')
					->where("id='{$id}'")
					->update($data);
		// var_dump($this->db->sql);die;
		return $rows;
	}

	function delete()
	{

		// 接收要删除的地址id
		$id=$_GET['id'];
		// var_dump($_GET);die;
		
		// 执行删除操作
		$rows=$this->db
					->table('address')
					->where("id='{$id}'")
					->delete();
		// var_dump($this->db->sql);die;
		return $rows;

	}

	function add($id)
	{
		// 接收post数据
		$data=$_POST;
		$data=$this->check->striptags($data);
		$data=$this->check->entities($data);
		$data['uid']=$id;
		// var_dump($data);die;

		$rows=$this->db
					->table('address')
					->insert($data);
		return $rows;

	}


	function changeStatus($uid)
	{
		// 接收要更改为默认的id
		$aid=$_GET['id'];

		// 将所有uid代表的地址更改为非默认状态
		// $data['is_default']=2;
		// var_dump($data);die;	
		$rows=$this->db
					->table('address')
					->where("uid='{$uid}'")
					->update('is_default=2');
		// var_dump($this->db->sql);
		
		// 将制定id的条目数据变更为1
		$end=$this->db
					->table('address')
					->where("id='{$aid}'")
					->update('is_default=1');
		// var_dump($this->db->sql);
		// var_dump($end);die;
		return [$rows,$end];


	}

	function addUser($id)
	{
		// var_dump($_FILES);
		// var_dump($_POST);
		$data=$_POST;
		// var_dump($data);
		$data=$this->check->striptags($data);
		$data=$this->check->entities($data);
		// var_dump($data);
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


}












