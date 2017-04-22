<?php
/* @var $this yii\web\View */
$js = <<<EOT
    //点击切换图标
    $(".choice").click(function(){
        $(this).toggleClass("glyphicon glyphicon-arrow-up");
        $(this).toggleClass("glyphicon glyphicon-arrow-down");
        //点击隐藏或者显示tr
        var tr = $(this).closest("tr");
        //当前tr里的值
        var current_lft = tr.attr("data-lft");
        var current_rgt = tr.attr("data-rgt");
        var current_tree = tr.attr("data-tree");
        $("#target tr").each(function(){
            //每个tr里的值
            var lft = $(this).attr("data-lft");
            var rgt = $(this).attr("data-rgt");
            var tree = $(this).attr("data-tree");
            if(lft>current_lft && rgt<current_rgt && current_tree==tree){
                //显示或者隐藏
                $(this).toggle();
            }
        });
    });

EOT;
$this->registerJs($js);
?>
<div class="container">
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>分类名</th>
        <th>操作</th>
    </tr>
    <tbody id="target">
    <?php foreach($models as $model):?>
        <tr class="ttr" data-lft="<?=$model->lft?>" data-rgt="<?=$model->rgt?>" data-tree="<?=$model->tree?>">
            <td class="col-lg-2"><?=$model->id?></td>
            <td class="col-lg-2 change"><?=str_repeat('－－',$model->depth)?><?=$model->name?><span class="glyphicon glyphicon-arrow-up choice" style="float: right"></span></td>
            <td class="col-lg-2">
                <?=\yii\bootstrap\Html::a('修改',['goods-category/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
                <?=\yii\bootstrap\Html::a('删除',['goods-category/delete','id'=>$model->id],['class'=>'btn btn-danger'])?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
</div>
