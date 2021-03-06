<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class OrderSearch extends Order
{
    public $menu_food_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'menu_food_id', 'guest_id', 'type', 'table_no', 'status'], 'integer'],
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
    public function search($params)
    {
        $query = Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['order_at'=>SORT_DESC]]
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
            'guest_id' => $this->guest_id,
            'type' => $this->type,
            'table_no' => $this->table_no,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchOwn($params,$user)
    {

        $quest = Guest::find()->where(['email'=>$user->email])->asArray()->one();


//        var_dump($quest);
//        die();

        $query = Order::find()->where(['guest_id'=>$quest['id']]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['order_at'=>SORT_DESC]]
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
            'guest_id' => $this->guest_id,
            'type' => $this->type,
            'table_no' => $this->table_no,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
