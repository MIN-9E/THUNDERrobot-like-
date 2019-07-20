<?php 

class Page3
{

	private $page3;
	private $c;
	private $d;
	/*	
	function __get($page3)
	{
		echo $this->page3;
	}
	*/
	public function showPage3()
	{
		


		$_GET['search']=empty($_GET['search'])?'':$_GET['search'];
		
		$html= "<li><a  class='mws-paging-button disabled' >".$this->d."条数据</a></li>";
        $html.="<li><a href='index.php?c=orders&page3=' class='mws-paging-button disabled' >".$this->page3."/".$this->c."页</a></li>";
        $html.="<li><a href='index.php?c=orders&page3=1&search=".$_GET['search']."' class='mws-paging-button'>First</a></li>";
        $html.="<li><a href='index.php?c=orders&page3=".($this->page3-1)."&search=".$_GET['search']."' class='mws-paging-button'>Prev</a></li>";


        for ($i=1; $i <= ($this->c); $i++) { 
        	$html.="<li><a href='index.php?c=orders&page3={$i}&search=".$_GET['search']."' class='mws-paging-button ".($this->page3==$i?'current':null)."'>{$i}</a></li>";
        }



        $html.="<li><a href='index.php?c=orders&page3=".($this->page3+1)."&search=".$_GET['search']."' class='mws-paging-button'>Next</a></li>";
        $html.="<li><a href='index.php?c=orders&page3=".($this->c)."&search=".$_GET['search']."' class='mws-paging-button'>Last</a></li>";

        return $html;
	}

	public function limit($count)
	{
		// var_dump($_GET);die;
		// $_GET['page3']=1;
		
		// 页数设置默认值
		$this->page3=empty($_GET['page3'])?1:$_GET['page3'];

		// var_dump($this->page3);
		// 显示行数计算
		$total=ceil($count/ROWS);

		$this->c=$total;
		$this->d=$count;
		$this->page3=max($this->page3,1);
		$this->page3=min($this->page3,$total);

		// var_dump($total);
		$k=($this->page3-1)*ROWS;
		// var_dump($k);
		return $k.','.ROWS;
		// 返回limit下标
	}

	



}









