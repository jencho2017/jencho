<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'content')->textarea();
echo $form->field($model,'article_category_id')->dropDownList(\app\models\Article::getCatrgoryOptions());
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'status',['inline'=>true])->radioList(['0'=>'未发布','1'=>'已发布']);
echo $form->field($model,'sort');
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
?>