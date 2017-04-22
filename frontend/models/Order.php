<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $name
 * @property string $province_name
 * @property string $city_name
 * @property string $area_name
 * @property string $detail_address
 * @property integer $tel
 * @property string $delivery_id
 * @property string $delivery_name
 * @property string $delivery_price
 * @property string $pay_type_id
 * @property string $pay_type_name
 * @property string $price
 * @property integer $status
 * @property string $trode_no
 * @property string $create_time
 */
class Order extends \yii\db\ActiveRecord
{

    //快递方式
    public static $deliveries=[
        1=>['顺丰快递','20','速度非常快，服务非常好，价格稍贵'],
        2=>['申通快递','10','速度快，服务好，价格便宜'],
        3=>['EMS','12','速度一般，服务好，价格便宜'],
    ];
    //支付方式
    public static $payments=[
        1=>['货到付款','送货上门后再收款，支持现金、POS机刷卡、支票支付'],
        2=>['支付宝','在线支付'],
        3=>['微信支付','在线支付'],
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'tel', 'delivery_id', 'pay_type_id', 'status', 'create_time'], 'integer'],
            [['delivery_price', 'price'], 'number'],
            [['name', 'province_name', 'city_name', 'area_name', 'detail_address', 'delivery_name', 'pay_type_name'], 'string', 'max' => 255],
            [['trode_no'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '用户ID',
            'name' => '收货人',
            'province_name' => '省份',
            'city_name' => '城市',
            'area_name' => '地区',
            'detail_address' => '详细地址',
            'tel' => '联系电话',
            'delivery_id' => '配送方式ID',
            'delivery_name' => '配送方式的名字',
            'delivery_price' => '运费',
            'pay_type_id' => '支付方式ID',
            'pay_type_name' => '支付方式',
            'price' => '商品金额',
            'status' => '订单状态',
            'trode_no' => '第三方支付的交易号',
            'create_time' => '添加时间',
        ];
    }
}
