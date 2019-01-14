<?php

/**
 * @package application.controllers
 */
class TaxController extends Controller
{
    public function getConfigNew($config, $origin)
    {
        $configNew = [
            [0,     5000,  0,  0],
        ];
        foreach ($config as $item) {

            $item[0] += $origin;

            if ($item[1] !== null) {
                $item[1] += $origin;
            }

            $configNew[]= $item;
        }
        return $configNew;
    }

	public function actionIndex()
	{
        // 税前工资的输入单元格
        $ceil = 'N3';

        // 收税起点
        $origin = 5000;

        // 要收税部分
        $config = [
            [0,     3000,  3,  0],
            [3000,  12000, 10, 210],
            [12000, 25000, 20, 1410],
            [25000, 35000, 25, 2660],
            [35000, 55000, 30, 4410],
            [55000, 80000, 35, 7160],
            [80000, null,  45, 15160],
        ];

        // 计算得到范围
        $configNew = $this->getConfigNew($config, $origin);

        $res = '=';
        $indexSpace = '';
        $back = '';

        // 计算
        $configNew = $this->calcConfigNew($configNew, $origin, $ceil);

        $res = "\n\n计算税后工资\n\n{$res}\n{$back}\n\n";

        \D::pd($configNew);

//        $d = [];
//        foreach ($configNew as $item) {
//
//            //\D::pd($item);
//
//            if ($item[0]) {
//
//                $item['method'] = str_replace('{ceil}', $item[0], $item['method']);
//                $item['result'] = eval('return '.$item['method'].';');
//                $d[$item[0]] = $item;
//
//            } else {
//                $d[0] = $item;
//                $item['result'] = 0;
//            }
//        }
//        $dList = implode("\n", array_keys($d));
//        $dList = "\n\n计税前工资输入\n{$dList}\n\n";
//
//
//        \D::pd($d);
//
//        // 根据税后工资计算税前工资
//
//
//        \D::log($dList . $res);

	}

	public function calcConfigNew($configNew, $origin, $ceil)
    {
        $indexSpace = '';
        foreach ($configNew as $index => $item) {

            // 变量
            $begin = $item[0];
            $end = $item[1];
            $rate = $item[2] / 100;
            $add = $item[3];

            $item['index_space'] = $indexSpace;

            // 显示计算公式
            if ($begin === 0) {
                // 第一行显示0
                $method_after = 0;
                $method = 0;
                $result_after = 0;
                $method_before = 0;
            } else {
                // 否则显示计算公式
                $method_after = "ROUND(({$ceil}-{$origin})*{$rate}-{$add},2)";

                // 计算税后结果
                $method= strtolower(str_replace($ceil, $item[0], $method_after));
                $result_after = eval('return '.$method.';');

                // 计算税前公式
                $method_before = "ROUND(({$ceil}-{$origin}*{$rate}-{$add})/(1-{$rate}),2)";
            }

            // 缩进
            $indexSpace = str_repeat('    ', $index+1);

            $item['method'] = $method;
            $item['result_after'] = $result_after;
            //$item['result_before'] = $result_before;
            $item['method_after'] = $method_after;
            $item['method_before'] = $method_before;

            $configNew[$index] = $item;
        }
        return $configNew;
    }

	public function d($configNew)
    {
        $res = '=';
        foreach ($configNew as $index => $item) {

            // 变量
            $begin = $item[0];
            $end = $item[1];
            $rate = $item[2] / 100;
            $add = $item[3];

            // 子串
            $res .= substr($indexSpace, 4)."IF(\n";

            // 比较条件
            if ($end !== null) {
                // 不是最后一行，比较范围
                $res .= "{$indexSpace}AND({$ceil}>{$begin},{$ceil}<={$end}),\n";
            } else {
                // 最后一行只比较开头
                $res .= "{$indexSpace}AND({$ceil}>{$begin}),\n";
            }

            // 显示计算公式
            if ($begin === 0) {
                // 第一行显示0
                $res .= "{$indexSpace}0,\n";
                $method = 0;
            } else {
                // 否则显示计算公式
                $res .= "{$indexSpace}ROUND(({$ceil}-{$origin})*{$rate}-{$add},2),\n";
                $method = "round(({ceil}-{$origin})*{$rate}-{$add},2)";
            }

            // 最后一行返回空字符串
            if ($end === null) {
                $res .= $indexSpace . '""';
            }

            // 缩进
            $indexSpace = str_repeat('    ', $index+1);

            // 括号
            $back .= ')';

            $item['method'] = $method;
            $configNew[$index] = $item;
        }

        return $res;
    }

    /**
     * 根据税前和其它信息计算税后.
     * @date 2019/01/14
     */
    public function actionNew()
    {
        // 某员工连续4个月的收入信息
        $data = [
            // 月薪	累计收入	累计免税收入	累计减除费用	累计专项扣除	累计专项附加扣除	累计依法确认的其他扣除  累计减免税额
            ['income'=>15000,'income_accum'=>15000,'duty_free_accum'=>0,'exclude_accum'=>5000,'special_accum'=>3000,'addition_accum'=>4000,'other_accum'=>200,'exclude_tax_accum'=>0],
            ['income'=>45000,'income_accum'=>60000,'duty_free_accum'=>0,'exclude_accum'=>10000,'special_accum'=>6000,'addition_accum'=>8000,'other_accum'=>400,'exclude_tax_accum'=>0],
            ['income'=>15000,'income_accum'=>75000,'duty_free_accum'=>0,'exclude_accum'=>15000,'special_accum'=>9000,'addition_accum'=>12000,'other_accum'=>600,'exclude_tax_accum'=>0],
            ['income'=>15000,'income_accum'=>90000,'duty_free_accum'=>0,'exclude_accum'=>20000,'special_accum'=>12000,'addition_accum'=>16000,'other_accum'=>800,'exclude_tax_accum'=>0],
        ];

        // 计算税费和税后
        $this->newCalcAfterList($data);

        // 猜测法计算税前
        $this->newCalcBeforeList($data);

        // 显示税后计算结果
        $this->newDisplayAfterList($data);

        // 显示猜测结果列表
        $this->newDisplayBeforeList($data);
    }

    /**
     * 猜测法计算税前
     * @param $data
     */
    public function newCalcBeforeList(&$data)
    {
        foreach ($data as &$row) {
            $row['after_guest_list'] = $this->newAfterGuestList($row);
        }
    }

    /**
     * 猜测税后列表.
     * @param $row
     * @return array
     * @bug
     */
    public function newAfterGuestList($row)
    {
        // 原来数据行的月薪和税后
        $incomeOld = $row['income'];
        $afterTaxOld = $row['after_tax'];
        $taxAccumOld = $row['tax_accum'];

        // 初始化：
        // 构造只有一行的数组
        // 收入和累计收入用已知税后做猜测税前
        $data = [$row];
        $data[0]['income_accum'] = $data[0]['income_accum'] - $incomeOld + $afterTaxOld;
        $data[0]['income'] = $afterTaxOld;

        // 猜测列表
        $guessList = [];

        while (1) {

            // 用猜测税前计算税后
            $this->newCalcAfterList($data);

            // 猜测税后和已知税后的差值
            $afterTaxDiff = $this->priceFormat($afterTaxOld - $data[0]['after_tax']);

            // 记录差值
            $data[0]['after_tax_diff'] = $afterTaxDiff;

            // 记录到猜测列表
            $guessList[] = $data[0];

            // 如果猜测税后和已知税后差值小于指定误差则不再猜测
            if ($afterTaxDiff < 0.000000001) {
                break;
            } else {
                //否则更新数据行继续猜测
                $incomeNewGuess = $data[0]['income'] + $afterTaxDiff; // 新的猜测税前等于上一次的猜测税前加上猜测税后的差值
                $data[0]['income_accum'] = $data[0]['income_accum'] - $data[0]['income'] + $incomeNewGuess; // 新的猜测税前累计收入
                $data[0]['income'] = $incomeNewGuess; // 新的猜测税前
                $data[0]['tax_accum'] = $taxAccumOld; // 累计已预扣预缴税额
            }
        }

        array_unshift($guessList, $row);
        $guessList[0]['after_tax_diff'] = '';

        return $guessList;
    }

    /**
     * 计算税费和税后.
     * @param $data
     */
    public function newCalcAfterList(&$data)
    {
        // 如果数据行不是员工第一个月的流水，那么累计已预扣预缴税额可能不是0，所以这里不能直接初始化为0
        // 同时因为员工第一个月的累计已预扣预缴税额一定会是0，所以如果数据行没有给定这个值，那就初始化为0，否则就用原来的
        // 因为$data[0]可能是员工第一个月或者其它月份的流水，而且如果是其它月份的流水的话，那么一定会初始化这个值，所以这样处理可行
        if (isset($data[0]['tax_accum'])) {
            $taxAccum = $data[0]['tax_accum'];
        } else {
            $taxAccum = 0;
        }

        foreach ($data as &$row) {

            // 累计已预扣预缴税额
            $row['tax_accum'] = $taxAccum;

            // 累计预扣预缴应纳税所得额
            $should = $this->newCalcShould($row);

            // 根据应纳税额获取税率
            $rateData = $this->newRateData($should);
            $rate = $rateData[0];
            $exclude = $rateData[1];

            // 计算当前月份的税费
            $tax = $this->newCalcTax($should, $rate, $exclude, $row['exclude_tax_accum'], $row['tax_accum']);

            // 累加税费
            $taxAccum = $this->priceFormat($taxAccum + $tax);

            $row['should'] = $should;
            $row['tax'] = $tax; // 税费
            $row['after_tax'] = $this->priceFormat($row['income'] - $tax); // 税后
            $row['rate'] = $rate; // 税率
            $row['exclude'] = $exclude; // 扣除数
        }
    }

    /**
     * 累计预扣预缴应纳税所得额.
     * @param $row
     * @return mixed
     */
    public function newCalcShould($row)
    {
        $should = $row['income_accum'] - $row['duty_free_accum'] - $row['exclude_accum'] - $row['special_accum'] - $row['addition_accum'] - $row['other_accum'];
        return $this->priceFormat($should);
    }

    /**
     * 计算一个月的税费.
     * @param $should
     * @param $rate
     * @param $exclude
     * @param $excludeTaxAccum
     * @param $taxAccum
     * @return int
     */
    public function newCalcTax($should, $rate, $exclude, $excludeTaxAccum, $taxAccum)
    {
        // 税率等于0表示不收税
        if ($rate == 0) {
            return 0;
        }

        // 根据税率计算税费
        $ratePrice = $should * $rate - $exclude;

        // 减去累计减免部分
        $tax = $ratePrice - $excludeTaxAccum - $taxAccum;

        return $this->priceFormat($tax);
    }

    /**
     * 根据累计预扣预缴应纳税所得额获取税率和扣除数.
     * @param $should
     * @return array
     */
    public function newRateData($should)
    {
        if ($should <= 0) {
            return [0, 0];
        } else if ($should <= 36000) {
            return [0.03, 0];
        } else if ($should <= 144000) {
            return [0.1, 2520];
        } else if ($should <= 300000) {
            return [0.2, 16920];
        } else if ($should <= 42000) {
            return [0.25, 31920];
        } else if ($should <= 66000) {
            return [0.3, 52920];
        } else if ($should <= 96000) {
            return [0.35, 85920];
        } else {
            return [0.45, 181920];
        }
    }

    public function newDisplayAfterList($data)
    {
        echo '<br/>';
        echo '<h2>某员工按月递增每个月税后自动计算结果</h2>';
        echo '<p>备注：<br/>这是每个月累计税前和其它信息自动计算的税后结果，因为全部变量都已确定，所以能够直接求出税后，计算过程简单.</p>';
        echo '<table style="width: 100%; margin-bottom:50px;">';
        echo '<tr>';
        echo '<th>月份</th>';
        echo '<th>月薪</th>';
        echo '<th>累计收入</th>';
        echo '<th>累计免税收入</th>';
        echo '<th>累计减除费用</th>';
        echo '<th>累计专项扣除</th>';
        echo '<th>累计专项附加扣除</th>';
        echo '<th>累计依法确认的其他扣除</th>';
        echo '<th>累计预扣预缴应纳税所得额</th>';
        echo '<th>预扣率</th>';
        echo '<th>速算扣除数</th>';
        echo '<th>累计减免税额</th>';
        echo '<th>累计已预扣预缴税额</th>';
        echo '<th>税费</th>';
        echo '<th>税后</th>';
        echo '</tr>';

        foreach ($data as $index => $row) {
            $row['month'] = $index + 1;
            $this->newDisplayAfterRow($row);
        }

        echo '</table>';
    }

    public function newDisplayAfterRow($row)
    {
        echo '<tr>';
        echo '<td>'.$row['month'].'</td>';
        echo '<td>'.$row['income'].'</td>';
        echo '<td>'.$row['income_accum'].'</td>';
        echo '<td>'.$row['duty_free_accum'].'</td>';
        echo '<td>'.$row['exclude_accum'].'</td>';
        echo '<td>'.$row['special_accum'].'</td>';
        echo '<td>'.$row['addition_accum'].'</td>';
        echo '<td>'.$row['other_accum'].'</td>';
        echo '<td>'.$row['should'].'</td>';
        echo '<td>'.$row['rate'].'</td>';
        echo '<td>'.$row['exclude'].'</td>';
        echo '<td>'.$row['exclude_tax_accum'].'</td>';
        echo '<td>'.$row['tax_accum'].'</td>';
        echo '<td>'.$row['tax'].'</td>';
        echo '<td>'.$row['after_tax'].'</td>';
        echo '</tr>';
    }

    public function newDisplayBeforeList($data)
    {
        echo '<h2>根据某员工某个月的税后和其它信息，猜测他当前月份的税前</h2>';
        echo '<p>备注：<br/>无法根据税后直接计算税前，但是可以用猜测法把计算过程当做黑盒来计算税前，这是猜测展示结果.这种猜测方法是可行的，理由是猜测得到的税后差值加上猜测税前总是会小于而且无限靠近待求税前.<br/>
可以是某员工的任何一个月份的税后（这个计算过程用来佐证猜测法的正确性以及娱乐），但是对应的其它累计信息必须是正确的，例如累计已预扣预缴税额，否则计算结果不正确.<br/>
同理，可以用来计算第一个月的税前（员工入职的时候要求税后薪资）.</p>';
        echo '<table style="width: 100%; margin-bottom:50px;">';
        echo '<tr>';
        echo '<th>编号</th>';
        echo '<th>月薪</th>';
        echo '<th>累计收入</th>';
        echo '<th>累计免税收入</th>';
        echo '<th>累计减除费用</th>';
        echo '<th>累计专项扣除</th>';
        echo '<th>累计专项附加扣除</th>';
        echo '<th>累计依法确认的其他扣除</th>';
        echo '<th>累计预扣预缴应纳税所得额</th>';
        echo '<th>预扣率</th>';
        echo '<th>速算扣除数</th>';
        echo '<th>累计减免税额</th>';
        echo '<th>累计已预扣预缴税额</th>';
        echo '<th>税费</th>';
        echo '<th>税后</th>';
        echo '<th>税后差值</th>'; // 猜测税后和已知税后的差值
        echo '</tr>';

        foreach ($data as $row) {
            foreach ($row['after_guest_list'] as $index => $item) {
                $item['index'] = $index;
                $this->newDisplayBeforeRow($item);
            }

            echo '<tr><td cols="'.count($item).'">&nbsp;</td></tr>';
        }

        echo '</table>';
    }

    public function newDisplayBeforeRow($row)
    {
        echo '<tr>';
        echo '<td>'.$row['index'].'</td>';
        echo '<td>'.$row['income'].'</td>';
        echo '<td>'.$row['income_accum'].'</td>';
        echo '<td>'.$row['duty_free_accum'].'</td>';
        echo '<td>'.$row['exclude_accum'].'</td>';
        echo '<td>'.$row['special_accum'].'</td>';
        echo '<td>'.$row['addition_accum'].'</td>';
        echo '<td>'.$row['other_accum'].'</td>';
        echo '<td>'.$row['should'].'</td>';
        echo '<td>'.$row['rate'].'</td>';
        echo '<td>'.$row['exclude'].'</td>';
        echo '<td>'.$row['exclude_tax_accum'].'</td>';
        echo '<td>'.$row['tax_accum'].'</td>';
        echo '<td>'.$row['tax'].'</td>';
        echo '<td>'.$row['after_tax'].'</td>';
        echo '<td>'.$row['after_tax_diff'].'</td>';
        echo '</tr>';
    }

    /**
     * 价格格式化.
     * @param $price
     * @return float
     * @notice 可以分别用四舍五入和非四舍五入两种情况来调试，看看计算过程的细微差别，有助于理解计算过程的精度和计算过程是否有限问题.
     * 调试的时候，可以配合修改猜测税后和已知税后的差值比较精度来分析.
     */
    public function priceFormat($price)
    {
        // 如果不四舍五入，会得到非常接近的小数，可以更精确地反映出猜测法逐步靠近目标结果的计算过程
        return $price;

        // 如果四舍五入保留两位小数，可以简化计算过程，往往能够得到合适的结果
        return round($price, 2);
    }
}
