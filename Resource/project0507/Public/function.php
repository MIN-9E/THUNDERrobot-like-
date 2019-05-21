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



 ?>