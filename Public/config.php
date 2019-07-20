<?php

	// 配置文件


session_start();

// 设置时区
date_default_timezone_set('PRC');

//主帐号
const ACCOUNTSID= '8a216da86a58af8b016a900b55cd1cb3';

//主帐号Token
const ACCOUNTTOKEN= 'e4360fc2cfee49f6a5c1cb2c2fab73de';

//应用Id
const APPID='8a216da86a58af8b016a900b56181cb9';

//请求地址，格式如下，不需要写https://
const SERVERIP='app.cloopen.com';

//请求端口 
const SERVERPORT='8883';

//REST版本号
const SOFTVERSION='2013-12-26';


// css,js,images地址
const AL='/Admin/Static/';

const HL='/Home/Static/';

// 定义数据库参数为常量
const DSN = 'mysql:host=localhost;dbname=project;charset=utf8';
const USER = 'root';
const PWD = '123456';

require_once '../Public/function.php';

// 每页显示的条数(后台)
const ROWS=5;

// 每页显示的条数
const ROW=8;
