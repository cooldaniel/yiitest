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
	 * 首页显示选中的站点url列表.完整的url列表见{@see actionSelect}方法，而且在这里可以修改选中的站点url列表.
	 */
	public function actionIndex()
	{
        // 获取数据
        $siteListHelper = new SiteListHelper();
        $checkedList = $siteListHelper->getCheckedList();
        $data = $siteListHelper->getSiteUrlList($checkedList);

        // 首页只显示选中项
        $siteListHelper->filterUncheckedList($data);

        $this->render('index', array(
            'data'=>$data,
            'showForm'=>false,
        ));
	}

    /**
     * 修改站点配置列表选中状态.
     */
    public function actionSelect()
    {
        // 获取数据
        $siteListHelper = new SiteListHelper();
        $checkedList = $siteListHelper->getCheckedList();
        $data = $siteListHelper->getSiteUrlList($checkedList);

        // 提交表单
        $form = $_POST['form'] ?? null;
        if ($form) {
            $checkedList = $form['checked_list'] ?? null;
            if ($checkedList) {

                // 保存表单
                $siteListHelper->saveCheckedList($checkedList);

                // 跳转到首页，避免刷新时提示是否提交表单
                $this->redirect($this->createUrl('site/index'));
            }
        }

        // 选择页显示所有项目
        $this->render('index', array(
			'data'=>$data,
            'showForm'=>true,
		));
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
	
	public function getUser()
	{
		return array(
			'id'=>'100',
			'username'=>'13425163196',
			'password'=>md5(123456),
		);
	}
	
	public function actionLoginFirst()
	{
		$password = '123456';
		$username = '13425163196';
		$rememberMe = true;
		
		$user = $this->getUser();
		$login = (md5($password) == $user['password']) && ($username == $user['username']);
		if ($login)
		{
			setcookie();
		}
	}
	
	public function actionAutoLogin()
	{
		$salt = 'abc123';
		
		$username = '13425163196';
		$password_hash = md5($password);
		$password_hash_part = substr($password_hash, 0, 6);
		
		$uid = md5('my id');
		$value = $username;
		$value = time() + 3600;
		
		$value = hash('ripemd160', $username . $expires . $password_hash_part . $salt);
	}
	
	// 生成API中心随机账号
	public function actionApicenterAccount()
	{
		$string = md5(mt_rand() . md5(mt_rand() . microtime()));
		$appid = 'ac' . substr($string, 0, 18);
		$appsecret = md5($string . mt_rand());
		D::pd(array('appid'=>$appid, 'appsecret'=>$appsecret));
	}
	
	public function actionBrowser()
	{
		D::pd($this->getBrowser());
		D::pd($this->getBrowserVer());
		D::pd($_SERVER["HTTP_USER_AGENT"]);
	}

	public function getBrowser(){
		$agent=$_SERVER["HTTP_USER_AGENT"];
		if(strpos($agent,'MSIE')!==false || strpos($agent,'rv:11.0')) //ie11判断
		return "ie";
		else if(strpos($agent,'Firefox')!==false)
		return "firefox";
		else if(strpos($agent,'Chrome')!==false)
		return "chrome";
		else if(strpos($agent,'Opera')!==false)
		return 'opera';
		else if((strpos($agent,'Chrome')==false)&&strpos($agent,'Safari')!==false)
		return 'safari';
		else
		return 'unknown';
	}
	 
	public function getBrowserVer(){
		if (empty($_SERVER['HTTP_USER_AGENT'])){    //当浏览器没有发送访问者的信息的时候
			return 'unknow';
		}
		$agent= $_SERVER['HTTP_USER_AGENT'];   
		if (preg_match('/MSIE\s(\d+)\..*/i', $agent, $regs))
			return $regs[1];
		elseif (preg_match('/FireFox\/(\d+)\..*/i', $agent, $regs))
			return $regs[1];
		elseif (preg_match('/Opera[\s|\/](\d+)\..*/i', $agent, $regs))
			return $regs[1];
		elseif (preg_match('/Chrome\/(\d+)\..*/i', $agent, $regs))
			return $regs[1];
		elseif ((strpos($agent,'Chrome')==false)&&preg_match('/Safari\/(\d+)\..*$/i', $agent, $regs))
			return $regs[1];
		else
			return 'unknow';
	}

	public function actionXdebug()
	{
		$t = xdebug_time_index();
		D::fp();

		$string = 'ccc';

		$d = array('aaa');
		for ($i=0; $i<10; $i++)
		{
			$d = array_merge($d, $d);
			D::pd($d);
		}

		//$this->test($d);

		D::fp();
		D::pd(xdebug_call_class());
	}

	// 超过最大内存时直接空白，register_shutdown_function()注册的函数也不会被调用
	public function actionUsage()
	{
		@ini_set('memory_limit', '200M');
		$table = 'goods';

		D::usage();

		$sql = "SELECT * FROM " . $table;
		$d = Yii::app()->db->createCommand($sql)->queryAll();
		for ($i=0; $i<13; $i++)
			$d = array_merge($d, $d);

		D::usage();

		$sql = "SELECT COUNT(*) FROM " . $table;
		D::pd(Yii::app()->db->createCommand($sql)->queryColumn(), count($d));


		D::bk();


		$rows = $d;

		$objPHPExcel = new PHPExcel();

		// 列宽
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);

		$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);

		// 取第一个工作表
		$objPHPExcel->setActiveSheetIndex(0);

		// 表头
		$objPHPExcel->getActiveSheet()
					->setCellValue('A1', 'one')
					->setCellValue('B1', 'two')
					->setCellValue('C1', 'three');
		// 表头样式
		$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->applyFromArray(array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
		));

		// 内容
		for ($i = 0, $len = count($rows); $i < $len; $i++) {
			$row_num = ($i + 2);
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $row_num, $rows[$i]['gName']);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $row_num, $rows[$i]['gKeywords']);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $row_num, $rows[$i]['gDesc']);
		}
		// 内容样式
		$objPHPExcel->getActiveSheet()->getStyle('B2:C'.($len + 1))->applyFromArray(array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
		));

		// 表名
		$objPHPExcel->getActiveSheet()->setTitle('一级机构统计总表');

		D::usage();

		D::bk();

		// 输出
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="一级机构统计总表' . date('YmdHis') . '.xls"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}

	public function actionTmp()
    {
        $this->render('tmp');
    }
    
    public function actionCache()
    {
        $disable = getQuery('disable');

        $fresh = false;
        if ($fresh){
            $content = json_encode(['rand'=>rand(), JSON_UNESCAPED_UNICODE]);
        }else{
            $content = 'ddd';
        }
        $etag = md5($content);

        if ($disable){
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
            header("Cache-Control: no-cache, must-revalidate");
            header("Pragma: no-cache");
        }else{
            $last = strtotime('2017-12-15');
            $interval = 30 * 24 * 60 * 60;
            header ("Last-Modified: " . gmdate ('r', $last));
            header ("Expires: " . gmdate ("r", ($last + $interval)));
            header ("Cache-Control: max-age=$interval");
            header ("Pragma: max-age=$interval");
            header ("Etag: {$etag}");
        }

        $http_equiv = [
            ["Last-Modified", gmdate ('r', $last)],
            ["Expires", gmdate ("r", ($last + $interval))],
            ["Cache-Control", "max-age=$interval"],
            ["Pragma", "max-age=$interval"],
            ["Etag", $etag],
        ];

        $html = '';
        foreach ($http_equiv as $row){
            $html .= '<meta http_equiv="'.$row[0].'" content="'.$row[1].'">'."\n";
        }
        echo $html;

        echo $content;
    }

    public function actionExtractphar()
    {
        $phar = Yii::app()->request->getQuery('phar');
        $saveto = Yii::app()->request->getQuery('saveto');
        $overwrite = (bool)Yii::app()->request->getQuery('overwrite');

        if (empty($phar) || empty($saveto)) {
            echo '必须指定phar和saveto参数';
            exit();
        }

        if (!file_exists($phar)) {
            echo "phar文件 {$phar} 不存在";
            exit();
        }

        if (!file_exists($saveto)) {
            echo "保存目录 {$saveto} 不存在";
            exit();
        }

        if (!is_dir($saveto)) {
            echo "保存目录 {$saveto} 不是一个目录";
            exit;
        }

        if (!is_writeable($saveto)) {
            echo "保存目录 {$saveto} 没有写权限";
            exit;
        }

        echo 'Starting to extract the phar file: '.$phar;

        $phar = new Phar($phar);
        $phar->extractTo($saveto, null, $overwrite);

        echo '<br/>';
        echo 'Done!';
    }

    public function actionUrlEncode()
    {
        $url = Yii::app()->request->getParam('url');
        echo urlencode($url);
    }

    public function actionUrlDecode()
    {
        $url = Yii::app()->request->getParam('url');
        echo urldecode($url);
    }
    
    public function actionHello()
    {
        echo "yiitest says hello-".rand();
    }
}
