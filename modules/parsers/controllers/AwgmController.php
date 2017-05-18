<?php

namespace app\modules\parsers\controllers;

use app\models\Items;
use \app\models\Users;
use app\modules\parsers\models\AwgmModel;

/**
 * Created by PhpStorm.
 * User: sau00
 * Date: 4/27/17
 * Time: 11:01 PM
 */
class AwgmController extends \yii\web\Controller
{
    public function actionStart()
    {
        set_time_limit(0);

        for ($i = 1; $i <= 10; $i++) {
            $url = 'http://awgm.ru/ajax_handler.php?AJAX=Y&NAME=PAGEN_1&PAGE_NUM=1&TYPE=get_list_sell_main&PAGEN_1=' . $i;

            $ajax_page = AwgmModel::getPage($url);

            // Parsing links
            preg_match_all('#<a href="/(.*)"><img src="#iSU', $ajax_page, $urls);

            foreach ($urls[1] as $item_url) {
                $item_page = AwgmModel::getPage('http://awgm.ru/' . $item_url);

                sleep(1);

                $item = new Items();

                $item->user_id = AwgmModel::getUser($item_page);
                if (is_null($item->user_id))
                    continue;

                $item->category_id = AwgmModel::getCategory($item_url);
                if (is_null($item->category_id))
                    continue;

                $item->city_id = AwgmModel::getCity($item_page);
                if (is_null($item->city_id))
                    continue;

                $item->title = AwgmModel::getTitle($item_page);
                if (is_null($item->title))
                    continue;

                $item->price = AwgmModel::getPrice($item_page);
                if (is_null($item->price))
                    continue;

                $images = AwgmModel::getImages($item_page);
                if (is_null($images['serialized']))
                    continue;

                $item->description = AwgmModel::getDescription($item_page);
                $item->shipping = AwgmModel::getShippingStatus($item_page);
                $item->time = AwgmModel::getTime($item_page);
                $item->images = $images['serialized'];

                if(!Items::findOne(['user_id' => $item->user_id, 'category_id' => $item->category_id, 'title' => $item->title])) {
                    if ($item->save()) {
                        if (!is_dir($_SERVER['DOCUMENT_ROOT'] . '/uploads/items/' . $item->id)) {
                            mkdir($_SERVER['DOCUMENT_ROOT'] . '/uploads/items/' . $item->id);
                        }

                        echo $item->title . '<br />';

                        foreach ($images['source'] as $key => $image_url) {
                            file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/uploads/items/' . $item->id . '/' . $images['md5'][$key], file_get_contents('http://awgm.ru' . $image_url));
                        }
                    }
                }
            }
        }
    }
}