<?php 

class Page5
{

	private $page5;
	private $c;
	private $d;
	/*	
	function __get($page5)
	{
		echo $this->page5;
	}
	*/
	public function showPage5()
	{
		


		$_GET['search']=empty($_GET['search'])?'':$_GET['search'];
		
		$html= "<li><a  class='mws-paging-button disabled' >".$this->d."条数据</a></li>";
        $html.="<li><a href='index.php?c=goods&a=evaluate&page5=' class='mws-paging-button disabled' >".$this->page5."/".$this->c."页</a></li>";
        $html.="<li><a href='index.php?c=goods&a=evaluate&page5=1&search=".$_GET['search']."' class='mws-paging-button'>First</a></li>";
        $html.="<li><a href='index.php?c=goods&a=evaluate&page5=".($this->page5-1)."&search=".$_GET['search']."' class='mws-paging-button'>Prev</a></li>";


        for ($i=1; $i <= ($this->c); $i++) { 
        	$html.="<li><a href='index.php?c=goods&a=evaluate&page5={$i}&search=".$_GET['search']."' class='mws-paging-button ".($this->page5==$i?'current':null)."'>{$i}</a></li>";
        }



        $html.="<li><a href='index.php?c=goods&a=evaluate&page5=".($this->page5+1)."&search=".$_GET['search']."' class='mws-paging-button'>Next</a></li>";
        $html.="<li><a href='index.php?c=goods&a=evaluate&page5=".($this->c)."&search=".$_GET['search']."' class='mws-paging-button'>Last</a></li>";

        return $html;
	}

	public function limit($count)
	{
		// var_dump($_GET);die;
		// $_GET['page5']=1;
		
		// 页数设置默认值
		$this->page5=empty($_GET['page5'])?1:$_GET['page5'];

		// var_dump($this->page5);
		// 显示行数计算
		$total=ceil($count/ROWS);

		$this->c=$total;
		$this->d=$count;
		$this->page5=max($this->page5,1);
		$this->page5=min($this->page5,$total);

		// var_dump($total);var_dump($count);
		$k=($this->page5-1)*ROWS;
		// var_dump($k);
		return $k.','.ROWS;
		// 返回limit下标
	}

	



}









