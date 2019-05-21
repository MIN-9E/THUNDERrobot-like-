<?php

	class indexModel
	{
		protected $db;
		public function __construct()
		{
			// 加载 DB类
			$this->db = new DB;
		}

		public function getHot()
		{
			
			$data = $this->db
						  ->field('g.id, name, price, `desc`, sold, icon ')
						  ->table('goods as g, goodsimg as i')
						  ->where('g.id = i.gid  and hot = 1 and up = 1 and face = 1')
						  ->select();

			return $data;
		}




	}





