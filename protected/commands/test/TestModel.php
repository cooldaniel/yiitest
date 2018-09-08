<?php
/**
 * 配合TestCommand.php定义测试用的model.
 */
class TestModel
{
    protected $testData = [];

	public function getTestData()
    {
        return $this->testData;
    }
}
