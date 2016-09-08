<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tasks;

/**
 * TasksSearch represents the model behind the search form about `app\models\Tasks`.
 */
class CalendarSearch extends Tasks
{
    /**
     * @inheritdoc
     */
    public $date_from;
    public $date_to;
    public $project;
    public function rules()
    {
        return [
            [['id', 'Status', 'created_at', 'task_complete', 'worker','task_creator'], 'integer'],
            [['title', 'description', 'project_id'], 'safe'],
            [['project'],'safe'],
            [['finish_date'],'date','format'=>'yyyy-mm-dd']
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
        $userId = Yii::$app->user->identity['id'];

        $query = Tasks::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder'=> [
                    'task_priority'=>SORT_DESC,
                    'finish_date' => SORT_DESC,
                ]
            ],
            'pagination' => [
                'pageSize' => 1000,
            ]
        ]);






        $this->load($params);


        //Сравнение даты по промежуткам
        if ( ! is_null($this->finish_date) && strpos($this->finish_date, 'to') !== false ) {
            list($start_date, $end_date) = explode('to', $this->finish_date);
            $query->andFilterWhere(['between', 'finish_date', $start_date, $end_date]);
            $this->finish_date = null;
        }


        if ( ! is_null($this->task_complete) && strpos($this->task_complete, 'to') !== false ) {
            list($start_date, $end_date) = explode('to', $this->task_complete);
            $query->andFilterWhere(['between', 'finish_date', $start_date, $end_date]);
            $this->task_complete = null;
        }
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }




        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'Status' => $this->Status,
            'created_at' => $this->created_at,
            'worker' => $this->worker,
            'task_complete' => $this->task_complete,
            'project_id' => $this->project_id,
            'task_creator' => $this->task_creator
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
        ;
        return $dataProvider;
    }
}
