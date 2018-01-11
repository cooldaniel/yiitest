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
}