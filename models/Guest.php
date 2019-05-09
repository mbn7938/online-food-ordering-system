<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "guest".
 *
 * @property int $id
 * @property string $name
 * @property int $tel_no
 * @property string $email
 *
 * @property Order[] $orders
 */
class Guest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'guest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email','tel_no'], 'required'],
            [['email'],'unique'],
            [['tel_no'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'tel_no' => 'Mobile Number',
            'email' => 'Guest Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['guest_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return GuestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GuestQuery(get_called_class());
    }
}
