<?php 


	class Page
	{
		protected $page;   # 当前页码
		protected $total;  # 总页数
		protected $count;  # 总条数

		// 显示页码
		public function showPage()
		{
			
			$link = null;
			for ($i=1; $i <= $this->total; $i++) { 
				$link .= "<a href='index.php?c=user&page={$i}' target='mainFrame'> {$i} </a>&nbsp;&nbsp;";
			}



			$html = "{$this->count} 条数据 {$this->page}/{$this->total} 页&nbsp;&nbsp;";
			$html .= "<a href='index.php?c=user&page=1' target='mainFrame'>首页</a>&nbsp;&nbsp;";
			$html .= "<a href='index.php?c=user&page=". ($this->page - 1) ."' target='mainFrame'>上一页</a>&nbsp;&nbsp;";

			$html .= $link;

			$html .= "<a href='index.php?c=user&page=". ($this->page + 1) ."' target='mainFrame'>下一页</a>&nbsp;&nbsp;";
			$html .= "<a href='index.php?c=user&page={$this->total}' target='mainFrame'>尾页</a>";

			return $html;
		}




		// 计算页码
		public function limit( $count )
		{
			// 接收页码
			$this->page = empty($_GET['page'])?1:$_GET['page'];

			// 计算 总页数
			$this->count = $count;
			$this->total = ceil($this->count / ROWS);


			// 限制页码
			$this->page = max($this->page, 1);
			$this->page = min($this->page, $this->total);


			// 计算limit 下标
			$k = ($this->page - 1) * ROWS;

			return $k.','.ROWS;

			
		}





	}



