<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contractors".
 *
 * @property integer $id
 * @property integer $author
 * @property integer $created_at
 * @property string $title
 * @property string $client
 * @property string $phone
 * @property string $mail
 * @property integer $now_date
 * @property integer $next_date
 * @property integer $now_result
 * @property integer $next_event
 * @property integer $project_type
 * @property string $meet
 * @property string $comment
 */
class Contractors extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contractors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author', 'title', 'client', 'phone', 'mail', 'now_date', 'next_date', 'now_result', 'next_event', 'project_type', 'meet','created_at'], 'required'],
            [['author','now_result', 'next_event', 'project_type'], 'integer'],
            [['comment'], 'string'],
            [['created_at'],'date','format'=>'yyyy-mm-dd'],
            [['now_date', 'next_date',],'date','format'=> 'yyyy-mm-dd'],
            [['title', 'client', 'phone', 'mail', 'meet'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'=>'ID',
            'author' => 'Руководитель проекта',
            'created_at' => 'Создан',
            'title' => 'Название контрагента',
            'client' => 'Контактное лицо',
            'phone' => 'Телефон',
            'mail' => 'E-mail',
            'now_date' => 'Дата',
            'next_date' => 'Дата следующего события',
            'now_result' => 'Результат',
            'next_event' => 'Событие',
            'project_type' => 'Тип проекта',
            'meet' => 'Место встречи',
            'comment' => 'Комментарий',
        ];
    }
}
