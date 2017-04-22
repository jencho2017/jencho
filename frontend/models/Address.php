<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $username
 * @property integer $user_id
 * @property string $province
 * @property string $city
 * @property string $area
 * @property integer $tel
 * @property string $detail
 * @property integer $status
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'province', 'city', 'area', 'tel', 'detail'], 'required'],
            [['user_id', 'tel', 'status'], 'integer'],
            [['username', 'province', 'city', 'area', 'detail'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '* 收 货 人',
            'user_id' => '用户ID',
            'province' => '省份',
            'city' => '省份',
            'area' => '省份',
            'tel' => '* 联系电话',
            'detail' => '* 详细地址',
            'status' => '默认地址',
        ];
    }
}
