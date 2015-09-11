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
		print_r($periods);
		
		// 开始和结束时间横跨两年
		$end = '2016-12-23';
		$periods = $split_years->multi_year($start, $end);
		print_r($periods);
		
		// 横跨多年
		$end = '2018-12-23';
		$periods = $split_years->multi_year($start, $end);
		print_r($periods);
		
		//----------- 年份测试 -----------------------
		
		// 开始和结束时间都在同一年
		$end = '2015-12-23';
		$periods = $split_years->parse_year($start, $end);
		print_r($periods);
		
		// 开始和结束时间横跨两年
		$end = '2016-12-23';
		$periods = $split_years->parse_year($start, $end);
		print_r($periods);
		
		// 横跨多年
		$end = '2018-12-23';
		$periods = $split_years->parse_year($start, $end);
		print_r($periods);
    }
}