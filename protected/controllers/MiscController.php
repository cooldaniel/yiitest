<?php

class MiscController extends Controller
{
	/**
	 * 生成指定日期区间内的所有月区间（跨年）.
	 */
	public function actionMonthPeriods()
	{
		$split_years = new SplitYears;
		
		//----------- 月区间测试 -----------------------
		
		$start = '2015-09-02';
		
		// 开始和结束时间都在同一年
		$end = '2015-12-23';
		$periods = $split_years->multi_year($start, $end);
		D::pd($periods);
		
		// 开始和结束时间横跨两年
		$end = '2016-12-23';
		$periods = $split_years->multi_year($start, $end);
		D::pd($periods);
		
		// 横跨多年
		$end = '2018-12-23';
		$periods = $split_years->multi_year($start, $end);
		D::pd($periods);
		
		//----------- 年份测试 -----------------------
		
		// 开始和结束时间都在同一年
		$end = '2015-12-23';
		$periods = $split_years->parse_year($start, $end);
		D::pd($periods);
		
		// 开始和结束时间横跨两年
		$end = '2016-12-23';
		$periods = $split_years->parse_year($start, $end);
		D::pd($periods);
		
		// 横跨多年
		$end = '2018-12-23';
		$periods = $split_years->parse_year($start, $end);
		D::pd($periods);
		
		//----------- 判断两个时间段是否重叠 -----------------------
		
		// 假设第一个时间段为A，第二个时间段为B，初始总是按A在左B在右顺序，并保持B不动
		
		// 时间B，总是不变
		$start_2 = '2002-01-01';
		$end_2 = '2005-01-01';
		
		// A在B左边
		$start = '2001-01-01';
		$end = '2002-01-01';
		$is_overlap_time = $split_years->is_overlap_time($start, $end, $start_2, $end_2);
		D::pd($is_overlap_time);
		
		// A在B右边
		$start = '2005-01-01';
		$end = '2006-01-01';
		$is_overlap_time = $split_years->is_overlap_time($start, $end, $start_2, $end_2);
		D::pd($is_overlap_time);
		
		// A左相交于B
		$start = '2001-01-01';
		$end = '2003-01-01';
		$is_overlap_time = $split_years->is_overlap_time($start, $end, $start_2, $end_2);
		D::pd($is_overlap_time);
		
		// A右相交于B
		$start = '2004-01-01';
		$end = '2006-01-01';
		$is_overlap_time = $split_years->is_overlap_time($start, $end, $start_2, $end_2);
		D::pd($is_overlap_time);
		
		// A包含于B
		$start = '2003-01-01';
		$end = '2004-01-01';
		$is_overlap_time = $split_years->is_overlap_time($start, $end, $start_2, $end_2);
		D::pd($is_overlap_time);
		
		// A包含B
		$start = '2001-01-01';
		$end = '2006-01-01';
		$is_overlap_time = $split_years->is_overlap_time($start, $end, $start_2, $end_2);
		D::pd($is_overlap_time);
    }


    public function actionXdebug()
    {
        \D::bk();

        xdebug_start_trace();

        foreach (range('a', 'z') as $char)
        {
            echo ($char);
        }

        xdebug_stop_trace();
        xdebug_start_code_coverage();

        function a($a) {
            echo $a * 2.5;
        }
        function b($count) {
            for ($i = 0; $i < $count; $i++) {
                a($i + 0.17);
            }
        }
        b(6);
        b(10);
        var_dump(xdebug_get_code_coverage());
        D::pds(xdebug_get_profiler_filename());

        xdebug_stop_code_coverage();

        D::cookie();
        D::fp();
        D::bk();
    }

    public function actionBehavior()
    {
        // 测试行为和事件机制
		// new BehaviorHost;
		// new Event;

		//throw new CHttpException('test http', 403);
		//throw new Exception('test');
		//D::pd($d);
		//require __DIR__ . 'daniel.txt';
    }

    public function actionSession()
    {
        session_start();
		$_SESSION['token'] = rand();
		D::log($_SESSION);
    }
    
    public function actionD()
    {
        \D::fp();

        // 数据类型及操作方式通用分析

        /* 简单的数据访问方式 */

        // 操作单元：基本表达式
        $a = 1;
        $b = 2;
        $c = $a + $b;
        \D::pd($a, $b, $c);

        // 数组
        $a = [1,2,3];
        $b = $a[0];
        $c = $a[1];
        \D::pd($a, $b, $c);

        // 关联数组
        $a = ['one'=>1, 'two'=>2];
        $b = $a['one'];
        $c = $a['two'];
        \D::pd($a, $b, $c);

        // 对象
        $a = new class{
            public $one = 1;
            public $two = 2;
            public function three() {
                echo 'three';
            }
        };
        $b = $a->one;
        $c = $a->two;
        $a->three();
        \D::pd($a, $b, $c);

        /* 构造高级数据结构和访问方式 */
    }
    
    public function actionDaemon()
    {
        // 入口脚本
        // 解析环境数据，设定运行环境
        // 解析url定位controller
        // 接收和解析提交的参数，包括header，cookie，request等
        // 数据处理
        // 数据库操作
        // 响应

        /* 数组处理建模 */

        // 构造多维数组
        $tpl = [
            ['name'=>'title', 'type'=>'string'],
            ['name'=>'status', 'type'=>'enum', 'value'=>'1,2,3'],

            ['name'=>'sub', 'type'=>'array', 'return_type'=>'json', 'tpl'=>[
                ['name'=>'title', 'type'=>'string'],
                ['name'=>'status', 'type'=>'enum', 'value'=>'1,2,3'],

                ['name'=>'sub', 'type'=>'array', 'tpl'=>[
                    ['name'=>'title', 'type'=>'string'],
                    ['name'=>'status', 'type'=>'enum', 'value'=>'1,2,3'],

                    ['name'=>'sub', 'type'=>'array', 'tpl'=>[
                        ['name'=>'title', 'type'=>'string'],
                        ['name'=>'status', 'type'=>'enum', 'value'=>'1,2,3'],

                        ['name'=>'sub', 'type'=>'array', 'tpl'=>[
                            ['name'=>'title', 'type'=>'string'],
                            ['name'=>'status', 'type'=>'enum', 'value'=>'1,2,3'],
                        ]],
                    ]],
                ]],
            ]],
        ];

        $builder = new ArrayBuilder();
        $data = $builder->makeData($tpl, 10);
        \D::pd($data);

        // 一维数组处理

        // 多维数组处理

        // 多个数组处理（集合运算）

        array_map(function ($value) {
            \D::pd($value);
        }, $data);

        \D::fp();

        // 递归遍历
        array_walk_recursive($data, function (&$value, $index, $params=[]) {
            $value .= ' - ' .rand() . ' - ' . $params['rand'];
        }, ['rand'=>rand()]);
        \D::pd($data);
    }