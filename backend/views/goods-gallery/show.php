<?php
/* @var $this yii\web\View */
?>
    <h1>商品相册</h1>

<?php foreach($goods as $good):?>
    <div>
        <img src="<?=$good->path?>" width="100px">
        <a href="del?id=<?=$good->id?>" class="btn btn-danger">删除</a>
        <hr>
    </div>
<?php endforeach;?>
<?=\yii\bootstrap\Html::a('添加相册',['goods-gallery/add?id='.$_GET['id']],['class'=>'btn btn-info']);?>
<?=\yii\bootstrap\Html::a('返回商品首页',['goods/index'],['class'=>'btn btn-success']);?>