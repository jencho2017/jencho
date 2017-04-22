<?php

?>
<table class="table table-hover table-bordered">
    <tr>
        <th>权限名</th>
        <th>权限描述</th>
        <th>操作</th>
    </tr>
    <?php foreach($permissions as $permission):?>
    <tr>
        <td><?=$permission->name?></td>
        <td><?=$permission->description?></td>
        <td>
            <?=\yii\bootstrap\Html::a('删除',['permissions/delete','name'=>$permission->name],['class'=>'btn btn-danger'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
