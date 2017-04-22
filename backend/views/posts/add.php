<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'title');
echo $form->field($model,'author');
echo $form->field($model,'cate_id')->dropDownList(\app\models\Posts::getCateOptions());
echo $form->field($model,'content')->textarea();
echo $form->field($model,'is_valid',['inline'=>true])->radioList(['0'=>'未发布','1'=>'发布']);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
?>