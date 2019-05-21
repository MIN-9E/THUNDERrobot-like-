<?php

	// 专门用于验证
	
	class Checking
	{
		public function tel($tel)
		{
			$preg = '/^1(3\d|4[5-9]|5[0-35-9]|66|7[03-8]|8\d|9[89])\d{8}$/';

			$result = preg_match($preg, $tel);

			if ($result) {
				return true;
			}
			return false;
			
		} 


		public function pwd($pwd)
		{
			$preg1='/^.{6,18}$/';
			$result1=preg_match($preg1,$pwd);
			$preg2='/ /';
			$result2=preg_match($preg2,$pwd);
			// var_dump($result1,$result2);die;
			if ($result1) {
				if ($result2<1) {
						return true;
					}	
			}
			return false;
		}


		public function email($email)
		{
			$preg='/^[0-9a-zA-Z-_!]{2,18}@[\da-zA-z]{1,10}\.(com|cn|net|org|edu|com\.cn|tv)$/';
			$result=preg_match($preg,$email);
			// var_dump($result);die;
			if ($result) {
				return true;
			}
			return false;
		}


		public function entities($arr)
		{
			foreach ($arr as $k => $v) {
				$newarr[$k]=htmlentities($v);
			}
			return $newarr;
		}

		public function striptags($arr)
		{
			foreach ($arr as $k => $v) {
				$newarr[$k]=strip_tags($v);
			}
			return $newarr;
		}



	}



