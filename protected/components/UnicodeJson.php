<?php

/**
 * Class UnicodeJson
 *
 * 封装PHP的json函数，提供unicode参数.
 */
class UnicodeJson
{
    public static function json_encode($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public static function json_decode($data)
    {
        return json_decode($data, true);
    }
}