<?php
?>
<p><?=$admin->username?>管理员具有以下权限</p><br>
<?php foreach($permissions as $permission):?>
    <?=$permission->description;?><br>
<?php endforeach;?><br>
<?=\yii\bootstrap\Html::a('返回管理员列表',['admin/index'],['class'=>'btn btn-info'])?>
