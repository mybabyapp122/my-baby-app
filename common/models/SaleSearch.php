<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Sale;

/**
 * SaleSearch represents the model behind the search form of `common\models\Sale`.
 */
class SaleSearch extends Sale
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'creator_id', 'payer_id'], 'integer'],
            [['creator_model', 'payer_model', 'type', 'status', 'status_ex', 'invoice_id', 'metadata', 'order_date', 'gateway_invoice_id', 'gateway_invoice_url', 'create_time', 'update_time'], 'safe'],
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
            'creator_id' => $this->creator_id,
            'payer_id' => $this->payer_id,
            'order_date' => $this->order_date,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'creator_model', $this->creator_model])
            ->andFilterWhere(['like', 'payer_model', $this->payer_model])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'status_ex', $this->status_ex])
            ->andFilterWhere(['like', 'invoice_id', $this->invoice_id])
            ->andFilterWhere(['like', 'metadata', $this->metadata])
            ->andFilterWhere(['like', 'gateway_invoice_id', $this->gateway_invoice_id])
            ->andFilterWhere(['like', 'gateway_invoice_url', $this->gateway_invoice_url]);


        $query->orderBy(['create_time' => SORT_DESC]);

        return $dataProvider;
    }
}
