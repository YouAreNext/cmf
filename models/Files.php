<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $parent_type
 * @property string $url
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     *
     */

    public $file;

    public static function tableName()
    {
        return 'files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => 'png, jpg,psd,txt,xl,xlsx,xls,doc,docx', 'skipOnEmpty' => true,'maxFiles'=>10],
            [['parent_id', 'parent_type'], 'integer'],
            [['url'], 'string'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'parent_type' => 'Parent Type',
            'url' => 'Url',
        ];
    }
}
