<?php

namespace app\modules\parsers\controllers;
use app\models\Items;
use \app\models\Users;
use app\models\VkGroups;
use app\models\VkItems;
use app\modules\parsers\models\UtilsModel;
use app\modules\parsers\models\VkModel;

/**
 * Created by PhpStorm.
 * User: sau00
 * Date: 4/27/17
 * Time: 11:01 PM
 */
class VkController extends \yii\web\Controller
{
    // Добавляет группы в БД
    public function actionInit()
    {
        $groups = [
            [
                'group_id' => '13212026',
                'albums' => [
                    '244826162' => 'w', //weapon
                    '244826144' => 'e', //equipment
                    '244826183' => 'g' //gear
                ],
                'name' => 'Единая Страйкбольная Группа Страйкбол'
            ],
            [
                'group_id' => '11571122',
                'albums' => [
                    '229924509' => 'w', //weapon
                    '229924632' => 'e', //equipment
                    '229924703' => 'g' //gear
                ],
                'name' => 'Страйкбол'
            ],
            [
                'group_id' => '27239071',
                'albums' => [
                    '236939434' => 'w', //weapon
                    '236939314' => 'e', //equipment
                    '236939488' => 'g' //gear
                ],
                'name' => 'AIRSOFT4YOU (Страйкбол I Airsoft)'
            ],
            [
                'group_id' => '76629546',
                'albums' => [
                    '203426857' => 'w', //weapon
                    '203426992' => 'e', //equipment
                    '203426935' => 'g' //gear
                ],
                'name' => 'СТРАЙКБОЛЬНАЯ БАРАХОЛКА | страйкбол'
            ],
        ];

        foreach($groups as $group) {
            if(VkGroups::findOne(['group_id' => $group['group_id']])) {
                $vk_group = VkGroups::findOne(['group_id' => $group['group_id']]);
            } else {
                $vk_group = new VkGroups();
            }

            $vk_group->group_id = $group['group_id'];
            $vk_group->albums = serialize($group['albums']);
            $vk_group->name = $group['name'];
            $vk_group->save();

            echo $group['name'] . '<br />';
        }
    }

    public function actionStart()
    {
        $groups = VkGroups::find()->all();

        foreach($groups as $group) {
            $albums = unserialize($group->albums);
            foreach($albums as $album_id => $album_type) {
                $method = 'photos.get';
                $parameters = [
                    'owner_id' => '-' . $group->group_id,
                    'album_id' => $album_id,
                    'count' => '5',
                    'rev' => '1'
                ];

                $response = VkModel::getResponse($method, $parameters);

                if (isset($response['response'])) {
                    foreach ($response['response'] as $key => $item) {

                        if(Users::findOne(['vk' => $item['user_id']])) {
                            $user = Users::findOne(['vk' => $item['user_id']]);
                        } else {
                            $user = new Users();
                            $user_vk = VkModel::getUserData($item['user_id']);

                            $user->vk = $item['user_id'];
                            $user->firstname = $user_vk['response'][0]['first_name'];
                            $user->lastname = $user_vk['response'][0]['last_name'];
                            $user->save();
                        }

                        $vk_item = new VkItems();
                        $vk_item->user_id = $user->id;
                        $vk_item->group_id = $group->group_id;
                        $vk_item->category = $album_type;
                        $vk_item->url = 'photo' . $item['owner_id'] . '_' . $item['pid'];
                        $vk_item->photo = $item['src_big'];
                        $vk_item->description = $item['text'];
                        $vk_item->timestamp = $item['created'];
                        $vk_item->hash = md5(file_get_contents($item['src_small']));

                        $method = 'photos.getComments';
                        $parameters = [
                            'owner_id' => $item['owner_id'],
                            'photo_id' => $item['pid'],
                            'access_token' => '547ddeb0f7ce109ad82861ca2546b6b0ce7b01fc7dff99406071d286eefb7467abb01040dc6e66b055902'
                        ];

                        $comments_response = VkModel::getResponse($method, $parameters);

                        if (isset($comments_response['response'])) {
                            foreach ($comments_response['response'] as $comment_key => $comment) {
                                if ($comment['from_id'] == $item['user_id']) {
                                    $vk_item->description .= $comment['message'];
                                }
                            }
                        }

                        $vk_item->description = preg_replace("/[^A-Za-z0-9 ]/", '',
                            strtolower(UtilsModel::rus2translit(trim(strip_tags($vk_item->description)))));

                        if (!VkItems::findOne(['hash' => $vk_item->hash])) {
                            if (strlen($vk_item->description) > 10)
                                $vk_item->save();

                            echo $vk_item->hash . '<br />';
                        }
                    }
                } else {
                    print_r($response);
                }
            }
        }
    }
}