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
}























