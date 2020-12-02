<?php

namespace app\controllers;

use app\models\Message;
use app\models\MessageForm;
use app\models\SignupForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $messageFormModel = new MessageForm();
        $messages = Message::find()->orderBy(['created_at' => SORT_DESC])->all();

        $request = Yii::$app->request;

        if ($messageFormModel->load($request->post()) && $request->post('send-message-button')) {
            if (!$messageFormModel->send()) {
                Yii::$app->session->setFlash('error', 'Не удалось отправить сообщение.');
                return $this->render('index', compact('messageFormModel', 'messages'));
            } else {
                $this->refresh();
            }
        }


        return $this->render('index', compact('messageFormModel', 'messages'));
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', compact('model'));
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }

            if ($model->hasErrors()) {
                Yii::$app->session->setFlash('error', 'Не удалось зарегистрировать пользователя.');
                return $this->render('signup', compact('model'));
            }
        }

        return $this->render('signup', compact('model'));
    }
}
