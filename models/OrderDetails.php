<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_details".
 *
 * @property int $id
 * @property int $menu_food_id
 * @property int $order_id
 * @property int $status
 *
 * @property MenuFood $menuFood
 * @property Order $order
 */
class OrderDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['menu_food_id', 'order_id', 'status'], 'integer'],
            [['menu_food_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuFood::className(), 'targetAttribute' => ['menu_food_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_food_id' => 'Menu Food ID',
            'order_id' => 'Order ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuFood()
    {
        return $this->hasOne(MenuFood::className(), ['id' => 'menu_food_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * {@inheritdoc}
     * @return OrderDetailsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderDetailsQuery(get_called_class());
    }
}
