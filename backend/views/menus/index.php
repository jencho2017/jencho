<?php
?>
<table class="table table-hover table-bordered">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>路由</th>
        <th>描述</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->name?></td>
        <td><?=$model->url?></td>
        <td><?=$model->description?></td>
        <td>
            <?=\yii\bootstrap\Html::a('修改',['menus/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
            <?=\yii\bootstrap\Html::a('删除',['menus/delete','id'=>$model->id],['class'=>'btn btn-info'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
