<?php

/**
 * ConverHelper
 * @package application.components
 */
class ConvertHelper
{
    const CHOICE_JSON = 1;
    const CHOICE_ARRAY = 2;
    const CHOICE_LIKEARRAY = 3;
    const CHOICE_POSTMAN = 4;
    const CHOICE_LIST = 5;
    const CHOICE_LISTSPACE = 6;

    /**
     * 排序方向.
     */
    const SORT_ASC = 1;
    const SORT_DESC = 2;
    const SORT_NO = 3;

    public static $sortList = [
        self::SORT_ASC => 'Asc',
        self::SORT_DESC => 'Desc',
        self::SORT_NO => 'No',
    ];

    /**
     * Conver the given data base on the choice.
     *
     * Always convert the given string to the array data to keep the converting process simple.
     *
     * @param $data
     * @return array
     * @throws Exception
     */
    public function run($data)
    {
        // 输入各种格式数据
        $json = trim($data['json']);
        $array = trim($data['array']);
        $likearray = trim($data['likearray']);
        $postman = trim($data['postman']);
        $list = trim($data['list']);
        $listspace = trim($data['listspace']);

        // 选用哪一个输入数据做转换
        $choice = (int)$data['choice'];

        // 排序选项
        $sort = (int)$data['sort'];
        $sortByAssoc = (int)$data['sortByAssoc'];
        $sortByKey = (int)$data['sortByKey'];
        $sortByRecurse = (int)$data['sortByRecurse'];

        // 统一转成数组
        switch ($choice) {
            case self::CHOICE_JSON:

                $array_data = $this->jsonToArrayData($json);
                $json       = $this->arrayDataToJson($array_data); // 美化json数据，但是不改变输入排序
                $this->sort($array_data, $sort, $sortByAssoc, $sortByKey, $sortByRecurse);

                $input      = $this->arrayDataToJson($array_data);
                $array      = $this->arrayDataToArray($array_data);
                $likearray  = $this->arrayDataToLikearray($array_data);
                $postman    = $this->arrayDataToPostman($array_data);
                $list       = $this->arrayDataToList($array_data);
                $listspace  = $this->arrayDataToListSpace($array_data);

                break;
            case self::CHOICE_ARRAY:

                $array_data = $this->arrayToArrayData($array);
                $this->sort($array_data, $sort, $sortByAssoc, $sortByKey, $sortByRecurse);

                $input      = $this->arrayDataToArray($array_data);
                $json       = $this->arrayDataToJson($array_data);
                $likearray  = $this->arrayDataToLikearray($array_data);
                $postman    = $this->arrayDataToPostman($array_data);
                $list       = $this->arrayDataToList($array_data);
                $listspace  = $this->arrayDataToListSpace($array_data);

                break;
            case self::CHOICE_LIKEARRAY:

                $array_data = $this->likearrayToArrayData($likearray);
                $this->sort($array_data, $sort, $sortByAssoc, $sortByKey, $sortByRecurse);

                $input      = $this->arrayDataToLikearray($array_data);
                $json       = $this->arrayDataToJson($array_data);
                $array      = $this->arrayDataToArray($array_data);
                $postman    = $this->arrayDataToPostman($array_data);
                $list       = $this->arrayDataToList($array_data);
                $listspace  = $this->arrayDataToListSpace($array_data);

                break;
            case self::CHOICE_POSTMAN:

                $array_data = $this->postmanToArrayData($postman);
                $this->sort($array_data, $sort, $sortByAssoc, $sortByKey, $sortByRecurse);

                $input      = $this->arrayDataToPostman($array_data);
                $json       = $this->arrayDataToJson($array_data);
                $array      = $this->arrayDataToArray($array_data);
                $likearray  = $this->arrayDataToLikearray($array_data);
                $list       = $this->arrayDataToList($array_data);
                $listspace  = $this->arrayDataToListSpace($array_data);

                break;
            case self::CHOICE_LIST:

                $array_data = $this->listToArrayData($list);
                $this->sort($array_data, $sort, $sortByAssoc, $sortByKey, $sortByRecurse);

                $input      = $this->arrayDataToList($array_data);
                $json       = $this->arrayDataToJson($array_data);
                $array      = $this->arrayDataToArray($array_data);
                $likearray  = $this->arrayDataToLikearray($array_data);
                $postman    = $this->arrayDataToPostman($array_data);
                $listspace  = $this->arrayDataToListSpace($array_data);

                break;
            case self::CHOICE_LISTSPACE:

                $array_data = $this->listspaceToArrayData($listspace);
                $this->sort($array_data, $sort, $sortByAssoc, $sortByKey, $sortByRecurse);

                $input      = $this->arrayDataToListSpace($array_data);
                $json       = $this->arrayDataToJson($array_data);
                $array      = $this->arrayDataToArray($array_data);
                $likearray  = $this->arrayDataToLikearray($array_data);
                $postman    = $this->arrayDataToPostman($array_data);
                $list       = $this->arrayDataToList($array_data);

                break;
            default:
                throw new Exception('Choice is not supprted.');
        }

        $jsonencode = json_encode(json_decode($json));

        return [
            'input'=>$input,
            'json'=>$json,
            'jsonencode'=>$jsonencode,
            'array'=>$array,
            'likearray'=>$likearray,
            'postman'=>$postman,
            'list'=>$list,
            'listspace'=>$listspace,
            'choice'=>$choice,
            'sort'=>$sort,
            'sortByAssoc'=>$sortByAssoc,
            'sortByKey'=>$sortByKey,
            'sortByRecurse'=>$sortByRecurse,
            'dataCount'=>count($array_data),
        ];
    }

    /**
     * Sort the array.
     * @param $array
     * @param $sort
     * @param $sortByAssoc
     * @param $sortByKey
     * @param $sortByRecurse
     */
    public function sort(&$array, $sort, $sortByAssoc, $sortByKey, $sortByRecurse)
    {
        if ($sort)
        {
            \D::sort($array, $sort, $sortByAssoc, $sortByKey, $sortByRecurse);
        }
    }

    /**
     * Convert a json string to an array.
     * @param string $string
     * @return array
     */
    public function jsonToArrayData($string)
    {
        return json_decode($string, true);
    }

    /**
     * Convert an array string to an array.
     * @param string $string
     * @return array
     */
    public function arrayToArrayData($string)
    {
        return \D::eval($string);
    }

    /**
     * Convert a likearray string to an array.
     * @param string $string
     * @return array
     */
    public function likearrayToArrayData($string)
    {
        $data = [];
        \D::unlikearray($string, $data);
        return $data;
    }

    /**
     * Convert a postman string to an array.
     * @param string $string
     * @return array
     */
    public function postmanToArrayData($string)
    {
        $data = [];
        \D::unpostman($string, $data);
        return $data;
    }

    /**
     * Convert a list string to an array.
     * @param string $string
     * @return array
     */
    public function listToArrayData($string)
    {
        $data = explode("\n", $string);

        foreach ($data as &$item)
        {
            $item = trim($item);
        }

        return $data;
    }

    /**
     * Convert a listspace string to an array.
     * @param string $string
     * @return array
     */
    public function listspaceToArrayData($string)
    {
        $res = [];

        $data = explode("\n", $string);

        foreach ($data as $item)
        {
            $item = trim($item);

            // 跳过空行
            if ($item == '')
            {
                continue;
            }

            $parts = preg_split('/\s+/', $item);

            $index = trim($parts[0]);
            $value = isset($parts[1]) ? trim($parts[1]) : '';

            $res[$index] = $value;
        }
        return $res;
    }

    /**
     * Convert an array to a json string.
     * @param array $array_data
     * @return string
     */
    public function arrayDataToJson($array_data)
    {
        return json_encode($array_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Convert an array to an array string.
     * @param array $array_data
     * @return string
     */
    public function arrayDataToArray($array_data)
    {
        $res = CVarDumper::dumpAsString($array_data);
        $res = substr($res, 6);
        $res = substr($res, 0, -3);
        $res = '[' . $res . '];';
        return $res;
    }

    /**
     * Convert an array to a likearray string.
     * @param array $array_data
     * @return string
     */
    public function arrayDataToLikearray($array_data)
    {
        $res = '';
        \D::likearray($array_data, $res);
        return $res;
    }

    /**
     * Convert an array to a postman string.
     * @param array $array_data
     * @return string
     */
    public function arrayDataToPostman($array_data)
    {
        $res = '';
        \D::postman($array_data, $res);
        return $res;
    }

    /**
     * Convert an array to a list string.
     * @param array $array_data
     * @return string
     */
    public function arrayDataToList($array_data)
    {
        $data = [];
        foreach ($array_data as $index => $item)
        {
            if (!is_array($item))
            {
                $data[$index] = $item;
            }
        }
        return implode("\n", $data);
    }

    /**
     * Convert an array to a listspace string.
     * @param array $array_data
     * @return string
     */
    public function arrayDataToListSpace($array_data)
    {
        $data = [];
        foreach ($array_data as $index => $item)
        {
            if (!is_array($item))
            {
                $data[$index] = $item;
            }
        }

        $res = '';
        foreach ($data as $index => $item)
        {
            $res .= $index . ' '. $item . "\n";
        }
        return $res;
    }
}