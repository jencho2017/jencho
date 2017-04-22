<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo '修改管理员'.$admin->username.'的权限';
echo $form->field($roles,'name')->checkboxList(\backend\models\SignupForm::getRoles());
\yii\bootstrap\ActiveForm::end();
?>