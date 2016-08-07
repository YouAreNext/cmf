<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tasks;

/**
 * TasksSearch represents the model behind the search form about `app\models\Tasks`.
 */
class TasksSearch extends Tasks
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
            [['id', 'Status', 'created_at', 'finish_date', 'task_complete'], 'integer'],
            [['title', 'description', 'project_id', 'worker'], 'safe'],
            [['project'],'safe']
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
        if (isset($project)){
            $query = Tasks::find()->where(['project_id'=>$project]);
        }
        elseif (isset($user)){
            $query = Tasks::find()->where(['worker'=>$user]);

        } else{
            $query = Tasks::find();
        }



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


        if ( ! is_null($this->finish_date) && strpos($this->finish_date, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->finish_date);
            var_dump($end_date);
            $query->andFilterWhere(['between', 'finish_date', $start_date, $end_date]);
            $this->finish_date = null;
            echo(finish_date);
        };
        $query->joinWith('project');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'Status' => $this->Status,
            'created_at' => $this->created_at,
            'task_complete' => $this->task_complete,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'Projects.Title', $this->project_id])

        ;


        return $dataProvider;
    }
}
