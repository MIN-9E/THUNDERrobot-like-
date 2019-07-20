<?php 

class Page
{

	private $page;
	private $c;
	private $d;
	/*	
	function __get($page)
	{
		echo $this->page;
	}
	*/
	public function showPage()
	{
		


		$_GET['search']=empty($_GET['search'])?'':$_GET['search'];
		
		$html= "<li><a  class='mws-paging-button disabled' >".$this->d."条数据</a></li>";
        $html.="<li><a href='index.php?c=user&page=' class='mws-paging-button disabled' >".$this->page."/".$this->c."页</a></li>";
        $html.="<li><a href='index.php?c=user&page=1&search=".$_GET['search']."' class='mws-paging-button'>First</a></li>";
        $html.="<li><a href='index.php?c=user&page=".($this->page-1)."&search=".$_GET['search']."' class='mws-paging-button'>Prev</a></li>";


        for ($i=1; $i <= ($this->c); $i++) { 
        	$html.="<li><a href='index.php?c=user&page={$i}&search=".$_GET['search']."' class='mws-paging-button ".($this->page==$i?'current':null)."'>{$i}</a></li>";
        }



        $html.="<li><a href='index.php?c=user&page=".($this->page+1)."&search=".$_GET['search']."' class='mws-paging-button'>Next</a></li>";
        $html.="<li><a href='index.php?c=user&page=".($this->c)."&search=".$_GET['search']."' class='mws-paging-button'>Last</a></li>";

        return $html;
	}

	public function limit($count)
	{
		// var_dump($_GET);die;
		// $_GET['page']=1;
		
		// 页数设置默认值
		$this->page=empty($_GET['page'])?1:$_GET['page'];

		// 显示行数计算
		$total=ceil($count/ROWS);

		$this->c=$total;
		$this->d=$count;
		$this->page=max($this->page,1);
		$this->page=min($this->page,$total);

		// var_dump($total);
		$k=($this->page-1)*ROWS;
		// var_dump($k);
		return $k.','.ROWS;
		// 返回limit下标
	}



}









