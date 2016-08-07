<?php
namespace app\models;


use yii\base\Model;

use Yii;
use yii\db\ActiveRecord;

class RegForm extends Model{
    public $username;
    public $password;
    public $status;

    public function rules()
    {
        return [
            [['username','password'], 'filter','filter' => 'trim'],
            [['username','password'], 'required'],
            ['username','string','min'=>2,'max'=>255],
            ['password','string','min'=>6,'max'=>255],
            ['username','unique',
                'targetClass' => User::className(),
                'message' => 'Это имя уже занято'
            ],
            ['status','default','value' => \app\models\User::STATUS_ACTIVE, 'on' => 'default'],
            ['status','in','range' =>[
                \app\models\User::STATUS_NOT_ACTIVE,
                \app\models\User::STATUS_ACTIVE

            ]],

        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль'
        ];
    }
    public function reg()
    {
       $user = new User();
       $user->username = $this->username;
       $user->status = $this->status;
       $user->setPassword($this->password);
       $user->generateAuthKey();
       return $user->save() ? $user : null;
    }
}