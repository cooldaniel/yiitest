<?php

trait Singleton {

    protected static $_instance;

    final public static function getInstance()
    {
        if (self::$_instance === null)
        {
            self::$_instance = new static();
        }

        return self::$_instance;
    }

    private function __construct()
    {
        $this->init();
    }

    protected function init()
    {

    }
}