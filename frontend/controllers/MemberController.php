<?php

namespace frontend\controllers;

use frontend\models\LoginForm;
use frontend\models\Member;
use yii\helpers\Json;

use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;

class MemberController extends \yii\web\Controller
{
    public $layout = 'login';//指定布局文件
    public $enableCsrfValidation = false;
    /**用户注册
     * @return string
     */
    public function actionRegister()
    {
        $model = new Member();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->password_hash = \Yii::$app->security->generatePasswordHash($model->password);
                $model->auth_key = \Yii::$app->security->generateRandomString();
                $model->last_login_ip = ip2long($_SERVER['REMOTE_ADDR']);
                $model->last_login_time = time();
                $model->created_at = time();
                $model->updated_at = time();
                $res = $model->save();
                if($res){
                    \Yii::$app->user->login($model);
                    return $this->redirect(['goods/detail']);
                }
            }
        }
        return $this->render('register',['model'=>$model]);
    }

    /**
     * 短信验证
     */
    public function actionSms()
    {
        /*
         * App Key:23749185
         * App Secret: b5091d1519124436cdd67659f5c91592
         */

        //生成短信验证码  手机号码
        $tel = \Yii::$app->request->post('tel');
        //echo $tel;
        $code = rand(1000,9999);//随机生成短信验证码
        \Yii::$app->session->set('tel_'.$tel,$code);
        //发送短信验证码到手机
        $config = [
            'app_key'    => '23749185',
            'app_secret' => 'b5091d1519124436cdd67659f5c91592',
            // 'sandbox'    => true,  // 是否为沙箱环境，默认false
        ];
        $client = new Client(new App($config));
        $req    = new AlibabaAliqinFcSmsNumSend;

        $req->setRecNum($tel)//要发送给谁 电话号码
        ->setSmsParam([
            'name'=>'吕儿子',
            'num' => $code//设置参数，根短信模板上的参数名一致
        ])
            ->setSmsFreeSignName('JenCho沈')//签名，必须要设置 签名必须是已审核的
            ->setSmsTemplateCode('SMS_60675148');//短信模板ID

        $resp = $client->execute($req);

        return Json::encode([
            'err_code'=>0,
            'msg'=>'短信发送成功',
        ]);
    }

    /*
 * 测试发送短信
 */
    public function actionTest()
    {


// 配置信息
        $config = [
            'app_key'    => '23749185',
            'app_secret' => 'b5091d1519124436cdd67659f5c91592',
            // 'sandbox'    => true,  // 是否为沙箱环境，默认false
        ];


// 使用方法一
        $client = new Client(new App($config));
        $req    = new AlibabaAliqinFcSmsNumSend;

        $req->setRecNum('18282049819')//要发送给谁 电话号码
        ->setSmsParam([
            'name'=>'左帆大哈皮!!!!!',
            'num' => rand(100000, 999999)//设置参数，根短信模板上的参数名一致
        ])
            ->setSmsFreeSignName('JenCho沈')//签名，必须要设置 签名必须是已审核的
            ->setSmsTemplateCode('SMS_60675148');//短信模板ID

        $resp = $client->execute($req);
        var_dump($resp);
    }


    /**
     * 用户登录
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->login()){
                $member = Member::findOne(['username'=>$model->username]);
                $member->last_login_time=time();
                $member->last_login_ip=ip2long($_SERVER['REMOTE_ADDR']);
                $member->save(false);
                \Yii::$app->session->setFlash('success','登陆成功');
                return $this->redirect(['address/add']);
            }
        }
        return $this->render('login',['model'=>$model]);
    }

}
