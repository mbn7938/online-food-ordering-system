<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "table_no".
 *
 * @property int $id
 * @property int $table_no
 * @property int $status
 */
class TableNo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'table_no';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['table_no', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table_no' => 'Table No',
            'status' => 'Status',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TableNoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TableNoQuery(get_called_class());
    }
}
