<?php

namespace andahrm\person\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\person\models\PersonRetired;

/**
 * PersonRetiredSearch represents the model behind the search form of `andahrm\person\models\PersonRetired`.
 */
class PersonRetiredSearch extends PersonRetired
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'last_position_id', 'because', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['retired_date', 'note'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = PersonRetired::find();

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
            'user_id' => $this->user_id,
            'last_position_id' => $this->last_position_id,
            'retired_date' => $this->retired_date,
            'because' => $this->because,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
