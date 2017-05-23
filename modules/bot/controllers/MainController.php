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

//Строка для подтверждения адреса сервера из настроек Callback API
        $confirmation_token = 'cd743aa7';

//Ключ доступа сообщества
        $token = '630aa6da5928b5da9977d64d44b8040f83e366b3bea1cc03872bfff8432fb2c5114022312da80a6ba41b5';

//Получаем и декодируем уведомление
        $data = json_decode(file_get_contents('php://input'));

//Проверяем, что находится в поле "type"
        switch ($data->type) {
            //Если это уведомление для подтверждения адреса сервера...
            case 'confirmation':
                //...отправляем строку для подтверждения адреса
                echo $confirmation_token;
                break;

//Если это уведомление о новом сообщении...
            case 'message_new':
                //...получаем id его автора
                $user_id = $data->object->user_id;
                //затем с помощью users.get получаем данные об авторе
                $user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&v=5.0"));

//и извлекаем из ответа его имя
                $user_name = $user_info->response[0]->first_name;

//С помощью messages.send и токена сообщества отправляем ответное сообщение
                $request_params = array(
                    'message' => "Привет, {$user_name}!",
                    'user_id' => $user_id,
                    'access_token' => $token,
                    'v' => '5.0'
                );

                $get_params = http_build_query($request_params);

                file_get_contents('https://api.vk.com/method/messages.send?'. $get_params);

//Возвращаем "ok" серверу Callback API
                echo('ok');

                break;
        }
    }
}