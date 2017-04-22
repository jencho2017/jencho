<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'description');
echo $form->field($model,'permissions')->checkboxList(\backend\models\RoleForm::getPermissions());
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();