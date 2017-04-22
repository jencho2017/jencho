<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property string $sn
 * @property string $logo
 * @property integer $goods_category_id
 * @property integer $brand_id
 * @property string $market_price
 * @property string $shop_price
 * @property integer $stock
 * @property integer $is_on_sale
 * @property integer $status
 * @property integer $sort
 * @property integer $inputtime
 */
class Goods extends \yii\db\ActiveRecord
{
    public $content;
    public static $status_options = ['1'=>'新品','2'=>'热销','4'=>'精品',
        '8'=>'促销','3'=>'新品,热销','5'=>'新品,精品','9'=>'新品,促销',
        '6'=>'热销,精品','10'=>'热销,促销','12'=>'精品,促销','7'=>'新品,热销,精品',
        '11'=>'新品,热销,促销','13'=>'新品,精品,促销','14'=>'热销,精品,促销',
        '15'=>'新品,热销,精品,促销'
    ];
    public static $sale_options = ['0'=>'下架','1'=>'上架'];

    public $count;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'brand_id', 'market_price', 'shop_price', 'stock', 'is_on_sale', 'status', 'sort'], 'required'],
            [['goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'sort', 'inputtime'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['sn'], 'string', 'max' => 15],
            [['logo'], 'string', 'max' => 150],
            ['content','safe'],
            ['count','safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'sn' => '货号',
            'logo' => '商品LOGO',
            'goods_category_id' => '商品分类',
            'brand_id' => '品牌',
            'market_price' => '市场价格',
            'shop_price' => '本店价格',
            'stock' => '库存',
            'is_on_sale' => '是否上架',
            'status' => '商品状态',
            'sort' => '商品排序',
            'inputtime' => '添加时间',
        ];
    }
    public function actions()
    {
        return [
            'upload'=>[
                'class' => 'common\widgets\file_upload\UploadAction',     //这里扩展地址别写错
                'config' => [
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ]
        ];
    }

    public static function getBrandOptions()
    {
        $options = Brand::find()->asArray()->all();
        return ArrayHelper::map($options,'id','name');
    }
    public function getCategory()
    {
        return $this->hasOne(GoodsCategory::className(),['id'=>'goods_category_id']);
    }
}
