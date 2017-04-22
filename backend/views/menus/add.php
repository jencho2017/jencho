<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'url');
echo $form->field($model,'description');
echo $form->field($model,'parent_id')->dropDownList(['0'=>'添加顶级菜单',\backend\models\Menus::getMenus()]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();
?>