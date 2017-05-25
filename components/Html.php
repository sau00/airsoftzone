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
        $hours = '10800';
        $delta = strtotime($date) - strtotime(date('Y-m-d', time() + $hours));
        if($delta < 86400 && $delta > 0)
            return 'Сегодня ' . date('H:i', strtotime($date) + $hours);
        else if($delta < 0 && abs($delta) < 86400)
            return 'Вчера ' . date('H:i', strtotime($date) + $hours);
        else {
            $months = ['', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
            return date('d', strtotime($date) + $hours) . ' ' . $months[date('n', strtotime($date) + $hours)] . ' ' . date('H:i', strtotime($date) + $hours);
        }
    }
}