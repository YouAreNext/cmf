<?php

namespace app\models;
use yii\web\IdentityInterface;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property integer $status
 * @property string $auth_key
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $roles
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 10;

    public $password;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password' ],'filter','filter' => 'trim'],
            [['username', 'status'], 'required'],
            ['username','string','min' => 2,'max' => 255],
            ['password','required','on'=>'create'],
            ['username','unique','message' => 'Имя занято']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password Hash',
            'status' => 'Status',
            'auth_key' => 'Auth Key',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'roles' => 'Roles',
        ];
    }

//связи
   public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }
    //Хелперы
    public function setPassword($password){
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    public function generateAuthKey(){
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    public function validatePassword($password){
        return Yii::$app->security->validatePassword($password,$this->password_hash);
    }
    //Поведения

    public function behaviors()
    {
        return[
            TimestampBehavior::className()
        ];
    }
    //Поиск

    public static function findByUsername($username){
        return static::findOne(
            [
                'username' => $username,
            ]
        );
    }
    //Аутентификация

    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
}
