<?php
namespace application\helpers;

/**
 * Class String
 * @package application\helpers
 */
class String {
    /**
     * returns string with leading zeros
     * @param $str
     * @param int $count
     * @return string
     */
    public static function leadZero($str, $count = 5)
    {
        $str = (string)$str;
        $len = $count - mb_strlen($str);
        for ($i=0; $i < $len; $i++) {
            $str = "0" . $str;
        }
        return $str;
    }
}