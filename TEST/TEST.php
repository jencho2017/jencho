<?php
// 1 获取微信post过来的xml数据
//$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
$postStr = file_get_contents('php://input');

//将xml数据保存到文件，方便调试
file_put_contents('post.xml',$postStr);

//2 使用simplexml解析xml数据
$xml = simplexml_load_string($postStr);
$FromUserName = (string)$xml->FromUserName;
$ToUserName = (string)$xml->ToUserName;
$Content = (string)$xml->Content;

//3 回复消息
ob_start();//打开ob缓存
require 'text.xml';
$ob_str = ob_get_contents();//获取ob缓冲区内容
file_put_contents('respose.xml',$ob_str);