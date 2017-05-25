<?php

/**
 * Created by PhpStorm.
 * User: sau00
 * Date: 5/21/17
 * Time: 9:10 PM
 */

namespace yii\helpers;

class Html extends BaseHtml
{
    public static function displayDate($date)
    {
        $delta = strtotime($date) - strtotime(date('Y-m-d', time()));
        if($delta < 86400 && $delta > 0)
            return 'Сегодня ' . date('H:i', strtotime($date));
        else if($delta < 0 && abs($delta) < 86400)
            return 'Вчера ' . date('H:i', strtotime($date));
        else {
            $months = ['', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
            return date('d', strtotime($date)) . ' ' . $months[date('n', strtotime($date))] . ' ' . date('H:i', strtotime($date));
        }
    }
}