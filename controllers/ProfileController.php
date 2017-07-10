<?php
/**
 * Created by PhpStorm.
 * User: sau00
 * Date: 5/31/17
 * Time: 3:07 AM
 */

namespace app\controllers;


use app\components\AuthHandler;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ProfileController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'add', 'edit', 'delete', 'info', 'login', 'auth'],
                'denyCallback' => function ($rule, $action) {
                    $this->redirect(['profile/login']);
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'auth'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'add', 'edit', 'delete', 'info', 'login'],
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
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
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }

    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionLogin()
    {
        if(\Yii::$app->user->isGuest)
            return $this->render('login');
        else
            $this->redirect(['profile/index']);
    }

    public function actionAdd()
    {
        echo 'Add Advert';
//        return $this->render('add');
    }

    public function actionEdit()
    {

    }

    public function actionDelete()
    {

    }

    // Обновление профиля
    public function actionInfo()
    {

    }
}