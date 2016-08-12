<?php

namespace app\models;

use Yii;
use yii\validators\EmailValidator;

/**
 * This is the model class for table "projects".
 *
 * @property string $Title
 * @property string $Commentary
 * @property integer $id
 * @property string $site_addr
 * @property integer $seo_type
 * @property string $seo_theme
 *
 * @property Tasks[] $tasks
 */
class Projects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    


    public static function tableName()
    {
        return 'projects';
    }

    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['site_addr', 'seo_type','Title','project_chief'], 'required'],
            [['seo_type','project_chief'], 'integer'],
            [['Commentary','Title','checklist'],'string'],
            [['report_day'],'date','format'=>'yyyy-mm-dd'],
            [['Title', 'site_addr', 'seo_theme'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Title' => 'Название проекта',
            'Commentary' => 'Комментарий',
            'id' => 'ID',
            'site_addr' => 'Адрес сайта',
            'seo_type' => 'Пакет продвижения',
            'seo_theme' => 'Тематика',
            'project_files'=>'Загрузите файл',
            'project_chief'=>'Ответственный за проект',
            'report_day'=>'Дата отчета'
        ];
    }
    /**
     * Email validation.
     *
     * @param $attribute
     */


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['project_id' => 'id']);
    }

}
