<?php

/**
 * @package application.controllers
 */
class SiteController extends Controller
{	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// 测试行为和事件机制
		// new BehaviorHost;
		// new Event;
		
		//throw new CHttpException('test http', 403);
		//throw new Exception('test');
		//D::pd($d);
		//require __DIR__ . 'daniel.txt';
		
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{	
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page.
	 * 如果已登录就跳转到首页.
	 */
	public function actionLogin()
	{
		if(Yii::app()->getUser()->getIsGuest())
		{
			$model=new LoginForm;
	
			// if it is ajax validation request
			if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
	
			// collect user input data
			if(isset($_POST['LoginForm']))
			{
				$model->attributes=$_POST['LoginForm'];
				// validate user input and redirect to the previous page if valid
				if($model->validate() && $model->login())
					$this->redirect(Yii::app()->user->returnUrl);
			}
			// display the login form
			$this->render('login',array('model'=>$model));
		}
		else
		{
			$this->redirect(Yii::app()->getHomeUrl());
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionPhpinfo()
	{
		var_dump(Yii::getVersion());
		phpinfo();
	}
	
	/**
	 * Catch all request for maintaince.
	 */
	public function actionMaintain()
	{
		echo 'Catch all request for maintaince.';
	}
	
	public function actionPressureTest()
	{
		// IO pressure test
		$content = str_repeat('a', 1024*1024);
		$file = $_SERVER['DOCUMENT_ROOT'].'/IOPressureTest.txt';
		file_put_contents($file, $content);
		
		foreach(range(1,10) as $item)
		{
			$content = file_get_contents($file);
			file_put_contents($file, $content);
		}
	}
	
	public function actionYiiLogTest()
	{
		
		
		
		
		$this->render('yiilogtest');
	}
	
	public function actionDataAuto()
	{
		D::bk();
		
		$sql = "INSERT INTO ecs_goods VALUES(
NULL, 100, 100, 'GD-MULTIDANIEL', 'Test goods which takes GD-MULTIDANIEL as goods sn.', '<span style=\"color:red;\"></span>', 500, 100, 60000, 10, 1200, 1000, 900, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()+2592000,
100, 'images/2014/goods_thumb/GD-MULTIDANIEL-1.png', 'images/2014/goods_img/GD-MULTIDANIEL-1.png', 'images/2014/original_img/GD-MULTIDANIEL-1.png', 1, 'common', 1, 1, 100, UNIX_TIMESTAMP(), 0, 
0, 1, 1, 1, 1, 1, 0, 1, 150, UNIX_TIMESTAMP(), 100, 'Test goods', -1, -1, 3, 4, 5, 10, '900~1200', 1, UNIX_TIMESTAMP(), 100, UNIX_TIMESTAMP(), 1, 100, 50000, 1, 'lowest_price_data', 'highest_price_data', 1
);";
		for ($i=0; $i<30000; $i++)
		{
			$c = Yii::app()->db->createCommand($sql);
			$c->query();
		}
		
		$sql = "SELECT COUNT(*) FROM ecs_goods";
		$c = Yii::app()->db->createCommand($sql);
		$n = $c->queryRow();
		
		$this->refresh();
		
		D::pde($n);
	}
	
	/**
	 * 根据卡号生成卡号验证码.
	 */
	public function actionCode()
	{
		$model=new CodeForm;
		$operationSucceeded = '';
		
		$user = Yii::app()->user;
		if ($user->hasState('cardNumList'))
		{
			$model->cardNumList = $user->getState('cardNumList');
		}
		if ($user->hasState('codeList'))
		{
			$model->codeList = $user->getState('codeList');
		}
		if ($user->hasState('codeListWithCard'))
		{
			$model->codeListWithCard = $user->getState('codeListWithCard');
		}
		if ($user->hasState('codeErrors'))
		{
			$model->codeErrors = $user->getState('codeErrors');
		}
		if ($user->hasFlash('operationSucceeded'))
		{
			$operationSucceeded = $user->getFlash('operationSucceeded');
		}
		
		if(isset($_POST['CodeForm']))
		{
			$model->attributes=$_POST['CodeForm'];
			if($model->validate())
			{
				$cardNumList = trim($_POST['CodeForm']['cardNumList']);
				if (trim($cardNumList) != '')
				{
					$res = $this->generateCardValidateCodeList($cardNumList);
					$user->setState('cardNumList', $res['cardNumList']);
					$user->setState('codeList', $res['codeList']);
					$user->setState('codeListWithCard', $res['codeListWithCard']);
					$user->setState('codeErrors', $res['codeErrors']);
					$user->setFlash('operationSucceeded', 'Operation Succeeded');
					$this->refresh();
				}
			}
		}
		$this->render('code',array('model'=>$model, 'operationSucceeded'=>$operationSucceeded));
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
			'0' => '3205',
			'1' => '4369',
			'2' => '7425',
			'3' => '1753',
			'4' => '2531',
			'5' => '3812',
			'6' => '5104',
			'7' => '6239',
			'8' => '2897',
			'9' => '5372',
		);
		$last_one = substr($card_num, -1);
		$pre_code = $pre_code_list[$last_one];
		return substr((fmod(fmod($card_num, 100000) * 6390, $pre_code) + $pre_code), -4);
	}
}