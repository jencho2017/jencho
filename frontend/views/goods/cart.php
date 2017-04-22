<!-- 主体部分 start -->
<div class="mycart w990 mt10 bc">
    <h2><span>我的购物车</span></h2>
    <table>
        <thead>
        <tr>
            <th class="col1">商品名称</th>
            <th class="col3">单价</th>
            <th class="col4">数量</th>
            <th class="col5">小计</th>
            <th class="col6">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($models as $model):?>
            <tr>
                <td class="col1"><a href=""><img src="<?=Yii::$app->params['backend_logo'].$model['logo']?>" alt="" /></a>  <strong><a href=""><?=$model['name']?></a></strong></td>
                <td class="col3">￥<span><?=$model['shop_price']?></span></td>
                <td class="col4">
                    <a href="javascript:;" class="reduce_num"></a>
                    <input type="text" name="amount" value="<?=$model['num']?>" class="amount"/>
                    <a href="javascript:;" class="add_num"></a>
                </td>
                <td class="col5">￥<span><?=$model['shop_price'] * $model['num']?></span></td>
                <td class="col6"><a href="">删除</a></td>
            </tr>
        <?php endforeach;?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="6">购物金额总计： <strong>￥ <span id="total"></span></strong></td>
        </tr>
        </tfoot>
    </table>
    <div class="cart_btn w990 bc mt10">
        <a href="" class="continue">继续购物</a>
        <a href="<?=\yii\helpers\Url::to(['goods/order'])?>" class="checkout">结 算</a>
    </div>
</div>
<!-- 主体部分 end -->
<?php
$this->registerJs('totalMoney();');
