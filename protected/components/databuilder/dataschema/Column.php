<?php

//namespace app\components\databuilder\dataschema;

class Column
{
    const TYPE_STRING = 1;
    const TYPE_INT = 2;
    const TYPE_FLOAT = 3;
    const TYPE_ENUM = 4;
    const TYPE_BOOL = 5;
    const TYPE_NULL = 6;

    public $name;
    public $type;
    public $min;
    public $max;
    public $value;

    private static $instance;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}