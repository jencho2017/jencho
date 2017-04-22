<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'description');
echo \yii\bootstrap\Html::submitButton('添加',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
