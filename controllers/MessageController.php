<?php

namespace app\controllers;

use app\models\Message;
use app\models\MessageEditForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

class MessageController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'update', 'incorrect'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Список сообщений
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Message::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', compact('dataProvider'));
    }

    /**
     * Просмотр сообщения
     *
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = Message::findOne(['id' => $id]);

        return $this->render('view', compact('model'));
    }

    /**
     * Изменение сообщения
     *
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = new MessageEditForm();
        $messageModel = Message::findOne(['id' => $id]);

        $model->status = $messageModel->status;

        if ($model->load(Yii::$app->request->post())) {
            if (!$model->validate()) {
                Yii::$app->session->setFlash('error', 'Не удалось изменить статус сообщения.');
                return $this->render('update', compact('model', 'messageModel'));
            }

            $messageModel->status = $model->status;

            if ($messageModel->save()) {
                Yii::$app->session->setFlash('success', 'Статус сообщения успешно изменен.');
                return $this->redirect(Url::toRoute(['/message/view', 'id' => $messageModel->id]));
            }
        }

        return $this->render('update', compact('model', 'messageModel'));
    }


    public function actionIncorrect()
    {
        $query = Message::find()->where(['status' => Message::STATUS_INCORRECT]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('incorrect', compact('dataProvider'));
    }
}
