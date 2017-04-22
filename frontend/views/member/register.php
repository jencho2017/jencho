<!-- 登录主体部分start -->
<div class="login w990 bc mt10 regist">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <?php
            $form = \yii\widgets\ActiveForm::begin();
            echo '<ul>';
            echo $form->field($model,'username',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
                    'template'=>"{label}\n{input}\n{hint}\n{error}",//输出模板
                ]
            )->textInput(['class'=>'txt','placeholder'=>'3-20位字符，可由中文、字母、数字和下划线组成']);
            echo $form->field($model,'password',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
                    'template'=>"{label}\n{input}\n{hint}\n{error}",//输出模板
                ]
            )->passwordInput(['class'=>'txt','placeholder'=>'6-20位字符，字母、数字和符号的组合']);
            echo $form->field($model,'repassword',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
                    'template'=>"{label}\n{input}\n{hint}\n{error}",//输出模板
                ]
            )->passwordInput(['class'=>'txt','placeholder'=>'请再次输入密码']);
            echo $form->field($model,'email',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
                    'template'=>"{label}\n{input}\n{hint}\n{error}",//输出模板
                ]
            )->textInput(['class'=>'txt','placeholder'=>'请正确填写您的邮箱']);

            $button =  '<input type="button" onclick="bindPhoneNum(this)" id="get_captcha" value="获取验证码" style="height: 25px;padding:3px 8px;margin-left: 4px">';

            echo $form->field($model,'tel',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
                    'template'=>"{label}\n{input}\n{hint}\n{error}",//输出模板
                ]
            )->textInput(['class'=>'txt','placeholder'=>'请输入您的手机号']);

            echo $form->field($model,'telcode',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
                    'template'=>"{label}\n{input}$button\n{hint}\n{error}",//输出模板
                ]
            )->textInput(['class'=>'txt','placeholder'=>'请输入短信验证码']);
            //echo $form->field($model,'password')->passwordInput(['class'=>'txt']);
//            echo $form->field($model,'code',
//                [
//                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
//                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
//                    'template'=>"{label}\n{input}\n{hint}\n{error}",//输出模板
//                ]
//            )->textInput(['class'=>'txt','placeholder'=>'请输入验证码']);

            echo $form->field($model,'code',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
                    'template'=>"{label}\n{input}\n{hint}\n{error}",//输出模板
                ]
            )->widget(\yii\captcha\Captcha::className(),[
                'template'=>'<span>{input}</span><span class="col-lg-1">{image}</span>','class'=>'txt'
            ]);

            echo '<label for="">&nbsp;</label>
				<input type="checkbox" class="chb" checked="checked" /> 我已阅读并同意《用户注册协议》';
            echo '<li><label for="">&nbsp;</label>'.\yii\helpers\Html::submitButton('',['class'=>'login_btn']).'</li>';
            echo '</ul>';
            \yii\widgets\ActiveForm::end();

            ?>

        </div>

        <div class="mobile fl">
            <h3>手机快速注册</h3>
            <p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
            <p><strong>1069099988</strong></p>
        </div>

    </div>
</div>
<!-- 登录主体部分end -->
<?php
/**
 *  @var $this \yii\web\View
 */
$url = \yii\helpers\Url::to(['member/sms']);
$token = Yii::$app->request->csrfToken;
$this->registerJs(new \yii\web\JsExpression(
    <<<EOT
$("#get_captcha").click(function(){
        //发起AJAX（post）请求到 member/sms
        var tel = $("#member-tel").val();//获取电话号码
        console.log(tel);
        $.post("{$url}",{"tel":tel,"_csrf-frontend":"{$token}"},function(data){
            console.log(data);
        });

        //启用输入框
        $('#captcha').prop('disabled',false);
        var time=30;
        var interval = setInterval(function(){
            time--;
            if(time<=0){
                clearInterval(interval);
                var html = '获取验证码';
                $('#get_captcha').prop('disabled',false);
            } else{
                var html = time + ' 秒后再次获取';
                $('#get_captcha').prop('disabled',true);
            }
            $('#get_captcha').val(html);
        },1000);
});
EOT
));