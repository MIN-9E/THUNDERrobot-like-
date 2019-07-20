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

		public function getUser($like, $limit)
		{
			// 查询所有的用户
			// select id, tel, nickname, status
			// from  user
			$data = $this->db
						  ->field('id, tel, nickname, status, icon')
						  ->table('user')
						  ->where($like)
						  ->order('id desc')
						  ->limit($limit)
						  ->select();

			return $data;
		}

		public function getCount($like)
		{
			$data = $this->db
						  ->field(' count(id) as count  ')
						  ->table(' user ')
						  ->where($like)
						  ->select();

			return $data[0]['count'];
			
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

				// 头像
				$icon = upload();
				if( is_string($icon) ){
					notice($icon);
				}

				// 补充 注册时间
				$data['icon'] = $icon[0];
				$data['regtime'] = time();


			// SQL
			$result = $this->db
							->table('user')
							->insert($data);

			// echo  $this->db->sql; die;


			// 返回结果
			return $result;
		}

		public function getFind($id)
		{

			$data = $this->db
						  ->field('id, nickname, tel, email, birthday, sex, status')
						  ->table(' user ')
						  ->where(' id = '.$id)
						  ->find();

			return $data;
		}

		public function doEdit()
		{
			// 接收 用户数据
			$data = $_POST;

			// 验证 数据
				// 手机
				if( !$this->checking->tel($data['tel'])){
					notice('手机号码格式不正确');
				}

				// 密码
				// 密码为空, 则证明不想换密码
				if ( empty($data['pwd']) ) {
					unset($data['pwd']);
					unset($data['repwd']);
				}elseif ( $data['pwd'] != $data['repwd']) {
					// 密码有值, 则证明想改密码
					notice('两次密码不一致');
				}else{
					unset($data['repwd']);
					$data['pwd'] = md5($data['pwd']); 
				}

				// 头像
				if( !is_file_empty() ){
					// 已上传头像, 并检测是否成功
					$icon = upload();
					if( is_string($icon) ){
						notice($icon);
					}

					$data['icon'] = $icon[0];
				}


			// SQL
			$result = $this->db
							->table('user')
							->where('id = '.$data['id'])
							->update($data);

			// echo  $this->db->sql; die;

			// 返回结果
			return $result;
		}

		public function doDel()
		{
			$id = $_GET['id'];

			$data = $this->db
						  ->table('user')
						  ->where('id = '.$id)
						  ->delete();

			return $data;
		}

		public function doStatus()
		{
			$id = $_GET['id'];
			$data = $this->getFind($id);
			
			// 修改当前的状态
			$new['status'] = $data['status']==1?2:1;

			// update user set   `status` = 2  where id = xxx
			$result = $this->db
							->table('user')
							->where('id = '.$id)
							->update($new);

			return $result;
		}


	}



