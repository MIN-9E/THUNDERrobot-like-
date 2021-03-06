<?php 
	// 公共函数库

	/**
	 * notice 提示信息
	 * @param  string  $info 提示信息
	 * @param  string  $url  提示之后的跳转地址
	 * @param  integer $time 几秒后进行跳转
	 */
	function notice($info, $url=null, $time=3)
	{

		// 显示信息
		echo $info;

		// 检测 $url 是否为空,  为空则默认为上一级地址
		if ( is_null($url) ) {
			$url = $_SERVER['HTTP_REFERER'];
		}


		// 跳转
		echo "<meta http-equiv='refresh' content='{$time}; url={$url}'>";
		die;
	}



	/**
	  * 发送模板短信
	  * @param to 手机号码集合,用英文逗号分开
	  * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
	  * @param $tempId 模板Id, 默认用 id = 1
	  */       
	function sendSMS($to,$datas,$tempId)
	{
	     // 初始化REST SDK
	     $rest = new REST(SERVERIP,SERVERPORT,SOFTVERSION);
	     $rest->setAccount(ACCOUNTSID, ACCOUNTTOKEN);
	     $rest->setAppId(APPID);
	    
	     // 发送模板短信
	     $result = $rest->sendTemplateSMS($to,$datas,$tempId);
	     if($result == NULL ) {
	         return false;
	     }
	     if($result->statusCode!=0) {
	        //TODO 添加错误处理逻辑
	     	return false;
	     }else{
	         //TODO 添加成功处理逻辑
	         return true;
	     }
	}


	/**
	 * upload 单文件上传
	 * @param  string $saveDir   存储目录
	 * @param  array  $allowType 允许类型
	 * @return string 错误信息            
	 * @return array  新的文件名            
	 */
	function upload($saveDir='../Uploads/',$allowType=['image'])
	{
		// 1. 检测错误号
			// 检测 超过8M
			$key = key($_FILES);
			if( is_null($key) ){
				return '您的太大, 请换个小点的';
			}

			# 获取当前的错误号
			$error = $_FILES[$key]['error'];
			if($error != 0){

				switch($error){
					case 1: return '您的太大, 请换个小点的'; break;
					case 2: return '您的太大, 请换个小点的'; break;
					case 3: return '网络中断'; break;
					case 4: return '未上传文件'; break;
					case 6: return '服务器繁忙'; break;
					case 7: return '服务器繁忙'; break;
				}

			}

		// 2. 检测是否是从post协议上传过来的
			// is_uploaded_file( 临时文件地址 )
			// 返回值: bool
			$tmp = $_FILES[$key]['tmp_name'];
			if( !is_uploaded_file($tmp) ){
				return '非法上传';
			}

		// 3. 检测文件类型
			// 当做 头像上传, 那么限制在image类型中
			# 获取当前文件的类型
			$type = strtok( $_FILES[$key]['type'], '/');

			# 准备允许的类型
			// $allowType = ['image'];

			if ( !in_array($type, $allowType) ) {
				return '您的类型不符合要求';
			}

		// 4. 设计新的文件名(唯一)
			// 新的文件名格式:  20190423xxxxxxxxxxxx.jpg
			
			# 4.1 获取扩展名
			$suffix = strrchr($_FILES[$key]['name'] , '.');

			# 4.2 新的唯一文件名 
			# 	uniqid() 	基于1微秒而产生的唯一id.   适合低频率
			$filename = date('Ymd').uniqid().$suffix;

		// 5. 设置存储目录
			// 存储目录:  uploads/年/月/日
			$dir = $saveDir.date('/Y/m/d/');

			if( !file_exists($dir) ){
				mkdir($dir, 0777, true);
			}

		// 6. 移动临时文件 -> 存储目录
			// move_uploaded_file( 临时文件, 目标文件)
			//  
			// 目标文件:  存储目录 + 新的文件名

			if ( move_uploaded_file($tmp, $dir.$filename)  ) {
				return [$filename];

			}else{
				return '上传失败';
			}
	}

	function is_file_empty()
	{
		$key = key($_FILES);
		if ( $_FILES[$key]['error'] == 4) {
			return true; # 没上传文件
		}

		return false;  # 已上传文件
	}



	/**
	 * 根据 图片名 => 图片地址
	 * @param  string $filename 	图片名
	 * @return string $url  	 	图片地址
	 */
	function imgUrl($filename)
	{
		// 201905085cd2744f63283.jpg
		// 
		// /Uploads/2019/05/08/201905085cd2744f63283.jpg

		$url = '/Uploads/';
		$url .= substr($filename, 0, 4).'/';
		$url .= substr($filename, 4, 2).'/';
		$url .= substr($filename, 6, 2).'/';
		$url .= $filename;
		return $url;
	}



 ?>