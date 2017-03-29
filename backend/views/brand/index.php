<?php
echo \yii\bootstrap\Html::a('添加品牌',['brand/add'],['class'=>'btn btn-info']);
echo \yii\bootstrap\Html::a('回收站',['brand/save_delete_index'],['class'=>'btn btn-danger']);
?>
<h1>商品品牌表</h1>
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
            <?=\yii\bootstrap\Html::a('删除',['brand/save_delete','id'=>$model->id],['class'=>'btn btn-danger'])?>
            <?=\yii\bootstrap\Html::a('删除','',['class'=>'btn btn-success','id'=>'delete'])?>
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
<script type="text/javascript">

</script>
