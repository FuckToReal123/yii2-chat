<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;

/**
 * Class MessageForm
 * @package app\models
 *
 * Форма отправки сообщения
 */
class MessageForm extends Model
{
    /** @var string Текст сообщения */
    public $text;

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
            [['text'], 'string', 'min' => 1, 'max' => 255],
            [['text', 'userId'], 'required'],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function beforeValidate()
    {
        $this->text = Html::encode($this->text);

        return parent::beforeValidate();
    }

    /**
     * Отправляет сообщение в чат
     *
     * @return Message|null
     */
    public function send()
    {
        if (!$this->validate()) {
            return null;
        }

        $model = new Message();

        $model->text = $this->text;
        $model->user_id = Yii::$app->user->id;

        if (!$model->save()) {
            $this->addErrors($model->getErrors());
            return null;
        }

        return $model;
    }
}
