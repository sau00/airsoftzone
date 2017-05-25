<?php
/**
 * Created by PhpStorm.
 * User: sau00
 * Date: 5/17/17
 * Time: 8:06 PM
 */

namespace app\modules\parsers\models;


use yii\base\Model;

class VkModel extends Model
{
    public static function getUserData($id) {
        $method = 'users.get';
        $parameters = [
            'user_ids' => $id,
            'lang' => 0
        ];

        return self::getResponse($method, $parameters);
    }

    public static function getResponse($method, $parameters)
    {
        $url = 'https://api.vk.com/method/' . $method . '?' . http_build_query($parameters);
        return json_decode(file_get_contents($url), TRUE);
    }
}