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
            'lang' => 'ru'
        ];

        return self::getResponse($method, $parameters);
    }

    public static function getResponse($method, $parameters)
    {
        $url = 'https://api.vk.com/method/' . $method . '?' . http_build_query($parameters);
        return json_decode(file_get_contents($url), TRUE);
    }

    public static function getPhotoDescription($vk_item, $group)
    {
        $albums = unserialize($group->albums);

        foreach($albums as $key => $album) {
            if($album == $vk_item->category) {
                $album_id = $key;
            }
        }

        if(!$vk_item->description_raw) {
            $photo = explode('-', $vk_item->url)[1];
            $photo_id = explode('_', $photo)[1];

            $method = 'photos.getById';
            $parameters = [
                'photos' => '-' . $photo,
                'access_token' => '547ddeb0f7ce109ad82861ca2546b6b0ce7b01fc7dff99406071d286eefb7467abb01040dc6e66b055902'
            ];

            $item = self::getResponse($method, $parameters);

            if(isset($item['response'])) {
                if(isset($item['response'][0])) {

                    $method = 'photos.getComments';
                    $parameters = [
                        'owner_id' => '-' . $group->group_id,
                        'photo_id' => $photo_id,
                        'access_token' => '547ddeb0f7ce109ad82861ca2546b6b0ce7b01fc7dff99406071d286eefb7467abb01040dc6e66b055902'
                    ];

                    $comments_response = VkModel::getResponse($method, $parameters);

                    $vk_item->description_raw = $item['response'][0]['text'];

                    if (isset($comments_response['response'])) {
                        foreach ($comments_response['response'] as $comment_key => $comment) {
                            if ($comment['from_id'] == $item['response'][0]['user_id']) {
                                $vk_item->description_raw .= $comment['message'];
                            }
                        }
                    }

                    $vk_item->save();

                    return $vk_item;
                }
            }
        }
    }
}