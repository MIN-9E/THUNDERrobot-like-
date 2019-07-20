<?php 

class goodsModel
{
	protected $db;
	public $page;
	public $c;
	public $d;

	function __construct()
	{
		// echo 'goodsModel链接成功';
		$this->db=new DB;

	}

	function getType($li)
	{	
		// echo ' getType方法链接 ';
		$cateId=empty($_GET['id'])?null:$_GET['id'];
		// var_dump($_GET);
		
		// 根据id在category表中查询path中包含cateid的id
		$cateList=$this->db->field('id')
						->table('category')
						->where("path like '%,{$cateId},%'")
						->select();
		// var_dump($cateList);die;
		// 拼接id为字符串型数据
		$cateIdStr=null;
		foreach ($cateList as $k => $v) {
			$cateIdStr.=$v['id'].',';
		}
		$cateIdStr=$cateIdStr.$cateId;

		// 搜索cid中包含在id内的数据
		$data=$this->db->field()
				 ->table('goods as g, goodsimg as i')
				 ->where("g.id=i.gid and up=1 and face=1 and cid in ($cateIdStr)")
				 ->limit($li)
				 ->select();
		// var_dump($this->db->sql);die;
		// var_dump($data);die;
		return $data;
	}

	function getCou()
	{
		$cateId=empty($_GET['id'])?null:$_GET['id'];

		$data=$this->db
					->table('goods as g,category as c')
					->field('count(g.id) as count')
					->where('g.cid=c.id and c.pid='.$cateId)
					->select();
		// var_dump($this->db->sql);
					// var_dump($data);
		return $data[0]['count'];
	}

	function lim($count)
	{
		// var_dump($_GET);die;
		// $_GET['page']=1;
		
		// 页数设置默认值
		$this->page=empty($_GET['page'])?1:$_GET['page'];

		// 显示行数计算
		$total=ceil($count/ROW);
		// var_dump($total);
		$this->c=$total;
		$this->d=$count;
		$this->page=max($this->page,1);
		$this->page=min($this->page,$total);
		// var_dump($this->c);
		// var_dump($this->d);
		// var_dump($this->page);

		// var_dump($total);
		$k=($this->page-1)*ROW;
		// var_dump($k);
		return $k.','.ROW;
		// 返回limit下标
	}





	public function getGoodsInfo()
	{
		// 接收点击商品代表id
		$goodsId=$_GET['id'];

		$data=$this->db->field()
					->table('goods')
					->where('id='.$goodsId.' and up=1')
					->find();
		// var_dump($this->db->sql);
		// var_dump($data);die;
		return $data; 
	}

	public function getGoodsImg()
	{
		// 接收点击商品代表id
		$goodsId=$_GET['id'];

		$data=$this->db->field()
					->table('goodsimg')
					->where('gid='.$goodsId)
					->order('face asc')	#?为啥可以影响下一条方法
					->select();
		// var_dump($this->db->sql);
		// var_dump($data);die;
		return $data;

	}

	/*
	function changeStatus($x)
	{
		$id=$_GET['id'];
		// var_dump($_GET);die;
		$data=$this->getOne();
		// var_dump($data);die;
		$new[$x]=$data[$x]==1?2:1;
		// var_dump($new);die;
		$result=$this->db
					 ->table('goodsimg')
					 ->where('id='.$id)
					 ->update($new);
		// var_dump($this->db->sql);die;
		header("location:".$_SERVER['HTTP_REFERER']);die;
		return $result;
	}*/

	function getComment()
	{
		$goodsId=$_GET['id'];
		$data=$this->db->field('u.id,u.nickname,c.comment,u.icon,c.tip,c.time')
					->table('`user` as u,`comment` as c')
					->where('u.id=c.uid and isShow=1 and c.gid='.$goodsId)
					->select();
		// var_dump($this->db->sql);
		return $data;

	}

	function getCommentImg()
	{
		$goodsId=$_GET['id'];
		$data=$this->db->field('i.pic,u.id')
					->table('`user` as u,`commentimg` as i,`comment` as c')
					->where('u.id=i.uid and c.uid=u.id and c.gid='.$goodsId)
					->select();

		// var_dump($this->db->sql);
		// var_dump($data);die;
		return $data;
	}


	function getPath()
	{
		$goodsId=$_GET['id'];
		$data=$this->db->field('c.path,c.pid,g.name as nickname')
					->table('`category` as c,`goods` as g')
					->where('c.id=g.cid and g.id='.$goodsId)
					->find();
		$result=$this->db->field('name')
					->table('`category`')
					->where('id='.$data['pid'])
					->find();
		$data['name']=$result['name'];
		// var_dump($data);
		// var_dump($this->db->sql);die;
		return $data;
					
	}

}




