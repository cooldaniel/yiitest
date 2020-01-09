<?php
class DController extends Controller
{
	public function actionIndex()
	{
		$this->testYiiCollectArData();
	}

	public function testYiiCollectArData()
    {
        $res = Country::model()->findAll();

        // 测试yii ar数据收集函数
        $data = [
            1,
            $res,
            [
                1,
                $res,
                [
                    1,
                    $res,
                    [],
                    range(1,10),
                ],
                [],
                    range(1,10),
            ],
            [],
            range(1,10),
        ];
        $res = \D::yiiCollectArData($data);
        \D::logc($data, $res);
    }
}
