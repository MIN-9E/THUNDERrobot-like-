<?php

	class goodsModel
	{
		protected $db;

		public function __construct()
		{
			$this->db = new DB;
		}

		public function getGoods()
		{
			// 分类id
			$cateId = $_GET['id'];  # id = 1


			// 根据id = 1 查询出所有 后辈分类的id
				// path like "%,1,%"
				$cateIdList = $this->db
									 ->field('id')
									 ->table('category')
									 ->where("path like  '%,{$cateId},%' ")
									 ->select();

				$cateIdStr = null;
				foreach($cateIdList as $k => $v){
					$cateIdStr .= $v['id'].',';
				}

				$cateIdStr =  $cateIdStr.$cateId;



			// 根据分类查询商品
			$data = $this->db
						  ->field('g.id, name, price, `desc`, sold, icon ')
						  ->table('goods as g, goodsimg as i')
						  ->where("g.id = i.gid and up = 1 and face = 1 and cid in ({$cateIdStr})  ")
						  ->select();

			return $data;
		}

		public function getGoodsInfo()
		{
			// 接收商品id
				$id = $_GET['id'];

			// 根据id 查询商品信息
				$data = $this->db
							  ->field(' id, name, price, `desc`, sold, stock ')
							  ->table('goods')
							  ->where('id = '.$id.' and up = 1')
							  ->find();

			// 返回商品信息
				return $data;
		}


		public function getImgs()
		{
			// 接收商品id
				$gid = $_GET['id'];

			// 根据gid 查询图片信息
				$data = $this->db
							  ->field(' icon ')
							  ->table('goodsimg')
							  ->where('gid = '.$gid)
							  ->order('face asc')    # 好处:  封面就直接在第一个
							  ->select();

			// 返回图片信息
				return $data;
		}




	}


