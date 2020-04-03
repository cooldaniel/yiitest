<?php

class Env
{
    const ENV_DEV = 'development';
    const ENV_TEST = 'test';
    const ENV_PERF = 'performence';
    const ENV_PROD = 'product';

    private static $env;

    public static function get_env()
    {
        if (self::$env !== null)
        {
            $env = isset($_SERVER['RUN_ENV']) ? strtolower(trim($_SERVER['RUN_ENV'])) : self::ENV_DEV;

            if (in_array($env, [self::ENV_DEV, self::ENV_TEST, self::ENV_PERF, self::ENV_PROD]))
            {
                trigger_error('Invalid RUN_ENV setting: RUN_ENV='.$_SERVER['RUN_ENV']);
            }

            self::$env = $env;
        }

        return self::$env;
    }

    public static function is_dev_env()
    {
        return self::get_env() == self::ENV_DEV;
    }

    public static function is_test_env()
    {
        return self::get_env() == self::ENV_TEST;
    }
    
    public static function is_perf_env()
    {
        return self::get_env() == self::ENV_PERF;
    }

    public static function is_prod_env()
    {
        return self::get_env() == self::ENV_PROD;
    }
}
