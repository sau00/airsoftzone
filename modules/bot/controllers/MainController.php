<?php

namespace app\modules\bot\controllers;

use app\models\Items;
use \app\models\Users;
use app\modules\parsers\models\AwgmModel;

/**
 * Created by PhpStorm.
 * User: sau00
 * Date: 4/27/17
 * Time: 11:01 PM
 */
class MainController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        if ($action->id == 'index') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        if (!isset($_REQUEST)) {
            return;
        }

        $confirmation_token = 'cd743aa7';

        $token = '630aa6da5928b5da9977d64d44b8040f83e366b3bea1cc03872bfff8432fb2c5114022312da80a6ba41b5';

        $data = json_decode(file_get_contents('php://input'));

        switch ($data->type) {
            case 'confirmation':
                echo $confirmation_token;
                break;

            case 'message_new':
                $user_id = $data->object->user_id;

                $message = $data->object->body;

                $messages = [
                    '/add' => "Для добавления объявления отправь в ответном сообщении форму и прикрепи фотографию:" . "\r\n" .
                        "1) Заголовок объявления"  . "\r\n" .
                        "2) Цена" . "\r\n" .
                        "3) Город" . "\r\n" .
                        "4) Пересыл (Да/Нет)" . "\r\n" .
                        "5) Описание" . "\r\n"
                ];

                $user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&lang=ru&v=5.0"));

                $user_name = $user_info->response[0]->first_name;

                if($message == '/add') {
                    $request_params = array(
                        'message' => $messages[$message],
                        'user_id' => $user_id,
                        'access_token' => $token,
                        'v' => '5.0'
                    );
                } else {
                    $request_params = array(
                        'message' => "Привет, {$user_name}! Я пока отдыхаю, для поиска объявлений можешь воспользоваться сайтом http://airsoftzone.ru/index.php?r=site/vk",
                        'user_id' => $user_id,
                        'access_token' => $token,
                        'v' => '5.0'
                    );
                }

                $get_params = http_build_query($request_params);

                file_get_contents('https://api.vk.com/method/messages.send?'. $get_params);

                echo('ok');

                break;
        }
    }
}