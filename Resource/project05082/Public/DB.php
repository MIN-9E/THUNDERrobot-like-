<?php 
	
	# 只是为了 方便操作数据库
	class DB
	{
		# pdo对象
		private $pdo;

		# 表名
		private $table;

		# 字段名
		private $field;

		# where条件
		private $where;

		# group by 字段
		private $group;

		# having 筛选
		private $having;

		# order by 条件
		private $order;

		# limit 分页
		private $limit;

		# 存储最近一条 sql 语句
		public $sql;


		public function __construct()
		{
			// 链接数据库
			$this->pdo = new PDO(DSN, USER, PWD);
		}


		// 多查询
		public function select()
		{
			// 准备sql
  			$this->sql = "
  					select 	{$this->field} 
  					from 	{$this->table}  
  							{$this->where} 
  							{$this->group} 
  							{$this->having} 
  							{$this->order}  
  							{$this->limit}   
					";
  			// echo $this->sql;die;

  			// 执行sql
 			$ps = $this->pdo->query($this->sql);

 			if( is_object($ps) ){
				// 分析结果集
	 			$data = $ps->fetchAll(PDO::FETCH_ASSOC);
	 			return $data;
 			}else{
 				return false;
 			}
		}

		// 单查询
		public function find()
		{
			// 准备sql
  			$this->sql = "
  					select 	{$this->field} 
  					from 	{$this->table}  
  							{$this->where} 
					";

  			// 执行sql
 			$ps = $this->pdo->query($this->sql);

 			if( is_object($ps) ){
				// 分析结果集
	 			$data = $ps->fetch(PDO::FETCH_ASSOC);
	 			return $data;
 			}else{
 				return false;
 			}
		}

		// 删除
		public function delete()
		{
 			$this->sql = "delete from {$this->table} {$this->where} {$this->order} {$this->limit}";

 			// 执行sql
			$rows = $this->pdo->exec($this->sql);

			return $rows;
		}


		// 插入
		public function insert($data=null)
		{
			
			// 凑 sql 格式
			$field = null;
			$value = null;
			foreach($data as $k => $v){
				$field .= "`{$k}`,";
				$value .= "'{$v}',";
			}

			$field = rtrim($field, ',');
			$value = rtrim($value, ',');

			// 准备sql 
			$this->sql = "INSERT INTO {$this->table}( {$field} )  VALUES( {$value} )";

			// 执行sql
			$rows = $this->pdo->exec($this->sql);

			# 由于 $rows 和 $newID 在判断是否新增成功的角度而言, 效果一样
			if ($rows) {
				return $this->pdo->lastInsertId();
			}

			return false;
		}


		// 编辑
		public function update($data=null)
		{

			// 凑sql格式
			$str = null;
			foreach($data as $k => $v){
				$str .=  "`{$k}`='{$v}',";
			}

			$str = rtrim($str, ',');

			// 准备SQL
			$this->sql = "UPDATE {$this->table} SET {$str} {$this->where} ";

			// 执行SQL
			$rows = $this->pdo->exec($this->sql);

			return $rows;
		}




















































		# 设置 字段名
		public function field($condition=null)
		{
			if( empty($condition) ){
				$condition = '*';
				$this->field = $condition;
			}else{
				$this->field = $condition;
			}

			return $this;
		}


		# 设置 表名
		public function table($condition=null)
		{
			if( empty($condition) ){
				return false;
			}else{
				$this->table = $condition;
			}
			return $this;
		}


		# 设置 where条件
		public function where($condition=null)
		{
			if( empty($condition) ){
				$this->where = null;
			}else{
				$this->where = '  where '. $condition;
			}
			return $this;
		}


		# 设置 group by条件
		public function group($condition=null)
		{
			if( empty($condition) ){
				$this->group = null;
			}else{
				$this->group = '  group by '. $condition;
			}
			return $this;
		}



		# 设置 having条件
		public function having($condition=null)
		{
			if( empty($condition) ){
				$this->having = null;
			}else{
				$this->having = '  having '. $condition;
			}
			return $this;
		}



		# 设置 order by 条件
		public function order($condition=null)
		{
			if( empty($condition) ){
				$this->order = null;
			}else{
				$this->order = '  order by '. $condition;
			}
			return $this;
		}


		# 设置 limit 条件
		public function limit($condition=null)
		{
			if( empty($condition) ){
				$this->limit = null;
			}else{
				$this->limit = '  limit '. $condition;
			}
			return $this;
		}


	}



