<?php

	class userModel
	{
		protected $db;
		protected $checking;
		public function __construct()
		{
			$this->db = new DB;
			$this->checking = new checking;
		}

		public function getUser()
		{ 
			// 查询所有的用户
			// select id, tel, nickname, status
			// from  user
			$data = $this->db
						  ->field('id, tel, nickname, status')
						  ->table('user')
						  ->select();

			return $data;
		}

		public function doAdd()
		{
			// 接收 用户数据
			$data = $_POST;

			// 验证 数据
			// 手机
			if( !$this->checking->tel($data['tel'])){
				notice('手机号码格式不正确');
			}

			// 密码
			if ( $data['pwd'] != $data['repwd']) {
				notice('两次密码不一致');
			}else{
				unset($data['repwd']);
				$data['pwd'] = md5($data['pwd']); 
			}

			// 补充 注册时间
			$data['regtime'] = time();


			// SQL
			$result = $this->db
							->table('user')
							->insert($data);


			// 返回结果
			return $result;
		}

	}



