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
    // Позднее надо будет переписать, чтобы брало данные с VK api
    public static function getVkUserData($user_link) {
        $user_id = array_reverse(explode('/', $user_link));
        return $user_id[0];
    }
}