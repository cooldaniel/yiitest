<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/21 0021
 * Time: 下午 2:12
 */

use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{
    public function testSomething()
    {
        // 可选：如果愿意，在这里随便测试点什么。
        $this->assertTrue(true, 'wererwer。');

        // 在这里停止，并将此测试标记为未完成。
        $this->markTestIncomplete(
          'assadfsdafsdaf'
        );
    }
}