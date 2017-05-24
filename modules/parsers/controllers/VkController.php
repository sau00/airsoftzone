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
        function rus2translit($string) {
            $converter = array(
                'а' => 'a',   'б' => 'b',   'в' => 'v',
                'г' => 'g',   'д' => 'd',   'е' => 'e',
                'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
                'и' => 'i',   'й' => 'y',   'к' => 'k',
                'л' => 'l',   'м' => 'm',   'н' => 'n',
                'о' => 'o',   'п' => 'p',   'р' => 'r',
                'с' => 's',   'т' => 't',   'у' => 'u',
                'ф' => 'f',   'х' => 'h',   'ц' => 'c',
                'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
                'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
                'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
                ' ' => ' ',   '&' => '_',

                'А' => 'A',   'Б' => 'B',   'В' => 'V',
                'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
                'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
                'И' => 'I',   'Й' => 'Y',   'К' => 'K',
                'Л' => 'L',   'М' => 'M',   'Н' => 'N',
                'О' => 'O',   'П' => 'P',   'Р' => 'R',
                'С' => 'S',   'Т' => 'T',   'У' => 'U',
                'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
                'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
                'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
                'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya'
            );
            return strtr($string, $converter);
        }

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
                    $vk_item->timestamp = $item['created'];

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

                    $vk_item->description = preg_replace("/[^A-Za-z0-9 ]/", '', rus2translit(trim(strip_tags($vk_item->description))));

                    if (!VkItems::findOne(['md5' => $vk_item->md5])) {
                        if (strlen($vk_item->description) > 10) {
                            $vk_item->save();
                        }
                    }
                }
            } else {
                print_r($response);
            }
        }
    }
}