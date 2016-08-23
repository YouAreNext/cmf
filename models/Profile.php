<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "profile".
 *
 * @property integer $user_id
 * @property string $avatar
 * @property string $first_name
 * @property string $second_name
 * @property string $middle_name
 * @property integer $birthday
 * @property integer $gender
 *
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $avatar;


    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['birthday', 'gender'], 'integer'],
            [['email','ava_url'], 'string', 'max' => 255],
            [['first_name', 'second_name', 'middle_name'], 'string', 'max' => 32],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['avatar'],'file','skipOnEmpty'=>true,'extensions'=>'png,jpg']
        ];
    }

    /**
     * @inheritdoc
     *
     *
     *
     */


    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'avatar' => 'Аватар',
            'first_name' => 'Имя',
            'second_name' => 'Фамилия',
            'middle_name' => 'Отчество',
            'birthday' => 'Дата рождения',
            'gender' => 'Пол',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function updateProfile(){
        $profile = ($profile = Profile::findOne(Yii::$app->user->id)) ? $profile : new Profile();
        $profile->user_id = Yii::$app->user->id;
        $profile->first_name = $this->first_name;
        $profile->email = $this->email;
        $profile->second_name = $this->second_name;
        $profile->middle_name = $this->middle_name;
        $profile->ava_url = $this->ava_url;
        return $profile->save() ? true : false;
    }
}
