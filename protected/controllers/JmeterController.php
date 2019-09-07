<?php
/**
 * Jmeter测试
 */
class JmeterController extends Controller
{
    public function actionIndex()
    {
        echo 'jmeter test';
    }

    public function formatMicrotime($microtime)
    {
        $parts = explode('.', $microtime);
        return date('H:i:s', $parts[0]) . ':' .$parts[1];
    }

    public function outputTime($startTime, $endTime)
    {
        $text = <<<EOD
{startTime}
{endTime}
EOD;
        $text = strtr($text, [
            '{startTime}' => $startTime,
            '{endTime}' => $endTime,
        ]);

        echo nl2br($text);
    }

    public function sleepTest($sleepTime)
    {
        $startTime = $this->formatMicrotime(microtime(true));
        sleep($sleepTime);
        $endTime = $this->formatMicrotime(microtime(true));
        $this->outputTime($startTime, $endTime);
    }

	public function actionApiSec3()
    {
        $this->sleepTest(3);
    }

    public function actionApiSec5()
    {
        $this->sleepTest(5);
    }

    public function actionApiSec10()
    {
        $this->sleepTest(10);
    }
}
