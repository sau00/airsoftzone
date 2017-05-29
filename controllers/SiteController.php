<?php

namespace app\controllers;

use app\models\Categories;
use app\models\Cities;
use app\models\Items;
use app\models\Users;
use app\models\VkGroups;
use app\models\VkItems;
use app\modules\parsers\models\UtilsModel;
use app\modules\parsers\models\VkModel;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Items::find()->orderBy(['time' => SORT_DESC]);

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $items = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        foreach($items as $item) {
            $item->user_id = Users::findOne(['id' => $item->user_id]);
            $item->city_id = Cities::findOne(['id' => $item->city_id]);
            $item->category_id = Categories::findOne(['id' => $item->category_id]);
        }

        return $this->render('index', [
            'items' => $items,
            'pagination' => $pagination
        ]);
    }

    public function actionVkItem()
    {
        $request = Yii::$app->request;

        $item = VkItems::findOne(intval($request->get('id')));

        $item->user_id = Users::findOne(['id' => $item->user_id]);
        $item->group_id = VkGroups::findOne(['group_id' => $item->group_id]);

        if($item) {
            if(!$item->description_raw)
                VkModel::getPhotoDescription($item, VkGroups::findOne(['group_id' => $item['group_id']])) ;

            return $this->render('vk_item', [
                'item' => $item,
            ]);
        } else {
            return $this->render('error', [
                'message' => 'Такой страницы не существует',
                'name' => 'Ошибка 404'
            ]);
        }
    }

    public function actionVk()
    {
        $request = Yii::$app->request;

        if($request->get('query')) {
            $query = VkItems::find()
                ->where(['like', 'description', UtilsModel::rus2translit(trim($request->get('query')))])
                ->andWhere(['category' => trim($request->get('cat'))])
                ->orderBy(['timestamp' => SORT_DESC]);
        } elseif (trim($request->get('cat'))) {
            if(trim($request->get('cat')) != 'a') {
                $query = VkItems::find()->where(
                    ['category' => trim($request->get('cat'))]
                )->orderBy(['timestamp' => SORT_DESC]);
            } else {
                $query = VkItems::find()->orderBy(['timestamp' => SORT_DESC]);
            }
        }
        else {
            $query = VkItems::find()->orderBy(['timestamp' => SORT_DESC]);
        }

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $items = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        // Need to rework log later
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/uploads/items/log.txt', UtilsModel::rus2translit($request->get('query')) . "\r\n", FILE_APPEND);

        foreach($items as $item) {
            $item->user_id = Users::findOne(['id' => $item->user_id]);
            $item->group_id = VkGroups::findOne(['group_id' => $item->group_id]);
        }

        return $this->render('vk', [
            'items' => $items,
            'pagination' => $pagination,
            'query' => trim($request->get('query')),
            'amount' => $count
        ]);
    }

    public function actionItem()
    {
        $request = Yii::$app->request;

        $item = Items::findOne(['id' => $request->get('id')]);

        if(isset($item)) {
            $item->user_id = Users::findOne(['id' => $item->user_id]);
            $item->city_id = Cities::findOne(['id' => $item->city_id]);
            $item->category_id = Categories::findOne(['id' => $item->category_id]);

            return $this->render('item', [
                'item' => $item
            ]);
        } else {
            return $this->render('error', [
                'message' => 'Такой страницы не существует',
                'name' => 'Ошибка 404'
            ]);
        }
    }

    public function actionAlpha()
    {
        return $this->render('alpha');
    }

    /**
     * Login action.
     *
     * @return string
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
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
