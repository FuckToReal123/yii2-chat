<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class Message
 * @package app\models
 *
 * @property integer $id
 * @property string $text
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property integer $user_id
 */
class Message extends ActiveRecord
{
    /** @var int Статус отображаемого сообщения */
    const STATUS_ACTIVE = 1;
    /** @var int Статус скрытого сообщения */
    const STATUS_DISABLED = 0;
    /** @var int Статус некорректного сообщения */
    const STATUS_INCORRECT = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['user_id'], 'userRoleValidator', 'skipOnEmpty' => false],
            [['text'], 'string', 'min' => 1, 'max' => 255],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['status'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DISABLED, self::STATUS_INCORRECT]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'text' => 'Текст сообщения',
            'created_at' => 'Отправлено',
            'updated_at' => 'Изменено',
            'status' => 'Статус сообщения',
            'user_id' => 'Кто отправил'
        ];
    }

    /**
     * Возвращает возможные статусы ссобщений
     *
     * @return string[]
     */
    public function getStatuses()
    {
        return [
            Message::STATUS_ACTIVE => 'Активно',
            Message::STATUS_DISABLED => 'Удалено',
            Message::STATUS_INCORRECT => 'Некорректно',
        ];
    }

    /**
     * Запрещает отправлять сообщения гостям
     */
    public function userRoleValidator()
    {
        if (!Yii::$app->user->can('sendMessages')) {
            $this->addError('user_id', 'Только зарегистрированные пользователи могут отправлять сообщения.');
        }
    }
}
