<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "food".
 *
 * @property int $id
 * @property string $name
 * @property string $desc
 * @property int $status
 * @property int $price
 *
 * @property MenuFood[] $menuFoods
 */
class Food extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'food';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            //[['price'], 'decimal'],
            [['name', 'desc'], 'string', 'max' => 255],
            [['price'], 'safe'],
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
            'desc' => 'Desc',
            'status' => 'Status',
            'price' => 'Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuFoods()
    {
        return $this->hasMany(MenuFood::className(), ['food_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return FoodQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FoodQuery(get_called_class());
    }
}
