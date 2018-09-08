<?php

/**
 * @package application.controllers
 */
class JoinController extends Controller
{
	public function actionIndex()
	{
		$model=new JoinForm();
        $user = Yii::app()->user;

        // Get the last data from the session to show again
        if ($user->hasState('joindata')) {
			$model->attributes = $user->getState('joindata');
		}

		// Process the post data
		if(isset($_POST['JoinForm'])) {
			$model->attributes=$_POST['JoinForm'];

            // Make sure that validating the format before using
			if($model->validate()) {

                // Join
                $res = $this->join($_POST['JoinForm']['list']);

                // Keep the result prompt and data for the next request showing.
                $user->setState('joindata', $res);
                $user->setFlash('operationSucceeded', 'Operation Succeeded');

                // Refresh the page to discard the post operation
                $this->refresh();
			}
		}

		$this->render('index',array('model'=>$model));
	}

    /**
     * Join the input string into an output string.
     * @param string $data The input string.
     * @return array
     */
	public function join($data)
    {
        // make output
        $lines = explode("\r\n", trim($data));
        $totalCount = count($lines);
        $emptyCount = 0;
        foreach ($lines as $index => $line) {

            // filter empty item
            $line = trim($line);
            $line = trim($line, ",");
            if ($line == '') {
                $emptyCount++;
                unset($lines[$index]);
                continue;
            }

            $lines[$index] = $line;
        }

        // 包含重复项时的数量
        $repeatableCount = count($lines);

        // 去重
        $lines = array_unique($lines);

        // 去重后数量
        $activeCount = count($lines);

        // 空字符串数量
        $emptyCount = $totalCount - $repeatableCount;

        // 重复的数量
        $repeatCount = $repeatableCount - $activeCount;

        // 输出结果
        $output = "'" . implode("','", $lines) . "'";

        return [
            'list' => $data,
            'output' => $output,
            'totalCount' => $totalCount,
            'activeCount' => $activeCount,
            'emptyCount' => $emptyCount,
            'repeatCount' => $repeatCount,
        ];
    }
}























