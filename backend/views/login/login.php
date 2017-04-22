<?php
$form = \yii\bootstrap\ActiveForm::begin(['id' => 'login-form']); ?>

<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<?= $form->field($model,'code')->widget(\yii\captcha\Captcha::className(),[
    'template'=>'<div class="row"><div class="col-lg-2">{images}</div><div class="col-lg-2">{input}</div></div>'
])?>

<?= $form->field($model, 'rememberMe')->checkbox() ?>

<div class="form-group">
    <?= \yii\bootstrap\Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
</div>

<?php \yii\bootstrap\ActiveForm::end(); ?>
