<?php
use yii\web\JsExpression;
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'logo')->hiddenInput();
echo \yii\bootstrap\Html::img($model->logo,['id'=>'img','width'=>300]);


//外部TAG
echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);
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
        //console.log(data.fileUrl);
        $("#goods-logo").val(data.fileUrl);
        $("#img").attr("src",data.fileUrl);
    }
}
EOF
        ),
    ]
]);

echo $form->field($model,'content')->widget('common\widgets\ueditor\Ueditor',[
    'options'=>[
        'initialFrameWidth' => 850,
        'initialFrameHeight' => 200,
    ]
]);

//echo $form->field($model,'goods_category_id');

echo $form->field($model,'goods_category_id')->hiddenInput();
echo '<div>
    <ul id="treeDemo" class="ztree"></ul>
</div>';
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',
    ['depends'=>\yii\web\JqueryAsset::className()]);
$js = <<<EOT
var zTreeObj;
    // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
    var setting = {
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "parent_id",
                rootPId: 0
            }
        },
        callback: {
		onClick: function(event,treeId,treeNode){
		        console.log(treeNode.id);
		        $("#goods-goods_category_id").val(treeNode.id);
		    }
	    }
    };
    // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
    var zNodes = {$models};
        zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        zTreeObj.expandAll(true);
        zTreeObj.selectNode(zTreeObj.getNodeByParam("id", "{$model->goods_category_id}", null));//选中节点
EOT;

$this->registerJs($js);



echo $form->field($model,'brand_id')->dropDownList(\backend\models\Goods::getBrandOptions());
echo $form->field($model,'market_price');
echo $form->field($model,'shop_price');
echo $form->field($model,'stock');
echo $form->field($model,'is_on_sale',['inline'=>true])->radioList(['0'=>'下架','1'=>'上架']);
echo $form->field($model,'status',['inline'=>true])->checkboxList(['1'=>'新品','2'=>'热销','4'=>'促销','8'=>'精品']);
echo $form->field($model,'sort');
echo \yii\bootstrap\Html::submitButton('确认添加',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
?>
<link rel="stylesheet" href="/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">
