<?php

	class categoryModel
	{
		protected $db;
		protected $checking;

		public function __construct()
		{
			$this->db = new DB;
			$this->checking = new checking;
		}

		public function getCategory()
		{
			$pid = empty($_GET['id'])?0:$_GET['id'];

			// 查询所有的分类
			$data = $this->db
						  ->field('id, name, pid, path, display')
						  ->table('category')
						  ->order('id desc')
						  ->where('pid = '.$pid)
						  ->select();

			return $data;
		}

	
		public function getOrderCate()
		{
			/* 

									path + id + ,
				服装 				0,3,
					男装 			0,3,5,
						T恤 		0,3,5,8
						西装 		0,3,5,9
					女装 			0,3,6
						... 		0,3,6,?
						... 		0,3,6,?
					童装
						...
						...
				数码 				0,4,
					手机 			0,4,10,
						苹果 		0,4,10,13
						小米		0,4,10,14
						华为		0,4,10,15
						OPPO		0,4,10,16
					笔记本
						...
			 */


			// 查询排好序的分类
			$data = $this->db
						  ->field('name, id, path')
						  ->table('category')
						  ->order('concat(path, id, ",") ')
						  ->select();

			return $data;

		}


		public function doAdd()
		{
			// 接收 分类数据
			$data = $_POST;

			// 验证 数据

				// 补充path = 父级path + 父级id
				if ($data['pid'] == 0) {
					$data['path'] = '0,';
				}else{
					$parent = $this->getFind($data['pid']);
					$data['path'] = $parent['path'].$parent['id'].',';
				}


			// SQL
			$result = $this->db
							->table('category')
							->insert($data);

			// echo  $this->db->sql; die;


			// 返回结果
			return $result;
		}

		public function getFind($id)
		{

			$data = $this->db
						  ->field('id, name, pid, path, display')
						  ->table(' category ')
						  ->where(' id = '.$id)
						  ->find();

			return $data;
		}

		public function doEdit()
		{
			// 接收 分类数据
			$data = $_POST;

			// 验证 数据
				// 自己玩...

			// SQL
			$result = $this->db
							->table('category')
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
						  ->table('category')
						  ->where('id = '.$id)
						  ->delete();

			return $data;
		}

		public function doStatus()
		{
			$id = $_GET['id'];
			$data = $this->getFind($id);
			
			// 修改当前的状态
			$new['display'] = $data['display']==1?2:1;

			// update category set   `display` = 2  where id = xxx
			$result = $this->db
							->table('category')
							->where('id = '.$id)
							->update($new);


			return $result;
		}


	}



