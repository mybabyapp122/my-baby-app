<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "admin".
 *
 * @property int $id
 * @property string $username
 * @property string|null $name
 * @property string|null $email
 * @property string $auth_key
 * @property string $password_hash
 * @property resource|null $password_reset_token
 * @property int $status
 * @property string $create_time
 * @property string $update_time
 */
class Admin extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'status'], 'required'],
            [['status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['username', 'auth_key', 'password_hash'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 127],
            [['password_reset_token'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'name' => 'Name',
            'email' => 'Email',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    public static function findByEmail($email) {
        return static::findOne(['email' => $email, 'status' => ObjectId::STATUS_ACTIVE]);
    }

    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'status' => ObjectId::STATUS_ACTIVE]);
    }

    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }


    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => ObjectId::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
//        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
        return static::findOne(['auth_key' => $token]);
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }


    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
}
