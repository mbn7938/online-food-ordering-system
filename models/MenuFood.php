<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menu_food".
 *
 * @property int $id
 * @property int $menu_id
 * @property int $food_id
 * @property int $status
 *
 * @property Menu $menu
 * @property Food $food
 * @property Order[] $orders
 */
class MenuFood extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu_food';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['menu_id', 'food_id'], 'required'],
            [['menu_id', 'food_id', 'status'], 'integer'],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['menu_id' => 'id']],
            [['food_id'], 'exist', 'skipOnError' => true, 'targetClass' => Food::className(), 'targetAttribute' => ['food_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => 'Menu Name',
            'food_id' => 'Food Name',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFood()
    {
        return $this->hasOne(Food::className(), ['id' => 'food_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['menu_food_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return MenuFoodQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuFoodQuery(get_called_class());
    }
}
