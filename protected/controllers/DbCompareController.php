<?php
class DbCompareController extends Controller
{
	public function actionIndex()
    {
        $data = [];

        $user = Yii::app()->user;

        if(isset($_POST['json'])) {

            $json = trim($_POST['json']);

            if ($json !== '')
            {
                $html = $this->compare();
                $data = [
                    'html'=>$html,
                ];
                $data = array_merge($data, $_POST);
                $data['json'] = json_encode(json_decode($data['json']), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

                $user->setState('data', $data);

                if (is_string($html))
                {
                    $user->setFlash('operationSucceeded', $html);
                }
                else
                {
                    $user->setFlash('operationSucceeded', 'Operation Succeeded');
                }

                // Refresh the page to discard the post operation
                $this->refresh();
            }
        }

        if (Yii::app()->request->getPost('json'))
        {
            echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_UNICODE);
            exit;
        }

        $this->render('index', [
            'data'=>$user->getState('data'),
        ]);
    }

    public function getDbConnection($ip, $port, $database, $username, $password)
    {
        $dsn = "mysql:host={$ip}:{$port};dbname={$database}";
        $connection=new CDbConnection($dsn,$username,$password);
        $connection->active=true;
        $connection->emulatePrepare = true;
        $connection->charset = 'utf8';
        $connection->enableProfiling = true;
        return $connection;
    }

    public function getMongodbConnection($ip, $port, $database, $username, $password)
    {

    }

    public function getDataFromSourceDatabase()
    {
        // 参数
        $source_ip = Yii::app()->request->getPost('source_ip');
        $source_port = Yii::app()->request->getPost('source_port', '3306');
        $source_database = Yii::app()->request->getPost('source_database');
        $source_username = Yii::app()->request->getPost('source_username');
        $source_password = Yii::app()->request->getPost('source_password');
        $source_table = Yii::app()->request->getPost('source_table');
        $source_search_key = Yii::app()->request->getPost('source_search_key');
        $source_search_value = Yii::app()->request->getPost('source_search_value');

        if (empty($source_ip) ||
            empty($source_port) ||
            empty($source_database) ||
            empty($source_username) ||
            empty($source_password) ||
            empty($source_table) ||
            empty($source_search_key) ||
            empty($source_search_value))
        {
            return [];
        }

        // sql查询
        $source_connection = $this->getDbConnection($source_ip, $source_port, $source_database, $source_username, $source_password);
        $sql = "SELECT * FROM `{$source_table}` WHERE `{$source_search_key}` = '{$source_search_value}'";
        $res = $source_connection->createCommand($sql)->queryRow();

        return $res;
    }

    public function getDataFromCompareDatabase()
    {
        // 参数
        $compare_ip = Yii::app()->request->getPost('compare_ip');
        $compare_port = Yii::app()->request->getPost('compare_port', '3306');
        $compare_database = Yii::app()->request->getPost('compare_database');
        $compare_username = Yii::app()->request->getPost('compare_username');
        $compare_password = Yii::app()->request->getPost('compare_password');
        $compare_table = Yii::app()->request->getPost('compare_table');
        $compare_search_key = Yii::app()->request->getPost('compare_search_key');
        $compare_search_value = Yii::app()->request->getPost('compare_search_value');

        if (empty($compare_ip) ||
            empty($compare_port) ||
            empty($compare_database) ||
            empty($compare_username) ||
            empty($compare_password) ||
            empty($compare_table) ||
            empty($compare_search_key) ||
            empty($compare_search_value))
        {
            return [];
        }

        // sql查询
        $compare_connection = $this->getDbConnection($compare_ip, $compare_port, $compare_database, $compare_username, $compare_password);
        $sql = "SELECT * FROM `{$compare_table}` WHERE `{$compare_search_key}` = '{$compare_search_value}'";
        $res = $compare_connection->createCommand($sql)->queryRow();

        return $res;
    }

    public function getDataFromMongodb()
    {
        // 参数
        $mongodb_ip = Yii::app()->request->getPost('mongodb_ip');
        $mongodb_port = Yii::app()->request->getPost('mongodb_port', '27017');
        $mongodb_database = Yii::app()->request->getPost('mongodb_database');
        $mongodb_username = Yii::app()->request->getPost('mongodb_username');
        $mongodb_password = Yii::app()->request->getPost('mongodb_password');
        $mongodb_table = Yii::app()->request->getPost('mongodb_table');
        $mongodb_search_key = Yii::app()->request->getPost('mongodb_search_key');
        $mongodb_search_value = Yii::app()->request->getPost('mongodb_search_value');

        if (empty($mongodb_ip) ||
            empty($mongodb_port) ||
            empty($mongodb_database) ||
            empty($mongodb_username) ||
            empty($mongodb_password) ||
            empty($mongodb_table) ||
            empty($mongodb_search_key) ||
            empty($mongodb_search_value))
        {
            return [];
        }

        // mongodb查询
        // 连接
        $config = [];
        $config['mongo_host'] = $mongodb_ip;
        $config['mongo_port'] = $mongodb_port;
        $config['mongo_db'] = $mongodb_database;
        $config['mongo_user'] = $mongodb_username;
        $config['mongo_pass'] = $mongodb_password;
        $config['host_db_flag'] = true;
        $mongo_db = new Mongo_db($config);

        // 查询
        $where = [
            $mongodb_search_key=>$mongodb_search_value,
        ];
        $res = $mongo_db->where($where)->get($mongodb_table);

        return empty($res) ? [] : json_decode((json_encode($res[0])), true);
    }

    public function compare()
    {
                // 数据库连接
//        $dsn = 'mysql:host=192.168.71.216;dbname=yb_datacenter';
//        $username = 'root';
//        $password = 'yibai123456';
//
//        $dsn = 'mysql:host=192.168.71.6:3306;dbname=wms-test';
//        $username = 'huangbiyu';
//        $password = 'hby.123';

        $json = Yii::app()->request->getPost('json');

        // 获取源数据
        $source_data = $this->getDataFromSourceDatabase();

        // 获取要对比的数据
        $compare_data = $this->getDataFromCompareDatabase();
        $mongodb_data = $this->getDataFromMongodb();
        $json_data = json_decode($json, true);

        // 源数据必须存在才进行对比
        if (empty($source_data))
        {
            return '源数据记录不存在，请重新输入搜索条件';
        }

        // 对比json
        if (empty($json))
        {
            $json_html = '没有输入json数据';
        }
        else
        {
            $json_result = $this->compareDataWithJson($source_data, $json_data);
            $json_html = $this->renderCompareResult($json_result, '对比Json');
        }

        // 对比数据库
        if (empty($compare_data))
        {
            $compare_html = '没有输入对比数据库连接';
        }
        else
        {
            $compare_result = $this->compareDataWithCompare($source_data, $compare_data);
            $compare_html = $this->renderCompareResult($compare_result, '对比数据库');
        }

        // 对比mongodb
        if (empty($mongodb_data))
        {
            $mongodb_html = '没有输入mongodb连接';
        }
        else
        {
            $mongodb_result = $this->compareDataWithMongodb($source_data, $mongodb_data);
            $mongodb_html = $this->renderCompareResult($mongodb_result, '对比mongodb');
        }

        return [
            'json_html'=>$json_html,
            'compare_html'=>$compare_html,
            'mongodb_html'=>$mongodb_html,
        ];
    }

    protected function compareDataWithJson($source_data, $compare_data)
    {
        $data = [];

        foreach ($source_data as $key => $value)
        {
            // 转键名
            $key_new = $this->convertKey($key);

            // 是否存在字段
            $key_not_found = !array_key_exists($key_new, $compare_data);

            // 对比结果
            $value_json = $key_not_found ? '<span style="color:red;">没有字段</span>' : $compare_data[$key_new];
            $result_equal = ($value == $value_json) ? '相等' : '<span style="color:red;">不相等</span>';
            $result_equal_strict = ($value === $value_json) ? '相等' : '<span style="color:red;">不相等</span>';
            $result_equal_trim = (trim($value) == trim($value_json)) ? '相等' : '<span style="color:red;">不相等</span>';

            // json没有字段就不对比
            if ($key_not_found)
            {
                $result_equal = '<span style="color:red;">-</span>';
                $result_equal_strict = '<span style="color:red;">-</span>';
                $result_equal_trim = '<span style="color:red;">-</span>';
            }

            $data[] = [
                'key'=>$key,
                'key_new'=>$key_new,
                'value'=>is_null($value) ? '<i>NULL</i>' : $value,
                'value_json'=>is_null($value) ? '<i>NULL</i>' : $value,
                'result_equal'=>$result_equal,
                'result_equal_strict'=>$result_equal_strict,
                'result_equal_trim'=>$result_equal_trim,
            ];
        }

        return $data;
    }

    protected function compareDataWithCompare($source_data, $compare_data)
    {
        $data = [];

        foreach ($source_data as $key => $value)
        {
            // 转键名
            $key_new = $this->convertKey($key);

            // 是否存在字段
            $key_not_found = !array_key_exists($key, $compare_data);

            // 对比结果
            $value_json = $key_not_found ? '<span style="color:red;">没有字段</span>' : $compare_data[$key];
            $result_equal = ($value == $value_json) ? '相等' : '<span style="color:red;">不相等</span>';
            $result_equal_strict = ($value === $value_json) ? '相等' : '<span style="color:red;">不相等</span>';
            $result_equal_trim = (trim($value) == trim($value_json)) ? '相等' : '<span style="color:red;">不相等</span>';

            // json没有字段就不对比
            if ($key_not_found)
            {
                $result_equal = '<span style="color:red;">-</span>';
                $result_equal_strict = '<span style="color:red;">-</span>';
                $result_equal_trim = '<span style="color:red;">-</span>';
            }

            $data[] = [
                'key'=>$key,
                'key_new'=>$key_new,
                'value'=>is_null($value) ? '<i>NULL</i>' : $value,
                'value_json'=>is_null($value) ? '<i>NULL</i>' : $value,
                'result_equal'=>$result_equal,
                'result_equal_strict'=>$result_equal_strict,
                'result_equal_trim'=>$result_equal_trim,
            ];
        }

        return $data;
    }

    protected function compareDataWithMongodb($source_data, $compare_data)
    {
        $data = [];

        foreach ($source_data as $key => $value)
        {
            // 转键名
            $key_new = $this->convertKey($key);

            // 是否存在字段
            $key_not_found = !array_key_exists($key, $compare_data);

            // 对比结果
            $value_json = $key_not_found ? '<span style="color:red;">没有字段</span>' : $compare_data[$key];
            $result_equal = ($value == $value_json) ? '相等' : '<span style="color:red;">不相等</span>';
            $result_equal_strict = ($value === $value_json) ? '相等' : '<span style="color:red;">不相等</span>';
            $result_equal_trim = (trim($value) == trim($value_json)) ? '相等' : '<span style="color:red;">不相等</span>';

            // json没有字段就不对比
            if ($key_not_found)
            {
                $result_equal = '<span style="color:red;">-</span>';
                $result_equal_strict = '<span style="color:red;">-</span>';
                $result_equal_trim = '<span style="color:red;">-</span>';
            }

            $data[] = [
                'key'=>$key,
                'key_new'=>$key_new,
                'value'=>is_null($value) ? '<i>NULL</i>' : $value,
                'value_json'=>is_null($value) ? '<i>NULL</i>' : $value,
                'result_equal'=>$result_equal,
                'result_equal_strict'=>$result_equal_strict,
                'result_equal_trim'=>$result_equal_trim,
            ];
        }

        return $data;
    }

    protected function renderCompareResult($data, $title)
    {
        // 输出表格
        $html = '';
        $html .=  '<table>';
        $html .=  '<thead>';
        $html .=  '<tr>';
        $html .=  '<th>数据库字段</th>';
        $html .=  '<th>驼峰格式</th>';
        $html .=  '<th>数据库值</th>';
        $html .=  '<th>'.$title.'值</th>';
        $html .=  '<th>数值相等</th>';
        $html .=  '<th>严格相等</th>';
        $html .=  '<th>去空格后相等</th>';
        $html .=  '</tr>';
        $html .=  '</thead>';
        $html .=  '<tbody>';
        foreach ($data as $index => $item)
        {
            $even = !(($index % 2) == 0);
            $even_class = $even ? "even" : '';
            $html .=  '<tr class="'.$even_class.'">';
            $html .=  '<td>'.$item['key'].'</td>';
            $html .=  '<td>'.$item['key_new'].'</td>';
            $html .=  '<td>'.$item['value'].'</td>';
            $html .=  '<td>'.$item['value_json'].'</td>';
            $html .=  '<td style="width:50px;">'.$item['result_equal'].'</td>';
            $html .=  '<td style="width:50px;">'.$item['result_equal_strict'].'</td>';
            $html .=  '<td style="width:50px;">'.$item['result_equal_trim'].'</td>';
            $html .=  '</tr>';
        }
        $html .=  '</tbody>';
        $html .=  '</table>';

        return $html;
    }

    protected function convertKey($key)
    {
        if (strpos($key, '_') > 0)
        {
            $parts = explode('_', $key);

            $key_new = '';
            foreach ($parts as $index => $item)
            {
                if ($index > 0)
                {
                    $item = ucfirst($item);
                }
                $key_new .= $item;
            }
            return $key_new;
        }
        return $key;
    }
}
