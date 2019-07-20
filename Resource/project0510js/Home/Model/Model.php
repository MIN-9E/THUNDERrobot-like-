<?php 

	
	class Model
	{
		public function __construct()
		{
			$this->db = new DB;
		}

		public function getCate()
		{
			$data = $this->db
						  ->field('id, name')
						  ->table('category')
						  ->where('pid = 0 and display = 1')
						  ->select();

			return $data;
		}
	}
