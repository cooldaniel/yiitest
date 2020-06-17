<?php

function process_level($data)
{
    if (empty($data))
    {
        return $data;
    }

    $res = [];

    // 第一行第一项键名做字段名
    $field_name = array_keys($data[0])[0];

    // 遍历每一行数据
    foreach ($data as $item)
    {
        // 从结果集里找当前项
        $found_key = null;

        foreach ($res as $res_key => $res_item)
        {
            if ($res_item[$field_name] == $item[$field_name])
            {
                $found_key = $res_key;
                break;
            }
        }

        // 是否找到
        if ($found_key === null)
        {
            // 没找到就在结果集里添加当前项
            $res[] = [
                $field_name=>$item[$field_name],
                'child'=>[array_slice($item, 1)],
            ];
        }
        else
        {
            // 找到了就往结果集里当前项的child添加
            $res[$found_key]['child'][] = array_slice($item, 1);
        }
    }

    // 遍历结果集，递归处理child
    foreach ($res as $res_key => $res_item)
    {
        // child大于1表示还有层级需要递归处理
        if (count($res_item['child']) > 1)
        {
            $res[$res_key]['child'] = process_level($res_item['child']);
        }
    }

    return $res;
}

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
        //$siteListHelper->filterUncheckedList($data);

        $this->render('index', array(
            'data'=>$data,
            'showForm'=>false,
        ));
    }

    public function actionUrl()
    {
        $data = [];

        $orderCountStartTime = '2019-07-16';
        $orderCountStartTime = '2019-01-01';
        $orderCountEndTime = date('Y-m-d', time());

        $id = ArrayHelper::getBetweenDaysInterval($orderCountStartTime, $orderCountEndTime, 15);
        foreach ($id as $item)
        {
            $url_1 = 'http://www.erp.local/services/yunyi/yunyiproduct/wishcount?date='.$item;
            $url_2 = 'http://192.168.71.38/services/yunyi/yunyiproduct/wishcount?date='.$item;
            $url_3 = 'http://publish.delaman168.com/services/yunyi/yunyiproduct/wishcount?date='.$item;

            $data['wish订单统计'][$item] = [$url_1, $url_2, $url_3];
        }

        foreach ($id as $item)
        {
            $url_1 = 'http://www.erp.local/services/yunyi/yunyiproduct/lazadacount?date='.$item;
            $url_2 = 'http://192.168.71.38/services/yunyi/yunyiproduct/lazadacount?date='.$item;
            $url_3 = 'http://publish.delaman168.com/services/yunyi/yunyiproduct/lazadacount?date='.$item;

            $data['lazada订单统计'][$item] = [$url_1, $url_2, $url_3];
        }

        foreach ($id as $item)
        {
            $url_1 = 'http://www.erp.local/services/yunyi/yunyiproduct/amazoncount?date='.$item;
            $url_2 = 'http://192.168.71.38/services/yunyi/yunyiproduct/amazoncount?date='.$item;
            $url_3 = 'http://publish.delaman168.com/services/yunyi/yunyiproduct/amazoncount?date='.$item;

            $data['amazon订单统计'][$item] = [$url_1, $url_2, $url_3];
        }

        $id = range(160, 182);
        foreach ($id as $item)
        {

            $url_1 = 'http://www.erp.local/services/amazon/amazonperformancereport/run?id='.$item;
            $url_2 = 'http://192.168.71.38/services/amazon/amazonperformancereport/run?id='.$item;
            $url_3 = 'http://publish.delaman168.com/services/amazon/amazonperformancereport/run?id='.$item;

            $data['亚马逊账号表现'][$item] = [$url_1, $url_2, $url_3];
        }

        $this->render('url', ['data'=>$data]);
    }

    public function actionMisc()
    {

        $start = strtotime('2019-05-15 00:00:00');
        $end = strtotime('2019-07-30 00:00:00');
        \D::pd($start, $end);


        \D::bk();

        $id_list = [
            "68",
            "69",
            "70",
        ];

        $sql_base = "insert into `yibai_order_amazon` (`order_id`, `platform_code`, `platform_order_id`, `account_id`, `log_id`, `order_status`, `email`, `buyer_id`, `timestamp`, `created_time`, `last_update_time`, `paytime`, `ship_name`, `ship_street1`, `ship_street2`, `ship_zip`, `ship_city_name`, `ship_stateorprovince`, `ship_country`, `ship_country_name`, `ship_phone`, `print_remark`, `ship_cost`, `subtotal_price`, `total_price`, `currency`, `final_value_fee`, `package_nums`, `repeat_nums`, `payment_status`, `ship_status`, `refund_status`, `ship_code`, `complete_status`, `opration_id`, `modify_time`, `opration_date`, `service_remark`, `is_lock`, `abnormal`, `abnormal_causes`, `order_check_status`, `is_multi_warehouse`, `insurance_amount`, `is_check`, `amazon_fulfill_channel`, `escrowFee`, `warehouse_id`, `order_profit_rate`, `calculate_profit_flag`, `parent_order_id`, `order_type`, `buyer_option_logistics`, `is_upload`, `upload_time`, `company_ship_code`, `real_ship_code`, `track_number`, `shipped_date`, `priority_satus`, `is_manual_order`, `order_is_dispose`) values";
        //$sql = "('{order_id}','AMAZON','{platform_order_id}','{account_id}','420995','Unshipped','41x2b9zd7hw3173@marketplace.amazon.in','Deepak P Santhosh','2019-05-04 17:18:02','2019-05-04 16:36:13','2019-05-04 09:10:54','2019-05-04 16:36:13','Jithu T.S.','House No.: VRA138, Thekkepurath House','Market P.O.','686673','MUVATTUPUZHA','KERALA','IN','India','9895826916','','0.00','660.00','660.00','INR','99.00','0','0','1','0','0','YW_481','20','','2019-05-04 16:52:03','2019-05-08 14:42:50','','0','0','0','1','0',NULL,'0','MFN',NULL,'1','46.53','1','0','1','Eco IN MFN','1','2019-05-05 21:38:16','481','YW_481','UE743616655YP','2019-05-08 14:42:29','0','0','0');";
        //$sql = "('AM190413016616','AMAZON','249-3029688-3087868','586','396057','Unshipped','th6mxkwbnw19ggf@marketplace.amazon.co.jp','成重良恵','2019-04-13 14:15:02','2019-04-13 13:48:13','2019-04-13 05:53:39','2019-04-13 13:48:13','成重良恵','十和田市赤沼字前川原４７','','034-0071','','青森県','JP','Japan','0176-22-9612','','0.00','3349.00','3349.00','JPY','502.35','0','0','1','0','0','YDH_1','20','','2019-04-13 14:15:02','2019-04-22 18:26:46','','0','0','0','1','0',NULL,'0','MFN',NULL,'1','17.71','1','0','1','Std JP D2D Dom 11','0','0000-00-00 00:00:00','JPSADD','YDH_1','517978823213','2019-04-22 18:26:55','0','0','0');";

        $data = [];
        $platform_order_id = '171-5688991-0277929';
        foreach ($id_list as $id)
        {
            $order_id = 'AM'.rand().'_test';
            $sql = "('{order_id}','AMAZON','{platform_order_id}','{account_id}','420995','Unshipped','41x2b9zd7hw3173@marketplace.amazon.in','Deepak P Santhosh','2019-05-04 17:18:02','2019-05-04 16:36:13','2019-05-04 09:10:54','2019-05-04 16:36:13','Jithu T.S.','House No.: VRA138, Thekkepurath House','Market P.O.','686673','MUVATTUPUZHA','KERALA','IN','India','9895826916','','0.00','660.00','660.00','INR','99.00','0','0','1','0','0','YW_481','20','','2019-05-04 16:52:03','2019-05-08 14:42:50','','0','0','0','1','0',NULL,'0','MFN',NULL,'1','46.53','1','0','1','Eco IN MFN','1','2019-05-05 21:38:16','481','YW_481','UE743616655YP','2019-05-08 14:42:29','0','0','0')";

            $sql = strtr($sql, [
                '{order_id}'=>$order_id,
                '{platform_order_id}'=>$platform_order_id,
                '{account_id}'=>$id,
            ]);

            $data[] = $sql_base . $sql;
        }

        $sql = "\n\n" . $sql_base . "\n" . implode(";\n", $data) . ";\n\n";
        //\D::logce($sql);

        $data = [];
        $platform_order_id = '249-3029688-3087868';
        foreach ($id_list as $id)
        {
            $order_id = 'AM'.rand().'_test';
            $sql = "('{order_id}','AMAZON','{platform_order_id}','{account_id}','396057','Unshipped','th6mxkwbnw19ggf@marketplace.amazon.co.jp','成重良恵','2019-04-13 14:15:02','2019-04-13 13:48:13','2019-04-13 05:53:39','2019-04-13 13:48:13','成重良恵','十和田市赤沼字前川原４７','','034-0071','','青森県','JP','Japan','0176-22-9612','','0.00','3349.00','3349.00','JPY','502.35','0','0','1','0','0','YDH_1','20','','2019-04-13 14:15:02','2019-04-22 18:26:46','','0','0','0','1','0',NULL,'0','MFN',NULL,'1','17.71','1','0','1','Std JP D2D Dom 11','0','0000-00-00 00:00:00','JPSADD','YDH_1','517978823213','2019-04-22 18:26:55','0','0','0');";

            $sql = strtr($sql, [
                '{order_id}'=>$order_id,
                '{platform_order_id}'=>$platform_order_id,
                '{account_id}'=>$id,
            ]);

            $data[] = $sql_base . $sql;
        }

        $sql = "\n\n" . $sql_base . "\n" . implode(";\n", $data) . ";\n\n";
        \D::logce($sql);

        // [50, 60]被[0, 400]覆盖
        $offsets = 50;
        $limit = 10;
        $after_before_limit = $this->get_after_before_limit($offsets, 200);
        $id_list = $this->get_id_list($after_before_limit['offsets'], $after_before_limit['limit']);
        $id_list_page = $this->get_after_before_limit_page($id_list, $after_before_limit['diff'], $limit);
        \D::pd($offsets, $limit, $after_before_limit, $id_list, $id_list_page);
        \D::line();

        // [590, 600]被[390, 400]覆盖
        $offsets = 590;
        $limit = 10;
        $after_before_limit = $this->get_after_before_limit($offsets, 200);
        $id_list = $this->get_id_list($after_before_limit['offsets'], $after_before_limit['limit']);
        $id_list_page = $this->get_after_before_limit_page($id_list, $after_before_limit['diff'], $limit);
        \D::pd($offsets, $limit, $after_before_limit, $id_list, $id_list_page);

        \D::bk();

        \D::logc($_GET);

        \D::jsonteste();

        \D::usage();

//        $data = range(0, 100000);

        $data = [];
        for ($i=0; $i<1000000; $i++)
        {
            $data[] = $i;
        }

        \D::usagee();
    }

    public function get_id_list($offsets, $limit)
    {
        $data = range(1, 598);

        return array_slice($data, $offsets, $limit);
    }

    /**
     * 给定offset和一个长度，返回扩展后的offset和limit.
     *
     * get_after_before_limit(50, 200): 返回[0, 400]
     * get_after_before_limit(200, 200): 返回[0, 400]
     * get_after_before_limit(300, 200): 返回[100, 400]
     *
     * @param int $offsets sql的offset偏移量，例如300，表示从第300个记录开始取记录.
     * @param int $length 用这个参数计算扩展后的offset和limit，扩展sql的分页大小范围，例如200，此时sql的limit子句就是LIMIT 100, 400.
     * @return array
     */
    public function get_after_before_limit($offsets, $length=200)
    {
        // length小于0时重置为0
        if ($length < 0)
        {
            $length = 0;
        }

        // length最大长度
        if ($length > 500)
        {
            $length = 500;
        }

        // 如果length没有覆盖offsets，就从offsets减去length的位置取数据
        // 如果length覆盖了offsets，就从0开始取数据
        if ($offsets >= $length)
        {
            $offsets_new = $offsets - $length;
            $diff = $offsets - $offsets_new;
        }
        else
        {
            $offsets_new = 0;
            $diff = $offsets;
        }

        // 向下溢出没有关系，不用重置为最大数量
        $limit = $length * 2;

        return [
            'offsets' => $offsets_new,
            'limit' => $limit,
            'diff' => $diff,
        ];
    }

    /**
     * 从扩展offset和limit之后的id列表里取分页数据.
     * @param array $id_list 扩展offset和limit之后查询得到的id列表.
     * @param int $diff 原来的offset在扩展之后的范围相对位置.
     * @param int $limit 原来要取的分页大小.
     * @return array
     */
    public function get_after_before_limit_page($id_list, $diff, $limit)
    {
        return array_slice($id_list, $diff, $limit);
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

    public function isApiRequest()
    {
        return Yii::app()->request->getParam('api') == 1;
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionCustomError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if($this->isApiRequest())
            {
                if (YII_DEBUG)
                {
                    \D::pd($error);
                    $data = [
                        'code'=>$error['code'],
                        'message'=>$error['message'],
                    ];
                }
                else
                {
                    $data = [
                        'code'=>$error['code'],
                        'message'=>$error['message'],
                    ];
                }
                echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            }
            else
            {
                $this->render('error', $error);
            }
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

    public function actionIp()
    {
        // 本机ip
        $ipList = $this->getLocalIPList();
        echo $ipList;
    }

    public function getLocalIPList()
    {
        $preg = "/\A((([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\.){3}(([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\Z/";

        $ipList = [];
        $out = [];
        $stats = [];

        if (PHP_OS == 'WINNT')
        {
            //获取操作系统为win2000/xp、win7的本机IP真实地址
            @exec("ipconfig", $out, $stats);
            if (!empty($out))
            {
                foreach ($out AS $row)
                {
                    if (strstr($row, "IP") && strstr($row, ":") && !strstr($row, "IPv6")) {
                        $tmpIp = explode(":", $row);
                        if (preg_match($preg, trim($tmpIp[1])))
                        {
                            $ip = trim($tmpIp[1]);
                            if ($ip != '127.0.0.1')
                            {
                                $ipList[] = $ip;
                            }
                        }
                    }
                }
            }

            if (count($ipList))
            {
                sort($ipList);
                return implode('|', $ipList);
            }
        }
        else
        {
            //获取操作系统为linux类型的本机IP真实地址
            @exec("ifconfig", $out, $stats);
            if (!empty($out))
            {
                foreach ($out as $item) {
                    if (strstr($item, 'addr:'))
                    {
                        $tmpArray = explode(":", $item);
                        $tmpIp = explode(" ", $tmpArray[1]);
                        if (preg_match($preg, trim($tmpIp[0])))
                        {
                            $ip = trim($tmpIp[0]);
                            if ($ip != '127.0.0.1')
                            {
                                $ipList[] = $ip;
                            }
                        }
                    }
                }
            }

            if (count($ipList))
            {
                sort($ipList);
                return implode('|', $ipList);
            }
        }

        if (preg_match("/cli/i", php_sapi_name()))
        {
            return '';
        }
        else
        {
            return empty($_SERVER['SERVER_ADDR']) ? '' : $_SERVER['SERVER_ADDR'];
        }
    }

    public function actionLogChain()
    {
        Yii::trace('start log chain');

        // 业务链日志
        // 发起 0 --- 0 ---- 0
        //                   |
        // 结束 0 --- 0 ---- 0
        // 远程集中式日志服务器
        // 结束时删除正常日志

        Yii::trace('stop log chain');

        // 这种方式不如逻辑业务链日志，只在出错时记录日志，错误信息标识业务链
        // 相同的错误可能会影响多个业务链，每个主机环节的api功能点是多对多的关系
        // 当前断点错误日志应该标明上下文环境
    }

    public function actionSplQueue()
    {
        // 模拟数据
        $data = range(1, 150);
//        $data = array_reverse($data);
        $group = array_chunk($data, 50);

        // 数组方式操作
        $array = true;

        $queue_list = [];

        // 构造多个队列
        foreach ($group as $index => $list)
        {
            $queue = new SplQueue();

            // 入队
            foreach ($list as $item)
            {
                if ($array)
                {
                    // 数组方式添加
                    $queue[] = $item;
                }
                else
                {
                    // 队列方式
                    $queue->enqueue($item);
                }
            }

            $queue_list[] = $queue;
        }

        \D::pd($queue_list);

        // 打印多个队列
        foreach ($queue_list as $queue)
        {
            // 出队
            if ($array)
            {
                // 数组方式遍历
                foreach ($queue as $value)
                {
                    \D::pd($value);
                }
            }
            else{
                // 队列方式
                while(!$queue->isEmpty())
                {
                    \D::pd($queue->dequeue());
                }
            }
        }
    }

    /**
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     * @throws ErrorException
     */
    protected function exception_error_handler($errno, $errstr, $errfile, $errline )
    {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }

    /**
     * 使用set_error_handler()函数将错误信息托管至ErrorException.
     */
    public function actionException()
    {
        set_error_handler([$this, "exception_error_handler"]);

        strpos();
    }

    public function actionDump()
    {
        \D::pds($_GET, $_POST);
    }

    public function actionContext()
    {
        $url = 'http://www.yiitest.local/site/dump';

        $postdata = http_build_query(
            array(
                'var1' => 'some content',
                'var2' => 'doh'
            )
        );

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );

        $context = stream_context_create($opts);

        $result = file_get_contents($url, false, $context);
        \D::pd($result);
    }

    public function actionUniqid()
    {
        $units = array();
        for($i=0;$i<100000;$i++){
            $units[] = uniqid();
        }
        $values  = array_count_values($units);
        $duplicates = [];
        foreach($values as $k=>$v){
            if($v>1){
                $duplicates[$k]=$v;
            }
        }
        echo '<pre>';
        print_r($duplicates);
        echo '</pre>';

        $units = array();
        for($i=0;$i<100000;$i++){
            $units[] = uniqid('',true);
        }
        $values  = array_count_values($units);
        $duplicates = [];
        foreach($values as $k=>$v){
            if($v>1){
                $duplicates[$k]=$v;
            }
        }
        echo '<pre>';
        print_r($duplicates);
        echo '</pre>';
    }

    public function actionSqlFormat()
    {
        $data = [];

        $user = Yii::app()->user;

        if(isset($_POST['sql'])) {

            $sql = trim($_POST['sql']);

            if ($sql !== '')
            {
                $data = [
                    'sql'=>SqlFormatter::format($sql, false),
                    'sqlHighlight'=>SqlFormatter::format($sql),
                ];

                $user->setState('data', $data);
                $user->setFlash('operationSucceeded', 'Operation Succeeded');

                // Refresh the page to discard the post operation
                $this->refresh();
            }
        }

        if (Yii::app()->request->getPost('json'))
        {
            echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_UNICODE);
            exit;
        }

        $this->render('sqlFormat', [
            'data'=>$user->getState('data'),
        ]);
    }

    public function actionApi()
    {
        $type = Yii::app()->request->getParam('type');

        if ($type == 1)
        {
            $data = [
                range(1, 10),
                range(1, 10),
                range(1, 10),
            ];
        }
        elseif ($type == 2)
        {
            $data = range(1, 10);
        }
        else
        {
            $data = [];
        }

        $this->response($data, $type);

//        $this->responseData();
//        $this->responseError();
    }

    public function actionErpUrl()
    {
        $month_list = [
            7 => range(1, 31),
            6 => range(1, 30),
            5 => range(1, 31),
            4 => range(1, 30),
        ];

        $url = "\n";

        foreach ($month_list as $month => $day_list)
        {
            $day_list = array_reverse($day_list);

            $max_day = count($day_list);

            foreach ($day_list as $day)
            {
                $title = date('m-d', strtotime("2019-{$month}-{$day} 00:00:00"));

                if ($month < 10)
                {
                    $month = '0' . (int)$month;
                }

                if ($day < 10)
                {
                    $day = '0' . $day;
                }

                $next_month = $month;
                $next_day = $day + 1;

                if ($day == $max_day)
                {
                    $next_day = 1;
                    $next_month = $month + 1;
                }

                if ($next_day < 10)
                {
                    $next_day = '0' . $next_day;
                }

                if ($next_month < 10)
                {
                    $next_month = '0' . (int)$next_month;
                }

                $text = "
{title}
http://47.106.127.90:81/services/amazon_pull_order/process_order?history=1&startTime=2019-{month}-{day} 00:00:00&endTime=2019-{month}-{day} 06:00:00&multi=20
http://47.106.127.90:81/services/amazon_pull_order/process_order?history=1&startTime=2019-{month}-{day} 06:00:00&endTime=2019-{month}-{day} 12:00:00&multi=20
http://47.106.127.90:81/services/amazon_pull_order/process_order?history=1&startTime=2019-{month}-{day} 12:00:00&endTime=2019-{month}-{day} 18:00:00&multi=20
http://47.106.127.90:81/services/amazon_pull_order/process_order?history=1&startTime=2019-{month}-{day} 18:00:00&endTime=2019-{next_month}-{next_day} 00:00:00&multi=20
";

                $url .= strtr($text, [
                    '{title}'=>$title,
                    '{month}'=>$month,
                    '{day}'=>$day,
                    '{next_day}'=>$next_day,
                    '{next_month}'=>$next_month,
                ]);
            }
        }

        $url .= "\n\n\n";

        \D::logc($url);
        \D::done();
    }

    public function actionCronTaskLog()
    {
        $file = Yii::app()->getRuntimePath() . "/cron_task_log.csv";

        $lines = file($file);

        $time_list = [];

        foreach ($lines as $item)
        {
            $item = json_decode($item, true);

            $time_list[] = $item['item']['startTime'] . ' - ' . $item['item']['endTime'];
        }

        $time_list = array_unique($time_list);

        foreach ($time_list as $item)
        {
            $parts = explode(' - ', $item);
            $startTime = $parts[0];
            $endTime = $parts[1];
            echo "http://47.106.127.90:81/services/amazon_pull_order/process_order?history=1&startTime={$startTime}&endTime={$endTime}" . '<br/>';
        }
    }

    public function actionDb()
    {
        \D::noclean();
        \D::log('db'.rand());
        $sql = "
            SELECT * FROM yibai_crm.yibai_amazon_inbox AS a 
                LEFT JOIN yibai_crm.yibai_amazon_inbox AS b 
                    ON b.id = a.id 
                LEFT JOIN yibai_crm.yibai_amazon_inbox AS c 
                    ON c.id = a.id 
                LEFT JOIN yibai_crm.yibai_amazon_inbox AS d 
                    ON d.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox AS e 
                    ON e.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox AS f 
                    ON f.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox AS g 
                    ON g.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox AS h 
                    ON h.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox AS i 
                    ON i.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox AS j 
                    ON j.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox AS k 
                    ON k.id = a.id 
                LEFT JOIN yibai_crm.yibai_amazon_inbox AS l 
                    ON l.id = a.id 
                LEFT JOIN yibai_crm.yibai_amazon_inbox AS m 
                    ON m.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox AS n 
                    ON n.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox AS o 
                    ON o.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox AS p 
                    ON p.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox AS q 
                    ON q.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox AS r 
                    ON r.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox AS s 
                    ON s.id = a.id
        ";

        $res = Yii::app()->getDb()->createCommand($sql)->query();
        \D::log($res);
    }

    public function actionDb2()
    {
        \D::noclean();
        \D::log('db2'.rand());
        $sql = "
            SELECT * FROM yibai_crm.yibai_amazon_inbox_copy AS a 
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy AS b 
                    ON b.id = a.id 
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy AS c 
                    ON c.id = a.id 
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy AS d 
                    ON d.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy AS e 
                    ON e.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy AS f 
                    ON f.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy AS g 
                    ON g.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy AS h 
                    ON h.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy AS i 
                    ON i.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy AS j 
                    ON j.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy AS k 
                    ON k.id = a.id 
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy AS l 
                    ON l.id = a.id 
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy AS m 
                    ON m.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy AS n 
                    ON n.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy AS o 
                    ON o.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy AS p 
                    ON p.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy AS q 
                    ON q.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy AS r 
                    ON r.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy AS s 
                    ON s.id = a.id
        ";

        $res = Yii::app()->getDb()->createCommand($sql)->query();
        \D::log($res);
    }

    public function actionDb3()
    {
        \D::noclean();
        \D::log('db3'.rand());
        $sql = "
            SELECT * FROM yibai_crm.yibai_amazon_inbox_copy_copy AS a 
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy_copy AS b 
                    ON b.id = a.id 
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy_copy AS c 
                    ON c.id = a.id 
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy_copy AS d 
                    ON d.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy_copy AS e 
                    ON e.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy_copy AS f 
                    ON f.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy_copy AS g 
                    ON g.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy_copy AS h 
                    ON h.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy_copy AS i 
                    ON i.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy_copy AS j 
                    ON j.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy_copy AS k 
                    ON k.id = a.id 
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy_copy AS l 
                    ON l.id = a.id 
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy_copy AS m 
                    ON m.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy_copy AS n 
                    ON n.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy_copy AS o 
                    ON o.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy_copy AS p 
                    ON p.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy_copy AS q 
                    ON q.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy_copy AS r 
                    ON r.id = a.id
                LEFT JOIN yibai_crm.yibai_amazon_inbox_copy_copy AS s 
                    ON s.id = a.id
        ";

        $res = Yii::app()->getDb()->createCommand($sql)->query();
        \D::log($res);
    }

    public function actionLog()
    {
        sleep(5);

        \D::noclean();
        \D::log('log');
    }

    public function actionTree()
    {
        $array = [
            [
                'id' => 1,
                'pid' => 0,
                'name' => 1,
            ],
            [
                'id' => 2,
                'pid' => 1,
                'name' => 1,
            ],
            [
                'id' => 3,
                'pid' => 2,
                'name' => 3,
            ],
            [
                'id' => 4,
                'pid' => 2,
                'name' => 4,
            ],
            [
                'id' => 5,
                'pid' => 3,
                'name' => 5,
            ],
            [
                'id' => 6,
                'pid' => 4,
                'name' => 6,
            ],
        ];

        shuffle($array);
        echo '<pre>';

        $totree = arrayToTree($array, 0);
        $toarr = treeToArray($totree);
        \D::pd($totree, $toarr);
    }

    public function actionProfile()
    {
        //exit('dd');

        \D::noclean();
        setcookie('PHPSESSID', null);

        \D::profile();
        $data = [
            ['a'=>1, 'b'=>3, 'c'=>5],
            ['a'=>1, 'b'=>4, 'c'=>5],
            ['a'=>2, 'b'=>3, 'c'=>5],
            ['a'=>2, 'b'=>3, 'c'=>6],
        ];

        $d = process_level($data);

        \D::pd($d);

        \D::profilee();

        // redis
        \D::profile('redis');
        \D::profile('connect');
        $redis = new Redis();
        $redis->connect('127.0.0.1', '6379');
        \D::profilee('connect');
        \D::profile('set');
        $key = 'yiitest';
        //$value = json_encode(range(1, 100000));
        //$set = $redis->set($key, $value);
        \D::profilee('set');
        \D::profile('get');
        $get = $redis->get($key);
        \D::profilee('get');
        if (isset($_GET['del'])){
            $redis->del($key);
        }
        //\D::pd($redis, $set, $get);
        \D::profilee('redis');

        // db
        \D::profile(2);
        $sql = "SELECT sql_no_cache * FROM yii_goods WHERE gSn LIKE '20100%' LIMIT 10;";
        $res = Yii::app()->db->createCommand($sql)->query()->readAll();

        \D::profilee(2);
        echo json_encode($res);

        \D::bk();
    }

    public function actionTestMongodb()
    {
        // 连接
        $config = [];
        $config['mongo_host'] = '127.0.0.1';
        $config['mongo_port'] = '27017';
        $config['mongo_db'] = 'yibai_cloud';
        $config['mongo_user'] = 'clouduser';
        $config['mongo_pass'] = '654321';
        $config['host_db_flag'] = true;
        $mongo_db = new Mongo_db($config);

        // 查询
        $where = [
            'account_id'=>'414',
        ];
        $doc = 'yibai_pull_aliexpress_evaluate_task_queue';
        $res = $mongo_db->where($where)->get($doc);
        \D::pd($res);
    }

    public function actionTime()
    {
        $time = Yii::app()->request->getParam('time');
        $wantnum = Yii::app()->request->getParam('wantnum', 0);

        if (empty($time))
        {
            echo 'yiitest.local/site/time?time=时间字符串或者时间戳&num=时间戳就设置为1';
            exit();
        }

        if ($wantnum)
        {
            echo strtotime($time);
        }
        else{
            echo date('Y-m-d H:i:s', $time);
        }
    }

    public function actionDbConnectTest()
    {
        $sql = "show processlist";
        $res = Yii::app()->db->createCommand($sql)->query();
        \D::pd($res->readAll());
    }
}

/**
 * 数组转树结构数组
 *
 * @param array $list
 * @param integer $root
 * @param string $pk
 * @param string $pid
 * @param string $child
 * @return array
 * @author  吴荣超
 * @date    2019-09-08 16:06
 * @version 1.0.0
 */
function arrayToTree($list, $root = 0, $pk = 'id', $pid = 'pid', $child = '_child')
{
    // 创建Tree
    $tree = array();
    $parentId = 0;
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] = &$list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            if (isset($data[$pid])) {
                $parentId = $data[$pid];
            }
            if ($root == $parentId) {
                $tree[] = &$list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent = &$refer[$parentId];
                    $parent[$child][] = &$list[$key];
                }
            }
        }
    }
    return $tree;
}
/**
 * 树结构数组转数组
 *
 * @param array $tree
 * @param integer $level
 * @param string $child_key
 * @return array
 * @author  吴荣超
 * @date    2019-09-10 07:48
 * @version 1.0.0
 */
function treeToArray($tree, $level = 0, $child_key = '_child') {
    $list = array();
    if (is_array($tree)) {
        foreach ($tree as $val) {
            $val['level'] = $level;
            if (isset($val[$child_key])) {
                $child = $val[$child_key];
                if (is_array($child)) {
                    unset($val[$child_key]);
                    $list[] = $val;
                    $list = array_merge($list, treeToArray($child, $level + 1));
                }
            } else {
                $list[] = $val;
            }
        }
    }
    return $list;
}




// 数组遍历
//function get_data(){
//    $d = [
//        ['name'=>'dd', 'age'=>30],
//        ['name'=>'aa', 'age'=>80],
//        ['name'=>'bb', 'age'=>99],
//    ];
//    return $d;
//}
//
//$d = get_data();
//\D::pd($d);
//
//// get some field value
//array_walk($d, function(&$v, $k, $code){
//    $v = $v[$code];
//}, 'name');
//\D::pd($d);
//
//$d = get_data();
//\D::pd($d);
//
//// map two field
//array_walk($d, function(&$v, $k, $params){
//    $v = [$v[$params[0]]=>$v[$params[1]]];
//}, ['name', 'age']);
//\D::pd($d);
//
//\D::pde($d);

