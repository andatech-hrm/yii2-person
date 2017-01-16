<?php

namespace andahrm\person\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\person\models\Detail;

/**
 * DetailSearch represents the model behind the search form about `andahrm\person\models\Detail`.
 */
class DetailSearch extends Detail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'nationality_id', 'race_id', 'religion_id', 'address_contact_id', 'address_birth_place_id', 'address_register_id', 'married_status', 'people_spouse_id'], 'integer'],
            [['blood_group', 'mother_name', 'father_name'], 'safe'],
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
        $query = Detail::find();

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
            'nationality_id' => $this->nationality_id,
            'race_id' => $this->race_id,
            'religion_id' => $this->religion_id,
            'address_contact_id' => $this->address_contact_id,
            'address_birth_place_id' => $this->address_birth_place_id,
            'address_register_id' => $this->address_register_id,
            'married_status' => $this->married_status,
            'people_spouse_id' => $this->people_spouse_id,
        ]);

        $query->andFilterWhere(['like', 'blood_group', $this->blood_group])
            ->andFilterWhere(['like', 'mother_name', $this->mother_name])
            ->andFilterWhere(['like', 'father_name', $this->father_name]);

        return $dataProvider;
    }
}
