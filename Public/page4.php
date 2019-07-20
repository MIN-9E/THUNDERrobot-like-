<?php 

class Page4
{

	private $page4;
	private $c;
	private $d;
	/*	
	function __get($page4)
	{
		echo $this->page4;
	}
	*/
	public function showPage4()
	{
		


		$_GET['search']=empty($_GET['search'])?'':$_GET['search'];
		
		$html= "<li><a  class='mws-paging-button disabled' >".$this->d."条数据</a></li>";
        $html.="<li><a href='index.php?c=orders&a=process&page4=' class='mws-paging-button disabled' >".$this->page4."/".$this->c."页</a></li>";
        $html.="<li><a href='index.php?c=orders&a=process&page4=1&search=".$_GET['search']."' class='mws-paging-button'>First</a></li>";
        $html.="<li><a href='index.php?c=orders&a=process&page4=".($this->page4-1)."&search=".$_GET['search']."' class='mws-paging-button'>Prev</a></li>";


        for ($i=1; $i <= ($this->c); $i++) { 
        	$html.="<li><a href='index.php?c=orders&a=process&page4={$i}&search=".$_GET['search']."' class='mws-paging-button ".($this->page4==$i?'current':null)."'>{$i}</a></li>";
        }



        $html.="<li><a href='index.php?c=orders&a=process&page4=".($this->page4+1)."&search=".$_GET['search']."' class='mws-paging-button'>Next</a></li>";
        $html.="<li><a href='index.php?c=orders&a=process&page4=".($this->c)."&search=".$_GET['search']."' class='mws-paging-button'>Last</a></li>";

        return $html;
	}

	public function limit4($count)
	{
		// var_dump($_GET);die;
		// $_GET['page4']=1;
		
		// 页数设置默认值
		$this->page4=empty($_GET['page4'])?1:$_GET['page4'];

		// var_dump($this->page4);
		// 显示行数计算
		$total=ceil($count/ROWS);

		$this->c=$total;
		$this->d=$count;
		$this->page4=max($this->page4,1);
		$this->page4=min($this->page4,$total);

		// var_dump($total);var_dump($count);
		$k=($this->page4-1)*ROWS;
		// var_dump($k);
		return $k.','.ROWS;
		// 返回limit4下标
	}

	



}









