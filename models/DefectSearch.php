<?php

namespace andahrm\person\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\person\models\Defect;

/**
 * DefectSearch represents the model behind the search form of `andahrm\person\models\Defect`.
 */
class DefectSearch extends Defect
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'edoc_id', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['date_defect', 'title', 'detail'], 'safe'],
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
        $query = Defect::find();

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
            'user_id' => $this->user_id,
            'date_defect' => $this->date_defect,
            'edoc_id' => $this->edoc_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'detail', $this->detail]);

        return $dataProvider;
    }
}
