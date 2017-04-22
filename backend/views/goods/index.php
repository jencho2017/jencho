<?php

?>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>商品名称</th>
        <th>货号</th>
        <th>商品LOGO</th>
        <th>商品分类</th>
        <th>商品品牌</th>
        <th>市场售价</th>
        <th>本店售价</th>
        <th>库存</th>
        <th>商品状态</th>
        <th>商品排序</th>
        <th>加入时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->name?></td>
            <td><?=$model->sn?></td>
            <td><?=\yii\bootstrap\Html::img('@web'.$model->logo,['style'=>'max-height:30px'])?></td>
            <td><?=$model->category->name?></td>
            <td><?=$model->brand_id?></td>
            <td><?=$model->market_price?></td>
            <td><?=$model->shop_price?></td>
            <td><?=$model->stock?></td>
            <td><?=\backend\models\Goods::$sale_options[$model->is_on_sale]?></td>
            <td><?=\backend\models\Goods::$status_options[$model->status]?></td>
            <td><?=$model->sort?></td>
            <td><?=date('Y-m-d',$model->inputtime)?></td>
            <td>
                <?=\yii\bootstrap\Html::a('查看相册',['goods-gallery/show','id'=>$model->id],['class'=>'btn btn-info'])?>
                <?=\yii\bootstrap\Html::a('修改',['goods/edit','id'=>$model->id],['class'=>'btn btn-success'])?>
                <?=\yii\bootstrap\Html::a('删除',['goods/delete','id'=>$model->id],['class'=>'btn btn-danger'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
