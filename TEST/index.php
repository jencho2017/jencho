<?php
//接收微信发送来的消息
$postStr = file_get_contents('php://input');
//将消息保存到文件中
file_put_contents('request.xml',$postStr);
//解析微信发来的xml数据
$xml = simplexml_load_string($postStr);
$FromUserName = (string)$xml->FromUserName;
$ToUserName = (string)$xml->ToUserName;
$Contents = (string)$xml->Content;
$weather = simplexml_load_file('./weather.xml');
$Content = '此平台提供以下服务:
查看当天四川天气预报;
查看美女排行榜;
请输入正确格式查看,例如:成都天气预报!';
//需求: 回复地名+天气预报 返回当地天气
//回复:美女排行榜返回美女排行榜图文消息
//检测回复消息中是否含有城市地名或者美女关键字
//如果有,提示 回复数字获取相关信息
//如果没有检测到关键字,返回提示信息
//start
//先检测用户消息中是否含有关键字
//打开ob_缓存
ob_start();
$tianqi = strpos($Contents,'天气预报');
$meinv = strpos($Contents,'美女');
//如果天气预报关键字存在
if($tianqi !== false){
    $box = [];
    foreach($weather as $city){
        //装城市名的变量
        //城市名
        $cityname = (string)$city['cityname'];
        $box[$cityname] = $cityname;
        //检测是否含有四川城市信息
        $chengshi = str_replace('天气预报','',$Contents);
        //如果城市名也存在
        if($chengshi == $cityname){
            $stateDetailed =  (string)$city['stateDetailed'];
            $Content = $cityname.'的天气如下 :'.$stateDetailed;
        }elseif($Contents == '天气预报'){
            //不存在提示只提供四川天气服务
            $Content = '若要查询天气,请这样回复:
            城市名+天气预报
            ';
        }
    }
    $name = str_replace('天气预报','',$Contents);
    if(!array_key_exists($name,$box)){
        $Content = '此平台只提供四川省内的城市天气预报信息';
    }
    //加载回复XML数据
    require('text.xml');
}elseif($meinv !== false){
    //判断是否排行榜也存在
        require('meinv.php');
        require('meinv.xml');

}else{
    require('text.xml');
}
//回复微信服务器
//获取ob缓存中数据

$ob_data = ob_get_contents();
//将缓存中数据存入response文件中
file_put_contents('response.xml',$ob_data);

