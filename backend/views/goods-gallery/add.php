<?php
/**
 * @var $this \yii\web\view
 */
use yii\web\JsExpression;

$form=\yii\bootstrap\ActiveForm::begin();

//Remove Events Auto Convert
//外部TAG
echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);

echo $form->field($model,'getImgs')->hiddenInput();


echo \xj\uploadify\Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
//        console.log(data.fileUrl);
        //添加的图片显示出来
        var imgHtml='<div><img src="'+data.fileUrl+'" class="img" style="width=100"/><span style="float:right"><a class="btn btn-danger img-btn">删除</a></span><hr/></div>';
        $(imgHtml).appendTo('#add');
        $('.img-btn').on('click',function(){
            $(this).closest('div').remove();
        });
        
    }
    
}
EOF
        ),
    ]
]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info','id'=>'sMB']);
\yii\bootstrap\ActiveForm::end();

$js=<<<EOF
    $('#sMB').on('click',function(){
        var getImgs=[];
        $('.img').each(function(i){
            getImgs[i]=$(this).attr('src');
        });
        $('#goodsgallery-getimgs').val(getImgs);

    })

EOF;
$this->registerJs($js);
?>
<div id="add"></div>