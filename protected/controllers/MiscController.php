<?php

class MiscController extends Controller
{
	/**
	 * 生成指定日期区间内的所有月区间（跨年）.
	 */
	public function actionMonthPeriods()
	{
		//----------- test -----------------------
		$split_years = new SplitYears;
		
		// 开始和结束时间都在同一年
		$start = '2015-09-02';
		$end = '2015-12-23';
		$periods = $split_years->multi_year($start, $end);
		print_r($periods);
		
		// 开始和结束时间横跨两年
		$start = '2015-09-02';
		$end = '2016-12-23';
		$periods = $split_years->multi_year($start, $end);
		print_r($periods);
		
		// 横跨多年
		$start = '2015-09-02';
		$end = '2018-12-23';
		$periods = $split_years->multi_year($start, $end);
		print_r($periods);
    }
}