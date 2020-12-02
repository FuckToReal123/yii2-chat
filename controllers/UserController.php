<?php

namespace app\controllers;

use app\models\User;
use app\models\UserForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

class UserController extends Controller
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
                        'actions' => ['index', 'view', 'update'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Список пользователей
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', compact('dataProvider'));
    }

    /**
     * Просмотр информации о пользователе
     *
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = User::findOne(['id' => $id]);

        return $this->render('view', compact('model'));
    }

    /**
     * Изменение данных пользователя
     *
     * @param $id
     * @return string
     */
    public function actionUpdate($id)
    {
        $userModel = User::findOne(['id' => $id]);
        $model = new UserForm();

        $model->role = $userModel->getCurrentRole();

        if ($model->load(Yii::$app->request->post())) {
            if (!$model->validate()) {
                Yii::$app->session->setFlash('error', 'Не удалось изменить роль пользователя.');
                return $this->render('update', compact('model'));
            }

            if ($userModel->changeRole($model->role)) {
                Yii::$app->session->setFlash('success', 'Роль пользователя успешно изменена.');
                return $this->redirect(Url::toRoute(['/user/view', 'id' => $userModel->id]));
            }
        }

        return $this->render('update', compact('model', 'userModel'));
    }
}
