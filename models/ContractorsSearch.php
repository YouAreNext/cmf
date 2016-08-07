<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Contractors;

/**
 * ContractorsSearch represents the model behind the search form about `app\models\Contractors`.
 */
class ContractorsSearch extends Contractors
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'author', 'now_date', 'next_date', 'now_result', 'next_event', 'project_type'], 'integer'],
            [['title', 'client', 'phone', 'mail', 'meet', 'comment'], 'safe'],
            [['created_at'],'date','format'=>'yyyy-mm-dd']
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
        $query = Contractors::find();

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
            'author' => $this->author,
            'created_at' => $this->created_at,
            'now_date' => $this->now_date,
            'next_date' => $this->next_date,
            'now_result' => $this->now_result,
            'next_event' => $this->next_event,
            'project_type' => $this->project_type,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'client', $this->client])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'mail', $this->mail])
            ->andFilterWhere(['like', 'meet', $this->meet])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
