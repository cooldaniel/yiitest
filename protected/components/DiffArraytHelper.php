<?php

/**
 * ConverHelper
 * @package application.components
 */
class DiffArraytHelper
{
    const DIRECT_LEFT_RIGHT = 1;
    const DIRECT_RIGHT_LEFT = 2;

    const CHOICE_DIFF = 1;
    const CHOICE_INTERSECT = 2;
    const CHOICE_MERGE = 3;

    public static $directList = [
        self::DIRECT_LEFT_RIGHT => 'Array1 -> Array2',
        self::DIRECT_RIGHT_LEFT => 'Array2 -> Array1',
    ];

    public static $choiceList = [
        self::CHOICE_DIFF => 'Diff',
        self::CHOICE_INTERSECT => 'Intersect',
        self::CHOICE_MERGE => 'Merge',
    ];

    /**
     * Diff the given data base on the choice.
     *
     * @param $data
     * @return array
     * @throws Exception
     */
    public function run($data)
    {
        $array1 = trim($data['array1']);
        $array2 = trim($data['array2']);
        $direct = (int)$data['direct'];
        $choice = (int)$data['choice'];
        $sort = (int)$data['sort'];
        $sortByKey = (int)$data['sortbykey'];
        $sortByRecurse = (int)$data['sortbyrecurse'];
        $natsort = (int)$data['natsort'];

        $convertHelper = new ConvertHelper();

        // 转成数组
        $arrayData1 = $convertHelper->arrayToArrayData($array1);
        $arrayData2 = $convertHelper->arrayToArrayData($array2);

        // 处理
        switch ($choice)
        {
            case self::CHOICE_DIFF:
                $diffData = ($direct == self::DIRECT_LEFT_RIGHT) ? array_diff($arrayData1, $arrayData2) : array_diff($arrayData2, $arrayData1);
                break;
            case self::CHOICE_INTERSECT:
                $diffData = ($direct == self::DIRECT_LEFT_RIGHT) ? array_intersect($arrayData1, $arrayData2) : array_intersect($arrayData2, $arrayData1);
                break;
            case self::CHOICE_MERGE:
                $diffData = ($direct == self::DIRECT_LEFT_RIGHT) ? array_merge($arrayData1, $arrayData2) : array_merge($arrayData2, $arrayData1);
                $diffData = array_unique($diffData);
                break;
            default:
                throw new Exception('Choice is not supprted.');
        }

        // 排序
        if ($sort != ConvertHelper::SORT_NO)
        {
            if ($natsort)
            {
                // 自然排序
                natcasesort($arrayData1);
                natcasesort($arrayData2);
                natcasesort($diffData);
            }
            else
            {
                // 非自然排序
                $convertHelper->sort($arrayData1, $sort, $sortByKey, $sortByRecurse);
                $convertHelper->sort($arrayData2, $sort, $sortByKey, $sortByRecurse);
                $convertHelper->sort($diffData, $sort, $sortByKey, $sortByRecurse);
            }
        }

        return [
            'array1'=>$convertHelper->arrayDataToArray($arrayData1),
            'array2'=>$convertHelper->arrayDataToArray($arrayData2),
            'diff'=>$convertHelper->arrayDataToArray($diffData),
            'choice'=>$choice,
            'direct'=>$direct,
            'data_count'=>count($arrayData1) . ' / ' . count($arrayData2) . ' / ' . (count($arrayData1) - count($arrayData2)) . ' / ' . count($diffData),
            'sort'=>$sort,
            'sortbykey'=>$sortByKey,
            'sortbyrecurse'=>$sortByRecurse,
            'natsort'=>$natsort,
        ];
    }
}