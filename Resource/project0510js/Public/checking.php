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


		public function pwd()
		{
			
		}


		public function email()
		{
			
		}


	}



