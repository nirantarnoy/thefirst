<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Loan;

/**
 * LoanSearch represents the model behind the search form of `backend\models\Loan`.
 */
class LoanSearch extends Loan
{
    public $globalSearch;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'loan_date', 'sale_id', 'period_type', 'factor', 'period', 'first_pay_date', 'next_pay_date', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['loan_no', 'personal_id'], 'safe'],
            [['payment_per', 'first_pay'], 'number'],
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
        $query = Loan::find();

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
            'loan_date' => $this->loan_date,
            'sale_id' => $this->sale_id,
            'period_type' => $this->period_type,
            'factor' => $this->factor,
            'period' => $this->period,
            'payment_per' => $this->payment_per,
            'first_pay' => $this->first_pay,
            'first_pay_date' => $this->first_pay_date,
            'next_pay_date' => $this->next_pay_date,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        if($this->globalSearch != ''){
            $query->orFilterWhere(['like','loan_no',$this->globalSearch])
                ->orFilterWhere(['like','personal_id',$this->globalSearch]);
        }

        return $dataProvider;
    }
}
