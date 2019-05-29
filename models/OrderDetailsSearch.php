<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class OrderDetailsSearch extends OrderDetails
{
    public $menu_food_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'menu_food_id', 'order_id', 'status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$id)
    {
        $query = OrderDetails::find();


        $query->andFilterWhere(['order_id'=>$id]);


//        var_dump($query);
//        die();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'menu_food_id' => $this->menu_food_id,
            'order_id' => $this->order_id,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }

}
