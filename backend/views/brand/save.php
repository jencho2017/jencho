<?php
echo \yii\bootstrap\Html::a('返回品牌列表页',['brand/index'],['class'=>'btn btn-danger']);
?>
<h1>商品品牌回收站!</h1>
<table class="table table-hover table-bordered">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>LOGO</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->name?></td>
        <td><?=\yii\bootstrap\Html::img('@web'.$model->logo,['style'=>'max-height:30px'])?></td>
        <td><?=\backend\models\Brand::$status_options[$model->status]?></td>
        <td>
            <?=\yii\bootstrap\Html::a('修改',['brand/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
            <?=\yii\bootstrap\Html::a('彻底删除',['brand/delete','id'=>$model->id],['class'=>'btn btn-danger'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页'
])
?>
