<?php
namespace helpers\weframework\components\date;

class Date
{
    /**
     * @param $date
     * @return string
     */
    public static function dateFormateBrToDefault($date)
    {
        $date = explode('/', $date);
        return $date[2] . '-' . $date[1] . '-'. $date[0];
    }

    /**
     * @param $date
     * @return bool|string
     */
    public static function dateFormatDefaultToBr($date)
    {
        return date('d/m/Y', strtotime($date));
    }
}