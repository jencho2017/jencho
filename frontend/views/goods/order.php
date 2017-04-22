<?php
/**
 * @var $this \yii\web\View;
 */
?>
<!-- 主体部分 start -->
<div class="fillin w990 bc mt15">
    <form action="<?=\yii\helpers\Url::to(['goods/order'])?>" method="post">
    <div class="fillin_hd">
        <h2>填写并核对订单信息</h2>
    </div>

    <div class="fillin_bd">
        <!-- 收货人信息  start-->
        <div class="address">
            <h3>收货人信息 </h3>

            <div class="address_select ">
                <ul>
                    <?php foreach($addresss as $address):?>
                    <li>
                        <input type="radio" name="address_id" value="<?=$address->id?>"  /><?=$address->username.'  '.$address->province.'  '.$address->city.'  '.$address->area.'  '.$address->detail.'  '.$address->tel?>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <!-- 收货人信息  end-->
        <?php $all = 0;?>
        <!-- 配送方式 start -->
        <div class="delivery">
            <h3>送货方式 </h3>
            <div class="delivery_select ">
                <table>
                    <thead>
                    <tr>
                        <th class="col1">送货方式1</th>
                        <th class="col2">运费</th>
                        <th class="col3">运费标准</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $n = 1;?>
                    <?php foreach($sends as $send):?>
                    <tr>
                        <td><input type="radio" name="send_id" value="<?=$n?>" /><?=$send[0]?></td>
                        <td><?=$send[1]?></td>
                        <td><?=$send[2]?></td>
                    </tr>
                        <?php $n++?>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- 配送方式 end -->

        <!-- 支付方式  start-->
        <div class="pay">
            <h3>支付方式 </h3>
            <div class="pay_select ">
            <?php $a = 1;?>
                <table>
                <?php foreach($pays as $pay):?>
                    <tr>
                        <td class="col1"><input type="radio" name="pay_id" value="<?=$a?>" /><?=$pay[0]?></td>
                        <td class="col2"><?=$pay[1]?></td>
                    </tr>
                    <?php $a++?>
                <?php endforeach;?>
                </table>
            </div>
        </div>
        <!-- 支付方式  end-->


        <!-- 商品清单 start -->
        <div class="goods">
            <h3>商品清单</h3>
            <table>
                <thead>
                <tr>
                    <th class="col1">商品</th>
                    <th class="col3">价格</th>
                    <th class="col4">数量</th>
                    <th class="col5">小计</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($goodss as $goods):?>
                <tr>
                    <td class="col1"><a href=""><img src="<?=Yii::$app->params['goodsPicUrl'].$goods->logo?>" alt="" /></a> <strong><a href="">九牧王王正品新款时尚休闲中长款茄克EK01357200</a></strong></td>
                    <td class="col3"><?=$goods->shop_price?></td>
                    <td class="col4"><?=$goods->count?></td>
                    <td class="col5"><span><?=$goods->shop_price * 2?></span></td>
                </tr>
                <?php endforeach;?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <ul>
                            <li>
                                <span>4 件商品，总商品金额：</span>
                                <em>￥5316.00</em>
                            </li>
                            <li>
                                <span>返现：</span>
                                <em>-￥240.00</em>
                            </li>
                            <li>
                                <span>运费：</span>
                                <em class="send">￥10.00</em>
                            </li>
                            <li>
                                <span>应付总额：</span>
                                <em>￥5076.00</em>
                            </li>
                        </ul>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- 商品清单 end -->

    </div>

    <div class="fillin_ft">
        <input type="submit" value="">
        <p>应付总额：<strong>￥5076.00元</strong></p>

    </div>
    </form>
</div>
<!-- 主体部分 end -->

