<?php

?>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>用户名</th>
        <th>邮箱</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->username?></td>
            <td><?=$model->email?></td>
            <td><?=date('Y-m-d',$model->created_at)?></td>
            <td>
                <?=\yii\bootstrap\Html::a('查看其权限',['admin/check','id'=>$model->id],['class'=>'btn btn-info'])?>
                <?=\yii\bootstrap\Html::a('修改其角色',['admin/edit','id'=>$model->id],['class'=>'btn btn-success'])?>
                <?=\yii\bootstrap\Html::a('删除',['admin/delete','id'=>$model->id],['class'=>'btn btn-danger'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
