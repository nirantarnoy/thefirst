<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Loanpayment;

/**
 * LoanpaymentSearch represents the model behind the search form of `backend\models\Loanpayment`.
 */
class LoanpaymentSearch extends Loanpayment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'loan_id', 'period_pay', 'payment_type', 'payment_date', 'fine_type', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['payment_by'], 'safe'],
            [['amount', 'fee', 'fine'], 'number'],
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
        $query = Loanpayment::find();

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
            'loan_id' => $this->loan_id,
            'period_pay' => $this->period_pay,
            'payment_type' => $this->payment_type,
            'payment_date' => $this->payment_date,
            'amount' => $this->amount,
            'fee' => $this->fee,
            'fine' => $this->fine,
            'fine_type' => $this->fine_type,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'payment_by', $this->payment_by]);

        return $dataProvider;
    }
}
