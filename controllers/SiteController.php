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
        $request = Yii::$app->request;

        $query = Items::find();

        if($request->get('query'))
            $query->where(['like', 'title', trim($request->get('query'))]);
        else
            $query = $query->orderBy(['time' => SORT_DESC]);


        if($request->get('cat')) {
            $query->andWhere(['category_id' => trim($request->get('cat'))]);
        }

        if($request->get('city')) {
            $query->andWhere(['city_id' => trim($request->get('city'))]);
        }

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

        $categories = Categories::find()->all();
        $cities = Cities::find()->all();

        return $this->render('index', [
            'items' => $items,
            'categories' => $categories,
            'pagination' => $pagination,
            'cities' => $cities,
            'amount' => $count,
        ]);
    }

    public function actionVkItem()
    {
        $request = Yii::$app->request;

        $item = VkItems::findOne(intval($request->get('id')));

        if($item) {
            if(!$item->description_raw)
                VkModel::getPhotoDescription($item, VkGroups::findOne(['group_id' => $item['group_id']]));

            $user_items = VkItems::find()
                ->where(['user_id' => $item->user_id])
                ->andWhere('id != :id', ['id' => $item->id])
                ->orderBy(['timestamp' => SORT_DESC])
                ->all();

            $item->user_id = Users::findOne(['id' => $item->user_id]);
            $item->group_id = VkGroups::findOne(['group_id' => $item->group_id]);

            foreach($user_items as $key => $user_item)
            {
                $user_item->user_id = Users::findOne(['id' => $user_item->user_id]);
                $user_item->group_id = VkGroups::findOne(['group_id' => $user_item->group_id]);
            }

            return $this->render('vk_item', [
                'item' => $item,
                'user_items' => $user_items
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

        $query = VkItems::find();

        if($request->get('query'))
            $query->where(['like', 'description', UtilsModel::rus2translit(trim($request->get('query')))]);

        if($request->get('cat')) {
            if(trim($request->get('cat')) != 'a')
                $query->andWhere(['category' => trim($request->get('cat'))]);
        }

        $query->orderBy(['timestamp' => SORT_DESC]);

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

        $city = Cities::findOne(['alias' => $request->get('city')]);
        $category = Categories::findOne(['alias' => $request->get('category')]);

        if($category && $city)
            $item = Items::findOne(['alias' => $request->get('alias'), 'city_id' => $city->id, 'category_id' => $category->id]);
        else {
            return $this->render('error', [
                'message' => 'Такой страницы не существует',
                'name' => 'Ошибка 404'
            ]);
        }

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
}
