<?php
/**
 * 性能测试.
 * @package application.controllers
 *
 * 备注：
 * 可以用index测试网络和框架，其它可以用for循环测试.
 */
class PerformanceController extends Controller
{
    public function actionIndex()
    {
        echo rand();
    }

    public function actionRedis()
    {
        $redis_helper = new RedisHelper();
        $redis = $redis_helper->get_connection();

        foreach (range(0, 100) as $item)
        {
            $key = 'redis-'.$item;
            $value = $item;
            $redis->set($key, $value, 5);
        }

        foreach (range(0, 100) as $item)
        {
            $key = 'redis-'.$item;
            $value = $redis->get($key);
            \D::pds($value);
        }

        \D::done();
    }

    public function actionMongodb()
    {

    }

    public function actionSql()
    {

    }

    public function actionDao()
    {

    }

    public function actionAr()
    {

    }
}