<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MenuFood]].
 *
 * @see MenuFood
 */
class MenuFoodQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MenuFood[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MenuFood|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
