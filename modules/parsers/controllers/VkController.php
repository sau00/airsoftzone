<?php

namespace app\modules\parsers\controllers;
use app\models\Items;
use \app\models\Users;
use app\models\VkItems;

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

    public function actionStart()
    {
//        $groups = [
//            '76629546' => 'СТРАЙКБОЛЬНАЯ БАРАХОЛКА | страйкбол',
//            '13212026' => 'Единая Страйкбольная Группа Страйкбол',
//            '45753674' => 'Страйкбол базар AIRSOFT4YOU'
//        ];

        $groups = [
            '76629546' => [
                '203426857'
            ],
            '13212026' => [
                '244826162'
            ],
            '45753674' => [
                '237603507'
            ]
        ];

        foreach ($groups as $group_key => $group_albums) {
            $method = 'photos.get';
            $parameters = [
                'owner_id' => '-' . $group_key,
                'album_id' => $group_albums[0],
                'count' => '1000',
                'rev' => '1'
            ];

            $url = 'https://api.vk.com/method/' . $method . '?' . http_build_query($parameters);

            $response = json_decode(file_get_contents($url), TRUE);

            if (isset($response['response'])) {
                foreach ($response['response'] as $key => $item) {
                    $vk_item = new VkItems();

                    $vk_item->photo = $item['src_big'];

                    $vk_item->description = $item['text'];

                    $vk_item->url = 'photo' . $item['owner_id'] . '_' . $item['pid'];
                    $vk_item->md5 = md5($vk_item->url);
                    $vk_item->author_id = $item['user_id'];
                    $vk_item->group_id = $group_key;


                    $method = 'photos.getComments';

                    $parameters = [
                        'owner_id' => $item['owner_id'],
                        'photo_id' => $item['pid'],
                        'access_token' => '701c2fea2814147e4eadc0e09af2a75884d6a6f2b2df97b391996a1bdb7b336283238fa43acfdb3250f8d'
                    ];

                    $comments_request_url = 'https://api.vk.com/method/' . $method . '?' . http_build_query($parameters);

                    $comments_response = json_decode(file_get_contents($comments_request_url), TRUE);

                    if (isset($comments_response['response'])) {
                        foreach ($comments_response['response'] as $comment_key => $comment) {
                            if ($comment['from_id'] == $item['user_id']) {
                                $vk_item->description .= $comment['message'];
                            }
                        }
                    }

                    mb_internal_encoding('UTF-8');
                    $vk_item->description = mb_convert_encoding(strip_tags($vk_item->description), 'UTF-8', 'UTF-8');

                    if (!VkItems::findOne(['md5' => $vk_item->md5])) {
                        if (strlen($vk_item->description) > 10) {
                            $vk_item->save(false);
                        }
                    }

                }
            } else {
                print_r($response);
            }
        }
    }
}