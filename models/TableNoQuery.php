<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TableNo]].
 *
 * @see TableNo
 */
class TableNoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TableNo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TableNo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
