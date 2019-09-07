<?php

class DBinfoController extends Controller
{
    public function actionIndex()
    {

        $_POST['form'] = [
            'connection_list'=>[
                [
                    'host'=>'192.168.71.170',
                    'database'=>'yibai_crm',
                    'username'=>'wurongchao',
                    'password'=>'wurC@2019',
                    'table_list'=>'yibai_amazon_order_cust_message,yibai_amazon_order_pro_message,yibai_amazon_order_package_message,yibai_account',
                    'field_list'=>'id'
                ],
                // yibai_order
                [
                    'host'=>'192.168.71.170',
                    'database'=>'yibai_order',
                    'username'=>'wurongchao',
                    'password'=>'wurC@2019',
                    'table_list'=>'yibai_order_amazon,yibai_order_amazon_detail,yibai_order_package,yibai_order_remark',
                    'field_list'=>'id'
                ],
                // yibai_product
                [
                    'host'=>'192.168.71.170',
                    'database'=>'yibai_product',
                    'username'=>'wurongchao',
                    'password'=>'wurC@2019',
                    'table_list'=>'yibai_product,yibai_product_description',
                    'field_list'=>'id'
                ],
                // yibai_logistics
                [
                    'host'=>'192.168.71.170',
                    'database'=>'yibai_logistics',
                    'username'=>'wurongchao',
                    'password'=>'wurC@2019',
                    'table_list'=>'yibai_logistics_statistics',
                    'field_list'=>'id'
                ],
                // yibai_crm
                [
                    'host'=>'192.168.71.170',
                    'database'=>'yibai_crm',
                    'username'=>'wurongchao',
                    'password'=>'wurC@2019',
                    'table_list'=>'yibai_country_new,yibai_warehouse',
                    'field_list'=>'id'
                ]
            ],
        ];



        echo '<pre>';

        foreach ($this->getDbinfoList() as $dbinfo)
        {
            foreach ($dbinfo->tableList as $table)
            {
                $sql = "SHOW CREATE TABLE `{$dbinfo->database}`.`{$table}`";
                $command=$dbinfo->getConnection()->createCommand($sql);
                $res = $command->query()->read();

                echo "\n\n";
                echo "{$dbinfo->database}\n";
                echo $res['Create Table'];

//                foreach ($dbinfo->fieldList as $field)
//                {
//
//                }
            }
        }


//        $data = [];
//
//
//        $this->render('dbinfo', [
//            'data'=>$data
//        ]);



        // 连接 主机 数据库 账号 表格多选
        // 功能 统计数量  show create table 查找字段
    }

    protected function getDbinfoList()
    {
        $connectionList = $_POST['form']['connection_list'];

        $res = [];
        
        foreach ($connectionList as $item)
        {
            $host = $item['host'];
            $database = $item['database'];
            $username = $item['username'];
            $password = $item['password'];
            $tableList = $item['table_list'];
            $fieldList = $item['field_list'];

            $res[] = new Dbinfo($host, $database, $username, $password, $tableList, $fieldList);
        }

        return $res;
    }
}

class Dbinfo
{
    public $host;
    public $database;
    public $dsn;
    public $username;
    public $password;
    public $tableList;
    public $fieldList;

    private $connection;

    public function __construct($host, $database, $username, $password, $tableList, $fieldList)
    {
        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->tableList = explode(',', $tableList);
        $this->fieldList = explode(',', $fieldList);
        $this->dsn = "mysql:host={$host};dbname={$database}";
    }

    public function getConnection()
    {
        if ($this->connection === null)
        {
            $connection=new CDbConnection($this->dsn, $this->username, $this->password);
            $connection->active=true;
            $this->connection = $connection;
        }
        return $this->connection;
    }
}
