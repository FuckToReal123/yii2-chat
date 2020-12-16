<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;

/**
 * Class SignupForm
 * @package app\models
 *
 * Форма регистрации
 */
class SignupForm extends Model
{
    /** @var string Имя */
    public $username;
    /** @var string email */
    public $email;
    /** @var string Паарль */
    public $password;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'trim'],
            [['username', 'email', 'password'], 'required'],
            [
                ['username'],
                'unique',
                'targetClass' => '\app\models\User',
                'message' => 'Пользователь с таким именем уже существует.'
            ],
            [['username'], 'string', 'min' => 2, 'max' => 255],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 255],
            [
                ['email'],
                'unique',
                'targetClass' => '\app\models\User',
                'message' => 'Пользователь с таким e-mail уже существует.'
            ],
            [['password'], 'string', 'min' => 6],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function beforeValidate()
    {
        $this->username = Html::encode($this->username);
        $this->email = Html::encode($this->email);
        $this->password = Html::encode($this->password);

        return parent::beforeValidate();
    }

    /**
     * Регистрирует юзера
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {

        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        if (!$user->save()) {
            $this->addErrors($user->getErrors());
            return null;
        }

        // назначаем роль юзеру
        $userRole = Yii::$app->authManager->getRole('user');
        Yii::$app->authManager->assign($userRole, $user->id);

        return $user;
    }
}
