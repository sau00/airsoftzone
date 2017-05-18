<?php

namespace app\modules\parsers\controllers;
use app\models\Items;
use \app\models\Users;

/**
 * Created by PhpStorm.
 * User: sau00
 * Date: 4/27/17
 * Time: 11:01 PM
 */
class VkController extends \yii\web\Controller
{
    public function actionTest()
    {

    }

    private function getUsername($id)
    {
        $method = 'users.get';
        $parameters = 'user_ids=' . $id;

        $url = 'https://api.vk.com/method/' . $method . '?' . $parameters;

        $response = json_decode(file_get_contents($url), TRUE);

        return $response['response'][0]['first_name'];
    }

    public function actionStart()
    {
        $method = 'photos.get';
        $parameters = 'owner_id=-13212026&album_id=244269681&count=10&rev=1';

        $url = 'https://api.vk.com/method/' . $method . '?' . $parameters;

        $response = json_decode(file_get_contents($url), TRUE);

        foreach ($response['response'] as $key => $item) {
            if($item['text']) {
                echo '<pre>';

                $user = Users::findOne(['vk' => $item['user_id']]);
                if(!$user)
                    $user = new Users();

                $user->vk = strval($item['user_id']);
                $user->name = $this->getUsername($item['user_id']);
                if(!$user->save()) echo 'Error!'; else echo $user->id;

                print_r($item);

                $itemAr = Items::findOne(['vkpidaid' => md5($item['pid'] . $item['aid'])]);
                if(!$itemAr)
                    $itemAr = new Items();
                $itemAr->user_id = $user->id;
                $itemAr->title = substr($item['text'], 0, 32);
                $itemAr->description = $item['text'];
                $itemAr->vk_image = $item['src_big'];
                $itemAr->vkpidaid = md5($item['pid'] . $item['aid']);
                if(!$itemAr->save()) echo 'Error!';
                echo '</pre>';
            }
        }
    }
}