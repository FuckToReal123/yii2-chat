<?php

namespace app\models;

use yii\base\Model;

class UserForm extends Model
{
    /** @var string Название роли гостя */
    const USER_ROLE_GUEST = 'guest';
    /** @var string Название роли зарегистрированного пользователя */
    const USER_ROLE_USER = 'user';
    /** @var string Название роли админа */
    const USER_ROLE_ADMIN = 'admin';

    /** @var string */
    public $role;

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
            [['role'], 'required'],
            [['role'], 'string'],
            [['role'], 'in', 'range' => [self::USER_ROLE_GUEST, self::USER_ROLE_USER, self::USER_ROLE_ADMIN]]
        ];
    }

    /**
     * Возвращает список ролей
     *
     * @return array
     */
    public function getRolesList()
    {
        return [
            self::USER_ROLE_GUEST => 'Гость',
            self::USER_ROLE_USER => 'Пользователь',
            self::USER_ROLE_ADMIN => 'Админ',
        ];
    }
}
