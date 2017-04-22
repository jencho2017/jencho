<?php
$this->params['breadcrumbs'][] = ['label'=>'添加文章 -- ','url'=>(['article/add'])];
$this->params['breadcrumbs'][] = ['label'=>'商品品牌页 -- ','url'=>(['brand/index'])];
$this->params['breadcrumbs'][] = '文章列表页';
?>
    <table class="table table-bordered table-hover">
        <tr>
            <th>ID</th>
            <th>标题</th>
            <th>简介</th>
            <th>文章分类</th>
            <th>文章状态</th>
            <th>添加时间</th>
            <th>最近一次修改时间</th>
            <th>操作</th>
        </tr>
        <?php foreach($models as $model):?>
            <tr>
                <td><?=$model->id?></td>
                <td><?=$model->name?></td>
                <td><?=$model->intro?></td>
                <td><?=$model->category->name?></td>
                <td><?=$model->status ? '发布' : '未发布'?></td>
                <td><?=date('Y-m-d H:i:s',$model->inputtime)?></td>
                <td><?=$model->update_time ? date('Y-m-d H:i:s',$model->update_time) : '暂未修改'?></td>
                <td>
                    <?=\yii\bootstrap\Html::a('修改',['article/edit','id'=>$model->id],['class'=>'btn btn-success'])?>
                    <?=\yii\bootstrap\Html::a('删除',['article/delete','id'=>$model->id],['class'=>'btn btn-danger'])?>
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
