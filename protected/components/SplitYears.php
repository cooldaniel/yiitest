<?php
/**
 * SplitYears类文件.
 * 
 * SplitYears类可以根据给出的开始和结束时间，生成期间的所有月份区间数据.
 * 
 * 例如：
 * $start = '2015-09-02';
 * $end = '2015-12-23';
 * $periods = $split_years->multi_year($start, $end);
 * print_r($periods);
 * 
 * @author Daniel Luo<295313207@qq.com>
 * @date 2015/09/10
 */
class SplitYears
{
	/**
	 * 跨年月区间查询.
	 * @param string $start 开始时间字符串.
	 * @param string $end 结束时间字符串.
	 * return array 返回指定开始和结束时间之间的月区间数据（跨年）.
	 */
	public function multi_year($start, $end)
	{
		$periods = array();
		
		// 获取开始与结束时间的时间信息
		$start_info = getdate(strtotime($start));
		$end_info = getdate(strtotime($end));
		
		// 生成年区间，再生成每一年的月区间
		$scopes = $this->generate_scope($start, $end, $start_info, $end_info);
		foreach ($scopes as $item)
		{
			$periods = array_merge($periods, $this->one_year($item['start'], $item['end'], getdate(strtotime($item['start'])), getdate(strtotime($item['end']))));
		}
		
		return $periods;
	}
	
	/**
	 * 生成年区间信息数组.
	 * @param string $start 开始时间字符串.
	 * @param string $end 结束时间字符串.
	 * @param array $start_info 调用PHP函数getdate()返回的开始时间的信息数组.
	 * @param array $end_info 调用PHP函数getdate()返回的结束时间的信息数组.
	 * @return array 返回指定开始和结束时间跨越的年份区间时间字符串数组.
	 */
	public function generate_scope($start, $end, $start_info, $end_info)
	{
		$scopes = array();
		
		$years = ($end_info['year'] - $start_info['year']);
		if ($years == 0)
		{
			// 开始和结束时间都在同一年
			$scopes[] = array('start' => $start, 'end' => $end);
		}
		elseif ($years == 1)
		{
			// 开始和结束时间横跨两年
			$year_end = date('Y-m-d', strtotime('last day of December ' . $start_info['year']));
			$scopes[] = array('start' => $start, 'end' => $year_end);
			
			$year_start = date('Y-m-d', strtotime('first day of January ' . ($start_info['year'] + 1)));
			$scopes[] = array('start' => $year_start, 'end' => $end);
		}
		else
		{
			// 横跨多年
			$counts = 0;
			while ($counts <= $years)
			{
				$year = ($start_info['year'] + $counts);
				
				if ($counts == 0)
				{
					// 第一年的开始和结束时间
					$year_end = date('Y-m-d', strtotime('last day of December ' . $year));
					$scopes[] = array('start' => $start, 'end' => $year_end);
				}
				elseif ($counts == $years)
				{
					// 最后一年的开始和结束时间
					$year_start = date('Y-m-d', strtotime('first day of January ' . $year));
					$scopes[] = array('start' => $year_start, 'end' => $end);
				}
				else
				{
					// 中间年份的开始和结束时间
					$year_end = date('Y-m-d', strtotime('last day of December ' . $year));
					$year_start = date('Y-m-d', strtotime('first day of January ' . $year));
					$scopes[] = array('start' => $year_start, 'end' => $year_end);
				}
				
				$counts ++;
			}
		}
		
		return $scopes;
	}
	
	/**
	 * 生成同一年的月区间信息数组.
	 * @param string $start 开始时间字符串.
	 * @param string $end 结束时间字符串，必须跟开始时间在同一年内. 如果要获取跨年份的月区间信息数组，请调用{multi_year()}.
	 * @param array $start_info 调用PHP函数getdate()返回的开始时间的信息数组.
	 * @param array $end_info 调用PHP函数getdate()返回的结束时间的信息数组.
	 * @return array 返回指定开始和结束时间所在的同一年份的月区间信息数组.
	 */
	public function one_year($start, $end, $start_info, $end_info)
	{
		$periods = array();
		
		// 开始与结束时间之间的月数
		$length = ($end_info['mon'] - $start_info['mon']);
		if ($length == 0)
		{
			// 只有一个月区间
			$periods[] = $this->generate_period($start_info, $start, $end);
		}
		elseif ($length == 1)
		{
			// 只有首尾两个月区间
			$periods[] = $this->generate_period($start_info, $start);
			$periods[] = $this->generate_period($end_info, false, $end);
		}
		else
		{
			// 生成第一个时间的月区间
			$periods[] = $this->generate_period($start_info, $start);
			
			// 生成中间月份的月区间
			foreach (range($start_info['mon'] + 1, $end_info['mon'] - 1) as $item)
			{
				$periods[] = $this->generate_period(getdate(strtotime("{$start_info['year']}-{$item}-01")));
			}
			
			// 生成最后一个时间的月区间
			$periods[] = $this->generate_period($end_info, false, $end);
		}
		
		return $periods;
	}
	
	/**
	 * 根据PHP函数getdate()的时间信息，生成月区间数组.
	 * @param array $dateinfo 调用PHP函数getdate()返回的时间信息数组.
	 * @param mixed $start 开始时间字符串，false表示不指定，指定的话就直接用它做月区间的开始时间.
	 * @param mixed $end 结束时间字符串，false表示不指定，指定的话就直接用它做月区间的结束时间.
	 * @return array 返回指定某一天所在的月区间信息数组.
	 */
	public function generate_period($dateinfo, $start=false, $end=false)
	{
		$data = array();
		
		if ($start)
		{
			$data['first_timestamp'] = strtotime($start);
			$data['first_datetime'] = $start;
		}
		
		if ($end)
		{
			$data['last_timestamp'] = strtotime($end);
			$data['last_datetime'] = $end;
		}
		
		if (!isset($data['first_timestamp']))
		{
			$first_timestamp = strtotime('first day of ' . $dateinfo['month'] . ' ' . $dateinfo['year']);
			$data['first_timestamp'] = $first_timestamp;
			$data['first_datetime'] = date('Y-m-d', $first_timestamp);
		}
		
		if (!isset($data['last_timestamp']))
		{
			$last_timestamp = strtotime('last day of ' . $dateinfo['month'] . ' ' . $dateinfo['year']);
			$data['last_timestamp'] = $last_timestamp;
			$data['last_datetime'] = date('Y-m-d', $last_timestamp);
		}
		
		ksort($data);
		
		return $data;
	}
}