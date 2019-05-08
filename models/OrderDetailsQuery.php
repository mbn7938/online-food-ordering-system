<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[OrderDetails]].
 *
 * @see OrderDetails
 */
class OrderDetailsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return OrderDetails[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OrderDetails|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
