<?php

namespace andahrm\person\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\person\models\Person;

/**
 * PersonSearch represents the model behind the search form about `andahrm\person\models\Person`.
 */
class PersonSearch extends Person
{
    public $fullname;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['citizen_id', 'firstname_th', 'lastname_th', 'firstname_en', 'lastname_en', 'gender', 'tel', 'phone', 'birthday', 'fullname'], 'safe'],
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
        $query = Person::find();

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
            'title_id' => $this->title_id,
            'birthday' => $this->birthday,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'citizen_id', $this->citizen_id])
            ->andFilterWhere(['like', 'firstname_th', $this->firstname_th])
            ->andFilterWhere(['like', 'lastname_th', $this->lastname_th])
            ->andFilterWhere(['like', 'firstname_en', $this->firstname_en])
            ->andFilterWhere(['like', 'lastname_en', $this->lastname_en])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'phone', $this->phone]);
        
        $query->andFilterWhere(['like', 'firstname_th', $this->fullname])
            ->orFilterWhere(['like', 'lastname_th', $this->fullname])
            ->orFilterWhere(['like', 'firstname_en', $this->fullname])
            ->orFilterWhere(['like', 'lastname_en', $this->fullname]);

        return $dataProvider;
    }
}
