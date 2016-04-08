<?php

namespace frontend\modules\user\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class ProfileForm extends Model {

    public $id;
    public $username;
    public $email;
    public $firstname;
    public $lastname;
    public $phone;
    public $address;
    public $city;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['id', 'integer'],
            ['username', 'filter', 'filter' => 'trim'],
            [['username', 'firstname', 'lastname', 'email'], 'required', 'message' => '{attribute} không được rỗng.'],
            ['username', 'validateUsername'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [['email', 'firstname', 'lastname'], 'string', 'max' => 255],
            ['email', 'validateEmail'],
            [['phone'], 'integer'],
            [['city', 'address'], 'string'],
        ];
    }

    public function validateUsername($attribute, $params) {
        if (!$this->hasErrors()) {
            $model = User::find()->where(['username' => $this->username])->one();
            if (!empty($model)) {
                if ($model->id != Yii::$app->user->id)
                    $this->addError($attribute, $this->username . ' đã tồn tại trong hệ thống.');
            }
        }
    }

    public function validateEmail($attribute, $params) {
        if (!$this->hasErrors()) {
            $model = User::find()->where(['email' => $this->email])->one();
            if (!empty($model)) {
                if ($model->id != Yii::$app->user->id)
                    $this->addError($attribute, $this->email . ' đã tồn tại trong hệ thống.');
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'username' => 'Tên đăng nhập',
            'email' => 'Email',
            'firstname' => 'Họ',
            'lastname' => 'Tên'
        ];
    }

    public function profile() {
        if ($this->validate()) {
            $user = User::findOne(Yii::$app->user->id);
            $user->username = $this->username;
            $user->email = $this->email;
            $user->firstname = $this->firstname;
            $user->lastname = $this->lastname;
            $user->phone = $this->phone;
            $user->address = $this->address;
            $user->city = $this->city;
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }

}
