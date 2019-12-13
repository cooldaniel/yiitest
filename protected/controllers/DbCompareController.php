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
        $config = [];
        $config['mongo_host'] = $ip;
        $config['mongo_port'] = $port;
        $config['mongo_db'] = $database;
        $config['mongo_user'] = $username;
        $config['mongo_pass'] = $password;
        $config['host_db_flag'] = true;
        $mongo_db = new Mongo_db($config);
        return $mongo_db;
    }

    public function getDataFromSourceDatabase()
    {
        // 参数
        $ip = Yii::app()->request->getPost('source_ip');
        $port = Yii::app()->request->getPost('source_port', '3306');
        $database = Yii::app()->request->getPost('source_database');
        $username = Yii::app()->request->getPost('source_username');
        $password = Yii::app()->request->getPost('source_password');
        $table = Yii::app()->request->getPost('source_table');
        $search_key = Yii::app()->request->getPost('source_search_key');
        $search_value = Yii::app()->request->getPost('source_search_value');

        if (empty($ip) ||
            empty($port) ||
            empty($database) ||
            empty($username) ||
            empty($password) ||
            empty($table) ||
            empty($search_key) ||
            empty($search_value))
        {
            return false;
        }

        // sql查询
        $connection = $this->getDbConnection($ip, $port, $database, $username, $password);
        $sql = "SELECT * FROM `{$table}` WHERE `{$search_key}` = '{$search_value}'";
        $res = $connection->createCommand($sql)->queryRow();

        return empty($res) ? [] : $res;
    }

    public function getDataFromCompareDatabase()
    {
        // 参数
        $ip = Yii::app()->request->getPost('compare_ip');
        $port = Yii::app()->request->getPost('compare_port', '3306');
        $database = Yii::app()->request->getPost('compare_database');
        $username = Yii::app()->request->getPost('compare_username');
        $password = Yii::app()->request->getPost('compare_password');
        $table = Yii::app()->request->getPost('compare_table');
        $search_key = Yii::app()->request->getPost('compare_search_key');
        $search_value = Yii::app()->request->getPost('compare_search_value');

        if (empty($ip) ||
            empty($port) ||
            empty($database) ||
            empty($username) ||
            empty($password) ||
            empty($table) ||
            empty($search_key) ||
            empty($search_value))
        {
            return false;
        }

        // sql查询
        $connection = $this->getDbConnection($ip, $port, $database, $username, $password);
        $sql = "SELECT * FROM `{$table}` WHERE `{$search_key}` = '{$search_value}'";
        $res = $connection->createCommand($sql)->queryRow();

        return empty($res) ? [] : $res;
    }

    public function getDataFromMongodb()
    {
        // 参数
        $ip = Yii::app()->request->getPost('mongodb_ip');
        $port = Yii::app()->request->getPost('mongodb_port', '27017');
        $database = Yii::app()->request->getPost('mongodb_database');
        $username = Yii::app()->request->getPost('mongodb_username');
        $password = Yii::app()->request->getPost('mongodb_password');
        $table = Yii::app()->request->getPost('mongodb_table');
        $search_key = Yii::app()->request->getPost('mongodb_search_key');
        $search_value = Yii::app()->request->getPost('mongodb_search_value');

        if (empty($ip) ||
            empty($port) ||
            empty($database) ||
            empty($username) ||
            empty($password) ||
            empty($table) ||
            empty($search_key) ||
            empty($search_value))
        {
            return false;
        }

        // mongodb查询
        $connection = $this->getMongodbConnection($ip, $port, $database, $username, $password);
        $where = [
            $search_key=>$search_value,
        ];
        $res = $connection->where($where)->get($table);

        return empty($res) ? [] : (array)json_decode((json_encode($res[0])), true);
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
        if ($source_data === false)
        {
            return '源数据库连接信息不完整';
        }
        elseif (empty($source_data))
        {
            return '源数据记录不存在，请重新输入搜索条件';
        }

        // 对比json
        $json_no_data = true;
        if (empty($json) || (trim($json) == '{}'))
        {
            $json_html = '没有输入json数据';
        }
        else
        {
            $json_result = $this->compareData($source_data, $json_data, true);
            $json_html = $this->renderCompareResult($json_result, '对比Json');
            $json_no_data = false;
        }

        // 对比数据库
        $compare_no_data = true;
        if ($compare_data === false)
        {
            $compare_html = '没有输入对比数据库连接';
        }
        elseif (empty($compare_data))
        {
            $compare_html = '对比数据库连接信息不完整';
        }
        else
        {
            $compare_result = $this->compareData($source_data, $compare_data);
            $compare_html = $this->renderCompareResult($compare_result, '对比数据库');
            $compare_no_data = false;
        }

        // 对比mongodb
        $mongodb_no_data = true;
        if ($mongodb_data === false)
        {
            $mongodb_html = 'mongodb连接信息不完整';
        }
        elseif (empty($mongodb_data))
        {
            $mongodb_html = '找不到对应的mongodb记录';
        }
        else
        {
            $mongodb_result = $this->compareData($source_data, $mongodb_data);
            $mongodb_html = $this->renderCompareResult($mongodb_result, '对比mongodb');
            $mongodb_no_data = false;
        }

        return [
            'json_html'=>$json_no_data ? '<div class="nodata">'.$json_html.'</div>' : $json_html,
            'compare_html'=>$compare_no_data ? '<div class="nodata">'.$compare_html.'</div>' : $compare_html,
            'mongodb_html'=>$mongodb_no_data ? '<div class="nodata">'.$mongodb_html.'</div>' : $mongodb_html,
        ];
    }

    protected function compareData($source_data, $compare_data, $convertKey=false)
    {
        $data = [];

        foreach ($source_data as $key => $value)
        {
            // 转键名
            $key_new = $convertKey ? $this->convertKey($key) : $key;

            // 是否存在字段
            $key_not_found = !array_key_exists($key_new, $compare_data);

            // 对比结果
            $value_compare = $key_not_found ? '<span style="color:red;">没有字段</span>' : $compare_data[$key_new];
            $result_equal = ($value == $value_compare) ? '相等' : '<span style="color:red;">不相等</span>';
            $result_equal_strict = ($value === $value_compare) ? '相等' : '<span style="color:red;">不相等</span>';
            $result_equal_trim = (trim($value) == trim($value_compare)) ? '相等' : '<span style="color:red;">不相等</span>';

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
                'value_json'=>is_null($value_compare) ? '<i>NULL</i>' : $value_compare,
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
