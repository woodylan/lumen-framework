<?php

namespace App\Module;

class Util
{
    public static function createUuid()
    {
        $originUuid = strtolower(str_replace('-', '', uuid_create()));
        return self::md5L16($originUuid);
    }

    public static function md5L16($str)
    {
        return substr(md5($str), 8, 16);
    }

    //驼峰命名改成下划线
    public static function snakeCaseArray($data, $recursion = true)
    {
        $arr = [];
        foreach ($data as $key => $val) {
            $key = snake_case($key);
            if ($recursion && is_array($val)) {
                $val = self::snakeCaseArray($val);
            }
            $arr[$key] = $val;

        }
        return $arr;
    }

    public static function httpGet($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $output = curl_exec($ch);
        return $output;
    }
}