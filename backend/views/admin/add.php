<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username');
echo $form->field($model,'password');
echo $form->field($model,'email');
echo $form->field($model,'token')->checkbox([0,1]);
echo \yii\bootstrap\Html::submitButton('注册',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();

?>