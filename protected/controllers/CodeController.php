<?php

/**
 * @package application.controllers
 */
class CodeController extends Controller
{
	/**
	 * 根据卡号生成卡号验证码.
	 */
	public function actionIndex()
	{
		$model=new CodeForm;
		$user = Yii::app()->user;

        // Get the last data from the session to show again
        if ($user->hasState('codedata')) {
			$model->attributes = $user->getState('codedata');
		}

		// Process the post data
		if(isset($_POST['CodeForm']))
		{
			$model->attributes=$_POST['CodeForm'];
			if($model->validate())
			{
				$cardNumList = trim($_POST['CodeForm']['cardNumList']);
				if (trim($cardNumList) != '')
				{
					$res = $this->generateCardValidateCodeList($cardNumList);
					$user->setState('codedata', $res);
					$user->setFlash('operationSucceeded', 'Operation Succeeded');
					$this->refresh();
				}
			}
		}
		$this->render('index',array('model'=>$model));
	}

	private function generateCardValidateCodeList($cardNumList)
	{
		$codeList = array();
		$codeListWithCard = array();
		$codeErrors = '';

		$cardNumList = explode("\n", $cardNumList);
		foreach ($cardNumList as $index => $card_num)
		{
			$card_num = trim($card_num);

			// 卡号长度不对
			if (strlen($card_num) != 11)
			{
				$codeErrors .= '第 ' . ($index + 1) . ' 行卡号 ' . $card_num . ' 长度不对<br/>';
			}

			// 生成卡密
			$code = $this->generateCardValidateCode($card_num);
			$codeList[] = $code;
			$codeListWithCard[] = $card_num . '    ' . $code;
			$cardNumList[$index] = $card_num; // 去除卡两端空白
		}

		return array(
			'codeList' => implode("\n", $codeList),
			'codeListWithCard' => implode("\n", $codeListWithCard),
			'cardNumList' => implode("\n", $cardNumList),
			'codeErrors' => $codeErrors,
		);
	}

	/**
	 * 生成卡号验证码.
	 * @param int $card_num 整数卡号
	 * @return int 返回生成的4位卡号验证码数字.
	 */
	private function generateCardValidateCode($card_num)
	{
		$pre_code_list = array(
			0 => '3205',
			1 => '4369',
			2 => '7425',
			3 => '1753',
			4 => '2531',
			5 => '3812',
			6 => '5104',
			7 => '6239',
			8 => '2897',
			9 => '5372',
		);
		$last_one = substr($card_num, -1);

		$pre_code = isset($pre_code_list[$last_one]) ? $pre_code_list[$last_one] : $pre_code_list[0];
		return substr((fmod(fmod((float)$card_num, 100000) * 6390, $pre_code) + $pre_code), -4);
	}
}























