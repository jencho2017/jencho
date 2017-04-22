<?php


?>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>标题</th>
        <th>作者</th>
        <th>文章分类</th>
        <th>文章状态</th>
        <th>添加时间</th>
        <th>最近一次修改时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->title?></td>
        <td><?=$model->author?></td>
        <td><?=$model->category->name?></td>
        <td><?=$model->is_valid ? '发布' : '未发布'?></td>
        <td><?=date('Y-m-d H:i:s',$model->create_at)?></td>
        <td><?=$model->update_at ? date('Y-m-d H:i:s',$model->update_at) : '暂未修改'?></td>
        <td>
            <?=\yii\bootstrap\Html::a('修改',['posts/edit','id'=>$model->id],['class'=>'btn btn-success'])?>
            <?=\yii\bootstrap\Html::a('删除',['posts/delete','id'=>$model->id],['class'=>'btn btn-danger'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php
echo \yii\widgets\LinkPager::widget([
   'pagination'=>$pager,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
]);

?>
