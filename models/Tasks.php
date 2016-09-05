<?php

namespace app\models;
use app\models\Projects;
use app\models\User;
use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $Status
 * @property integer $worker
 * @property integer $created_at
 * @property integer $finish_date
 * @property integer $task_complete
 * @property integer $project_id
 *
 * @property Projects $project
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'title', 'description', 'Status', 'worker','finish_date', 'created_at'], 'required'],
            [[ 'Status', 'worker', 'project_id','prev_task','periodic','task_creator','task_priority'], 'integer'],
            [['description','worker_comment'], 'string'],
            [['created_at', 'finish_date'],'date','format'=>'yyyy-mm-dd'],
            [['task_complete'],'date','format'=>'yyyy-MM-dd HH:i:ss'],
            [['title'], 'string', 'max' => 255],

            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Projects::className(), 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Описание',
            'Status' => 'Статус задачи',
            'worker' => 'Исполнитель',
            'worker_comment' => 'Комментарий исполнителя',
            'created_at' => 'Создана',
            'finish_date' => 'Дата окончания',
            'task_complete' => 'Задача завершена',
            'project_id' => 'Проект',
            'task_priority'=>'Приоритет',
            'projectName' => 'Project Name',
            'finish_date' => 'Дата окончания',
            'task_creator' => 'Создатель задачи'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Projects::className(), ['id' => 'project_id']);
    }

    public function getProjectName() {
        return $this->project->Title;
    }

    public function getUser(){
        return $this->hasOne(User::className(),['id'=>'worker']);
    }
    public function getUserName() {
        return $this->user->username;
    }




}
