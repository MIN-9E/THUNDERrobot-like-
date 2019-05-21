<?php 

class loginModel 
{
	private $db;
	private $check;
	function __construct()
	{
		// echo 'loginModel链接成功';
		$this->db=new DB;
		$this->check=new Checking;
	}

	function check()
	{	
		// echo 'check方法链接成功';
		#接收数据
		$data=$_POST;
		$data=$this->check->striptags($data);
		$data=$this->check->entities($data);
		
		// var_dump($data);
		#验证输入数据格式是否正确
		$b=$this->check->pwd($data['pwd']);
		// var_dump($a,$b);die;
		if (!$b) {
			notice('密码格式不正确');
		}
		/*
		// 验证短信
		if ($_SESSION['code']!=$data['code']) {
			notice('验证码错误');
			unset($_SESSION['code']);
		}
		// unset($_SESSION['code']);
		
		*/
		#验证账号密码是否正确
		$result=$this->db->field('id')
				 ->table('admin')
				 ->where("name='{$data['name']}' and pwd=md5('{$data['pwd']}')")
				 ->find();
		// var_dump($result);die;
		// return $result;
		

		#查询是否勾选记住密码
		if ($result) {
			#如果勾选,设置cookie
			if (!empty($data['che'])) {
				setcookie('name',$data['name'],time()+3600*24*7);
				setcookie('pwd',md5($data['pwd']),time()+3600*24*7);

			}
			#设置session
			$_SESSION['name']=$data['name'];
			
			return true;
		}else{
			notice('账号或密码不正确');
		}


	}

	function cookie()
	{
		$data=$_COOKIE;


		$result=$this->db
				->field('id')
				->table('admin')
				->where("name='{$data['name']}' and pwd='{$data['pwd']}'")
				->find();
				// var_dump($result);die;
		if ($result) {
			$_SESSION['name']=$data['name'];
			return true;
		}else{
			return false;
		}
	}

	function quite()
	{
		// echo 'quite方法链接成功';
		setcookie('name',null,time()-1);
		setcookie('pwd',null,time()-1);
		unset($_SESSION['name']);

	}


}











