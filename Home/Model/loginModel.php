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
		// var_dump($data);
	
		$data=$this->check->striptags($data);
		$data=$this->check->entities($data);
		#验证输入数据格式是否正确
		$b=$this->check->pwd($data['pwd']);
		// var_dump($a,$b);die;
		if (!$b) {
			notice('密码格式不正确');
		}
		/*
		// 验证短信
		session_start();
		if ($_SESSION['code']!=$data['code']) {
			notice('验证码错误');
			unset($_SESSION['code']);
		}
		// unset($_SESSION['code']);
		
		*/
		// var_dump($data);
		#验证账号密码是否正确
		$result=$this->db->field('id')
				 ->table('user')
				 ->where("nickname='{$data['nickname']}' and pwd=md5('{$data['pwd']}')")
				 ->find();
		// var_dump($result);die;
		// return $result;
		

		#查询是否勾选记住密码
		if ($result) {
			#如果勾选,设置cookie
			if (!empty($data['che'])) {
				setcookie('nickname',$data['nickname'],time()+3600*24*7);
				setcookie('pwd',md5($data['pwd']),time()+3600*24*7);

			}
			#设置session
			$_SESSION['nickname']=$data['nickname'];
			
			// 更新登录时间
			$this->updateTime();
			notice('登录成功','index.php');
		}else{
			notice('账号或密码不正确');
		}


	}

	function updateTime()
	{
		$time=time();
		$time=$this->db->table('user')
					->where("nickname='{$_SESSION['nickname']}'")
					->update("lasttime={$time}");
		// var_dump($this->db->sql);die;
		
	}

	function cookie()
	{
		$data=$_COOKIE;



		$result=$this->db
				->field('id')
				->table('user')
				->where("nickname='{$data['nickname']}' and pwd='{$data['pwd']}'")
				->find();
				// var_dump($result);die;
		if ($result) {
			$_SESSION['nickname']=$data['nickname'];
			return true;
		}else{
			return false;
		}
	}

	function quite()
	{
		// echo 'quite方法链接成功';
		setcookie('nickname',null,time()-1);
		setcookie('pwd',null,time()-1);
		unset($_SESSION['nickname']);
		unset($_SESSION['cart']);
		// var_dump($_SESSION);die;

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
		if (!empty($data['email'])) {
			$c=$this->check->email($data['email']);
			// var_dump($c);die;
			if (!$c) {
				notice('邮箱不存在');
			}
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

		if (empty($data['checkBox'])) {
			echo '请勾选用户协议 ';
			return false;
		}



		if (empty($data['code'])) {
			echo '请验证手机号码 ';
			return false;
		}
		// 验证短信
		if (empty($_SESSION['code'])) {
			echo '请验证手机号码 ';
			return false;
		}
		if ($_SESSION['code']!=$data['code']) {
			notice('验证码错误');
			unset($_SESSION['code']);
		}
		unset($_SESSION['code']);
		
		unset($data['code']);
		unset($data['checkBox']);
		
		// 执行上传文件操作
		// var_dump($_FILES);die;
		/*if (!is_file_empty()) {
			$d=upLoad();
			if (is_string($d)) {
				notice($d);
			}
			$data['icon']=$d[0];
		}*/

		// var_dump($_SESSION);
		// var_dump($data);
		$rows=$this->db->table('user')->insert($data);
		// var_dump($this->db->sql);die;
		return $rows;
	}

		public function send()
		{
			// 接收 tel
			$tel = $_POST['tel'];
			
			// 验证tel 是否正确
			if ( !$this->check->tel($tel) ) {
				notice('手机号码格式不正确');
			}

			// 生成随机的验证码, 并存储至session
			$_SESSION['code'] = mt_rand(1000,9999);
			
			// 提示时间
			$time = 10;


			$data = [$_SESSION['code'], $time];

			$result = sendSMS($tel, $data, 1);

			if ($result) {
				# 发送成功
				header('location: index.php?c=login&a=regist'); die;
			}else{
				# 发送失败
				notice('短信发送失败');
			}



		}


}











