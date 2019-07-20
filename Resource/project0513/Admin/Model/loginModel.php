<?php 
	
	class LoginModel
	{
		private $db;
		public function __construct()
		{
			$this->db = new DB;
			$this->checking = new checking;
		}

		public function check()
		{

			// 接收 post数据
			$data = $_POST;

			// 验证tel 是否正确
			if ( !$this->checking->tel($data['tel']) ) {
				notice('手机号码格式不正确');
			}

			// 验证pwd
			

			// 验证 短信验证码
			// if ($_SESSION['code'] != $data['code']) {
			if ( '123456' != $data['code']) {
				unset($_SESSION['code']);
				notice('验证码不正确');
			}
			unset($_SESSION['code']);

			// 查询数据库
			// select id 
			// from user
			// where tel = 'xxxx' and pwd = md5('xxxx')

			$result = $this->db
							->field('id')
							->table('user')
							->where("tel = '{$data['tel']}' and pwd = md5('{$data['pwd']}')")
							->find();

			if ($result) {
				// 查询成功
				// 1) 检测是否 "记住密码"
					if ( !empty($data['static']) ) {
						setcookie('tel', $data['tel'], time()+3600*24*7);
						setcookie('pwd', md5($data['pwd']), time()+3600*24*7);
					}

				// 2) 存储 session
					$_SESSION['tel'] = $data['tel'];

				return true;

			}else{
				// 查询失败
				notice('账号或密码有误');
			}
		}

		public function cookie()
		{
			// 接收 cookie数据
			$data = $_COOKIE;

			// 验证tel 是否正确
			if ( !$this->checking->tel($data['tel']) ) {
				return false;
			}

			// 验证pwd
			// ...
			

			// 查询数据库
			$result = $this->db
							->field('id')
							->table('user')
							->where("tel = '{$data['tel']}' and pwd = '{$data['pwd']}' ")
							->find();

			if ($result) {
				# 查询成功
				$_SESSION['tel'] = $data['tel'];
				return true;

			}else{
				# 查询失败
				return false;
			}
		}

		public function sendSMS()
		{
			// 接收 tel
			$tel = $_POST['tel'];

			// 验证tel 是否正确
			if ( !$this->checking->tel($tel) ) {
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
				header('location: index.php?c=login'); die;
			}else{
				# 发送失败
				notice('短信发送失败');
			}



		}

	}

