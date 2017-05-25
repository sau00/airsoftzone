<?php

namespace app\modules\parsers\models;

use app\models\Categories;
use app\models\Cities;
use app\models\Users;

class AwgmModel extends \yii\base\Model
{
    public static function getPage($url)
    {
        $options = [
            'http' => [
                'method' => "GET",
                'header' => "Accept-language: en\r\n" .
                    "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n"
            ]
        ];

        $context = stream_context_create($options);

        return file_get_contents($url, false, $context);
    }

    public static function getCategory($url)
    {
        $category = explode('/', $url);

        $categories_list = [
            'parts-and-kit' => 'zapchasti',
            'weapons' => 'oruzhie',
            'ammunition' => 'snaryazhenie',
            'consumables' => 'rashodniki',
            'electronics' => 'elektronika',
        ];

        $subcategories_list = [
            'avtomaty' => 'shturmovie_vintovki',
        ];

        $category_id = null;

        $category_model = Categories::findOne(['alias' => $categories_list[$category[1]]]);
        if (isset($category_model->id)) {
            $category_id = $category_model->id;

            if (isset($subcategories_list[$category[2]]))
                $category[2] = $subcategories_list[$category[2]];

            $subcategory_model = Categories::findOne(['alias' => $category[2]]);
            if (isset($subcategory_model->id))
                $category_id = $subcategory_model->id;
        }

        return $category_id;
    }

    public static function getTitle($item_page)
    {
        preg_match_all('#<title>(.*)</title>#iSU', $item_page, $title);
        if (isset($title[1][0]))
            return trim(strip_tags($title[1][0]));
        else
            return null;
    }

    public static function getUser($item_page)
    {
        preg_match_all('#class=\'socserv-ico vk\' href="(.*)">#iSU', $item_page, $vk_url);
        if (isset($vk_url[1][0])) {
            $user_vk = VkModel::getUserData(preg_replace('#http://vk.com/#', '', $vk_url[1][0]));
            $user = Users::findOne(['vk' => $user_vk['response'][0]['uid']]);
            if (!isset($user)) {
                $user = new Users();
                $user->vk = $user_vk['response'][0]['uid'];
                $user->firstname = $user_vk['response'][0]['first_name'];
                $user->lastname = $user_vk['response'][0]['last_name'];
                $user->save();
            }

            return $user->id;
        } else
            return null;
    }

    public static function getDescription($item_page)
    {
        preg_match_all('#class="fields desc">(.*)</div>#isU', $item_page, $description);
        if (isset($description[1][0]))
            return trim(strip_tags($description[1][0]));
        else
            return null;
    }

    public static function getCity($item_page)
    {
        preg_match_all('#class="fields city list-set">(.*)</div>#isU', $item_page, $city);
        if (isset($city[1][0])) {
            $city = explode(':', $city[1][0]);
            $city_model = Cities::findOne(['alias' => strtolower(UtilsModel::rus2translit(trim(strip_tags($city[1]))))]);
            if (!isset($city_model)) {
                $city_model = new Cities();
                $city_model->name = trim(strip_tags($city[1]));
                $city_model->alias = strtolower(UtilsModel::rus2translit(trim(strip_tags($city[1]))));
                $city_model->save();
            }

            return $city_model->id;
        } else {
            return null;
        }
    }

    public static function getShippingStatus($item_page)
    {
        if (preg_match('#Отправка#', $item_page)) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function getPrice($item_page)
    {
        preg_match_all('#<div class="fields price ">(.*)<span>#isU', $item_page, $price);
        if (isset($price[1][0]))
            return intval(preg_replace('# #', '', $price[1][0]));
        else
            return null;
    }

    public static function getImages($item_page)
    {
        preg_match_all('#data-fancybox-group="gallery" href="(.*)"><img#isU', $item_page, $images);
        $images_array = [];
        if(isset($images[1][0])) {
            foreach ($images[1] as $key => $image_url) {
                $images_array[] = md5($image_url . time()) . '.jpg';
            }

            return [
                'source' => $images[1],
                'md5' => $images_array,
                'serialized' => serialize($images_array)
            ];
        } else {
            return [
                'source' => null,
                'md5' => null,
                'serialized' => null
            ];
        }
    }

    public static function getTime($item_page)
    {
        preg_match_all('#<h2>(.*)</h2>#isU', $item_page, $time);
        return date('Y-m-d H:i:s', strtotime(trim(strip_tags($time[1][0]))));
    }
}