<?php

	// 配置文件

	// 编码
		header('content-type: text/html; charset=utf-8');

	// 时区
		date_default_timezone_set("PRC");

	// 错误级别
		// 开发中, 开启所有的错误
		// 上线中, 屏蔽所有的错误

	// session 开启
		session_start();


	// 每页显示的条数
		const ROWS = 3;

	// css, js, images 地址
		const AC = '/Admin/Static/css/';
		const AJ = '/Admin/Static/js/';
		const AI = '/Admin/Static/images/';


	// 数据库配置
		const DSN = 'mysql:host=localhost;dbname=s86;charset=utf8';
		const USER = 'root';
		const PWD = '';


	// 短信配置
		//主帐号
		const ACCOUNTSID = '';
		//主帐号Token
		const ACCOUNTTOKEN = '';
		//应用Id
		const APPID ='';
		//请求地址，格式如下，不需要写https://
		const SERVERIP ='app.cloopen.com';
		//请求端口 
		const SERVERPORT ='8883';
		//REST版本号
		const SOFTVERSION ='2013-12-26';


	require_once 'function.php';
