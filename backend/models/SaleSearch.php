<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Sale;

/**
 * SaleSearch represents the model behind the search form of `backend\models\Sale`.
 */
class SaleSearch extends Sale
{
    public $globalSearch;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'trans_date', 'customer_id', 'sale_type_id', 'payment_type_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['sale_no', 'sale_total_text'], 'safe'],
            [['discount_per', 'discount_amount', 'sale_total'], 'number'],
            [['globalSearch'],'string'],
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
        $query = Sale::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'trans_date' => $this->trans_date,
            'customer_id' => $this->customer_id,
            'sale_type_id' => $this->sale_type_id,
            'payment_type_id' => $this->payment_type_id,
            'discount_per' => $this->discount_per,
            'discount_amount' => $this->discount_amount,
            'sale_total' => $this->sale_total,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        if($this->globalSearch!=""){
            $query->orFilterWhere(['like', 'sale_no', $this->globalSearch])
                ->orFilterWhere(['like', 'sale_total_text', $this->globalSearch]);
        }


        return $dataProvider;
    }
}
