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
}