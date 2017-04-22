<?php

?>
<!-- 页面主体 start -->
<div class="main w1210 bc mt10">
    <div class="crumb w1210">
        <h2><strong>我的XX </strong><span>> 我的订单</span></h2>
    </div>


    <!-- 左侧导航菜单 start -->
    <div class="menu fl">
        <h3>我的XX</h3>
        <div class="menu_wrap">
            <dl>
                <dt>订单中心 <b></b></dt>
                <dd><b>.</b><a href="">我的订单</a></dd>
                <dd><b>.</b><a href="">我的关注</a></dd>
                <dd><b>.</b><a href="">浏览历史</a></dd>
                <dd><b>.</b><a href="">我的团购</a></dd>
            </dl>

            <dl>
                <dt>账户中心 <b></b></dt>
                <dd class="cur"><b>.</b><a href="">账户信息</a></dd>
                <dd><b>.</b><a href="">账户余额</a></dd>
                <dd><b>.</b><a href="">消费记录</a></dd>
                <dd><b>.</b><a href="">我的积分</a></dd>
                <dd><b>.</b><a href="">收货地址</a></dd>
            </dl>

            <dl>
                <dt>订单中心 <b></b></dt>
                <dd><b>.</b><a href="">返修/退换货</a></dd>
                <dd><b>.</b><a href="">取消订单记录</a></dd>
                <dd><b>.</b><a href="">我的投诉</a></dd>
            </dl>
        </div>
    </div>
    <!-- 左侧导航菜单 end -->
 <!--右侧内容区域 start-->
    <div class="content fl ml10">


        <div class="address_bd mt10">
            <h4>新增收货地址</h4>
            <?php $form = \yii\widgets\ActiveForm::begin();?>
                <ul>
                    <li>
<!--                        <label for=""><span>*</span>收 货 人：</label>-->
                        <?php echo $form->field($model,'username')->textInput(['class'=>'txt'])?>
<!--                        <input type="text" name="" class="txt" />-->
                    </li>
                    <li>

                        <label for=""><span>*</span>所在地区：</label>
                        <select name="province" id="cmbProvince">

                        </select>

                        <select name="city" id="cmbCity">

                        </select>

                        <select name="area" id="cmbArea">

                        </select>
                    </li>
                    <li>
<!--                        <label for=""><span>*</span>详细地址：</label>-->
<!--                        <input type="text" name="" class="txt address"  />-->
                        <?php echo $form->field($model,'detail')->textInput(['class'=>'txt address'])?>
                    </li>
                    <li>
<!--                        <label for=""><span>*</span>手机号码：</label>-->
<!--                        <input type="text" name="" class="txt" />-->
                        <?php echo $form->field($model,'tel')->textInput(['class'=>'txt'])?>
                    </li>
                    <li>
<!--                        <label for="">&nbsp;</label>-->
<!--                        <input type="checkbox" name="" class="check" />设为默认地址-->
                        <?php echo $form->field($model,'status')->checkbox(['class'=>'check'])?>
                    </li>
                    <br>
                    <br>
                    <li>
<!--                        <label for="">&nbsp;</label>-->
<!--                        <input type="submit" name="" class="btn" value="保存" />-->
                        <?php echo \yii\helpers\Html::submitButton('保存',['class'=>'btn'])?>
                    </li>
                </ul>
            <?php \yii\widgets\ActiveForm::end();?>
        </div>

        <div class="address_hd">
            <h3>收货地址薄</h3>
            <?php foreach($addresss as $address):?>
                <dl>
                    <dt><?=$address->id.' '.$address->username.' '.$address->detail.''.$address->tel?></dt>
                    <dd>
                        <?=\yii\helpers\Html::a('修改',['address/edit','id'=>$address->id])?>
                        <?=\yii\helpers\Html::a('删除',['address/delete','id'=>$address->id])?>
                        <?php if($address->status == 1){
                            echo '<span style="color: red">默认地址</span>';
                        }else{
                        echo \yii\helpers\Html::a('设为默认地址',['address/check','id'=>$address->id]);

                        }?>
                    </dd>
                </dl>
            <?php endforeach;?>

        </div>

    </div>
    <!-- 右侧内容区域 end-->

    <div style="clear:both;"></div>
<script type="text/javascript">
    addressInit('cmbProvince', 'cmbCity', 'cmbArea', '四川', '成都', '武侯区');
</script>
