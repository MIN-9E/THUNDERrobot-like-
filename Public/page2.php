<?php 

class Page2
{

	private $page2;
	private $c;
	private $d;
	/*	
	function __get($page2)
	{
		echo $this->page2;
	}
	*/
	public function showPage2()
	{
		


		$_GET['search']=empty($_GET['search'])?'':$_GET['search'];
		
		$html= "<li><a  class='mws-paging-button disabled' >".$this->d."条数据</a></li>";
        $html.="<li><a href='index.php?c=goods&page2=' class='mws-paging-button disabled' >".$this->page2."/".$this->c."页</a></li>";
        $html.="<li><a href='index.php?c=goods&page2=1&search=".$_GET['search']."' class='mws-paging-button'>First</a></li>";
        $html.="<li><a href='index.php?c=goods&page2=".($this->page2-1)."&search=".$_GET['search']."' class='mws-paging-button'>Prev</a></li>";


        for ($i=1; $i <= ($this->c); $i++) { 
        	$html.="<li><a href='index.php?c=goods&page2={$i}&search=".$_GET['search']."' class='mws-paging-button ".($this->page2==$i?'current':null)."'>{$i}</a></li>";
        }



        $html.="<li><a href='index.php?c=goods&page2=".($this->page2+1)."&search=".$_GET['search']."' class='mws-paging-button'>Next</a></li>";
        $html.="<li><a href='index.php?c=goods&page2=".($this->c)."&search=".$_GET['search']."' class='mws-paging-button'>Last</a></li>";

        return $html;
	}

	public function limit($count)
	{
		// var_dump($_GET);die;
		// $_GET['page2']=1;
		
		// 页数设置默认值
		$this->page2=empty($_GET['page2'])?1:$_GET['page2'];

		// 显示行数计算
		$total=ceil($count/ROWS);

		$this->c=$total;
		$this->d=$count;
		$this->page2=max($this->page2,1);
		$this->page2=min($this->page2,$total);

		// var_dump($total);
		$k=($this->page2-1)*ROWS;
		// var_dump($k);
		return $k.','.ROWS;
		// 返回limit下标
	}



}









