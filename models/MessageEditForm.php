<?php

namespace app\models;

use Yii;
use yii\base\Model;

class MessageEditForm extends Model
{
    /** @var int Статус сообщения */
    public $status;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'in', 'range' => [
                Message::STATUS_ACTIVE,
                Message::STATUS_DISABLED,
                Message::STATUS_INCORRECT,
            ]],
        ];
    }
}
