<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/18
 * Time: 11:24
 */

namespace frontend\controllers;


use frontend\models\Member;
use yii\helpers\Json;
use yii\web\Controller;

class ApiController extends Controller
{
    public function actionLogin()
    {
        $result = [
            "success"=> false,
            "errorMsg"=> "用户名或密码错误",
            'result'=>'',
        ];
        $username = \Yii::$app->request->get('username');
        $pwd = \Yii::$app->request->get('pwd');
        $member = Member::findOne(['username'=>$username]);
        if($member){
            if(\Yii::$app->security->validatePassword($pwd,$member->password_hash));
            \Yii::$app->user->login($member);
            $result = [
               "success"=> true,
               "errorMsg"=> "",
               "result"=> [
               "id"=> "用户id",
               "userName"=> "用户名",
               "userIcon"=> "头像路径",
               "waitPayCount"=> 12,
               "waitReceiveCount"=> 12,
               "userLevel"=> 1,
               ] 
            ];
            return Json_encode($result);
        }
        return Json_encode($result);
    }

    public function actionWeather()
    {
        $all = [];
        $weather = simplexml_load_file('./weather.xml');
        foreach($weather as $city){
            $cityname = (string)$city['cityname'];
            if($cityname == '南充'){
                $tem1 = (string)$city['tem1'];
                $tem2 = (string)$city['tem2'];
                $windDir = (string)$city['windDir'];
                $all = [
                    'cityname'=>$cityname,
                    'tem1'=>$tem1,
                    'tem2'=>$tem2,
                    'windDir'=>$windDir,
                ];
            }

        }
        var_dump($all);
    }

    public function actionBanner()
    {
        //adKind=1  adKind=2
        $adKind = \Yii::$app->request->get('adKind');
//        echo 'actionBanner';
        $result = [
            "success"=>true,
            "errorMsg"=> "",
            "result"=>[
                [
                    "id"=>1,
                    "type"=> 1,
                    "adUrl"=> "/../images/ad.jpg",
                    "webUrl"=>"http://www.baidu.com",
                    "adKind"=> $adKind
                ]
            ]
        ];

        return Json::encode($result);

    }


    public function actionSeckill()
    {
        $result = [
            "success"=>true,
            "errorMsg"=> "",
            "result"=>[
                "total"=> 2,
                "rows"=> [
                    [
                        "allPrice"=>999,
                        "pointPrice"=>998,
                        "iconUrl"=> "/../images/ad.jpg",
                        "timeLeft"=> 99,
                        "type"=> 2,
                        "productId"=>1
                    ],
                    [
                        "allPrice"=>999,
                        "pointPrice"=>998,
                        "iconUrl"=> "/../images/ad.jpg",
                        "timeLeft"=> 99,
                        "type"=> 2,
                        "productId"=>7
                    ]
                ]
            ]
        ];

        return Json::encode($result);
    }

    public function actionGetYourFav()
    {
        $result = [
            "success"=>true,
            "errorMsg"=> "",
            "result"=>[
                "total"=> 1,
                "rows"=> [
                    [
                        "price"=>1998,
                        "name"=> "小米",
                        "iconUrl"=> "/../images/ad.jpg",
                        "productId"=>2
                    ]
                ]
            ]
        ];

        return Json::encode($result);
    }

    public function actionDom()
    {
        //实例化dom操作xml对象
        $dom = new \DOMDocument();
        //加载被操作的xml文件
        $dom->load('./weather.xml');
        //获取文档根节点
        $root = $dom->documentElement;
        //获取子节点
        $roots = $root->childNodes;
        //获取子节点个数
        $length = $roots->length;
        //遍历子节点
        for($i=0;$i<$length;$i++){
            $roos = $roots->item($i);
            //排除换行符
            if($roos->nodeType == XML_ELEMENT_NODE){
                $all = [];
                //获取roos上的属性
                $all['cityname'] = $roos->getAttribute('cityname');
                if($all['cityname'] == '成都'){
                    $all['tem1'] = $roos->getAttribute('tem1');
                    $all['tem2'] = $roos->getAttribute('tem1');
                    $all['windDir'] = $roos->getAttribute('windDir');
                    var_dump($all);
                }
            }
        }
    }
}